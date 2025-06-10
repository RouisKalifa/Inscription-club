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
        Schema::table('adherents', function (Blueprint $t) {
            // Passage de date_cotisation de date() à text() pour le chiffrement
            $t->text('date_cotisation')
              ->nullable()
              ->after('date_certificat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adherents', function (Blueprint $t) {
            $t->dropColumn('date_cotisation');
        });
    }
};
