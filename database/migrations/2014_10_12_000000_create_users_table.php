<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('name');
            $table->string('surname');
            $table->string('email')->unique();
            //$table->timestamp('email_verified_at')->nullable();
            $table->string('username')->unique();//hay que lograr que loguee por nickname y contraseña
            $table->string('cuil')->unique();
            $table->string('password');
            $table->integer('changedpassword')->default('0');
            $table->rememberToken();
            $table->timestamps();

            //$table->foreign('rol_id')->references('id')->on('roles')->onDelete('set null');
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
