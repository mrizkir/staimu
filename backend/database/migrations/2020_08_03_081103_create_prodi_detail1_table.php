<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdiDetail1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::defaultStringLength(191);
        Schema::create('pe3_prodi_detail1', function (Blueprint $table) {
            $table->uuid('id')->primary();                
            $table->uuid('matkul_skripsi')->nullable(); 
            $table->smallInteger('jumlah_sks');
            $table->unsignedInteger('prodi_id');
            $table->year('ta');                        
            
            $table->timestamps();
            $table->index('ta');
            $table->index('prodi_id');
            $table->index('matkul_skripsi');
            
            $table->foreign('matkul_skripsi')
                ->references('id')
                ->on('pe3_matakuliah')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('prodi_id')
                    ->references('id')
                    ->on('pe3_prodi')
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
        Schema::dropIfExists('pe3_prodi_detail1');        
    }
}
