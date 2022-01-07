<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($post)
    {
        $post = Post::find($post);

        if($post){
            return response()->json([
                'status'    => 'success',
                'data' => $post->comments
            ]);
        }

        return response()->json([
            'error_code'=> '404',
            'message'   => 'Failed to find requested post.',
            'status'    => 'error'
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request, $post)
    {
        $post = Post::find($post);

        if($post){
            if (isset($request->validator) && $request->validator->fails()) {
                return response()->json([
                    'status'=> 'error',
                    'message'   => 'The given data was invalid.',
                    'errors'    => $request->validator->errors()
                ]);
            }

            $comment = $post->comments()->create($request->all());

            return response()->json([
                'status'    => 'success',
                'data' => $comment
            ]);
        }

        return response()->json([
            'error_code'=> '404',
            'message'   => 'Failed to find requested post.',
            'status'    => 'error'
        ]);
    }

    /**
     * Display a specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($post, $comment)
    {
        $post = Post::find($post);

        if($post){
            $comment = Comment::find($comment);
            return response()->json([
                'status'    => 'success',
                'data' => $comment
            ]);
        }

        return response()->json([
            'error_code'=> '404',
            'message'   => 'Failed to find requested post.',
            'status'    => 'error'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $post \App\Model\Post
     * @param  int  $comment \App\Model\Comment
     * @return \Illuminate\Http\Response
     */
    public function update(CommentRequest $request, $post, $comment)
    {
        $post = Post::find($post);
        $comment = Comment::find($comment);

        if($post){
            if (isset($request->validator) && $request->validator->fails()) {
                return response()->json([
                    'status'=> 'error',
                    'message'   => 'The given data was invalid.',
                    'errors'    => $request->validator->errors()
                ]);
            }

            $comment->update($request->all());

            return response()->json([
                'status'    => 'success',
                'data' => $comment
            ]);
        }

        return response()->json([
                    'error_code'=> '404',
                    'message'   => 'Failed to find requested comment.',
                    'status'    => 'error'
                ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $post \App\Model\Post
     * @param  int  $comment \App\Model\Comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($post, $comment)
    {
        $post = Post::find($post);
        $comment = Comment::find($comment);

        if($post){
            $comment->delete();

            return response()->json([
                'status'    => 'success',
                'data' => $comment
            ]);
        }

        return response()->json([
                    'error_code'=> '404',
                    'message'   => 'Failed to find requested comment.',
                    'status'    => 'error'
                ]);
    }


}
