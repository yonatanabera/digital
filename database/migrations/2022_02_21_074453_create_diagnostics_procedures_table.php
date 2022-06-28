<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosticsProceduresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnostics_procedures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('diagnostics_id')->constrained('diagnostics');
            $table->unsignedBigInteger('procedures_id')->constrained('procedures');
            $table->json('schedule');
            $table->text('description')->nullable();
            $table->foreign('diagnostics_id')->references('id')->on('diagnostics')->onDelete('cascade');
            $table->foreign('procedures_id')->references('id')->on('procedures')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diagnostics_procedures');
    }
}
