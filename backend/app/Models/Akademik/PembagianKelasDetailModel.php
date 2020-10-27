<?php

namespace App\Models\Akademik;

use Illuminate\Database\Eloquent\Model;


class PembagianKelasDetailModel extends Model 
{
    /**
     * nama tabel model ini.
     *
     * @var string
     */
    protected $table = 'pe3_kelas_mhs_detail';
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
        'kelas_mhs_id',
        'krsmatkul_id',        
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
}

