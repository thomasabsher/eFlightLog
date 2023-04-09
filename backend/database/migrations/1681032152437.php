<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Migration1681032152437 extends Migration
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
                    $table->unsignedBigInteger('created_by_user')->nullable();
                    $table->unsignedBigInteger('updated_by_user')->nullable();
                    $table->timestamps();
                });

                Schema::create('aircrafts', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('created_by_user')->nullable();
                    $table->unsignedBigInteger('updated_by_user')->nullable();
                    $table->timestamps();
                });

                    Schema::table('aircrafts', function(Blueprint $table) {
                        $table->foreign('created_by_user')->references('id')->on('users');
                        $table->foreign('updated_by_user')->references('id')->on('users');
                    });

                Schema::create('flights', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('created_by_user')->nullable();
                    $table->unsignedBigInteger('updated_by_user')->nullable();
                    $table->timestamps();
                });

                    Schema::table('flights', function(Blueprint $table) {
                        $table->foreign('created_by_user')->references('id')->on('users');
                        $table->foreign('updated_by_user')->references('id')->on('users');
                    });

                Schema::create('pilots', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('created_by_user')->nullable();
                    $table->unsignedBigInteger('updated_by_user')->nullable();
                    $table->timestamps();
                });

                    Schema::table('pilots', function(Blueprint $table) {
                        $table->foreign('created_by_user')->references('id')->on('users');
                        $table->foreign('updated_by_user')->references('id')->on('users');
                    });

                Schema::table('users', function (Blueprint $table) {
                    $table->string('firstName')->nullable();

                });

                Schema::table('users', function (Blueprint $table) {
                    $table->string('lastName')->nullable();

                });

                Schema::table('users', function (Blueprint $table) {
                    $table->string('phoneNumber')->nullable();

                });

                Schema::table('users', function (Blueprint $table) {
                    $table->string('email')->nullable();

                });

                Schema::table('users', function (Blueprint $table) {
                    $table->enum('role', ['admin','user'])->nullable();

                });

                Schema::table('users', function (Blueprint $table) {
                    $table->boolean('disabled')->nullable();

                });

                Schema::table('users', function (Blueprint $table) {
                    $table->string('password')->nullable();

                });

                Schema::table('users', function (Blueprint $table) {
                    $table->boolean('emailVerified')->nullable();

                });

                Schema::table('users', function (Blueprint $table) {
                    $table->string('emailVerificationToken')->nullable();

                });

                Schema::table('users', function (Blueprint $table) {
                    $table->timestamp('emailVerificationTokenExpiresAt')->nullable();

                });

                Schema::table('users', function (Blueprint $table) {
                    $table->string('passwordResetToken')->nullable();

                });

                Schema::table('users', function (Blueprint $table) {
                    $table->timestamp('passwordResetTokenExpiresAt')->nullable();

                });

                Schema::table('users', function (Blueprint $table) {
                    $table->string('provider')->nullable();

                });

                Schema::table('aircrafts', function (Blueprint $table) {
                    $table->string('make')->nullable();

                });

                Schema::table('aircrafts', function (Blueprint $table) {
                    $table->string('model')->nullable();

                });

                Schema::table('aircrafts', function (Blueprint $table) {
                    $table->string('registration')->nullable();

                });

                Schema::table('aircrafts', function (Blueprint $table) {
                    $table->integer('year')->nullable();

                });

                Schema::table('flights', function (Blueprint $table) {
                    $table->string('type')->nullable();

                });

                Schema::table('flights', function (Blueprint $table) {
                    $table->timestamp('date')->nullable();

                });

                Schema::table('flights', function (Blueprint $table) {
                    $table->decimal('duration')->nullable();

                });

                Schema::table('flights', function (Blueprint $table) {
                    $table->unsignedBigInteger('aircraft')->nullable();

                    $table->foreign('aircraft')->references('id')->on('aircrafts');

                });

                Schema::table('flights', function (Blueprint $table) {
                    $table->string('comments')->nullable();

                });

                Schema::table('pilots', function (Blueprint $table) {
                    $table->string('name')->nullable();

                });

                Schema::table('pilots', function (Blueprint $table) {
                    $table->string('license')->nullable();

                });

    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {

                Schema::table('pilots', function(Blueprint $table) {
                    $table->dropColumn('license');
                });

                Schema::table('pilots', function(Blueprint $table) {
                    $table->dropColumn('name');
                });

                Schema::table('flights', function(Blueprint $table) {
                    $table->dropColumn('comments');
                });

                Schema::table('flights', function(Blueprint $table) {
                    $table->dropColumn('aircraft');
                });

                Schema::table('flights', function(Blueprint $table) {
                    $table->dropColumn('duration');
                });

                Schema::table('flights', function(Blueprint $table) {
                    $table->dropColumn('date');
                });

                Schema::table('flights', function(Blueprint $table) {
                    $table->dropColumn('type');
                });

                Schema::table('aircrafts', function(Blueprint $table) {
                    $table->dropColumn('year');
                });

                Schema::table('aircrafts', function(Blueprint $table) {
                    $table->dropColumn('registration');
                });

                Schema::table('aircrafts', function(Blueprint $table) {
                    $table->dropColumn('model');
                });

                Schema::table('aircrafts', function(Blueprint $table) {
                    $table->dropColumn('make');
                });

                Schema::table('users', function(Blueprint $table) {
                    $table->dropColumn('provider');
                });

                Schema::table('users', function(Blueprint $table) {
                    $table->dropColumn('passwordResetTokenExpiresAt');
                });

                Schema::table('users', function(Blueprint $table) {
                    $table->dropColumn('passwordResetToken');
                });

                Schema::table('users', function(Blueprint $table) {
                    $table->dropColumn('emailVerificationTokenExpiresAt');
                });

                Schema::table('users', function(Blueprint $table) {
                    $table->dropColumn('emailVerificationToken');
                });

                Schema::table('users', function(Blueprint $table) {
                    $table->dropColumn('emailVerified');
                });

                Schema::table('users', function(Blueprint $table) {
                    $table->dropColumn('password');
                });

                Schema::table('users', function(Blueprint $table) {
                    $table->dropColumn('avatar');
                });

                Schema::table('users', function(Blueprint $table) {
                    $table->dropColumn('disabled');
                });

                Schema::table('users', function(Blueprint $table) {
                    $table->dropColumn('role');
                });

                Schema::table('users', function(Blueprint $table) {
                    $table->dropColumn('email');
                });

                Schema::table('users', function(Blueprint $table) {
                    $table->dropColumn('phoneNumber');
                });

                Schema::table('users', function(Blueprint $table) {
                    $table->dropColumn('lastName');
                });

                Schema::table('users', function(Blueprint $table) {
                    $table->dropColumn('firstName');
                });

                Schema::drop('pilots');

                Schema::drop('flights');

                Schema::drop('aircrafts');

                Schema::drop('users');

    }
}
