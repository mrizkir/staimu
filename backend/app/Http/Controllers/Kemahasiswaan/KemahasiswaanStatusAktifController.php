<?php
namespace App\Http\Controllers\Kemahasiswaan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Akademik\RegisterMahasiswaModel;

class KemahasiswaanStatusAktifController  extends Controller 
{
  /**
   * daftar mahasiswa yang aktif
  */
  public function index(Request $request)
  {
    $this->hasPermissionTo('AKADEMIK-KEMAHASISWAAN-DAFTAR-MAHASISWA_BROWSE');
    
  }
}