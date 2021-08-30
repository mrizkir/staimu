<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelompokPertanyaanTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{   
		Schema::defaultStringLength(191);
		Schema::create('pe3_kelompok_pertanyaan', function (Blueprint $table) {
			$table->uuid('id');                        
			$table->tinyInteger('kategori_id');                        
			$table->string('nama_kelompok');                        
			$table->tinyinteger('urutan');                        
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
		Schema::dropIfExists('pe3_kelompok_pertanyaan');
	}
}
