<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DMaster\TAModel;
use App\Models\Akademik\RegisterMahasiswaModel;
use App\Models\Keuangan\BiayaKomponenPeriodeModel;
use App\Models\Keuangan\TransaksiModel;
use App\Models\Keuangan\TransaksiDetailModel;
use Illuminate\Validation\Rule;
use App\Helpers\Helper;

use Exception;

use Ramsey\Uuid\Uuid;

class TransaksiLaporanSPPPerSemesterController extends Controller {  
    /**
     * daftar komponen biaya
     */
    public function index(Request $request)
    {
      $this->hasPermissionTo('KEUANGAN-LAPORAN-PENERIMAAN-SPP_BROWSE');    

      $this->validate($request, [           
        'prodi_id'=>'required',
        'ta'=>'required',
        'tahun_pendaftaran'=>'required',
        'semester_akademik'=>'required',
      ]);
      $ta=$request->input('ta');
      $prodi_id=$request->input('prodi_id');
      $tahun_pendaftaran=$request->input('tahun_pendaftaran');
      $semester_akademik=$request->input('semester_akademik');

			switch($semester_akademik)
			{
				case 1:
					$select = 'A.user_id, A.nim, B.nama_mhs, "N.A" AS bulan9, "N.A" AS bulan10, "N.A" AS bulan11, "N.A" AS bulan12, "N.A" AS bulan1, "N.A" AS bulan2, 0 AS sub_total';
					$daftar_bulan=[9,10,11,12,1,2];
				break;
				case 2:
					$select = 'A.user_id, A.nim, B.nama_mhs, "N.A" AS bulan3, "N.A" AS bulan4, "N.A" AS bulan5, "N.A" AS bulan6, "N.A" AS bulan7, "N.A" AS bulan8, 0 AS sub_total';
					$daftar_bulan=[3,4,5,6,7,8];
				break;
				default :
					$select = "{} as bulan";
					$daftar_bulan=[];
			}
        
        $daftar_transaksi = \DB::table('pe3_register_mahasiswa AS A')
                            ->select(\DB::raw($select))
                            ->join('pe3_formulir_pendaftaran AS B','A.user_id','B.user_id');
                            

        if ($request->has('search'))
        {          
            $daftar_transaksi=$daftar_transaksi->whereRaw('(A.nim LIKE \''.$request->input('search').'%\' OR B.nama_mhs LIKE \'%'.$request->input('search').'%\')')        
                                                ->get();
        }            
        else
        {
            $daftar_transaksi=$daftar_transaksi->where('A.kjur', $prodi_id)
                                                ->where('A.tahun', $tahun_pendaftaran)
                                                ->get();
        }
                               
        $daftar_transaksi->transform(function ($item,$key) use ($ta, $daftar_bulan) {
          $transaksi = \DB::table('pe3_transaksi_detail AS A')  
                            ->select(\DB::raw("
                                A.user_id,
                              CONCAT(
                                '[',
                                GROUP_CONCAT(
                                  JSON_OBJECT(
                                    'bulan', bulan,
                                    'sub_total', sub_total
                                  )
                                ),
                                ']'
                              ) AS bulan
                            "))
                            ->join('pe3_transaksi AS B','A.transaksi_id','B.id')
                            ->where('A.user_id', $item->user_id)
                            ->where('A.kombi_id', 201)
                            ->where("A.tahun", $ta)
                            ->where('B.status', 1)          
														->whereIn("bulan", $daftar_bulan)
                            ->groupBy("A.user_id")
                            ->first();					
					
          if (!is_null($transaksi)) 
          {
            $bulan = json_decode($transaksi->bulan, false);            
            foreach ($bulan as $r) {
              switch($r->bulan)
              {
                case 1 :
                  $item->bulan1 = $r->sub_total;
                  $item->sub_total += $item->bulan1;
                break;
                case 2 :
                  $item->bulan2 = $r->sub_total;
                  $item->sub_total += $item->bulan2;
                break;
                case 3 :
                  $item->bulan3 = $r->sub_total;
                  $item->sub_total += $item->bulan3;
                break;
                case 4 :
                  $item->bulan4 = $r->sub_total;
                  $item->sub_total += $item->bulan4;
                break;
                case 5 :
                  $item->bulan5 = $r->sub_total;
                  $item->sub_total += $item->bulan5;
                break;
                case 6 :
                  $item->bulan6 = $r->sub_total;
                  $item->sub_total += $item->bulan6;
                break;
                case 7 :
                  $item->bulan7 = $r->sub_total;
                  $item->sub_total += $item->bulan7;
                break;
                case 8 :
                  $item->bulan8 = $r->sub_total;
                  $item->sub_total += $item->bulan8;
                break;
                case 9 :
                  $item->bulan9 = $r->sub_total;
                  $item->sub_total += $item->bulan9;
                break;
                case 10 :
                  $item->bulan10 = $r->sub_total;
                  $item->sub_total += $item->bulan10;
                break;
                case 11 :
                  $item->bulan11 = $r->sub_total;
                  $item->sub_total += $item->bulan11;
                break;
                case 12 :
                  $item->bulan12 = $r->sub_total;
                  $item->sub_total += $item->bulan12;
                break;
              }
            }            
          }
          return $item;
        });
        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata',  
                                    'transaksi'=>$daftar_transaksi,                                                                                                                                   
                                    'message'=>'Fetch data daftar transaksi spp mahasiswa berhasil diperoleh.'
                                ],200)->setEncodingOptions(JSON_NUMERIC_CHECK);    
    }
    public function show (Request $request,$id)
    {
        try 
        {
            if ($this->hasRole(['mahasiswa','mahasiswabaru']))
            {
                $transaksi=TransaksiModel::select(\DB::raw('                            
                                        pe3_transaksi.id,
                                        pe3_transaksi.user_id,
                                        pe3_formulir_pendaftaran.nama_mhs,
                                        CONCAT(pe3_transaksi.no_transaksi,\' \') AS no_transaksi,
                                        pe3_transaksi.no_faktur,
                                        pe3_transaksi.kjur,
                                        pe3_transaksi.ta,
                                        pe3_transaksi.idsmt,
                                        pe3_transaksi.idkelas,                                        
                                        COALESCE(pe3_transaksi.no_formulir,"N.A") AS no_formulir,
                                        COALESCE(pe3_transaksi.nim,"N.A") AS nim,
                                        pe3_formulir_pendaftaran.nama_mhs,
                                        pe3_kelas.nkelas,
                                        pe3_transaksi.status,
                                        pe3_status_transaksi.nama_status,
                                        pe3_status_transaksi.style,
                                        pe3_transaksi.total,
                                        pe3_transaksi.tanggal,   
                                        COALESCE(pe3_transaksi.desc,\'N.A\') AS `desc`, 
                                        pe3_formulir_pendaftaran.ta AS tahun_masuk,                                            
                                        pe3_transaksi.created_at,
                                        pe3_transaksi.updated_at
                                    '))
                                    ->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_transaksi.user_id')
                                    ->join('pe3_status_transaksi','pe3_transaksi.status','pe3_status_transaksi.id_status')
                                    ->join('pe3_kelas','pe3_kelas.idkelas','pe3_transaksi.idkelas')
                                    ->where('pe3_transaksi.user_id',$this->getUserid())
                                    ->find($id);
            }
            else
            {
                $transaksi=TransaksiModel::select(\DB::raw('
                                        pe3_transaksi.id,
                                        pe3_transaksi.user_id,
                                        pe3_formulir_pendaftaran.nama_mhs,
                                        CONCAT(pe3_transaksi.no_transaksi,\' \') AS no_transaksi,
                                        pe3_transaksi.no_faktur,
                                        pe3_transaksi.kjur,
                                        pe3_transaksi.ta,
                                        pe3_transaksi.idsmt,
                                        pe3_transaksi.idkelas,                                        
                                        COALESCE(pe3_transaksi.no_formulir,"N.A") AS no_formulir,
                                        COALESCE(pe3_transaksi.nim,"N.A") AS nim,
                                        pe3_formulir_pendaftaran.nama_mhs,
                                        pe3_kelas.nkelas,
                                        pe3_transaksi.status,
                                        pe3_status_transaksi.nama_status,
                                        pe3_status_transaksi.style,
                                        pe3_transaksi.total,
                                        pe3_transaksi.tanggal,   
                                        COALESCE(pe3_transaksi.desc,\'N.A\') AS `desc`,
                                        pe3_formulir_pendaftaran.ta AS tahun_masuk,                                             
                                        pe3_transaksi.created_at,
                                        pe3_transaksi.updated_at
                                    '))
                                    ->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_transaksi.user_id')
                                    ->join('pe3_status_transaksi','pe3_transaksi.status','pe3_status_transaksi.id_status')
                                    ->join('pe3_kelas','pe3_kelas.idkelas','pe3_transaksi.idkelas')
                                    ->find($id);
            }
            if (is_null($transaksi))        
            {
                throw new Exception ("Fetch data transaksi dengan id ($id) gagal diperoleh.");                
            }
            $biaya_kombi=BiayaKomponenPeriodeModel::where('tahun',$transaksi->tahun_masuk)
                                                    ->where('idkelas',$transaksi->idkelas)
                                                    ->where('kjur',$transaksi->kjur)
                                                    ->where('kombi_id',201)
                                                    ->value('biaya');
            
            if (!($biaya_kombi > 0))
            {
                throw new Exception ("Komponen Biaya SPP (201) belum disetting pada TA ".$transaksi->tahun_masuk);  
            }
            $ta=TAModel::find($transaksi->ta);             
            if (!Helper::checkformattanggal($ta->awal_ganjil))
            {
                throw new Exception ("Awal bulan semester ganjil Tahun Akademik (".$transaksi->ta.") belum disetting");
            }
            $awal_ganjil=Helper::getNomorBulan($ta->awal_ganjil);
            $transaksi_detail=[];
            for($i=$awal_ganjil;$i<= 12;$i++)
            {
                $status=$this->checkPembayaranSPP($i,$transaksi->ta,$transaksi->user_id);
                $transaksi_detail[]=[
                                    'id'=>$i,
                                    'no_bulan'=>$i,
                                    'nama_bulan'=>\App\Helpers\Helper::getNamaBulan($i),
                                    'tahun'=>$transaksi->ta,
                                    'biaya_kombi'=>$biaya_kombi,
                                    'isSelectable'=>$status,
                                    'status'=>$status
                                ];
            }
            for($i=1;$i<$awal_ganjil;$i++)
            {
                $status=$this->checkPembayaranSPP($i,$transaksi->ta,$transaksi->user_id);
                $transaksi_detail[]=[
                                    'id'=>$i,
                                    'no_bulan'=>$i,
                                    'nama_bulan'=>\App\Helpers\Helper::getNamaBulan($i),
                                    'tahun'=>$transaksi->ta+1,
                                    'biaya_kombi'=>$biaya_kombi,
                                    'isSelectable'=>$status,
                                    'status'=>$status
                                ];
            }            
            $item_selected = TransaksiDetailModel::select(\DB::raw('
                                id,
                                bulan AS no_bulan,
                                \'\' AS nama_bulan,
                                '.$transaksi->ta.' AS tahun,
                                biaya AS biaya_kombi,
                                true AS status,
                                true AS isSelectable
                            '))
                            ->where('transaksi_id',$transaksi->id)
                            ->get();
            $item_selected->transform(function ($item,$key) {                
                $item->nama_bulan=\App\Helpers\Helper::getNamaBulan($item->no_bulan);                
                return $item;
            });
            return Response()->json([
                                        'status'=>1,
                                        'pid'=>'fetchdata',  
                                        'transaksi'=>$transaksi,                                                                                                                                   
                                        'transaksi_detail'=>$transaksi_detail,                                                                                                                                   
                                        'item_selected'=>$item_selected,                                                                                                                                   
                                        'message'=>"Fetch data transaksi dengan id ($id) berhasil diperoleh."
                                    ],200)->setEncodingOptions(JSON_NUMERIC_CHECK); 
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
    /**
     * cetak seluruh transaksi spp per prodi dan ta
     */
    public function printtoexcel1 (Request $request)
    {
        $this->validate($request, [           
            'ta'=>'required',            
            'semester_akademik'=>'required',            
            'prodi_id'=>'required',
            'nama_prodi'=>'required',
            'tahun_pendaftaran'=>'required',
        ]);

        $data_report=[
            'ta'=>$request->input('ta'),
            'semester_akademik'=>$request->input('semester_akademik'),
            'prodi_id'=>$request->input('prodi_id'),            
            'nama_prodi'=>$request->input('nama_prodi'),                        
            'tahun_pendaftaran'=>$request->input('tahun_pendaftaran'),                        
        ];

        $report= new \App\Models\Report\ReportKeuanganSPPModel ($data_report);
        return $report->printtoexcel3();
    }    
}