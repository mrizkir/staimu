<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ramsey\Uuid\Uuid;
use Illuminate\Validation\Rule;
use App\Models\SPMB\FormulirPendaftaranModel;

class SystemMigrationController extends Controller {    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $this->hasPermissionTo('SYSTEM-MIGRATION_BROWSE');

        $this->validate($request, [           
            'TA'=>'required',            
        ]);
        
        $ta=$request->input('TA');
        $daftar_tasmt=[];
        
        for ($tahun=$ta;$tahun < 2020; $tahun++)
        {
            $daftar_tasmt[]=[
                'id'=>$tahun.'1',
                'ta'=>$tahun.'/'.($tahun+1),
                'semester'=>'GANJIL',
            ];   
            $daftar_tasmt[]=[
                'id'=>$tahun.'2',
                'ta'=>$tahun.'/'.($tahun+1),
                'semester'=>'GENAP',
            ];   
        }        
        return Response()->json([
                                'status'=>1,
                                'pid'=>'fetchdata',
                                'daftar_tasmt'=>$daftar_tasmt,
                                'message'=>'Fetch data daftar tahun semester berhasil diperoleh'
                            ],200); 
    }
    public function store(Request $request)
    {
        $this->hasPermissionTo('SYSTEM-MIGRATION_STORE');
        
        $status_mhs=json_decode($request->input('status_mhs'),true);
        $request->merge(['status_mhs'=>$status_mhs]);

        $this->validate($request, [
            'nim'=>'required|numeric|unique:pe3_register_mahasiswa,nim',        
            'nirm'=>'required|numeric|unique:pe3_register_mahasiswa,nirm',
            'nama_mhs'=>'required',            
            'dosen_id'=>[
                'required',
                Rule::exists('pe3_dosen','user_id')->where(function($query){
                    return $query->where('is_dw',1);
                })
            ],
            ''=>'required|numeric', 
            'prodi_id'=>'required|numeric',            
            'idkelas'=>'required',
            'tahun_pendaftaran'=>'required',
            'status_mhs.*'=>'required',                        
        ]);
        
        $user = \DB::transaction(function () use ($request){
            $now = \Carbon\Carbon::now()->toDateTimeString();   
            $uuid=Uuid::uuid4()->toString();
            $no_hp=mt_rand(1000,9999);
            $ta=$request->input('tahun_pendaftaran');

            $user=User::create([
                'id'=>$uuid,
                'name'=>$request->input('nama_mhs'),
                'email'=>"$uuid@staimutanjungpinang.ac.id",
                'username'=> $request->input('nim'),
                'password'=>Hash::make('87654321'),
                'nomor_hp'=>"+62$no_hp",
                'ta'=>$ta,
                'email_verified_at'=>'',
                'theme'=>'default',  
                'code'=>0,          
                'active'=>1,         
                'foto'=>'storage/images/users/no_photo.png', 
                'created_at'=>$now, 
                'updated_at'=>$now
            ]);    
            
            $role='mahasiswabaru';   
            $user->assignRole($role);
            $permission=Role::findByName('mahasiswabaru')->permissions;
            $user->givePermissionTo($permission->pluck('name'));            
            
            FormulirPendaftaranModel::create([
                'user_id'=>$user->id,
                'nama_mhs'=>$request->input('name'),                
                'telp_hp'=>$request->input('nomor_hp'),
                'kjur1'=>$request->input('prodi_id'),
                'ta'=>$ta,
            ]);
            return $user;
        });
        return Response()->json([
                                'status'=>1,
                                'pid'=>'store',                                
                                'user'=>$user,
                                'message'=>'Proses migrasi mahasiswa ini berhasil dilakukan, silahkan cek dimasing-masing halaman'
                            ],200);
    }
}
