<?php
namespace App\Http\Controllers\Kemahasiswaan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Akademik\RegisterMahasiswaModel;

class KemahasiswaanStatusAktifController  extends Controller 
{
  /**
   * daftar mahasiswa yang aktif
  */
  public function index(Request $request)
  {
    $this->hasPermissionTo('AKADEMIK-KEMAHASISWAAN-DAFTAR-MAHASISWA_BROWSE');
    
    $this->validate($request, [
      'prodi_id'=>'required'
    ]);
    $prodi_id=$request->input('prodi_id');

    $data = RegisterMahasiswaModel::select(\DB::raw('                
                pe3_register_mahasiswa.user_id,
                pe3_formulir_pendaftaran.no_formulir,
                pe3_register_mahasiswa.nim,
                pe3_register_mahasiswa.nirm,
                pe3_formulir_pendaftaran.nama_mhs,
                pe3_register_mahasiswa.idkelas,
                pe3_register_mahasiswa.k_status,    
                CONCAT(COALESCE(pe3_dosen.gelar_depan,\'\'),\'\',pe3_dosen.nama_dosen,\' \',COALESCE(pe3_dosen.gelar_belakang,\'\')) AS dosen_wali,                      
                pe3_register_mahasiswa.created_at,      
                pe3_register_mahasiswa.updated_at      
            '))            
            ->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_register_mahasiswa.user_id')
            ->leftJoin('pe3_dosen','pe3_dosen.user_id','pe3_register_mahasiswa.dosen_id')            
            ->where('pe3_register_mahasiswa.kjur',$prodi_id)
            ->where('pe3_register_mahasiswa.k_status','A')            
            ->orderBy('nama_mhs','asc')
            ->get();

    return Response()->json([
      'status'=>1,
      'pid'=>'fetchdata',  
      'mahasiswa'=>$data,                                                                                                                                   
      'message'=>'Fetch data daftar mahasiswa yang aktif berhasil.'
    ], 200); 
  }
}