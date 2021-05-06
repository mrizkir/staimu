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

class ReportKeuanganRegistrasiKRSModel extends ReportModel
{   
  public function __construct($dataReport)
  {
      parent::__construct($dataReport); 
  }    
  public function printtoexcel1()  
  {
    $ta=$this->dataReport['TA'];
    $prodi_id=$this->dataReport['prodi_id'];
    $nama_prodi=$this->dataReport['nama_prodi'];
    $idsmt=$this->dataReport['semester_akademik'];
    $nama_semester=$this->dataReport['nama_semester'];

    $this->spreadsheet->getProperties()->setTitle("Report Registrasi KRS");
    $this->spreadsheet->getProperties()->setSubject("Report Registrasi KRS");

    $sheet = $this->spreadsheet->getActiveSheet();        
    $sheet->setTitle ('LAPORAN REGISTRASI KRS');

    $sheet->getParent()->getDefaultStyle()->applyFromArray([
        'font' => [
            'name' => 'Arial',
            'size' => '9',
        ],
    ]);

    $row=2;
    $sheet->mergeCells("A$row:H$row");				                
    $sheet->setCellValue("A$row","LAPORAN REGISTRASI KRS PROGRAM STUDI $nama_prodi");

    $row+=1;
    $sheet->mergeCells("A$row:H$row");		
    $sheet->setCellValue("A$row","SEMESTER $nama_semester TAHUN AKADEMIK $ta"); 
    
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
    $sheet->getColumnDimension('E')->setWidth(50);
    $sheet->getColumnDimension('F')->setWidth(23);
    $sheet->getColumnDimension('G')->setWidth(15);    
    $sheet->getColumnDimension('H')->setWidth(22);    
    
    $row+=2;        
    $sheet->setCellValue("A$row",'NO');        
    $sheet->setCellValue("B$row",'KODE BILLING');    
    $sheet->setCellValue("C$row",'TANGGAL TRANSAKSI');    
    $sheet->setCellValue("D$row",'NIM');    
    $sheet->setCellValue("E$row",'NAMA MAHASISWA');
    $sheet->setCellValue("F$row",'KELAS');    
    $sheet->setCellValue("G$row",'STATUS');
    $sheet->setCellValue("H$row",'JUMLAH');
    

    $styleArray=array(
        'font' => array('bold' => true),
        'alignment' => array('horizontal'=>Alignment::HORIZONTAL_CENTER,
                            'vertical'=>Alignment::HORIZONTAL_CENTER),
        'borders' => array('allBorders' => array('borderStyle' =>Border::BORDER_THIN))
    );
    $sheet->getStyle("A$row:H$row")->applyFromArray($styleArray);
    $sheet->getStyle("A$row:H$row")->getAlignment()->setWrapText(true);

    $data = TransaksiDetailModel::select(\DB::raw('
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
                                                pe3_kelas.nkelas,
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
                                            ->join('pe3_transaksi','pe3_transaksi_detail.transaksi_id','pe3_transaksi.id')
                                            ->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_transaksi_detail.user_id')
                                            ->join('pe3_status_transaksi','pe3_transaksi.status','pe3_status_transaksi.id_status')        
                                            ->leftJoin('pe3_kelas','pe3_kelas.idkelas','pe3_transaksi.idkelas')        
                                            ->where('pe3_transaksi.ta',$ta)     
                                            ->where('pe3_transaksi.idsmt',$idsmt)                                               
                                            ->where('pe3_transaksi.kjur',$prodi_id)                                                                                           
                                            ->where('pe3_transaksi_detail.kombi_id',202)                                                    
                                            ->orderBy('pe3_formulir_pendaftaran.nama_mhs')
                                            ->get();
    $row+=1;
    $row_awal=$row; 
    $no=1;
    $total_paid=0;
    $total_unpaid=0;
    $total_cancel=0;
    foreach ($data as $v)
    {
        $sheet->setCellValue("A$row",$no);
        $sheet->setCellValueExplicit("B$row",$v->no_transaksi,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValue("C$row",Helper::tanggal('d F Y',$v->tanggal));
        $sheet->setCellValueExplicit("D$row",$v->nim,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValue("E$row",$v->nama_mhs);
        $sheet->setCellValue("F$row",$v->nkelas);
        $sheet->setCellValue("G$row",$v->nama_status);
        $sheet->setCellValueExplicit("H$row",Helper::formatUang($v->total),\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);         
        switch($v->status)
        {
            case 0:
                $total_unpaid += $v->total;
                $sheet->getStyle("A$row:H$row")->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('FFFF00');
            break;
            case 1:
                $total_paid += $v->total;
                
            break;
            case 2:
                $total_cancel += $v->total;
                $sheet->getStyle("A$row:H$row")->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('FF9999');
            break;
        }
        $row+=1;
        $no+=1;
    }
    $row-=1;
    $styleArray=array(								
        'alignment' => array('horizontal'=>Alignment::HORIZONTAL_CENTER,
                            'vertical'=>Alignment::HORIZONTAL_CENTER),
        'borders' => array('allBorders' => array('borderStyle' =>Border::BORDER_THIN))
    );   																					 
    $sheet->getStyle("A$row_awal:H$row")->applyFromArray($styleArray);
    $sheet->getStyle("A$row_awal:H$row")->getAlignment()->setWrapText(true);

    $styleArray=array(								
        'alignment' => array('horizontal'=>Alignment::HORIZONTAL_LEFT)
    );																					 
    $sheet->getStyle("E$row_awal:E$row")->applyFromArray($styleArray);    

    $row+=1;
    $row_awal_mhs=$row;
    $sheet->mergeCells("F$row:G$row");				                
    $sheet->setCellValue("F$row",'SUB TOTAL PAID');
    $sheet->setCellValueExplicit("H$row",Helper::formatUang($total_paid),\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $row+=1;
    $sheet->mergeCells("F$row:G$row");			
    $sheet->setCellValue("F$row",'SUB TOTAL UNPAID');
    $sheet->setCellValueExplicit("H$row",Helper::formatUang($total_unpaid),\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $row+=1;
    $sheet->mergeCells("F$row:G$row");			
    $sheet->setCellValue("F$row",'SUB TOTAL CANCEL');
    $sheet->setCellValueExplicit("H$row",Helper::formatUang($total_cancel),\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $row+=1;
    $sheet->mergeCells("F$row:G$row");			
    $sheet->setCellValue("F$row",'TOTAL');
    $sheet->setCellValueExplicit("H$row",Helper::formatUang($total_paid+$total_unpaid+$total_cancel),\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

    $styleArray=array(
    'font' => array('bold' => true)
    );
    $sheet->getStyle("F$row_awal_mhs:GH$row")->applyFromArray($styleArray);

    $styleArray=array(								
        'alignment' => array('horizontal'=>Alignment::HORIZONTAL_RIGHT)
    );																					 
    $sheet->getStyle("H$row_awal:H$row")->applyFromArray($styleArray);    

    $generate_date=date('Y-m-d_H_m_s');
    return $this->download("registrasi_krs_$generate_date.xlsx");
  }  
  /**
   * cetak rekap penerimaan spp per bulan setiap prodi
   */
  public function printtoexcel2() 
  {
    $ta=$this->dataReport['TA'];    

    $this->spreadsheet->getProperties()->setTitle("Report Registrasi KRS");
    $this->spreadsheet->getProperties()->setSubject("Report Registrasi KRS");

    $sheet = $this->spreadsheet->getActiveSheet();    
    $sheet->setTitle ('LAPORAN PENERIMAAN REG. KRS');

    $sheet->getParent()->getDefaultStyle()->applyFromArray([
      'font' => [
        'name' => 'Arial',
        'size' => '10',
      ],
    ]);

    $row=2;
    $sheet->mergeCells("A$row:D$row");				                
    $sheet->setCellValue("A$row","LAPORAN PENERIMAAN REGISTRASI KRS");

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
                  ->where('kombi_id', 202)
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
                  ->where('kombi_id', 202)
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
    return $this->download("registrasi_krs_$generate_date.xlsx");
  }  
}