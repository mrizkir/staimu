<?php

namespace App\Models\Kemahasiswaan;

use Illuminate\Database\Eloquent\Model;

class PindahKelasModel extends Model {    
     /**
     * nama tabel model ini.
     *
     * @var string
     */
    protected $table = 'pe3_pindah_kelas';
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
        'nim',
        'idkelas_lama',               
        'idkelas_baru',               
        'kjur',               
        'idsmt',               
        'tahun',        
        'descr',        
        'forcefully',        
    ];
    /**
     * enable auto_increment.
     *
     * @var string
     */
    public $incrementing = false;
    /**
     * activated timestamps.
     *
     * @var string
     */
    public $timestamps = true;
    
    public function mahasiswa()
    {
        return $this->belongsTo('App\Models\SPMB\FormulirPendaftaranModel','user_id','user_id');
    }
}