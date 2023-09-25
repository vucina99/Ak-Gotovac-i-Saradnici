<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('__trials', function (Blueprint $table) {
            $table->id();
            $table->string('number_office')->nullable();
            $table->string('number_institution')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('prosecutor')->nullable();
            $table->string('defendants')->nullable();
            $table->integer('institution_id')->nullable();
            $table->longText('note')->nullable();
            $table->date('date')->nullable();
            $table->string('archive')->nullable();

            $table->string('time')->nullable();
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
        Schema::dropIfExists('__trials');
    }
}
