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

            $table->foreignId('category_id');

            $table->string('name');
            $table->longText('description');

            $table->double('unit_price');
            $table->string('currency');

            $table->double('available_quantity');
            $table->foreignId('unit_id');

            $table->unsignedBigInteger('cover_image_id')
                ->nullable()
                ->default(null);

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
