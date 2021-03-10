<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog\BlogPostModel;
use App\Models\System\ConfigurationModel;
use Ramsey\Uuid\Uuid;

class PageInfoKampusController extends Controller {  
    public function index (Request $request)
    {
        $setting = ConfigurationModel::getCache();

        $data = BlogPostModel::select(\DB::raw('
                                    blog_post.id,
                                    blog_post.post_title,
                                    users.username,
                                    blog_post.created_at,
                                    blog_post.updated_at
                                '))
                                ->join('users','users.id','blog_post.user_id')
                                ->orderBy('created_at','desc')
                                ->get();

        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'fetchdata',                                
                                    'post'=>$data,
                                    'message'=>'Fetch data konfigurasi Page Info Kampus berhasil diperoleh'
                                ],200);
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
    public function store(Request $request)
    {
        $this->hasPermissionTo('BLOG-POST_STORE');

        $this->validate($request, [
            'post_title'=>'required',
            'post_content'=>'required',
            'term_id'=>'required',
        ]);
        
        $post = \DB::transaction(function () use ($request) {
            $now = \Carbon\Carbon::now()->toDateTimeString();
            $post_title = $request->input('post_title');
            $post_content = $request->input('post_content');
            $user=BlogPostModel::create([
                'id'=>Uuid::uuid4()->toString(),
                'user_id'=>$this->getUserid(),
                'post_title'=>$post_title,
                'post_content'=>$request->input('post_content'),
                'post_excerpt'=> '',
                'post_status'=>'publish',                        
                'comment_status'=>'closed',
                'post_name'=> str_replace(' ','-',strtolower($post_title)),
                'post_type'=> 'post',
                'comment_count'=> 0                
            ]);

            \DB::table('blog_term_relationship')
                ->insert([
                    'object_id'=>$user->id,
                    'term_taxonomy_id'=>$request->input('term_id'),
                    'term_order'=>0
                ]);
        });
        return Response()->json([
                                    'status'=>1,
                                    'pid'=>'store',                                    
                                    'post'=>$post,                                    
                                    'message'=>'Data matakuliah berhasil disimpan.'
                                ],200);
    }
}