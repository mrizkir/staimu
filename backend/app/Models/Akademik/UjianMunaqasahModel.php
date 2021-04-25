<?php

namespace App\Models\Akademik;

use Illuminate\Database\Eloquent\Model;

class UjianMunaqasahModel extends Model {    
     /**
     * nama tabel model ini.
     *
     * @var string
     */
    protected $table = 'pe3_ujian_munaqasah';
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
        'judul_skripsi',
        'abstrak',

        'pembimbing_1',               
        'pembimbing_2',               
        'status',               
        'keterangan',        
        
        'prodi_id',
        'ta',
    ];
    /**
     * enable auto_increment.
     *
     * @var string
     */
    public $incrementing = false;
}