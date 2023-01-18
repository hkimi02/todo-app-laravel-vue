<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Requests\categoryPostRequest;
use App\Http\Requests\categoryPutRequest;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories =  Categories::orderBy('created_at','DESC')->get();
        if(empty($categories)){
            return response()->json([],404);
        }
        return response()->json($categories,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(categoryPostRequest $request)
    {   $validaatedRequest=$request->validated();
        $newcategorie = Categories::create([
            "name"=>$validaatedRequest['name'],
        ]);
        if ($newcategorie == null){
            return response()->json(null,400);
        }
        return response()->json($newcategorie,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categorie =  Categories::find($id);
        if(empty($categorie)){
            return response()->json('task not found',404);
        }
        return response()->json($categorie,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update(categoryPutRequest $request, $id)
    {
        $validaatedRequest=$request->validated();
        $excitingcategorie=Categories::find($id);
        if($excitingcategorie){
        $excitingcategorie->update([
            'name'=>$validaatedRequest['name'],
        ]);
        $excitingcategorie->save();
        return response()->json('categorie updated succesfully',200);
    }
    return response()->json('not found',404);
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $excitingcategorie=Categories::find( $id );
        if( $excitingcategorie ){
            $excitingcategorie->delete();
            return response()->json("category succesfuly deleted",200);
        }
        return response()->json("category not found",404);
    }
}
