<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\Akademik\RegisterMahasiswaModel;
use App\Models\Akademik\PPLPKLModel;
use App\Models\Keuangan\TransaksiDetailModel;

use Ramsey\Uuid\Uuid;

use Exception;

class PPLPKLController extends Controller
{
	private $persyaratan_complete = [];
	private $persyaratan_verified = [];    
	/**
	 * daftar peserta ujian munaqasah
	 */
	public function index(Request $request)
	{
		$this->hasPermissionTo('AKADEMIK-PERKULIAHAN-PPL-PKL_BROWSE');

		$daftar_pplpkl=\DB::table('pe3_pplpkl AS A')
						->select(\DB::raw('
							A.id,
							B.nim,
							C.nama_mhs,
							A.tempat_pplpkl,
							A.alamat_pplpkl,
							A.size_baju,
							B.tahun AS tahun_masuk,
							CONCAT(COALESCE(D.gelar_depan,\' \'),D.nama_dosen,\' \',COALESCE(D.gelar_belakang,\'\')) AS dosen_pembimbing_1,							
							A.pembimbing_1,							
							A.status,
							A.created_at,
							A.updated_at
						'))
						->join('pe3_register_mahasiswa AS B','B.user_id','A.user_id')
						->join('pe3_formulir_pendaftaran AS C','C.user_id','A.user_id')
						->join('pe3_dosen AS D','D.user_id','A.pembimbing_1');						

		if ($this->hasRole('mahasiswa'))
		{
			$daftar_pplpkl=$daftar_pplpkl->where('A.user_id', $this->getUserid())
										->get();
		}
		else
		{
			$this->validate($request, [
				'ta'=>'required',
				'semester_akademik'=>'required',
				'prodi_id'=>'required'
			]);

			$daftar_pplpkl=$daftar_pplpkl->where('A.ta', $request->input('ta'))
										->where('A.idsmt', $request->input('semester_akademik'))
										->where('A.prodi_id', $request->input('prodi_id'))
										->get();
		}        
		return Response()->json([
									'status'=>1,
									'pid'=>'fetchdata',  
									'daftar_pplpkl'=>$daftar_pplpkl,
									'message'=>'Daftar peserta ujian munaqasah berhasil diperoleh' 
								], 200);  
		
	}	
	public function show (Request $request,$id)
	{
		$this->hasPermissionTo('AKADEMIK-PERKULIAHAN-PPL-PKL_SHOW');

		if ($this->hasRole('mahasiswa'))
		{
			$pplpkl = PPLPKLModel::select(\DB::raw('
					pe3_pplpkl.*,
					pe3_register_mahasiswa.nim
				'))
				->join('pe3_register_mahasiswa', 'pe3_register_mahasiswa.user_id', 'pe3_pplpkl.user_id')
				->where('pe3_pplpkl.id', $id)
				->where('pe3_pplpkl.user_id', $this->getUserid())				
				->first();
		}
		else
		{
			$pplpkl = PPLPKLModel::select(\DB::raw('
					pe3_pplpkl.*,
					pe3_register_mahasiswa.nim
				'))
				->join('pe3_register_mahasiswa', 'pe3_register_mahasiswa.user_id', 'pe3_pplpkl.user_id')
				->where('pe3_pplpkl.id', $id)
				->first();
		}
		if (is_null($pplpkl))
		{
			return Response()->json([
									'status'=>0,
									'pid'=>'fetchdata',    
									'message'=>["Data PPL / PKL dengan id ($id) gagal diperoleh"]
								], 422); 
		}
		else
		{			
			return Response()->json([
								'status'=>1,
								'pid'=>'fetchdata',
								'pplpkl'=>$pplpkl,								
								'message'=>'Daftar PPL / PKL berhasil diperoleh' 
							], 200);
		}        
	}
	/**
	 * digunakan untul menyimpan ujian munaqasah mahasiswa
	 */
	public function store (Request $request)
	{
		$this->hasPermissionTo('AKADEMIK-PERKULIAHAN-PPL-PKL_STORE');
		
		$this->validate($request, [            
			'nim'=>'required|exists:pe3_register_mahasiswa,nim',     
			'pembimbing_1'=>'required|exists:pe3_dosen,user_id',			  
			'tempat_pplpkl'=>'required',     
			'address1_desa_id'=>'required',
			'address1_kelurahan'=>'required',     
			'address1_kecamatan_id'=>'required',     
			'address1_kecamatan'=>'required',     
			'address1_kabupaten_id'=>'required',     
			'address1_kabupaten'=>'required',     
			'address1_provinsi_id'=>'required',     
			'address1_provinsi'=>'required',
			'alamat_pplpkl'=>'required',     
			'size_baju'=>'required',
			'ta'=>'required',     
			'idsmt'=>'required',    
		]);
		$jumlah_syarat_matkul = 0;
		try 
	  {
			$nim=$request->input('nim');
		  $semester_akademik=$request->input('idsmt');
		  $ta=$request->input('ta');
			
			$mahasiswa = RegisterMahasiswaModel::where('nim', $nim)->first();
			
			$transaksi=TransaksiDetailModel::select(\DB::raw('
											  1
										  '))
										  ->join('pe3_transaksi','pe3_transaksi_detail.transaksi_id','pe3_transaksi.id')
										  ->where('pe3_transaksi.ta',$ta)
										  ->where('pe3_transaksi.idsmt',$semester_akademik)
										  ->where('pe3_transaksi.nim',$nim)
										  ->where('pe3_transaksi_detail.kombi_id',301)
											->where('pe3_transaksi.status',1);

		  if (!$transaksi->exists())
		  {                
			  throw new Exception ("Tambah PPL / PKL a.n mahasiswa dengan NIM ($nim) gagal karena belum melakukan transaksi atau membayar transaksi pada $ta semester $semester_akademik.");  
		  }			
			
			$tahun=$mahasiswa->tahun;
		  $idkelas=$mahasiswa->idkelas;
		  $kjur=$mahasiswa->kjur;

			$syarat_matkul = \DB::table('pe3_matakuliah')
				->select(\DB::raw('id, kmatkul, nmatkul'))
				->where('ta', $tahun)
				->where('kjur', $kjur)
				->where('syarat_pplpkl', 1)
				->get();

			$jumlah_syarat_matkul = $syarat_matkul->count();
			if (!($jumlah_syarat_matkul > 0))
			{
				throw new Exception ("Syarat matakuliah PPL / PKL belum disetting pada halaman Matakuliah TA $tahun");
			}
			$daftar_syarat = $syarat_matkul->pluck('id')->toArray();

			$matkul_lulus = \DB::table('pe3_matakuliah AS A')
				->select(\DB::raw('A.kmatkul, A.nmatkul, D.n_mutu'))
				->join('pe3_penyelenggaraan AS B', 'A.id', 'B.matkul_id')
				->join('pe3_krsmatkul AS C', 'C.penyelenggaraan_id', 'B.id')
				->join('pe3_nilai_matakuliah AS D', 'D.krsmatkul_id', 'C.id')
				->whereIn('A.id', $daftar_syarat)
				->where('A.ta', $tahun)
				->where('A.kjur', $kjur)
				->where('A.syarat_pplpkl', 1)
				->where('C.batal', 0)
				->where('D.user_id_mhs', $mahasiswa->user_id)
				->get();

			$jumlah_matkul_lulus = $matkul_lulus->count();

			if (!($jumlah_matkul_lulus > 0))
			{
				throw new Exception ("Matakuliah prasyarat PPL / PKL belum dikontrak di KRS atau statusnya dibatalkan");
			}

			if ($jumlah_matkul_lulus < $jumlah_syarat_matkul) {
				throw new Exception ("Matakuliah prasyarat PPL / PKL yang lulus ($jumlah_matkul_lulus) harus sama dengan matakuliah syarat PPL / PKL ($jumlah_syarat_matkul)");
			}

			foreach($matkul_lulus as $v)
			{
				if ($v->n_mutu < 16)
				{
					throw new Exception ("Nilai Matakuliah Prasyarat PPL / PKL yaitu $v->nmatkul[$v->kmatkul] TIDAK LULUS");
				}
			}
			$pplpkl = PPLPKLModel::create([
				'id'=>Uuid::uuid4()->toString(),
				'user_id'=>$mahasiswa->user_id,
				'pembimbing_1'=>$request->input('pembimbing_1'),
				'tempat_pplpkl'=>$request->input('tempat_pplpkl'),
				'address1_desa_id'=>$request->input('address1_desa_id'),
				'address1_kelurahan'=>$request->input('address1_kelurahan'),
				'address1_kecamatan_id'=>$request->input('address1_kecamatan_id'),
				'address1_kecamatan'=>$request->input('address1_kecamatan'),
				'address1_kabupaten_id'=>$request->input('address1_kabupaten_id'),
				'address1_kabupaten'=>$request->input('address1_kabupaten'),
				'address1_provinsi_id'=>$request->input('address1_provinsi_id'),
				'address1_provinsi'=>$request->input('address1_provinsi'),
				'alamat_pplpkl'=>$request->input('alamat_pplpkl'),
				'size_baju'=>$request->input('size_baju'),
				'keterangan'=>$request->input('keterangan'),
				'prodi_id'=>$mahasiswa->kjur,
				'ta'=>$ta,
				'idsmt'=>$semester_akademik,
			]);

			return Response()->json([
									'status'=>1,
									'pid'=>'store', 
									'pplpkl'=>$pplpkl,                                     
									'message'=>'Data PPL / PKL berhasil ditambahkan'
								], 200);  
		}
		catch (Exception $e)
	  {
			if ($jumlah_syarat_matkul > 0)
			{
				$persyaratan_matkul='';
				$i = 0;
				foreach($syarat_matkul as $v)
				{
					if ($i < ($jumlah_syarat_matkul - 1))
					{
						$persyaratan_matkul .= ($i + 1) . ". $v->nmatkul [$v->kmatkul], ";
					}
					else
					{
						$persyaratan_matkul .= ($i + 1) . ". $v->nmatkul [$v->kmatkul]";
					}
					$i += 1;
				}
			}
			else 
			{
				$persyaratan_matkul = '-';
			}
		  return Response()->json([
			  'status'=>0,
			  'pid'=>'store',
			  'message'=>[$e->getMessage()],
				'matakuliah syarat'=>$persyaratan_matkul,
		  ], 422); 
		}		
	}
	/**
	 * digunakan untul menyimpan ujian munaqasah mahasiswa
	 */
	public function update (Request $request,$id)
	{
		$this->hasPermissionTo('AKADEMIK-PERKULIAHAN-PPL-PKL_UPDATE');
		
		if ($this->hasRole('mahasiswa'))
		{
			$pplpkl = PPLPKLModel::where('user_id',$this->getUserid())
										->find($id);
			
		}
		else
		{
			$pplpkl = PPLPKLModel::find($id);                                  
		}
		if (is_null($pplpkl))
		{
			return Response()->json([
									'status'=>0,
									'pid'=>'fetchdata',    
									'message'=>["Data PPL / PKL dengan ID ($id) gagal diperoleh"]
								], 422); 
		}
		else if ($pplpkl->status == 0)
		{
			$this->validate($request, [
				'pembimbing_1'=>'required|exists:pe3_dosen,user_id',			  
				'tempat_pplpkl'=>'required',     
				'address1_desa_id'=>'required',
				'address1_kelurahan'=>'required',     
				'address1_kecamatan_id'=>'required',     
				'address1_kecamatan'=>'required',     
				'address1_kabupaten_id'=>'required',     
				'address1_kabupaten'=>'required',     
				'address1_provinsi_id'=>'required',     
				'address1_provinsi'=>'required',
				'alamat_pplpkl'=>'required',     
				'size_baju'=>'required',
			]);       
			
			$pplpkl->pembimbing_1 = $request->input('pembimbing_1');
			$pplpkl->tempat_pplpkl = $request->input('tempat_pplpkl');
			$pplpkl->address1_desa_id = $request->input('address1_desa_id');
			$pplpkl->address1_kelurahan = $request->input('address1_kelurahan');
			$pplpkl->address1_kecamatan_id = $request->input('address1_kecamatan_id');
			$pplpkl->address1_kecamatan = $request->input('address1_kecamatan');
			$pplpkl->address1_kabupaten_id = $request->input('address1_kabupaten_id');
			$pplpkl->address1_kabupaten = $request->input('address1_kabupaten');
			$pplpkl->address1_provinsi_id = $request->input('address1_provinsi_id');
			$pplpkl->address1_provinsi = $request->input('address1_provinsi');
			$pplpkl->alamat_pplpkl = $request->input('alamat_pplpkl');
			$pplpkl->size_baju = $request->input('size_baju');
			$pplpkl->keterangan = $request->input('keterangan');
			$pplpkl->save();

			
			return Response()->json([
										'status'=>1,
										'pid'=>'update', 
										'pplpkl'=>$pplpkl,                                     
										'message'=>'Data PPL / PKL  berhasil diubah'
									], 200);  
		}
		else 
		{
			return Response()->json([
									'status'=>0,
									'pid'=>'update',    
									'message'=>["PPL / PKL dengan ($id) gagal diupdate karean sudah diverifikasi"]
								], 422); 
		}
	}
	/**
	 * digunakan untul menyimpan ujian munaqasah mahasiswa
	 */
	public function verifikasi (Request $request,$id)
	{
		$this->hasPermissionTo('AKADEMIK-PERKULIAHAN-PPL-PKL_UPDATE');
		
		if ($this->hasRole('mahasiswa'))
		{
			$ujian = PPLPKLModel::where('id',$id)
										->find($id);                                  
			
		}
		else
		{
			$ujian = PPLPKLModel::where('id',$id)
										->find($id);                                  
		}
		if (is_null($ujian))
		{
			return Response()->json([
									'status'=>0,
									'pid'=>'fetchdata',    
									'message'=>["Data PPL / PKL dengan ID ($id) gagal diperoleh"]
								], 422); 
		}
		else
		{
			$user_id = $ujian->user_id;
			$mahasiswa = RegisterMahasiswaModel::join('pe3_formulir_pendaftaran','pe3_register_mahasiswa.user_id','pe3_formulir_pendaftaran.user_id')
												->find($ujian->user_id);

			$daftar_persyaratan = $this->persyaratan(
				PersyaratanPPLPKLModel::select(\DB::raw('
													*,
													"" AS nama_status
												'))
												->where('user_id',$user_id)
												->get(),
				$mahasiswa
			);
			
			if ($this->isverified())
			{
				$ujian->status = 1;
				$ujian->save();

				return Response()->json([
											'status'=>1,
											'pid'=>'update', 
											'ujian'=>$ujian,                                     
											'message'=>'Data ujian munaqasah berhasil diubah'
										], 200);  
			}
			else
			{
				return Response()->json([
											'status'=>0,
											'pid'=>'update', 
											'ujian'=>$ujian,                                     
											'message'=>'Data ujian munaqasah berhasil diverifikasi karena item persyaratan ada yang belum diperiksa.'
										], 422);  
			}
		}
	}
	/**
	 * digunakan untul menyimpan ujian munaqasah mahasiswa
	 */
	public function updatepersyaratan (Request $request,$id)
	{
		$this->hasPermissionTo('AKADEMIK-PERKULIAHAN-PPL-PKL_UPDATE');
		
		$persyaratan = PersyaratanPPLPKLModel::find($id);                                  
		
		if (is_null($persyaratan))
		{
			return Response()->json([
									'status'=>0,
									'pid'=>'fetchdata',    
									'message'=>["Data Persyaratan PPL / PKL dengan ID ($id) gagal diperoleh"]
								], 422); 
		}
		else
		{
			$persyaratan->status=1;
			$persyaratan->save();

			return Response()->json([
										'status'=>1,
										'pid'=>'update', 
										'persyaratan'=>$persyaratan,                                     
										'message'=>'Data persyaratan ujian munaqasah berhasil diubah'
									], 200);  
		}
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request,$id)
	{ 
		$this->hasPermissionTo('AKADEMIK-PERKULIAHAN-PPL-PKL_STORE');

		$pplpkl = PPLPKLModel::find($id); 
		
		if (is_null($pplpkl))
		{
			return Response()->json([
									'status'=>0,
									'pid'=>'destroy',    
									'message'=>["PPL / PKL dengan ($id) gagal dihapus"]
								], 422); 
		}
		else if ($pplpkl->status == 0)
		{
			\App\Models\System\ActivityLog::log($request,[
															'object' => $pplpkl, 
															'object_id' => $pplpkl->id, 
															'user_id' => $this->getUserid(), 
															'message' => 'Menghapus PPL / PKL dengan id ('.$id.') berhasil'
														]);

			$pplpkl->delete();
			return Response()->json([
										'status'=>1,
										'pid'=>'destroy',    
										'message'=>"PPL / PKL dengan ID ($id) berhasil dihapus"
									], 200);    
		}
		else 
		{
			return Response()->json([
									'status'=>0,
									'pid'=>'destroy',    
									'message'=>["PPL / PKL dengan ($id) gagal dihapus karean sudah diverifikasi"]
								], 422); 
		}
				  
	}
	private function persyaratan($daftar_persyaratan,$mahasiswa) 
	{
		$daftar_persyaratan->transform(function ($item,$key) use ($mahasiswa) {                
			switch($item->persyaratan_id) {
				case '2021-ujian-munaqasah-1' : //Pembayaran Uang SPP
					$this->persyaratan_verified[]=$item->status == 1;
				break;
				case '2021-ujian-munaqasah-2' : //Pembayaran Uang SKRIPSI
					$detail1 = \DB::table('pe3_transaksi') 
								->join('pe3_transaksi_detail', 'pe3_transaksi.id','pe3_transaksi_detail.transaksi_id')
								->where('pe3_transaksi.user_id', $mahasiswa->user_id)   
								->where('status', 1)
								->where('kombi_id',601)
								->exists();
					
					if ($detail1)
					{
						$item->keterangan = "SUDAH BAYAR";
						$this->persyaratan_complete[]=true;
						$this->persyaratan_verified[]=true;
					}
					else 
					{  
						$item->keterangan =  "BELUM BAYAR"; 
						$this->persyaratan_verified[]=false;
					}          
				break;
				case '2021-ujian-munaqasah-4' : //Matakuliah Skripsi terdapat di KRS
					$detail1 = \DB::table('pe3_prodi_detail1')
									->where('ta',$mahasiswa->tahun)
									->where('prodi_id',$mahasiswa->kjur)
									->first();
									
					if (is_null($detail1->matkul_skripsi)) 
					{
						$item->keterangan = "MATAKULIAH SKRIPSI BELUM DISET";
						$this->persyaratan_complete[]=false;
						$this->persyaratan_verified[]=false;
					}
					else 
					{
						$this->persyaratan_complete[]=true;
						$this->persyaratan_verified[]=true;
						$item->keterangan = \DB::table('pe3_krsmatkul') 
											->join('pe3_penyelenggaraan', 'pe3_penyelenggaraan.id','pe3_krsmatkul.penyelenggaraan_id')
											->where('nim', $mahasiswa->nim)   
											->where('matkul_id',$detail1->matkul_skripsi)
											->exists() 
											? "ADA" 
											: "TIDAK ADA"; 
											
					}          
				break;
				case '2021-ujian-munaqasah-5' : //Jadwal konsultasi pembimbing                    
					if (is_null($item->file))
					{
						$item->keterangan = 'TIDAK ADA';
						$this->persyaratan_verified[]=false;
					}
					else
					{
						$this->persyaratan_verified[]=$item->status == 1;
					}
				break;
				case '2021-ujian-munaqasah-6' : //Scanan STTB / Ijazah Terakhir
					if (is_null($item->file))
					{
						$item->keterangan = 'TIDAK ADA';
						$this->persyaratan_verified[]=false;
					}
					else
					{
						$this->persyaratan_verified[]=$item->status == 1;
					}          
				break;           
				case '2021-ujian-munaqasah-7' : //Scanan KTP
					if (is_null($item->file))
					{
						$item->keterangan = 'TIDAK ADA';
						$this->persyaratan_verified[]=false;
					}
					else
					{
						$this->persyaratan_verified[]=$item->status == 1;
					}
				break;           
				case '2021-ujian-munaqasah-8' : //Pas Photo 3x4
					if (is_null($item->file))
					{
						$item->keterangan = 'TIDAK ADA';
						$this->persyaratan_verified[]=false;
					}
					else
					{
						$this->persyaratan_verified[]=$item->status == 1;
					}
				break;           
				case '2021-ujian-munaqasah-9' : //Sertifikat OSPEK / PBAK
					if (is_null($item->file))
					{
						$item->keterangan = 'TIDAK ADA';
						$this->persyaratan_verified[]=false;
					}
					else
					{
						$this->persyaratan_verified[]=$item->status == 1;
					}
				break;           
			}
			switch($item->status) {
				case 0:
					$item->nama_status = 'BELUM DIPERIKSA';
				break;
				case 1:
					$item->nama_status = 'SUDAH DIPERIKSA';
				break;
			}
			return $item;
		});
		return $daftar_persyaratan;
	}       
	private function iscomplete()
	{
		$bool = true;
		foreach ($this->persyaratan_complete as $v)
		{
			if (!$v)
			{
				$bool = false;
				break;
			}
		}
		return $bool;
	}
	private function isverified() 
	{
		$bool = true;
		foreach ($this->persyaratan_verified as $v)
		{
			if (!$v)
			{
				$bool = false;
				break;
			}
		}
		return $bool;
	}
}