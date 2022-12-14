<?php

/**********************************************************/
/*                                                        */
/* File: 2022_11_16_104422_create_attempts_table.php      */
/* Author: David Chocholaty <xbartu11@stud.fit.vutbr.cz>  */
/* Project: Project for the course ITU                    */
/* Description: The migration for creating the attempts   */
/*              table.                                    */
/*                                                        */
/**********************************************************/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The migration for creating the attempts table.
 */
class CreateAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attempts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exercise_id');
            $table->unsignedBigInteger('user_id');
            $table->time('spend_time');
            $table->unsignedInteger('correct_answers_number');
            $table->unsignedInteger('wrong_answers_number');
            $table->timestamps();

            $table->foreign('exercise_id')
                ->references('id')
                ->on('exercises')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attempts');
    }
}
