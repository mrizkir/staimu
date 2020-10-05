<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Akademik\RegisterMahasiswaModel;
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
                                                    ->orWhere('pe3_transaksi_detail.kombi_id',202)
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
                                                    ->orWhere('pe3_transaksi_detail.kombi_id',202)
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
    
}