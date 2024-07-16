<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Akademik\PenyelenggaraanMatakuliahModel;
use App\Models\DMaster\ProgramStudiModel;
use App\Models\Akademik\RegisterMahasiswaModel;
use App\Models\Akademik\DulangModel;
use App\Models\Akademik\KRSModel;
use App\Models\Akademik\KRSMatkulModel;
use App\Logic\LogicNilai;
use App\Helpers\HelperAkademik;

use App\Models\System\ConfigurationModel;

use Ramsey\Uuid\Uuid;

class NilaiKHSController extends Controller
{
  /**
   * daftar krs
   */
  public function index(Request $request)
  {
	  $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-KRS_BROWSE');
	  $daftar_khs=[];

	  if ($this->hasRole(['superadmin','akademik','programstudi','puslahta']))
	  {
		  $this->validate($request, [
			  'ta'=>'required',
			  'semester_akademik'=>'required',
			  'prodi_id'=>'required'
		  ]);

		  $ta=$request->input('ta');
		  $prodi_id=$request->input('prodi_id');
		  $semester_akademik=$request->input('semester_akademik');

		  $daftar_khs = KRSModel::select(\DB::raw('
								  pe3_krs.id,
								  pe3_krs.nim,
								  pe3_formulir_pendaftaran.nama_mhs,
								  pe3_krs.tasmt,
								  pe3_krs.sah,
								  pe3_formulir_pendaftaran.ta AS tahun_masuk,
								  0 AS jumlah_matkul,
								  0 AS jumlah_sks,
								  ips,
								  ipk,
								  pe3_krs.created_at,
								  pe3_krs.updated_at
							  '))
							  ->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_krs.user_id')
							  ->orderBy('nama_mhs','ASC');

		  if ($request->has('search'))
		  {
			  $daftar_khs=$daftar_khs->whereRaw('(pe3_krs.nim LIKE \''.$request->input('search').'%\' OR pe3_formulir_pendaftaran.nama_mhs LIKE \'%'.$request->input('search').'%\')')        
						  ->orderBy('tasmt','desc')
						  ->get();
		  }  
		  else
		  {
			  $daftar_khs=$daftar_khs->where('pe3_krs.kjur',$prodi_id)
									  ->where('pe3_krs.tahun',$ta)
									  ->where('pe3_krs.idsmt',$semester_akademik)
									  ->get();
		  }
		  $daftar_khs->transform(function ($item,$key) {                
			  $item->jumlah_matkul=\DB::table('pe3_krsmatkul')->where('krs_id',$item->id)->count();
			  $item->jumlah_sks=\DB::table('pe3_krsmatkul')
									  ->join('pe3_penyelenggaraan','pe3_penyelenggaraan.id','pe3_krsmatkul.penyelenggaraan_id')
									  ->where('krs_id',$item->id)->sum('pe3_penyelenggaraan.sks');
			  return $item;
		  });
	  }
	  else if ($this->hasRole('mahasiswa'))
	  {
		  $daftar_khs = KRSModel::select(\DB::raw('
								  pe3_krs.id,
								  pe3_krs.nim,
								  pe3_formulir_pendaftaran.nama_mhs,
								  pe3_krs.tasmt,
								  pe3_krs.sah,
								  pe3_formulir_pendaftaran.ta AS tahun_masuk,
								  0 AS jumlah_matkul,
								  0 AS jumlah_sks,
								  ips,
								  ipk,
								  pe3_krs.created_at,
								  pe3_krs.updated_at
							  '))
							  ->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_krs.user_id')
							  ->where('nim', $this->getUsername())
							  ->orderBy('tasmt','DESC')
							  ->get();

		  $daftar_khs->transform(function ($item,$key) {
			  
			  $item->jumlah_matkul=\DB::table('pe3_krsmatkul')->where('krs_id',$item->id)->count();
			  $item->jumlah_sks=\DB::table('pe3_krsmatkul')
									  ->join('pe3_penyelenggaraan','pe3_penyelenggaraan.id','pe3_krsmatkul.penyelenggaraan_id')
									  ->where('krs_id',$item->id)->sum('pe3_penyelenggaraan.sks');
			  return $item;
		  });
	  }
	  return Response()->json([
								  'status'=>1,
								  'pid'=>'fetchdata',  
								  'daftar_khs'=>$daftar_khs,
								  'message'=>'Daftar khs mahasiswa berhasil diperoleh' 
							  ], 200);  
	  
  }
  public function show (Request $request,$id)
  {
	  $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-KRS_SHOW');

	  $krs=KRSModel::select(\DB::raw('
					  pe3_krs.id,
					  pe3_krs.user_id,
					  pe3_krs.nim,
						pe3_register_mahasiswa.nirm,
						pe3_formulir_pendaftaran.no_formulir,	
					  pe3_formulir_pendaftaran.nama_mhs,
						pe3_formulir_pendaftaran.jk,				
					  pe3_register_mahasiswa.tahun AS tahun_pendaftaran,
						pe3_kelas.nkelas,

						pe3_dosen.nidn,
						CONCAT(COALESCE(pe3_dosen.gelar_depan,"")," ",pe3_dosen.nama_dosen," ",COALESCE(pe3_dosen.gelar_belakang,"")) AS nama_dosen,						

					  jumlah_matkul_1,
					  jumlah_sks_1,
					  jumlah_am_1,
					  jumlah_m_1,

					  jumlah_matkul_2,
					  jumlah_sks_2,
					  jumlah_am_2,
					  jumlah_m_2,

					  ipk,
					  ips,

					  pe3_krs.kjur,
					  pe3_krs.tahun,
					  pe3_krs.idsmt,
					  pe3_krs.tasmt,
					  pe3_krs.sah,
						pe3_krs.locked,
					  pe3_krs.created_at,
					  pe3_krs.updated_at
				  '))
					->join('pe3_register_mahasiswa','pe3_register_mahasiswa.user_id','pe3_krs.user_id')
				  ->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_krs.user_id')
					->join('pe3_kelas','pe3_kelas.idkelas','pe3_register_mahasiswa.idkelas')
					->leftJoin('pe3_dosen','pe3_dosen.user_id','pe3_register_mahasiswa.dosen_id')
				  ->find($id);

	  $daftar_matkul=[];

	  if (is_null($krs))
	  {
		  return Response()->json([
								  'status'=>0,
								  'pid'=>'destroy',    
								  'message'=>["KRS dengan ($id) gagal diperoleh"]
							  ], 422); 
	  }
		elseif($krs->locked == true && $this->hasRole(['mahasiswa', 'mahasiswabaru']))
		{
			$keterangan = 'semester ' . HelperAkademik::getSemester($krs->idsmt) . ' T.A ' . $krs->tahun . '/' .($krs->tahun + 1);
			return Response()->json([
				'status'=>0,
				'pid'=>'fetchdata',    
				'message'=>["Hubungi Bagian Keuangan untuk membuka KHS $keterangan ini"]
			], 422); 
		}
	  else
	  {
		  $daftar_matkul=KRSMatkulModel::select(\DB::raw('
										  pe3_krsmatkul.id,
										  pe3_krsmatkul.penyelenggaraan_id,
										  C.kelas_mhs_id,
										  A.kmatkul,
										  A.nmatkul,
										  A.sks,
										  A.semester,
										  NULL AS nama_dosen_penyelenggaraan,
										  NULL AS  nama_dosen_kelas,
										  \'\' AS nama_dosen,
										  COALESCE(pe3_kelas_mhs.nmatkul,\'N.A\') AS nama_kelas,
										  COALESCE(G.n_kual,\'-\') AS HM,
										  COALESCE(G.n_mutu,\'-\') AS AM,
										  \'-\' AS M,
										  pe3_krsmatkul.created_at,
										  pe3_krsmatkul.updated_at
									  '))
									  ->join('pe3_penyelenggaraan AS A','A.id','pe3_krsmatkul.penyelenggaraan_id')
									  ->leftJoin('pe3_dosen AS B','A.user_id','B.user_id')
									  ->leftJoin('pe3_kelas_mhs_peserta AS C','pe3_krsmatkul.id','C.krsmatkul_id') 
									  ->leftJoin('pe3_kelas_mhs','pe3_kelas_mhs.id','C.kelas_mhs_id')																				
									  ->leftJoin('pe3_nilai_matakuliah AS G','G.krsmatkul_id','pe3_krsmatkul.id')
									  ->where('pe3_krsmatkul.krs_id',$krs->id)
									  ->where('pe3_krsmatkul.batal', 0)
									  ->orderBy('semester','asc')
									  ->orderBy('kmatkul','asc')
									  ->get();
		  
		  $daftar_nilai=[];
		  $jumlah_matkul=0;
		  $jumlah_sks=0;
		  $jumlah_m=0;
		  $jumlah_am=0;
		  $ips=0;
		  $ipk=0;
		  foreach ($daftar_matkul as $key=>$item)
		  {
			  $nama_dosen = 'N.A';
			  $dosen_kelas = \DB::table('pe3_kelas_mhs_penyelenggaraan AS A')
				->select(\DB::raw("
				  CONCAT(COALESCE(C.gelar_depan,' '),C.nama_dosen,' ',COALESCE(C.gelar_belakang,'')) AS nama_dosen_kelas
				"))
				->join('pe3_penyelenggaraan_dosen AS B','A.penyelenggaraan_dosen_id','B.id')
				->join('pe3_dosen AS C','C.user_id','B.user_id')
				->where('A.kelas_mhs_id', $item->kelas_mhs_id)
				->where('B.penyelenggaraan_id', $item->penyelenggaraan_id)
				->first();

			  if (is_null($dosen_kelas))
			  {
				$dosen_penyelenggaraan = \DB::table('pe3_penyelenggaraan AS A')
				  ->select(\DB::raw("
					CONCAT(COALESCE(B.gelar_depan,' '),B.nama_dosen,' ',COALESCE(B.gelar_belakang,'')) AS nama_dosen_penyelenggaraan
				  "))										
				  ->join('pe3_dosen AS B','A.user_id','B.user_id')										
				  ->where('A.id', $item->penyelenggaraan_id)
				  ->first();

				  if (!is_null($dosen_penyelenggaraan))
				  {											
					$nama_dosen  = $dosen_penyelenggaraan->nama_dosen_penyelenggaraan;
				  }
			  }
			  else
			  {
				$nama_dosen = $dosen_kelas->nama_dosen_kelas;
			  }

			  if ($item->HM=='-')
			  {
				  $M='-';
			  }
			  else
			  {
				  $M=$item->sks*$item->AM;
				  $jumlah_m+=$M;
				  $jumlah_am+=$item->AM;
			  }      
			  $daftar_nilai[]=[
				  'no'=>$key+1,
				  'penyelenggaran_id'=>$item->penyelenggaraan_id,
				  'kelas_mhs_id'=>$item->kelas_mhs_id,
				  'nama_dosen'=>$nama_dosen,
				  'kmatkul'=>$item->kmatkul,
				  'nmatkul'=>$item->nmatkul,
				  'sks'=>$item->sks,
				  'HM'=>$item->HM,
				  'AM'=>$item->AM,
				  'M'=>$M,
				  'nama_dosen'=>$nama_dosen,
				  'nama_kelas'=>$item->nama_kelas,
			  ];
			  $jumlah_sks+=$item->sks;
			  $jumlah_matkul+=1;   
		  }      
		  $ips=\App\Helpers\HelperAkademik::formatIPK($jumlah_m,$jumlah_sks);

		  $krs->jumlah_matkul_1=$jumlah_matkul;
		  $krs->jumlah_sks_1=$jumlah_sks;
		  $krs->jumlah_am_1=$jumlah_am;
		  $krs->jumlah_m_1=$jumlah_m;

		  $krs->ips=$ips;
		  $nilai = new LogicNilai (RegisterMahasiswaModel::find($krs->user_id));						
			$data = $nilai->getIPKByLastTASMT($krs->tasmt);
		  $krs->ipk = $data['ipk'];
		  $krs->jumlah_sks_2 = $data['total_sks'];
		  $krs->save();

		  return Response()->json([
									  'status'=>1,
									  'pid'=>'fetchdata',  
									  'krs'=>$krs,
									  'daftar_nilai'=>$daftar_nilai,
									  'jumlah_matkul'=>$jumlah_matkul,
									  'jumlah_sks'=>$jumlah_sks,
									  'jumlah_sks_2'=>$krs->jumlah_sks_2,
									  'jumlah_m'=>$jumlah_m,
									  'jumlah_am'=>$jumlah_am,
									  'ipk'=>$krs->ipk ,
									  'ips'=>$ips,
									  'message'=>'Fetch data khs dan detail khs mahasiswa berhasil diperoleh' 
								  ],200)->setEncodingOptions(JSON_NUMERIC_CHECK);  
	  }        
  }		
  public function printpdf(Request $request,$id)
  {
		$this->hasPermissionTo('AKADEMIK-PERKULIAHAN-KRS_SHOW');

		$krs = KRSModel::select(\DB::raw('
			pe3_krs.id,
			pe3_krs.user_id,
			pe3_krs.nim,
			pe3_register_mahasiswa.nirm,
			pe3_formulir_pendaftaran.nama_mhs,
			pe3_formulir_pendaftaran.jk,
			
			jumlah_matkul_1,
			jumlah_sks_1,
			jumlah_am_1,
			jumlah_m_1,

			jumlah_matkul_2,
			jumlah_sks_2,
			jumlah_am_2,
			jumlah_m_2,

			ipk,
			ips,

			pe3_krs.kjur,
			pe3_prodi.nama_prodi,
			pe3_krs.tahun,
			pe3_krs.idsmt,            
			pe3_krs.tasmt,
			pe3_krs.sah,
			pe3_krs.locked,
			pe3_krs.created_at,
			pe3_krs.updated_at
		'))
		->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_krs.user_id')
		->join('pe3_register_mahasiswa','pe3_register_mahasiswa.user_id','pe3_krs.user_id')
		->join('pe3_prodi','pe3_register_mahasiswa.kjur','pe3_prodi.id')
		->find($id);

	  if (is_null($krs))
	  {
			return Response()->json([
									'status'=>0,
									'pid'=>'fetchdata',    
									'message'=>["KRS dengan ($id) gagal diperoleh"]
								], 422); 
	  }
	  elseif($krs->locked == true && $this->hasRole(['mahasiswa', 'mahasiswabaru']))
		{
			$keterangan = 'semester ' . HelperAkademik::getSemester($krs->idsmt) . ' T.A ' . $krs->tahun . '/' .($krs->tahun + 1);
			return Response()->json([
				'status'=>0,
				'pid'=>'fetchdata',    
				'message'=>["Hubungi Bagian Keuangan untuk membuka KHS $keterangan ini"]
			], 422); 
		}
		else
	  {
			$prodi = new ProgramStudiModel();
			$kaprodi=$prodi->getKAProdi($krs->kjur);
			if (!is_null($kaprodi))
			{            
				$daftar_matkul=KRSMatkulModel::select(\DB::raw('
					pe3_krsmatkul.id,
					pe3_krsmatkul.penyelenggaraan_id,
					C.kelas_mhs_id,
					A.kmatkul,
					A.nmatkul,
					A.sks,
					A.semester,
					NULL AS nama_dosen_penyelenggaraan,
					NULL AS  nama_dosen_kelas,
					\'\' AS nama_dosen,
					COALESCE(pe3_kelas_mhs.nmatkul,\'N.A\') AS nama_kelas,
					COALESCE(G.n_kual,\'-\') AS HM,
					COALESCE(G.n_mutu,\'-\') AS AM,
					\'-\' AS M,
					pe3_krsmatkul.created_at,
					pe3_krsmatkul.updated_at
				'))
				->join('pe3_penyelenggaraan AS A','A.id','pe3_krsmatkul.penyelenggaraan_id')
				->leftJoin('pe3_dosen AS B','A.user_id','B.user_id')
				->leftJoin('pe3_kelas_mhs_peserta AS C','pe3_krsmatkul.id','C.krsmatkul_id') 
				->leftJoin('pe3_kelas_mhs','pe3_kelas_mhs.id','C.kelas_mhs_id')
				->leftJoin('pe3_nilai_matakuliah AS G','G.krsmatkul_id','pe3_krsmatkul.id')
				->where('pe3_krsmatkul.krs_id',$krs->id)
				->where('pe3_krsmatkul.batal', 0)
				->orderBy('semester','asc')
				->orderBy('kmatkul','asc')
				->get();
			  
				$daftar_nilai=[];
				$jumlah_matkul=0;
				$jumlah_sks=0;
				$jumlah_m=0;
				$jumlah_am=0;
				$ips=0;
				$ipk=0;

				foreach ($daftar_matkul as $key=>$item)
				{
					$nama_dosen = 'N.A';
					$dosen_kelas = \DB::table('pe3_kelas_mhs_penyelenggaraan AS A')
						->select(\DB::raw("
							CONCAT(COALESCE(C.gelar_depan,' '),C.nama_dosen,' ',COALESCE(C.gelar_belakang,'')) AS nama_dosen_kelas
							"))
							->join('pe3_penyelenggaraan_dosen AS B','A.penyelenggaraan_dosen_id','B.id')
							->join('pe3_dosen AS C','C.user_id','B.user_id')
							->where('A.kelas_mhs_id', $item->kelas_mhs_id)
							->where('B.penyelenggaraan_id', $item->penyelenggaraan_id)
							->first();

					if (is_null($dosen_kelas))
					{
						$dosen_penyelenggaraan = \DB::table('pe3_penyelenggaraan AS A')
						->select(\DB::raw("
							CONCAT(COALESCE(B.gelar_depan,' '),B.nama_dosen,' ',COALESCE(B.gelar_belakang,'')) AS nama_dosen_penyelenggaraan
						"))										
						->join('pe3_dosen AS B','A.user_id','B.user_id')										
						->where('A.id', $item->penyelenggaraan_id)
						->first();

						if (!is_null($dosen_penyelenggaraan))
						{											
							$nama_dosen  = $dosen_penyelenggaraan->nama_dosen_penyelenggaraan;
						}
					}
					else
					{
						$nama_dosen = $dosen_kelas->nama_dosen_kelas;
					}			
					if ($item->HM=='-')
					{
						$M='-';
						$daftar_nilai[]=[
							'no'=>$key+1,
							'nama_dosen'=>$nama_dosen,
							'kmatkul'=>$item->kmatkul,
							'nmatkul'=>$item->nmatkul,
							'sks'=>$item->sks,
							'HM'=>$item->HM,
							'AM'=>$item->AM,
							'M'=>$M,
							'nama_dosen'=>$nama_dosen,
						];
					}
					else
					{
						$M=$item->sks*$item->AM;
						$jumlah_m+=$M;
						$jumlah_am+=$item->AM;          
						$daftar_nilai[]=[
							'no'=>$key+1,
							'nama_dosen'=>$nama_dosen,
							'kmatkul'=>$item->kmatkul,
							'nmatkul'=>$item->nmatkul,
							'sks'=>$item->sks,
							'HM'=>$item->HM,
							'AM'=>number_format($item->AM,0),
							'M'=>number_format($M,0),
							'nama_dosen'=>$nama_dosen,
						];
					}          
					$jumlah_sks+=$item->sks;
					$jumlah_matkul+=1;           
				}      
				$ips=\App\Helpers\HelperAkademik::formatIPK($jumlah_m,$jumlah_sks);

				$krs->jumlah_matkul_1=$jumlah_matkul;
				$krs->jumlah_sks_1=$jumlah_sks;
				$krs->jumlah_am_1=$jumlah_am;
				$krs->jumlah_m_1=$jumlah_m;

				$krs->ips=$ips;
				$nilai = new LogicNilai (RegisterMahasiswaModel::find($krs->user_id));						
				$data = $nilai->getIPKByLastTASMT($krs->tasmt);
				$krs->ipk = $data['ipk'];					
				$krs->jumlah_sks_2 = $data['total_sks'];
				$krs->save();

				$config = ConfigurationModel::getCache();
				$headers=[
				'HEADER_1'=>$config['HEADER_1'],
				'HEADER_2'=>$config['HEADER_2'],
				'HEADER_3'=>$config['HEADER_3'],
				'HEADER_4'=>$config['HEADER_4'],
				'HEADER_ADDRESS'=>$config['HEADER_ADDRESS'],
				'HEADER_LOGO'=>\App\Helpers\Helper::public_path("images/logo.png")
				];
				$pdf = \Mccarlosen\LaravelMpdf\Facades\LaravelMpdf::loadView('report.ReportKHS',
																		[
																		'headers'=>$headers,
																		'data_krs'=>$krs,
																		'nama_semester'=>\App\Helpers\HelperAkademik::getSemester($krs->idsmt),
																		'daftar_nilai'=>$daftar_nilai,
																		'jumlah_matkul'=>$jumlah_matkul,
																		'jumlah_sks'=>$jumlah_sks,
																		'jumlah_sks_2'=>$krs->jumlah_sks_2,
																		'jumlah_m'=>$jumlah_m,
																		'jumlah_am'=>$jumlah_am,
																		'ipk'=>$krs->ipk,
																		'ips'=>$ips, 
																		'tanggal'=>\App\Helpers\Helper::tanggal('d F Y'),
																		'kaprodi'=>$kaprodi
																	],
																	[],
																	[
																		'title' => 'KHS',
																	]);

				$file_pdf=\App\Helpers\Helper::public_path("exported/pdf/khs_".$krs->id.'.pdf');
				$pdf->save($file_pdf);

				$pdf_file="exported/pdf/khs_".$krs->id.".pdf";

				return Response()->json([
										'status'=>1,
										'pid'=>'fetchdata',
										'krs'=>$krs,
										'pdf_file'=>$pdf_file                                    
									], 200);
			}
			else
			{
				return Response()->json([
										'status'=>0,
										'pid'=>'fetchdata',        
										'message'=>'Ketua program studi belum disetting di halaman Data Master -> Program Studi'
									], 422);
			}
		}
  }
  /**
   * cetak seluruh khs per prodi dan ta
   */
  public function printtoexcel1 (Request $request)
  {
	$this->hasPermissionTo('AKADEMIK-NILAI-KHS_BROWSE');				
	
	$this->validate($request, [           
	  'ta'=>'required',			
	  'prodi_id'=>'required',
	  'semester_akademik'=>'required',
	]);
		
	$prodi=ProgramStudiModel::find($request->input('prodi_id'));
	$data_report = [
	  'ta'=>$request->input('ta'),
	  'prodi_id'=>$request->input('prodi_id'),
	  'semester_akademik'=>$request->input('semester_akademik'),
	  'nama_prodi'=>$prodi->nama_prodi,
	  'nama_prodi'=>$prodi->nama_prodi . " (".$prodi->nama_jenjang.")",
	];

	$report= new \App\Models\Report\ReportAkademikKHSModel ($data_report);
	return $report->printtoexcel1();
  }
}
