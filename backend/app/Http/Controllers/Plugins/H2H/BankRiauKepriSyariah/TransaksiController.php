<?php

namespace App\Http\Controllers\Plugins\H2H\BankRiauKepriSyariah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Akademik\RegisterMahasiswaModel;
use App\Models\Keuangan\TransaksiModel;
use App\Models\Keuangan\TransaksiDetailModel;
use App\Models\Keuangan\KonfirmasiPembayaranModel;

use App\Models\System\ConfigurationModel;

use Exception;

use Ramsey\Uuid\Uuid;

class TransaksiController extends Controller {  
    public function inquiryTagihan(Request $request)
    {
        $kode_billing=$request->input('kode_billing');
        
        $config = ConfigurationModel::getCache();

        $transaksi=TransaksiModel::select(\DB::raw('
                                        pe3_transaksi.no_transaksi AS kode_billing,
                                        pe3_formulir_pendaftaran.no_formulir,
                                        pe3_transaksi.nim,                                        
                                        pe3_formulir_pendaftaran.nama_mhs,
                                        \''.addslashes($config['NAMA_PT']).'\' AS universitas,
                                        \'\' AS fakultas, 
                                        pe3_prodi.nama_prodi AS prodi,
                                        pe3_transaksi.idsmt,
                                        pe3_transaksi.ta AS periode,
                                        pe3_transaksi.total AS nominal,
                                        0 AS denda,
                                        pe3_transaksi.status,
                                        COALESCE(pe3_konfirmasi_pembayaran.updated_at,"N.A") AS updated_at_konfirm
                                    '))
                                    ->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_transaksi.user_id')
                                    ->leftJoin('pe3_konfirmasi_pembayaran','pe3_konfirmasi_pembayaran.transaksi_id','pe3_transaksi.id')
                                    ->leftJoin('pe3_prodi','pe3_prodi.id','pe3_transaksi.kjur')
                                    ->where('pe3_transaksi.no_transaksi',$kode_billing)
                                    ->first();
        
        if (is_null($transaksi))        {
            return Response()->json([
                                        'status'=>'14',                                        
                                        'message'=>"request KODE_BILLING ($kode_billing) tidak sesuai"
                                    ],422); 
        }
        else if ($transaksi->status==1)
        {
            return Response()->json([
                                        'status'=>'88',                                        
                                        'message'=>"Tagihan sudah dibayarkan tanggal: ".$transaksi->updated_at_konfirm
                                    ],422); 
        }
        else if ($transaksi->status==2)
            {
                return Response()->json([
                                            'status'=>'88',                                        
                                            'message'=>"status kode billing ini dibatalkan"
                                        ],422); 
            }
        else
        {     
            return response()->json([
                'Result' => $transaksi
            ], 200); 
        }
    }
    public function payment(Request $request)
    {
        $messages=[
            'kode_billing.required'=>'kode billing diperlukan mohon di isi',
            'kode_billing.exists'=>'kode billing tidak terdaftar didatabase',            
            'nomor_referensi.required'=>'Nomor referensi dibutuhkan',
            'nomor_referensi.numeric'=>'Nomor referensi harus numeric',
            
            'amount”.required'=>'amount diperlukan mohon di isi',
            'amount”.numeric'=>'Nilai amount harus numeric',
            
            'tanggal_terima.required'=>'tanggal terima dibutuhkan',
            'tanggal_kirim.required'=>'tanggal kirim dibutuhkan',
        ];
        $validator = Validator::make($request->all(),[
            'kode_billing'=>'required|exists:pe3_transaksi,no_transaksi',
            'nomor_referensi'=>'required|numeric',
            'amount'=>'required|numeric',
            'tanggal_terima'=>'required',
            'tanggal_kirim'=>'required',
        ],$messages);

        if ($validator->fails())
        {
            return Response()->json([
                'status'=>'11',                                        
                'message'=>"Format request tidak sesuai",
                'errors'=>$validator->customMessages
            ],422); 
        }
        else
        {
            $kode_billing=$request->input('kode_billing');
            $transaksi=TransaksiModel::select(\DB::raw('
                                        pe3_transaksi.no_transaksi AS kode_billing,
                                        pe3_formulir_pendaftaran.no_formulir,
                                        pe3_transaksi.nim,                                        
                                        pe3_formulir_pendaftaran.nama_mhs,                                        
                                        pe3_prodi.nama_prodi AS prodi,
                                        pe3_transaksi.idsmt,
                                        pe3_transaksi.ta,
                                        pe3_transaksi.total,
                                        0 AS denda,
                                        pe3_transaksi.status,
                                        COALESCE(pe3_konfirmasi_pembayaran.updated_at,"N.A") AS updated_at_konfirm
                                    '))
                                    ->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_transaksi.user_id')
                                    ->leftJoin('pe3_konfirmasi_pembayaran','pe3_konfirmasi_pembayaran.transaksi_id','pe3_transaksi.id')
                                    ->leftJoin('pe3_prodi','pe3_prodi.id','pe3_transaksi.kjur')
                                    ->where('pe3_transaksi.no_transaksi',$kode_billing)
                                    ->first();
            
            if ($transaksi->status==1)
            {
                return Response()->json([
                                            'status'=>'88',                                        
                                            'message'=>"Tagihan sudah dibayarkan tanggal: ".$transaksi->updated_at_konfirm
                                        ],422); 
            }
            else if ($transaksi->status==2)
            {
                return Response()->json([
                                            'status'=>'88',                                        
                                            'message'=>"status kode billing ini dibatalkan"
                                        ],422); 
            }
            else if ($transaksi->total!=$request->input('amount'))
            {     
                return Response()->json([
                                            'status'=>'11',                                        
                                            'message'=>'Nilai nominal salah ('.\App\Helpers\Helper::formatUang($request->input('amount')).') karena  tidak sama dengan dengan transaksi '.\App\Helpers\Helper::formatUang($transaksi->total)
                                    ],422); 
            }
        
        }
        // $config = ConfigurationModel::getCache();

        // $transaksi=TransaksiModel::select(\DB::raw('
        //                                 pe3_transaksi.no_transaksi AS kode_billing,
        //                                 pe3_formulir_pendaftaran.no_formulir,
        //                                 pe3_transaksi.nim,                                        
        //                                 pe3_formulir_pendaftaran.nama_mhs,
        //                                 \''.addslashes($config['NAMA_PT']).'\' AS universitas,
        //                                 \'\' AS fakultas, 
        //                                 pe3_prodi.nama_prodi AS prodi,
        //                                 pe3_transaksi.idsmt,
        //                                 pe3_transaksi.ta AS periode,
        //                                 pe3_transaksi.total AS nominal,
        //                                 0 AS denda
        //                             '))
        //                             ->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_transaksi.user_id')
        //                             ->leftJoin('pe3_konfirmasi_pembayaran','pe3_konfirmasi_pembayaran.transaksi_id','pe3_transaksi.id')
        //                             ->leftJoin('pe3_prodi','pe3_prodi.id','pe3_transaksi.kjur')
        //                             ->where('pe3_transaksi.no_transaksi',$kode_billing)
        //                             ->first();

        // if (is_null($transaksi))        {
        //     return Response()->json([
        //                                 'status'=>'14',                                        
        //                                 'message'=>"request KODE_BILLING ($kode_billing) tidak sesuai"
        //                             ],422); 
        // }
        // else if ($transaksi->status==1)
        // {
        //     return Response()->json([
        //                                 'status'=>'88',                                        
        //                                 'message'=>"Tagihan sudah dibayarkan tanggal: ".$transaksi->updated_at_konfirm
        //                             ],422); 
        // }
        // else
        // {     
        //     return response()->json([
        //         'Result' => $transaksi
        //     ], 200); 
        // }
    }
}
