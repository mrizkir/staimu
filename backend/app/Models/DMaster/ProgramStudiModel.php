<?php

namespace App\Models\DMaster;

use Illuminate\Database\Eloquent\Model;

class ProgramStudiModel extends Model {    
   /**
   * nama tabel model ini.
   *
   * @var string
   */
  protected $table = 'pe3_prodi';
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
    'kode_prodi',
    'nama_prodi',
    'nama_prodi_alias',
    'kode_fakultas',
    'kode_jenjang',
    'nama_jenjang',
    'config'
  ];
  /**
   * enable auto_increment.
   *
   * @var string
   */
  public $incrementing = true;
  /**
   * activated timestamps.
   *
   * @var string
   */
  public $timestamps = false;
  
  public function mahasiswa()
  {
    return $this->hasMany('App\Models\Akademik\RegisterMahasiswaModel', 'kjur', 'id');
  }
  public function formulirpendaftaran1()
  {
    return $this->hasMany('App\Models\SPMB\FormulirPendaftaranModel', 'kjur1', 'id');
  }
  public function formulirpendaftaran2()
  {
    return $this->hasMany('App\Models\SPMB\FormulirPendaftaranModel', 'kjur2', 'id');
  }
  public function fakultas()
	{
		return $this->belongsTo('App\Models\DMaster\FakultasModel', 'kode_fakultas', 'kode_fakultas');
	}
}