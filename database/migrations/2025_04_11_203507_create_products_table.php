<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

  public function up()
{
    Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('slug')->unique();
    $table->integer('stock')->default(0);
    $table->decimal('price', 10, 2);
    $table->decimal('actual_price', 10, 2)->nullable();
    $table->decimal('discount', 5, 2)->default(0);
    $table->string('size')->nullable();
    $table->string('color')->nullable();
    $table->text('description')->nullable();
    $table->boolean('status')->default(true);
    $table->boolean('visibility')->default(true);
    $table->unsignedBigInteger('category_id')->nullable();
    $table->string('brand')->nullable();
    $table->string('product_code')->nullable();
    $table->string('product_image')->nullable();
    $table->timestamps();
});

}

  public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
