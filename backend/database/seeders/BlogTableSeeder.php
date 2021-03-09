<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

use Ramsey\Uuid\Uuid;

class BlogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('DELETE FROM blog_term_taxonomy');
        \DB::statement('DELETE FROM blog_term');
        $term_id=Uuid::uuid4()->toString();
        \DB::table('blog_term')->insert([
            'id'=>$term_id,
            'name'=>'Info Kampus',            
            'slug'=>'info-kampus',            
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        
        \DB::table('blog_term_taxonomy')->insert([
            'term_taxonomy_id'=>Uuid::uuid4()->toString(),
            'term_id'=>$term_id,            
            'taxonomy'=>'category',            
            'parent'=>0,            
            'count'=>0,            
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
    }
}
