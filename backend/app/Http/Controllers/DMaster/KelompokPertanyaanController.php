<?php

namespace App\Http\Controllers\DMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DMaster\KelompokPertanyaanModel;

use Ramsey\Uuid\Uuid;

class KelompokPertanyaanController extends Controller
{  
	/**
	 * daftar kelompok pertanyaan
	 */
	public function index(Request $request)
	{
		$data=KelompokPertanyaanModel::orderBy('urutan', 'asc')
			->get();

		return Response()->json([
														'status' => 1,
														'pid' => 'fetchdata',
														'kelompokpertanyaan' => $data,
														'message' => 'Fetch data kelompok pertanyaan berhasil.'
													], 200);
	}
	/**
	 * detail kelompok pertanyaan
	 */
	public function show(Request $request, $id)
	{
			$kelompokpertanyaan=KelompokPertanyaanModel::find($id);

			if (is_null($kelompokpertanyaan))
			{
					return Response()->json([
																	'status'=>0,
																	'pid' => 'fetchdata',
																	'message' => ["Kode Kelompok Pertanyaan ($id) gagal diperoleh"]
															], 422); 
			}
			else
			{
					return Response()->json([
																	'status' => 1,
																	'pid' => 'fetchdata',
																	'kelompokpertanyaan' => $kelompokpertanyaan,
																	'message' => 'Fetch data kelompok pertanyaan berhasil.'
															], 200);
			}        
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this->hasPermissionTo('DMASTER-KUISIONER_STORE');			
		$rule = [            
			'kategori_id' => 'required|numeric',
			'nama_kelompok' => 'required',
			'urutan' => 'required|numeric',					
		];
		
		$this->validate($request, $rule);
					
		$kelompokpertanyaan=KelompokPertanyaanModel::create([
			'id'=>Uuid::uuid4()->toString(),
			'kategori_id' => $request->input('kategori_id'),
			'nama_kelompok' => $request->input('nama_kelompok'),
			'urutan' => $request->input('urutan'),					
		]);                 
		
		\App\Models\System\ActivityLog::log($request,[
			'object' => $kelompokpertanyaan,
			'object_id' => $kelompokpertanyaan->id, 
			'user_id' => $this->getUserid(), 
			'message' => 'Menambah kelompok pertanyaan baru berhasil'
		]);

		return Response()->json([
			'status' => 1,
			'pid' => 'store',
			'kelompokpertanyaan' => $kelompokpertanyaan,
			'message' => 'Data kelompok pertanyaan berhasil disimpan.'
		], 200); 

	}
	/**
	 * digunakan untuk mendapatkan daftar jenjang studi kelompok pertanyaan
	 */
	public function jenjangstudi ()
	{
			$jenjangstudi = JenjangStudiModel::all();
			return Response()->json([
																	'status' => 1,
																	'pid' => 'fetchdata',
																	'jenjangstudi' => $jenjangstudi,
																	'message' => 'Jenjang studi berhasil diperoleh.'
															], 200);
	}					
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$this->hasPermissionTo('DMASTER-KUISIONER_UPDATE');

		$kelompokpertanyaan = KelompokPertanyaanModel::find($id);
		if (is_null($kelompokpertanyaan))
		{
			return Response()->json([
				'status'=>0,
				'pid' => 'update',
				'message' => ["Kode Kelompok Pertanyaan ($id) gagal diupdate"]
			], 422); 
		}
		else
		{
			$this->validate($request, [
				'kategori_id' => [
					'required',
					'numeric'                                                       
				],					
				'nama_kelompok' => [
					'required',					
				],
				'urutan' => [
					'required',
					'numeric',					
				],
			]); 
			
			$kelompokpertanyaan->kategori_id = $request->input('kategori_id');
			$kelompokpertanyaan->nama_kelompok = $request->input('nama_kelompok');
			$kelompokpertanyaan->urutan = $request->input('urutan');       			
			$kelompokpertanyaan->save();
				
			\App\Models\System\ActivityLog::log($request,[
				'object' => $kelompokpertanyaan,
				'object_id' => $kelompokpertanyaan->id, 
				'user_id' => $this->getUserid(), 
				'message' => 'Mengubah data kelompok pertanyaan (' . $kelompokpertanyaan->id. ') berhasil'
			]);

			return Response()->json([
				'status' => 1,
				'pid' => 'update',
				'kelompokpertanyaan' => $kelompokpertanyaan,
				'message' => 'Data kelompok pertanyaan ' . $kelompokpertanyaan->id. ' berhasil diubah.'
			], 200); 
		}
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, $id)
	{ 
			$this->hasPermissionTo('DMASTER-KUISIONER_DESTROY');

			$kelompokpertanyaan = KelompokPertanyaanModel::find($id); 
			
			if (is_null($kelompokpertanyaan))
			{
				return Response()->json([
					'status'=>0,
					'pid' => 'destroy',
					'message' => ["Kode kelompok pertanyaan ($id) gagal dihapus"]
				], 422); 
			}
			else
			{
				\App\Models\System\ActivityLog::log($request,[
					'object' => $kelompokpertanyaan, 
					'object_id' => $kelompokpertanyaan->id, 
					'user_id' => $this->getUserid(), 
					'message' => 'Menghapus Kelompok Pertanyaan (' . $id. ') berhasil'
				]);
				$kelompokpertanyaan->delete();
				return Response()->json([
					'status' => 1,
					'pid' => 'destroy',
					'message' => "Kelompok Pertanyaan dengan kode ($id) berhasil dihapus"
				], 200);    
			}
								
	}
}