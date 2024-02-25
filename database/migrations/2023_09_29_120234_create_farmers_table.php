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
        Schema::create('farmers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')
                ->unique();
            $table->string('password');

            $table->string('profile_photo_path', 2048)->nullable();

            $table->rememberToken();

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();
            $table->dateTime('last_login_at')
                ->nullable()
                ->default(null);

            $table->dateTime('email_verified_at')
                ->nullable()
                ->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farmers');
    }
};
