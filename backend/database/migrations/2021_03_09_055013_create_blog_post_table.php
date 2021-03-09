<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('blog_post', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->text('post_title');
            $table->longText('post_content');
            $table->text('post_excerpt');
            $table->string('post_status',20)->default('published');
            $table->string('comment_status',20)->default('closed');;
            $table->string('post_name');
            $table->string('post_type',20)->default('post'); 
            $table->integer('comment_count');
            $table->timestamps();              
            
            $table->index('user_id');  
            $table->index('post_name');  

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });

        Schema::create('blog_term', function (Blueprint $table) {
            $table->uuid('id')->primary();            
            $table->string('name');
            $table->string('slug');            
            $table->timestamps(); 
            
            $table->index('name');  
            $table->index('slug');  
        });

        Schema::create('blog_term_taxonomy', function (Blueprint $table) {
            $table->uuid('term_taxonomy_id')->primary();            
            $table->uuid('term_id');
            $table->string('taxonomy');            
            $table->uuid('parent');            
            $table->integer('count');
            $table->timestamps();           
            
            $table->index('taxonomy');  
        });

        Schema::create('blog_term_relationship', function (Blueprint $table) {
            $table->uuid('object_id')->primary();            
            $table->uuid('term_taxonomy_id');         
            $table->integer('term_order')->default(0);   
            $table->timestamps();              

            $table->index('term_taxonomy_id');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        Schema::dropIfExists('blog_term_taxonomy');
        Schema::dropIfExists('blog_term');
        Schema::dropIfExists('blog_term_relationship');        
        Schema::dropIfExists('blog_post');
    }
}
