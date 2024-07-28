<?php

namespace App\Http\Controllers\Kepegawaian;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDosen;
use Spatie\Permission\Models\Role;
use Ramsey\Uuid\Uuid;
use Illuminate\Validation\Rule;

class KepegawaianController extends Controller {
	public function index(Request $request)
	{           
		$this->hasPermissionTo('KEPEGAWAIAN-GROUP');		
		
		$subquery = \DB::table('pe3_dosen')
			->select(\DB::raw('
				id_jabatan,
				COUNT(user_id) AS jumlah_dosen
			'))
			->groupBy('id_jabatan');			
		$statistik_dosen = \DB::table('pe3_jabatan_akademik')
			->select(\DB::raw('
				pe3_jabatan_akademik.id_jabatan,
				pe3_jabatan_akademik.nama_jabatan,
				COALESCE(jumlah_dosen,0) AS jumlah_dosen
			'))
			->leftJoinSub($subquery, 'pe3_dosen', function($join) {
				$join->on('pe3_dosen.id_jabatan', '=', 'pe3_jabatan_akademik.id_jabatan');
			})
			->orderBy('pe3_jabatan_akademik.id_jabatan', 'ASC')
			->get();
		
		return Response()->json([
			'status' => 1,
			'pid' => 'fetchdata',
			'statistik_dosen' => $statistik_dosen,
			'total_dosen' => $statistik_dosen->sum('jumlah_dosen'),
			'message' => 'Fetch data kepegawaian berhasil diperoleh',
		], 200);
	}
}