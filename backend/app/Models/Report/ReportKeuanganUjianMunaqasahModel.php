<?php

namespace App\Models\Report;

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use \PhpOffice\PhpSpreadsheet\Cell\DataType;

use App\Models\Keuangan\TransaksiModel;
use App\Models\Keuangan\TransaksiDetailModel;

use App\Helpers\Helper;

class ReportKeuanganUjianMunaqasahModel extends ReportModel
{   
  public function __construct($dataReport)
  {
      parent::__construct($dataReport); 
  }    
  /**
   * cetak rekap penerimaan spp per bulan setiap prodi
   */
  public function printtoexcel2() 
  {
    $ta=$this->dataReport['TA'];    

    $this->spreadsheet->getProperties()->setTitle("Report Munaqasah");
    $this->spreadsheet->getProperties()->setSubject("Report Munaqasah");

    $sheet = $this->spreadsheet->getActiveSheet();    
    $sheet->setTitle ('LAPORAN PENERIMAAN MUNAQASAH');

    $sheet->getParent()->getDefaultStyle()->applyFromArray([
      'font' => [
        'name' => 'Arial',
        'size' => '10',
      ],
    ]);

    $row=2;
    $sheet->mergeCells("A$row:D$row");				                
    $sheet->setCellValue("A$row","LAPORAN PENERIMAAN UJIAN MUNAQASAH");

    $row+=1;
    $sheet->mergeCells("A$row:D$row");		
    $sheet->setCellValue("A$row","TAHUN AKADEMIK $ta"); 
    
    $styleArray=array( 
        'font' => array('bold' => true,'size'=>'11'),
        'alignment' => array('horizontal'=>Alignment::HORIZONTAL_CENTER,
                            'vertical'=>Alignment::HORIZONTAL_CENTER),								
    );           
    
    $sheet->getStyle("A1:A$row")->applyFromArray($styleArray);

    $sheet->getRowDimension(26)->setRowHeight(22);
    $sheet->getColumnDimension('A')->setWidth(7);
    $sheet->getColumnDimension('B')->setWidth(25);
    $sheet->getColumnDimension('C')->setWidth(20);
    $sheet->getColumnDimension('D')->setWidth(17);    
    
    $row+=2;    
    $sheet->setCellValue("A$row",'NO');    
    $sheet->setCellValue("B$row",'BULAN');
    $sheet->setCellValue("C$row",'PROGRAM STUDI');
    $sheet->setCellValue("D$row",'JUMLAH');
    

    $styleArray=array(
        'font' => array('bold' => true),
        'alignment' => array('horizontal'=>Alignment::HORIZONTAL_CENTER,
                            'vertical'=>Alignment::HORIZONTAL_CENTER),
        'borders' => array('allBorders' => array('borderStyle' =>Border::BORDER_THIN))
    );
    $sheet->getStyle("A$row:D$row")->applyFromArray($styleArray);
    $sheet->getStyle("A$row:D$row")->getAlignment()->setWrapText(true);

    $bulan = Helper::getNamaBulanSPP();

    $daftar_prodi = \DB::table('pe3_prodi')
                      ->select(\DB::raw('
                        id,
                        nama_prodi
                      '))
                      ->get()
                      ->pluck('nama_prodi','id');
    $jumlah_prodi=count($daftar_prodi)-1;
    $row+=1;
    $row_awal = $row;
    $sub_total = 0;
    $total_keseluruhan = 0;
    
    foreach ($bulan as $k=>$v) {
      $data_prodi=[];	
      $jumlah = 0;
      $sub_total=0;
      
      $sheet->mergeCells("A$row:A". ($row+$jumlah_prodi));				                
      $sheet->setCellValue("A$row",$k);

      if ($k == 9 || $k == 10 || $k == 11 || $k == 12)
      {
        $v = "$v $ta";	
        $sheet->mergeCells("B$row:B". ($row+$jumlah_prodi));
        $sheet->setCellValue("B$row",$v);
        foreach ($daftar_prodi as $prodi_id=>$nama_prodi)
        {
          $jumlah = \DB::table('pe3_transaksi_detail')
                  ->join('pe3_transaksi','pe3_transaksi.id','pe3_transaksi_detail.transaksi_id')										
                  ->where('ta', $ta)
                  ->where('bulan',$k)
                  ->where('kombi_id', 601)
                  ->where('status', 1)
                  ->where('kjur',$prodi_id)
                  ->sum('sub_total');

          $sheet->setCellValue("C$row", $nama_prodi);
          $sheet->setCellValueExplicit("D$row",Helper::formatUang($jumlah),\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);		        
          $sub_total += $jumlah; 
          $row+=1;         
        }			
        $styleArray=array( 
          'font' => array('bold' => true),
          'alignment' => array('horizontal'=>Alignment::HORIZONTAL_RIGHT,
                              'vertical'=>Alignment::HORIZONTAL_RIGHT),								
        );           
      
        $sheet->getStyle("A$row:D$row")->applyFromArray($styleArray);
        $sheet->mergeCells("A$row:C$row");
        $sheet->setCellValue("A$row", 'SUB TOTAL');
        $sheet->setCellValueExplicit("D$row",Helper::formatUang($sub_total),\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);		        
      }
      else 
      {				
        $v = "$v " . ($ta+1);
        $sheet->mergeCells("B$row:B". ($row+$jumlah_prodi));        
        $sheet->setCellValue("B$row",$v);	
        foreach ($daftar_prodi as $prodi_id=>$nama_prodi)
        {
          $jumlah = \DB::table('pe3_transaksi_detail')
                  ->join('pe3_transaksi','pe3_transaksi.id','pe3_transaksi_detail.transaksi_id')										
                  ->where('ta', $ta)
                  ->where('bulan',$k)
                  ->where('kombi_id', 601)
                  ->where('status', 1)
                  ->where('kjur',$prodi_id)
                  ->sum('sub_total');
          $sheet->setCellValue("C$row", $nama_prodi);
          $sheet->setCellValueExplicit("D$row",Helper::formatUang($jumlah),\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);		        
          $sub_total += $jumlah;
          $row+=1;         
        }        	
        $styleArray=array( 
          'font' => array('bold' => true),
          'alignment' => array('horizontal'=>Alignment::HORIZONTAL_RIGHT,
                              'vertical'=>Alignment::HORIZONTAL_RIGHT),								
        );           
      
        $sheet->getStyle("A$row:D$row")->applyFromArray($styleArray);

        $sheet->mergeCells("A$row:C$row");
        $sheet->setCellValue("A$row", 'SUB TOTAL');
        $sheet->setCellValueExplicit("D$row",Helper::formatUang($sub_total),\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
      }	
      $total_keseluruhan += $sub_total;
      $row += 1;      
    }
    $styleArray=array( 
      'font' => array('bold' => true),
      'alignment' => array('horizontal'=>Alignment::HORIZONTAL_RIGHT,
                          'vertical'=>Alignment::HORIZONTAL_RIGHT),								
    );           
  
    $sheet->getStyle("A$row:D$row")->applyFromArray($styleArray);

    $sheet->mergeCells("A$row:C$row");
    $sheet->setCellValue("A$row", 'TOTAL KESELURUHAN');
    $sheet->setCellValueExplicit("D$row",Helper::formatUang($total_keseluruhan),\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

    $styleArray=array(								
        'alignment' => array('horizontal'=>Alignment::HORIZONTAL_CENTER,
                            'vertical'=>Alignment::HORIZONTAL_CENTER),
        'borders' => array('allBorders' => array('borderStyle' =>Border::BORDER_THIN))
    );   																					 
    $sheet->getStyle("A$row_awal:D$row")->applyFromArray($styleArray);
    $sheet->getStyle("A$row_awal:D$row")->getAlignment()->setWrapText(true);

    $styleArray=array(								
      'alignment' => array('horizontal'=>Alignment::HORIZONTAL_LEFT)
    );																					 
    $sheet->getStyle("B$row_awal:C$row")->applyFromArray($styleArray);
    
    $styleArray=array(								
      'alignment' => array('horizontal'=>Alignment::HORIZONTAL_RIGHT)
    );																					 
    $sheet->getStyle("D$row_awal:D$row")->applyFromArray($styleArray);  
    
    $generate_date=date('Y-m-d_H_m_s');
    return $this->download("laporan_ujian_munaqasah_$generate_date.xlsx");
  }    
}