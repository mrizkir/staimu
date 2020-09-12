<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ramsey\Uuid\Uuid;
use Illuminate\Validation\Rule;

class SystemMigrationController extends Controller {    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $this->hasPermissionTo('SYSTEM-MIGRATION_BROWSE');

        $this->validate($request, [           
            'TA'=>'required',            
        ]);
        
        $ta=$request->input('TA');
        $daftar_tasmt=[];
        
        for ($tahun=$ta;$tahun < 2020; $tahun++)
        {
            $daftar_tasmt[]=[
                'id'=>$tahun.'1',
                'ta'=>$tahun.'/'.($tahun+1),
                'semester'=>'GANJIL',
            ];   
            $daftar_tasmt[]=[
                'id'=>$tahun.'2',
                'ta'=>$tahun.'/'.($tahun+1),
                'semester'=>'GENAP',
            ];   
        }        
        return Response()->json([
                                'status'=>1,
                                'pid'=>'fetchdata',
                                'daftar_tasmt'=>$daftar_tasmt,
                                'message'=>'Fetch data daftar tahun semester berhasil diperoleh'
                            ],200); 
    }
    public function store(Request $request)
    {
        $this->hasPermissionTo('SYSTEM-MIGRATION_STORE');
        
        $this->validate($request, [
            'nim'=>'required|numeric|unique:pe3_register_mahasiswa,nim',        
            'nirm'=>'required|numeric|unique:pe3_register_mahasiswa,nirm',
            'nama_mhs'=>'required',            
            'dosen_id'=>[
                'required',
                Rule::exists('pe3_dosen','user_id')->where(function($query){
                    return $query->where('is_dw',1);
                })
            ],
            'prodi_id'=>'required|numeric',            
            'idkelas'=>'required',
            'status_mhs'=>'required',                        
        ]);
        
        return Response()->json([
                                'status'=>1,
                                'pid'=>'store',                                
                                'message'=>'Proses migrasi mahasiswa ini berhasil dilakukan, silahkan cek dimasing-masing halaman'
                            ],200);
    }
}
