<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Akademik\KRSModel;

class BukaNilaiController extends Controller
{
	/**
	 * daftar krs
	 */
	public function index(Request $request)
	{
		$this->hasPermissionTo('KEUANGAN-KONFIRMASI-PEMBAYARAN_BROWSE');
		$daftar_krs=[];
	
    $this->validate($request, [
      'ta'=>'required',
      'semester_akademik'=>'required',
      'prodi_id'=>'required'
    ]);

    $ta=$request->input('ta');
    $prodi_id=$request->input('prodi_id');
    $semester_akademik=$request->input('semester_akademik');

    $daftar_krs = KRSModel::select(\DB::raw('
                pe3_krs.id,
                pe3_krs.nim,
                pe3_formulir_pendaftaran.nama_mhs,
                pe3_krs.tasmt,
                pe3_krs.sah,
                pe3_formulir_pendaftaran.ta AS tahun_masuk,
                0 AS jumlah_matkul,
                0 AS jumlah_sks,
                IF(pe3_krs.locked, false, true) AS locked,
                pe3_krs.created_at,
                pe3_krs.updated_at
              '))
              ->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_krs.user_id')
              ->orderBy('nama_mhs','ASC');
              
    
    if ($request->has('search'))
    {
      $daftar_krs=$daftar_krs->whereRaw('(pe3_krs.nim LIKE \''.$request->input('search').'%\' OR pe3_formulir_pendaftaran.nama_mhs LIKE \'%'.$request->input('search').'%\')')        
            ->orderBy('tasmt','desc')
            ->get();
    }  
    else
    {
      $daftar_krs=$daftar_krs->where('pe3_krs.kjur',$prodi_id)
                  ->where('pe3_krs.tahun',$ta)
                  ->where('pe3_krs.idsmt',$semester_akademik)
                  ->get();
    }
    $daftar_krs->transform(function ($item,$key) {                
      $item->jumlah_matkul=\DB::table('pe3_krsmatkul')->where('krs_id',$item->id)->count();
      $item->jumlah_sks=\DB::table('pe3_krsmatkul')
                  ->join('pe3_penyelenggaraan','pe3_penyelenggaraan.id','pe3_krsmatkul.penyelenggaraan_id')
                  ->where('krs_id',$item->id)->sum('pe3_penyelenggaraan.sks');
      return $item;
    });		
		
		return Response()->json([
									'status'=>1,
									'pid'=>'fetchdata',  
									'daftar_krs'=>$daftar_krs,
									'message'=>'Daftar krs mahasiswa berhasil diperoleh' 
								], 200);  
		
	}
	public function update (Request $request,$id)
	{
		$this->hasPermissionTo('KEUANGAN-KONFIRMASI-PEMBAYARAN_UPDATE');

		$krs = KRSModel::find($id);

		if (is_null($krs))
		{
			return Response()->json([
									'status'=>0,
									'pid'=>'update',    
									'message'=>["KRS dengan ($id) gagal diperoleh"]
								], 422); 
		}
		else
		{
			$this->validate($request, [
				'locked'=>'required|boolean'
			]);

			$krs->locked = $request->input('locked');
			$krs->save();

			return Response()->json([
									'status'=>1,
									'pid'=>'update',
									'message'=>'Ubah status buka nilai mahasiswa berhasil' 
								], 200)->setEncodingOptions(JSON_NUMERIC_CHECK);  
		}        
	}	
}