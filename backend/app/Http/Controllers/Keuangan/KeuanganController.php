<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Keuangan\TransaksiModel;
use App\Models\Keuangan\TransaksiDetailModel;

class KeuanganController extends Controller {  
    /**
     * daftar channel pembayaran
     */
    public function index(Request $request)
    {
        $this->hasPermissionTo('KEUANGAN-RINGKASAN_BROWSE');
        
        $this->validate($request, [           
            'TA'=>'required',
        ]);
        $ta=$request->input('TA');

        $kombi_ganjil=\DB::table('pe3_transaksi_detail')
                            ->select(\DB::raw('kombi_id,nama_kombi,sum(sub_total) AS jumlah'))
                            ->join('pe3_transaksi','pe3_transaksi.id','pe3_transaksi_detail.transaksi_id')
                            ->where('ta',$ta)
                            ->where('idsmt',1)
                            ->where('status',1)
                            ->groupByRaw('kombi_id,nama_kombi')
                            ->orderBy('kombi_id','ASC')
                            ->get();

        $kombi_genap=\DB::table('pe3_transaksi_detail')
                            ->select(\DB::raw('kombi_id,nama_kombi,sum(sub_total) AS jumlah'))
                            ->join('pe3_transaksi','pe3_transaksi.id','pe3_transaksi_detail.transaksi_id')
                            ->where('ta',$ta)
                            ->where('idsmt',2)
                            ->where('status',1)
                            ->groupByRaw('kombi_id,nama_kombi')
                            ->orderBy('kombi_id','ASC')
                            ->get();


        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata',  
                                    'kombi_ganjil'=>$kombi_ganjil,                                                                                                                                   
                                    'kombi_genap'=>$kombi_genap,                                                                                                                                   
                                    'message'=>'Fetch data rangkuman keuangan semester ganjil dan genap berhasil.'
                                ],200);     
    }    
}