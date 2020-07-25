<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Ramsey\Uuid\Uuid;
use Illuminate\Validation\Rule;

class UsersPMBController extends Controller {         
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {           
        $this->hasPermissionTo('SYSTEM-USERS-PMB_BROWSE');
        $data = User::role('pmb')
                    ->orderBy('username','ASC')
                    ->get();       
                    
        $role = Role::findByName('pmb');
        return Response()->json([
                                'status'=>1,
                                'pid'=>'fetchdata',
                                'role'=>$role,
                                'users'=>$data,
                                'message'=>'Fetch data users PMB berhasil diperoleh'
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
        $this->hasPermissionTo('SYSTEM-USERS-PMB_STORE');
        $this->validate($request, [
            'name'=>'required',
            'email'=>'required|string|email|unique:users',
            'nomor_hp'=>'required|string|unique:users',
            'username'=>'required|string|unique:users',
            'password'=>'required',            
            'prodi_id'=>'required',
        ]);
        $now = \Carbon\Carbon::now()->toDateTimeString();        
        $user=User::create([
            'id'=>Uuid::uuid4()->toString(),
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'nomor_hp'=>$request->input('nomor_hp'),
            'username'=> $request->input('username'),
            'password'=>Hash::make($request->input('password')),                        
            'theme'=>'default',
            'created_at'=>$now, 
            'updated_at'=>$now
        ]);            
        $role='pmb';   
        $user->assignRole($role);               
        
        $user_id=$user->id;
        $daftar_prodi=json_decode($request->input('prodi_id'),true);
        foreach($daftar_prodi as $v)
        {
            $sql = "
                INSERT INTO usersprodi (                    
                    user_id, 
                    prodi_id,
                    kode_prodi,
                    nama_prodi,
                    nama_prodi_alias,
                    kode_jenjang,
                    nama_jenjang,                                                        
                    created_at, 
                    updated_at
                ) 
                SELECT
                    '$user_id',                    
                    id,
                    kode_prodi,
                    nama_prodi,
                    nama_prodi_alias,
                    kode_jenjang,
                    nama_jenjang,                          
                    NOW() AS created_at,
                    NOW() AS updated_at
                FROM pe3_prodi                    
                WHERE 
                    id='$v' 
            ";

            \DB::statement($sql); 
        }

        \App\Models\System\ActivityLog::log($request,[
                                        'object' => $this->guard()->user(), 
                                        'object_id' => $this->guard()->user()->id, 
                                        'user_id' => $this->guard()->user()->id, 
                                        'message' => 'Menambah user PMB('.$user->username.') berhasil'
                                    ]);

        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'store',
                                    'user'=>$user,                                    
                                    'message'=>'Data user PMB berhasil disimpan.'
                                ],200); 

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->hasPermissionTo('SYSTEM-USERS-PMB_UPDATE');

        $user = User::find($id);
        if (is_null($user))
        {
            return Response()->json([
                                    'status'=>1,
                                    'pid'=>'update',                
                                    'message'=>["User ID ($id) gagal diupdate"]
                                ],422); 
        }
        else
        {
            $this->validate($request, [
                                        'username'=>[
                                                        'required',
                                                        'unique:users,username,'.$user->id
                                                    ],           
                                        'name'=>'required',            
                                        'email'=>'required|string|email|unique:users,email,'.$user->id,
                                        'nomor_hp'=>'required|string|unique:users,nomor_hp,'.$user->id,   
                                        'prodi_id'=>'required',           
                                    ]); 
                                    
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->nomor_hp = $request->input('nomor_hp');
            $user->username = $request->input('username');        
            if (!empty(trim($request->input('password')))) {
                $user->password = Hash::make($request->input('password'));
            }    
            $user->updated_at = \Carbon\Carbon::now()->toDateTimeString();
            $user->save();

            $user_id=$user->id;
            \DB::table('usersprodi')->where('user_id',$user_id)->delete();
            $daftar_prodi=json_decode($request->input('prodi_id'),true);
            foreach($daftar_prodi as $v)
            {
                $sql = "
                    INSERT INTO usersprodi (                    
                        user_id, 
                        prodi_id,
                        kode_prodi,
                        nama_prodi,
                        nama_prodi_alias,
                        kode_jenjang,
                        nama_jenjang,                                                        
                        created_at, 
                        updated_at
                    ) 
                    SELECT
                        '$user_id',                    
                        id,
                        kode_prodi,
                        nama_prodi,
                        nama_prodi_alias,
                        kode_jenjang,
                        nama_jenjang,                          
                        NOW() AS created_at,
                        NOW() AS updated_at
                    FROM pe3_prodi                    
                    WHERE 
                        id='$v' 
                ";
                \DB::statement($sql); 
            }

            \App\Models\System\ActivityLog::log($request,[
                                                        'object' => $this->guard()->user(), 
                                                        'object_id' => $this->guard()->user()->id, 
                                                        'user_id' => $this->guard()->user()->id, 
                                                        'message' => 'Mengubah data user PMB ('.$user->username.') berhasil'
                                                    ]);

            return Response()->json([
                                    'status'=>1,
                                    'pid'=>'update',
                                    'user'=>$user,      
                                    'message'=>'Data user PMB '.$user->username.' berhasil diubah.'
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
        $this->hasPermissionTo('SYSTEM-USERS-PMB_DESTROY');

        $user = User::where('isdeleted','1')
                    ->find($id); 
        
        if (is_null($user))
        {
            return Response()->json([
                                    'status'=>1,
                                    'pid'=>'destroy',                
                                    'message'=>["User ID ($id) gagal dihapus"]
                                ],422); 
        }
        else
        {
            $username=$user->username;
            $user->delete();

            \App\Models\System\ActivityLog::log($request,[
                                                                'object' => $this->guard()->user(), 
                                                                'object_id' => $this->guard()->user()->id, 
                                                                'user_id' => $this->guard()->user()->id, 
                                                                'message' => 'Menghapus user PMB ('.$username.') berhasil'
                                                            ]);
        
            return Response()->json([
                                        'status'=>1,
                                        'pid'=>'destroy',                
                                        'message'=>"User PMB ($username) berhasil dihapus"
                                    ],200);         
        }
                  
    }
}