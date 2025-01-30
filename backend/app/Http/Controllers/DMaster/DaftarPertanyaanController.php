<?php

namespace App\Http\Controllers\DMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DMaster\DaftarPertanyaanModel;

use Ramsey\Uuid\Uuid;

class DaftarPertanyaanController extends Controller
{  
	/**
	 * daftar kelompok pertanyaan
	 */
	public function index(Request $request)
	{
		$data=DaftarPertanyaanModel::orderBy('urutan', 'asc')
			->get();

		return Response()->json([
      'status' => 1,
      'pid' => 'fetchdata',
      'daftarpertanyaan' => $data,
      'message' => 'Fetch data kelompok pertanyaan berhasil.'
    ], 200);
	}
	/**
	 * detail kelompok pertanyaan
	 */
	public function show(Request $request, $id)
	{
    $daftarpertanyaan=DaftarPertanyaanModel::find($id);

    if (is_null($daftarpertanyaan))
    {
      return Response()->json([
        'status'=>0,
        'pid' => 'fetchdata',
        'message' => ["Kode Daftar Pertanyaan ($id) gagal diperoleh"]
      ], 422); 
    }
    else
    {
      return Response()->json([
        'status' => 1,
        'pid' => 'fetchdata',
        'kelompokpertanyaan' => $daftarpertanyaan,
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
					
		$daftarpertanyaan=DaftarPertanyaanModel::create([
			'id'=>Uuid::uuid4()->toString(),
			'kategori_id' => $request->input('kategori_id'),
			'nama_kelompok' => $request->input('nama_kelompok'),
			'urutan' => $request->input('urutan'),					
		]);                 
		
		\App\Models\System\ActivityLog::log($request,[
			'object' => $daftarpertanyaan,
			'object_id' => $daftarpertanyaan->id, 
			'user_id' => $this->getUserid(), 
			'message' => 'Menambah kelompok pertanyaan baru berhasil'
		]);

		return Response()->json([
			'status' => 1,
			'pid' => 'store',
			'kelompokpertanyaan' => $daftarpertanyaan,
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

		$daftarpertanyaan = DaftarPertanyaanModel::find($id);
		if (is_null($daftarpertanyaan))
		{
			return Response()->json([
				'status'=>0,
				'pid' => 'update',
				'message' => ["Kode Daftar Pertanyaan ($id) gagal diupdate"]
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
			
			$daftarpertanyaan->kategori_id = $request->input('kategori_id');
			$daftarpertanyaan->nama_kelompok = $request->input('nama_kelompok');
			$daftarpertanyaan->urutan = $request->input('urutan');       			
			$daftarpertanyaan->save();
				
			\App\Models\System\ActivityLog::log($request,[
				'object' => $daftarpertanyaan,
				'object_id' => $daftarpertanyaan->id, 
				'user_id' => $this->getUserid(), 
				'message' => 'Mengubah data kelompok pertanyaan (' . $daftarpertanyaan->id. ') berhasil'
			]);

			return Response()->json([
				'status' => 1,
				'pid' => 'update',
				'kelompokpertanyaan' => $daftarpertanyaan,
				'message' => 'Data kelompok pertanyaan ' . $daftarpertanyaan->id. ' berhasil diubah.'
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

			$daftarpertanyaan = DaftarPertanyaanModel::find($id); 
			
			if (is_null($daftarpertanyaan))
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
					'object' => $daftarpertanyaan, 
					'object_id' => $daftarpertanyaan->id, 
					'user_id' => $this->getUserid(), 
					'message' => 'Menghapus Daftar Pertanyaan (' . $id. ') berhasil'
				]);
				$daftarpertanyaan->delete();
				return Response()->json([
					'status' => 1,
					'pid' => 'destroy',
					'message' => "Daftar Pertanyaan dengan kode ($id) berhasil dihapus"
				], 200);    
			}
								
	}
}