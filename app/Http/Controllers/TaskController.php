<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::orderBy('priority', 'asc')->get();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $maxPrioroty = Task::max('priority') ?: 0;

        $newTask = new Task();
        $newTask->name = $request->name;
        $newTask->priority =$maxPrioroty + 1;
        $newTask->save();

        return redirect()->route('tasks.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
      * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);

        return view('tasks.edit', compact('task'));
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
        $task = Task::findOrFail($id);

        $request->validate([
            'name' => 'required',
        ]);

        $task->name = $request->name;
        $task->save();

        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        Task::where('priority', '>', $task->priority)
            ->update(['priority' => \DB::raw('priority - 1')]);

        $task->delete();

        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function apiSetPriority(Request $request)
    {
        $task = Task::findOrFail($request->input('task_id'));
        $prev = Task::find( $request->input('prev_id') );

        if( !$request->input('prev_id') ){
            $destination = 1;
        }else if( !$request->input('next_id') ){
            $destination = Task::count();
        }else{
            $destination = $task->priority < $prev->priority ? $prev->priority : $prev->priority + 1;
        }


        Task::where('priority', '>', $task->priority)
            ->where('priority', '<=', $destination)
            ->update(['priority' => \DB::raw('priority - 1')]);

        Task::where('priority', '<', $task->priority)
            ->where('priority', '>=', $destination)
            ->update(['priority' => \DB::raw('priority + 1')]);

        $task->priority = $destination;
        $task->save();

        return response()->json(true);
    }
}
