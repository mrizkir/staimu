<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Akademik\PenyelenggaraanMatakuliahModel;
use App\Models\Akademik\DulangModel;
use App\Models\Akademik\KRSModel;
use App\Models\Akademik\KRSMatkulModel;

use Ramsey\Uuid\Uuid;

class KRSController extends Controller
{
    /**
     * daftar krs
     */
    public function index(Request $request)
    {
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-KRS_BROWSE');
        $daftar_krs=[];

        if ($this->hasRole(['superadmin','akademik','programstudi']))
        {
            $this->validate($request, [
                'ta'=>'required',
                'semester_akademik'=>'required',
                'prodi_id'=>'required'
            ]);

            $ta=$request->input('ta');
            $prodi_id=$request->input('prodi_id');
            $semester_akademik=$request->input('semester_akademik');
        }
        else if ($this->hasRole('mahasiswa'))
        {
            $daftar_krs = KRSModel::select(\DB::raw('
                                    pe3_krs.id,
                                    pe3_krs.nim,
                                    pe3_formulir_pendaftaran.nama_mhs,
                                    pe3_krs.tasmt,
                                    pe3_krs.sah,
                                    pe3_formulir_pendaftaran.ta AS tahun_masuk,
                                    0 AS jumlah_matkul,
                                    0 AS jumlah_sks,
                                    pe3_krs.created_at,
                                    pe3_krs.updated_at
                                '))
                                ->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_krs.user_id')
                                ->where('nim',$this->getUsername())
                                ->orderBy('tasmt','DESC')
                                ->get();

            $daftar_krs->transform(function ($item,$key){
                
                $item->jumlah_matkul=\DB::table('pe3_krsmatkul')->where('krs_id',$item->id)->count();
                $item->jumlah_sks=\DB::table('pe3_krsmatkul')
                                        ->join('pe3_penyelenggaraan','pe3_penyelenggaraan.id','pe3_krsmatkul.penyelenggaraan_id')
                                        ->where('krs_id',$item->id)->sum('pe3_penyelenggaraan.sks');
                return $item;
            });
        }
        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata',  
                                    'daftar_krs'=>$daftar_krs,                                                                                                                                   
                                    'message'=>'Daftar krs mahasiswa berhasil diperoleh' 
                                ],200);  
        
    }
    public function show (Request $request,$id)
    {
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-KRS_SHOW');
        $krs=KRSModel::select(\DB::raw('
                        pe3_krs.id,
                        pe3_krs.nim,
                        pe3_formulir_pendaftaran.nama_mhs,
                        pe3_krs.kjur,
                        pe3_krs.tahun,
                        pe3_krs.idsmt,
                        pe3_krs.tasmt,
                        pe3_krs.sah,
                        pe3_krs.created_at,
                        pe3_krs.updated_at
                    '))
                    ->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_krs.user_id')
                    ->find($id);
        $daftar_matkul=[];

        if (is_null($krs))
        {
            return Response()->json([
                                    'status'=>1,
                                    'pid'=>'destroy',                
                                    'message'=>["KRS dengan ($id) gagal diperoleh"]
                                ],422); 
        }
        else
        {
            $daftar_matkul=KRSMatkulModel::select(\DB::raw('
                                            pe3_krsmatkul.id,
                                            pe3_penyelenggaraan.kmatkul,
                                            pe3_penyelenggaraan.nmatkul,
                                            pe3_penyelenggaraan.sks,
                                            pe3_penyelenggaraan.semester,
                                            pe3_krsmatkul.created_at,
                                            pe3_krsmatkul.updated_at
                                        '))
                                        ->join('pe3_penyelenggaraan','pe3_penyelenggaraan.id','pe3_krsmatkul.penyelenggaraan_id')
                                        ->where('krs_id',$krs->id);
        }
        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata',  
                                    'krs'=>$krs,                                                                                                                                   
                                    'daftar_matkul'=>$daftar_matkul,                                                                                                                                   
                                    'jumlah_matkul'=>$daftar_matkul->count(),                                                                                                                                   
                                    'jumlah_sks'=>$daftar_matkul->sum('sks'),                                                                                                                                   
                                    'message'=>'Fetch data krs dan detail krs mahasiswa berhasil diperoleh' 
                                ],200);  
    }
    /**
     * digunakan untul menyimpan krs mahasiswa
     */
    public function store (Request $request)
    {
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-KRS_STORE');
        
        $this->validate($request, [
            'nim'=>'required|exists:pe3_register_mahasiswa,nim',     
            'dulang_id'=>'required|exists:pe3_dulang,id',     
        ]);
        
        $nim=$request->input('nim');
        $dulang_id=$request->input('dulang_id');

        $dulang = DulangModel::find($dulang_id);

        $krs=KRSModel::create([
            'id'=>Uuid::uuid4()->toString(),
            'user_id'=>$dulang->user_id,
            'dulang_id'=>$dulang_id,
            'nim'=>$nim,
            'kjur'=>$dulang->register_mahasiswa->kjur, 
            'idsmt'=>$dulang->idsmt, 
            'tahun'=>$dulang->tahun, 
            'tasmt'=>$dulang->tasmt,         
            'sah'=>0,        
        ]);
        \App\Models\System\ActivityLog::log($request,[
                                                    'object' => $krs, 
                                                    'object_id' => $krs->id, 
                                                    'user_id' => $this->getUserid(), 
                                                    'message'=>"Menyimpan krs mahasiswa berhasil dilakukan."
                                                ]);
        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'store',  
                                    'krs'=>$krs,                                                                                                                                   
                                    'message'=>'menyimpan krs mahasiswa berhasil'
                                ],200);  
    }
    public function cekkrs ($request)
    {
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-KRS_SHOW');

        $this->validate($request, [      
            'nim'=>'required|exists:pe3_register_mahasiswa,nim',     
            'ta'=>'required',
            'idsmt'=>'required'
        ]);
        
        $nim=$request->input('nim');
        $ta=$request->input('ta');
        $idsmt=$request->input('idsmt');

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
