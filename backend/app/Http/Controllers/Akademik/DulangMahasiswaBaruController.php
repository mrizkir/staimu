<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use App\Models\SPMB\FormulirPendaftaranModel;
use App\Models\Akademik\RegisterMahasiswaModel;
use App\Models\Akademik\DulangModel;

use Illuminate\Http\Request;

use App\Models\Keuangan\TransaksiDetailModel;

use Ramsey\Uuid\Uuid;

class DulangMahasiswaBaruController extends Controller 
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
		
		$data = DulangModel::select(\DB::raw('
								pe3_dulang.id,
								pe3_dulang.user_id,
								pe3_formulir_pendaftaran.no_formulir,
								pe3_dulang.nim,
								pe3_register_mahasiswa.nirm,
								pe3_formulir_pendaftaran.nama_mhs,
								pe3_dulang.idkelas,                                                          
								pe3_dulang.created_at,      
								pe3_dulang.updated_at                                      
							'))
							->join('pe3_register_mahasiswa','pe3_register_mahasiswa.user_id','pe3_dulang.user_id')
							->join('pe3_formulir_pendaftaran','pe3_formulir_pendaftaran.user_id','pe3_dulang.user_id')
							->where('pe3_register_mahasiswa.tahun',$ta)   
							->where('pe3_dulang.tahun',$ta)   
							->where('pe3_dulang.idsmt', 1)   
							->where('pe3_register_mahasiswa.kjur',$prodi_id)
							->orderBy('pe3_dulang.idsmt','desc')
							->orderBy('nama_mhs','asc')
							->get();

		return Response()->json([
									'status'=>1,
									'pid'=>'fetchdata',  
									'mahasiswa'=>$data,
									'message'=>'Fetch data daftar ulang mahasiswa baru berhasil.'
								], 200);
	}
	/**
	 * update formulir pendaftaran
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request,$id)
	{
		$formulir=FormulirPendaftaranModel::find($id);

		if (is_null($formulir))
		{
			return Response()->json([
									'status'=>0,
									'pid'=>'update',    
									'message'=>["Formulir Pendaftaran dengan ID ($id) gagal diperoleh"]
								], 422); 
		}
		else
		{
		   
			$this->validate($request, [
				'nama_mhs'=>'required',
				'tempat_lahir'=>'required',
				'tanggal_lahir'=>'required',
				'jk'=>'required',
				'nomor_hp'=>'required|unique:users,nomor_hp,'.$formulir->user_id,
				'email'=>'required|string|email|unique:users,email,'.$formulir->user_id,
				'nama_ibu_kandung'=>'required',
				'nik'=>'required|numeric',

				'address1_provinsi_id'=>'required',
				'address1_provinsi'=>'required',
				'address1_kabupaten_id'=>'required',
				'address1_kabupaten'=>'required',
				'address1_kecamatan_id'=>'required',
				'address1_kecamatan'=>'required',
				'address1_desa_id'=>'required',
				'address1_kelurahan'=>'required',
				'alamat_rumah'=>'required',
				
				'kjur1'=>'required',
				'idkelas'=>'required',
			]);

			$data_mhs = \DB::transaction(function () use ($request,$formulir) {            
				$formulir->nama_mhs=$request->input('nama_mhs');      
				$formulir->tempat_lahir=$request->input('tempat_lahir');      
				$formulir->tanggal_lahir=$request->input('tanggal_lahir');      
				$formulir->jk=$request->input('jk');      
				$formulir->telp_hp=$request->input('nomor_hp');      
				  
				$formulir->nama_ibu_kandung=$request->input('nama_ibu_kandung');    				
				$formulir->nik=$request->input('nik');    				
				$formulir->address1_provinsi_id=$request->input('address1_provinsi_id');
				$formulir->address1_provinsi=$request->input('address1_provinsi');
				$formulir->address1_kabupaten_id=$request->input('address1_kabupaten_id');
				$formulir->address1_kabupaten=$request->input('address1_kabupaten');
				$formulir->address1_kecamatan_id=$request->input('address1_kecamatan_id');
				$formulir->address1_kecamatan=$request->input('address1_kecamatan');
				$formulir->address1_desa_id=$request->input('address1_desa_id');
				$formulir->address1_kelurahan=$request->input('address1_kelurahan');
				$formulir->alamat_rumah=$request->input('alamat_rumah');    
				$formulir->kjur1=$request->input('kjur1');    
				$formulir->idkelas=$request->input('idkelas');  
				$formulir->isdulang = true;
				$formulir->save();

				$user=$formulir->User;
				$user->name = $request->input('nama_mhs');
				$user->email = $request->input('email');
				$user->nomor_hp = $request->input('nomor_hp');
				$user->save();    
				
				$formulir=FormulirPendaftaranModel::find($formulir->user_id);
				return [
					'formulir'=>$formulir,
				];
			});
			return Response()->json([
										'status'=>1,
										'pid'=>'update',
										'formulir'=>$formulir,
										'message'=>'Daftar Ulang Mahasiswa Baru baru berhasil dilakukan.'
									],200)->setEncodingOptions(JSON_NUMERIC_CHECK);
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
		$this->hasPermissionTo('AKADEMIK-DULANG-BARU_DESTROY');

		$dulang = DulangModel::find($id); 
		
		if (is_null($dulang))
		{
			return Response()->json([
									'status'=>1,
									'pid'=>'destroy',    
									'message'=>["Daftar Ulang Mahasiswa Baru ($id) gagal dihapus"]
								], 422); 
		}
		else
		{
			\App\Models\System\ActivityLog::log($request,[
																'object' => $dulang, 
																'object_id' => $dulang->id, 
																'user_id' => $this->getUserid(), 
																'message' => 'Menghapus daftar ulang mahasiswa baru dengan id ('.$dulang->user_id.') berhasil'
															]);
			$register_mahasiswa=$dulang->register_mahasiswa;
			$register_mahasiswa->delete();
			
			return Response()->json([
										'status'=>1,
										'pid'=>'destroy',    
										'message'=>"Daftar Ulang dengan kode ($id) berhasil dihapus"
									], 200);    
		}
				  
	}
}