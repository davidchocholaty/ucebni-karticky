<?php

/**********************************************************/
/*                                                        */
/* File: 2014_10_12_000000_create_users_table.php         */
/* Author: David Chocholaty <xbartu11@stud.fit.vutbr.cz>  */
/* Project: Project for the course ITU                    */
/* Description: The migration for creating the users      */
/*              table.                                    */
/*                                                        */
/**********************************************************/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The migration for creating the users table.
 */
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('degree_front')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('degree_after')->nullable();
            $table->string('school')->nullable();
            $table->string('photo')->default('images/default-user.svg');
            $table->enum('account_type', ['admin', 'teacher', 'student']);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
