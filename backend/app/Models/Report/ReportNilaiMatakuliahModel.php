<?php

namespace App\Models\Report;

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use \PhpOffice\PhpSpreadsheet\Cell\DataType;

use App\Models\Akademik\PembagianKelasPesertaModel;

use App\Helpers\Helper;
use App\Helpers\HelperAkademik;

class ReportNilaiMatakuliahModel extends ReportModel
{   
  public function __construct($dataReport)
  {
      parent::__construct($dataReport); 
  }    
  public function printtemplatenilai()  
  {
    $kelas_mhs_id = $this->dataReport['id'];
    $sheet = $this->spreadsheet->getActiveSheet();
    $row=1;        
    $sheet->setCellValue("A$row",'NO');
    $sheet->setCellValue("B$row",'ID');
    $sheet->setCellValue("C$row",'NIM');    
    $sheet->setCellValue("D$row",'NAMA MAHASISWA');    
    $sheet->setCellValue("E$row",'ABSEN');    
    $sheet->setCellValue("F$row",'TUGAS');    
    $sheet->setCellValue("G$row",'UTS');
    $sheet->setCellValue("H$row",'UAS');        

    $data=PembagianKelasPesertaModel::select(\DB::raw('
										pe3_kelas_mhs_peserta.id,
										pe3_kelas_mhs_peserta.krsmatkul_id,
										pe3_krs.nim,
										pe3_formulir_pendaftaran.nama_mhs									
									'))
									->join('pe3_krsmatkul','pe3_krsmatkul.id','pe3_kelas_mhs_peserta.krsmatkul_id')
									->join('pe3_krs','pe3_krs.id','pe3_krsmatkul.krs_id')									
									->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_krs.user_id')									
									->where('pe3_kelas_mhs_peserta.kelas_mhs_id',$kelas_mhs_id)
									->where('pe3_krsmatkul.batal', 0)
                  ->orderBy('pe3_formulir_pendaftaran.nama_mhs','asc')
									->get();
      
    $row+=1;
    $row_awal=$row;
    $no=1;
    foreach ($data as $v)
    {
        $sheet->setCellValue("A$row",$no);
        $sheet->setCellValue("B$row",$v->krsmatkul_id);
        $sheet->setCellValueExplicit("C$row",$v->nim,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValue("D$row",ucwords(strtolower($v->nama_mhs)));        
        $row+=1;
        $no+=1;
    }
    $generate_date=date('Y-m-d_H_m_s');
    return $this->csv("template_nilai_$generate_date.csv");
  }
  public function printtoexcelperdosen1()  
  {
    $kelas_mhs_id = $this->dataReport['id'];
    $this->spreadsheet->getProperties()->setTitle("DPNA");
    $this->spreadsheet->getProperties()->setSubject("DPNA");

    $sheet = $this->spreadsheet->getActiveSheet();
    $sheet->setTitle ('Daftar Nilai');

    $sheet->getParent()->getDefaultStyle()->applyFromArray([
        'font' => [
            'name' => 'Arial',
            'size' => '9',
        ],
    ]);
    $row=2;
    $sheet->mergeCells("A$row:I$row");				                
    $sheet->setCellValue("A$row","DAFTAR NILAI");

    $styleArray=array( 
        'font' => array('bold' => true,'size'=>'11'),
        'alignment' => array('horizontal'=>Alignment::HORIZONTAL_CENTER,
                            'vertical'=>Alignment::HORIZONTAL_CENTER),								
    );               
    
    $sheet->getStyle("A1:A$row")->applyFromArray($styleArray);

    $row+=2;
    $sheet->mergeCells("A$row:B$row");				                
    $sheet->setCellValue("A$row",'NIDN');
    $sheet->setCellValue("C$row",': '.$this->dataReport['nidn']);

    $sheet->mergeCells("D$row:F$row");
    $sheet->setCellValue("D$row",'KODE');
    $sheet->setCellValue("G$row",': '.$this->dataReport['kmatkul']);
    
    $row+=1;
    $sheet->mergeCells("A$row:B$row");				                
    $sheet->setCellValue("A$row",'NAMA DOSEN');
    $sheet->setCellValue("C$row",': '.trim($this->dataReport['nama_dosen']));

    $sheet->mergeCells("D$row:F$row");
    $sheet->setCellValue("D$row",'MATAKULIAH / KELAS');
    $sheet->setCellValue("G$row",': '.$this->dataReport['nmatkul']);
    
    $row+=1;
    $sheet->mergeCells("A$row:B$row");				                
    $sheet->setCellValue("A$row",'TAHUN AKADEMIK');
    $tahun_akademik = $this->dataReport['tahun'] . '/' . ($this->dataReport['tahun'] + 1);
    $sheet->setCellValue("C$row",': '.$tahun_akademik);

    $sheet->mergeCells("D$row:F$row");
    $sheet->setCellValue("D$row",'SKS');
    $sheet->setCellValue("G$row",': '.$this->dataReport['sks']);
    
    $row+=1;
    $sheet->mergeCells("A$row:B$row");				                
    $sheet->setCellValue("A$row",'SEMESTER');
    $sheet->setCellValue("C$row",': '.HelperAkademik::getSemester($this->dataReport['idsmt']));

    $sheet->mergeCells("D$row:F$row");
    $sheet->setCellValue("D$row",'HARI');
    $sheet->setCellValue("G$row",': '.Helper::getNamaHari($this->dataReport['hari']));
    
    $row+=1;
    $sheet->mergeCells("A$row:B$row");				                
    $sheet->setCellValue("A$row",'RUANG');
    $sheet->setCellValue("C$row",': '.$this->dataReport['namaruang']);

    $sheet->mergeCells("D$row:F$row");
    $sheet->setCellValue("D$row",'WAKTU');
    $sheet->setCellValue("G$row",': '.$this->dataReport['jam_masuk'].' - '.$this->dataReport['jam_keluar']);

    $sheet->getColumnDimension('A')->setWidth(7);
    $sheet->getColumnDimension('B')->setWidth(12);
    $sheet->getColumnDimension('C')->setWidth(50);
    $sheet->getColumnDimension('D')->setWidth(8);
    $sheet->getColumnDimension('E')->setWidth(8);
    $sheet->getColumnDimension('F')->setWidth(8);
    $sheet->getColumnDimension('G')->setWidth(8);        
    $sheet->getColumnDimension('H')->setWidth(8);        
    $sheet->getColumnDimension('I')->setWidth(8);        

    $row+=2;        
    $sheet->setCellValue("A$row",'NO');        
    $sheet->setCellValue("B$row",'NIM');    
    $sheet->setCellValue("C$row",'NAMA MAHASISWA');    
    $sheet->setCellValue("D$row",'ABSEN');    
    $sheet->setCellValue("E$row",'TUGAS');    
    $sheet->setCellValue("F$row",'UTS');
    $sheet->setCellValue("G$row",'UAS');    
    $sheet->setCellValue("H$row",'ANGKA');    
    $sheet->setCellValue("I$row",'HURUF');

    $styleArray=array(
      'font' => array('bold' => true),
      'alignment' => array('horizontal'=>Alignment::HORIZONTAL_CENTER,
                          'vertical'=>Alignment::HORIZONTAL_CENTER),
      'borders' => array('allBorders' => array('borderStyle' =>Border::BORDER_THIN))
    );
    $sheet->getStyle("A$row:I$row")->applyFromArray($styleArray);
    $sheet->getStyle("A$row:I$row")->getAlignment()->setWrapText(true);

    $data=PembagianKelasPesertaModel::select(\DB::raw('
										pe3_kelas_mhs_peserta.id,
										pe3_kelas_mhs_peserta.krsmatkul_id,
										pe3_krs.nim,
										pe3_formulir_pendaftaran.nama_mhs,										    
										COALESCE(pe3_nilai_matakuliah.nilai_absen,0.00) AS nilai_absen,
										COALESCE(pe3_nilai_matakuliah.nilai_tugas_individu,0.00) AS nilai_tugas_individu,
										COALESCE(pe3_nilai_matakuliah.nilai_uts,0.00) AS nilai_uts,
										COALESCE(pe3_nilai_matakuliah.nilai_uas,0.00) AS nilai_uas,
										COALESCE(pe3_nilai_matakuliah.n_kuan,0.00) AS n_kuan,   
										pe3_nilai_matakuliah.n_kual,
										pe3_nilai_matakuliah.bydosen										
									'))
									->join('pe3_krsmatkul','pe3_krsmatkul.id','pe3_kelas_mhs_peserta.krsmatkul_id')
									->join('pe3_krs','pe3_krs.id','pe3_krsmatkul.krs_id')
									->join('pe3_register_mahasiswa','pe3_register_mahasiswa.user_id','pe3_krs.user_id')
									->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_register_mahasiswa.user_id')
									->leftJoin('pe3_nilai_matakuliah','pe3_nilai_matakuliah.krsmatkul_id','pe3_kelas_mhs_peserta.krsmatkul_id')
									->where('pe3_kelas_mhs_peserta.kelas_mhs_id',$kelas_mhs_id)
									->where('pe3_krsmatkul.batal', 0)
                  ->orderBy('pe3_formulir_pendaftaran.nama_mhs','asc')
									->get();
      
    $row+=1;
    $row_awal=$row;
    $no=1;
    foreach ($data as $v)
    {
        $sheet->setCellValue("A$row",$no);
        $sheet->setCellValueExplicit("B$row",$v->nim,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValue("C$row",ucwords(strtolower($v->nama_mhs)));
        $sheet->setCellValue("D$row",$v->nilai_absen);
        $sheet->setCellValue("E$row",$v->nilai_tugas_individu);
        $sheet->setCellValue("F$row",$v->nilai_uts);
        $sheet->setCellValue("G$row",$v->nilai_uas);
        $sheet->setCellValue("H$row",$v->n_kuan);
        $sheet->setCellValue("I$row",$v->n_kual);        
        $row+=1;
        $no+=1;
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

    $row+=2;    
    $row_awal=$row;
    $sheet->mergeCells("G$row:I$row");
    $sheet->setCellValue("G$row",'Tanjungpinang, '. Helper::tanggal('d F Y'));
    $row+=1;
    $sheet->mergeCells("B$row:C$row");
    $sheet->setCellValue("B$row",'Wakil Ketua I');
    $sheet->mergeCells("G$row:I$row");
    $sheet->setCellValue("G$row",'Dosen Pengampu');
    $row+=4;
    $sheet->mergeCells("B$row:C$row");
    $sheet->setCellValue("B$row",'Suhardiman. M.Pd.I');
    $sheet->mergeCells("G$row:I$row");
    $sheet->setCellValue("G$row",trim($this->dataReport['nama_dosen']));
    $row+=1;
    $sheet->mergeCells("B$row:C$row");
    $sheet->setCellValue("B$row",'Lektor NIDN. 2128087201');
    $sheet->mergeCells("G$row:I$row");
    $sheet->setCellValue("G$row",$this->dataReport['nama_jabatan'].' NIDN. '.$this->dataReport['nidn']);

    $styleArray=array(
      'font' => array('bold' => true),      
    );
    $sheet->getStyle("A$row_awal:I$row")->applyFromArray($styleArray);
    $sheet->getStyle("A$row_awal:I$row")->getAlignment()->setWrapText(true);

    $generate_date=date('Y-m-d_H_m_s');
    return $this->excel("daftar_nilai_$generate_date.xlsx");
  }
}