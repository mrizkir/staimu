<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePplpklTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::defaultStringLength(191);
		Schema::create('pe3_pplpkl', function (Blueprint $table) {
			$table->uuid('id')->primary();
			$table->uuid('user_id');
      $table->uuid('pembimbing_1')->nullable();
			
      $table->string('tempat_pplpkl');

      $table->string('address1_desa_id',10)->nullable(); 
      $table->string('address1_kelurahan')->nullable(); 
      $table->string('address1_kecamatan_id',7)->nullable(); 
      $table->string('address1_kecamatan')->nullable(); 
      $table->string('address1_kabupaten_id',4)->nullable(); 
      $table->string('address1_kabupaten')->nullable(); 
      $table->string('address1_provinsi_id',2)->nullable(); 
      $table->string('address1_provinsi')->nullable(); 
      $table->string('alamat_pplpkl')->nullable(); 

			$table->string('size_baju', 5);
			
			$table->tinyInteger('status')->default(0);
			$table->string('keterangan')->nullable();

			$table->unsignedInteger('prodi_id');   
			$table->year('ta');
			$table->tinyinteger('idsmt');

			$table->timestamps();  
			
			$table->index('user_id');   
			$table->index('pembimbing_1');
			$table->index('ta');
			$table->index('idsmt');

			$table->foreign('user_id')
				->references('user_id')
				->on('pe3_register_mahasiswa')
				->onDelete('cascade')
				->onUpdate('cascade');      
				
			$table->foreign('pembimbing_1')
				->references('user_id')
				->on('pe3_dosen')
				->onDelete('set null')
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
		Schema::dropIfExists('pe3_pplpkl');
	}
}
