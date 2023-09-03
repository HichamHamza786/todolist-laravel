<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all()->load('categories', 'tags');

        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'category_id' => 'nullable|integer|exists:categories,id',
            'tags' => 'nullable|array'
        ]);

        /*$task = new Task();
        $task->title = $request->get('title');
        $task->save();*/

        $task = Task::create($validated);

        if($request->get('tags')){
            foreach($request->get('tags') as $tag_id){
                $tag = Tag::find($tag_id);
                if($tag){
                    $task->tags()->attach($tag);
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Task created!',
            'task' => $task->load('category', 'tags')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Task::findOrFail($id)->load('categories', 'tags');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response(null, 404);
        }

        $title = $request->input('title');
        $task->title = $title;

        if ($title->save()) {
            return response()->json($task);
        } else {
            return response(null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response(null, 404);
        }

        if ($task->delete()) {
            return response(null, 200);
        } else {
            return response(null, 500);
        }
    }
}
