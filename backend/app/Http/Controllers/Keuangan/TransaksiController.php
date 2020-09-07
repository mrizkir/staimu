<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Akademik\RegisterMahasiswaModel;
use App\Models\Keuangan\TransaksiModel;
use App\Models\Keuangan\TransaksiDetailModel;

use Exception;

use Ramsey\Uuid\Uuid;

class TransaksiController extends Controller {  
    /**
     * daftar komponen biaya
     */
    public function index(Request $request)
    {
        $this->hasPermissionTo('KEUANGAN-TRANSAKSI_BROWSE');
        
        $this->validate($request, [           
            'TA'=>'required',
        ]);
        $ta=$request->input('TA');
        $daftar_transaksi = TransaksiModel::select(\DB::raw('
                                                pe3_transaksi.id,
                                                pe3_transaksi.user_id,
                                                pe3_formulir_pendaftaran.nama_mhs,
                                                pe3_transaksi.no_transaksi,
                                                pe3_transaksi.no_faktur,
                                                pe3_transaksi.kjur,
                                                pe3_transaksi.ta,
                                                pe3_transaksi.idsmt,
                                                pe3_transaksi.idkelas,
                                                pe3_transaksi.no_formulir,
                                                pe3_transaksi.nim,
                                                pe3_transaksi.status,
                                                pe3_status_transaksi.nama_status,
                                                pe3_status_transaksi.style,
                                                pe3_transaksi.total,
                                                pe3_transaksi.tanggal,                                                
                                                pe3_transaksi.created_at,
                                                pe3_transaksi.updated_at
                                            '))
                                            ->join('pe3_status_transaksi','pe3_transaksi.status','pe3_status_transaksi.id_status')
                                            ->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_transaksi.user_id')
                                            ->where('pe3_transaksi.ta',$ta)
                                            ->orderBy('tanggal','DESC')
                                            ->get();
        
        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata',  
                                    'transaksi'=>$daftar_transaksi,                                                                                                                                   
                                    'message'=>'Fetch data daftar transaksi berhasil.'
                                ],200);     
    }
    /**
     * digunakan untuk mendapatkan detail transaksi
     */
    public function show(Request $request,$id)
    {
        $transaksi=TransaksiModel::find($id);
        if (is_null($transaksi))        {
            return Response()->json([
                                        'status'=>0,
                                        'pid'=>'fetchdata',                                          
                                        'message'=>"Fetch data transaksi dengan id ($id) gagal diperoleh."
                                    ],422); 
        }
        else
        {
            $transaksi_detail=$transaksi->detail;
            return Response()->json([
                                        'status'=>1,
                                        'pid'=>'fetchdata',  
                                        'transaksi'=>$transaksi,                                                                                                                                   
                                        'transaksi_detail'=>$transaksi_detail,                                                                                                                                   
                                        'message'=>"Fetch data transaksi dengan id ($id) berhasil diperoleh."
                                    ],200); 
        }
    }  
    /**
     * digunakan untuk membatalkan transaksi
     */
    public function cancel(Request $request)
    {
        $this->validate($request, [           
            'transaksi_id'=>'required|exists:pe3_transaksi,id',
        ]);
        $transaksi_id=$request->input('transaksi_id');
        $transaksi=TransaksiModel::find($transaksi_id);

        if ($transaksi->status==1)
        {
            return Response()->json([
                'status'=>0,
                'pid'=>'update',  
                'transaksi_id'=>$transaksi_id,                                                                                                                                   
                'message'=>'Transaksi ini gagal dibatalkan karena status sudah PAID.'
            ],422);   
        }
        else if ($transaksi->status==2)
        {
            return Response()->json([
                'status'=>0,
                'pid'=>'update',  
                'transaksi_id'=>$transaksi_id,                                                                                                                                   
                'message'=>'Transaksi ini gagal dibatalkan karena status sudah DIBATALKAN.'
            ],422); 
        }
        else if ($transaksi->status==0)
        {
            $transaksi->status=2;
            $transaksi->save();

            \App\Models\System\ActivityLog::log($request,[
                                                            'object' => $transaksi, 
                                                            'object_id' => $transaksi->id, 
                                                            'user_id' => $this->getUserid(), 
                                                            'message' => 'Melakukan pembatalan terhadap transaksi dengan id ('.$id.') telah berhasil dilakukan.'
                                                        ]);
                                                        
            return Response()->json([
                                        'status'=>1,
                                        'pid'=>'update',  
                                        'transaksi_id'=>$transaksi_id,                                                                                                                                   
                                        'message'=>'Kode billing dengan ID ('.$transaksi->no_transaksi.') berhasil DIBATALKAN.'
                                    ],200); 
        }
        
    }
    public function sppmhsbaru (Request $request,$id)
    {
        $this->validate($request, [                       
            'jenis_id'=>'required'
        ]);        
        $jenis_id=$request->input('jenis_id');

        try 
        {
            $mhs=$jenis_id == 'nim' ? RegisterMahasiswaModel::where('nim',$id)->first() : RegisterMahasiswaModel::find($id);
            if (is_null($mhs))
            {
                throw new Exception ('SPP Mahasiswa Baru gagal DIPEROLEH.');
            }   

            $user_id=$mhs->user_id;
            $no_bulan=9;        
            $spp=TransaksiDetailModel::join('pe3_transaksi','pe3_transaksi.id','pe3_transaksi_detail.transaksi_id')
                            ->where('pe3_transaksi_detail.kombi_id',201)
                            ->where('pe3_transaksi.ta',$mhs->tahun)
                            ->where('pe3_transaksi.idsmt',$mhs->idsmt)
                            ->where('pe3_transaksi_detail.bulan',$no_bulan)
                            ->where('pe3_transaksi.status',1)
                            ->where('pe3_transaksi_detail.user_id',$user_id)
                            ->first();

            if (is_null($spp))
            {
                throw new Exception ('Mahasiswa Baru ini belum melakukan pembayaran KRS pada Bulan September ');
            }
            return Response()->json([
                'status'=>1,
                'pid'=>'fetchdata',  
                // 'status_transaksi'=>$spp->status,  
                'spp'=>$spp,                                                                                                                                   
                'message'=>'SPP Mahasiswa Baru berhasil DIPEROLEH.'
            ],200); 
        }
        catch (Exception $e)
        {
            return Response()->json([
                'status'=>0,
                'pid'=>'update',                                                                                                                                                  
                'message'=>[$e->getMessage()]
            ],422); 
        }
    }
}