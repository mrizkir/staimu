<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegisterMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('pe3_register_mahasiswa', function (Blueprint $table) {
            $table->uuid('user_id')->primary();
            $table->string('nim')->unique();
            $table->string('nirm')->unique();

            $table->char('idkelas',1)->nullable();
            $table->year('ta');
            $table->tinyInteger('idsmt');




            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pe3_register_mahasiswa');
    }
}
