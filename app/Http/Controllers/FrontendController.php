<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class FrontendController extends Controller
{
    public function index() : View 
    {
        return view('frontend.index',['posts'=>Post::all()]);
    }
    public function post($slug) 
    {
        $post =Post::where(['slug'=>$slug,'status'=> 'published'])->first();
        if (isset($post)) {
            $related = Post::whereHas('tags', function ($q) use ($post) {
                return $q->whereIn('title', $post->tags->pluck('title')); 
            })
            ->where('id', '!=', $post->id) // So you won't fetch same post
            ->get();
            return response()->view('frontend.post',['post'=>$post,'categories'=>Category::all(),'related'=>$related]);
        }
        return abort(404);
        
    }
    public function category($slug) 
    {
        $category = Category::where('slug',$slug)->first();
        $posts = $category->posts()->where('status','published')->get();
        return view('frontend.category',['posts'=>$posts,'category'=>$category]);
    }
    public function search(Request $request) : View {
        $search = $request->input('search');
        $posts = Post::query()
            ->where('title','LIKE',"%{$search}%")
            ->orwhere('context','LIKE',"%{$search}%")
            ->get();
        return view('frontend.search',['posts'=>$posts,'search'=>$search]);
    }
    public function contact() : View {
        return view('frontend.contact');
    }
    public function about() : View {
        return view('frontend.about');
    }
}
