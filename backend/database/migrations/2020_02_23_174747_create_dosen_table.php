<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::defaultStringLength(191);
        Schema::create('pe3_dosen', function (Blueprint $table) {
            $table->uuid('user_id')->primary();            
            $table->string('nidn',15)->unique();
            $table->string('nipy');
            $table->string('nama_dosen');
            $table->string('gelar_depan',20);
            $table->string('gelar_belakang',20);            
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('pe3_dosen');
    }
}
