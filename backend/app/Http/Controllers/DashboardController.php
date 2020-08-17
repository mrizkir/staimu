<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DMaster\ProgramStudiModel;

class DashboardController extends Controller 
{  
    /**
     * index pmb
     *
     * @return \Illuminate\Http\Response
     */
    public function pmbindex(Request $request)
    {   
        $this->hasPermissionTo('SPMB-PMB_BROWSE');

        $this->validate($request, [           
            'TA'=>'required',
        ]);

        $ta=$request->input('TA');
        
        $subquery = \DB::table('pe3_formulir_pendaftaran')
                        ->select(\DB::raw('kjur1,COUNT(user_id) AS jumlah'))
                        ->groupBy('kjur1')
                        ->where('ta',$ta);
        
        if ($this->hasRole('superadmin'))
        {
            $daftar_prodi=ProgramStudiModel::select(\DB::raw('id AS prodi_id,nama_prodi,nama_prodi_alias,nama_jenjang,COALESCE(jumlah,0) AS jumlah'))
                                        ->leftJoinSub($subquery,'pe3_formulir_pendaftaran',function($join){
                                            $join->on('pe3_formulir_pendaftaran.kjur1','=','pe3_prodi.id');
                                        })
                                        ->get();
        }
        else if ($this->hasRole('pmb'))
        {
            $daftar_prodi=\DB::table('usersprodi')
                        ->select(\DB::raw('prodi_id,nama_prodi,nama_prodi_alias,nama_jenjang,COALESCE(jumlah,0) AS jumlah'))
                        ->leftJoinSub($subquery,'pe3_formulir_pendaftaran',function($join){
                            $join->on('pe3_formulir_pendaftaran.kjur1','=','usersprodi.prodi_id');
                        })
                        ->where('user_id',$this->getUserid())
                        ->get();
        }

        return Response()->json([
                                'status'=>1,
                                'pid'=>'fetchdata',                                                                                          
                                'daftar_prodi'=>$daftar_prodi,
                                'total_mb'=>$daftar_prodi->sum('jumlah'),                              
                                'message'=>'Fetch data dashboard pmb berhasil diperoleh'
                            ],200);    
        
    }
}