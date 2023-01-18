<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\userRegisterRequest;
class UserController extends Controller
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
    public function login(Request $request){
        $infos=[
            'email'=>$request->email,
            'password'=>$request->password,
        ];
        if(Auth::attempt($infos)){
            $isAuth=true;
            $user='user loaged in succesfully';
            return response()->json(['isAuth'=>true,'message'=>'user loaged in succesfully','user'=>auth()->user()],200);
        }
        return response()->json(['isAuth'=>false,'message'=>'unautharised'],404);
    }
    public function store(userRegisterRequest $request)
    {
        $validatedRequest=$request->validated();
        $newUser=User::create([
            'name'=>$validatedRequest['name'],
            'email'=>$validatedRequest['email'],
            'password'=>Hash::make($validatedRequest['password'])
        ]);
        $newUser->save();
        if($newUser){
            return response()->json('user created succesfully', 201);
        }
        return response()->json('user not created', 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
