<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelasMhsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('pe3_kelas_mhs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('idkelas',1);
            $table->tinyinteger('nama_kelas');
            $table->tinyinteger('hari');
            $table->string('jam_masuk',5);
            $table->string('jam_keluar',5);
            $table->uuid('penyelenggaraan_dosen_id');   
            $table->uuid('ruang_kelas_id');            

            $table->tinyinteger('persen_quiz');
            $table->tinyinteger('persen_tugas_individu');
            $table->tinyinteger('persen_tugas_kelompok');
            $table->tinyinteger('persen_uts');
            $table->tinyinteger('persen_uas');
            $table->tinyinteger('persen_absen');
            $table->boolean('isi_nilai')->default(0);
            $table->timestamps();  
            
            $table->index('penyelenggaraan_dosen_id');
            $table->index('ruang_kelas_id');
            $table->index('idkelas');                                    
            
            $table->foreign('penyelenggaraan_dosen_id')
                ->references('id')
                ->on('pe3_penyelenggaraan_dosen')
                ->onDelete('cascade')
                ->onUpdate('cascade');                             
        });

        Schema::create('pe3_kelas_mhs_detail', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('kelas_mhs_id');    
            $table->uuid('krsmatkul_id');    
            $table->timestamps();  
            
            $table->index('kelas_mhs_id');        
            $table->index('krsmatkul_id');
            
            $table->foreign('kelas_mhs_id')
                ->references('id')
                ->on('pe3_kelas_mhs')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('krsmatkul_id')
                ->references('id')
                ->on('pe3_krsmatkul')
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
        Schema::dropIfExists('pe3_kelas_mhs_detail');
        Schema::dropIfExists('pe3_kelas_mhs');
    }
}
