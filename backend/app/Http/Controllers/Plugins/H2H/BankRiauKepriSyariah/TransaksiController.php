<?php

namespace App\Http\Controllers\Plugins\H2H\BankRiauKepriSyariah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
                                        0 AS denda
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
            dd($transaksi);
            return Response()->json([
                                        'status'=>'88',                                        
                                        'message'=>"Tagihan sudah dibayarkan tanggal: ".$transaksi->updated_at_konfirm
                                    ],422); 
        }
        else
        {     
            return response()->json([
                'Result' => $transaksi
            ], 200); 
        }
    }
}
