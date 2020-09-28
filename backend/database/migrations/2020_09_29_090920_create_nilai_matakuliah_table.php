<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiMatakuliahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('pe3_nilai_matakuliah', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('idkrsmatkul');               

            $table->decimal('persentase_absen',5,2)->default(0.00);               
            $table->decimal('persentase_quiz',5,2)->default(0.00);               
            $table->decimal('persentase_tugas_individu',5,2)->default(0.00);               
            $table->decimal('persentase_tugas_kelompok',5,2)->default(0.00);               
            $table->decimal('persentase_uts',5,2)->default(0.00);               
            $table->decimal('persentase_uas',5,2)->default(0.00);  

            $table->decimal('nilai_absen',5,2)->default(0.00);    
            $table->decimal('nilai_quiz',5,2)->default(0.00);    
            $table->decimal('nilai_tugas_individu',5,2)->default(0.00);    
            $table->decimal('nilai_tugas_kelompok',5,2)->default(0.00);    
            $table->decimal('nilai_uts',5,2)->default(0.00);    
            $table->decimal('nilai_uas',5,2)->default(0.00);    
            $table->decimal('n_kuan',5,2)->default(0.00);    
            $table->decimal('n_kual',3)->default(0.00);  

            $this->boolean('telah_isi_kuesioner')->default(false);
            $this->datetime('tanggal_isi_kuesioner')->default(false);

            
        });

        Schema::create('pe3_krsmatkul', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('krs_id');    
            $table->string('nim');                    
            $table->uuid('penyelenggaraan_id');            
            $table->boolean('batal')->default(0);   
            $table->unsignedInteger('kjur');                
            $table->tinyinteger('idsmt');
            $table->year('tahun');
            $table->timestamps();  
            
            $table->index('penyelenggaraan_id');                           
            $table->index('krs_id');
            $table->index('nim');
            $table->index('tahun');
            $table->index('idsmt');            
            $table->index('kjur');            
            
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
