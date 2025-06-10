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
            // Passage des flags de boolean à text() pour le chiffrement
            $table->text('visible_trombinoscope')
                  ->nullable()
                  ->after('statut');

            $table->text('visible_annuaire')
                  ->nullable()
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
