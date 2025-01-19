<?php

namespace App\Http\Controllers\Kemahasiswaan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\HelperAkademik;
use App\Models\Kemahasiswaan\PindahKelasModel;
use App\Models\SPMB\FormulirPendaftaranModel;
use App\Models\Akademik\RegisterMahasiswaModel;
use App\Models\System\ConfigurationModel;

use Exception;
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
      'ta' => 'required',
      'semester_akademik' => 'required',
      'prodi_id' => 'required'
    ]);

    $ta = $request->input('ta');
    $prodi_id = $request->input('prodi_id');
    $semester_akademik=$request->input('semester_akademik');
    
    $data = PindahKelasModel::select(\DB::raw("
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
                              pe3_pindah_kelas.forcefully,
                              pe3_pindah_kelas.created_at,
                              pe3_pindah_kelas.updated_at
                            "))
                            ->join('pe3_formulir_pendaftaran', 'pe3_formulir_pendaftaran.user_id', 'pe3_pindah_kelas.user_id')
                            ->join('pe3_kelas AS A', 'A.idkelas', 'pe3_pindah_kelas.idkelas_lama')
                            ->join('pe3_kelas AS B', 'B.idkelas', 'pe3_pindah_kelas.idkelas_baru')
                            ->orderBy('nama_mhs', 'ASC')
                            ->where('pe3_pindah_kelas.kjur', $prodi_id)
                            ->where('pe3_pindah_kelas.tahun', $ta)
                            ->where('pe3_pindah_kelas.idsmt', $semester_akademik)  
                            ->get();
    
    return Response()->json([
                              'status' => 1,
                              'pid' => 'fetchdata',  
                              'pindahkelas' => $data,
                              'message' => 'Fetch data mahasiswa yang pindah kelas berhasil diperoleh.'
                            ], 200);
  }
  
  /**
   * simpan data
   */
  public function store(Request $request)
  {
    $this->hasPermissionTo('KEMAHASISWAAN-PINDAH-KELAS_STORE');

    $this->validate($request, [
      'user_id' => 'required|exists:pe3_register_mahasiswa,user_id',
      'idkelas_lama' => 'required',     
      'idkelas_baru' => 'required',     
      'idsmt' => 'required',     
      'tahun' => 'required',     
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
          'user_id' => $request->input('user_id'),
          'nim' => $data_mhs->nim,
          'idkelas_lama' => $data_mhs->idkelas,
          'idkelas_baru' => $request->input('idkelas_baru'),
          'kjur' => $data_mhs->kjur,
          'idsmt' => $request->input('idsmt'),
          'tahun' => $request->input('tahun'),
          'descr' => $request->input('descr'),
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
      ->join('pe3_formulir_pendaftaran', 'pe3_formulir_pendaftaran.user_id', 'pe3_pindah_kelas.user_id')
      ->join('pe3_kelas AS A', 'A.idkelas', 'pe3_pindah_kelas.idkelas_lama')
      ->join('pe3_kelas AS B', 'B.idkelas', 'pe3_pindah_kelas.idkelas_baru')
      ->where('pe3_pindah_kelas.id', $data->id)
      ->first();
              
      return Response()->json([
                              'status' => 1,
                              'pid' => 'store',  
                              'pindahkelas' => $pindahkelas,
                              'message' => 'Mahasiswa yang pindah kelas berhasil dilakukan.'
                            ], 200);
    }
    catch (Exception $e)
    {
      return Response()->json([
        'status'=>0,
        'pid' => 'store',               
        'message' => [$e->getMessage()]
      ], 422); 
    }
  }
  /**
   * paksa pindah
   */
  public function paksa(Request $request)
  {
    $this->hasPermissionTo('KEMAHASISWAAN-PINDAH-KELAS_STORE');

    $this->validate($request, [
      'user_id' => 'required|exists:pe3_register_mahasiswa,user_id',
      'idkelas_baru' => 'required'
    ]);

    $user_id = $request->input('user_id');    
    try 
    {
      $data_mhs = RegisterMahasiswaModel::find($user_id);
   
      $data = \DB::transaction(function () use ($request, $data_mhs) {
        $config = ConfigurationModel::getCache();
        $idkelas_baru = $request->input('idkelas_baru');
        $data = PindahKelasModel::create([
          'id'=>Uuid::uuid4()->toString(),
          'user_id' => $data_mhs->user_id,
          'nim' => $data_mhs->nim,
          'idkelas_lama' => $data_mhs->idkelas,
          'idkelas_baru' => $idkelas_baru,
          'kjur' => $data_mhs->kjur,
          'idsmt' => $config['DEFAULT_SEMESTER'],
          'tahun' => $config['DEFAULT_TA'],
          'descr' => 'PINDAH SECARA PAKSA',
          'forcefully'=>true,
        ]);
        $data_mhs->idkelas = $request->input('idkelas_baru');
        $data_mhs->save();

        \DB::table('pe3_transaksi')->where('user_id', $data_mhs->user_id)->update(['idkelas' => $idkelas_baru]);
        \DB::table('pe3_dulang')->where('user_id', $data_mhs->user_id)->update(['idkelas' => $idkelas_baru]);
        \DB::table('pe3_formulir_pendaftaran')->where('user_id', $data_mhs->user_id)->update(['idkelas' => $idkelas_baru]);
        
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
      ->join('pe3_formulir_pendaftaran', 'pe3_formulir_pendaftaran.user_id', 'pe3_pindah_kelas.user_id')
      ->join('pe3_kelas AS A', 'A.idkelas', 'pe3_pindah_kelas.idkelas_lama')
      ->join('pe3_kelas AS B', 'B.idkelas', 'pe3_pindah_kelas.idkelas_baru')
      ->where('pe3_pindah_kelas.id', $data->id)
      ->first();
              
      return Response()->json([
                              'status' => 1,
                              'pid' => 'store',  
                              'pindahkelas' => $pindahkelas,
                              'message' => 'Mahasiswa yang pindah kelas berhasil dilakukan.'
                            ], 200);
    }
    catch (Exception $e)
    {
      return Response()->json([
        'status'=>0,
        'pid' => 'store',               
        'message' => [$e->getMessage()]
      ], 422); 
    }
  }
  /**
   * ubah data
   */
  public function update(Request $request, $id)
  {
    $this->hasPermissionTo('KEMAHASISWAAN-PINDAH-KELAS_UPDATE');
    
    $data = PindahKelasModel::find($id); 

    if (is_null($data))
    {
        return Response()->json([
                                'status'=>0,
                                'pid' => 'update',    
                                'message' => ["Data Pindah Kelas dengan ($id) gagal diupdate"]
                            ], 422); 
    }
    else
    {

      $this->validate($request, [      
        'idkelas_baru' => 'required',
      ]);

      try
      {
        $bool = \DB::table('pe3_dulang')
              ->where('user_id', $data->user_id)
              ->where('idsmt', $data->idsmt)
              ->where('tahun', $data->tahun)
              ->exists();         
              
        if ($bool) {
          $semester = HelperAkademik::getSemester($idsmt);
          throw new Exception ("Menghapus tidak bisa dilakukan karena sudah daftar ulang semester $semester T.A $tahun.");  
        }
        $data = \DB::transaction(function () use ($request, $data) {
          $data_mhs = RegisterMahasiswaModel::find($data->user_id);  
          $data_mhs->idkelas =  $request->input('idkelas_baru');
          $data_mhs->save();

          $data->idkelas_baru = $request->input('idkelas_baru');
          $data->descr = $request->input('descr');
          $data->save();

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
                ->join('pe3_formulir_pendaftaran', 'pe3_formulir_pendaftaran.user_id', 'pe3_pindah_kelas.user_id')
                ->join('pe3_kelas AS A', 'A.idkelas', 'pe3_pindah_kelas.idkelas_lama')
                ->join('pe3_kelas AS B', 'B.idkelas', 'pe3_pindah_kelas.idkelas_baru')
                ->where('pe3_pindah_kelas.id', $data->id)
                ->first();
                
        return Response()->json([
                                'status' => 1,
                                'pid' => 'update',  
                                'pindahkelas' => $pindahkelas,
                                'message' => 'Mahasiswa yang pindah kelas berhasil dilakukan.'
                              ], 200);    
      }
      catch (Exception $e)
      {
        return Response()->json([
          'status'=>0,
          'pid' => 'update',               
          'message' => [$e->getMessage()]
        ], 422); 
      }     
    }
  }
  public function destroy(Request $request,$id)
  { 
    $this->hasPermissionTo('KEMAHASISWAAN-PINDAH-KELAS_DESTROY');    

    $pindahkelas = PindahKelasModel::find($id); 
    
    if (is_null($pindahkelas))
    {
        return Response()->json([
                                'status'=>0,
                                'pid' => 'destroy',    
                                'message' => ["Data Pindah Kelas dengan ($id) gagal dihapus"]
                            ], 422); 
    }
    else
    {
      try
      {
        $bool = \DB::table('pe3_dulang')
              ->where('user_id', $pindahkelas->user_id)
              ->where('idsmt', $pindahkelas->idsmt)
              ->where('tahun', $pindahkelas->tahun)
              ->exists();         

        if ($bool) {
          $semester = HelperAkademik::getSemester($idsmt);
          throw new Exception ("Menghapus tidak bisa dilakukan karena sudah daftar ulang semester $semester T.A $tahun.");  
        }
        
        \DB::transaction(function () use ($request, $pindahkelas) {
          $data_mhs = RegisterMahasiswaModel::find($pindahkelas->user_id);        
          $data_mhs->idkelas = $pindahkelas->idkelas_lama;
          $data_mhs->save();
          $pindahkelas->delete();
          \App\Models\System\ActivityLog::log($request, [
            'object' => $pindahkelas, 
            'object_id' => $pindahkelas->id, 
            'user_id' => $this->getUserid(), 
            'message' => 'Menghapus Pindah Kelas dengan id ('.$pindahkelas->id.') berhasil'
          ]);
        });
        return Response()->json([
                                  'status' => 1,
                                  'pid' => 'destroy',    
                                  'message'=>"Data Pindah Kelas dengan ID ($id) berhasil dihapus"
                              ], 200);    
      }
      catch (Exception $e)
      {
        return Response()->json([
          'status'=>0,
          'pid' => 'destroy',               
          'message' => [$e->getMessage()]
        ], 422); 
      }        
    }
                
  }

}