<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePKRSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('pe3_pkrs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');            
            $table->string('nim');
            $table->uuid('penyelenggaraan_id');            
            $table->tinyInteger('tambah');
            $table->tinyInteger('hapus');
            $table->tinyInteger('batal');
            $table->tinyInteger('sah');            
            $table->timestamps();
            
            $table->foreign('user_id')
                ->references('user_id')
                ->on('pe3_formulir_pendaftaran')
                ->onDelete('cascade')
                ->onUpdate('cascade'); 
                
            $table->foreign('penyelenggaraan_id')
                ->references('id')
                ->on('pe3_penyelenggaraan')
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
        Schema::dropIfExists('pe3_pkrs');
    }
}
