<?php

namespace App\Http\Controllers\Akademik;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Akademik\RegisterMahasiswaModel;

class TranskripKurikulumController  extends Controller 
{
/**
     * daftar mahasiswa
     */
    public function index(Request $request)
    {
        $this->hasPermissionTo('AKADEMIK-NILAI-TRANSKRIP-KURIKULUM_BROWSE');

        $this->validate($request, [           
            'ta'=>'required',
            'prodi_id'=>'required'
        ]);

        $ta=$request->input('ta');
        $prodi_id=$request->input('prodi_id');
        
        $data = RegisterMahasiswaModel::select(\DB::raw('        
                                pe3_register_mahasiswa.user_id,                                
                                pe3_register_mahasiswa.nim,                                
                                pe3_formulir_pendaftaran.nama_mhs,                                
                                pe3_register_mahasiswa.idkelas,   
                                0 AS jumlah_matkul,
                                0 AS jumlah_sks,
                                0.00 AS ipk
                            '))
                            ->join('pe3_formulir_pendaftaran','pe3_register_mahasiswa.user_id','pe3_formulir_pendaftaran.user_id')                                                    
                            ->where('pe3_register_mahasiswa.kjur',$prodi_id)                            
                            ->where('pe3_register_mahasiswa.tahun',$ta)                            
                            ->orderBy('nama_mhs','desc')
                            ->get();
        
        $data->transform(function ($item,$key) {                
            $nilai=\DB::table('pe3_krs AS A')
                ->select(\DB::raw('
                    COUNT(B.id) AS jumlah_matkul,                    
                    COALESCE(SUM(C.sks),0) AS jumlah_sks
                '))
                ->join('pe3_krsmatkul AS B','A.id','B.krs_id')
                ->join('pe3_penyelenggaraan AS C','B.penyelenggaraan_id','C.id')
                ->join('pe3_nilai_matakuliah AS D','D.krsmatkul_id','B.id')
                ->where('A.user_id',$item->user_id)
                ->get();
            if (isset($nilai[0]))
            {
                $item->jumlah_matkul=$nilai[0]->jumlah_matkul;
                $item->jumlah_sks=$nilai[0]->jumlah_sks;
            }            
            
            return $item;
        });

        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata',  
                                    'mahasiswa'=>$data,                                                                                                                                   
                                    'message'=>'Fetch data daftar mahasiswa berhasil.'
                                ],200);     
    }
    public function show(Request $request,$id)
    {
        $this->hasPermissionTo('AKADEMIK-NILAI-TRANSKRIP-KURIKULUM_SHOW');

        $mahasiswa=RegisterMahasiswaModel::join('pe3_formulir_pendaftaran AS A','A.user_id','pe3_register_mahasiswa.user_id')
                                            ->find($id);
        
        if (is_null($mahasiswa))
        {
            return Response()->json([
                                    'status'=>0,
                                    'pid'=>'destroy',                
                                    'message'=>["Mahasiswa dengan ($id) gagal diperoleh"]
                                ],422); 
        }
        else
        {
            return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata', 
                                    'mahasiswa'=>$mahasiswa,               
                                    'message'=>"Transkrip Nilai ($id) berhasil dihapus"
                                ],200); 
        }
    }
    /**
     * cetak ke excel
     *
     * @return \Illuminate\Http\Response
     */
    public function printtoexcel(Request $request)
    {   
        $this->hasPermissionTo('AKADEMIK-NILAI-TRANSKRIP-KURIKULUM_SHOW');

        $this->validate($request, [           
            'TA'=>'required',
            'prodi_id'=>'required',
            'nama_prodi'=>'required',
        ]);
        
        $data_report=[
            'TA'=>$request->input('TA'),
            'prodi_id'=>$request->input('prodi_id'),            
            'nama_prodi'=>$request->input('nama_prodi'),            
        ];

        $report= new \App\Models\Report\ReportKemahasiswaanModel ($data_report);          
        return $report->daftarmahasiswa();
    }
}