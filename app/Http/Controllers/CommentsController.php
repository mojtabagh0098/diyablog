<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\CommentRequest;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Comments $comments) : View
    {
        return view('dashboard.comments.index',['comments'=>$comments->all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request, Comments $comments)
    {
        $validate_data = $request->validated();

        $post = $comments->create([
            'content' => $validate_data['content'],
            'status'  => 'approved',
            'user_id' => $request->user()->id,
            'post_id' => $validate_data['post_id']
        ]);
        return response()->json(['status'=>'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comments $comments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comments $comments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, Comments $comments, $id)
    {
        $validate_data = $request->validated();
        $comment = $comments->find($id);
        $comment->status = $validate_data['status'];
        $comment->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comments $comments)
    {
        $comments->delete();
        return back();
    }
}
