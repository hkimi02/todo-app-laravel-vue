<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CategoriesTask;
use Illuminate\Http\Request;

class CategoriesTaskController extends Controller
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
    public function store(Request $request)
    {
        $newcategorytask=CategoriesTask::create([
                "task_id"=>$request->task_id,
                "categories_id"=>$request->category_id,
            ]);
        if($newcategorytask==null){
            return response()->json('there has been a problem',400);
        }
        return response()->json('category added ', 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CategoriesTask  $categoriesTask
     * @return \Illuminate\Http\Response
     */
    public function show(CategoriesTask $categoriesTask)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CategoriesTask  $categoriesTask
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CategoriesTask $categoriesTask)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategoriesTask  $categoriesTask
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $excitingItem=CategoriesTask::where('categories_id','=', $request->id)->where('task_id', '=' , $request->id_task);
        if( $excitingItem ){
            $excitingItem->delete();
            return response()->json("category unsaved",200);
        }
        return response()->json("not found",404);
    }
}
