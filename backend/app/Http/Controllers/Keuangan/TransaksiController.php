<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keuangan\TransaksiModel;
use App\Models\Keuangan\TransaksiDetailModel;

class TransaksiController extends Controller {  
    /**
     * daftar komponen biaya
     */
    public function index(Request $request)
    {
        $this->hasPermissionTo('KEUANGAN-TRANSAKSI_BROWSE');
        
        $this->validate($request, [           
            'TA'=>'required',
        ]);
        $ta=$request->input('TA');
        $daftar_transaksi = TransaksiModel::select(\DB::raw('
                                                pe3_transaksi.id,
                                                pe3_transaksi.user_id,
                                                pe3_formulir_pendaftaran.nama_mhs,
                                                pe3_transaksi.no_transaksi,
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
                                                pe3_transaksi.created_at,
                                                pe3_transaksi.updated_at
                                            '))
                                            ->join('pe3_status_transaksi','pe3_transaksi.status','pe3_status_transaksi.id_status')
                                            ->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_transaksi.user_id')
                                            ->where('pe3_transaksi.ta',$ta)
                                            ->orderBy('tanggal','DESC')
                                            ->get();
        
        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata',  
                                    'transaksi'=>$daftar_transaksi,                                                                                                                                   
                                    'message'=>'Fetch data daftar transaksi berhasil.'
                                ],200);     
    }  
}