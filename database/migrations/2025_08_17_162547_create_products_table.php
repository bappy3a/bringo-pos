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
            $table->foreignId('business_id')->constrained('businesses')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('unit_id')->constrained('units')->cascadeOnDelete();
            $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete();
            $table->enum('type',['single','variable','modifier','combo'])->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('sku')->nullable();
            $table->string('barcode_type')->nullable();
            $table->string('barcode')->nullable();
            $table->integer('alert_quantity')->default(0);
            $table->string('images')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('not_for_selling')->default(false);
            $table->enum('selling_price_tax_type',['inclusive','exclusive'])->default('inclusive');
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
