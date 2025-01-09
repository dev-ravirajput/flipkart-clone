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
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('subcategory_id');
            $table->string('name');
            $table->text('slug');
            $table->boolean('status')->default(0);
            $table->integer('price')->default(0);
            $table->integer('discount_percentage')->nullable();
            $table->integer('discount_price')->nullable();
            $table->text('description')->nullable();
            $table->string('featured_image')->nullable();
            $table->text('gallery_images')->nullable();
            $table->timestamps();
    
            // Add foreign key constraints
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('cascade');
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
