<?php

namespace App\Http\Controllers\Kemahasiswaan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\HelperAkademik;
use App\Models\Kemahasiswaan\PindahKelasModel;
use App\Models\Akademik\RegisterMahasiswaModel;

use Exception;
use Ramsey\Uuid\Uuid;

class PindahPaksaKelasController  extends Controller 
{  
  /**
   * simpan data
   */
  public function store(Request $request)
  {
    $this->hasPermissionTo('KEMAHASISWAAN-PINDAH-KELAS_STORE');

    $this->validate($request, [
      'user_id'=>'required|exists:pe3_register_mahasiswa,user_id',
      'idkelas_lama'=>'required',     
      'idkelas_baru'=>'required',     
      'idsmt'=>'required',     
      'tahun'=>'required',     
    ]);
    $user_id = $request->input('user_id');
    $idsmt = $request->input('idsmt');
    $tahun = $request->input('tahun');
    try 
    {
      $data_mhs = RegisterMahasiswaModel::find($user_id);

      $bool = \DB::table('pe3_dulang')
              ->where('user_id', $user_id)
              ->where('idsmt', $idsmt)
              ->where('tahun', $tahun)
              ->exists();         
      if ($bool) {
        $semester = HelperAkademik::getSemester($idsmt);
        throw new Exception ("Pindah kelas tidak bisa dilakukan karena sudah daftar ulang semester $semester T.A $tahun.");  
      }
      $data = \DB::transaction(function () use ($request,$data_mhs) {
        $data = PindahKelasModel::create([
          'id'=>Uuid::uuid4()->toString(),
          'user_id'=>$request->input('user_id'),
          'nim'=>$data_mhs->nim,
          'idkelas_lama'=>$data_mhs->idkelas,
          'idkelas_baru'=>$request->input('idkelas_baru'),
          'kjur'=>$data_mhs->kjur,
          'idsmt'=>$request->input('idsmt'),
          'tahun'=>$request->input('tahun'),
          'descr'=>$request->input('descr'),
          'forcefull'=>false,
        ]);
        $data_mhs->idkelas = $request->input('idkelas_baru');
        $data_mhs->save();
        return $data;
      }); 
      $pindahkelas = PindahKelasModel::select(\DB::raw("
        pe3_pindah_kelas.id,
        pe3_pindah_kelas.user_id,
        pe3_pindah_kelas.nim,
        pe3_formulir_pendaftaran.nama_mhs,
        pe3_pindah_kelas.idkelas_lama,
        A.nkelas AS kelas_lama,
        pe3_pindah_kelas.idkelas_baru,
        B.nkelas AS kelas_baru,
        pe3_pindah_kelas.idsmt,
        pe3_pindah_kelas.tahun,
        pe3_pindah_kelas.descr,
        pe3_pindah_kelas.created_at,
        pe3_pindah_kelas.updated_at
      "))
      ->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_pindah_kelas.user_id')
      ->join('pe3_kelas AS A','A.idkelas','pe3_pindah_kelas.idkelas_lama')
      ->join('pe3_kelas AS B','B.idkelas','pe3_pindah_kelas.idkelas_baru')
      ->where('pe3_pindah_kelas.id', $data->id)
      ->first();
              
      return Response()->json([
                              'status'=>1,
                              'pid'=>'store',  
                              'pindahkelas'=>$pindahkelas,
                              'message'=>'Mahasiswa yang pindah kelas berhasil dilakukan.'
                            ], 200);
    }
    catch (Exception $e)
    {
      return Response()->json([
        'status'=>0,
        'pid'=>'store',               
        'message'=>[$e->getMessage()]
      ], 422); 
    }
  }
}