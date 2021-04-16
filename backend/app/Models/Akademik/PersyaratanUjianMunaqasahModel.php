<?php

namespace App\Models\Akademik;

use Illuminate\Database\Eloquent\Model;

class PersyaratanUjianMunaqasahModel extends Model {    
     /**
     * nama tabel model ini.
     *
     * @var string
     */
    protected $table = 'pe3_persyaratan_ujian_munaqasah';
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
        'persyaratan_id',
        'ujian_munaqasah_id',

        'nama_persyaratan',               
        'file',               
        'status',               
        'keterangan',        
    ];
    /**
     * enable auto_increment.
     *
     * @var string
     */
    public $incrementing = false;
}