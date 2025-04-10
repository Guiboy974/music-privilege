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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name_product');
            $table->string('sku');
            $table->string('categorie');
            $table->foreignId('categorie_ids')->unique();
            $table->string('description')->nullable();
            $table->string('short_description')->nullable();
            $table->integer('weight');
            $table->boolean('product_online');
            $table->integer('tax_class_name');
            $table->string('visibility')->nullable();
            $table->decimal('price');
            $table->decimal('special_price')->nullable();
            $table->decimal('special_price_to_date')->nullable();
            $table->string('url_key');
            $table->string('base_image');
            $table->integer('qty');
            $table->integer('out_of_stock_qty');
            $table->integer('max_cart_qty');
            $table->boolean('is_in_stock');
            $table->integer('manage_stock');
            $table->string('additional_image')->nullable();
            $table->string('available')->nullable();
            $table->string('code_famille');
            $table->decimal('cost');
            $table->string('ean')->nullable();
            $table->string('enattente')->nullable();
            $table->integer('encommande')->nullable();
            $table->integer('garantie')->nullable();
            $table->string('is_solde')->nullable();
            $table->string('manufacturer');
            $table->boolean('occasion');
            $table->decimal('prix_public');
            $table->string('real_sku');
            $table->string('plus_produit')->nullable();
            $table->decimal('eco')->nullable();
            $table->string('caracteristique')->nullable();
            $table->string('instruments')->nullable();
            $table->string('avis_profdeux')->nullable();
            $table->string('ean_code')->nullable();
            $table->decimal('ecotaxe')->nullable();
            $table->string('frequence')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
