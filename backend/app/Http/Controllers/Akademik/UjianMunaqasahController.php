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
    private $persyaratan_complete = [];
    private $persyaratan_verified = [];    
    /**
     * daftar peserta ujian munaqasah
     */
    public function index(Request $request)
    {
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-UJIAN-MUNAQASAH_BROWSE');

        $daftar_ujian=\DB::table('pe3_ujian_munaqasah AS A')
                        ->select(\DB::raw('
                            A.id,
                            B.nim,                                            
                            C.nama_mhs,
                            A.judul_skripsi,
                            A.abstrak,
                            B.tahun AS tahun_masuk,
                            CONCAT(COALESCE(D.gelar_depan,\' \'),D.nama_dosen,\' \',COALESCE(D.gelar_belakang,\'\')) AS dosen_pembimbing_1,
                            CONCAT(COALESCE(E.gelar_depan,\' \'),E.nama_dosen,\' \',COALESCE(D.gelar_belakang,\'\')) AS dosen_pembimbing_2,                            
                            A.pembimbing_1,
                            A.pembimbing_2,
                            A.status,
                            A.created_at,
                            A.updated_at
                        '))
                        ->join('pe3_register_mahasiswa AS B','B.user_id','A.user_id')
                        ->join('pe3_formulir_pendaftaran AS C','C.user_id','A.user_id')
                        ->join('pe3_dosen AS D','D.user_id','A.pembimbing_1')
                        ->join('pe3_dosen AS E','E.user_id','A.pembimbing_2');

        if ($this->hasRole('mahasiswa'))
        {
            $daftar_ujian=$daftar_ujian->where('A.user_id', $this->getUserid())
                                        ->get();
        }
        else
        {
            $this->validate($request, [
                'ta'=>'required',                
                'prodi_id'=>'required'
            ]);

            $daftar_ujian=$daftar_ujian->where('A.ta', $request->input('ta'))
                                        ->where('A.prodi_id', $request->input('prodi_id'))
                                        ->get();
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
                                'iscomplete'=>$this->iscomplete(),                                                                                                                                
                                'isverified'=>$this->isverified(),                                                                                                                                
                                'message'=>'Daftar persyaratan mahasiswa berhasil diperoleh' 
                            ], 200);
    }
    public function detail (Request $request,$id)
    {   
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-UJIAN-MUNAQASAH_SHOW');

        $ujian = \DB::table('pe3_ujian_munaqasah AS A')
                        ->select(\DB::raw('
                            A.id,
                            A.user_id,
                            B.nim,                                            
                            C.nama_mhs,
                            A.judul_skripsi,
                            A.abstrak,
                            B.tahun AS tahun_masuk,
                            CONCAT(COALESCE(D.gelar_depan,\' \'),D.nama_dosen,\' \',COALESCE(D.gelar_belakang,\'\')) AS dosen_pembimbing_1,
                            CONCAT(COALESCE(E.gelar_depan,\' \'),E.nama_dosen,\' \',COALESCE(D.gelar_belakang,\'\')) AS dosen_pembimbing_2,                            
                            A.pembimbing_1,
                            A.pembimbing_2,
                            A.status,
                            A.created_at,
                            A.updated_at
                        '))
                        ->join('pe3_register_mahasiswa AS B','B.user_id','A.user_id')
                        ->join('pe3_formulir_pendaftaran AS C','C.user_id','A.user_id')
                        ->join('pe3_dosen AS D','D.user_id','A.pembimbing_1')
                        ->join('pe3_dosen AS E','E.user_id','A.pembimbing_2');

        if ($this->hasRole('mahasiswa'))
        {
            $ujian = $ujian->where('A.user_id',$this->getUserid())
                        ->where('A.id',$id)
                        ->first();                                       
            
        }
        else
        {
            $ujian = $ujian->where('A.id',$id)
                            ->first(); 
        }

        if (is_null($ujian))
        {
            return Response()->json([
                                    'status'=>0,
                                    'pid'=>'fetchdata',                
                                    'message'=>["Data Ujian Munaqasah dengan ID ($id) gagal diperoleh"]
                                ], 422); 
        }
        else
        {
            $user_id = $ujian->user_id;
            $mahasiswa = RegisterMahasiswaModel::join('pe3_formulir_pendaftaran','pe3_register_mahasiswa.user_id','pe3_formulir_pendaftaran.user_id')
                                                ->find($ujian->user_id);

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
                                        'ujian'=>$ujian,                                
                                        'mahasiswa'=>$mahasiswa,
                                        'daftar_persyaratan'=>$daftar_persyaratan, 
                                        'iscomplete'=>$this->iscomplete(),                                                                                                                                  
                                        'isverified'=>$this->isverified(),                                                                                                                                  
                                        'message'=>'Daftar persyaratan mahasiswa berhasil diperoleh' 
                                    ], 200);
        }
        

    }
    public function show (Request $request,$id)
    {
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-UJIAN-MUNAQASAH_SHOW');

        if ($this->hasRole('mahasiswa'))
        {
            $mahasiswa = RegisterMahasiswaModel::find($this->getUserid());
        }
        else
        {
            $mahasiswa = RegisterMahasiswaModel::where('nim',$id)
                                                ->first();
        }
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
                                'iscomplete'=>$this->iscomplete(),                                                                                                                                  
                                'isverified'=>$this->isverified(),                                                                                                                                  
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
    /**
     * digunakan untul menyimpan ujian munaqasah mahasiswa
     */
    public function store (Request $request)
    {
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-UJIAN-MUNAQASAH_STORE');
        
        $this->validate($request, [            
            'user_id'=>'required|exists:pe3_register_mahasiswa,user_id',     
            'judul_skripsi'=>'required',     
            'abstrak'=>'required',     
            'pembimbing_1'=>'required|exists:pe3_dosen,user_id',     
            'pembimbing_2'=>'required|exists:pe3_dosen,user_id',     
            'ta'=>'required',     
        ]);
        
        $mahasiswa = RegisterMahasiswaModel::find($request->input('user_id'));

        $ujian = UjianMunaqasahModel::create([
            'id'=>Uuid::uuid4()->toString(),
            'user_id'=>$request->input('user_id'),
            'judul_skripsi'=>$request->input('judul_skripsi'),
            'abstrak'=>$request->input('abstrak'),
            'pembimbing_1'=>$request->input('pembimbing_1'),
            'pembimbing_2'=>$request->input('pembimbing_2'),
            'prodi_id'=>$mahasiswa->kjur,
            'ta'=>$request->input('ta')
        ]);

        \DB::table('pe3_persyaratan_ujian_munaqasah')
            ->where('user_id', $request->input('user_id'))
            ->update([
                'ujian_munaqasah_id'=>$ujian->id
            ]);

        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'store', 
                                    'ujian'=>$ujian,                                                                                                                                                                        
                                    'message'=>'Data ujian munaqasah berhasil ditambahkan'
                                ], 200);  
    }
    /**
     * digunakan untul menyimpan ujian munaqasah mahasiswa
     */
    public function update (Request $request,$id)
    {
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-UJIAN-MUNAQASAH_UPDATE');
        
        if ($this->hasRole('mahasiswa'))
        {
            $ujian = UjianMunaqasahModel::where('id',$id)
                                        ->find($id);                                       
            
        }
        else
        {
            $ujian = UjianMunaqasahModel::where('id',$id)
                                        ->find($id);                                       
        }
        if (is_null($ujian))
        {
            return Response()->json([
                                    'status'=>0,
                                    'pid'=>'fetchdata',                
                                    'message'=>["Data Ujian Munaqasah dengan ID ($id) gagal diperoleh"]
                                ], 422); 
        }
        else if ($ujian->status == 0)
        {
            $this->validate($request, [            
                'judul_skripsi'=>'required',     
                'abstrak'=>'required',     
                'pembimbing_1'=>'required|exists:pe3_dosen,user_id',     
                'pembimbing_2'=>'required|exists:pe3_dosen,user_id',                 
            ]);            
            
            $ujian->judul_skripsi = $request->input('judul_skripsi');
            $ujian->abstrak = $request->input('abstrak');
            $ujian->pembimbing_1 = $request->input('pembimbing_1');
            $ujian->pembimbing_2 = $request->input('pembimbing_2');
            $ujian->save();

            \DB::table('pe3_persyaratan_ujian_munaqasah')
                ->where('user_id', $ujian->user_id)
                ->update([
                    'ujian_munaqasah_id'=>$ujian->id
                ]);

            return Response()->json([
                                        'status'=>1,
                                        'pid'=>'update', 
                                        'ujian'=>$ujian,                                                                                                                                                                        
                                        'message'=>'Data ujian munaqasah berhasil diubah'
                                    ], 200);  
        }
        else 
        {
            return Response()->json([
                                    'status'=>0,
                                    'pid'=>'destroy',                
                                    'message'=>["Ujian Munaqasah dengan ($id) gagal diupdate karean sudah diverifikasi"]
                                ],422); 
        }
    }
    /**
     * digunakan untul menyimpan ujian munaqasah mahasiswa
     */
    public function verifikasi (Request $request,$id)
    {
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-UJIAN-MUNAQASAH_UPDATE');
        
        if ($this->hasRole('mahasiswa'))
        {
            $ujian = UjianMunaqasahModel::where('id',$id)
                                        ->find($id);                                       
            
        }
        else
        {
            $ujian = UjianMunaqasahModel::where('id',$id)
                                        ->find($id);                                       
        }
        if (is_null($ujian))
        {
            return Response()->json([
                                    'status'=>0,
                                    'pid'=>'fetchdata',                
                                    'message'=>["Data Ujian Munaqasah dengan ID ($id) gagal diperoleh"]
                                ], 422); 
        }
        else
        {
            $user_id = $ujian->user_id;
            $mahasiswa = RegisterMahasiswaModel::join('pe3_formulir_pendaftaran','pe3_register_mahasiswa.user_id','pe3_formulir_pendaftaran.user_id')
                                                ->find($ujian->user_id);

            $daftar_persyaratan = $this->persyaratan(
                PersyaratanUjianMunaqasahModel::select(\DB::raw('
                                                    *,
                                                    "" AS nama_status
                                                '))
                                                ->where('user_id',$user_id)
                                                ->get(),
                $mahasiswa
            );
            
            if ($this->isverified())
            {
                $ujian->status = 1;
                $ujian->save();

                return Response()->json([
                                            'status'=>1,
                                            'pid'=>'update', 
                                            'ujian'=>$ujian,                                                                                                                                                                        
                                            'message'=>'Data ujian munaqasah berhasil diubah'
                                        ], 200);  
            }
            else
            {
                return Response()->json([
                                            'status'=>0,
                                            'pid'=>'update', 
                                            'ujian'=>$ujian,                                                                                                                                                                        
                                            'message'=>'Data ujian munaqasah berhasil diverifikasi karena item persyaratan ada yang belum diperiksa.'
                                        ], 422);  
            }
        }
    }
    /**
     * digunakan untul menyimpan ujian munaqasah mahasiswa
     */
    public function updatepersyaratan (Request $request,$id)
    {
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-UJIAN-MUNAQASAH_UPDATE');
        
        $persyaratan = PersyaratanUjianMunaqasahModel::find($id);                                       
        
        if (is_null($persyaratan))
        {
            return Response()->json([
                                    'status'=>0,
                                    'pid'=>'fetchdata',                
                                    'message'=>["Data Persyaratan Ujian Munaqasah dengan ID ($id) gagal diperoleh"]
                                ], 422); 
        }
        else
        {
            $persyaratan->status=1;
            $persyaratan->save();

            return Response()->json([
                                        'status'=>1,
                                        'pid'=>'update', 
                                        'persyaratan'=>$persyaratan,                                                                                                                                                                        
                                        'message'=>'Data persyaratan ujian munaqasah berhasil diubah'
                                    ], 200);  
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    { 
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-UJIAN-MUNAQASAH_STORE');

        $ujian = UjianMunaqasahModel::find($id); 
        
        if (is_null($ujian))
        {
            return Response()->json([
                                    'status'=>0,
                                    'pid'=>'destroy',                
                                    'message'=>["Ujian Munaqasah dengan ($id) gagal dihapus"]
                                ],422); 
        }
        else if ($ujian->status == 0)
        {
            \App\Models\System\ActivityLog::log($request,[
                                                            'object' => $ujian, 
                                                            'object_id' => $ujian->id, 
                                                            'user_id' => $this->getUserid(), 
                                                            'message' => 'Menghapus Ujian Munaqasah dengan id ('.$id.') berhasil'
                                                        ]);
            $ujian->delete();
            return Response()->json([
                                        'status'=>1,
                                        'pid'=>'destroy',                
                                        'message'=>"Ujian munaqasah dengan ID ($id) berhasil dihapus"
                                    ],200);         
        }
        else 
        {
            return Response()->json([
                                    'status'=>0,
                                    'pid'=>'destroy',                
                                    'message'=>["Ujian Munaqasah dengan ($id) gagal dihapus karean sudah diverifikasi"]
                                ],422); 
        }
                  
    }
    private function persyaratan($daftar_persyaratan,$mahasiswa) 
    {
        $daftar_persyaratan->transform(function ($item,$key) use ($mahasiswa) {                
            switch($item->persyaratan_id) {
                case '2021-ujian-munaqasah-1' : //Pembayaran Uang SPP
                    $this->persyaratan_verified[]=$item->status == 1;
                break;
                case '2021-ujian-munaqasah-2' : //Pembayaran Uang SKRIPSI
                    $detail1 = \DB::table('pe3_transaksi') 
                                ->join('pe3_transaksi_detail', 'pe3_transaksi.id','pe3_transaksi_detail.transaksi_id')
                                ->where('pe3_transaksi.user_id', $mahasiswa->user_id)   
                                ->where('status',1)
                                ->where('kombi_id',601)
                                ->exists();
                    
                    if ($detail1)
                    {
                        $item->keterangan = "SUDAH BAYAR";
                        $this->persyaratan_complete[]=true;
                        $this->persyaratan_verified[]=true;
                    }
                    else 
                    {                        
                        $item->keterangan =  "BELUM BAYAR"; 
                        $this->persyaratan_verified[]=false;
                    }                    
                break;
                case '2021-ujian-munaqasah-4' : //Matakuliah Skripsi terdapat di KRS
                    $detail1 = \DB::table('pe3_prodi_detail1')
                                    ->where('ta',$mahasiswa->tahun)
                                    ->where('prodi_id',$mahasiswa->kjur)
                                    ->first();
                                    
                    if (is_null($detail1->matkul_skripsi)) 
                    {
                        $item->keterangan = "MATAKULIAH SKRIPSI BELUM DISET";
                        $this->persyaratan_complete[]=false;
                        $this->persyaratan_verified[]=false;
                    }
                    else 
                    {
                        $this->persyaratan_complete[]=true;
                        $this->persyaratan_verified[]=true;
                        $item->keterangan = \DB::table('pe3_krsmatkul') 
                                            ->join('pe3_penyelenggaraan', 'pe3_penyelenggaraan.id','pe3_krsmatkul.penyelenggaraan_id')
                                            ->where('nim', $mahasiswa->nim)   
                                            ->where('matkul_id',$detail1->matkul_skripsi)
                                            ->exists() 
                                            ? "ADA" 
                                            : "TIDAK ADA"; 
                                            
                    }                    
                break;
                case '2021-ujian-munaqasah-5' : //Jadwal konsultasi pembimbing                    
                    if (is_null($item->file))
                    {
                        $item->keterangan = 'TIDAK ADA';
                        $this->persyaratan_verified[]=false;
                    }
                    else
                    {
                        $this->persyaratan_verified[]=$item->status == 1;
                    }
                break;
                case '2021-ujian-munaqasah-6' : //Scanan STTB / Ijazah Terakhir
                    if (is_null($item->file))
                    {
                        $item->keterangan = 'TIDAK ADA';
                        $this->persyaratan_verified[]=false;
                    }
                    else
                    {
                        $this->persyaratan_verified[]=$item->status == 1;
                    }                    
                break;                
                case '2021-ujian-munaqasah-7' : //Scanan KTP
                    if (is_null($item->file))
                    {
                        $item->keterangan = 'TIDAK ADA';
                        $this->persyaratan_verified[]=false;
                    }
                    else
                    {
                        $this->persyaratan_verified[]=$item->status == 1;
                    }
                break;                
                case '2021-ujian-munaqasah-8' : //Pas Photo 3x4
                    if (is_null($item->file))
                    {
                        $item->keterangan = 'TIDAK ADA';
                        $this->persyaratan_verified[]=false;
                    }
                    else
                    {
                        $this->persyaratan_verified[]=$item->status == 1;
                    }
                break;                
                case '2021-ujian-munaqasah-9' : //Sertifikat OSPEK / PBAK
                    if (is_null($item->file))
                    {
                        $item->keterangan = 'TIDAK ADA';
                        $this->persyaratan_verified[]=false;
                    }
                    else
                    {
                        $this->persyaratan_verified[]=$item->status == 1;
                    }
                break;                
            }
            switch($item->status) {
                case 0:
                    $item->nama_status = 'BELUM DIPERIKSA';
                break;
                case 1:
                    $item->nama_status = 'SUDAH DIPERIKSA';
                break;
            }
            return $item;
        });
        return $daftar_persyaratan;
    }       
    private function iscomplete()
    {
        $bool = true;
        foreach ($this->persyaratan_complete as $v)
        {
            if (!$v)
            {
                $bool = false;
                break;
            }
        }
        return $bool;
    }
    private function isverified() 
    {
        $bool = true;
        foreach ($this->persyaratan_verified as $v)
        {
            if (!$v)
            {
                $bool = false;
                break;
            }
        }
        return $bool;
    }
}