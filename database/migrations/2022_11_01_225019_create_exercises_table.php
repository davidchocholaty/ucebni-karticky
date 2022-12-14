<?php

/**********************************************************/
/*                                                        */
/* File: 2022_11_01_225019_create_exercises_table.php     */
/* Author: David Chocholaty <xbartu11@stud.fit.vutbr.cz>  */
/* Project: Project for the course ITU                    */
/* Description: The migration for creating the exercises  */
/*              table.                                    */
/*                                                        */
/**********************************************************/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The migration for creating the exercises table.
 */
class CreateExercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('topic')->nullable();
            $table->enum('visibility', ['private', 'public']);
            $table->boolean('show_timer')->default(true);
            $table->timestamps();

            $table->foreign('author')
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
        Schema::dropIfExists('exercises');
    }
}
