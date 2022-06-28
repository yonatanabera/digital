<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertismentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisments', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->tinyInteger('ad_type');
            $table->integer('priority');
            $table->string('photo');
            $table->text('caption')->nullable();
            $table->string('web_link')->nullable();
            $table->string('email_link')->nullable();
            $table->string('phone_link')->nullable();
            $table->date('upload_date');
            $table->date('down_date');
            $table->tinyInteger('is_active')->default(1);
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
        Schema::dropIfExists('advertisments');
    }
}
