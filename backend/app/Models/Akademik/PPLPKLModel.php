<?php

namespace App\Models\Akademik;

use Illuminate\Database\Eloquent\Model;

class PPLPKLModel extends Model {    
	 /**
	 * nama tabel model ini.
	 *
	 * @var string
	 */
	protected $table = 'pe3_pplpkl';
	/**
	 * primary key tabel ini.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id';
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id',        
		'user_id',
		'pembimbing_1',
		'tempat_pplpkl',
		'address1_desa_id',
		'address1_kelurahan',
		'address1_kecamatan_id',
		'address1_kecamatan',
		'address1_kabupaten_id',
		'address1_kabupaten',
		'address1_provinsi_id',
		'address1_provinsi',

		'alamat_pplpkl',

		'size_baju',               		  
		'status',               
		'keterangan',        
		
		'prodi_id',
		'ta',
		'idsmt',
	];
	/**
	 * enable auto_increment.
	 *
	 * @var string
	 */
	public $incrementing = false;

	public function mahasiswa()
	{
		return $this->belongsTo('App\Models\Akademik\RegisterMahasiswaModel','user_id','user_id');
	}
}