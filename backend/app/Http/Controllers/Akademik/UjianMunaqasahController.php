<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\Akademik\RegisterMahasiswaModel;
use App\Models\Akademik\UjianMunaqasahModel;
use App\Models\Akademik\PersyaratanUjianMunaqasahModel;
use App\Models\DMaster\PersyaratanModel;

use App\Models\System\ConfigurationModel;

use Ramsey\Uuid\Uuid;

class UjianMunaqasahController extends Controller
{
    /**
     * daftar peserta ujian munaqasah
     */
    public function index(Request $request)
    {
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-UJIAN-MUNAQASAH_BROWSE');

        if ($this->hasRole('mahasiswa'))
        {
            $daftar_ujian=[];
        }
        else
        {
            $daftar_ujian=[];

            $this->validate($request, [
                'ta'=>'required',                
                'prodi_id'=>'required'
            ]);
        }        
        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata',  
                                    'daftar_ujian'=>$daftar_ujian,                                                                                                                                   
                                    'message'=>'Daftar peserta ujian munaqasah berhasil diperoleh' 
                                ],200);  
        
    }
    public function cekpersyaratan(Request $request)
    {
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-UJIAN-MUNAQASAH_BROWSE');
        
        $this->validate($request, [            
            'nim'=>'required|exists:pe3_register_mahasiswa,nim',
        ]);
        $nim = $request->input('nim');        
        $mahasiswa = RegisterMahasiswaModel::where('nim',$nim)
                                            ->first();
        $user_id = $mahasiswa->user_id;

        $sql = " INSERT INTO 
        pe3_persyaratan_ujian_munaqasah 
        (
            id,
            user_id,
            persyaratan_id,
            ujian_munaqasah_id,
            nama_persyaratan,
            file,
            status,
            keterangan,
            created_at,
            updated_at
        ) 
        SELECT 
            UUID(),
            '$user_id',
            id AS persyaratan_id,
            NULL,
            nama_persyaratan,
            NULL,
            0,
            NULL,
            NOW() AS created_at,
            NOW() AS updated_at 
        FROM pe3_persyaratan 
        WHERE proses='ujian-munaqasah' 
        AND 
        id
        NOT IN (
            SELECT 
                persyaratan_id 
            FROM 
                pe3_persyaratan_ujian_munaqasah 
            WHERE user_id='$user_id')
        ";
        
        \DB::statement($sql);

        $daftar_persyaratan = $this->persyaratan(
            PersyaratanUjianMunaqasahModel::select(\DB::raw('
                                                *,
                                                "" AS nama_status
                                            '))
                                            ->where('user_id',$user_id)
                                            ->get(),
            $mahasiswa
        );
        
        return Response()->json([
                                'status'=>1,
                                'pid'=>'fetchdata',                                
                                'mahasiswa'=>$mahasiswa,
                                'daftar_persyaratan'=>$daftar_persyaratan,                                                                                                                                   
                                'message'=>'Daftar persyaratan mahasiswa berhasil diperoleh' 
                            ], 200);
    }
    public function show (Request $request,$id)
    {
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-UJIAN-MUNAQASAH_SHOW');

        $mahasiswa = RegisterMahasiswaModel::where('nim',$id)
                                            ->first();

        if (is_null($mahasiswa))
        {
            return Response()->json([
                                    'status'=>0,
                                    'pid'=>'fetchdata',                
                                    'message'=>["Data Mahasiswa dengan nim ($id) gagal diperoleh"]
                                ],422); 
        }
        else
        {
            $user_id = $mahasiswa->user_id;
            
            $daftar_persyaratan = $this->persyaratan(
                                    PersyaratanUjianMunaqasahModel::select(\DB::raw('
                                                                        *,
                                                                        "" AS nama_status
                                                                    '))
                                                                    ->where('user_id',$user_id)
                                                                    ->get(),
                                    $mahasiswa
                                );

            
            return Response()->json([
                                'status'=>1,
                                'pid'=>'fetchdata',                                
                                'mahasiswa'=>$mahasiswa,
                                'daftar_persyaratan'=>$daftar_persyaratan,                                                                                                                                   
                                'message'=>'Daftar persyaratan mahasiswa berhasil diperoleh' 
                            ], 200);
        }        
    }  
    public function upload (Request $request,$id)
    {
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-UJIAN-MUNAQASAH_STORE');

        $ujian_munaqasah = PersyaratanUjianMunaqasahModel::find($id); 
        
        if (is_null($ujian_munaqasah))
        {
            return Response()->json([
                                    'status'=>0,
                                    'pid'=>'store',                
                                    'message'=>["Data Persyaratan Ujian Munaqasah tidak ditemukan."]
                                ], 422);         
        }
        else
        {
            $this->validate($request, [    
                'filepersyaratan'=>'required'                        
            ]);            
            $foto = $request->file('filepersyaratan');
            $mime_type=$foto->getMimeType();
            if ($mime_type=='image/png' || $mime_type=='image/jpeg')
            {
                $folder=Helper::public_path('images/ujianmunaqasah/');
                $file_name="$id.".$foto->getClientOriginalExtension();                                
                $ujian_munaqasah->file="storage/images/ujianmunaqasah/$file_name";
                $ujian_munaqasah->keterangan = 'ADA';                            
                $ujian_munaqasah->save();                            
                $foto->move($folder,$file_name);                
                return Response()->json([
                                            'status'=>0,
                                            'pid'=>'store',
                                            'persyaratan'=>$ujian_munaqasah->file,                
                                            'message'=>"Persyaratan Ujian Munaqasah (". $ujian_munaqasah->nama_persyaratan. ")  berhasil diupload"
                                        ],200);    
            }
            else
            {
                return Response()->json([
                                        'status'=>1,
                                        'pid'=>'store',
                                        'message'=>["Extensi file yang diupload bukan jpg atau png."]
                                    ], 422);                 

            }
        }
    }  
    private function persyaratan($daftar_persyaratan,$mahasiswa) 
    {
        $daftar_persyaratan->transform(function ($item,$key) use ($mahasiswa) {                
            switch($item->persyaratan_id) {
                case '2021-ujian-munaqasah-2' : //Pembayaran Uang SKRIPSI
                    $item->keterangan = \DB::table('pe3_transaksi') 
                                            ->join('pe3_transaksi_detail', 'pe3_transaksi.id','pe3_transaksi_detail.transaksi_id')                                            
                                            ->where('pe3_transaksi.user_id', $mahasiswa->user_id)   
                                            ->where('status',1)
                                            ->where('kombi_id',601)
                                            ->exists() 
                                            ? "SUDAH BAYAR" 
                                            : "BELUM BAYAR";
                break;
                case '2021-ujian-munaqasah-4' : //Matakuliah Skripsi terdapat di KRS
                    $detail1 = \DB::table('pe3_prodi_detail1')
                                    ->where('ta',$mahasiswa->tahun)
                                    ->where('prodi_id',$mahasiswa->kjur)
                                    ->first();
                                    
                    if (is_null($detail1->matkul_skripsi)) 
                    {
                        $item->keterangan = "MATAKULIAH SKRIPSI BELUM DISET";
                    }
                    else 
                    {
                        $item->keterangan = \DB::table('pe3_krsmatkul') 
                                            ->join('pe3_penyelenggaraan', 'pe3_penyelenggaraan.id','pe3_krsmatkul.penyelenggaraan_id')                                            
                                            ->where('nim', $mahasiswa->nim)   
                                            ->where('matkul_id',$detail1->matkul_skripsi)
                                            ->exists() 
                                            ? "ADA" 
                                            : "TIDAK ADA"; 
                                            
                    }
                break;

            }
            switch($item->status) {
                case 0:
                    $item->nama_status = 'BELUM DIPERIKSA';
                break;
            }
            return $item;
        });
        return $daftar_persyaratan;
    }    
}