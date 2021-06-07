<?php

namespace App\Models\Report;

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use \PhpOffice\PhpSpreadsheet\Cell\DataType;

use App\Models\Akademik\RegisterMahasiswaModel;

use App\Helpers\Helper;

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
    $nama_prodi=$this->dataReport['nama_prodi'];    

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
    $sheet->mergeCells("A$row:G$row");				                
    $sheet->setCellValue("A$row","LAPORAN REKAPITULASI KHS PROGRAM STUDI $nama_prodi");

    $row+=1;
    $sheet->mergeCells("A$row:G$row");		
    $sheet->setCellValue("A$row","MAHASISWA TAHUN PENDAFTARAN $ta"); 
    
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
    $sheet->setCellValue("D$row",'KELAS');    
    $sheet->setCellValue("E$row",'JUMLAH MATKUL');
    $sheet->setCellValue("F$row",'JUMLAH SKS');    
    $sheet->setCellValue("G$row",'IPK SEMENTARA');    
    

    $styleArray=array(
        'font' => array('bold' => true),
        'alignment' => array('horizontal'=>Alignment::HORIZONTAL_CENTER,
                            'vertical'=>Alignment::HORIZONTAL_CENTER),
        'borders' => array('allBorders' => array('borderStyle' =>Border::BORDER_THIN))
    );
    $sheet->getStyle("A$row:G$row")->applyFromArray($styleArray);
    $sheet->getStyle("A$row:G$row")->getAlignment()->setWrapText(true);

    $data = RegisterMahasiswaModel::select(\DB::raw('
                                    pe3_register_mahasiswa.user_id,                                
                                    pe3_register_mahasiswa.nim,                                
                                    pe3_formulir_pendaftaran.nama_mhs,                                
                                    pe3_register_mahasiswa.idkelas,   
                                    pe3_kelas.nkelas,   
                                    COALESCE(pe3_rekap_transkrip_kurikulum.jumlah_matkul,0) AS jumlah_matkul,
                                    COALESCE(pe3_rekap_transkrip_kurikulum.jumlah_sks,0) AS jumlah_sks,
                                    COALESCE(pe3_rekap_transkrip_kurikulum.ipk,0.00) AS ipk                               
                                '))
                                ->join('pe3_formulir_pendaftaran','pe3_register_mahasiswa.user_id','pe3_formulir_pendaftaran.user_id')                                                    
                                ->join('pe3_kelas','pe3_kelas.idkelas','pe3_register_mahasiswa.idkelas')                                                    
                                ->leftJoin('pe3_rekap_transkrip_kurikulum','pe3_rekap_transkrip_kurikulum.user_id','pe3_register_mahasiswa.user_id')                                
                                ->where('pe3_register_mahasiswa.kjur',$prodi_id)                            
                                ->where('pe3_register_mahasiswa.tahun',$ta) 
                                ->orderBy('nama_mhs','asc')
                                ->get();

    
    $row+=1;
    $row_awal=$row; 
    $no=1;
    $total_ipk=0;
    $total_mhs=0;
    foreach ($data as $v)
    {
        $sheet->setCellValue("A$row",$no);
        $sheet->setCellValueExplicit("B$row",$v->nim,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValue("C$row",$v->nama_mhs);                
        $sheet->setCellValue("D$row",$v->nkelas);
        $sheet->setCellValue("E$row",$v->jumlah_matkul);
        $sheet->setCellValue("F$row",$v->jumlah_sks);
        $sheet->setCellValue("G$row",$v->ipk);
        $total_ipk += $v->ipk;
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
    $sheet->getStyle("A$row_awal:G$row")->applyFromArray($styleArray);
    $sheet->getStyle("A$row_awal:G$row")->getAlignment()->setWrapText(true);

    $styleArray=array(								
        'alignment' => array('horizontal'=>Alignment::HORIZONTAL_LEFT)
    );																					 
    $sheet->getStyle("C$row_awal:C$row")->applyFromArray($styleArray);    

    $row+=1;
    $row_awal_mhs=$row;
    $sheet->mergeCells("E$row:F$row");				                
    $sheet->setCellValue("E$row",'RATA-RATA IPK');
    $sheet->setCellValue("G$row",Helper::formatPecahan($total_ipk,$total_mhs));
    
    $styleArray=array(
    'font' => array('bold' => true)
    );
    $sheet->getStyle("F$row_awal_mhs:G$row")->applyFromArray($styleArray);

    $generate_date=date('Y-m-d_H_m_s');
    return $this->download("transkrip_kurikulum_$generate_date.xlsx");
  }      
}