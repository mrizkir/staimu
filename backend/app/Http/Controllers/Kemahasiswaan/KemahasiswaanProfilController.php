<?php

namespace App\Http\Controllers\Kemahasiswaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KemahasiswaanProfilController extends Controller {  
    /**
     * melakukan pencarian untuk nim
     */
    public function search(Request $request)
    {
        $this->hasPermissionTo('KEMAHASISWAAN-PROFIL-MHS_SHOW');

        $this->validate($request,[
            'search'=>'required'        
        ]);
        
        $daftar_mhs = \DB::table('pe3_register_mahasiswa AS A')
                            ->select(\DB::raw('
                                A.user_id,
                                A.nim,
                                B.nama_mhs,
                                CONCAT(\'[\',A.nim,\'] \',B.nama_mhs) AS nama_mhs_alias,
                                D.nama_prodi,
                                C.foto
                            '))
                            ->join('pe3_formulir_pendaftaran AS B','A.user_id','B.user_id')
                            ->join('users AS C','A.user_id','C.id')
                            ->join('pe3_prodi AS D','A.kjur','D.id')
                            ->where('A.nim','LIKE',$request->input('search').'%')
                            ->get();

        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata',
                                    'daftar_mhs'=>$daftar_mhs,  
                                    'jumlah'=>$daftar_mhs->count(),                                                                                                                                   
                                    'message'=>'Daftar Mahasiswa berhasil diperoleh.'
                                ],200); 
    
    }
}