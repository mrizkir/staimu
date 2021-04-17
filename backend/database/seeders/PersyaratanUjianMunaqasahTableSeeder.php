<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class PersyaratanUjianMunaqasahTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {   
    \DB::statement('DELETE FROM pe3_persyaratan WHERE proses="ujian-munaqasah"');

    $tahun = 2021;

    \DB::table('pe3_persyaratan')->insert([
      'id'=>"$tahun-ujian-munaqasah-1",
      'proses'=>'ujian-munaqasah',
      'nama_persyaratan'=>'SPP Semester yang sedang berjalan (SPP Terakhir)',
      'prodi_id'=>NULL,
      'ta'=>$tahun,
      'created_at'=>Carbon::now(),
      'updated_at'=>Carbon::now()
    ]);
    \DB::table('pe3_persyaratan')->insert([
      'id'=>"$tahun-ujian-munaqasah-2",
      'proses'=>'ujian-munaqasah',
      'nama_persyaratan'=>'Pembayaran uang skripsi',
      'prodi_id'=>NULL,
      'ta'=>$tahun,
      'created_at'=>Carbon::now(),
      'updated_at'=>Carbon::now()
    ]);
    
    \DB::table('pe3_persyaratan')->insert([
      'id'=>"$tahun-ujian-munaqasah-4",
      'proses'=>'ujian-munaqasah',
      'nama_persyaratan'=>'Matakuliah Skripsi terdapat di KRS',
      'prodi_id'=>NULL,
      'ta'=>$tahun,
      'created_at'=>Carbon::now(),
      'updated_at'=>Carbon::now()
    ]);

    \DB::table('pe3_persyaratan')->insert([
      'id'=>"$tahun-ujian-munaqasah-5",
      'proses'=>'ujian-munaqasah',
      'nama_persyaratan'=>'Jadwal konsultasi pembimbing',
      'prodi_id'=>NULL,
      'ta'=>$tahun,
      'created_at'=>Carbon::now(),
      'updated_at'=>Carbon::now()
    ]);

    \DB::table('pe3_persyaratan')->insert([
      'id'=>"$tahun-ujian-munaqasah-6",
      'proses'=>'ujian-munaqasah',
      'nama_persyaratan'=>'Scanan STTB / Ijazah Terakhir',
      'prodi_id'=>NULL,
      'ta'=>$tahun,
      'created_at'=>Carbon::now(),
      'updated_at'=>Carbon::now()
    ]);
    
    \DB::table('pe3_persyaratan')->insert([
      'id'=>"$tahun-ujian-munaqasah-7",
      'proses'=>'ujian-munaqasah',
      'nama_persyaratan'=>'Scanan KTP',
      'prodi_id'=>NULL,
      'ta'=>$tahun,
      'created_at'=>Carbon::now(),
      'updated_at'=>Carbon::now()
    ]);

    \DB::table('pe3_persyaratan')->insert([
      'id'=>"$tahun-ujian-munaqasah-8",
      'proses'=>'ujian-munaqasah',
      'nama_persyaratan'=>'Pas Photo 3x4 (Latar belakang Merah, Baju Putih, untuk laki-laki memakai jas, dasi warna hitam, kopiah hitam dan perempuan memakai jas almamater dan jilbab polos warna putih',
      'prodi_id'=>NULL,
      'ta'=>$tahun,
      'created_at'=>Carbon::now(),
      'updated_at'=>Carbon::now()
    ]);

    \DB::table('pe3_persyaratan')->insert([
      'id'=>"$tahun-ujian-munaqasah-9",
      'proses'=>'ujian-munaqasah',
      'nama_persyaratan'=>'Sertifikat OSPEK / PBAK',
      'prodi_id'=>NULL,
      'ta'=>$tahun,
      'created_at'=>Carbon::now(),
      'updated_at'=>Carbon::now()
    ]);
    
  }
}
