<html>
<head>
<style>
.table {		
    width:100%;
    border-collapse: collapse;    
}
.table th {
    border: 1px solid #000;	    
}
.table td {
    border: 1px solid #000;	    
}
</style>
</head>
<body>
@include('report.ReportHeader')
<table class="table">
    <thead>
        <tr>
            <th width="10">NO</th>
            <th width="70">KODE</th>
            <th width="250">NAMA</th>
            <th width="50">SKS</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($daftar_matkul as $key=>$item)
        <tr>
            <td style="text-align:center">
                {{ $key + 1 }}    
            </td>  
            <td>
                {{ $item->kmatkul}}    
            </td>  
            <td>
                {{ $item->nmatkul}}    
            </td>  
            <td style="text-align:center">
                {{ $item->sks}}    
            </td>  
        </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
