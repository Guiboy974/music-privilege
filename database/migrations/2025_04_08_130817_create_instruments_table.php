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
        Schema::create('instruments', function (Blueprint $table) {
            $table->id();
            $table->string('sku');
            $table->string('categorie');
            $table->foreignId('categorie_ids')->unique();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('short_description')->nullable();
            $table->integer('weight');
            $table->boolean('product_online')->default(true);
            $table->integer('tax_class_name');
            $table->string('visibility')->nullable();
            $table->decimal('price', 8, 2);
            $table->decimal('special_price', 8, 2)->nullable();
            $table->decimal('special_price_to_date', 8, 2)->nullable();
            $table->string('url_key');
            $table->string('base_image');
            $table->integer('qty');
            $table->integer('out_of_stock_qty');
            $table->integer('max_cart_qty');
            $table->boolean('is_in_stock')->default(false);
            $table->integer('manage_stock');
            $table->string('additional_image')->nullable();
            $table->string('available')->nullable();
            $table->string('code_famille');
            $table->decimal('cost', 8, 2);
            $table->string('ean')->nullable();
            $table->string('enattente')->nullable();
            $table->integer('encommande')->nullable();
            $table->integer('garantie')->nullable();
            $table->string('is_solde')->nullable();
            $table->string('manufacturer');
            $table->boolean('occasion')->default(false);
            $table->decimal('prix_public', 8, 2);
            $table->string('real_sku');
            $table->string('plus_produit')->nullable();
            $table->decimal('eco', 3, 2)->nullable();
            $table->string('caracteristique')->nullable();
            $table->string('instruments')->nullable();
            $table->string('avis_profdeux')->nullable();
            $table->string('ean_code')->nullable();
            $table->decimal('ecotaxe', 3, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instruments');
    }
};
