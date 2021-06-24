<?php

namespace App\Http\Controllers\Kemahasiswaan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Kemahasiswaan\PindahKelasModel;

use Ramsey\Uuid\Uuid;

class PindahKelasController  extends Controller 
{
  /**
   * daftar mahasiswa yang pindah kelas
  */
  public function index(Request $request)
  {
    $this->hasPermissionTo('KEMAHASISWAAN-PINDAH-KELAS_BROWSE');

    $this->validate($request, [
      'ta'=>'required',
      'semester_akademik'=>'required',
      'prodi_id'=>'required'
    ]);

    $ta=$request->input('ta');
    $prodi_id=$request->input('prodi_id');
    $semester_akademik=$request->input('semester_akademik');
    
    $data = PindahKelasModel::select(\DB::raw("
                              pe3_pindah_kelas.id,
                              pe3_pindah_kelas.user_id,
                              pe3_pindah_kelas.nim,
                              pe3_formulir_pendaftaran.nama_mhs,
                              A.nkelas AS kelas_lama,
                              B.nkelas AS kelas_baru,
                              pe3_pindah_kelas.descr,
                              pe3_pindah_kelas.created_at,
                              pe3_pindah_kelas.updated_at
                            "))
                            ->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_pindah_kelas.user_id')
                            ->join('pe3_kelas AS A','A.idkelas','pe3_pindah_kelas.idkelas_lama')
                            ->join('pe3_kelas AS B','B.idkelas','pe3_pindah_kelas.idkelas_baru')
                            ->orderBy('nama_mhs','ASC')
                            ->where('pe3_pindah_kelas.kjur', $prodi_id)
                            ->where('pe3_pindah_kelas.tahun', $ta)
                            ->where('pe3_pindah_kelas.idsmt', $semester_akademik)  
                            ->get();
    
    return Response()->json([
                              'status'=>1,
                              'pid'=>'fetchdata',  
                              'pindahkelas'=>$data,                                                                                                                                   
                              'message'=>'Fetch data mahasiswa yang pindah kelas berhasil diperoleh.'
                            ], 200);     
  }
  
  /**
   * simpan data
   */
  public function store(Request $request)
  {
    $this->hasPermissionTo('KEMAHASISWAAN-PINDAH-KELAS_STORE');

    $this->validate($request, [
      'user_id'=>'required|exists:pe3_register_mahasiswa,user_id',     
      'nim'=>'required|exists:pe3_register_mahasiswa,nim',     
      'idkelas_lama'=>'required',     
      'idkelas_baru'=>'required',     
      'idsmt'=>'required',     
      'tahun'=>'required',     
    ]);

    $data = PindahKelasModel::create([
      'id'=>Uuid::uuid4()->toString(),
      'user_id'=>$request->input('user_id'),
      'nim'=>$request->input('nim'),
      'idkelas_lama'=>$request->input('idkelas_lama'),
      'idkelas_baru'=>$request->input('idkelas_baru'),
      'idsmt'=>$request->input('idsmt'),
      'tahun'=>$request->input('tahun'),
      'descr'=>$request->input('descr'),
    ]);
    
    return Response()->json([
                            'status'=>1,
                            'pid'=>'store',  
                            'pindahkelas'=>$data,                                                                                                                                   
                            'message'=>'Mahasiswa yang pindah kelas berhasil dilakukan.'
                          ], 200);     
  }
  public function destroy(Request $request,$id)
  { 
    $this->hasPermissionTo('KEMAHASISWAAN-PINDAH-KELAS_DESTROY');    

    $pindahkelas = PindahKelasModel::find($id); 
    
    if (is_null($pindahkelas))
    {
        return Response()->json([
                                'status'=>0,
                                'pid'=>'destroy',                
                                'message'=>["Data Pindah Kelas dengan ($id) gagal dihapus"]
                            ],422); 
    }
    else
    {
        \App\Models\System\ActivityLog::log($request,[
                                                      'object' => $pindahkelas, 
                                                      'object_id' => $pindahkelas->id, 
                                                      'user_id' => $this->getUserid(), 
                                                      'message' => 'Menghapus Pindah Kelas dengan id ('.$id.') berhasil'
                                                    ]);
        $pindahkelas->delete();
        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'destroy',                
                                    'message'=>"Data Pindah Kelas dengan ID ($id) berhasil dihapus"
                                ],200);         
    }
                
  }

}