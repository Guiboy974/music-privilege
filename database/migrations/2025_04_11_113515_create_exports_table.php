<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exports', function (Blueprint $table) {
            $table->id();
            $table->string('name_marketplace');
            $table->string('name_export')->nullable();
            $table->string('name')->nullable();
            $table->string('entete')->nullable();
            $table->string('sku')->nullable();
            $table->string('categorie')->nullable();
            $table->foreignId('categorie_ids')->nullable();
            $table->string('description')->nullable();
            $table->string('short_description')->nullable();
            $table->integer('weight')->nullable();
            $table->boolean('product_online')->nullable();
            $table->integer('tax_class_name')->nullable();
            $table->string('visibility')->nullable();
            $table->decimal('price')->nullable();
            $table->decimal('special_price')->nullable();
            $table->decimal('special_price_to_date')->nullable();
            $table->string('url_key')->nullable();
            $table->string('base_image')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('out_of_stock_qty')->nullable();
            $table->integer('max_cart_qty')->nullable();
            $table->boolean('is_in_stock')->nullable();
            $table->integer('manage_stock')->nullable();
            $table->string('additional_image')->nullable();
            $table->string('available')->nullable();
            $table->string('code_famille')->nullable();
            $table->decimal('cost')->nullable();
            $table->string('ean')->nullable();
            $table->string('enattente')->nullable();
            $table->integer('encommande')->nullable();
            $table->integer('garantie')->nullable();
            $table->string('is_solde')->nullable();
            $table->string('manufacturer')->nullable();
            $table->boolean('occasion')->default(false)->nullable();
            $table->decimal('prix_public')->nullable();
            $table->string('real_sku')->nullable();
            $table->string('plus_produit')->nullable();
            $table->decimal('eco')->nullable();
            $table->string('caracteristique')->nullable();
            $table->string('instruments')->nullable();
            $table->string('avis_profdeux')->nullable();
            $table->string('ean_code')->nullable();
            $table->decimal('ecotaxe')->nullable();
            $table->string('frequence')->nullable();
            $table->boolean('is_active')->default(true)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exports');
    }
};
