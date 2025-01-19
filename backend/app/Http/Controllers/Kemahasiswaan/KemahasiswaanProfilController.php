<?php

namespace App\Http\Controllers\Kemahasiswaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SPMB\FormulirPendaftaranModel;
use Illuminate\Support\Facades\Hash;

class KemahasiswaanProfilController extends Controller {  
	/**
	 * melakukan pencarian untuk nim
	 */
	public function search(Request $request)
	{
		$this->hasPermissionTo('KEMAHASISWAAN-PROFIL-MHS_SHOW');

		$this->validate($request,[
			'search' => 'required'        
		]);
		
		$daftar_mhs = \DB::table('pe3_register_mahasiswa AS A')
							->select(\DB::raw('
								A.user_id,
								A.nim,
								B.nama_mhs,
								CONCAT(\'[\',A.nim,\'] \',B.nama_mhs) AS nama_mhs_alias,
								D.nama_prodi,
								A.idkelas,
								C.foto
							'))
							->join('pe3_formulir_pendaftaran AS B', 'A.user_id', 'B.user_id')
							->join('users AS C', 'A.user_id', 'C.id')
							->join('pe3_prodi AS D', 'A.kjur', 'D.id')
							->whereRaw('(A.nim LIKE \''.$request->input('search').'%\' OR B.nama_mhs LIKE \'%'.$request->input('search').'%\')')        
							->get();

		return Response()->json([
									'status' => 1,
									'pid' => 'fetchdata',
									'daftar_mhs' => $daftar_mhs,  
									'jumlah' => $daftar_mhs->count(),
									'message' => 'Daftar Mahasiswa berhasil diperoleh.'
								], 200); 
	
	}
	/**
	 * profil mahasiswa berdasarkan nim
	 */
	public function bynim(Request $request)
	{
		$this->hasPermissionTo('KEMAHASISWAAN-PROFIL-MHS_SHOW');

		$this->validate($request,[
			'nim' => 'required|numeric'
		]);
		
		$profil = \DB::table('pe3_register_mahasiswa AS A')
							->select(\DB::raw('
								A.user_id,
								A.nim,
								B.*,
								D.nama_prodi,
								A.idkelas,
								E.nkelas,
								C.foto
							'))
							->join('pe3_formulir_pendaftaran AS B', 'A.user_id', 'B.user_id')
							->join('users AS C', 'A.user_id', 'C.id')
							->join('pe3_prodi AS D', 'A.kjur', 'D.id')
							->join('pe3_kelas AS E', 'A.idkelas', 'E.idkelas')
							->where('A.nim', $request->input('nim'))        
							->first();

		return Response()->json([
									'status' => 1,
									'pid' => 'fetchdata',
									'profil' => $profil,
									'message' => 'Profil Mahasiswa berhasil diperoleh.'
								], 200); 
	
	}
	/**
	 * profil mahasiswa berdasarkan userid
	 */
	public function byuserid(Request $request)
	{
		$this->hasPermissionTo('KEMAHASISWAAN-PROFIL-MHS_SHOW');

		$this->validate($request,[
			'user_id' => 'required'
		]);
		
		$profil = \DB::table('pe3_register_mahasiswa AS A')
							->select(\DB::raw('
								A.user_id,
								A.nim,
								C.nomor_hp,
								C.email,
								B.no_formulir,
								B.nama_mhs,
								B.tempat_lahir,
								B.tanggal_lahir,
								B.jk,
								B.idagama,
								B.idwarga,
								B.nik,
								B.ukuran_baju,
								B.status_pekerjaan,
								B.alamat_kantor,
								B.telp_kantor,
								B.address1_desa_id,
								B.address1_kelurahan,
								B.address1_kecamatan_id,
								B.address1_kecamatan,
								B.address1_kabupaten_id,
								B.address1_kabupaten,
								B.address1_provinsi_id,
								B.address1_provinsi,
								B.alamat_rumah,
								B.telp_rumah,
								B.telp_hp,
								B.nama_ibu_kandung,
								B.id_jenispekerjaan_ortu,								
								B.pendidikan_terakhir,
								B.jurusan,
								B.address2_kabupaten_id,
								B.address2_kota,
								B.address2_provinsi_id,
								B.address2_provinsi,
								B.tahun_pa,
								B.jenis_slta,
								B.asal_slta,
								B.status_slta,
								B.nomor_ijazah,
								D.nama_prodi,
								A.idkelas,
								E.nkelas,
								A.kjur,								
								A.k_status,								
								A.konsentrasi_id,								
								A.dosen_id,								
								A.tahun,								
								C.foto
							'))
							->join('pe3_formulir_pendaftaran AS B', 'A.user_id', 'B.user_id')
							->join('users AS C', 'A.user_id', 'C.id')
							->join('pe3_prodi AS D', 'A.kjur', 'D.id')
							->join('pe3_kelas AS E', 'A.idkelas', 'E.idkelas')
							->where('A.user_id', $request->input('user_id'))        
							->first();

		return Response()->json([
									'status' => 1,
									'pid' => 'fetchdata',
									'profil' => $profil,
									'message' => 'Profil Mahasiswa berhasil diperoleh.'
								], 200)->setEncodingOptions(JSON_NUMERIC_CHECK);
	
	}
	/**
	 * melakukan pencarian untuk nim
	 */
	public function searchnonampulan(Request $request)
	{
		$this->hasPermissionTo('KEMAHASISWAAN-PROFIL-MHS_SHOW');

		$this->validate($request,[
			'search' => 'required'        
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
							->join('pe3_formulir_pendaftaran AS B', 'A.user_id', 'B.user_id')
							->join('users AS C', 'A.user_id', 'C.id')
							->join('pe3_prodi AS D', 'A.kjur', 'D.id')
							->whereNotIn('A.user_id',function($query) {
								$query->select('user_id')
									->from('pe3_nilai_konversi1');                               
							})
							->where('A.nim', 'LIKE',$request->input('search').'%')
							->orWhere('B.nama_mhs', 'LIKE', '%'.$request->input('search').'%')
							->get();

		return Response()->json([
									'status' => 1,
									'pid' => 'fetchdata',
									'daftar_mhs' => $daftar_mhs,  
									'jumlah' => $daftar_mhs->count(),
									'message' => 'Daftar Mahasiswa berhasil diperoleh.'
								], 200); 
	
	}
	/**
	 * melakukan reset password mahasiswa
	 */
	public function resetpassword(Request $request)
	{
		$this->hasPermissionTo('KEMAHASISWAAN-PROFIL-MHS_UPDATE');

		$this->validate($request,[
			'user_id' => 'required|exists:pe3_register_mahasiswa,user_id'        
		]);
		
		$user=User::find($request->input('user_id'));

		$user->password=Hash::make(12345678);
		$user->save();

		return Response()->json([
								'status' => 1,
								'pid' => 'update',        
								'message' => 'Reset password Mahasiswa '.$user->name.'berhasil diperoleh.'
							], 200);
	}

	public function updatebiodata(Request $request, $id)
	{
		$this->hasPermissionTo('KEMAHASISWAAN-PROFIL-MHS_UPDATE');

		$formulir = FormulirPendaftaranModel::find($id);

		if (is_null($formulir))
		{
			return Response()->json([
									'status'=>0,
									'pid' => 'update',    
									'message' => ["Formulir Pendaftaran dengan ID ($id) gagal diperoleh"]
								], 422); 
		}
		else
		{
		   
			$this->validate($request, [
				'nama_mhs' => 'required',
				'tempat_lahir' => 'required',
				'tanggal_lahir' => 'required',
				'jk' => 'required',
				'nomor_hp' => 'required|unique:users,nomor_hp, '.$formulir->user_id,
				'email' => 'required|string|email|unique:users,email, '.$formulir->user_id,
				'nama_ibu_kandung' => 'required',

				'address1_provinsi_id' => 'required',
				'address1_provinsi' => 'required',
				'address1_kabupaten_id' => 'required',
				'address1_kabupaten' => 'required',
				'address1_kecamatan_id' => 'required',
				'address1_kecamatan' => 'required',
				'address1_desa_id' => 'required',
				'address1_kelurahan' => 'required',
				'alamat_rumah' => 'required',
				'tahun' => 'required|numeric' 
			]);

			$data_mhs = \DB::transaction(function () use ($request, $formulir) {            
				$formulir->nama_mhs=$request->input('nama_mhs');      
				$formulir->tempat_lahir=$request->input('tempat_lahir');      
				$formulir->tanggal_lahir=$request->input('tanggal_lahir');      
				$formulir->jk=$request->input('jk');      
				$formulir->telp_hp=$request->input('nomor_hp');      
				  
				$formulir->nama_ibu_kandung=$request->input('nama_ibu_kandung');    				
				$formulir->address1_provinsi_id = $request->input('address1_provinsi_id');
				$formulir->address1_provinsi=$request->input('address1_provinsi');
				$formulir->address1_kabupaten_id = $request->input('address1_kabupaten_id');
				$formulir->address1_kabupaten=$request->input('address1_kabupaten');
				$formulir->address1_kecamatan_id = $request->input('address1_kecamatan_id');
				$formulir->address1_kecamatan=$request->input('address1_kecamatan');
				$formulir->address1_desa_id = $request->input('address1_desa_id');
				$formulir->address1_kelurahan=$request->input('address1_kelurahan');
				$formulir->alamat_rumah=$request->input('alamat_rumah');    
				$formulir->ta=$request->input('tahun');    				

				$formulir->save();

				$user=$formulir->User;
				$user->name = $request->input('nama_mhs');
				$user->email = $request->input('email');
				$user->nomor_hp = $request->input('nomor_hp');
				$user->ta = $request->input('tahun');
				$user->save();    		           

				\DB::table('pe3_register_mahasiswa')
					->where('user_id', $formulir->user_id)
					->update([
						'tahun' => $request->input('tahun')
					]);

				return [
					'formulir' => $formulir,					
				];
			});
			return Response()->json([
										'status' => 1,
										'pid' => 'update',										
										'message' => 'Biodata Mahasiswa berhasil diubah.'
									], 200)->setEncodingOptions(JSON_NUMERIC_CHECK);
		}
	}
}