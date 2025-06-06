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

            // Si chaque adhérent est lié à un compte utilisateur (login), on met une FK vers users
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');

            // Informations personnelles de l’adhérent
            $table->string('prenom');
            $table->string('nom');
            $table->date('date_naissance')->nullable();
            $table->string('adresse')->nullable();
            $table->string('ville')->nullable();
            $table->string('code_postal', 10)->nullable();
            $table->string('telephone')->nullable();

            // Statut dans le club (ex. président, coach, adhérent ordinaire…)
            $table->string('statut')->default('adhérent');

            // Chemin vers la photo du trombinoscope
            $table->string('photo_path')->nullable();

            // Date d’expiration du certificat médical
            $table->date('date_certificat')->nullable();

            // Archivage : si l’adhérent n’est plus actif, on met TRUE
            $table->boolean('est_archive')->default(false);

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
