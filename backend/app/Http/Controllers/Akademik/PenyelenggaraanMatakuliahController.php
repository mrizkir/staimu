<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Akademik\PenyelenggaraanMatakuliahModel;

use Ramsey\Uuid\Uuid;

class PenyelenggaraanMatakuliahController extends Controller
{
    /**
     * daftar penyelenggaraan
     */
    public function index(Request $request)
    {
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-PENYELENGGARAAN_BROWSE');

        $this->validate($request, [
            'ta'=>'required',
            'semester_akademik'=>'required',
            'prodi_id'=>'required'
        ]);

        $ta=$request->input('ta');
        $prodi_id=$request->input('prodi_id');
        $semester_akademik=$request->input('semester_akademik');

        $penyelenggaraan=PenyelenggaraanMatakuliahModel::select(\DB::raw('
                                                            id,
                                                            kmatkul,
                                                            nmatkul,                                                            
                                                            sks,       
                                                            semester,
                                                            ta_matkul,                                                                                                                 
                                                            0 AS jumlah_dosen,
                                                            0 AS jumlah_mhs
                                                        '))
                                                        ->where('tahun',$ta)
                                                        ->where('idsmt',$semester_akademik)
                                                        ->where('kjur',$prodi_id)
                                                        ->orderBy('semester','ASC')                      
                                                        ->orderBy('kmatkul','ASC')    
                                                        ->orderBy('ta_matkul','ASC')    
                                                        ->get();
      
        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata',  
                                    'penyelenggaraan'=>$penyelenggaraan,                                                                                                                                   
                                    'message'=>'Fetch data penyelenggaraan matakuliah berhasil.'
                                ],200); 
    }
    /**
     * simpan
     */
    public function store(Request $request)
    {
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-PENYELENGGARAAN_STORE');

        $matkul_selected=json_decode($request->input('matkul_selected'),true);
        $request->merge(['matkul_selected'=>$matkul_selected]);

        $this->validate($request, [            
            'ta'=>'required',
            'semester_akademik'=>'required',
            'prodi_id'=>'required',   
            'matkul_selected.*'=>'required',                   
        ]);
        $ta=$request->input('ta');
        $prodi_id=$request->input('prodi_id');
        $semester_akademik=$request->input('semester_akademik');

        $daftar_matkul=[];
        foreach ($matkul_selected as $v)
        {
            $daftar_matkul[]=[
                'id'=>Uuid::uuid4()->toString(),
                'matkul_id'=>$v['id'],
                'kmatkul'=>$v['kmatkul'],
                'nmatkul'=>$v['nmatkul'],
                'sks'=>$v['sks'],
                'semester'=>$v['semester'],
                'ta_matkul'=>$v['ta'],
                'idsmt'=>$semester_akademik,
                'tahun'=>$ta,
                'kjur'=>$prodi_id,
            ];
        }
        PenyelenggaraanMatakuliahModel::insert($daftar_matkul);

        return Response()->json([
                                'status'=>1,
                                'pid'=>'store',                    
                                'matkul_selected'=>$matkul_selected,                                            
                                'message'=>'Penyelenggaraan matakuliah berhasil ditambahkan.'
                            ],200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    { 
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-PENYELENGGARAAN_DESTROY');

        $penyelenggaraan = PenyelenggaraanMatakuliahModel::find($id); 
        
        if (is_null($penyelenggaraan))
        {
            return Response()->json([
                                    'status'=>1,
                                    'pid'=>'destroy',                
                                    'message'=>["Penyelenggaraan dengan ($id) gagal dihapus"]
                                ],422); 
        }
        else
        {
            \App\Models\System\ActivityLog::log($request,[
                                                                'object' => $penyelenggaraan, 
                                                                'object_id' => $penyelenggaraan->id, 
                                                                'user_id' => $this->getUserid(), 
                                                                'message' => 'Menghapus penyelenggaraan matakuliah dengan id ('.$id.') berhasil'
                                                            ]);
            $penyelenggaraan->delete();
            return Response()->json([
                                        'status'=>1,
                                        'pid'=>'destroy',                
                                        'message'=>"Penyelenggaraan dengan ID ($id) berhasil dihapus"
                                    ],200);         
        }
                  
    }
}
