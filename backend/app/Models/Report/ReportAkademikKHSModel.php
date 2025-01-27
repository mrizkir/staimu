<?php

namespace App\Models\Report;

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use \PhpOffice\PhpSpreadsheet\Cell\DataType;

use App\Models\Akademik\KRSModel;

use App\Helpers\Helper;
use App\Helpers\HelperAkademik;

class ReportAkademikKHSModel extends ReportModel
{   
  public function __construct($dataReport)
  {
	  parent::__construct($dataReport); 
  }    
  public function printtoexcel1()  
  {
		$ta=$this->dataReport['ta'];
		$prodi_id=$this->dataReport['prodi_id'];
		$nama_prodi=strtoupper($this->dataReport['nama_prodi']);
		$semester_akademik=$this->dataReport['semester_akademik'];    
		$nama_semester=HelperAkademik::getSemester($semester_akademik);    

		$this->spreadsheet->getProperties()->setTitle("Report Rekap KHS");
		$this->spreadsheet->getProperties()->setSubject("Report Rekap KHS");

		$sheet = $this->spreadsheet->getActiveSheet();        
		$sheet->setTitle ('REKAP KHS');

		$sheet->getParent()->getDefaultStyle()->applyFromArray([
			'font' => [
				'name' => 'Arial',
				'size' => '9',
			],
		]);

		$row=2;
		$sheet->mergeCells("A$row:I$row");				                
		$sheet->setCellValue("A$row","LAPORAN REKAPITULASI KARTU HASIL STUDI (KHS)");

		$row+=1;
		$sheet->mergeCells("A$row:I$row");		
		$sheet->setCellValue("A$row","PROGRAM STUDI $nama_prodi TAHUN AKADEMIK $ta SEMESTER $nama_semester"); 
		
		$styleArray=array( 
			'font' => array('bold' => true,'size'=>'11'),
			'alignment' => array('horizontal'=>Alignment::HORIZONTAL_CENTER,
								'vertical'=>Alignment::HORIZONTAL_CENTER),								
		);               
		
		$sheet->getStyle("A1:A$row")->applyFromArray($styleArray);

		$sheet->getRowDimension(26)->setRowHeight(22);
		$sheet->getColumnDimension('A')->setWidth(7);
		$sheet->getColumnDimension('B')->setWidth(25);
		$sheet->getColumnDimension('C')->setWidth(50);
		$sheet->getColumnDimension('D')->setWidth(17);
		$sheet->getColumnDimension('E')->setWidth(17);
		$sheet->getColumnDimension('F')->setWidth(17);
		$sheet->getColumnDimension('G')->setWidth(15);        
		
		$row+=2;        
		$sheet->setCellValue("A$row",'NO');        
		$sheet->setCellValue("B$row",'NIM');    
		$sheet->setCellValue("C$row",'NAMA MAHASISWA');    
		$sheet->setCellValue("D$row",'ANGK. ');    
		$sheet->setCellValue("E$row",'KELAS');    
		$sheet->setCellValue("F$row",'JUMLAH MATKUL');
		$sheet->setCellValue("G$row",'JUMLAH SKS');    
		$sheet->setCellValue("H$row",'IPS');    
		$sheet->setCellValue("I$row",'IPK');    
		

		$styleArray=array(
			'font' => array('bold' => true),
			'alignment' => array('horizontal'=>Alignment::HORIZONTAL_CENTER,
								'vertical'=>Alignment::HORIZONTAL_CENTER),
			'borders' => array('allBorders' => array('borderStyle' =>Border::BORDER_THIN))
		);
		$sheet->getStyle("A$row:I$row")->applyFromArray($styleArray);
		$sheet->getStyle("A$row:I$row")->getAlignment()->setWrapText(true);

		$data = KRSModel::select(\DB::raw('
											pe3_krs.id,
											pe3_krs.nim,
											pe3_formulir_pendaftaran.nama_mhs,
											pe3_krs.tasmt,
											pe3_krs.sah,
											pe3_kelas.nkelas,
											pe3_formulir_pendaftaran.ta AS tahun_masuk,
											0 AS jumlah_matkul,
											0 AS jumlah_sks,
											ips,
											ipk,
											pe3_krs.locked,
											pe3_krs.created_at,
											pe3_krs.updated_at
										'))
										->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_krs.user_id')                                
										->join('pe3_register_mahasiswa','pe3_register_mahasiswa.user_id','pe3_formulir_pendaftaran.user_id')
										->join('pe3_kelas','pe3_kelas.idkelas','pe3_register_mahasiswa.idkelas')
										->where('pe3_krs.kjur', $prodi_id)
										->where('pe3_krs.tahun', $ta)
										->where('pe3_krs.idsmt', $semester_akademik)                            
										->orderBy('nama_mhs','ASC')
										->get();
										
		$data->transform(function ($item,$key){								
			$item->jumlah_matkul=\DB::table('pe3_krsmatkul')->where('krs_id',$item->id)->count();
			$item->jumlah_sks=\DB::table('pe3_krsmatkul')
								->join('pe3_penyelenggaraan','pe3_penyelenggaraan.id','pe3_krsmatkul.penyelenggaraan_id')
								->where('krs_id',$item->id)
								->sum('pe3_penyelenggaraan.sks');
			return $item;
		});
		
		$row+=1;
		$row_awal=$row; 
		$no=1;
		$total_ipk=0;
		$total_ips=0;
		$total_mhs=0;
		foreach ($data as $v)
		{
			$sheet->setCellValue("A$row",$no);
			$sheet->setCellValueExplicit("B$row",$v->nim,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValue("C$row",ucwords($v->nama_mhs));                
			$sheet->setCellValue("D$row",$v->tahun_masuk);
			$sheet->setCellValue("E$row",$v->nkelas);
			$sheet->setCellValue("F$row",$v->jumlah_matkul);
			$sheet->setCellValue("G$row",$v->jumlah_sks);
			$sheet->setCellValue("H$row",$v->ips);
			$sheet->setCellValue("I$row",$v->ipk);
			$total_ipk += $v->ipk;
			$total_ips += $v->ips;
			$row+=1;
			$no+=1;
			$total_mhs+=1;
		}
		$row-=1;
		$styleArray=array(								
			'alignment' => array('horizontal'=>Alignment::HORIZONTAL_CENTER,
								'vertical'=>Alignment::HORIZONTAL_CENTER),
			'borders' => array('allBorders' => array('borderStyle' =>Border::BORDER_THIN))
		);   																					 
		$sheet->getStyle("A$row_awal:I$row")->applyFromArray($styleArray);
		$sheet->getStyle("A$row_awal:I$row")->getAlignment()->setWrapText(true);

		$styleArray=array(								
			'alignment' => array('horizontal'=>Alignment::HORIZONTAL_LEFT)
		);																					 
		$sheet->getStyle("C$row_awal:C$row")->applyFromArray($styleArray);    

		$row+=1;
		$row_awal_mhs=$row;
		$sheet->mergeCells("E$row:F$row");				                
		$sheet->setCellValue("E$row",'RATA-RATA IPS');
		$sheet->setCellValue("I$row",Helper::formatPecahan($total_ips,$total_mhs));

		$row+=1;
		$row_awal_mhs=$row;
		$sheet->mergeCells("E$row:F$row");				                
		$sheet->setCellValue("E$row",'RATA-RATA IPK');
		$sheet->setCellValue("I$row",Helper::formatPecahan($total_ipk,$total_mhs));
		
		$styleArray=array(
			'font' => array('bold' => true)
		);
		$sheet->getStyle("F$row_awal_mhs:I$row")->applyFromArray($styleArray);

		$generate_date=date('Y-m-d_H_m_s');
		return $this->excel("/report_khs_$generate_date.xlsx");
  }      
}