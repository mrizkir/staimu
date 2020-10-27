<?php

namespace App\Models\Akademik;

use Illuminate\Database\Eloquent\Model;


class PembagianKelasModel extends Model 
{
    /**
     * nama tabel model ini.
     *
     * @var string
     */
    protected $table = 'pe3_kelas_mhs';
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
        'idkelas',
        'nama_kelas',
        'nmatkul',
        'hari',
        'semester',
        'jam_masuk',
        'jam_keluar',
        'penyelenggaraan_dosen_id',         
        'ruang_kelas_id',
        'persen_quiz',
        'persen_tugas_individu',
        'persen_tugas_kelompok',
        'persen_uas',
        'persen_absen',
        'isi_nilai',        
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

