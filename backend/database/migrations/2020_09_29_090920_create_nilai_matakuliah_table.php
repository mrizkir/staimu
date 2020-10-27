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

            $table->boolean('telah_isi_kuesioner')->default(false);
            $table->datetime('tanggal_isi_kuesioner');
            
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pe3_nilai_matakuliah');
    }
}
