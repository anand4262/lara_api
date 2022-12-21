<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric|digits:10||unique:users',
            'password' => 'required|confirmed',
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

        $user_data = User::create($data);

        return response()->json([
            'success' => true,
            'message' => 'User record has been created',
            'data' => $user_data
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json([
            'success' => true,
            'message' => 'User record has been created',
            'data' => $user
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'first_name' => 'string',
            'last_name' => 'string',
            'role' => 'in:DEFAULT,writer,editor'
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

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'User record has been created',
            'data' => $user
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
