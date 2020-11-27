<?php

namespace App\Http\Controllers\Akademik;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Akademik\RegisterMahasiswaModel;
use App\Models\Akademik\MatakuliahModel;

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

        $mahasiswa=RegisterMahasiswaModel::select(\DB::raw('
                                                A.user_id,
                                                A.nama_mhs,
                                                A.jk,
                                                C.email,
                                                C.nomor_hp,
                                                A.no_formulir,
                                                pe3_register_mahasiswa.nim,
                                                pe3_register_mahasiswa.nirm,
                                                pe3_register_mahasiswa.kjur,
                                                B.nama_prodi,
                                                D.nkelas,
                                                pe3_register_mahasiswa.tahun,
                                                E.n_status,
                                                pe3_register_mahasiswa.created_at,
                                                pe3_register_mahasiswa.updated_at,
                                                C.foto
                                            '))
                                            ->join('pe3_formulir_pendaftaran AS A','A.user_id','pe3_register_mahasiswa.user_id')
                                            ->join('pe3_prodi AS B','B.id','pe3_register_mahasiswa.kjur')                                            
                                            ->join('users AS C','C.id','pe3_register_mahasiswa.user_id')
                                            ->join('pe3_kelas AS D','D.idkelas','pe3_register_mahasiswa.idkelas')
                                            ->join('pe3_status_mahasiswa AS E','E.k_status','pe3_register_mahasiswa.k_status')
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
            $daftar_matkul=MatakuliahModel::select(\DB::raw('
                                                0 AS no,
                                                id,
                                                group_alias,                                    
                                                kmatkul,
                                                nmatkul,
                                                sks,
                                                semester,
                                                \'-\' AS HM,
                                                \'-\' AS AM,
                                                0 AS M                                              
                                            '))
                                            ->where('kjur',$mahasiswa->kjur)
                                            ->where('ta',$mahasiswa->tahun)   
                                            ->orderBy('semester','ASC')                      
                                            ->orderBy('kmatkul','ASC')    
                                            ->get();

            $jumlah_sks=0;            
            $jumlah_am=0;
            $jumlah_m=0;

            $daftar_nila=[];
            foreach ($daftar_matkul as $key=>$item)
            {
                $user_id=$mahasiswa->user_id;
                $nilai=\DB::table('v_nilai')
                            ->select(\DB::raw('
                                n_kual,                                
                                n_mutu
                            '))
                            ->where('user_id',$mahasiswa->user_id)
                            ->where('matkul_id',$item->id)
                            ->get();
                
                $HM=$item->HM;
                $AM=$item->AM;
                $M=$item->M;

                if (isset($nilai[0]))
                {
                    $HM=$nilai[0]->n_kual;
                    $AM=number_format($nilai[0]->n_mutu,0);
                    $M=$AM*$item->sks;
                    $jumlah_m+=$M;
                    $jumlah_am+=$AM;
                }
                $daftar_nilai[]=[
                    'no'=>$key+1,
                    'kmatkul'=>$item->kmatkul,
                    'nmatkul'=>$item->nmatkul,
                    'sks'=>$item->sks,
                    'semester'=>$item->semester,
                    'group_alias'=>$item->group_alias,
                    'HM'=>$HM,
                    'AM'=>$AM,
                    'M'=>$M
                ];

                $jumlah_sks+=$item->sks;  
            }            
            return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata', 
                                    'mahasiswa'=>$mahasiswa, 
                                    'nilai_matakuliah'=>$daftar_nilai,              
                                    'jumlah_sks'=>$jumlah_sks,              
                                    'jumlah_am'=>$jumlah_am,              
                                    'jumlah_m'=>$jumlah_m,              
                                    'ipk'=>\App\Helpers\Helper::formatPecahan($jumlah_am,$jumlah_sks),
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