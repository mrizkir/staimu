<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keuangan\TransaksiModel;
use App\Models\Keuangan\TransaksiDetailModel;
use App\Helpers\Helper;

class TransaksiLaporanSPPController extends Controller {  
		/**
		 * daftar transaksi 
		 */
		public function index(Request $request)
		{
			$this->hasPermissionTo('KEUANGAN-LAPORAN-PENERIMAAN-SPP_BROWSE');        				
					
			$this->validate($request, [           
				'TA'=>'required',
				'prodi_id'=>'required'
			]);
			$ta=$request->input('TA');
			$prodi_id=$request->input('prodi_id');
			
			$bulan = Helper::getNamaBulanSPP();

			$daftar_transaksi = [];

			foreach ($bulan as $k=>$v) {
				if ($k == 9 || $k == 10 || $k == 11 || $k == 12)
				{
					$jumlah = \DB::table('pe3_transaksi_detail')
										->join('pe3_transaksi','pe3_transaksi.id','pe3_transaksi_detail.transaksi_id')
										->where('kjur', $prodi_id)
										->where('ta', $ta)
										->where('bulan',$k)
										->where('kombi_id', 201)
										->sum('sub_total');
					$v = "$v $ta";
				}
				else 
				{
					$jumlah = \DB::table('pe3_transaksi_detail')
										->join('pe3_transaksi','pe3_transaksi.id','pe3_transaksi_detail.transaksi_id')
										->where('kjur', $prodi_id)
										->where('ta', $ta+1)
										->where('bulan',$k)
										->sum('sub_total');

					$v = "$v " . ($ta+1);
				}
				$daftar_transaksi[]=[
					'no_bulan'=>$k,
					'nama_bulan'=>$v,
					'jumlah'=>$jumlah,
				];
			}
			
			return Response()->json([
																	'status'=>1,
																	'pid'=>'fetchdata',  
																	'transaksi'=>$daftar_transaksi,                                                                                                                                   
																	'message'=>'Fetch data daftar transaksi berhasil.'
															],200)->setEncodingOptions(JSON_NUMERIC_CHECK);    
		}		
}