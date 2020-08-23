<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Akademik\GroupMatakuliahModel;
use App\Models\Akademik\MatakuliahModel;

use Ramsey\Uuid\Uuid;

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
        $this->hasPermissionTo('AKADEMIK-MATAKULIAH_STORE');

        $kjur=$request->input('kjur');
        $ta=$request->input('ta');

        $rule=[            
            'id_group'=>'required',
            'kmatkul'=>[
                'required',
                Rule::unique('pe3_matakuliah')->where(function ($query) use ($ta,$kjur) {
                    $query->where('ta', $ta)
                        ->where('kjur',$kjur);
                })
            ],
            'nmatkul'=>[
                'required',
                Rule::unique('pe3_matakuliah')->where(function ($query) use ($ta,$kjur) {
                    $query->where('ta', $ta)
                        ->where('kjur',$kjur);
                })
            ],
            'sks'=>'required|numeric',            
            'semester'=>'required|numeric',            
            'sks_tatap_muka'=>'required|numeric',            
            'minimal_nilai'=>'required',            
            'ta'=>'required',            
            'kjur'=>'required',  
        ];
    
        $this->validate($request, $rule);
        
        $id_group=$request->input('id_group');
        $nama_group=$request->input('nama_group');
        $group_alias=$request->input('group_alias');

        $group_matakuliah=GroupMatakuliahModel::find($id_group);
        if(!is_null($group_matakuliah))
        {
            $nama_group=$group_matakuliah->nama_group;
            $group_alias=$group_matakuliah->group_alias;
        }

        $matakuliah=MatakuliahModel::create([
            'id'=>Uuid::uuid4()->toString(),
            'id_group'=>$id_group,
            'nama_group'=>$nama_group,
            'group_alias'=>$group_alias,
            'kmatkul'=>strtoupper($request->input('kmatkul')),
            'nmatkul'=>ucwords($request->input('nmatkul')),            
            'sks'=>$request->input('sks'),            
            'idkonsentrasi'=>$request->input('idkonsentrasi'),            
            'ispilihan'=>$request->input('ispilihan'),            
            'islintas_prodi'=>$request->input('islintas_prodi'),            
            'semester'=>$request->input('semester'),            
            'sks_tatap_muka'=>$request->input('sks_tatap_muka'),            
            'sks_praktikum'=>$request->input('sks_praktikum'),            
            'sks_praktik_lapangan'=>$request->input('sks_praktik_lapangan'),            
            'minimal_nilai'=>$request->input('minimal_nilai'),            
            'syarat_skripsi'=>$request->input('syarat_skripsi'),            
            'status'=>$request->input('status'),            
            'ta'=>$request->input('ta'),            
            'kjur'=>$request->input('kjur'),            
        ]);                      
        
        \App\Models\System\ActivityLog::log($request,[
                                        'object' => $matakuliah,
                                        'object_id'=>$matakuliah->id, 
                                        'user_id' => $this->getUserid(), 
                                        'message' => 'Menambah matakuliah baru berhasil'
                                    ]);

        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'store',
                                    'post'=>$request->all(),
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
        $this->hasPermissionTo('AKADEMIK-MATAKULIAH_UPDATE');

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    { 
        $this->hasPermissionTo('AKADEMIK-MATAKULIAH_DESTROY');

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
                                                                'object_id' => $matakuliah->id, 
                                                                'user_id' => $this->getUserid(), 
                                                                'message' => 'Menghapus matakuliah dengan id ('.$id.') berhasil'
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