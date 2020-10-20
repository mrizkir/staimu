<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DMaster\TAModel;
use App\Models\Akademik\RegisterMahasiswaModel;
use App\Models\Keuangan\BiayaKomponenPeriodeModel;
use App\Models\Keuangan\TransaksiModel;
use App\Models\Keuangan\TransaksiDetailModel;

use Exception;

use Ramsey\Uuid\Uuid;

class TransaksiSPPController extends Controller {  
    /**
     * daftar komponen biaya
     */
    public function index(Request $request)
    {
        $this->hasPermissionTo('KEUANGAN-TRANSAKSI-SPP_BROWSE');
        
        $this->validate($request, [           
            'TA'=>'required',
        ]);
        $ta=$request->input('TA');

        if ($this->hasRole(['mahasiswa','mahasiswabaru']))
        {
            $daftar_transaksi = TransaksiDetailModel::select(\DB::raw('
                                                        pe3_transaksi_detail.id,
                                                        pe3_transaksi_detail.user_id,
                                                        pe3_transaksi_detail.transaksi_id,
                                                        pe3_transaksi_detail.no_transaksi,
                                                        pe3_transaksi_detail.biaya,
                                                        pe3_transaksi_detail.jumlah,
                                                        pe3_transaksi_detail.bulan,
                                                        pe3_transaksi_detail.sub_total,

                                                        pe3_formulir_pendaftaran.nama_mhs,

                                                        pe3_transaksi.no_faktur,
                                                        pe3_transaksi.kjur,
                                                        pe3_transaksi.ta,
                                                        pe3_transaksi.idsmt,
                                                        pe3_transaksi.idkelas,
                                                        pe3_transaksi.no_formulir,                                                        
                                                        COALESCE(pe3_transaksi.nim,\'N.A\') AS nim,
                                                        pe3_transaksi.status,
                                                        pe3_status_transaksi.nama_status,
                                                        pe3_status_transaksi.style,
                                                        pe3_transaksi.total,
                                                        pe3_transaksi.tanggal,     
                                                        pe3_transaksi_detail.created_at,
                                                        pe3_transaksi_detail.updated_at
                                                    '))
                                                    ->join('pe3_transaksi','pe3_transaksi_detail.transaksi_id','pe3_transaksi.id')
                                                    ->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_transaksi_detail.user_id')
                                                    ->join('pe3_status_transaksi','pe3_transaksi.status','pe3_status_transaksi.id_status')
                                                    ->where('pe3_transaksi.ta',$ta)
                                                    ->where('pe3_transaksi_detail.user_id',$this->getUserid())
                                                    ->where('pe3_transaksi_detail.kombi_id',201)                                                    
                                                    ->orderBy('pe3_transaksi.tanggal','DESC')
                                                    ->get();
        }
        else
        {
            $daftar_transaksi = TransaksiDetailModel::select(\DB::raw('
                                                        pe3_transaksi_detail.id,
                                                        pe3_transaksi_detail.user_id,
                                                        pe3_transaksi_detail.transaksi_id,
                                                        pe3_transaksi_detail.no_transaksi,
                                                        pe3_transaksi_detail.biaya,
                                                        pe3_transaksi_detail.jumlah,
                                                        pe3_transaksi_detail.bulan,
                                                        pe3_transaksi_detail.sub_total,

                                                        pe3_formulir_pendaftaran.nama_mhs,

                                                        pe3_transaksi.no_faktur,
                                                        pe3_transaksi.kjur,
                                                        pe3_transaksi.ta,
                                                        pe3_transaksi.idsmt,
                                                        pe3_transaksi.idkelas,
                                                        pe3_transaksi.no_formulir,
                                                        pe3_transaksi.nim,
                                                        pe3_transaksi.status,
                                                        pe3_status_transaksi.nama_status,
                                                        pe3_status_transaksi.style,
                                                        pe3_transaksi.total,
                                                        pe3_transaksi.tanggal,     
                                                        pe3_transaksi_detail.created_at,
                                                        pe3_transaksi_detail.updated_at
                                                    '))
                                                    ->join('pe3_transaksi','pe3_transaksi_detail.transaksi_id','pe3_transaksi.id')
                                                    ->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_transaksi_detail.user_id')
                                                    ->join('pe3_status_transaksi','pe3_transaksi.status','pe3_status_transaksi.id_status')
                                                    ->where('pe3_transaksi.ta',$ta)                                                    
                                                    ->where('pe3_transaksi_detail.kombi_id',201)                                                    
                                                    ->orderBy('pe3_transaksi.tanggal','DESC')
                                                    ->get();
        }        
        
        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata',  
                                    'transaksi'=>$daftar_transaksi,                                                                                                                                   
                                    'message'=>'Fetch data daftar transaksi berhasil.'
                                ],200);     
    }
    public function show (Request $request,$id)
    {
        try 
        {
            $transaksi=TransaksiModel::select(\DB::raw('
                                    pe3_transaksi.*,
                                    pe3_formulir_pendaftaran.nama_mhs,
                                    pe3_kelas.nkelas,
                                    pe3_status_transaksi.nama_status,
                                    pe3_status_transaksi.style
                                '))
                                ->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_transaksi.user_id')
                                ->join('pe3_status_transaksi','pe3_transaksi.status','pe3_status_transaksi.id_status')
                                ->join('pe3_kelas','pe3_kelas.idkelas','pe3_transaksi.idkelas')
                                ->find($id);

            if (is_null($transaksi))        
            {
                throw new Exception ("Fetch data transaksi dengan id ($id) gagal diperoleh.");                
            }
            $biaya_kombi=BiayaKomponenPeriodeModel::where('tahun',$transaksi->ta)
                                                    ->where('idkelas',$transaksi->idkelas)
                                                    ->where('kjur',$transaksi->kjur)
                                                    ->where('kombi_id',201)
                                                    ->value('biaya');
            
            if (!($biaya_kombi > 0))
            {
                throw new Exception ("Komponen Biaya SPP (201) belum disetting pada TA ".$transaksi->ta);  
            }
            $ta=TAModel::find($transaksi->ta); 
            $awal_semester = $ta->awal_semester;
            $transaksi_detail=[];
            for($i=$awal_semester;$i<= 12;$i++)
            {
                $transaksi_detail[]=[
                                    'no_bulan'=>$i,
                                    'nama_bulan'=>\App\Helpers\Helper::getNamaBulan($i),
                                    'biaya_kombi'=>$biaya_kombi
                                ];
            }
            for($i=1;$i<$awal_semester;$i++)
            {
                $transaksi_detail[]=[
                                    'no_bulan'=>$i,
                                    'nama_bulan'=>\App\Helpers\Helper::getNamaBulan($i),
                                    'biaya_kombi'=>$biaya_kombi
                                ];
            }            
            return Response()->json([
                                        'status'=>1,
                                        'pid'=>'fetchdata',  
                                        'transaksi'=>$transaksi,                                                                                                                                   
                                        'transaksi_detail'=>$transaksi_detail,                                                                                                                                   
                                        'message'=>"Fetch data transaksi dengan id ($id) berhasil diperoleh."
                                    ],200); 
        }
        catch (Exception $e)
        {
            return Response()->json([
                'status'=>0,
                'pid'=>'fetchdata',                                                                                                                                                  
                'message'=>[$e->getMessage()]
            ],422); 
        }      
    }
    public function newtransaction (Request $request)
    {
        $this->hasPermissionTo('KEUANGAN-TRANSAKSI-SPP_STORE');

        $this->validate($request, [           
            'nim'=>'required|exists:pe3_register_mahasiswa,nim',                 
            'semester_akademik'=>'required',
            'TA'=>'required'
        ]);

        try 
        {
            $nim=$request->input('nim');
            $semester_akademik=$request->input('semester_akademik');
            $ta=$request->input('TA');
            
            $mahasiswa=RegisterMahasiswaModel::select(\DB::raw('
                                    pe3_formulir_pendaftaran.user_id,
                                    pe3_formulir_pendaftaran.no_formulir,
                                    pe3_formulir_pendaftaran.nama_mhs,
                                    pe3_register_mahasiswa.nim,
                                    pe3_register_mahasiswa.tahun,
                                    pe3_register_mahasiswa.idkelas,
                                    pe3_register_mahasiswa.kjur,
                                    pe3_register_mahasiswa.k_status,
                                    pe3_status_mahasiswa.n_status                                    
                                '))                             
                                ->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_register_mahasiswa.user_id')   
                                ->join('pe3_status_mahasiswa','pe3_status_mahasiswa.k_status','pe3_register_mahasiswa.k_status')                                
                                ->where('nim',$nim)
                                ->first();

            if (is_null($mahasiswa))
            {                
                throw new Exception ("Mahasiswa dengan NIM ($nim) tidak terdaftar.");  
            }
            if ($mahasiswa->k_status == 'D' || $mahasiswa->k_status == 'K' || $mahasiswa->k_status == 'L')
            {                
                throw new Exception ("Mahasiswa dengan NIM ($nim) telah ".$mahasiswa->n_status.' jadi tidak bisa membuat transaksi baru');  
            }
            
            $tahun=$mahasiswa->tahun;
            $idkelas=$mahasiswa->idkelas;
            $kjur=$mahasiswa->kjur;

            $biaya_kombi=BiayaKomponenPeriodeModel::where('tahun',$tahun)
                                                    ->where('idkelas',$idkelas)
                                                    ->where('kjur',$kjur)
                                                    ->where('kombi_id',201)
                                                    ->value('biaya');
            
            if (!($biaya_kombi > 0))
            {
                throw new Exception ("Komponen Biaya SPP (201) belum disetting pada TA $tahun");  
            }

            $no_transaksi='201'.date('YmdHms');
            $transaksi=TransaksiModel::create([
                'id'=>Uuid::uuid4()->toString(),
                'user_id'=>$mahasiswa->user_id,
                'no_transaksi'=>$no_transaksi,
                'no_faktur'=>'',
                'kjur'=>$mahasiswa->kjur,
                'ta'=>$ta,
                'idsmt'=>$semester_akademik,
                'idkelas'=>$mahasiswa->idkelas,
                'no_formulir'=>$mahasiswa->no_formulir,
                'nim'=>$mahasiswa->nim,
                'commited'=>0,
                'total'=>0,
                'tanggal'=>date('Y-m-d'),
            ]);  

            return Response()->json([
                                        'status'=>1,
                                        'pid'=>'store',                   
                                        'transaksi'=>$transaksi,                                                                                                                                   
                                        'message'=>'Membuat Transaksi SPP baru berhasil.'
                                    ],200); 
        }
        catch (Exception $e)
        {
            return Response()->json([
                'status'=>0,
                'pid'=>'store',                                                                                                                                                  
                'message'=>[$e->getMessage()]
            ],422); 
        }  
    }
}