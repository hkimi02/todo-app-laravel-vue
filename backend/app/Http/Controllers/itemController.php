<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\task;
use Illuminate\Support\Carbon;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\updateTaskRequest;
use App\Models\CategoriesTask;
use Nette\Utils\Json;

class itemController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
        $validatedReequest=$request->validated();
        $newTask = task::create([
            "name"=>$validatedReequest['name'],
            "duedate"=>$validatedReequest['duedate'],
            "user_id"=>auth()->user()->id
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
    public function gettaskbyid($id)
    {
        $task=task::where('id','=',$id)->with('category')->get();
        if($task){
            return response()->json($task,200);
        }
        return response()->json([],404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $excitingItem = task::find($id);
        if($excitingItem){
            $excitingItem->update([
            "name"=>$request->name,
            "duedate"=>$request->duedate,
        ]);
        $excitingItem->save();
        return response()->json($excitingItem,200);
    }
    return response()->json("task not found",404);
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
                "done"=>$validatedRequest['done'],
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
        $excitingItem=task::find($id);
        if( $excitingItem ){
            $excitingItem::with('subtasks')->delete();
            $excitingItem->delete();
            return response()->json("task succesfuly deleted",200);
        }
        return response()->json("task not found",404);
    }
    public function searchByName(Request $request){
        $searchName=$request->search;
        $tasks=task::where('name',"LIKE","%". $searchName ."%")->with('subtasks','category')->paginate(3);
        return response()->Json($tasks,200);
    }
}
// php artisan make:controller API/TestController --api --model=Test
// # then
// php artisan make:migration create_tests_table
