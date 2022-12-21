<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Validator;

class CommentController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $post)
    {
        $data = $request->all();

                $validator = Validator::make($data, [
                    'comment' => 'required',
                ]);

                if($validator->fails()){
                    return response()->json([
                        'success' => false,
                        'message' => 'Bad Request',
                        'data' => [
                            'errors' => $validator->errors()
                        ],
                    ], 400);  
                }
                $post_data = Post::find($post);

                $comment_data = Comment::create([
                    'user_id' => $post_data->user_id,
                    'post_id' => $post_data->id,
                    'comment' => $request->comment
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'comment has been created',
                    'data' => $comment_data
                ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
