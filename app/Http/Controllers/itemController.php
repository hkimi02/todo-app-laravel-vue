<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\task;
use Illuminate\Support\Carbon;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\updateTaskRequest;

class itemController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks =  task::orderBy('created_at','DESC')->get();
        if(empty($tasks)){
            return response()->json([],404);
        }
        return response()->json($tasks,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {
        // $newTask= new task;
        // $newTask->name=$request->name;
        // $newTask->save();
        $validatedReequest=$request->validated();
        //$validated = $request->safe()->only(['name']);
        $newTask = task::create([
            "name"=>$validatedReequest['name']
        ]);
        if ($newTask == null){
            return response()->json(null,400);
        }
        return response()->json($newTask,201);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(updateTaskRequest $request, $id)
    {
        $excitingItem = task::find($id);
        $validatedRequest=$request->validated();
        if($excitingItem){
            // $excitingItem->done=$request->task['done'] ? true : false;
            // $excitingItem->done_at=$request->task['done'] ? Carbon::now() : null;
            // $excitingItem->save();
            task::whereId($id)->update([
                "done"=>$validatedRequest['done'] ? true : false,
                "done_at"=>$validatedRequest['done'] ? Carbon::now() : null
            ]);
            $excitingItem->save();
            return response()->json($excitingItem,200);
        }
        return response()->json("task not found",404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $excitingItem=task::find( $id );
        if( $excitingItem ){
            $excitingItem->delete();
            return response()->json("task succesfuly deleted",200);
        }
        return response()->json("task not found",404);
    }
}
