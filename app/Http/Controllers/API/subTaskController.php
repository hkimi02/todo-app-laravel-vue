<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SubTask;
use Illuminate\Http\Request;
use App\Http\Controllers\itemController;
use App\Models\task;
class subTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($task_id)
    {
        return task::find($task_id)->with('subtasks')->get();
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
    public function store(Request $request,$task_id)
    {
        $task=task::find($task_id);
        $subTask=$task->subtasks()->save(new SubTask([
            'description'=>$request->description,
            'deadline'=>$request->deadline,
        ]));
        $subTask->save();
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubTask  $subTask
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubTask $subTask)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubTask  $subTask
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubTask $subTask)
    {
        //
    }
}
