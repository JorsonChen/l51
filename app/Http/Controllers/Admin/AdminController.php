<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $article_count = Article::count();
        $category_count = Category::count();
        $tag_count = Tag::count();
        $user_count = User::count();
        return view('admin.console',compact('article_count','category_count','tag_count','user_count'));
    }

}
