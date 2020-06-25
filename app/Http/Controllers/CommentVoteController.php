<?php

namespace App\Http\Controllers;

use App\Comment;
use App\CommentVote;
use App\VoteType;
use Illuminate\Http\Request;

class CommentVoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $comment = Comment::find($request->id);
        $comment->vote(auth()->user(), $request);

        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param \App\CommentVote $commentVote
     * @return \Illuminate\Http\Response
     */
    public function show(CommentVote $commentVote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\CommentVote $commentVote
     * @return \Illuminate\Http\Response
     */
    public function edit(CommentVote $commentVote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\CommentVote $commentVote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CommentVote $commentVote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\CommentVote $commentVote
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommentVote $commentVote)
    {
        //
    }
}
