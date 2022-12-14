<?php

/**********************************************************/
/*                                                        */
/* File: 2022_11_15_220906_create_groups_table.php        */
/* Author: David Chocholaty <xbartu11@stud.fit.vutbr.cz>  */
/* Project: Project for the course ITU                    */
/* Description: The migration for creating the groups     */
/*              table.                                    */
/*                                                        */
/**********************************************************/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The migration for creating the groups table.
 */
class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('photo')->default('images/default-group.svg');
            $table->enum('type', ['teachers', 'students']);
            $table->enum('visibility', ['private', 'public']);
            $table->timestamps();

            $table->foreign('owner')
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
        Schema::dropIfExists('groups');
    }
}
