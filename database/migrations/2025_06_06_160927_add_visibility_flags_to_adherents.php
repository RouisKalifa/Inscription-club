<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVisibilityFlagsToAdherents extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('adherents', function (Blueprint $table) {
            // Ajoute deux colonnes booléennes après “statut”
            $table->boolean('visible_trombinoscope')
                  ->default(true)
                  ->after('statut');
            $table->boolean('visible_annuaire')
                  ->default(true)
                  ->after('visible_trombinoscope');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('adherents', function (Blueprint $table) {
            $table->dropColumn(['visible_trombinoscope', 'visible_annuaire']);
        });
    }
}
