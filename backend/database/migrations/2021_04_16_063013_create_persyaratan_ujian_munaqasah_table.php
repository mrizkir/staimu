<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersyaratanUjianMunaqasahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('pe3_persyaratan_ujian_munaqasah', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');            
            $table->uuid('persyaratan_id');
            $table->uuid('ujian_munaqasah_id')->nullable();
            $table->string('nama_persyaratan');
            $table->string('file')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->string('keterangan')->nullable();

            $table->timestamps();  
            
            $table->index('user_id');   
            $table->index('persyaratan_id');            

            $table->foreign('user_id')
                ->references('user_id')
                ->on('pe3_register_mahasiswa')
                ->onDelete('cascade')
                ->onUpdate('cascade');
                
            $table->foreign('persyaratan_id')
                ->references('id')
                ->on('pe3_persyaratan')
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
        Schema::dropIfExists('pe3_persyaratan_ujian_munaqasah');
    }
}
