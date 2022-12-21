<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = User::findorFail($id);
        if($user->role === 'writer'){
            $post_data = Post::where('user_id', $id)->with('comments')->get();
                    return response()->json([
                        'success' => true,
                        'message' => 'data fetched',
                        'data' => $post_data
                    ], 200);
        }
        else if($user->role === 'editor'){
            $post_data = Post::with('comments')->get();
                    return response()->json([
                        'success' => true,
                        'message' => 'data fetched',
                        'data' => $post_data
                    ], 200);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Bad Request',
                'data' => [
                    'errors' => "not authorized"
                ],
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        if($user->role === 'writer')
        {
            $data = $request->all();

            $validator = Validator::make($data, [
                'title' => 'required',
                'post' => 'required',
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

            $post_data = Post::create([
                'user_id' => $user->id,
                'title' => $request->title,
                'post' => $request->post
            ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Post record has been created',
                    'data' => $post_data
                ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Bad Request',
                'data' => [
                    'errors' => "Insufficient role"
                ],
            ], 400); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id, $post)
    {
 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, $post)
    {
        $user = User::findorFail($id);
        if($user->role === 'writer')
        {
            $post_count = Post::where('id', $post)->where('user_id', $id)->get()->count();
            if($post_count)
            {
                $data = $request->all();

                $validator = Validator::make($data, [
                    'title' => 'required',
                    'post' => 'required',
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
                Post::where('id', $post)->where('user_id', $id)->update([
                    'title' => $request->title,
                    'post' => $request->post 
                ]);
                $post_data = Post::where('id', $post)->where('user_id', $id)->get();
                    return response()->json([
                        'success' => true,
                        'message' => 'post has been updated',
                        'data' => $post_data
                    ], 200);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Bad Request',
                    'data' => [
                        'errors' => "not authorized"
                    ],
                ], 400);
            }
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Bad Request',
                'data' => [
                    'errors' => "Insufficient role"
                ],
            ], 400); 
        }
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $post)
    {
        $user = User::findorFail($id);
        if($user->role === 'writer')
        {
            $post_count = Post::where('id', $post)->where('user_id', $id)->get()->count();
            if($post_count)
            {
                Post::where('id', $post)->where('user_id', $id)->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'record deleted',
                ], 200);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Bad Request',
                    'data' => [
                        'errors' => "not authorized"
                    ],
                ], 400);
            }
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Bad Request',
                'data' => [
                    'errors' => "Insufficient role"
                ],
            ], 400);
        }
    }
}
