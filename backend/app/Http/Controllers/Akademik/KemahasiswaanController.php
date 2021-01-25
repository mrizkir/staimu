<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Akademik\RegisterMahasiswaModel;

class KemahasiswaanController extends Controller {  
    /**
     * update status mahasiswa baru atau lama
     */
    public function updatestatus(Request $request,$id)
    {
        $this->hasPermissionTo('AKADEMIK-KEMAHASISWAAN-STATUS_UPDATE');

        $this->validate($request,[
            'active'=>'required|numeric'
        ]);

        $user = \App\Models\User::find($id); 
        
        if ($user == null)
        {
            return Response()->json([
                                    'status'=>0,
                                    'pid'=>'store',                
                                    'message'=>["Data User tidak ditemukan."]
                                ],422);         
        }
        else
        {
            $user->active = $request->input('active');
            $user->save();

            \App\Models\System\ActivityLog::log($request,[
                                        'object' => $this->guard()->user(), 
                                        'object_id' => $this->guard()->user()->id, 
                                        'user_id' => $this->getUserid(), 
                                        'message' => 'Merubah status Mahasiswa baru menjadi active A.N ('.$user->username.') berhasil dilakukan'
                                    ]);

            return Response()->json([
                                        'status'=>1,
                                        'pid'=>'update',                                                                                                                                     
                                        'message'=>'Status Mahasiswa berhasil diubah.'
                                    ],200); 
        }
    }
    /**
     * ubah dosen wali mahasiswa
     */
    public function updatedw(Request $request,$id)
    {
        $this->hasPermissionTo('AKADEMIK-KEMAHASISWAAN-DW_UPDATE');

        $mahasiswa = RegisterMahasiswaModel::find($id); 
        
        if ($user == null)
        {
            return Response()->json([
                                    'status'=>0,
                                    'pid'=>'store',                
                                    'message'=>["Data Mahasiswa tidak ditemukan."]
                                ],422);         
        }
        else
        {
            $this->validate($request,[
                'dosen_id'=>'required|exists:pe3_dosen,user_id'
            ]);

            $mahasiswa->dosen_id = $request->input('dosen_id');
            $mahasiswa->save();

            \App\Models\System\ActivityLog::log($request,[
                                        'object' => $mahasiswa, 
                                        'object_id' => $mahasiswa->user_id, 
                                        'user_id' => $this->getUserid(), 
                                        'message' => 'Merubah dosen wali mahasiswa menjadi berhasil dilakukan'
                                    ]);

            return Response()->json([
                                        'status'=>1,
                                        'pid'=>'update',                                                                                                                                     
                                        'message'=>'Dosen wali Mahasiswa berhasil diubah.'
                                    ],200); 
        }
    }
}