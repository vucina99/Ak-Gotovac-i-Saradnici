<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('__cases', function (Blueprint $table) {
            $table->id();
            $table->string('number_office')->nullable();
            $table->string('number_institution')->nullable();
            $table->string('prosecutor')->nullable();
            $table->string('defendants')->nullable();
            $table->integer('institution_id')->nullable();
            $table->longText('note')->nullable();
            $table->string('mark')->nullable();
            $table->date('fail_day')->nullable();
            $table->integer('case_type_id')->nullable();
            $table->string('archive')->nullable();

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
        Schema::dropIfExists('__cases');
    }
}
