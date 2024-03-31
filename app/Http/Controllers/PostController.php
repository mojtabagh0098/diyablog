<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        return view("dashboard.posts.index",['posts'=> Post::all()->sortByDesc("created_at")]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view("dashboard.posts.new", ["categories"=>Category::all(),"tags"=>Tag::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $validate_data = $request->validated();

        $post = auth()->user()->post()->create([
            'title' => $validate_data['title'],
            'context' => $validate_data['context'],
            'status' => $validate_data['status'],
            'media_id' => $validate_data['media_id']
        ]);

        $post->categories()->attach($validate_data['categories']);
        $post->tags()->attach($validate_data['tags'] ?? null);
        return redirect('/posts');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post): View
    {
        if (Gate::denies('update-post', $post)){

           abort(403);

       };
        return view("dashboard.posts.edit", ["post"=>$post,"categories"=>Category::all(),"tags"=>Tag::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $validate_data = $request->validated();
        $post->update($validate_data);
        $post->categories()->sync($validate_data['categories']);
        $post->tags()->sync($validate_data['tags'] ?? null);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return back();
    }
}
