<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKRSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('pe3_krs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');               
            $table->uuid('dulang_id');               
            $table->string('nim');
            $table->tinyinteger('kjur');                
            $table->string('idsmt');
            $table->string('tahun');
            $table->smallInteger('tasmt');
            $table->boolean('sah')->default(0);                     
            $table->timestamps();  
            
            $table->index('tahun');
            $table->index('idsmt');            
            $table->index('kjur');            
            
            $table->foreign('dulang_id')
                ->references('id')
                ->on('pe3_dulang')
                ->onDelete('cascade')
                ->onUpdate('cascade');            

            $table->foreign('user_id')
                ->references('user_id')
                ->on('pe3_formulir_pendaftaran')
                ->onDelete('cascade')
                ->onUpdate('cascade');            
        });

        Schema::create('pe3_krsmatkul', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('krs_id');            
            $table->uuid('penyelenggaraan_id');            
            $table->boolean('batal')->default(0);   
            
            $table->timestamps();  
            
            $table->index('penyelenggaraan_id');                           
            $table->index('krs_id');
           
            
            $table->foreign('penyelenggaraan_id')
                ->references('id')
                ->on('pe3_penyelenggaraan')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('krs_id')
                ->references('id')
                ->on('pe3_krs')
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
        Schema::dropIfExists('pe3_krs');
    }
}
