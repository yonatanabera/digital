<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgentToDiagnostics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('diagnostics', function (Blueprint $table) {
            $table->unsignedBigInteger('agent_id')->nullable()->after('type');
            $table->string('agent_name')->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('diagnostics', function (Blueprint $table) {
            $table->dropColumn('agent_id');
            $table->dropColumn('agent_name');
        });
    }
}
