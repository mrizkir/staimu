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
				'ta' => 'required',				
			]);
			$ta=$request->input('ta');
			
			$bulan = Helper::getNamaBulanSPP();

			$daftar_transaksi = [];
			
			$daftar_prodi = \DB::table('pe3_prodi')
												->select(\DB::raw('
													id,
													nama_prodi
												'))
												->get()
												->pluck('nama_prodi', 'id');
			$sub_total = 0;
			$total_keseluruhan = 0;
			foreach ($bulan as $k=>$v) {
				$data_prodi=[];	
				$jumlah = 0;
				$sub_total=0;
				if ($k == 9 || $k == 10 || $k == 11 || $k == 12)
				{
					foreach ($daftar_prodi as $prodi_id=>$nama_prodi)
					{
						$jumlah = \DB::table('pe3_transaksi_detail')
										->join('pe3_transaksi', 'pe3_transaksi.id', 'pe3_transaksi_detail.transaksi_id')										
										->where('ta', $ta)
										->where('bulan',$k)
										->where('kombi_id', 201)
										->where('status', 1)
										->where('kjur',$prodi_id)
										->sum('sub_total');
						
						$data_prodi[$prodi_id] = [
							'prodi_id' => $prodi_id,						
							'nama_prodi' => $nama_prodi,
							'jumlah' => $jumlah,
						];
						$sub_total += $jumlah;
					}					
					$v = "$v $ta";					
				}
				else 
				{
					foreach ($daftar_prodi as $prodi_id=>$nama_prodi)
					{
						$jumlah = \DB::table('pe3_transaksi_detail')
										->join('pe3_transaksi', 'pe3_transaksi.id', 'pe3_transaksi_detail.transaksi_id')										
										->where('ta', $ta + 1)
										->where('bulan',$k)
										->where('kombi_id', 201)
										->where('status', 1)
										->where('kjur',$prodi_id)
										->sum('sub_total');

						$data_prodi[$prodi_id] = [
							'prodi_id' => $prodi_id,
							'nama_prodi' => $nama_prodi,
							'jumlah' => $jumlah,
						];
						$sub_total += $jumlah;
					}
					$v = "$v " . ($ta+1);					
				}	
				$total_keseluruhan += $sub_total;			
				$daftar_transaksi[]=[
					'no_bulan' => $k,
					'nama_bulan' => $v,
					'sub_total' => $sub_total,
					'data_prodi' => $data_prodi,
				];
			}
			
			return Response()->json([
																	'status' => 1,
																	'pid' => 'fetchdata',  
																	'transaksi' => $daftar_transaksi,
																	'total_keseluruhan' => $total_keseluruhan,
																	'message' => 'Fetch data daftar transaksi berhasil.'
															], 200)->setEncodingOptions(JSON_NUMERIC_CHECK);    
		}		
	/**
	 * cetak seluruh transaksi spp per prodi dan ta
	 */
	public function printtoexcel1 (Request $request)
	{
		$this->hasPermissionTo('KEUANGAN-LAPORAN-PENERIMAAN-SPP_BROWSE');   				
		
		$this->validate($request, [           
			'ta' => 'required',			
		]);

		$data_report = [
			'ta' => $request->input('ta'),			
		];

		$report= new \App\Models\Report\ReportKeuanganSPPModel ($data_report);
		return $report->printtoexcel2();
	}
}