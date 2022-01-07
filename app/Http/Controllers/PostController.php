<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return response($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json([
                'status'=> 'error',
                'message'   => 'The given data was invalid.',
                'errors'    => $request->validator->errors()
            ]);
        }

        return Post::create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        if($post){
            return response()->json([
                'status'    => 'success',
                'data' => $post
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::find($id);
        if($post){
            if (isset($request->validator) && $request->validator->fails()) {
                return response()->json([
                    'status'=> 'error',
                    'message'   => 'The given data was invalid.',
                    'errors'    => $request->validator->errors()
                ]);
            }

            $post->update($request->all());

            return response()->json([
                'status'    => 'success',
                'data' => $post
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function upvote($id)
    {
        $post = Post::find($id);
        if($post){
            $post->upvotes++;
            $post->save();

            return response()->json([
                'status'    => 'success',
                'data' => $post
            ]);
        }

        return response()->json([
                    'error_code'=> '404',
                    'message'   => 'Failed to find requested post.',
                    'status'    => 'error'
                ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if($post){
            $post->delete();

            return response()->json([
                'status'    => 'success',
                'data' => $post
            ]);
        }

        return response()->json([
                    'error_code'=> '404',
                    'message'   => 'Failed to find requested post.',
                    'status'    => 'error'
                ]);
    }
}
