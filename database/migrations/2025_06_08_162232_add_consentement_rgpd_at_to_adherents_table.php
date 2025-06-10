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
        Schema::table('adherents', function (Blueprint $table) {
            // Passage de consentement_rgpd_at de timestamp à text() pour le chiffrement
            $table->text('consentement_rgpd_at')
                  ->nullable()
                  ->after('est_archive')
                  ->comment('Horodatage du consentement RGPD');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adherents', function (Blueprint $table) {
            $table->dropColumn('consentement_rgpd_at');
        });
    }
};
