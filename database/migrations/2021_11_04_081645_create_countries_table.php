<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('continent')->nullable();
            $table->string('region')->nullable();
            $table->double('surface_area')->nullable();
            $table->string('indep_year')->nullable();
            $table->double('population')->nullable();
            $table->double('life_expectancy')->nullable();
            $table->double('gnp')->nullable();
            $table->double('gnp_old')->nullable();
            $table->string('local_name')->nullable();
            $table->string('government_form')->nullable();
            $table->string('head_of_state')->nullable();
            $table->double('capital')->nullable();
            $table->string('code2')->nullable();

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
        Schema::dropIfExists('countries');
    }
}
