<?php

namespace App\Http\Controllers\Kemahasiswaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KemahasiswaanProfilControllerl extends Controller {  
    /**
     * melakukan pencarian untuk nim
     */
    public function search(Request $request)
    {
        $this->hasPermissionTo('KEMAHASISWAAN-PROFIL-MHS_SHOW');

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
}