<?php

namespace App\Http\Controllers\SPMB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SPMB\FormulirPendaftaranModel;
use App\Models\SPMB\NilaiUjianPMBModel;
use App\Models\System\ConfigurationModel;
use App\Models\Keuangan\TransaksiModel;
use App\Models\Keuangan\TransaksiDetailModel;

use App\Helpers\Helper;
use App\Mail\MahasiswaBaruRegistered;
use App\Mail\VerifyEmailAddress;

use Ramsey\Uuid\Uuid;

class NilaiUjianController extends Controller {             
    /**
     * digunakan untuk mendapatkan calon mahasiswa baru yang telah mengisi formulir pendaftaran
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $this->hasAnyPermission(['SPMB-PMB-NILAI-UJIAN_BROWSE']);

        $this->validate($request, [           
            'TA'=>'required',
            'prodi_id'=>'required'
        ]);
        
        $ta=$request->input('TA');
        $prodi_id=$request->input('prodi_id');

        $data = FormulirPendaftaranModel::select(\DB::raw('
                        users.id,
                        users.name,
                        users.nomor_hp,
                        COALESCE(pe3_nilai_ujian_pmb.nilai,\'N.A\') AS nilai,
                        CASE
                            WHEN pe3_nilai_ujian_pmb.ket_lulus IS NULL THEN \'N.A\'
                            WHEN pe3_nilai_ujian_pmb.ket_lulus=0 THEN \'FAIL\'
                            WHEN pe3_nilai_ujian_pmb.ket_lulus=1 THEN \'PASS\'
                        END AS status,
                        pe3_kelas.nkelas,
                        users.active,
                        users.foto,
                        users.created_at,
                        users.updated_at
                    '))
                    ->join('users','pe3_formulir_pendaftaran.user_id','users.id')                    
                    ->join('pe3_kelas','pe3_formulir_pendaftaran.idkelas','pe3_kelas.idkelas')                    
                    ->leftJoin('pe3_nilai_ujian_pmb','pe3_formulir_pendaftaran.user_id','pe3_nilai_ujian_pmb.user_id')                    
                    ->where('users.ta',$ta)
                    ->where('kjur1',$prodi_id)            
                    ->whereNotNull('pe3_formulir_pendaftaran.idkelas')   
                    ->where('users.active',1)    
                    ->orderBy('users.name','ASC') 
                    ->get();
        
        return Response()->json([
                                'status'=>1,
                                'pid'=>'fetchdata',
                                'pmb'=>$data,
                                'message'=>'Fetch data calon mahasiswa baru berhasil diperoleh'
                            ],200);  
    }  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kjur=$request->input('kjur');
        $this->validate($request, [
            'user_id'=>[
                        'required',
                        Rule::exists('pe3_formulir_pendaftaran')->where(function ($query) use ($kjur) {
                            return $query->whereNotNull('idkelas')
                                        ->where('kjur1',$kjur);
                        })
                    ],            
            'no_transaksi'=>[
                        'required',
                        Rule::exists('pe3_transaksi')->where(function ($query) {
                            return $query->where('status',1);
                        })
                    ],   
            'nilai'=>'required|numeric',            
            'kjur'=>'required',            
        ]);
        $user_id=$request->input('user_id');
        $data_nilai=NilaiUjianPMBModel::create([
            'user_id'=>$user_id,
            'jadwal_ujian_id'=>null,
            'jumlah_soal'=>null,
            'jawaban_benar'=>null,
            'jawaban_salah'=>null,
            'soal_tidak_terjawab'=>null,
            'passing_grade_1'=>null,
            'passing_grade_2'=>null,
            'nilai'=>$request->input('nilai'),
            'kjur'=>$request->input('kjur'),
            'ket_lulus'=>1,
            'desc'=>$request->input('desc'),
        ]);          

        \App\Models\System\ActivityLog::log($request,[
                                                        'object' => $data_nilai, 
                                                        'object_id' => $data_nilai->user_id, 
                                                        'user_id' => $this->guard()->user()->id, 
                                                        'message' => 'Mahasiswa berhasil dinyatakan lulus.'
                                                    ]);
        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'store',
                                    'data_nilai'=>$data_nilai,
                                    'message'=>'Menyimpan status kelulusan Mahasiswa Baru berhasil dilakukan.'
                                ],200); 

    }      
    /**
     * Detail formulir pendaftaran
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $formulir=FormulirPendaftaranModel::select(\DB::raw('   
                                                            pe3_formulir_pendaftaran.user_id,                                                       
                                                            kjur1,
                                                            CONCAT(pe3_prodi.nama_prodi,\'(\',pe3_prodi.nama_jenjang,\')\') AS nama_prodi
                                                        '))
                                            ->join('users','users.id','pe3_formulir_pendaftaran.user_id')
                                            ->join('pe3_prodi','pe3_prodi.id','pe3_formulir_pendaftaran.kjur1')                                            
                                            ->find($id);
        if (is_null($formulir))
        {
            return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata',                
                                    'message'=>["Formulir Pendaftaran dengan ID ($id) gagal diperoleh"]
                                ],422); 
        }
        else
        {
            $transaksi_detail=TransaksiDetailModel::select(\DB::raw('pe3_transaksi.no_transaksi,pe3_transaksi.status'))
                                                    ->join('pe3_transaksi','pe3_transaksi.id','pe3_transaksi_detail.transaksi_id')
                                                    ->where('pe3_transaksi.user_id',$formulir->user_id)
                                                    ->where('kombi_id',101)                                                    
                                                    ->first(); 

            $transaksi_status=0;
            $no_transaksi='N.A';
            if (!is_null($transaksi_detail))
            {
                $no_transaksi=$transaksi_detail->no_transaksi;
                $transaksi_status=$transaksi_detail->status;
            }             
            $daftar_prodi[]=['prodi_id'=>$formulir->kjur1,'nama_prodi'=>$formulir->nama_prodi];                     
            return Response()->json([
                                        'status'=>1,
                                        'pid'=>'fetchdata',                                                        
                                        'no_transaksi'=>"$no_transaksi",                                                                           
                                        'transaksi_status'=>$transaksi_status,
                                        'daftar_prodi'=>$daftar_prodi,
                                        'kjur'=>$formulir->kjur1,                                        
                                        'message'=>"Data nilai dengan ID ($id) berhasil diperoleh"
                                    ],200);        
        }

    }   
    /**
     * update formulir pendaftaran
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $formulir=FormulirPendaftaranModel::find($id);

        if (is_null($formulir))
        {
            return Response()->json([
                                    'status'=>1,
                                    'pid'=>'update',                
                                    'message'=>["Formulir Pendaftaran dengan ID ($id) gagal diperoleh"]
                                ],422); 
        }
        else
        {
           
            $this->validate($request, [
                'nama_mhs'=>'required',            
                'tempat_lahir'=>'required',            
                'tanggal_lahir'=>'required',            
                'jk'=>'required',            
                'nomor_hp'=>'required|unique:users,nomor_hp,'.$formulir->user_id,
                'email'=>'required|string|email|unique:users,email,'.$formulir->user_id,
                'nama_ibu_kandung'=>'required',

                'address1_provinsi_id'=>'required',
                'address1_provinsi'=>'required',
                'address1_kabupaten_id'=>'required',
                'address1_kabupaten'=>'required',
                'address1_kecamatan_id'=>'required',
                'address1_kecamatan'=>'required',
                'address1_desa_id'=>'required',
                'address1_kelurahan'=>'required',
                'alamat_rumah'=>'required',
                
                'kjur1'=>'required',
                'idkelas'=>'required',            
            ]);

            $data_mhs = \DB::transaction(function () use ($request,$formulir){            
                $formulir->nama_mhs=$request->input('nama_mhs');           
                $formulir->tempat_lahir=$request->input('tempat_lahir');           
                $formulir->tanggal_lahir=$request->input('tanggal_lahir');           
                $formulir->jk=$request->input('jk');           
                $formulir->telp_hp=$request->input('nomor_hp');           
                  
                $formulir->nama_ibu_kandung=$request->input('nama_ibu_kandung');    
                $formulir->address1_provinsi_id=$request->input('address1_provinsi_id');
                $formulir->address1_provinsi=$request->input('address1_provinsi');
                $formulir->address1_kabupaten_id=$request->input('address1_kabupaten_id');
                $formulir->address1_kabupaten=$request->input('address1_kabupaten');
                $formulir->address1_kecamatan_id=$request->input('address1_kecamatan_id');
                $formulir->address1_kecamatan=$request->input('address1_kecamatan');
                $formulir->address1_desa_id=$request->input('address1_desa_id');
                $formulir->address1_kelurahan=$request->input('address1_kelurahan');
                $formulir->alamat_rumah=$request->input('alamat_rumah');    
                $formulir->kjur1=$request->input('kjur1');    
                $formulir->idkelas=$request->input('idkelas');  

                $formulir->save();

                $user=$formulir->User;
                $user->name = $request->input('nama_mhs');
                $user->email = $request->input('email');
                $user->nomor_hp = $request->input('nomor_hp');
                $user->save();    

                $role='mahasiswabaru';   
                $user->assignRole($role);
                $permission=Role::findByName('mahasiswabaru')->permissions;
                $user->givePermissionTo($permission->pluck('name'));             
                
                //buat transaksi keuangan pmb
                $no_transaksi='N.A';
                $transaksi_detail=TransaksiDetailModel::where('user_id',$formulir->user_id)->where('kombi_id',101)->first();                
                if (is_null($transaksi_detail))
                {                  
                    $kombi=\App\Models\Keuangan\BiayaKomponenPeriodeModel::where('kombi_id',101)
                                                                        ->where('idkelas',$formulir->idkelas)
                                                                        ->where('tahun',$formulir->ta)
                                                                        ->first();
                    if (!is_null($kombi))
                    {
                        $no_transaksi='101'.date('YmdHms');
                        $transaksi=TransaksiModel::create([
                            'id'=>Uuid::uuid4()->toString(),
                            'user_id'=>$formulir->user_id,
                            'no_transaksi'=>$no_transaksi,
                            'no_faktur'=>'',
                            'kjur'=>$formulir->kjur1,
                            'ta'=>$formulir->ta,
                            'idsmt'=>$formulir->idsmt,
                            'idkelas'=>$formulir->idkelas,
                            'no_formulir'=>$formulir->no_formulir,
                            'nim'=>$formulir->nim,
                            'commited'=>0,
                            'total'=>0,
                            'tanggal'=>date('Y-m-d'),
                        ]);  
                        
                        $transaksi_detail=TransaksiDetailModel::create([
                            'id'=>Uuid::uuid4()->toString(),
                            'user_id'=>$formulir->user_id,
                            'transaksi_id'=>$transaksi->id,
                            'no_transaksi'=>$transaksi->no_transaksi,
                            'kombi_id'=>$kombi->kombi_id,
                            'nama_kombi'=>$kombi->nama_kombi,
                            'biaya'=>$kombi->biaya,
                            'jumlah'=>1,
                            'sub_total'=>$kombi->biaya    
                        ]);
                        $transaksi->total=$kombi->biaya;
                        $transaksi->save();
                    }                    
                }
                else
                {
                    $no_transaksi=$transaksi_detail->no_transaksi;
                }
                $formulir=FormulirPendaftaranModel::find($formulir->user_id);
                return [
                    'formulir'=>$formulir,
                    'no_transaksi'=>$no_transaksi
                ];
            });
            return Response()->json([
                                        'status'=>1,
                                        'pid'=>'store',
                                        'formulir'=>$data_mhs['formulir'],                                                                                                  
                                        'no_transaksi'=>$data_mhs['no_transaksi'],                                                                                                  
                                        'message'=>'Formulir Pendaftaran Mahasiswa baru berhasil diubah.'
                                    ],200); 
        }
    }           
    /**
     * Menghapus calon mahasiwa baru
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    { 
        $this->hasPermissionTo('SPMB-PMB_DESTROY');

        $user = User::where('isdeleted','1')
                    ->find($id); 
        
        if (is_null($user))
        {
            return Response()->json([
                                    'status'=>1,
                                    'pid'=>'destroy',                
                                    'message'=>["Calon Mahasiswa Baru dengan ID ($id) gagal dihapus"]
                                ],422); 
        }
        else
        {
            $name=$user->name;
            $user->delete();

            \App\Models\System\ActivityLog::log($request,[
                                                                'object' => $this->guard()->user(), 
                                                                'object_id' => $this->guard()->user()->id, 
                                                                'user_id' => $this->guard()->user()->id, 
                                                                'message' => 'Menghapus Mahasiswa Baru ('.$name.') berhasil'
                                                            ]);
        
            return Response()->json([
                                        'status'=>1,
                                        'pid'=>'destroy',                
                                        'message'=>"Mahasiswa Baru ($name) berhasil dihapus"
                                    ],200);         
        }
                  
    }  
    /**
     * digunakan untuk mengirimkan ulang emai konfirmasi pendaftaran
     */
    public function resend(Request $request)
    {
        $this->validate($request, [
            'id'=>[
                'required',
                "exists:users,id"
            ],                                         
        ]);
        $user = User::find($request->input('id'));
        $name=$user->name;
        
        return Response()->json([
                                'status'=>1,
                                'pid'=>'resendemail',                
                                'message'=>"Kirim ulang data dan konfirmasi PMB ($name) berhasil dikirim"
                            ],200);         
    } 
}