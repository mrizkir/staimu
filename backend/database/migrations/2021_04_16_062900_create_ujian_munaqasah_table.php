<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUjianMunaqasahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('pe3_ujian_munaqasah', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('judul_skripsi');
            $table->text('abstrak');
            $table->uuid('pembimbing_1')->nullable();
            $table->uuid('pembimbing_2')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->string('keterangan')->nullable();

            $table->unsignedInteger('prodi_id');   
            $table->year('ta');

            $table->timestamps();  
            
            $table->index('user_id');   
            $table->index('pembimbing_1');   
            $table->index('pembimbing_2');   
                     

            $table->foreign('user_id')
                ->references('user_id')
                ->on('pe3_register_mahasiswa')
                ->onDelete('cascade')
                ->onUpdate('cascade');         

            $table->foreign('pembimbing_1')
                ->references('user_id')
                ->on('pe3_dosen')
                ->onDelete('set null')
                ->onUpdate('cascade');         

            $table->foreign('pembimbing_2')
                ->references('user_id')
                ->on('pe3_dosen')
                ->onDelete('set null')
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
        Schema::dropIfExists('pe3_persyaratan_ujian_munaqasah');
    }
}
