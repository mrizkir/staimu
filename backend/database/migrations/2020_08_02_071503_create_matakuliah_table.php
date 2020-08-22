<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatakuliahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::defaultStringLength(191);
        Schema::create('pe3_matakuliah', function (Blueprint $table) {
            $table->uuid('id')->primary();    
            $table->tinyInteger('id_group')->nullable();
            $table->string('nama_group')->nullable();
            $table->string('group_alias')->nullable();
            $table->string('kmatkul');
            $table->string('nmatkul');
            $table->tinyinteger('sks');
            $table->tinyinteger('idkonsentrasi')->nullable();
            $table->boolean('ispilihan')->default(false);
            $table->boolean('islintas_prodi')->default(false);
            $table->tinyinteger('semester');
            $table->tinyinteger('sks_tatap_muka');
            $table->tinyinteger('sks_praktikum');
            $table->tinyinteger('sks_praktik_lapangan');
            $table->char('minimal_nilai',1);
            $table->boolean('syarat_skripsi')->default(false);
            $table->boolean('status')->default(false);
            $table->year('ta');
            $table->tinyinteger('kjur');
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
        Schema::dropIfExists('pe3_matakuliah');        
    }
}
