<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SPMB\FormulirPendaftaranModel;
use App\Models\Akademik\RegisterMahasiswaModel;
use App\Models\Keuangan\TransaksiModel;
use App\Models\Keuangan\TransaksiDetailModel;
use App\Models\Keuangan\KonfirmasiPembayaranModel;

use Exception;

use Ramsey\Uuid\Uuid;

class TransaksiController extends Controller {  
	/**
	 * daftar komponen biaya
	 */
	public function index(Request $request)
	{
		$this->hasPermissionTo('KEUANGAN-TRANSAKSI_BROWSE');
		
		$select=\DB::raw('
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
							pe3_transaksi.status,
							pe3_status_transaksi.nama_status,
							pe3_status_transaksi.style,
							pe3_transaksi.total,
							pe3_transaksi.tanggal,   
							COALESCE(pe3_transaksi.desc,\'N.A\') AS `desc`, 
							pe3_transaksi.created_at,
							pe3_transaksi.updated_at
						');
		if ($this->hasRole(['mahasiswa', 'mahasiswabaru']))
		{
			$this->validate($request, [           
				'ta' => 'required',    
			]);
			$ta = $request->input('ta');      

			$daftar_transaksi = TransaksiModel::select($select)
											->join('pe3_status_transaksi', 'pe3_transaksi.status', 'pe3_status_transaksi.id_status')
											->join('pe3_formulir_pendaftaran', 'pe3_formulir_pendaftaran.user_id', 'pe3_transaksi.user_id')
											->where('pe3_transaksi.ta',$ta)
											->where('pe3_transaksi.user_id', $this->getUserid())
											->orderBy('tanggal', 'DESC')
											->get();
		}
		elseif ($request->has('user_id') && $request->filled('user_id') )
		{
			$this->validate($request, [           
				'ta' => 'required',    
			]);
			$ta = $request->input('ta');
			
			$daftar_transaksi = TransaksiModel::select($select)
											->join('pe3_status_transaksi', 'pe3_transaksi.status', 'pe3_status_transaksi.id_status')
											->join('pe3_formulir_pendaftaran', 'pe3_formulir_pendaftaran.user_id', 'pe3_transaksi.user_id')
											->where('pe3_transaksi.ta',$ta)
											->where('pe3_transaksi.user_id',$request->input('user_id'))
											->orderBy('tanggal', 'DESC')
											->get();
		}
		else
		{
			$this->validate($request, [           
				'ta' => 'required',
				'prodi_id' => 'required',
			]);
			$ta = $request->input('ta');
			$prodi_id = $request->input('prodi_id');

			$daftar_transaksi = TransaksiModel::select($select)
											->join('pe3_status_transaksi', 'pe3_transaksi.status', 'pe3_status_transaksi.id_status')
											->join('pe3_formulir_pendaftaran', 'pe3_formulir_pendaftaran.user_id', 'pe3_transaksi.user_id')
											->orderBy('tanggal', 'DESC');                                       

			if ($request->has('search'))
			{
				$daftar_transaksi=$daftar_transaksi->whereRaw('(pe3_transaksi.nim LIKE \'' . $request->input('search').'%\' OR pe3_transaksi.no_formulir LIKE \'' . $request->input('search').'%\' OR pe3_formulir_pendaftaran.nama_mhs LIKE \'%' . $request->input('search').'%\')')        
													->get();
			}  
			else
			{
				$daftar_transaksi=$daftar_transaksi->where('pe3_transaksi.ta',$ta)        
													->where('pe3_transaksi.kjur',$prodi_id)        
													->get();
			}
		}        
		
		return Response()->json([
									'status' => 1,
									'pid' => 'fetchdata',  
									'transaksi' => $daftar_transaksi,
									'message' => 'Fetch data daftar transaksi berhasil.'
								], 200)->setEncodingOptions(JSON_NUMERIC_CHECK);
	}
	/**
	 * digunakan untuk mendapatkan detail transaksi
	 */
	public function show(Request $request,$id)
	{
		$transaksi=TransaksiModel::select(\DB::raw('
										pe3_transaksi.id,
										pe3_transaksi.user_id,
										pe3_formulir_pendaftaran.nama_mhs,
										pe3_formulir_pendaftaran.alamat_rumah,
										pe3_formulir_pendaftaran.telp_hp,                                    
										CONCAT(pe3_transaksi.no_transaksi,\' \') AS no_transaksi,
										pe3_transaksi.no_faktur,
										pe3_transaksi.kjur,
										pe3_transaksi.ta,
										pe3_transaksi.idsmt,
										pe3_transaksi.idkelas,        
										COALESCE(pe3_transaksi.no_formulir,"N.A") AS no_formulir,
										COALESCE(pe3_transaksi.nim,"N.A") AS nim,        
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
									->join('pe3_formulir_pendaftaran', 'pe3_formulir_pendaftaran.user_id', 'pe3_transaksi.user_id')
									->join('pe3_status_transaksi', 'pe3_transaksi.status', 'pe3_status_transaksi.id_status')
									->join('pe3_kelas', 'pe3_kelas.idkelas', 'pe3_transaksi.idkelas')
									->where('pe3_transaksi.id',$id)
									->first();

		if (is_null($transaksi))        {
			return Response()->json([
										'status'=>0,
										'pid' => 'fetchdata',          
										'message' => "Fetch data transaksi dengan id ($id) gagal diperoleh."
									], 422); 
		}
		else
		{
			$transaksi_detail=TransaksiDetailModel::where('transaksi_id',$id)
													->get();
			return Response()->json([
										'status' => 1,
										'pid' => 'fetchdata',  
										'transaksi' => $transaksi,
										'transaksi_detail' => $transaksi_detail,
										'message' => "Fetch data transaksi dengan id ($id) berhasil diperoleh."
									], 200)->setEncodingOptions(JSON_NUMERIC_CHECK);
		}
	}
	/**
	 * digunakan untuk mendapatkan data spp khusus mahasiswa baru
	 */
	public function dulangmhsbaru (Request $request, $id)
	{
		try 
		{
			$mhs = FormulirPendaftaranModel::find($id);
			if (is_null($mhs))
			{
				throw new Exception ('Data Mahasiswa Baru gagal DIPEROLEH. ');
			} 

			$transaksi=TransaksiDetailModel::join('pe3_transaksi', 'pe3_transaksi.id', 'pe3_transaksi_detail.transaksi_id')
							->where('pe3_transaksi_detail.kombi_id', 102)																					
							->where('pe3_transaksi.status', 1)
							->where('pe3_transaksi_detail.user_id',$mhs->user_id)
							->first();

			if (is_null($transaksi))
			{
				throw new Exception ('Tidak bisa daftar ulang karena belum melakukan pembayaran Daftar Ulang Mahasiswa Baru. ');
			}

			return Response()->json([
				'status' => 1,
				'pid' => 'fetchdata',  
				// 'status_transaksi' => $transaksi->status,  
				'transaksi' => $transaksi,
				'message' => 'Biaya Daftar Ulang Mahasiswa Baru berhasil DIPEROLEH.'
			], 200);
			
		}
		catch (Exception $e)
		{
			return Response()->json([
				'status'=>0,
				'pid' => 'update',               
				'message' => [$e->getMessage()]
			], 422); 
		}
	}
	/**
	 * digunakan untuk mendapatkan data spp khusus mahasiswa baru
	 */
	public function sppmhsbaru (Request $request, $id)
	{
		$this->validate($request, [                       
			'jenis_id' => 'required'
		]);   
		$jenis_id = $request->input('jenis_id');

		try 
		{
			$mhs=$jenis_id == 'nim' ? RegisterMahasiswaModel::where('nim', $id)->first() : RegisterMahasiswaModel::find($id);
			if (is_null($mhs))
			{
				throw new Exception ('Data Mahasiswa Baru gagal DIPEROLEH. ');
			}   

			$user_id = $mhs->user_id;
			$no_bulan=9;   
			$spp=TransaksiDetailModel::join('pe3_transaksi', 'pe3_transaksi.id', 'pe3_transaksi_detail.transaksi_id')
							->where('pe3_transaksi_detail.kombi_id', 201)
							->where('pe3_transaksi.ta',$mhs->tahun)
							->where('pe3_transaksi.idsmt',$mhs->idsmt)
							->where('pe3_transaksi_detail.bulan',$no_bulan)
							->where('pe3_transaksi.status', 1)
							->where('pe3_transaksi_detail.user_id',$user_id)
							->first();

			if (is_null($spp))
			{
				throw new Exception ('Mahasiswa Baru ini belum melakukan pembayaran KRS pada Bulan September');
			}
			return Response()->json([
				'status' => 1,
				'pid' => 'fetchdata',  
				// 'status_transaksi' => $spp->status,  
				'spp' => $spp,
				'message' => 'SPP Mahasiswa Baru berhasil DIPEROLEH.'
			], 200); 
		}
		catch (Exception $e)
		{
			return Response()->json([
				'status'=>0,
				'pid' => 'update',               
				'message' => [$e->getMessage()]
			], 422); 
		}
	}
	/**
	 * digunakan untuk membatalkan transaksi
	 */
	public function cancel(Request $request)
	{
		$this->validate($request, [           
			'transaksi_id' => 'required|exists:pe3_transaksi,id',
		]);
		$transaksi_id = $request->input('transaksi_id');
		$transaksi=TransaksiModel::find($transaksi_id);

		if ($transaksi->status==1)
		{
			return Response()->json([
				'status'=>0,
				'pid' => 'update',  
				'transaksi_id' => $transaksi_id,
				'message' => 'Transaksi ini gagal dibatalkan karena status sudah PAID.'
			], 422);   
		}
		else if ($transaksi->status==2)
		{
			return Response()->json([
				'status'=>0,
				'pid' => 'update',  
				'transaksi_id' => $transaksi_id,
				'message' => 'Transaksi ini gagal dibatalkan karena status sudah DIBATALKAN.'
			], 422); 
		}
		else if ($transaksi->status==0)
		{
			$transaksi->status=2;
			$transaksi->save();

			\App\Models\System\ActivityLog::log($request,[
															'object' => $transaksi, 
															'object_id' => $transaksi->id, 
															'user_id' => $this->getUserid(), 
															'message' => 'Melakukan pembatalan terhadap transaksi dengan id (' . $transaksi_id. ') telah berhasil dilakukan.'
														]);
														
			return Response()->json([
										'status' => 1,
										'pid' => 'update',  
										'transaksi_id' => $transaksi_id,
										'message' => 'Kode billing dengan ID (' . $transaksi->no_transaksi. ') berhasil DIBATALKAN.'
									], 200); 
		}
		
	}
	/**
	 * digunakan untuk merubah status transaksi menjadi paid
	 */
	public function verifikasi(Request $request,$id)
	{
		$this->hasPermissionTo('KEUANGAN-KONFIRMASI-PEMBAYARAN_UPDATE');

		$konfirmasi=KonfirmasiPembayaranModel::find($id);
		if (is_null($konfirmasi))
		{
			return Response()->json([
									'status'=>0,
									'pid' => 'update',    
									'message' => ["Update data transaksi dengan ID ($id) gagal diperoleh"]
								], 422); 
		}
		else
		{
			$konfirmasi = \DB::transaction(function () use ($request,$konfirmasi) {
				$konfirmasi->verified=true;
				$konfirmasi->save();

				$transaksi=$konfirmasi->transaksi;
				$transaksi->status=1;
				$transaksi->save();
				
				//aksi setelah PAID

				$detail = TransaksiDetailModel::select(\DB::raw('
													kombi_id
												'))
												->where('transaksi_id',$transaksi->id)
												->get();
				foreach ($detail as $v)
				{
					switch ($v->kombi_id)
					{
						case 101: //biaya formulir pendaftaran
							$formulir=\App\Models\SPMB\FormulirPendaftaranModel::find($konfirmasi->user_id);                   
							$no_formulir=$formulir->idsmt.mt_rand();
							$formulir->no_formulir=$no_formulir;
							$formulir->save();
						break;
						case 202:
							if (!(\App\Models\Akademik\DulangModel::where('tahun',$transaksi->ta)
																	->where('idsmt',$transaksi->idsmt)
																	->where('idkelas',$transaksi->idkelas)
																	->where('nim',$transaksi->nim)
																	->exists()))
							{
								\App\Models\Akademik\DulangModel::create([
																			'id'=>Uuid::uuid4()->toString(),
																			'user_id' => $transaksi->user_id,
																			'nim' => $transaksi->nim,
																			'tahun' => $transaksi->ta,
																			'idsmt' => $transaksi->idsmt,
																			'tasmt' => $transaksi->ta.$transaksi->idsmt,
																			'idkelas' => $transaksi->idkelas,
																			'status_sebelumnya' => 'A',
																			'k_status' => 'A',
																		]);
							}
						break;
					}
				}
				
				\App\Models\System\ActivityLog::log($request,[
																'object' => $konfirmasi, 
																'object_id' => $konfirmasi->transaksi_id, 
																'user_id' => $this->getUserid(), 
																'message' => 'Melakukan verifikasi terhadap transaksi dengan status PAID telah berhasil dilakukan.'
															]);
				return $konfirmasi;
			});
			
			return Response()->json([
										'status' => 1,
										'pid' => 'update',          
										'message' => "Mengubah data status konfirmasi dengan id ($id) berhasil."                                        
									], 200);   
		}
		
	}
}