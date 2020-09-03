<?php


namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Keuangan\TransaksiDetailModel;

class MahasiswaBelumPunyaNIMController extends Controller 
{
    /**
     * daftar mahasiswa
     */
    public function index(Request $request)
    {
        $this->hasPermissionTo('AKADEMIK-DULANG-BARU_BROWSE');

        $this->validate($request, [           
            'ta'=>'required',
            'prodi_id'=>'required'
        ]);

        $ta=$request->input('ta');
        $prodi_id=$request->input('prodi_id');

        
        $data = TransaksiDetailModel::select(\DB::raw('
                                        pe3_formulir_pendaftaran.user_id,
                                        pe3_formulir_pendaftaran.no_formulir,
                                        pe3_formulir_pendaftaran.nama_mhs,
                                        pe3_formulir_pendaftaran.telp_hp,
                                        pe3_formulir_pendaftaran.idkelas                                      
                                    '))
                                    ->join('pe3_transaksi','pe3_transaksi.id','pe3_transaksi_detail.transaksi_id')
                                    ->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_transaksi_detail.user_id')
                                    ->leftJoin('pe3_register_mahasiswa','pe3_register_mahasiswa.user_id','pe3_formulir_pendaftaran.user_id')
                                    ->where('kombi_id',102)
                                    ->where('pe3_transaksi.status',1)
                                    ->where('pe3_formulir_pendaftaran.kjur1',$prodi_id)
                                    ->where('pe3_formulir_pendaftaran.ta',$ta)
                                    ->whereNull('pe3_register_mahasiswa.nim')
                                    ->orderBy('pe3_formulir_pendaftaran.idkelas','ASC')                      
                                    ->orderBy('pe3_formulir_pendaftaran.nama_mhs','ASC')                      
                                    ->get();

        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata',  
                                    'mahasiswa'=>$data,                                                                                                                                   
                                    'message'=>'Fetch data calon mahasiswa baru yang belum punya nim berhasil.'
                                ],200);     
    }
}

