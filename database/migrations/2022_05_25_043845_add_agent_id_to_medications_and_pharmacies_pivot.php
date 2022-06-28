<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgentIdToMedicationsAndPharmaciesPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medication_pharmacies', function (Blueprint $table) {
            $table->unsignedBigInteger('agent_id')->nullable()->after('medication_id');
            $table->string('agent_name')->nullable()->after('medication_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medication_pharmacies', function (Blueprint $table) {
            $table->dropColumn('agent_id');
            $table->dropColumn('agent_name');
        });
    }
}
