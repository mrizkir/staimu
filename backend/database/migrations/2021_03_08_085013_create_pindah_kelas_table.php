<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePindahKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('pe3_pindah_kelas', function (Blueprint $table) {
            $table->uuid('id')->primary();           
            $table->uuid('user_id');               
            $table->string('nim');
            $table->char('idkelas_lama',1);
            $table->char('idkelas_baru',1);
            $table->unsignedInteger('kjur'); 
            $table->tinyinteger('idsmt');
            $table->year('tahun');
            $table->string('descr')->nullable();
            $table->timestamps();  

            $table->index('user_id');
            $table->index('nim');

            $table->foreign('user_id')
                ->references('user_id')
                ->on('pe3_formulir_pendaftaran')
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
