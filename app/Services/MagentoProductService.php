<?php

namespace App\Services;

use App\Models\Product; // Assurez-vous que cette table locale est correctement configurée.
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use JustBetter\MagentoClient\Query\SearchCriteria;
use JustBetter\MagentoClient\Client\Magento;

class MagentoProductService
{
    protected Magento $magento;

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
     */
    public function syncProducts(): array
    {
        // Construire les critères de recherche pour les produits actifs
        $searchCriteria = SearchCriteria::make()
            ->where('status', '1')                 // Produits actifs
	        ->where('visibility', 'neq', '1') // Produits visibles
            //->where('sku', 'eq', 'AMP00AC-ACUSAC098')
            ->orderBy('created_at', 'desc')
            ->paginate(1, 100)
            ->get();


        try {
            // Appel à l'API pour récupérer les produits
            $response = $this->magento->get('products', $searchCriteria);

            // Gestion des erreurs d'API
            if ($response->failed()) {
                Log::error('Magento API Error for Products', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                throw new \Exception('Magento request failed with status ' . $response->status());
            }

            Log::info('Magento Products Response', ['items' => count($response['items'] ?? [])]);

            // Parcourir les produits
	        $products = [];

	        foreach ($response['items'] as $productData) {
		        $products[] = $productData; // Ou $this->mapProductData($productData) si tu veux un format allégé
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
