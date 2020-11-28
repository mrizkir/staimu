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
<h2>TRANSKRIP NILAI</h2>
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
<table class="table">
    <thead>
        <tr>
            <th width="10">NO</th>
            <th width="250">MATAKULIAH</th>
            <th width="70">KODE</th>
            <th width="50">SEMESTER</th>
            <th width="50">KELOMPOK</th>
            <th width="50">HM</th>
            <th width="50">AM</th>
            <th width="50">K</th>
            <th width="50">M</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($daftar_nilai as $key=>$item)
        <tr>
            <td style="text-align:center">
                {{ $key + 1 }}    
            </td>  
            <td>
                {{ $item['nmatkul']}}    
            </td>  
            <td style="text-align:center">
                {{ $item['kmatkul']}}    
            </td>  
            <td style="text-align:center">
                {{ $item['semester']}}    
            </td>  
            <td style="text-align:center">
                {{ $item['group_alias']}}    
            </td>  
            <td style="text-align:center">
                {{ $item['HM']}}    
            </td>  
            <td style="text-align:center">
                {{ $item['AM']}}    
            </td>  
            <td style="text-align:center">
                {{ $item['sks']}}    
            </td>  
            <td style="text-align:center">
                {{ $item['M']}}    
            </td>  
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" style="text-align:right"><strong>Jumlah</strong></td>           
            <td style="text-align:center">{{$jumlah_am}}</td>
            <td style="text-align:center">{{$jumlah_sks}}</td>
            <td style="text-align:center">{{$jumlah_m}}</td>            
        </tr>        
        <tr>
            <td colspan="6" style="text-align:right"><strong>IPK</strong></td>
            <td colspan="3">{{$ipk}}</td>            
        </tr>        
    </tfoot>
</table>
</body>
</html>
