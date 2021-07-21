<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog\BlogPostModel;

class CategoriesController extends Controller {  
    public function index (Request $request)
    {
        $data = \DB::table('blog_term')
                        ->select(\DB::raw('
                            blog_term.id,
                            blog_term.name,
                            blog_term.slug,
                            blog_term.created_at,
                            blog_term.updated_at
                        '))
                        ->join('blog_term_taxonomy','blog_term_taxonomy.term_id','blog_term.id')
                        ->where('blog_term_taxonomy.taxonomy','category')
                        ->get();

        return Response()->json([
                                'status'=>1,
                                'pid'=>'fetchdata',
                                'categories'=>$data,
                                'message'=>'Fetch data categories berhasil diperoleh'
                            ], 200);
    }
}