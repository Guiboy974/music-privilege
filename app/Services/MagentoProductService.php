<?php

namespace App\Services;

use App\Models\Product; // Assurez-vous que cette table locale est correctement configurée.
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use JustBetter\MagentoClient\Query\SearchCriteria;
use JustBetter\MagentoClient\Client\Magento;

class MagentoProductService
{
    protected Magento $magento;
    protected array $pricesCache = [];

    public function __construct(Magento $magento)
    {
        // Configurer les headers ou autres options si nécessaire
        $magento->intercept(function (\Illuminate\Http\Client\PendingRequest $request) {
            $request->withHeaders([
                'User-Agent' => 'MagentoClient/1.0',
                'Accept' => 'application/json',
            ]);
        });

        $this->magento = $magento;
    }

    /**
     * Synchronise les produits du catalogue Magento vers la base locale.
     * Renvoie un tableau de produits avec leurs catégories et chemins complets.
     */
    public function syncProducts(): array
    {
        $searchCriteria = SearchCriteria::make()
            ->where('status', '1')
            ->where('visibility', 'neq', '1')
            ->orderBy('created_at', 'desc')
            ->paginate(1, 6000)
            ->get();

        try {
            $response = $this->magento->get('products', $searchCriteria);

            if ($response->failed()) {
                Log::error('Magento API Error for Products', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                throw new \Exception('Magento request failed with status ' . $response->status());
            }

            Log::info('Magento Products Response', ['items' => count($response['items'] ?? [])]);

            // Récupération et mapping des catégories avec leur nom + chemin
            $flatCategories = $this->flattenCategories(
                $this->magento->get('categories')['children_data'] ?? []
            );

            $categoryMap = collect($flatCategories)->keyBy(fn($cat) => (string) $cat['id']);

            $products = [];

            foreach ($response['items'] as $productData) {

                // ➤ Récupérer les category_ids (priorité : extension_attributes > custom_attributes)
                $categoryIds = collect($productData['extension_attributes']['category_links'] ?? [])
                    ->pluck('category_id');

                if ($categoryIds->isEmpty()) {
                    $categoryIds = collect($productData['custom_attributes'] ?? [])
                        ->firstWhere('attribute_code', 'category_ids')['value'] ?? [];
                    $categoryIds = collect($categoryIds);
                }

                $categoryIds = $categoryIds->map(fn($id) => (string) $id)->toArray();

                // ➤ Catégories (noms simples)
                $productData['categories'] = collect($categoryIds)
                    ->map(fn($id) => $categoryMap[$id]['name'] ?? 'Inconnue')
                    ->unique()
                    ->implode(', ');

                // ➤ Chemins complets
                $productData['category_ids'] = collect($categoryIds)
                    ->map(function ($id) use ($categoryMap) {
                        return $categoryMap[$id]['path'] ?? null;
                    })
                    ->filter()
                    ->unique()
                    ->implode(' > ');

                $products[] = $productData;
            }

            return $products;

        } catch (\Exception $exception) {
            Log::error('Erreur lors de la synchronisation des produits Magento', [
                'message' => $exception->getMessage(),
            ]);
            throw $exception;
        }
    }

    /**
     * Aplati récursivement les catégories pour obtenir un tableau plat avec le chemin complet.
     *
     * @param array $categories
     * @param array $flat
     * @param array $parentPath
     * @return array
     */
    protected function flattenCategories(array $categories, array &$flat = [], array $parentPath = []): array
    {
        foreach ($categories as $cat) {
            $currentPath   = array_merge($parentPath, [$cat['name'] ?? '']);
            $flat[] = [
                'id'   => $cat['id'],
                'name' => $cat['name'] ?? 'Inconnue',
                'path' => $currentPath,
            ];

            if (!empty($cat['children_data'])) {
                $this->flattenCategories($cat['children_data'], $flat, $currentPath);
            }
        }

        return $flat;
    }

    /**
     * Précharge les prix en mémoire à partir d’un tableau de produits.
     */
    public function preloadPricesFromProducts(array $products): void
    {
        foreach ($products as $p) {
            if (!empty($p['sku']) && isset($p['price'])) {
                $this->pricesCache[$p['sku']] = (float) $p['price'];
            }
        }

        Log::info('Magento prices preloaded', ['count' => count($this->pricesCache)]);
    }

    public function getCachedPrice(string $sku): ?float
    {
        return $this->pricesCache[$sku] ?? null;
    }

    /**
     * Mapper les données du produit Magento avec votre modèle local.
     */
    public function mapProductData(array $productData): array
    {
        $extensionAttributes = $productData['extension_attributes'] ?? [];
	    // Mapper les custom_attributes en un tableau associatif
	    $customAttributes = collect($productData['custom_attributes'] ?? [])
		    ->keyBy('attribute_code'); // Crée un tableau où les clés sont les 'attribute_code'

	    return [
		    'sku' => $productData['sku'] ?? null,
		    'name' => $productData['name'] ?? null,
		    'price' => $productData['price'] ?? null,
		    'status' => $productData['status'] ?? null,
		    'visibility' => $productData['visibility'] ?? null,
		    'created_at' => $productData['created_at'] ?? now(),
		    'updated_at' => $productData['updated_at'] ?? now(),
		    'special_price' => $extensionAttributes['special_price'] ?? null,
		    'description' => $customAttributes['description']['value'] ?? null, // Accès sécurisé
		    'short_description' => $customAttributes['short_description']['value'] ?? null,
		    'weight' => $productData['weight'] ?? null,

	    ];
    }
}
