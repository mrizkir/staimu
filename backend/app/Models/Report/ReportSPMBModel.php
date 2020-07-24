<?php

namespace App\Models\Report;

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use \PhpOffice\PhpSpreadsheet\Cell\DataType;

use App\Helpers\Helper;

class ReportSPMBModel extends ReportModel
{   
    public function __construct($dataReport)
    {
        parent::__construct($dataReport); 
    }    
    public function prodi()  
    {
        $ta=$this->dataReport['TA'];
        $prodi_id=$this->dataReport['prodi_id'];
        $nama_prodi=$this->dataReport['nama_prodi'];

        $this->spreadsheet->getProperties()->setTitle("Report Prodi");
        $this->spreadsheet->getProperties()->setSubject("Report Prodi");

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
        return $this->download("laporan_prodi_$generate_date.xlsx");
    }
    public function fakultas()  
    {
        $ta=$this->dataReport['TA'];
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
            $sheet->setCellValue("K$row",$v->nama_prodi.' ('.$v->nama_jenjang.')');
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
        return $this->download("laporan_fakultas_$generate_date.xlsx");
    }
}