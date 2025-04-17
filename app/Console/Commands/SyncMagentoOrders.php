<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MagentoProductService;

class SyncMagentoProducts extends Command
{
    /**
     * Signature de la commande Artisan.
     */
    protected $signature = 'magento:sync-products';

    /**
     * Description de la commande Artisan.
     */
    protected $description = 'Synchronise les produits depuis Magento vers la base locale';

    /**
     * Constructeur.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Exécute la commande pour synchroniser les produits.
     *
     * @param MagentoProductService $magentoProductService
     * @return int
     */
    public function handle(MagentoProductService $magentoProductService): int
    {
        $this->info('Récupération des produits en cours depuis Magento...');

        try {
            $magentoProductService->syncProducts();
            $this->info('Synchronisation des produits terminée avec succès !');
        } catch (\Exception $e) {
            $this->error("Erreur lors de la synchronisation : {$e->getMessage()}");
            return 1; // Code de sortie en cas d'échec
        }

        return 0; // Code de sortie en cas de succès
    }
}
