<?php

namespace App\Http\Controllers\DMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\DMaster\ProgramStudiModel;
use App\Models\DMaster\ProgramStudiDetail1Model;
use App\Models\DMaster\JenjangStudiModel;
use App\Models\System\ConfigurationModel;

class ProgramStudiController extends Controller 
{  
  /**
   * daftar program studi
   */
  public function index(Request $request)
  {
    $prodi=ProgramStudiModel::select(\DB::raw('id,kode_prodi,nama_prodi,CONCAT(nama_prodi,\' (\',nama_jenjang,\')\') AS nama_prodi2,nama_prodi_alias,kode_jenjang,nama_jenjang,pe3_fakultas.kode_fakultas,nama_fakultas,pe3_prodi.config'))
      ->leftJoin('pe3_fakultas', 'pe3_fakultas.kode_fakultas', 'pe3_prodi.kode_fakultas')
      ->get();

    return Response()->json([
      'status' => 1,
      'pid' => 'fetchdata',
      'prodi' => $prodi,
      'message' => 'Fetch data program studi berhasil.'
    ], 200);
  }
  /**
   * detail program studi
   */
  public function show(Request $request, $id)
  {
    $prodi = ProgramStudiModel::select(\DB::raw('id,kode_prodi,nama_prodi,CONCAT(nama_prodi,\' (\',nama_jenjang,\')\') AS nama_prodi2,nama_prodi_alias,kode_jenjang,nama_jenjang,pe3_fakultas.kode_fakultas,nama_fakultas,pe3_prodi.config'))
    ->leftJoin('pe3_fakultas', 'pe3_fakultas.kode_fakultas', 'pe3_prodi.kode_fakultas')
    ->where('pe3_prodi.id',$id)
    ->first();

    if (is_null($prodi))
    {
      return Response()->json([
        'status'=>0,
        'pid' => 'fetchdata',
        'message' => ["Kode Program Studi ($id) gagal diperoleh"]
      ], 422); 
    }
    else
    {
      return Response()->json([
        'status' => 1,
        'pid' => 'fetchdata',
        'prodi' => $prodi,
        'message' => 'Fetch data program studi berhasil.'
      ], 200);
    }        
  }
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->hasPermissionTo('DMASTER-PRODI_STORE');

    $bentuk_pt=ConfigurationModel::getCache('BENTUK_PT');
    if ($bentuk_pt=='sekolahtinggi')
    {
      $rule = [            
        'kode_prodi' => 'required|numeric|unique:pe3_prodi',
        'nama_prodi' => 'required|string|unique:pe3_prodi',
        'nama_prodi_alias' => 'required|string|unique:pe3_prodi',
        'kode_jenjang' => 'required|exists:pe3_jenjang_studi,kode_jenjang',
        'nama_jenjang' => 'required',
      ];
      $kode_fakultas=null;
    }
    else
    {
      $rule = [            
        'kode_prodi' => 'required|numeric',
        'kode_fakultas' => 'required|exists:pe3_fakultas,kode_fakultas',
        'nama_prodi' => 'required|string|unique:pe3_prodi',
        'nama_prodi_alias' => 'required|string|unique:pe3_prodi',
        'kode_jenjang' => 'required|exists:pe3_jenjang_studi,kode_jenjang',
        'nama_jenjang' => 'required',
      ];
      $kode_fakultas = $request->input('kode_fakultas');
    }
    $this->validate($request, $rule);
       
    $prodi=ProgramStudiModel::create([
      'kode_prodi' => $request->input('kode_prodi'),
      'kode_fakultas' => $kode_fakultas,
      'nama_prodi' => $request->input('nama_prodi'),
      'nama_prodi_alias' => $request->input('nama_prodi_alias'),
      'kode_jenjang' => $request->input('kode_jenjang'),
      'nama_jenjang' => $request->input('nama_jenjang'),
    ]);                 
    
    \App\Models\System\ActivityLog::log($request,[
      'object' => $prodi,
      'object_id' => $prodi->id, 
      'user_id' => $this->getUserid(), 
      'message' => 'Menambah program studi baru berhasil'
    ]);

    return Response()->json([
      'status' => 1,
      'pid' => 'store',
      'prodi' => $prodi,
      'message' => 'Data program studi berhasil disimpan.'
    ], 200); 

  }
  /**
   * digunakan untuk mendapatkan daftar jenjang studi program studi
   */
  public function jenjangstudi ()
  {
    $jenjangstudi = JenjangStudiModel::all();
    return Response()->json([
      'status' => 1,
      'pid' => 'fetchdata',
      'jenjangstudi' => $jenjangstudi,
      'message' => 'Jenjang studi berhasil diperoleh.'
    ], 200);
  }
  /**
   * ubah kaprodi
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function updateconfig (Request $request, $id)
  {
    $this->hasPermissionTo('DMASTER-PRODI_UPDATE');

    $prodi = ProgramStudiModel::find($id);
    if (is_null($prodi))
    {
      return Response()->json([
        'status'=>0,
        'pid' => 'update',
        'message' => ["Kode Program Studi ($id) gagal diupdate"]
      ], 422); 
    }
    else
    {
      $this->validate($request,[
        'config' => 'required'
      ]);			
      $prodi->config=$request->input('config');
      $prodi->save();
      return Response()->json([
        'status' => 1,
        'pid' => 'update',
        'prodi' => $prodi,
        'message' => 'Konfigurasi program studi ' . $prodi->nama_prodi. ' berhasil disimpan.'
      ], 200);
    }
  }
  /**
   * detail jumlah sks lulus dari program studi
   */
  public function skslulus(Request $request, $id)
  {
    $skslulus = ProgramStudiDetail1Model::where('prodi_id',$id)
    ->orderBy('ta', 'desc')
    ->get();

    return Response()->json([
      'status' => 1,
      'pid' => 'fetchdata',
      'skslulus' => $skslulus,
      'message' => 'Fetch data sks lulus program studi berhasil.'
    ], 200);
    
  }
  /**
   * detail jumlah matakuliah skripsi dari program studi
   */
  public function matkulskripsi(Request $request, $id)
  {
    $matkulskripsi = ProgramStudiDetail1Model::select(\DB::raw('
                        pe3_prodi_detail1.id,
                        pe3_prodi_detail1.ta,
                        CASE 
                          WHEN pe3_matakuliah.nmatkul IS NULL THEN
                            "N.A"
                          ELSE
                            CONCAT("[",pe3_matakuliah.kmatkul,"] ",pe3_matakuliah.nmatkul)
                        END AS matkul_skripsi,    
                        pe3_prodi_detail1.created_at,
                        pe3_prodi_detail1.updated_at
                      '))
                      ->leftJoin('pe3_matakuliah', 'pe3_matakuliah.id', 'pe3_prodi_detail1.matkul_skripsi')
                      ->where('pe3_prodi_detail1.prodi_id',$id)
                      ->orderBy('pe3_prodi_detail1.ta', 'desc')
                      ->get();
    return Response()->json([
                'status' => 1,
                'pid' => 'fetchdata',
                'matkulskripsi' => $matkulskripsi,
                'message' => 'Fetch data matkul skripsi program studi berhasil.'
              ], 200);
    
  }
  public function loadskslulus(Request $request) 
  {
    $this->hasPermissionTo('DMASTER-PRODI_UPDATE');

    $this->validate($request, [
      'prodi_id' => 'required|exists:pe3_prodi,id'
    ]);
    $prodi_id = $request->input('prodi_id');
    $sql = "INSERT INTO pe3_prodi_detail1 (id,matkul_skripsi,jumlah_sks,ta,prodi_id,created_at,updated_at)
    SELECT UUID(),null,0,tahun,$prodi_id,NOW() AS created_at,NOW() AS updated_at FROM pe3_ta WHERE tahun NOT IN (SELECT ta FROM pe3_prodi_detail1 WHERE prodi_id = $prodi_id)";           
    
    \DB::statement($sql);
    
    $matkulskripsi = ProgramStudiDetail1Model::select(\DB::raw('
                        pe3_prodi_detail1.id,
                        pe3_prodi_detail1.ta,
                        CASE 
                          WHEN pe3_matakuliah.nmatkul IS NULL THEN
                            "N.A"
                          ELSE
                            CONCAT("[",pe3_matakuliah.kmatkul,"] ",pe3_matakuliah.nmatkul)
                        END AS matkul_skripsi,    
                        pe3_prodi_detail1.created_at,
                        pe3_prodi_detail1.updated_at
                      '))
                      ->leftJoin('pe3_matakuliah', 'pe3_matakuliah.id', 'pe3_prodi_detail1.matkul_skripsi')
                      ->where('pe3_prodi_detail1.prodi_id',$id)
                      ->orderBy('pe3_prodi_detail1.ta', 'desc')
                      ->get();

    return Response()->json([
                  'status' => 1,
                  'pid' => 'store',
                  'matkulskripsi' => $matkulskripsi,
                  'message' => 'Menyalin data tahun akademik ke program studi detail berhasil.'
                ], 200);
  }
  public function loadmatkulskripsi(Request $request) 
  {
    $this->hasPermissionTo('DMASTER-PRODI_UPDATE');

    $this->validate($request, [
      'prodi_id' => 'required|exists:pe3_prodi,id'
    ]);
    $prodi_id = $request->input('prodi_id');
    $sql = "INSERT INTO pe3_prodi_detail1 (id,matkul_skripsi,jumlah_sks,ta,prodi_id,created_at,updated_at)
    SELECT UUID(),null,0,tahun,$prodi_id,NOW() AS created_at,NOW() AS updated_at FROM pe3_ta WHERE tahun NOT IN (SELECT ta FROM pe3_prodi_detail1 WHERE prodi_id = $prodi_id)";           
    
    \DB::statement($sql);
    
    $skslulus = ProgramStudiDetail1Model::where('prodi_id',$prodi_id)
                      ->orderBy('ta', 'desc')
                      ->get();
    return Response()->json([
                  'status' => 1,
                  'pid' => 'store',
                  'skslulus' => $skslulus,
                  'message' => 'Menyalin data tahun akademik ke program studi detail berhasil.'
                ], 200);
  }
  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $this->hasPermissionTo('DMASTER-PRODI_UPDATE');

    $prodi = ProgramStudiModel::find($id);
    if (is_null($prodi))
    {
      return Response()->json([
                  'status'=>0,
                  'pid' => 'update',
                  'message' => ["Kode Program Studi ($id) gagal diupdate"]
                ], 422); 
    }
    else
    {
      $bentuk_pt=ConfigurationModel::getCache('BENTUK_PT');
      if ($bentuk_pt=='sekolahtinggi')
      {
        $this->validate($request, [
                      'kode_prodi' => [
                              'required',
                              'numeric'                                                       
                            ],
                      
                      'nama_prodi' => [
                              'required',
                              'string',
                              Rule::unique('pe3_prodi')->ignore($prodi->nama_prodi, 'nama_prodi')
                            ],
                      'nama_prodi_alias' => [
                              'required',
                              'string',
                              Rule::unique('pe3_prodi')->ignore($prodi->nama_prodi_alias, 'nama_prodi_alias')
                            ],
                            
                      'kode_jenjang' => 'required|exists:pe3_jenjang_studi,kode_jenjang',
                      'nama_jenjang' => 'required',
                      
                    ]); 
      }
      else
      {
        $this->validate($request, [
          'kode_fakultas' => [
            'required',
            'exists:pe3_fakultas,kode_fakultas',
          ],
          'kode_prodi' => [
            'required',
            'numeric'                                                       
          ],
          
          'nama_prodi' => [
            'required',
            'string',
            Rule::unique('pe3_prodi')->ignore($prodi->nama_prodi, 'nama_prodi')
          ],
          'nama_prodi' => [
            'required',
            'string',
            Rule::unique('pe3_prodi')->ignore($prodi->nama_prodi_alias, 'nama_prodi_alias')
          ],
          'kode_jenjang' => 'required|exists:pe3_jenjang_studi,kode_jenjang',
          'nama_jenjang' => 'required',
          
        ]); 
      }             
      $prodi->kode_fakultas = $request->input('kode_fakultas');
      $prodi->kode_prodi = $request->input('kode_prodi');
      $prodi->nama_prodi = $request->input('nama_prodi');       
      $prodi->nama_prodi_alias = $request->input('nama_prodi_alias');       
      $prodi->kode_jenjang = $request->input('kode_jenjang');       
      $prodi->nama_jenjang = $request->input('nama_jenjang');       
      $prodi->save();

      \DB::table('usersprodi')
        ->where('id',$id)
        ->update([
          'kode_prodi' => $request->input('kode_prodi'),
          'nama_prodi' => $request->input('nama_prodi'),
          'nama_prodi_alias' => $request->input('nama_prodi_alias'),
          'kode_jenjang' => $request->input('kode_jenjang'),
          'nama_jenjang' => $request->input('nama_jenjang'),
        ]);

      \App\Models\System\ActivityLog::log($request,[
        'object' => $prodi,
        'object_id' => $prodi->id, 
        'user_id' => $this->getUserid(), 
        'message' => 'Mengubah data program studi (' . $prodi->nama_prodi. ') berhasil'
      ]);

      return Response()->json([
        'status' => 1,
        'pid' => 'update',
        'prodi' => $prodi,
        'message' => 'Data program studi ' . $prodi->nama_prodi. ' berhasil diubah.'
      ], 200); 
    }
  }
  public function updateskslulus(Request $request)
  {
    $this->hasPermissionTo('DMASTER-PRODI_UPDATE');
    
    $this->validate($request, [           
      'id' => 'required|exists:pe3_prodi_detail1,id',
      'jumlah_sks' => 'required'
    ]);
    $id = $request->input('id');
    $jumlah_sks = $request->input('jumlah_sks');
    
    $detail1=ProgramStudiDetail1Model::find($id);
    $old_sks = $detail1->jumlah_sks;
    $detail1->jumlah_sks = $jumlah_sks;
    $detail1->save();
    
    \App\Models\System\ActivityLog::log($request,[
                            'object' => $detail1,
                            'object_id' => $detail1->id, 
                            'user_id' => $this->getUserid(), 
                            'message' => 'Mengubah jumlah sks ' . $old_sks. ' menjadi ' . $jumlah_sks. ' berhasil dilakukan'
                          ]);
    return Response()->json([
                  'status' => 1,
                  'pid' => 'update',     
                  'jumlah_sks' => $jumlah_sks,                            
                  'message' => 'Mengubah jumlah sks ' . $detail1->jumlah_sks. ' berhasil.'
                ], 200);  
  }
  public function updatematkulskripsi(Request $request)
  {
    $this->hasPermissionTo('DMASTER-PRODI_UPDATE');
    
    $this->validate($request, [           
      'id' => 'required|exists:pe3_prodi_detail1,id',
      'matkul_id' => 'required|exists:pe3_matakuliah,id'
    ]);
    $id = $request->input('id');
    $matkul_id = $request->input('matkul_id');
    
    $detail1=ProgramStudiDetail1Model::find($id);   
    $detail1->matkul_skripsi=$matkul_id;
    $detail1->save();
    
    \App\Models\System\ActivityLog::log($request,[
      'object' => $detail1,
      'object_id' => $detail1->id, 
      'user_id' => $this->getUserid(), 
      'message' => 'Mengubah matakuliah skripsi berhasil dilakukan'
    ]);

    return Response()->json([
      'status' => 1,
      'pid' => 'update',     
      'matkul_id' => $matkul_id,                            
      'message' => 'Mengubah matakuliah skripsi berhasil dilakukan.'
    ], 200);  
  }
  /**
   * daftar program studi
   */
  public function programstudi(Request $request, $id)
  {
    $prodi=ProgramStudiModel::find($id);
    if (is_null($prodi))
    {
      return Response()->json([
        'status'=>0,
        'pid' => 'fetchdata',
        'message' => ["Fetch data program studi berdasarkan id program studi gagal"]
      ], 422); 
    }
    else
    {
      $programstudi = $prodi->programstudi;
      return Response()->json([
      'status' => 1,
      'pid' => 'fetchdata',
      'programstudi' => $programstudi,
      'message' => 'Fetch data program studi berdasarkan id program studi berhasil.'
    ], 200);

    }
  }
  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request, $id)
  { 
    $this->hasPermissionTo('DMASTER-PRODI_DESTROY');

    $prodi = ProgramStudiModel::find($id); 
    
    if (is_null($prodi))
    {
      return Response()->json([
        'status'=>0,
        'pid' => 'destroy',
        'message' => ["Kode program studi ($id) gagal dihapus"]
      ], 422); 
    }
    else if($prodi->formulirpendaftaran1->count() > 0 || $prodi->formulirpendaftaran2->count() > 0)    
    {
      return Response()->json([
        'status'=>0,
        'pid' => 'destroy',
        'message' => ["Kode program studi ($id) gagal dihapus karena terdapat mahasiswa di prodi ini"]
      ], 422); 
    }
    else if($prodi->mahasiswa->count() > 0)
    {
      return Response()->json([
        'status'=>0,
        'pid' => 'destroy',
        'message' => ["Kode program studi ($id) gagal dihapus karena terdapat mahasiswa di prodi ini"]
      ], 422); 
    }    
    else
    {
      \App\Models\System\ActivityLog::log($request,[
        'object' => $prodi, 
        'object_id' => $prodi->kode_prodi, 
        'user_id' => $this->getUserid(), 
        'message' => 'Menghapus Kode Program Studi (' . $id. ') berhasil'
      ]);

      $prodi->delete();

      return Response()->json([
        'status' => 1,
        'pid' => 'destroy',
        'message' => "Program Studi dengan kode ($id) berhasil dihapus"
      ], 200);    
    }
          
  }
}