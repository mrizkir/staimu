<?php

namespace App\Logic;

use App\Models\Akademik\RekapTranskripKurikulumModel;
use App\Models\Akademik\MatakuliahModel;
use App\Models\Akademik\KRSMatkulModel;

class LogicNilai {
	/**
	 * digunakan untuk menampung data mahasiswa
	 */
	private $dataMHS;
	/**
	 * digunakan untuk menampung data transkrip
	 */
	private $dataTranskrip = [];

	public function __construct($dataMhs)
	{
		$this->dataMhs = $dataMhs;
	}
	public function setDataMhs($dataMhs)
	{
		$this->dataMhs = $dataMhs;
	}
	public function getTranskrip($temp=true)
	{
		$daftar_matkul=MatakuliahModel::select(\DB::raw('
																								0 AS no,
																								id,
																								group_alias,                                    
																								kmatkul,
																								nmatkul,
																								sks,
																								semester,
																								\'-\' AS HM,
																								\'-\' AS AM,
																								\'-\' AS M                                              
																						'))
																						->where('kjur',$this->dataMhs->kjur)
																						->where('ta',$this->dataMhs->tahun)   
																						->orderBy('semester','ASC')                      
																						->orderBy('kmatkul','ASC')    
																						->get();

		$jumlah_sks=0;            
		$jumlah_sks_nilai=0;            
		$jumlah_am=0;
		$jumlah_m=0;
		$jumlah_matkul=0;

		$user_id=$this->dataMhs->user_id;
		$data_konversi=\DB::table('pe3_nilai_konversi1')
							->where('user_id',$user_id)
							->first();

		$daftar_nilai=[];
		foreach ($daftar_matkul as $key=>$item)
		{                
			$nilai=\DB::table('pe3_nilai_matakuliah AS A')
						->select(\DB::raw('
							A.n_kual,                                
							A.n_mutu
						'))
						->join('pe3_krsmatkul AS B','A.krsmatkul_id','B.id')
						->join('pe3_krs AS C','B.krs_id','C.id')
						->join('pe3_penyelenggaraan AS D','A.penyelenggaraan_id','D.id')
						->where('C.user_id',$user_id)
						->where('D.matkul_id',$item->id)
						->orderBy('n_mutu','desc')
						->limit(1)
						->get();
			
			$HM=$item->HM;
			$AM=$item->AM;
			$M=$item->M;

			if (isset($nilai[0]))
			{
				$HM=$nilai[0]->n_kual;
				$AM=number_format($nilai[0]->n_mutu,0);
				$M=$AM*$item->sks;
				$jumlah_m+=$M;
				$jumlah_am+=$AM;
				$jumlah_matkul+=1;
				$jumlah_sks_nilai+=$item->sks;
			}
			if (!is_null($data_konversi))
			{
				$n_kual_konversi=\DB::table('pe3_nilai_konversi2')                        
					->where('nilai_konversi_id',$data_konversi->id)
					->where('matkul_id',$item->id)
					->value('n_kual');

				if (!is_null($n_kual_konversi))
				{
					if ($HM == '-')
					{
						$HM=$n_kual_konversi;
						$AM=\App\Helpers\HelperAkademik::getNilaiMutu($HM);
					}
					else
					{
						$HM_KONVERSI=$n_kual_konversi;
						$AM_KONVERSI=\App\Helpers\HelperAkademik::getNilaiMutu($HM);                            
						if ($AM_KONVERSI>$AM)
						{
							$HM=$HM_KONVERSI;
							$AM=$AM_KONVERSI;
						}
					}                        
					$M=$AM*$item->sks;
					$jumlah_m+=$M;
					$jumlah_am+=$AM;
					$jumlah_matkul+=1;
					$jumlah_sks_nilai+=$item->sks;
				}
			}
			$daftar_nilai[]=[
				'id'=>$item->id,
				'no'=>$key+1,
				'kmatkul'=>$item->kmatkul,
				'nmatkul'=>$item->nmatkul,
				'sks'=>$item->sks,
				'semester'=>$item->semester,
				'group_alias'=>$item->group_alias,
				'HM'=>$HM,
				'AM'=>$AM,
				'M'=>$M
			];

			$jumlah_sks+=$item->sks;                 
		}         
		$ipk=\App\Helpers\HelperAkademik::formatIPK($jumlah_m,$jumlah_sks_nilai);            
		$rekap=RekapTranskripKurikulumModel::find($user_id);
		if (is_null($rekap))
		{

			RekapTranskripKurikulumModel::create([
				'user_id'=>$user_id,
				'jumlah_matkul'=>$jumlah_matkul,
				'jumlah_sks'=>$jumlah_sks_nilai,
				'jumlah_am'=>$jumlah_am,
				'jumlah_m'=>$jumlah_m,
				'ipk'=>$ipk,
			]);   
		}
		else
		{
			$rekap->jumlah_matkul=$jumlah_matkul;
			$rekap->jumlah_sks=$jumlah_sks_nilai;
			$rekap->jumlah_am=$jumlah_am;
			$rekap->jumlah_m=$jumlah_m;
			$rekap->ipk=$ipk;

			$rekap->save();
		}
		$this->dataTranskrip = [
								'jumlah_matkul'=>$jumlah_matkul, 
								'nilai_matakuliah'=>$daftar_nilai,              
								'jumlah_sks'=>$jumlah_sks,              
								'jumlah_sks_nilai'=>$jumlah_sks_nilai,              
								'jumlah_am'=>$jumlah_am,              
								'jumlah_m'=>$jumlah_m,              
								'ipk'=>$ipk,
							]; 

		return $this->dataTranskrip;
	}
	public function getIPKByLastTASMT($tasmt)
	{
		$user_id = $this->dataMhs->user_id;

		$subquery=\DB::table('pe3_krs AS A')
													->select(\DB::raw('
														D.krsmatkul_id,
														C.matkul_id,	
														MAX(D.n_mutu) AS n_mutu
												'))                      
												->join('pe3_krsmatkul AS B','B.krs_id','A.id')
												->join('pe3_penyelenggaraan AS C','C.id','B.penyelenggaraan_id')
												->join('pe3_nilai_matakuliah AS D','B.id','D.krsmatkul_id')
												->where('A.user_id',$user_id)
												->where('A.tasmt','<=',$tasmt)
												->groupBy('C.matkul_id')
												->groupBy('D.krsmatkul_id');

		$data = \DB::table('pe3_nilai_matakuliah AS A1')
								->select(\DB::raw('
									A1.n_mutu * C1.sks AS n_mutu,
									C1.sks
								'))
								->joinSub($subquery,'B1', function($join){
									$join->on('A1.krsmatkul_id','B1.krsmatkul_id');
								})
								->join('pe3_penyelenggaraan AS C1','A1.penyelenggaraan_id','C1.id')
								->get();		
		
		$total_sks = $data->sum('sks');
		$n_mutu = $data->sum('n_mutu');

		$ipk=\App\Helpers\HelperAkademik::formatIPK($n_mutu, $total_sks);
		$data= [
			'ipk'=>$ipk,
			'n_mutu'=>$n_mutu,
			'total_sks'=>$total_sks,
		];
		return $data;
	}
}
