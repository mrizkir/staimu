<html>
<head>
<style>
.header{
    width:100%;
    font-weight:bold;
    text-align:center;
    border-collapse: collapse;   
    border-bottom: 2px solid black;
}
.table {		
    width:100%;
    border-collapse: collapse;   
    font-size: 12px; 
    margin-bottom: 10px;
}
.table th {
    border: 1px solid #000;	    
}
.table td {
    border: 1px solid #000;	    
}
h2{
    text-align:center;
}
</style>
</head>
<body>
@include('report.ReportHeader')
<h2>TRANSKRIP NILAI SEMESTER</h2>
<table style="font-size:14px">
    <tbody>
        <tr>
            <td><strong>Nama Mahasiswa</strong></td>
            <td>:</td>
            <td width="250">{{$mahasiswa->nama_mhs}} ({{$mahasiswa->jk}})</td>

            <td><strong>Fakultas</strong></td>
            <td>:</td>
            <td>-</td>
        </tr>
        <tr>
            <td><strong>NIRM</strong></strong></td>
            <td>:</td>
            <td>{{$mahasiswa->nirm}}</td>

            <td><strong>Program Studi</strong></td>
            <td>:</td>
            <td>{{$mahasiswa->nama_prodi}}</td>
        </tr>        
    </tbody>
</table>
<table>    
    <tbody>            
        @php
            $totalSks=0;
            $totalM=0;
            $row=0;
            $row_ganjil=$row;
            $row_genap = $row;
            
            $tambah_ganjil_row=false;		
            $tambah_genap_row=false;		
            foreach ($daftar_nilai as $key=>$item)
            {    
                $no_semester=1;
                if ($key%2==0) 
                {//genap
                    $tambah_genap_row=true;
                    $genap_total_m=0;
                    $genap_total_sks=0;	

                    foreach ($item as $key_genap=>$item_genap)
                    {                      
                        $row_genap+=4;
                        $no_semester++;                
                    }
                }
                else //ganjil
                {
                    $tambah_ganjil_row=true;
                    $ganjil_total_m=0;
                    $ganjil_total_sks=0;

                    foreach ($item as $key_ganjil=>$item_ganjil)
                    {                                      
                        $row_ganjil+=4;
                        $no_semester++;                
                    }
                }
                if ($tambah_ganjil_row && $tambah_genap_row) 
                {
                    $tambah_ganjil_row=false;
                    $tambah_genap_row=false;						
                    if ($row_ganjil < $row_genap){ // berarti tambah row yang ganjil
                        $sisa=$row_ganjil + ($row_genap-$row_ganjil);
                        for ($c=$row_ganjil;$c <= $row_genap;$c+=4) {
                            // $rpt->setXY(3,$c);
                            // $rpt->Cell(102,4,'',1,0);
                        }
                        $row_ganjil=$sisa;
                    }else{ // berarti tambah row yang genap
                        $sisa=$row_genap + ($row_ganjil-$row_genap);						
                        for ($c=$row_genap;$c < $row_ganjil;$c+=4) {
                            // $rpt->setXY(106,$c);
                            // $rpt->Cell(102,4,'',1,0);
                        }
                        $row_genap=$sisa;
                    }		
                    //ganjil
                    // $rpt->setXY(16,$row_ganjil);	
                    // $rpt->Cell(65,4,'Jumlah',1,0,'L');						
                    // $rpt->Cell(8,4,$ganjil_total_sks,1,0,'C');
                    // $rpt->Cell(8,4,'',1,0,'L');						
                    // $rpt->Cell(8,4,$ganjil_total_m,1,0,'C');
                    $row_ganjil+=4;
                    // $rpt->setXY(16,$row_ganjil);	
                    // $rpt->Cell(81,4,'Indeks Prestasi Semester',1,0,'L');
                    // $ip=@ bcdiv($ganjil_total_m,$ganjil_total_sks,2);												
                    // $rpt->Cell(8,4,$ip,1,0,'C');
                    $row_ganjil+=4;
                    // $rpt->setXY(16,$row_ganjil);	
                    // $rpt->Cell(81,4,'Indeks Prestasi Kumulatif',1,0,'L');		
                    // $ipk_ganjil=$ip == '0.00'?'0.00':$ipk_ganjil;
                    // $rpt->Cell(8,4,$ipk_ganjil,1,0,'C');
                    $row_ganjil+=4;	
                    // $rpt->setXY(16,$row_ganjil);
                    // $rpt->Cell(8,4,' ',0,0,'C');						
                    $row_ganjil+=1;		
                    //genap			
                    // $rpt->setXY(119,$row_genap);	
                    // $rpt->Cell(65,4,'Jumlah',1,0,'L');						
                    // $rpt->Cell(8,4,$genap_total_sks,1,0,'C');
                    // $rpt->Cell(8,4,'',1,0,'L');
                    // $rpt->Cell(8,4,$genap_total_m,1,0,'C');
                    $row_genap+=4;
                    // $rpt->setXY(119,$row_genap);	
                    // $rpt->Cell(81,4,'Indeks Prestasi Semester',1,0,'L');
                    // $ip=@ bcdiv($genap_total_m,$genap_total_sks,2);									
                    // $rpt->Cell(8,4,$ip,1,0,'C');
                    $row_genap+=4;
                    // $rpt->setXY(119,$row_genap);	
                    // $rpt->Cell(81,4,'Indeks Prestasi Kumulatif',1,0,'L');								
                    // $ipk_genap=$ip == '0.00'?'0.00':$ipk_genap;
                    // $rpt->Cell(8,4,$ipk_genap,1,0,'C');
                    $row_genap+=4;
                    // $rpt->setXY(119,$row_genap);	
                    // $rpt->Cell(8,4,' ',0,0,'C');
                    $row_genap+=1;				   
                }
            }
        @endphp        
    </tbody>
</table>
<table style="font-size:12px">
    <tbody>
        <tr>
            <td width="150"><strong>SKS Total</strong></td>           
            <td width="5">:</td>
            <td>{{$jumlah_sks}}</td>            
        </tr>        
        <tr>
            <td><strong>IPK</strong></td>
            <td>:</td>
            <td>{{$ipk}}</td>            
        </tr>        
    </tbody>
</table>
<table style="font-size:12px">
    <tbody>
        <tr>
            <td width="65%"></td>
            <td><strong>Tanjungpinang, {{$tanggal}}</strong></td>                                   
        </tr>        
        <tr>
            <td width="65%"></td>
            <td><strong>Wakil Ketua 1 Bidang Akademik</strong></td>                                   
        </tr>        
        <tr>
            <td width="65%"></td>
            <td>
                <br>
                <br>
                <br>
                <br>
                <br>
                ____________________<br>
                NIDN.:
            </td>                                   
        </tr>        
            
    </tbody>
</table>
</body>
</html>
