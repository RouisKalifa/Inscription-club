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
        Schema::create('adherents', function (Blueprint $table) {
            $table->id();

            // Clé étrangère vers users
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');

            // Tous ces champs deviennent TEXT pour stocker le JSON chiffré
            $table->text('prenom');
            $table->text('nom');
            $table->text('date_naissance')->nullable();
            $table->text('adresse')->nullable();
            $table->text('ville')->nullable();
            $table->text('code_postal')->nullable();
            $table->text('telephone')->nullable();
            $table->text('statut')->nullable();
            $table->text('photo_path')->nullable();
            $table->text('date_certificat')->nullable();
            $table->text('est_archive')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adherents');
    }
};
