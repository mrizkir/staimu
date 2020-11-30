<?php

namespace App\Http\Controllers\Akademik;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Akademik\RegisterMahasiswaModel;
use App\Models\Akademik\RekapTranskripKurikulumModel;
use App\Models\Akademik\MatakuliahModel;

use App\Models\System\ConfigurationModel;

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
                                COALESCE(pe3_rekap_transkrip_kurikulum.jumlah_matkul,0) AS jumlah_matkul,
                                COALESCE(pe3_rekap_transkrip_kurikulum.jumlah_sks,0) AS jumlah_sks,
                                COALESCE(pe3_rekap_transkrip_kurikulum.ipk,0.00) AS ipk                               
                            '))
                            ->join('pe3_formulir_pendaftaran','pe3_register_mahasiswa.user_id','pe3_formulir_pendaftaran.user_id')                                                    
                            ->leftJoin('pe3_rekap_transkrip_kurikulum','pe3_rekap_transkrip_kurikulum.user_id','pe3_register_mahasiswa.user_id')
                            ->where('pe3_register_mahasiswa.kjur',$prodi_id)                            
                            ->where('pe3_register_mahasiswa.tahun',$ta)                            
                            ->orderBy('nama_mhs','asc')
                            ->get();        
         
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
                                                \'-\' AS M                                              
                                            '))
                                            ->where('kjur',$mahasiswa->kjur)
                                            ->where('ta',$mahasiswa->tahun)   
                                            ->orderBy('semester','ASC')                      
                                            ->orderBy('kmatkul','ASC')    
                                            ->get();

            $jumlah_sks=0;            
            $jumlah_sks_nilai=0;            
            $jumlah_am=0;
            $jumlah_m=0;
            $jumlah_matkul=0;

            $daftar_nilai=[];
            foreach ($daftar_matkul as $key=>$item)
            {
                $user_id=$mahasiswa->user_id;
                $nilai=\DB::table('pe3_nilai_matakuliah AS A')
                            ->select(\DB::raw('
                                A.n_kual,                                
                                A.n_mutu
                            '))
                            ->join('pe3_krsmatkul AS B','A.krsmatkul_id','B.id')
                            ->join('pe3_krs AS C','B.krs_id','C.id')
                            ->join('pe3_penyelenggaraan AS D','A.penyelenggaraan_id','D.id')
                            ->where('C.user_id',$mahasiswa->user_id)
                            ->where('D.matkul_id',$item->id)
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
                    $jumlah_matkul+=1;
                    $jumlah_sks_nilai+=$item->sks;
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
            $ipk=\App\Helpers\HelperAkademik::formatIPK($jumlah_m,$jumlah_sks_nilai);
            // $ipk=number_format(($jumlah_m/$jumlah_sks_nilai)*100,0,'.','.');
            $rekap=RekapTranskripKurikulumModel::find($mahasiswa->user_id);
            if (is_null($rekap))
            {

                RekapTranskripKurikulumModel::updateOrCreate([
                    'user_id'=>$mahasiswa->user_id,
                    'jumlah_matkul'=>$jumlah_matkul,
                    'jumlah_sks'=>$jumlah_sks_nilai,
                    'jumlah_am'=>$jumlah_am,
                    'jumlah_m'=>$jumlah_m,
                    'ipk'=>$ipk,
                ]);   
            }
            else
            {
                $rekap->jumlah_matkul=$jumlah_matkul;
                $rekap->jumlah_sks=$jumlah_sks_nilai;
                $rekap->jumlah_am=$jumlah_am;
                $rekap->jumlah_m=$jumlah_m;
                $rekap->ipk=$ipk;

                $rekap->save();
            }
           
            return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata', 
                                    'mahasiswa'=>$mahasiswa, 
                                    'nilai_matakuliah'=>$daftar_nilai,              
                                    'jumlah_sks'=>$jumlah_sks,              
                                    'jumlah_sks_nilai'=>$jumlah_sks_nilai,              
                                    'jumlah_am'=>$jumlah_am,              
                                    'jumlah_m'=>$jumlah_m,              
                                    'ipk'=>$ipk,
                                    'message'=>"Transkrip Nilai ($id) berhasil dihapus"
                                ],200); 
        }
    }
    public function printpdf(Request $request,$id)
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
                                                \'-\' AS M                                              
                                            '))
                                            ->where('kjur',$mahasiswa->kjur)
                                            ->where('ta',$mahasiswa->tahun)   
                                            ->orderBy('semester','ASC')                      
                                            ->orderBy('kmatkul','ASC')    
                                            ->get();

            $jumlah_sks=0;            
            $jumlah_sks_nilai=0;            
            $jumlah_am=0;
            $jumlah_m=0;
            $jumlah_matkul=0;

            $daftar_nilai=[];
            foreach ($daftar_matkul as $key=>$item)
            {
                $user_id=$mahasiswa->user_id;
                $nilai=\DB::table('pe3_nilai_matakuliah AS A')
                            ->select(\DB::raw('
                                A.n_kual,                                
                                A.n_mutu
                            '))
                            ->join('pe3_krsmatkul AS B','A.krsmatkul_id','B.id')
                            ->join('pe3_krs AS C','B.krs_id','C.id')
                            ->join('pe3_penyelenggaraan AS D','A.penyelenggaraan_id','D.id')
                            ->where('C.user_id',$mahasiswa->user_id)
                            ->where('D.matkul_id',$item->id)
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
                    $jumlah_matkul+=1;
                    $jumlah_sks_nilai+=$item->sks;
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
            $ipk=\App\Helpers\Helper::formatPersen($jumlah_m,$jumlah_sks_nilai);
            $rekap=RekapTranskripKurikulumModel::find($mahasiswa->user_id);
            if (is_null($rekap))
            {

                RekapTranskripKurikulumModel::updateOrCreate([
                    'user_id'=>$mahasiswa->user_id,
                    'jumlah_matkul'=>$jumlah_matkul,
                    'jumlah_sks'=>$jumlah_sks_nilai,
                    'jumlah_am'=>$jumlah_am,
                    'jumlah_m'=>$jumlah_m,
                    'ipk'=>$ipk,
                ]);   
            }
            else
            {
                $rekap->jumlah_matkul=$jumlah_matkul;
                $rekap->jumlah_sks=$jumlah_sks_nilai;
                $rekap->jumlah_am=$jumlah_am;
                $rekap->jumlah_m=$jumlah_m;
                $rekap->ipk=$ipk;

                $rekap->save();
            }

            $config = ConfigurationModel::getCache();
            $headers=[
                'HEADER_1'=>$config['HEADER_1'],
                'HEADER_2'=>$config['HEADER_2'],
                'HEADER_3'=>$config['HEADER_3'],
                'HEADER_4'=>$config['HEADER_4'],
                'HEADER_LOGO'=>\App\Helpers\Helper::public_path("images/logo.png")
            ];
            $pdf = \Meneses\LaravelMpdf\Facades\LaravelMpdf::loadView('report.ReportTranskripKurikulum',
                                                                    [
                                                                        'headers'=>$headers,
                                                                        'mahasiswa'=>$mahasiswa,
                                                                        'daftar_nilai'=>$daftar_nilai,                                                                        
                                                                        'jumlah_sks'=>$jumlah_sks,
                                                                        'jumlah_am'=>$jumlah_am,
                                                                        'jumlah_m'=>$jumlah_m,
                                                                        'jumlah_matkul'=>$jumlah_matkul,
                                                                        'ipk'=>$ipk,
                                                                    ],
                                                                    [],
                                                                    [
                                                                        'title' => 'Transkrip Kurikulum',
                                                                    ]);

            $file_pdf=\App\Helpers\Helper::public_path("exported/pdf/tk_".$mahasiswa->user_id.'.pdf');
            $pdf->save($file_pdf);

            $pdf_file="storage/exported/pdf/tk_".$mahasiswa->user_id.".pdf";

            return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata',
                                    'mahasiswa'=>$mahasiswa,
                                    'pdf_file'=>$pdf_file                                    
                                ],200);
        }
    }
}