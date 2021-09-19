<?php
namespace App\Http\Controllers\Kemahasiswaan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Akademik\RegisterMahasiswaModel;

class KemahasiswaanStatusCutiController  extends Controller 
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
                pe3_register_mahasiswa.tahun,
                pe3_register_mahasiswa.created_at,      
                pe3_register_mahasiswa.updated_at      
            '))            
            ->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_register_mahasiswa.user_id')
            ->leftJoin('pe3_dosen','pe3_dosen.user_id','pe3_register_mahasiswa.dosen_id')            
            ->where('pe3_register_mahasiswa.kjur',$prodi_id)
            ->where('pe3_register_mahasiswa.k_status','C')            
            ->orderBy('nama_mhs','asc')
            ->get();

    $subquery = \DB::table('pe3_register_mahasiswa')
            ->select(\DB::raw('kjur, COUNT(user_id) AS total'))
            ->where('k_status','C')
            ->groupBy('kjur');

    $daftar_prodi = \DB::table('pe3_prodi AS A')
                    ->select(\DB::raw('
                      id,
                      nama_prodi,
                      CONCAT(nama_prodi_alias," (",nama_jenjang, ")") AS nama_prodi_alias,              
                      COALESCE(total,0) AS  total
                    '))
                    ->leftJoinSub($subquery,'B',function($join) {
                      $join->on('B.kjur','=','A.id');
                    })
                    ->get();

    $total_mahasiswa = $daftar_prodi->sum('total');

    return Response()->json([
      'status'=>1,
      'pid'=>'fetchdata',  
      'mahasiswa'=>$data,
      'daftar_prodi'=>$daftar_prodi, 
      'total_mahasiswa'=>$total_mahasiswa,
      'message'=>'Fetch data daftar mahasiswa yang cuti berhasil.'
    ], 200); 
  }
}