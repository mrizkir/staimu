<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Akademik\PembagianKelasModel;
use App\Models\Akademik\PembagianKelasPenyelenggaraanModel;
use App\Models\Akademik\PenyelenggaraanDosenModel;
use App\Models\UserDosen;

use Ramsey\Uuid\Uuid;

class PembagianKelasController extends Controller
{
    /**
     * daftar penyelenggaraan
     */
    public function index(Request $request)
    {
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-PEMBAGIAN-KELAS_BROWSE');

        $this->validate($request, [
            'ta'=>'required',
            'semester_akademik'=>'required',
            'prodi_id'=>'required'
        ]);

        $ta=$request->input('ta');
        $prodi_id=$request->input('prodi_id');
        $semester_akademik=$request->input('semester_akademik');

        $pembagiankelas=PembagianKelasModel::select(\DB::raw('
                            pe3_kelas_mhs.id,
                            pe3_kelas_mhs.idkelas,                            
                            pe3_kelas_mhs.hari,     
                            \'\' AS nama_hari,        
                            pe3_kelas_mhs.jam_masuk,
                            pe3_kelas_mhs.jam_keluar,
                            pe3_kelas_mhs.kmatkul,
                            pe3_kelas_mhs.nmatkul,
                            pe3_kelas_mhs.sks,
                            pe3_dosen.nama_dosen,
                            pe3_dosen.nidn,
                            pe3_kelas_mhs.ruang_kelas_id,
                            pe3_ruangkelas.namaruang,
                            pe3_ruangkelas.kapasitas,
                            0 AS jumlah_mhs,
                            pe3_kelas_mhs.created_at,
                            pe3_kelas_mhs.updated_at                   
                        '))
                        ->join('pe3_dosen','pe3_kelas_mhs.user_id','pe3_dosen.user_id')
                        ->join('pe3_ruangkelas','pe3_ruangkelas.id','pe3_kelas_mhs.ruang_kelas_id')                            
                        ->where('pe3_kelas_mhs.tahun',$ta)
                        ->where('pe3_kelas_mhs.idsmt',$semester_akademik)                                              
                        ->get();
                        
        $pembagiankelas->transform(function ($item,$key){  
            $item->nama_kelas_alias=chr($item->nama_kelas+64);          
            $item->nama_hari=\App\Helpers\Helper::getNamaHari($item->hari);          
            $item->jumlah_mhs=\DB::table('pe3_kelas_mhs_peserta')->where('kelas_mhs_id',$item->id)->count();;
            return $item;
        });
        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata',  
                                    'pembagiankelas'=>$pembagiankelas,                                                                                                                                   
                                    'message'=>'Fetch data pembagian kelas berhasil.'
                                ],200); 
    }
    /**
     * simpan
     */
    public function store(Request $request)
    {
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-PEMBAGIAN-KELAS_STORE');

        $this->validate($request, [            
            'idkelas'=>'required',                        
            'hari'=>'required|numeric',
            'jam_masuk'=>'required',   
            'jam_keluar'=>'required',   
            'penyelenggaraan_dosen_id'=>'required',   
            'ruang_kelas_id'=>'required|exists:pe3_ruangkelas,id',   
            
        ]);

        $pembagiankelas = \DB::transaction(function () use ($request){               
            
            $uuid=Uuid::uuid4()->toString();
            $pembagiankelas=PembagianKelasModel::create([
                'id'=>$uuid,
                'user_id'=>$request->input('user_id'),
                'kmatkul'=>$request->input('kmatkul'),
                'nmatkul'=>$request->input('nmatkul'),
                'sks'=>$request->input('sks'),
                'idkelas'=>$request->input('idkelas'),                
                'hari'=>$request->input('hari'),
                'jam_masuk'=>$request->input('jam_masuk'),
                'jam_keluar'=>$request->input('jam_keluar'),                
                'ruang_kelas_id'=>$request->input('ruang_kelas_id'),                
                'idsmt'=>$request->input('idsmt'),
                'tahun'=>$request->input('ta'),

            ]);
            
            $penyelenggaraan_dosen=json_decode($request->input('penyelenggaraan_dosen_id'),true);

            foreach ($penyelenggaraan_dosen as $v)
            {
                PembagianKelasPenyelenggaraanModel::create([
                    'kelas_mhs_id'=>$uuid,
                    'penyelenggaraan_dosen_id'=>$v
                ]);
            }

            return $pembagiankelas;

        });
        
        return Response()->json([
                                'status'=>1,
                                'pid'=>'store',                    
                                'pembagiankelas'=>$pembagiankelas,                                            
                                'message'=>'Pembagian Kelas berhasil ditambahkan.'
                            ],200);
    }
    public function show(Request $request,$id)
    {
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-PEMBAGIAN-KELAS_SHOW');

        $pembagiankelas = PembagianKelasModel::find($id);
        if (is_null($pembagiankelas))
        {
            return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata',                
                                    'message'=>["Penyelenggaraan dengan ($id) gagal diperoleh"]
                                ],422); 
        }
        else
        {
            return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata',                    
                                    'penyelenggaraan'=>$pembagiankelas,                                            
                                    'message'=>"Penyelenggaraan dengan id ($id) matakuliah berhasil diperoleh."
                                ],200);
        }
    }
    public function pengampu (Request $request)
    {
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-PEMBAGIAN-KELAS_SHOW');

        $this->validate($request, [            
            'pid'=>'required', 
            'idpenyelenggaraan'=>'required|exists:pe3_penyelenggaraan,id'           
        ]);
        
        $data=[];
        $idpenyelenggaraan=$request->input('idpenyelenggaraan');
        switch($request->input('pid'))
        {
            case 'belumterdaftar':
                $data=UserDosen::select(\DB::raw('
                                    user_id,
                                    nidn,                                    
                                    nama_dosen
                                '))       
                                ->where('active',1)                                  
                                ->whereNotIn('user_id',function($query) use ($idpenyelenggaraan){
                                    $query->select('user_id')
                                        ->from('pe3_penyelenggaraan_dosen')
                                        ->where('penyelenggaraan_id',$idpenyelenggaraan);                                        
                                })
                                ->orderBy('nama_dosen','ASC')                                                      
                                ->get();
            break;
            case 'terdaftar':
                $data=UserDosen::select(\DB::raw('
                                    pe3_penyelenggaraan_dosen.id,
                                    pe3_penyelenggaraan_dosen.penyelenggaraan_id,
                                    pe3_penyelenggaraan_dosen.user_id,
                                    pe3_dosen.nidn,                                    
                                    pe3_dosen.nama_dosen,
                                    pe3_penyelenggaraan_dosen.is_ketua,
                                    pe3_penyelenggaraan_dosen.created_at,
                                    pe3_penyelenggaraan_dosen.updated_at
                                '))       
                                ->join('pe3_penyelenggaraan_dosen','pe3_penyelenggaraan_dosen.user_id','pe3_dosen.user_id')                                                                  
                                ->where('penyelenggaraan_id',$idpenyelenggaraan)                                       
                                ->orderBy('nama_dosen','ASC')                                                      
                                ->get();
            break;
        }
        return Response()->json([
                                'status'=>1,
                                'pid'=>'fetchdata',                                
                                'dosen'=>$data,
                                'message'=>'Fetch data Dosen Pengampu berhasil diperoleh'
                            ],200);  
    }
    public function storedosenpengampu (Request $request)
    {
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-PEMBAGIAN-KELAS_STORE');

        $this->validate($request, [   
            'penyelenggaraan_id'=>'required|exists:pe3_penyelenggaraan,id',           
            'dosen_id'=>'required|exists:pe3_dosen,user_id',
            'is_ketua'=>'required'
        ]);
        $idpenyelenggaraan=$request->input('penyelenggaraan_id');
        if ($request->input('is_ketua'))
        {
            PenyelenggaraanDosenModel::where('penyelenggaraan_id',$idpenyelenggaraan)
                                    ->update(['is_ketua'=>false]);
        }
        $dosen=PenyelenggaraanDosenModel::create([
            'id'=>Uuid::uuid4()->toString(),
            'penyelenggaraan_id'=>$idpenyelenggaraan,
            'user_id'=>$request->input('dosen_id'),
            'is_ketua'=>$request->input('is_ketua')
        ]);
        
        return Response()->json([
                                'status'=>1,
                                'pid'=>'store',                    
                                'dosen'=>$dosen,                                            
                                'message'=>'Dosen pengampu Penyelenggaraan matakuliah ini berhasil ditambahkan.'
                            ],200);
    }

    public function update(Request $request,$id)
    {
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-PEMBAGIAN-KELAS_UPDATE');
        
        $pembagian = PembagianKelasModel::find($id); 

        if (is_null($pembagian))
        {
            return Response()->json([
                                    'status'=>1,
                                    'pid'=>'destroy',                
                                    'message'=>["Dosen Pengampu dengan ($id) gagal dihapus"]
                                ],422); 
        }
        else
        {
            $this->validate($request, [                                     
                'hari'=>'required|numeric',
                'jam_masuk'=>'required',   
                'jam_keluar'=>'required',                   
                'ruang_kelas_id'=>'required|exists:pe3_ruangkelas,id',   
            ]);

            $pembagian->hari=$request->input('hari');
            $pembagian->jam_masuk=$request->input('jam_masuk');
            $pembagian->jam_keluar=$request->input('jam_keluar');
            $pembagian->ruang_kelas_id=$request->input('ruang_kelas_id');
            $pembagian->save();
            
            \App\Models\System\ActivityLog::log($request,[
                                                                'object' => $pembagian, 
                                                                'object_id' => $pembagian->id, 
                                                                'user_id' => $this->getUserid(), 
                                                                'message' => 'Mengupdate pembagian kelas dengan id ('.$id.') berhasil'
                                                            ]);
            
            return Response()->json([
                                        'status'=>1,
                                        'pid'=>'update',                
                                        'message' => 'Mengupdate pembagian kelas dengan id ('.$id.') berhasil'
                                    ],200);         
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
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-PEMBAGIAN-KELAS_DESTROY');

        $pembagiankelas = PembagianKelasModel::find($id); 
        
        if (is_null($pembagiankelas))
        {
            return Response()->json([
                                    'status'=>1,
                                    'pid'=>'destroy',                
                                    'message'=>["Kelas dengan ($id) gagal dihapus"]
                                ],422); 
        }
        else
        {
            \App\Models\System\ActivityLog::log($request,[
                                                                'object' => $pembagiankelas, 
                                                                'object_id' => $pembagiankelas->id, 
                                                                'user_id' => $this->getUserid(), 
                                                                'message' => 'Menghapus pembagian kelas dengan id ('.$id.') berhasil'
                                                            ]);
            $pembagiankelas->delete();
            return Response()->json([
                                        'status'=>1,
                                        'pid'=>'destroy',                
                                        'message'=>"Kelas dengan ID ($id) berhasil dihapus"
                                    ],200);         
        }
                    
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroypeserta(Request $request,$id)
    { 
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-PEMBAGIAN-KELAS_DESTROY');

        $dosen = PenyelenggaraanDosenModel::find($id); 
        
        if (is_null($dosen))
        {
            return Response()->json([
                                    'status'=>1,
                                    'pid'=>'destroy',                
                                    'message'=>["Dosen Pengampu dengan ($id) gagal dihapus"]
                                ],422); 
        }
        else
        {
            \App\Models\System\ActivityLog::log($request,[
                                                                'object' => $dosen, 
                                                                'object_id' => $dosen->id, 
                                                                'user_id' => $this->getUserid(), 
                                                                'message' => 'Menghapus penyelenggaraan dosen dengan id ('.$id.') berhasil'
                                                            ]);
            $dosen->delete();
            return Response()->json([
                                        'status'=>1,
                                        'pid'=>'destroy',                
                                        'message'=>"Kelas Dosen dengan ID ($id) berhasil dihapus"
                                    ],200);         
        }
                    
    }
}
