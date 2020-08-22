<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Akademik\MatakuliahModel;

class MatakuliahController extends Controller {  
    /**
     * daftar matakuliah
     */
    public function index(Request $request)
    {
        $matakuliah=MatakuliahModel::select(\DB::raw('
                                    id,
                                    group_alias,                                    
                                    kmatkul,
                                    nmatkul,
                                    sks,
                                    semester,
                                    minimal_nilai,
                                    syarat_skripsi,
                                    status
                                '))                                
                                ->get();

        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata',  
                                    'matakuliah'=>$matakuliah,                                                                                                                                   
                                    'message'=>'Fetch data matakuliah berhasil.'
                                ],200);     
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
        
        $rule=[            
            'kode_prodi'=>'required|numeric|unique:pe3_prodi',
            'nama_prodi'=>'required|string|unique:pe3_prodi',            
            'nama_prodi_alias'=>'required|string|unique:pe3_prodi',            
            'kode_jenjang'=>'required|exists:pe3_jenjang_studi,kode_jenjang',            
            'nama_jenjang'=>'required',            
        ];
    
        $this->validate($request, $rule);
             
        $matakuliah=MatakuliahModel::create([
            'kode_prodi'=>$request->input('kode_prodi'),
            'kode_fakultas'=>$kode_fakultas,
            'nama_prodi'=>$request->input('nama_prodi'),            
            'nama_prodi_alias'=>$request->input('nama_prodi_alias'),            
            'kode_jenjang'=>$request->input('kode_jenjang'),            
            'nama_jenjang'=>$request->input('nama_jenjang'),            
        ]);                      
        
        \App\Models\System\ActivityLog::log($request,[
                                        'object' => $matakuliah,
                                        'object_id'=>$matakuliah->id, 
                                        'user_id' => $this->guard()->user()->id, 
                                        'message' => 'Menambah matakuliah baru berhasil'
                                    ]);

        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'store',
                                    'matakuliah'=>$matakuliah,                                    
                                    'message'=>'Data matakuliah berhasil disimpan.'
                                ],200); 

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

        $matakuliah = MatakuliahModel::find($id);
        if (is_null($matakuliah))
        {
            return Response()->json([
                                    'status'=>1,
                                    'pid'=>'update',                
                                    'message'=>["Kode matakuliah ($id) gagal diupdate"]
                                ],422); 
        }
        else
        {
         
            $this->validate($request, [
                                        'kode_prodi'=>[
                                                        'required',                                                        
                                                        'numeric'                                                       
                                                    ],           
                                        
                                        'nama_prodi'=>[
                                                        'required',
                                                        'string',
                                                        Rule::unique('pe3_prodi')->ignore($matakuliah->nama_prodi,'nama_prodi')
                                                    ],           
                                        'nama_prodi_alias'=>[
                                                        'required',
                                                        'string',
                                                        Rule::unique('pe3_prodi')->ignore($matakuliah->nama_prodi_alias,'nama_prodi_alias')
                                                    ],  
                                                    
                                        'kode_jenjang'=>'required|exists:pe3_jenjang_studi,kode_jenjang',            
                                        'nama_jenjang'=>'required',            
                                        
                                    ]); 
                                   
            $matakuliah->kode_fakultas = $request->input('kode_fakultas');
            $matakuliah->kode_prodi = $request->input('kode_prodi');
            $matakuliah->nama_prodi = $request->input('nama_prodi');            
            $matakuliah->nama_prodi_alias = $request->input('nama_prodi_alias');            
            $matakuliah->kode_jenjang = $request->input('kode_jenjang');            
            $matakuliah->nama_jenjang = $request->input('nama_jenjang');            
            $matakuliah->save();

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
                                                        'object' => $matakuliah,
                                                        'object_id'=>$matakuliah->id, 
                                                        'user_id' => $this->getUserid(), 
                                                        'message' => 'Mengubah data matakuliah ('.$matakuliah->nama_prodi.') berhasil'
                                                    ]);

            return Response()->json([
                                    'status'=>1,
                                    'pid'=>'update',
                                    'matakuliah'=>$matakuliah,      
                                    'message'=>'Data matakuliah '.$matakuliah->username.' berhasil diubah.'
                                ],200); 
        }
    }
    /**
     * daftar matakuliah
     */
    public function programstudi(Request $request,$id)
    {
        $matakuliah=MatakuliahModel::find($id);
        if (is_null($matakuliah))
        {
            return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata',                
                                    'message'=>["Fetch data matakuliah berdasarkan id matakuliah gagal"]
                                ],422); 
        }
        else
        {
            $programstudi = $matakuliah->programstudi;
            return Response()->json([
                                        'status'=>1,
                                        'pid'=>'fetchdata',  
                                        'programstudi'=>$programstudi,                                                                                                                                   
                                        'message'=>'Fetch data matakuliah berdasarkan id matakuliah berhasil.'
                                    ],200);     

        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    { 
        $this->hasPermissionTo('DMASTER-PRODI_DESTROY');

        $matakuliah = MatakuliahModel::find($id); 
        
        if (is_null($matakuliah))
        {
            return Response()->json([
                                    'status'=>1,
                                    'pid'=>'destroy',                
                                    'message'=>["Kode matakuliah ($id) gagal dihapus"]
                                ],422); 
        }
        else
        {
            \App\Models\System\ActivityLog::log($request,[
                                                                'object' => $matakuliah, 
                                                                'object_id' => $matakuliah->kode_prodi, 
                                                                'user_id' => $this->guard()->user()->id, 
                                                                'message' => 'Menghapus Kode matakuliah ('.$id.') berhasil'
                                                            ]);
            $matakuliah->delete();
            return Response()->json([
                                        'status'=>1,
                                        'pid'=>'destroy',                
                                        'message'=>"matakuliah dengan kode ($id) berhasil dihapus"
                                    ],200);         
        }
                  
    }
}