<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Akademik\PembagianKelasModel;
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

        $pembagiankelas=\DB::table('pe3_kelas_mhs')
                            ->select(\DB::raw('
                                pe3_kelas_mhs.id,
                                pe3_kelas_mhs.idkelas,
                                pe3_kelas_mhs.nama_kelas,
                                pe3_kelas_mhs.hari,
                                pe3_kelas_mhs.jam_masuk,
                                pe3_kelas_mhs.jam_keluar,
                                pe3_matakuliah.kmatkul,
                                pe3_matakuliah.nmatkul,
                                pe3_dosen.nama_dosen,
                                pe3_dosen.nidn,
                                pe3_ruangkelas.namaruang,
                                pe3_ruangkelas.kapasitas,
                                pe3_kelas_mhs.created_at,
                                pe3_kelas_mhs.updated_at
                            '))
                            ->join('pe3_penyelenggaraan_dosen','pe3_penyelenggaraan_dosen.id','pe3_kelas_mhs.id')
                            ->join('pe3_dosen','pe3_penyelenggaraan_dosen.user_id','pe3_dosen.user_id')
                            ->join('pe3_penyelenggaraan','pe3_penyelenggaraan_dosen.penyelenggaraan_id','pe3_penyelenggaraan.id')                            
                            ->join('pe3_matakuliah','pe3_matakuliah.id','pe3_penyelenggaraan.matkul_id')                            
                            ->join('pe3_ruangkelas','pe3_ruangkelas.id','pe3_kelas_mhs.ruang_kelas_id')                            
                            ->where('pe3_penyelenggaraan.tahun',$ta)
                            ->where('pe3_penyelenggaraan.idsmt',$semester_akademik)
                            ->where('pe3_penyelenggaraan.kjur',$prodi_id)                            
                            ->get();
        
        $pembagiankelas->transform(function ($item,$key){            
            $item->jumlah_mhs=\DB::table('pe3_kelas_mhs_detail')->where('kelas_mhs_id',$item->id)->count();;
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

        $matkul_selected=json_decode($request->input('matkul_selected'),true);
        $request->merge(['matkul_selected'=>$matkul_selected]);

        $this->validate($request, [            
            'idkelas'=>'required',                        
            'hari'=>'required',
            'jam_masuk'=>'required',   
            'jam_keluar'=>'required',   
            'penyelenggaraan_dosen_id'=>'required',   
            'ruang_kelas_id'=>'required',   
            
        ]);
        $idkelas=$request->input('idkelas');
        $nama_kelas=$request->input('nama_kelas');
        $nmatkul=$request->input('nmatkul');
        $hari=$request->input('hari');        
        $jam_masuk=$request->input('jam_masuk');
        $jam_keluar=$request->input('jam_keluar');
        $penyelenggaraan_dosen_id=$request->input('penyelenggaraan_dosen_id');
        $ruang_kelas_id=$request->input('ruang_kelas_id');
        
        $pembagiankelas=[];
        // $pembagiankelas=PembagianKelasModel::create([
        //     'id'=>Uuid::uuid4()->toString(),
        //     'idkelas'=>$idkelas,
        //     'nmatkul'=>$nmatkul,
        //     'hari'=>$hari,
        //     'jam_masuk'=>$jam_masuk,
        //     'jam_keluar'=>$jam_keluar,
        //     'penyelenggaraan_dosen_id'=>$penyelenggaraan_dosen_id,
        //     'ruang_kelas_id'=>$ruang_kelas_id,
        // ]);

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

    public function updateketua(Request $request,$id)
    {
        $this->hasPermissionTo('AKADEMIK-PERKULIAHAN-PEMBAGIAN-KELAS_UPDATE');
        
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
            $this->validate($request, [                                     
                'is_ketua'=>'required'
            ]);
            $idpenyelenggaraan=$request->input('penyelenggaraan_id');

            PenyelenggaraanDosenModel::where('penyelenggaraan_id',$idpenyelenggaraan)
                                    ->update(['is_ketua'=>false]);

            $dosen->is_ketua=$request->input('is_ketua');
            $dosen->save();
            
            \App\Models\System\ActivityLog::log($request,[
                                                                'object' => $dosen, 
                                                                'object_id' => $dosen->id, 
                                                                'user_id' => $this->getUserid(), 
                                                                'message' => 'Mengupdate ketua group dosen pengampu dengan id penyelenggaraan ('.$idpenyelenggaraan.') berhasil'
                                                            ]);
            
            return Response()->json([
                                        'status'=>1,
                                        'pid'=>'destroy',                
                                        'message' => 'Mengupdate ketua group dosen pengampu dengan id penyelenggaraan ('.$idpenyelenggaraan.') berhasil'
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
    public function destroypengampu(Request $request,$id)
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
