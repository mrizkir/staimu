<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Akademik\PenyelenggaraanMatakuliahModel;
use App\Models\Akademik\PenyelenggaraanDosenModel;
use App\Models\Akademik\PembagianKelasModel;
use App\Models\Akademik\PembagianKelasPesertaModel;

use App\Models\UserDosen;

use Ramsey\Uuid\Uuid;

class NilaiMatakuliahController extends Controller
{
    /**
     * daftar penyelenggaraan
     */
    public function index(Request $request)
    {
        $this->hasPermissionTo('AKADEMIK-NILAI-MATAKULIAH_BROWSE');

        $this->validate($request, [
            'ta'=>'required',
            'semester_akademik'=>'required',
            'prodi_id'=>'required'
        ]);

        $ta=$request->input('ta');
        $prodi_id=$request->input('prodi_id');
        $semester_akademik=$request->input('semester_akademik');
        
        $daftar_nilai=[];

        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata',  
                                    'daftar_nilai'=>$daftar_nilai,                                                                                                                                   
                                    'message'=>'Fetch data penyelenggaraan matakuliah berhasil.'
                                ],200); 
    }
    public function pesertakelas (Request $request,$id)
    {
        $pembagian = PembagianKelasModel::find($id); 
        
        if (is_null($pembagian))
        {
            return Response()->json([
                                    'status'=>0,
                                    'pid'=>'fetchdata',                
                                    'message'=>["Kelas Mahasiswa dengan ($id) gagal diperoleh"]
                                ],422); 
        }
        else
        {
            $peserta=PembagianKelasPesertaModel::select(\DB::raw('
                                        pe3_kelas_mhs_peserta.id,
                                        pe3_krs.nim,
                                        pe3_formulir_pendaftaran.nama_mhs,
                                        pe3_register_mahasiswa.tahun,
                                        pe3_register_mahasiswa.idkelas,
                                        pe3_register_mahasiswa.tahun,
                                        pe3_register_mahasiswa.kjur,
                                        pe3_nilai_matakuliah.n_kuan,
                                        pe3_nilai_matakuliah.n_kual,
                                        pe3_nilai_matakuliah.created_at,
                                        pe3_nilai_matakuliah.updated_at
                                    '))
                                    ->join('pe3_krsmatkul','pe3_krsmatkul.id','pe3_kelas_mhs_peserta.krsmatkul_id')
                                    ->join('pe3_krs','pe3_krs.id','pe3_krsmatkul.krs_id')                            
                                    ->join('pe3_register_mahasiswa','pe3_register_mahasiswa.user_id','pe3_krs.user_id')
                                    ->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_register_mahasiswa.user_id')
                                    ->leftJoin('pe3_nilai_matakuliah','pe3_nilai_matakuliah.krsmatkul_id','pe3_kelas_mhs_peserta.krsmatkul_id')
                                    ->where('pe3_kelas_mhs_peserta.kelas_mhs_id',$id)
                                    ->get();
            return Response()->json([
                                'status'=>1,
                                'pid'=>'fetchdata',                                                                                         
                                'peserta'=>$peserta,                                            
                                'message'=>"Daftar Peserta MHS dari Kelas MHS dengan id ($id) berhasil diperoleh."
                            ],200);
        }
    }
}
