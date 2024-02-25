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
        Schema::create('payment_records', function (Blueprint $table) {
            $table->id();
            $table->string('code')
                ->unique();
            $table->foreignId('user_id');
            // $table->foreignId('cart_id');
            $table->string('provider');
            $table->string('currency');
            $table->decimal('amount', 10, 2);
            $table->string('status');
            $table->longText('details');
            $table->boolean('transferred_to_wallet')
                ->default(false);
            $table->longText('initiate_response');
            $table->longText('redirect_response');
            $table->longText('validate_response');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_records');
    }
};
