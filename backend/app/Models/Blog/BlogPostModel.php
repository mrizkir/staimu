<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class BlogPostModel extends Model {    
     /**
     * nama tabel model ini.
     *
     * @var string
     */
    protected $table = 'blog_post';
    /**
     * primary key tabel ini.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'post_title',
        'post_content',
        'post_excerpt',
        'post_status',
        'comment_status',
        'post_name',
        'post_type',
        'comment_count',
    ];
    /**
     * enable auto_increment.
     *
     * @var string
     */
    public $incrementing = false;
    /**
     * activated timestamps.
     *
     * @var string
     */
    public $timestamps = true;
}