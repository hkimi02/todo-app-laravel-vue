<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SubTask;
use Illuminate\Http\Request;
use App\Http\Requests\StoresubtaskRequest;
use App\Http\Requests\updatesubtaskRequest;
use App\Models\task;
class subTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $task=task::with('subtasks')->paginate(2);
    if($task){
        return response()->json($task,200);
    }
    else{
        return response()->json("not found",404);
    }
        // $task=task::find($request->id_task);
        // $subTasks=$task->children()->get();
        // return $subTasks;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoresubtaskRequest $request,$task_id)
    {   $validadedRequest=$request->validated();
        $task=task::find($task_id);
        $subTask=$task->subtasks()->save(new SubTask([
            'description'=>$validadedRequest["description"],
            'deadline'=>$validadedRequest["deadline"]
        ]));
        $subTask->save();
        if($subTask==null){
            return response()->json('there has been an error',400);
        }else{
            return response()->json($subTask,201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubTask  $subTask
     * @return \Illuminate\Http\Response
     */
    public function show(SubTask $subTask)
    {
        //
    }
    public function makeDone($id){
            $excitingSubTask=SubTask::find($id);
            if($excitingSubTask){
                $excitingSubTask->update([
                    "status"=>!($excitingSubTask->status),
                ]);
                $excitingSubTask->save();
                return response()->json("status updated succesfully",200);
                }
                return response()->json("subtask not found",404);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubTask  $subTask
     * @return \Illuminate\Http\Response
     */
    public function update(updatesubtaskRequest $request, $id)
    {
            $excitingSubTask=SubTask::find($id);
            $validadedRequest=$request->validated();
            if($excitingSubTask){
            $excitingSubTask->update([
                "description"=>$validadedRequest["description"],
                "deadline"=>$validadedRequest["deadline"]
            ]);
            $excitingSubTask->save();
            return response()->json($excitingSubTask,200);
            }
            return response()->json("subtask not found",404);
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubTask  $subTask
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $excitingSubTask=SubTask::find( $id );
        if( $excitingSubTask ){
            $excitingSubTask->delete();
            return response()->json("subtask succesfuly deleted",200);
        }
        return response()->json("subtask not found",404);
    }
}
