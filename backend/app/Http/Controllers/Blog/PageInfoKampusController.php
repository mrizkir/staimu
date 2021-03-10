<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog\BlogPostModel;
use App\Models\System\ConfigurationModel;

class PageInfoKampusController extends Controller {  
    public function index (Request $request)
    {

    }
    public function config (Request $request)
    {
        $setting = ConfigurationModel::getCache();

        $data = [
            'INFO_KAMPUS_TERM_ID'=>$setting['INFO_KAMPUS_TERM_ID']
        ];
        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata',                                
                                    'config'=>$data,
                                    'message'=>'Fetch data konfigurasi Page Info Kampus berhasil diperoleh'
                                ],200);
    }
}