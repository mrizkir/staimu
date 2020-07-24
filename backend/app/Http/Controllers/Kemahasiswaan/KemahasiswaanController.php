<?php

namespace App\Http\Controllers\Kemahasiswaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KemahasiswaanController extends Controller {  
    /**
     * update status mahasiswa baru atau lama
     */
    public function updatestatus(Request $request,$id)
    {
        $this->hasPermissionTo('KEMAHASISWAAN-STATUS_UPDATE');

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
            return Response()->json([
                                        'status'=>1,
                                        'pid'=>'update',                                                                                                                                     
                                        'message'=>'Status Mahasiswa berhasil diubah.'
                                    ],200); 
        }
    }
}