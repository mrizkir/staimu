<?php

namespace App\Models\Report;

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use \PhpOffice\PhpSpreadsheet\Cell\DataType;
use App\Models\SPMB\FormulirPendaftaranModel;
use App\Helpers\Helper;

class ReportSPMBModel extends ReportModel
{   
	public function __construct($dataReport)
	{
		parent::__construct($dataReport); 
	}    
	public function prodi()  
	{
		$ta=$this->dataReport['ta'];
		$prodi_id=$this->dataReport['prodi_id'];
		$nama_prodi=$this->dataReport['nama_prodi'];

		$this->spreadsheet->getProperties()->setTitle("Report PMB Prodi");
		$this->spreadsheet->getProperties()->setSubject("Report PMB Prodi");

		$sheet = $this->spreadsheet->getActiveSheet();        
		$sheet->setTitle ('LAPORAN PROGRAM STUDI');

		$sheet->getParent()->getDefaultStyle()->applyFromArray([
			'font' => [
				'name' => 'Arial',
				'size' => '9',
			],
		]);

		$row=2;
		$sheet->mergeCells("A$row:K$row");				                
		$sheet->setCellValue("A$row","LAPORAN PENERIMAAN MAHASISWA BARU PROGRAM STUDI $nama_prodi");

		$row+=1;
		$sheet->mergeCells("A$row:K$row");		
		$sheet->setCellValue("A$row","TAHUN PENDAFTARAN $ta"); 
		
		$styleArray=array( 
			'font' => array('bold' => true,'size'=>'11'),
			'alignment' => array('horizontal'=>Alignment::HORIZONTAL_CENTER,
							   'vertical'=>Alignment::HORIZONTAL_CENTER),								
		);               
		
		$sheet->getStyle("A1:A$row")->applyFromArray($styleArray);

		$sheet->getRowDimension(26)->setRowHeight(22);
		$sheet->getColumnDimension('A')->setWidth(7);
		$sheet->getColumnDimension('B')->setWidth(14);
		$sheet->getColumnDimension('C')->setWidth(40);
		$sheet->getColumnDimension('D')->setWidth(25);
		$sheet->getColumnDimension('E')->setWidth(17);
		$sheet->getColumnDimension('F')->setWidth(7);
		$sheet->getColumnDimension('G')->setWidth(60);
		$sheet->getColumnDimension('H')->setWidth(15);
		$sheet->getColumnDimension('I')->setWidth(15);
		$sheet->getColumnDimension('J')->setWidth(15);
		$sheet->getColumnDimension('K')->setWidth(15);        
		
		$row+=2;        
		$sheet->setCellValue("A$row",'NO');
		$sheet->setCellValue("B$row",'NO. FORMULIR');
		$sheet->setCellValue("C$row",'NAMA MAHASISWA');
		$sheet->setCellValue("D$row",'TEMPAT LAHIR');
		$sheet->setCellValue("E$row",'TANGGAL LAHIR');
		$sheet->setCellValue("F$row",'JK');
		$sheet->setCellValue("G$row",'ALAMAT');
		$sheet->setCellValue("H$row",'TELEPON HP');
		$sheet->setCellValue("I$row",'TELEPON RUMAH');
		$sheet->setCellValue("J$row",'KELAS');
		$sheet->setCellValue("K$row",'TGL. DAFTAR');

		$styleArray=array(
				'font' => array('bold' => true),
				'alignment' => array('horizontal'=>Alignment::HORIZONTAL_CENTER,
									'vertical'=>Alignment::HORIZONTAL_CENTER),
				'borders' => array('allBorders' => array('borderStyle' =>Border::BORDER_THIN))
			);
		$sheet->getStyle("A$row:K$row")->applyFromArray($styleArray);
		$sheet->getStyle("A$row:K$row")->getAlignment()->setWrapText(true);

		$data=\DB::table('pe3_formulir_pendaftaran')
				->select(\DB::raw('
									no_formulir,
									nama_mhs, 
									tempat_lahir, 
									tanggal_lahir, 
									jk,
									CONCAT(alamat_rumah,\' \',address1_kelurahan,\' \',address1_kecamatan,\' \',address1_kabupaten,\' \',address1_provinsi) AS alamat,
									telp_hp,
									telp_rumah,
									pe3_kelas.nkelas,
									created_at
								'))
				->join('pe3_kelas','pe3_kelas.idkelas','pe3_formulir_pendaftaran.idkelas')
				->where('ta',$ta)
				->where('kjur1',$prodi_id)                                     
				->orderBy('pe3_formulir_pendaftaran.idkelas','ASC')               
				->orderBy('pe3_formulir_pendaftaran.nama_mhs','ASC')               
				->get();

		$row+=1;
		$row_awal=$row; 
		$no=1;
		foreach ($data as $v)
		{
			$sheet->setCellValue("A$row",$no);
			$sheet->setCellValue("B$row",$v->no_formulir);
			$sheet->setCellValue("C$row",$v->nama_mhs);
			$sheet->setCellValue("D$row",$v->tempat_lahir);
			$sheet->setCellValue("E$row",Helper::tanggal('d F Y',$v->tanggal_lahir));
			$sheet->setCellValue("F$row",$v->jk);
			$sheet->setCellValue("G$row",$v->alamat);            
			$sheet->setCellValueExplicit("H$row",$v->telp_hp,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);        
			$sheet->setCellValue("I$row",$v->telp_rumah);
			$sheet->setCellValue("J$row",$v->nkelas);
			$sheet->setCellValue("K$row",Helper::tanggal($v->created_at));

			$row+=1;
			$no+=1;
		}
		$row-=1;
		$styleArray=array(								
			'alignment' => array('horizontal'=>Alignment::HORIZONTAL_CENTER,
							   'vertical'=>Alignment::HORIZONTAL_CENTER),
			'borders' => array('allBorders' => array('borderStyle' =>Border::BORDER_THIN))
		);   																					 
		$sheet->getStyle("A$row_awal:K$row")->applyFromArray($styleArray);
		$sheet->getStyle("A$row_awal:K$row")->getAlignment()->setWrapText(true);

		$styleArray=array(								
			'alignment' => array('horizontal'=>Alignment::HORIZONTAL_LEFT)
		);																					 
		$sheet->getStyle("C$row_awal:D$row")->applyFromArray($styleArray);
		$sheet->getStyle("G$row_awal:G$row")->applyFromArray($styleArray);

		$generate_date=date('Y-m-d_H_m_s');
		return $this->excel("/laporan_prodi_$generate_date.xlsx");
	}
	public function fakultas()  
	{
		$ta=$this->dataReport['ta'];
		$fakultas_id=$this->dataReport['fakultas_id'];
		$nama_fakultas=$this->dataReport['nama_fakultas'];

		$this->spreadsheet->getProperties()->setTitle("Report Fakultas");
		$this->spreadsheet->getProperties()->setSubject("Report Fakultas");

		$sheet = $this->spreadsheet->getActiveSheet();        
		$sheet->setTitle ('LAPORAN PROGRAM STUDI');

		$sheet->getParent()->getDefaultStyle()->applyFromArray([
			'font' => [
				'name' => 'Arial',
				'size' => '9',
			],
		]);

		$row=2;
		$sheet->mergeCells("A$row:L$row");				                
		$sheet->setCellValue("A$row","LAPORAN PENERIMAAN MAHASISWA BARU FAKULTAS $nama_fakultas");

		$row+=1;
		$sheet->mergeCells("A$row:L$row");		
		$sheet->setCellValue("A$row","TAHUN PENDAFTARAN $ta"); 
		
		$styleArray=array( 
			'font' => array('bold' => true,'size'=>'11'),
			'alignment' => array('horizontal'=>Alignment::HORIZONTAL_CENTER,
							   'vertical'=>Alignment::HORIZONTAL_CENTER),								
		);               
		
		$sheet->getStyle("A1:A$row")->applyFromArray($styleArray);

		$sheet->getRowDimension(26)->setRowHeight(22);
		$sheet->getColumnDimension('A')->setWidth(7);
		$sheet->getColumnDimension('B')->setWidth(14);
		$sheet->getColumnDimension('C')->setWidth(40);
		$sheet->getColumnDimension('D')->setWidth(25);
		$sheet->getColumnDimension('E')->setWidth(17);
		$sheet->getColumnDimension('F')->setWidth(7);
		$sheet->getColumnDimension('G')->setWidth(60);
		$sheet->getColumnDimension('H')->setWidth(15);
		$sheet->getColumnDimension('I')->setWidth(15);
		$sheet->getColumnDimension('J')->setWidth(15);
		$sheet->getColumnDimension('K')->setWidth(25);        
		$sheet->getColumnDimension('L')->setWidth(15);        
		
		$row+=2;        
		$sheet->setCellValue("A$row",'NO');
		$sheet->setCellValue("B$row",'NO. FORMULIR');
		$sheet->setCellValue("C$row",'NAMA MAHASISWA');
		$sheet->setCellValue("D$row",'TEMPAT LAHIR');
		$sheet->setCellValue("E$row",'TANGGAL LAHIR');
		$sheet->setCellValue("F$row",'JK');
		$sheet->setCellValue("G$row",'ALAMAT');
		$sheet->setCellValue("H$row",'TELEPON HP');
		$sheet->setCellValue("I$row",'TELEPON RUMAH');
		$sheet->setCellValue("J$row",'KELAS');
		$sheet->setCellValue("K$row",'PROGRAM STUDI');
		$sheet->setCellValue("L$row",'TGL. DAFTAR');

		$styleArray=array(
				'font' => array('bold' => true),
				'alignment' => array('horizontal'=>Alignment::HORIZONTAL_CENTER,
									'vertical'=>Alignment::HORIZONTAL_CENTER),
				'borders' => array('allBorders' => array('borderStyle' =>Border::BORDER_THIN))
			);
		$sheet->getStyle("A$row:L$row")->applyFromArray($styleArray);
		$sheet->getStyle("A$row:L$row")->getAlignment()->setWrapText(true);

		$data=\DB::table('pe3_formulir_pendaftaran')
				->select(\DB::raw('
									no_formulir,
									nama_mhs, 
									tempat_lahir, 
									tanggal_lahir, 
									jk,
									CONCAT(alamat_rumah,\' \',address1_kelurahan,\' \',address1_kecamatan,\' \',address1_kabupaten,\' \',address1_provinsi) AS alamat,
									telp_hp,
									telp_rumah,
									pe3_prodi.nama_prodi,
									pe3_prodi.nama_jenjang,
									pe3_kelas.nkelas,
									created_at
								'))
				->join('pe3_kelas','pe3_kelas.idkelas','pe3_formulir_pendaftaran.idkelas')
				->join('pe3_prodi','pe3_prodi.id','pe3_formulir_pendaftaran.kjur1')
				->where('ta',$ta)                
				->where('kode_fakultas',$fakultas_id)      
				->orderBy('pe3_prodi.nama_prodi','ASC')          
				->orderBy('pe3_formulir_pendaftaran.idkelas','ASC')               
				->orderBy('pe3_formulir_pendaftaran.nama_mhs','ASC')          
				->get();

		$row+=1;
		$row_awal=$row; 
		$no=1;
		foreach ($data as $v)
		{
			$sheet->setCellValue("A$row",$no);
			$sheet->setCellValue("B$row",$v->no_formulir);
			$sheet->setCellValue("C$row",$v->nama_mhs);
			$sheet->setCellValue("D$row",$v->tempat_lahir);
			$sheet->setCellValue("E$row",Helper::tanggal('d F Y',$v->tanggal_lahir));
			$sheet->setCellValue("F$row",$v->jk);
			$sheet->setCellValue("G$row",$v->alamat);            
			$sheet->setCellValueExplicit("H$row",$v->telp_hp,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);        
			$sheet->setCellValue("I$row",$v->telp_rumah);
			$sheet->setCellValue("J$row",$v->nkelas);
			$sheet->setCellValue("K$row",$v->nama_prodi. ' (' . $v->nama_jenjang . ')');
			$sheet->setCellValue("L$row",Helper::tanggal($v->created_at));

			$row+=1;
			$no+=1;
		}
		$row-=1;
		$styleArray=array(								
			'alignment' => array('horizontal'=>Alignment::HORIZONTAL_CENTER,
							   'vertical'=>Alignment::HORIZONTAL_CENTER),
			'borders' => array('allBorders' => array('borderStyle' =>Border::BORDER_THIN))
		);   																					 
		$sheet->getStyle("A$row_awal:L$row")->applyFromArray($styleArray);
		$sheet->getStyle("A$row_awal:L$row")->getAlignment()->setWrapText(true);

		$styleArray=array(								
			'alignment' => array('horizontal'=>Alignment::HORIZONTAL_LEFT)
		);																					 
		$sheet->getStyle("C$row_awal:D$row")->applyFromArray($styleArray);
		$sheet->getStyle("G$row_awal:G$row")->applyFromArray($styleArray);

		$generate_date=date('Y-m-d_H_m_s');
		return $this->excel("/laporan_fakultas_$generate_date.xlsx");
	}
	public function kelulusan()  
	{
		$ta=$this->dataReport['ta'];
		$prodi_id=$this->dataReport['prodi_id'];
		$nama_prodi=$this->dataReport['nama_prodi'];
		$filter_status=$this->dataReport['filter_status'];

		$this->spreadsheet->getProperties()->setTitle("Report PMB Prodi");
		$this->spreadsheet->getProperties()->setSubject("Report PMB Prodi");

		$sheet = $this->spreadsheet->getActiveSheet();        
		$sheet->setTitle ('LAPORAN KELULUSAN');

		$sheet->getParent()->getDefaultStyle()->applyFromArray([
			'font' => [
				'name' => 'Arial',
				'size' => '9',
			],
		]);

		$row=2;
		$sheet->mergeCells("A$row:M$row");				                
		$sheet->setCellValue("A$row","LAPORAN KELULUSAN CALON MAHASISWA BARU");

		$row+=1;
		$sheet->mergeCells("A$row:M$row");				                
		$sheet->setCellValue("A$row"," PROGRAM STUDI $nama_prodi");

		$row+=1;
		$sheet->mergeCells("A$row:M$row");		
		$sheet->setCellValue("A$row","TAHUN PENDAFTARAN $ta"); 
		
		$styleArray=array( 
			'font' => array('bold' => true,'size'=>'11'),
			'alignment' => array('horizontal'=>Alignment::HORIZONTAL_CENTER,
							   'vertical'=>Alignment::HORIZONTAL_CENTER),								
		);               
		
		$sheet->getStyle("A1:A$row")->applyFromArray($styleArray);

		$sheet->getRowDimension(26)->setRowHeight(22);
		$sheet->getColumnDimension('A')->setWidth(7);
		$sheet->getColumnDimension('B')->setWidth(14);
		$sheet->getColumnDimension('C')->setWidth(40);
		$sheet->getColumnDimension('D')->setWidth(25);
		$sheet->getColumnDimension('E')->setWidth(17);
		$sheet->getColumnDimension('F')->setWidth(7);
		$sheet->getColumnDimension('G')->setWidth(60);
		$sheet->getColumnDimension('H')->setWidth(15);
		$sheet->getColumnDimension('I')->setWidth(15);
		$sheet->getColumnDimension('J')->setWidth(15);
		$sheet->getColumnDimension('K')->setWidth(15);        
		$sheet->getColumnDimension('L')->setWidth(15);        
		$sheet->getColumnDimension('M')->setWidth(15);        
		
		$row+=2;        
		$sheet->setCellValue("A$row",'NO');
		$sheet->setCellValue("B$row",'NO. FORMULIR');
		$sheet->setCellValue("C$row",'NAMA MAHASISWA');
		$sheet->setCellValue("D$row",'TEMPAT LAHIR');
		$sheet->setCellValue("E$row",'TANGGAL LAHIR');
		$sheet->setCellValue("F$row",'JK');
		$sheet->setCellValue("G$row",'ALAMAT');
		$sheet->setCellValue("H$row",'TELEPON HP');
		$sheet->setCellValue("I$row",'TELEPON RUMAH');
		$sheet->setCellValue("J$row",'KELAS');
		$sheet->setCellValue("K$row",'NILAI');
		$sheet->setCellValue("L$row",'KET. ');
		$sheet->setCellValue("M$row",'TGL. DAFTAR');

		$styleArray=array(
				'font' => array('bold' => true),
				'alignment' => array('horizontal'=>Alignment::HORIZONTAL_CENTER,
									'vertical'=>Alignment::HORIZONTAL_CENTER),
				'borders' => array('allBorders' => array('borderStyle' =>Border::BORDER_THIN))
			);
		$sheet->getStyle("A$row:M$row")->applyFromArray($styleArray);
		$sheet->getStyle("A$row:M$row")->getAlignment()->setWrapText(true);    

		$data = FormulirPendaftaranModel::select(\DB::raw('
					users.id,
					pe3_formulir_pendaftaran.no_formulir,
					pe3_formulir_pendaftaran.nama_mhs,
					pe3_formulir_pendaftaran.tempat_lahir,
					pe3_formulir_pendaftaran.tanggal_lahir,
					pe3_formulir_pendaftaran.jk,
					CONCAT(alamat_rumah,\' \',address1_kelurahan,\' \',address1_kecamatan,\' \',address1_kabupaten,\' \',address1_provinsi) AS alamat,
					pe3_formulir_pendaftaran.telp_hp,
					pe3_formulir_pendaftaran.telp_rumah,
					COALESCE(pe3_nilai_ujian_pmb.nilai,\'N.A\') AS nilai,
					pe3_nilai_ujian_pmb.ket_lulus,
					CASE
						WHEN pe3_nilai_ujian_pmb.ket_lulus IS NULL THEN \'N.A\'
						WHEN pe3_nilai_ujian_pmb.ket_lulus=0 THEN \'TIDAK LULUS\'
						WHEN pe3_nilai_ujian_pmb.ket_lulus=1 THEN \'LULUS\'
					END AS status,
					pe3_kelas.nkelas,
					users.active,
					users.foto,
					users.created_at,
					users.updated_at
				'))
				->join('users','pe3_formulir_pendaftaran.user_id','users.id')                    
				->join('pe3_kelas','pe3_formulir_pendaftaran.idkelas','pe3_kelas.idkelas')                    
				->leftJoin('pe3_nilai_ujian_pmb','pe3_formulir_pendaftaran.user_id','pe3_nilai_ujian_pmb.user_id')                    
				->where('users.ta',$ta)
				->where('kjur1',$prodi_id)            
				->whereNotNull('pe3_formulir_pendaftaran.idkelas')   
				->where('users.active',1)    
				->where('pe3_nilai_ujian_pmb.ket_lulus',$filter_status)
				->orderBy('pe3_formulir_pendaftaran.idkelas','ASC')               
				->orderBy('pe3_formulir_pendaftaran.nama_mhs','ASC') 
				->get();

		$row+=1;
		$row_awal=$row; 
		$no=1;
		foreach ($data as $v)
		{
			$sheet->setCellValue("A$row",$no);
			$sheet->setCellValue("B$row",$v->no_formulir);
			$sheet->setCellValue("C$row",$v->nama_mhs);
			$sheet->setCellValue("D$row",$v->tempat_lahir);
			$sheet->setCellValue("E$row",Helper::tanggal('d F Y',$v->tanggal_lahir));
			$sheet->setCellValue("F$row",$v->jk);
			$sheet->setCellValue("G$row",$v->alamat);            
			$sheet->setCellValueExplicit("H$row",$v->telp_hp,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);        
			$sheet->setCellValue("I$row",$v->telp_rumah);
			$sheet->setCellValue("J$row",$v->nkelas);
			$sheet->setCellValue("K$row",$v->nilai);
			$sheet->setCellValue("L$row",$v->status);
			$sheet->setCellValue("M$row",Helper::tanggal($v->created_at));

			$row+=1;
			$no+=1;
		}
		$row-=1;
		$styleArray=array(								
			'alignment' => array('horizontal'=>Alignment::HORIZONTAL_CENTER,
							   'vertical'=>Alignment::HORIZONTAL_CENTER),
			'borders' => array('allBorders' => array('borderStyle' =>Border::BORDER_THIN))
		);   																					 
		$sheet->getStyle("A$row_awal:M$row")->applyFromArray($styleArray);
		$sheet->getStyle("A$row_awal:M$row")->getAlignment()->setWrapText(true);

		$styleArray=array(								
			'alignment' => array('horizontal'=>Alignment::HORIZONTAL_LEFT)
		);																					 
		$sheet->getStyle("C$row_awal:D$row")->applyFromArray($styleArray);
		$sheet->getStyle("G$row_awal:G$row")->applyFromArray($styleArray);

		$generate_date=date('Y-m-d_H_m_s');
		return $this->excel("/laporan_kelulusan_$generate_date.xlsx");
	}
	public function daftarulang()  
	{
		$ta=$this->dataReport['ta'];
		$prodi_id=$this->dataReport['prodi_id'];
		$nama_prodi=$this->dataReport['nama_prodi'];

		$this->spreadsheet->getProperties()->setTitle("Report PMB Prodi");
		$this->spreadsheet->getProperties()->setSubject("Report PMB Prodi");

		$sheet = $this->spreadsheet->getActiveSheet();        
		$sheet->setTitle ('LAPORAN DAFTAR ULANG');

		$sheet->getParent()->getDefaultStyle()->applyFromArray([
			'font' => [
				'name' => 'Arial',
				'size' => '9',
			],
		]);

		$row=2;
		$sheet->mergeCells("A$row:O$row");				                
		$sheet->setCellValue("A$row","LAPORAN DAFTAR ULANG CALON MAHASISWA BARU");

		$row+=1;
		$sheet->mergeCells("A$row:O$row");				                
		$sheet->setCellValue("A$row"," PROGRAM STUDI $nama_prodi");

		$row+=1;
		$sheet->mergeCells("A$row:O$row");		
		$sheet->setCellValue("A$row","TAHUN PENDAFTARAN $ta"); 
		
		$styleArray=array( 
			'font' => array('bold' => true,'size'=>'11'),
			'alignment' => array('horizontal'=>Alignment::HORIZONTAL_CENTER,
							   'vertical'=>Alignment::HORIZONTAL_CENTER),								
		);               
		
		$sheet->getStyle("A1:A$row")->applyFromArray($styleArray);

		$sheet->getRowDimension(26)->setRowHeight(22);
		$sheet->getColumnDimension('A')->setWidth(7);
		$sheet->getColumnDimension('B')->setWidth(14);
		$sheet->getColumnDimension('C')->setWidth(14);
		$sheet->getColumnDimension('D')->setWidth(40);
		$sheet->getColumnDimension('E')->setWidth(25);
		$sheet->getColumnDimension('F')->setWidth(17);
		$sheet->getColumnDimension('G')->setWidth(7);
		$sheet->getColumnDimension('H')->setWidth(12);
		$sheet->getColumnDimension('I')->setWidth(60);
		$sheet->getColumnDimension('J')->setWidth(15);
		$sheet->getColumnDimension('K')->setWidth(15);
		$sheet->getColumnDimension('L')->setWidth(15);        
		$sheet->getColumnDimension('M')->setWidth(15);        
		$sheet->getColumnDimension('N')->setWidth(15);        
		$sheet->getColumnDimension('O')->setWidth(15);        
		
		$row+=2;        
		$sheet->setCellValue("A$row",'NO');
		$sheet->setCellValue("B$row",'NIK');
		$sheet->setCellValue("C$row",'NO. FORMULIR');
		$sheet->setCellValue("D$row",'NAMA MAHASISWA');
		$sheet->setCellValue("E$row",'TEMPAT LAHIR');
		$sheet->setCellValue("F$row",'TANGGAL LAHIR');
		$sheet->setCellValue("G$row",'JK');
		$sheet->setCellValue("H$row",'SIZE BAJU');
		$sheet->setCellValue("I$row",'ALAMAT');
		$sheet->setCellValue("J$row",'TELEPON HP');
		$sheet->setCellValue("K$row",'TELEPON RUMAH');
		$sheet->setCellValue("L$row",'KELAS');
		$sheet->setCellValue("M$row",'NILAI');
		$sheet->setCellValue("N$row",'KET. ');
		$sheet->setCellValue("O$row",'TGL. DAFTAR');

		$styleArray=array(
				'font' => array('bold' => true),
				'alignment' => array('horizontal'=>Alignment::HORIZONTAL_CENTER,
									'vertical'=>Alignment::HORIZONTAL_CENTER),
				'borders' => array('allBorders' => array('borderStyle' =>Border::BORDER_THIN))
			);
		$sheet->getStyle("A$row:O$row")->applyFromArray($styleArray);
		$sheet->getStyle("A$row:O$row")->getAlignment()->setWrapText(true);    

		$data = FormulirPendaftaranModel::select(\DB::raw('
					users.id,
					pe3_formulir_pendaftaran.no_formulir,
					pe3_formulir_pendaftaran.nama_mhs,
					pe3_formulir_pendaftaran.tempat_lahir,
					pe3_formulir_pendaftaran.tanggal_lahir,
					pe3_formulir_pendaftaran.nik,
					pe3_formulir_pendaftaran.ukuran_baju,
					pe3_formulir_pendaftaran.jk,
					CONCAT(alamat_rumah,\' \',address1_kelurahan,\' \',address1_kecamatan,\' \',address1_kabupaten,\' \',address1_provinsi) AS alamat,
					pe3_formulir_pendaftaran.telp_hp,
					pe3_formulir_pendaftaran.telp_rumah,
					COALESCE(pe3_nilai_ujian_pmb.nilai,\'N.A\') AS nilai,
					pe3_nilai_ujian_pmb.ket_lulus,
					CASE
						WHEN pe3_nilai_ujian_pmb.ket_lulus IS NULL THEN \'N.A\'
						WHEN pe3_nilai_ujian_pmb.ket_lulus=0 THEN \'TIDAK LULUS\'
						WHEN pe3_nilai_ujian_pmb.ket_lulus=1 THEN \'LULUS\'
					END AS status,
					pe3_kelas.nkelas,
					users.active,
					users.foto,
					users.created_at,
					users.updated_at
				'))
				->join('users','pe3_formulir_pendaftaran.user_id','users.id')                    
				->join('pe3_kelas','pe3_formulir_pendaftaran.idkelas','pe3_kelas.idkelas')                    
				->leftJoin('pe3_nilai_ujian_pmb','pe3_formulir_pendaftaran.user_id','pe3_nilai_ujian_pmb.user_id')                    
				->where('pe3_formulir_pendaftaran.isdulang', 1)
				->where('users.ta',$ta)
				->where('kjur1',$prodi_id)            
				->whereNotNull('pe3_formulir_pendaftaran.idkelas')   
				->where('users.active',1)    
				->where('pe3_nilai_ujian_pmb.ket_lulus',1)
				->orderBy('pe3_formulir_pendaftaran.idkelas','ASC')               
				->orderBy('pe3_formulir_pendaftaran.nama_mhs','ASC') 
				->get();

		$row+=1;
		$row_awal=$row; 
		$no=1;
		foreach ($data as $v)
		{
			$sheet->setCellValue("A$row",$no);
			$sheet->setCellValue("B$row",$v->nik);
			$sheet->setCellValue("C$row",$v->no_formulir);
			$sheet->setCellValue("D$row",$v->nama_mhs);
			$sheet->setCellValue("E$row",$v->tempat_lahir);
			$sheet->setCellValue("F$row",Helper::tanggal('d F Y',$v->tanggal_lahir));
			$sheet->setCellValue("G$row",$v->jk);
			$sheet->setCellValue("H$row",$v->ukuran_baju);            
			$sheet->setCellValue("I$row",$v->alamat);            
			$sheet->setCellValueExplicit("J$row",$v->telp_hp,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);        
			$sheet->setCellValue("K$row",$v->telp_rumah);
			$sheet->setCellValue("L$row",$v->nkelas);
			$sheet->setCellValue("M$row",$v->nilai);
			$sheet->setCellValue("N$row",$v->status);
			$sheet->setCellValue("O$row",Helper::tanggal($v->created_at));			

			$row+=1;
			$no+=1;
		}
		$row-=1;
		$styleArray=array(								
			'alignment' => array('horizontal'=>Alignment::HORIZONTAL_CENTER,
							   'vertical'=>Alignment::HORIZONTAL_CENTER),
			'borders' => array('allBorders' => array('borderStyle' =>Border::BORDER_THIN))
		);   																					 
		$sheet->getStyle("A$row_awal:O$row")->applyFromArray($styleArray);
		$sheet->getStyle("A$row_awal:O$row")->getAlignment()->setWrapText(true);

		$styleArray=array(								
			'alignment' => array('horizontal'=>Alignment::HORIZONTAL_LEFT)
		);																					 
		$sheet->getStyle("D$row_awal:E$row")->applyFromArray($styleArray);
		$sheet->getStyle("I$row_awal:I$row")->applyFromArray($styleArray);

		$generate_date=date('Y-m-d_H_m_s');
		return $this->excel("/laporan_kelulusan_$generate_date.xlsx");
	}
	public function pesertalulus()
	{
		$ta=$this->dataReport['ta'];
		$prodi_id=$this->dataReport['prodi_id'];
		$nama_prodi=$this->dataReport['nama_prodi'];

		$this->spreadsheet->getProperties()->setTitle("Report PMB Prodi");
		$this->spreadsheet->getProperties()->setSubject("Report PMB Prodi");

		$sheet = $this->spreadsheet->getActiveSheet();        
		$sheet->setTitle ('LAPORAN KELULUSAN');

		$sheet->getParent()->getDefaultStyle()->applyFromArray([
			'font' => [
				'name' => 'Arial',
				'size' => '9',
			],
		]);

		$row=2;
		$sheet->mergeCells("A$row:M$row");				                
		$sheet->setCellValue("A$row","LAPORAN KELULUSAN CALON MAHASISWA BARU");

		$row+=1;
		$sheet->mergeCells("A$row:M$row");				                
		$sheet->setCellValue("A$row"," PROGRAM STUDI $nama_prodi");

		$row+=1;
		$sheet->mergeCells("A$row:M$row");		
		$sheet->setCellValue("A$row","TAHUN PENDAFTARAN $ta"); 
		
		$styleArray=array( 
			'font' => array('bold' => true,'size'=>'11'),
			'alignment' => array('horizontal'=>Alignment::HORIZONTAL_CENTER,
							   'vertical'=>Alignment::HORIZONTAL_CENTER),								
		);               
		
		$sheet->getStyle("A1:A$row")->applyFromArray($styleArray);

		$sheet->getRowDimension(26)->setRowHeight(22);
		$sheet->getColumnDimension('A')->setWidth(7);
		$sheet->getColumnDimension('B')->setWidth(14);
		$sheet->getColumnDimension('C')->setWidth(40);
		$sheet->getColumnDimension('D')->setWidth(25);
		$sheet->getColumnDimension('E')->setWidth(17);
		$sheet->getColumnDimension('F')->setWidth(7);
		$sheet->getColumnDimension('G')->setWidth(60);
		$sheet->getColumnDimension('H')->setWidth(15);
		$sheet->getColumnDimension('I')->setWidth(15);
		$sheet->getColumnDimension('J')->setWidth(15);
		$sheet->getColumnDimension('K')->setWidth(15);        
		$sheet->getColumnDimension('L')->setWidth(15);        
		$sheet->getColumnDimension('M')->setWidth(15);        
		
		$row+=2;        
		$sheet->setCellValue("A$row",'NO');
		$sheet->setCellValue("B$row",'NO. FORMULIR');
		$sheet->setCellValue("C$row",'NAMA MAHASISWA');
		$sheet->setCellValue("D$row",'TEMPAT LAHIR');
		$sheet->setCellValue("E$row",'TANGGAL LAHIR');
		$sheet->setCellValue("F$row",'JK');
		$sheet->setCellValue("G$row",'ALAMAT');
		$sheet->setCellValue("H$row",'TELEPON HP');
		$sheet->setCellValue("I$row",'TELEPON RUMAH');
		$sheet->setCellValue("J$row",'KELAS');
		$sheet->setCellValue("K$row",'NILAI');
		$sheet->setCellValue("L$row",'KET. ');
		$sheet->setCellValue("M$row",'TGL. DAFTAR');

		$styleArray=array(
				'font' => array('bold' => true),
				'alignment' => array('horizontal'=>Alignment::HORIZONTAL_CENTER,
									'vertical'=>Alignment::HORIZONTAL_CENTER),
				'borders' => array('allBorders' => array('borderStyle' =>Border::BORDER_THIN))
			);
		$sheet->getStyle("A$row:M$row")->applyFromArray($styleArray);
		$sheet->getStyle("A$row:M$row")->getAlignment()->setWrapText(true);    

		$data = FormulirPendaftaranModel::select(\DB::raw('
					users.id,
					pe3_formulir_pendaftaran.no_formulir,
					pe3_formulir_pendaftaran.nama_mhs,
					pe3_formulir_pendaftaran.tempat_lahir,
					pe3_formulir_pendaftaran.tanggal_lahir,
					pe3_formulir_pendaftaran.jk,
					CONCAT(alamat_rumah,\' \',address1_kelurahan,\' \',address1_kecamatan,\' \',address1_kabupaten,\' \',address1_provinsi) AS alamat,
					pe3_formulir_pendaftaran.telp_hp,
					pe3_formulir_pendaftaran.telp_rumah,
					COALESCE(pe3_nilai_ujian_pmb.nilai,\'N.A\') AS nilai,
					pe3_nilai_ujian_pmb.ket_lulus,
					CASE
						WHEN pe3_nilai_ujian_pmb.ket_lulus IS NULL THEN \'N.A\'
						WHEN pe3_nilai_ujian_pmb.ket_lulus=0 THEN \'TIDAK LULUS\'
						WHEN pe3_nilai_ujian_pmb.ket_lulus=1 THEN \'LULUS\'
					END AS status,
					pe3_kelas.nkelas,
					users.active,
					users.foto,
					users.created_at,
					users.updated_at
				'))
				->join('users','pe3_formulir_pendaftaran.user_id','users.id')                    
				->join('pe3_kelas','pe3_formulir_pendaftaran.idkelas','pe3_kelas.idkelas')                    
				->leftJoin('pe3_nilai_ujian_pmb','pe3_formulir_pendaftaran.user_id','pe3_nilai_ujian_pmb.user_id')                    
				->where('users.ta',$ta)
				->where('kjur1',$prodi_id)            
				->whereNotNull('pe3_formulir_pendaftaran.idkelas')   
				->where('users.active',1)    
				->where('pe3_nilai_ujian_pmb.ket_lulus',1)
				->orderBy('pe3_formulir_pendaftaran.idkelas','ASC')               
				->orderBy('pe3_formulir_pendaftaran.nama_mhs','ASC') 
				->get();

		$row+=1;
		$row_awal=$row; 
		$no=1;
		foreach ($data as $v)
		{
			$sheet->setCellValue("A$row",$no);
			$sheet->setCellValue("B$row",$v->no_formulir);
			$sheet->setCellValue("C$row",$v->nama_mhs);
			$sheet->setCellValue("D$row",$v->tempat_lahir);
			$sheet->setCellValue("E$row",Helper::tanggal('d F Y',$v->tanggal_lahir));
			$sheet->setCellValue("F$row",$v->jk);
			$sheet->setCellValue("G$row",$v->alamat);            
			$sheet->setCellValueExplicit("H$row",$v->telp_hp,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);        
			$sheet->setCellValue("I$row",$v->telp_rumah);
			$sheet->setCellValue("J$row",$v->nkelas);
			$sheet->setCellValue("K$row",$v->nilai);
			$sheet->setCellValue("L$row",$v->status);
			$sheet->setCellValue("M$row",Helper::tanggal($v->created_at));

			$row+=1;
			$no+=1;
		}
		$row-=1;
		$styleArray=array(								
			'alignment' => array('horizontal'=>Alignment::HORIZONTAL_CENTER,
							   'vertical'=>Alignment::HORIZONTAL_CENTER),
			'borders' => array('allBorders' => array('borderStyle' =>Border::BORDER_THIN))
		);   																					 
		$sheet->getStyle("A$row_awal:M$row")->applyFromArray($styleArray);
		$sheet->getStyle("A$row_awal:M$row")->getAlignment()->setWrapText(true);

		$styleArray=array(								
			'alignment' => array('horizontal'=>Alignment::HORIZONTAL_LEFT)
		);																					 
		$sheet->getStyle("C$row_awal:D$row")->applyFromArray($styleArray);
		$sheet->getStyle("G$row_awal:G$row")->applyFromArray($styleArray);

		$generate_date=date('Y-m-d_H_m_s');
		return $this->excel("/laporan_peserta_lulus_$generate_date.xlsx");
	}
}