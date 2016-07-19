<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Article extends Model
{
    use SoftDeletes;

    protected $guarded = ['submit','tag_list'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
