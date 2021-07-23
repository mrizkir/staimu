<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use App\Models\Akademik\RegisterMahasiswaModel;
use App\Models\Akademik\DulangModel;
use App\Models\SPMB\FormulirPendaftaranModel;
use Spatie\Permission\Models\Role;

use Illuminate\Http\Request;

use Ramsey\Uuid\Uuid;

class DulangController extends Controller 
{
    /**
     * daftar dulang id yang tidak ada didalam krs
     */
    public function dulangnotinkrs (Request $request)
    {
        $this->hasPermissionTo('AKADEMIK-DULANG-MHS_BROWSE');

        $this->validate($request, [      
            'nim'=>'required|exists:pe3_register_mahasiswa,nim',                 
        ]);
        
        $nim=$request->input('nim');

        $daftar_dulang=DulangModel::select(\DB::raw('
                                    id AS value,
                                    CONCAT("DAFTAR ULANG T.A ",tahun,idsmt) AS text,
                                    update_info,
                                    user_id
                                '))       
                                ->where('nim',$nim)
                                ->where('k_status','A')   
                                ->whereNotIn('id',function($query) use($nim){
                                    $query->select('dulang_id')
                                        ->from('pe3_krs')
                                        ->where('nim',$nim);
                                })
                                ->orderBy('tahun','ASC')
                                ->orderBy('idsmt','ASC')
                                ->get();

        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata',  
                                    'daftar_dulang'=>$daftar_dulang,                                                                                                   
                                    'message'=>'daftar dulang mahasiswa yang tidak ada di KRS dengan status aktif berhasil diperoleh'
                                ], 200);  
    }
    /**
     * cek apakah mahasiswa telah melakukan daftar ulang
     */
    public function cekdulangkrs (Request $request)
    {
        $this->hasPermissionTo('AKADEMIK-DULANG-MHS_SHOW');

        $this->validate($request, [      
            'nim'=>'required|exists:pe3_register_mahasiswa,nim',     
            'ta'=>'required',
            'idsmt'=>'required'
        ]);
        
        $nim=$request->input('nim');
        $ta=$request->input('ta');
        $idsmt=$request->input('idsmt');
        
        $isdulang = DulangModel::where('nim',$nim)
                                ->where('tahun',$ta)
                                ->where('idsmt',$idsmt)
                                ->where('k_status','A')
                                ->exists();

        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata',  
                                    'isdulang'=>$isdulang,                                                                                                   
                                    'message'=>'Cek dulang mahasiswa'
                                ], 200);  
    }
    /**
     * digunakan untuk merubaha biodata mahasiwa dan mengeset sudah update info
     */
    public function updatebiodata(Request $request,$id) {

        if ($this->hasRole('mahasiswa')) 
        {
            $dulang = DulangModel::where('user_id', $this->getUserid())
                                ->find($id);
        }
        else
        {
            $dulang = DulangModel::find($id);
        }
        if (is_null($dulang))
        {
            return Response()->json([
                                    'status'=>0,
                                    'pid'=>'destroy',                
                                    'message'=>["Update biodata mahasiswa dengan dulang id ($id) gagal diperoleh"]
                                ], 422); 
        }
        else
        {
            $this->validate($request, [
                'nama_mhs'=>'required',            
                'tempat_lahir'=>'required',            
                'tanggal_lahir'=>'required',            
                'jk'=>'required',            
                'nomor_hp'=>'required|unique:users,nomor_hp,'.$dulang->user_id,
                'email'=>'required|string|email|unique:users,email,'.$dulang->user_id,
                'nama_ibu_kandung'=>'required',

                'address1_provinsi_id'=>'required',
                'address1_provinsi'=>'required',
                'address1_kabupaten_id'=>'required',
                'address1_kabupaten'=>'required',
                'address1_kecamatan_id'=>'required',
                'address1_kecamatan'=>'required',
                'address1_desa_id'=>'required',
                'address1_kelurahan'=>'required',
                'alamat_rumah'=>'required',                
            ]);

            $dulang = \DB::transaction(function () use ($request,$dulang){ 
                $formulir=FormulirPendaftaranModel::find($dulang->user_id);      
                $formulir->nama_mhs=$request->input('nama_mhs');      
                $formulir->tempat_lahir=$request->input('tempat_lahir');      
                $formulir->tanggal_lahir=$request->input('tanggal_lahir');      
                $formulir->jk=$request->input('jk');      
                $formulir->telp_hp=$request->input('nomor_hp');      
                  
                $formulir->nama_ibu_kandung=$request->input('nama_ibu_kandung');    
                $formulir->address1_provinsi_id=$request->input('address1_provinsi_id');
                $formulir->address1_provinsi=$request->input('address1_provinsi');
                $formulir->address1_kabupaten_id=$request->input('address1_kabupaten_id');
                $formulir->address1_kabupaten=$request->input('address1_kabupaten');
                $formulir->address1_kecamatan_id=$request->input('address1_kecamatan_id');
                $formulir->address1_kecamatan=$request->input('address1_kecamatan');
                $formulir->address1_desa_id=$request->input('address1_desa_id');
                $formulir->address1_kelurahan=$request->input('address1_kelurahan');
                $formulir->alamat_rumah=$request->input('alamat_rumah');              

                $formulir->save();

                $user=$formulir->User;
                $user->name = $request->input('nama_mhs');
                $user->email = $request->input('email');
                $user->nomor_hp = $request->input('nomor_hp');
                $user->save();    

                \DB::table('model_has_permissions')->where('model_id',$user->id)->delete();
                $permission=Role::findByName('mahasiswa')->permissions;
                $user->givePermissionTo($permission->pluck('name'));        
                
                $dulang->update_info = 1;
                $dulang->save();

                return $formulir;
            });
            return Response()->json([
                                    'status'=>1,
                                    'pid'=>'update',
                                    'dulang'=>$dulang,
                                    'message'=>'Biodata Mahasiswa berhasil diubah.'
                                ], 200)->setEncodingOptions(JSON_NUMERIC_CHECK);
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
        $this->hasPermissionTo('AKADEMIK-DULANG-MHS_DESTROY');

        $dulang = DulangModel::find($id);
        
        if (is_null($dulang))
        {
            return Response()->json([
                                    'status'=>0,
                                    'pid'=>'destroy',                
                                    'message'=>["Daftar Ulang Mahasiswa Baru ($id) gagal dihapus"]
                                ], 422); 
        }
        else
        {
            \App\Models\System\ActivityLog::log($request,[
                                                                'object' => $matakuliah, 
                                                                'object_id' => $matakuliah->id, 
                                                                'user_id' => $this->getUserid(), 
                                                                'message' => 'Menghapus daftar ulang mahasiswa baru dengan id ('.$dulang->user_id.') berhasil'
                                                            ]);
            $dulang->delete();
            
            return Response()->json([
                                        'status'=>1,
                                        'pid'=>'destroy',                
                                        'message'=>"Daftar Ulang dengan kode ($id) berhasil dihapus"
                                    ], 200);    
        }
                  
    }    
}