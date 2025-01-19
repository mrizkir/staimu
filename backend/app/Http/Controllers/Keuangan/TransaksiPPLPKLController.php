<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Akademik\RegisterMahasiswaModel;
use App\Models\Keuangan\BiayaKomponenPeriodeModel;
use App\Models\Keuangan\TransaksiModel;
use App\Models\Keuangan\TransaksiDetailModel;

use Exception;

use Ramsey\Uuid\Uuid;

class TransaksiPPLPKLController extends Controller {  
  /**
   * daftar komponen biaya
   */
  public function index(Request $request)
  {
	  $this->hasPermissionTo('KEUANGAN-TRANSAKSI-PKL_BROWSE');
	  
	  if ($this->hasRole(['mahasiswa', 'mahasiswabaru']))
	  {
		  $this->validate($request, [           
			  'ta' => 'required',
			  'semester_akademik' => 'required|in:1,2,3',
		  ]);
  
		  $ta = $request->input('ta');
		  $idsmt=$request->input('semester_akademik');

		  $daftar_transaksi = TransaksiDetailModel::select(\DB::raw('
													  pe3_transaksi_detail.id,
													  pe3_transaksi_detail.user_id,
													  pe3_transaksi_detail.transaksi_id,
													  CONCAT(pe3_transaksi.no_transaksi,\' \') AS no_transaksi,
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
												  ->join('pe3_transaksi', 'pe3_transaksi_detail.transaksi_id', 'pe3_transaksi.id')
												  ->join('pe3_formulir_pendaftaran', 'pe3_formulir_pendaftaran.user_id', 'pe3_transaksi_detail.user_id')
												  ->join('pe3_status_transaksi', 'pe3_transaksi.status', 'pe3_status_transaksi.id_status')
												  ->where('pe3_transaksi.ta',$ta)
												  ->where('pe3_transaksi.idsmt',$idsmt)
												  ->where('pe3_transaksi_detail.user_id', $this->getUserid())
												  ->where('pe3_transaksi_detail.kombi_id',301)        
												  ->orderBy('pe3_transaksi.tanggal', 'DESC')
												  ->get();
	  }
	  else
	  {
		  $this->validate($request, [           
			  'ta' => 'required',
			  'semester_akademik' => 'required|in:1,2,3',
			  'prodi_id' => 'required',
		  ]);
  
		  $ta = $request->input('ta');
		  $idsmt=$request->input('semester_akademik');
		  $prodi_id = $request->input('prodi_id');
		  
		  $daftar_transaksi = TransaksiDetailModel::select(\DB::raw('
													  pe3_transaksi_detail.id,
													  pe3_transaksi_detail.user_id,
													  pe3_transaksi_detail.transaksi_id,
													  CONCAT(pe3_transaksi.no_transaksi,\' \') AS no_transaksi,
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
												  ->join('pe3_transaksi', 'pe3_transaksi_detail.transaksi_id', 'pe3_transaksi.id')
												  ->join('pe3_formulir_pendaftaran', 'pe3_formulir_pendaftaran.user_id', 'pe3_transaksi_detail.user_id')
												  ->join('pe3_status_transaksi', 'pe3_transaksi.status', 'pe3_status_transaksi.id_status')        
												  ->where('pe3_transaksi_detail.kombi_id',301)        
												  ->orderBy('pe3_transaksi.tanggal', 'DESC');                                               

		  if ($request->has('SEARCH'))
		  {
			  $daftar_transaksi=$daftar_transaksi->whereRaw('(pe3_transaksi.nim LIKE \''.$request->input('SEARCH').'%\' OR pe3_formulir_pendaftaran.nama_mhs LIKE \'%'.$request->input('SEARCH').'%\')')        
												  ->get();
		  }  
		  else
		  {
			  $daftar_transaksi=$daftar_transaksi->where('pe3_transaksi.ta',$ta)     
												  ->where('pe3_transaksi.idsmt',$idsmt)   
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
   * buat transaksi baru
   */
  public function store (Request $request)
  {
	  $this->hasPermissionTo('KEUANGAN-TRANSAKSI-PKL_STORE');

	  $this->validate($request, [           
		  'nim' => 'required|exists:pe3_register_mahasiswa,nim',     
		  'semester_akademik' => 'required',
		  'ta' => 'required'
	  ]);
	  $jumlah_syarat_matkul = 0;
	  try 
	  {
		  $nim=$request->input('nim');
		  $semester_akademik=$request->input('semester_akademik');
		  $ta = $request->input('ta');
		  
		  $transaksi=TransaksiDetailModel::select(\DB::raw('
											  1
										  '))
										  ->join('pe3_transaksi', 'pe3_transaksi_detail.transaksi_id', 'pe3_transaksi.id')
										  ->where('pe3_transaksi.ta',$ta)
										  ->where('pe3_transaksi.idsmt',$semester_akademik)
										  ->where('pe3_transaksi.nim',$nim)
										  ->where('pe3_transaksi_detail.kombi_id',301)
										  ->where(function($query) {
											  $query->where('pe3_transaksi.status',0)
												  ->orWhere('pe3_transaksi.status', 1);
										  })
										  ->first();

		  if (!is_null($transaksi))
		  {                
			  throw new Exception ("Transaksi tidak bisa dibuat karena ($nim) sudah melakukan transaksi pada $ta semester $semester_akademik.");  
		  }

		  $mahasiswa=RegisterMahasiswaModel::select(\DB::raw('
					pe3_register_mahasiswa.*,
					pe3_formulir_pendaftaran.no_formulir
				'))
				->join('pe3_formulir_pendaftaran', 'pe3_formulir_pendaftaran.user_id', 'pe3_register_mahasiswa.user_id')
				->where('nim', $nim)
				->first();

		  $tahun=$mahasiswa->tahun;
		  $idkelas=$mahasiswa->idkelas;
		  $kjur=$mahasiswa->kjur;
		  
		  $biaya_kombi=BiayaKomponenPeriodeModel::where('tahun',$tahun)
												  ->where('idkelas',$idkelas)
												  ->where('kjur',$kjur)
												  ->where('kombi_id',301)
												  ->value('biaya');
		  
		  if (!($biaya_kombi > 0))
		  {
			  throw new Exception ("Komponen Biaya PPL / PKL (301) belum disetting pada TA $tahun");  
		  }

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

		  $transaksi = \DB::transaction(function () use ($request, $mahasiswa, $biaya_kombi) {
			  $no_transaksi='301'.date('YmdHms');
			  $transaksi=TransaksiModel::create([
				  'id'=>Uuid::uuid4()->toString(),
				  'user_id' => $mahasiswa->user_id,
				  'no_transaksi' => $no_transaksi,
				  'no_faktur' => '',
				  'kjur' => $mahasiswa->kjur,
				  'ta' => $request->input('ta'),
				  'idsmt' => $request->input('semester_akademik'),
				  'idkelas' => $mahasiswa->idkelas,
				  'no_formulir' => $mahasiswa->no_formulir,
				  'nim' => $mahasiswa->nim,
				  'commited'=>0,
				  'total'=>0,
				  'tanggal'=>date('Y-m-d'),
				  'desc'=>null
			  ]); 
			  
			  $transaksi_detail=TransaksiDetailModel::create([
				  'id'=>Uuid::uuid4()->toString(),
				  'user_id' => $mahasiswa->user_id,
				  'transaksi_id' => $transaksi->id,
				  'no_transaksi' => $transaksi->no_transaksi,
				  'kombi_id'=>301,
				  'nama_kombi' => 'PPL / PKL',
				  'biaya' => $biaya_kombi,
				  'jumlah' => 1,
				  'sub_total' => $biaya_kombi    
			  ]);

			  $transaksi->total=$biaya_kombi;
			  $transaksi->desc='PPL / PKL '.$request->input('ta').$request->input('semester_akademik');
			  $transaksi->save();

			  return $transaksi;

		  });

		  return Response()->json([
									  'status' => 1,
									  'pid' => 'store',       
									  'transaksi' => $transaksi,
										'daftar_syarat' => $daftar_syarat,
									  'message' => 'Transaksi PPL / PKL berhasil di input.'
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
			  'pid' => 'store',
			  'message' => [$e->getMessage()],
				'matakuliah syarat' => $persyaratan_matkul,
		  ], 422); 
	  }        
  }
  public function destroy(Request $request,$id)
  {
	$this->hasPermissionTo('KEUANGAN-TRANSAKSI-PKL_DESTROY');

	if ($this->hasRole('mahasiswa'))
	{
	  $transaksi = TransaksiModel::where('user_id', $this->getUserid())
								  ->find($id); 
	}
	else
	{
	  $transaksi = TransaksiModel::find($id); 
	}        

	if (is_null($transaksi))
	{
	  return Response()->json([
							  'status'=>0,
							  'pid' => 'destroy',           
							  'transaksi' => $transaksi,     
							  'message' => ["Transaksi ppl / pkl dengan ($id) gagal dihapus"]
						  ], 422); 
	}
	else if ($transaksi->status==0)
	{
	  \App\Models\System\ActivityLog::log($request,[
													  'object' => $transaksi, 
													  'object_id' => $transaksi->id, 
													  'user_id' => $this->getUserid(), 
													  'message' => 'Menghapus transaksi ppl / pkl dengan id ('.$id.') berhasil'
												  ]);
	  $transaksi->delete();
	  return Response()->json([
								  'status' => 1,
								  'pid' => 'destroy',    
								  'message'=>"transaksi ppl / pkl dengan id ($id) berhasil dihapus"
							  ], 200);    
	}
	else
	{
	  return Response()->json([
							  'status' => 1,
							  'pid' => 'destroy',           
							  'transaksi' => $transaksi,     
							  'message' => ["Transaksi ppl / pkl dengan ($id) gagal dihapus"]
						  ], 422); 
	}
  }
}