<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Akademik\PenyelenggaraanMatakuliahModel;
use App\Models\Akademik\PenyelenggaraanDosenModel;
use App\Models\UserDosen;

use Ramsey\Uuid\Uuid;

class PenyelenggaraanKRSController extends Controller
{
    /**
     * daftar penyelenggaraan
     */
    public function index(Request $request)
    {
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-KRS_BROWSE');

        $this->validate($request, [
            'ta'=>'required',
            'semester_akademik'=>'required',
            'prodi_id'=>'required'
        ]);

        $ta=$request->input('ta');
        $prodi_id=$request->input('prodi_id');
        $semester_akademik=$request->input('semester_akademik');

        
    }
    public function show ($request,$id)
    {
        
    }
    public function cekkrs ($request)
    {
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-KRS_SHOW');

        $this->validate($request, [      
            'nim'=>'required|exists:pe3_register_mahasiswa,nim',     
            'ta'=>'required',
            'idsmt'=>'required'
        ]);
        
        $isdulang = KRSModel::where('nim',$nim)
                                ->where('tahun',$ta)
                                ->where('idsmt',$idsmt)                                
                                ->exists();

        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata',  
                                    'iskrs'=>$iskrs,                                                                                                                                   
                                    'message'=>'Cek krs mahasiswa'
                                ],200);  

    }
}
