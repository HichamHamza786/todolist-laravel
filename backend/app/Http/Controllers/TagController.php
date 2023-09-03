<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tag = Tag::all();

        return response()->json($tag);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $title = $request->input('title');

        $tag = new Tag();
        $tag->title = $title;

        if ($tag->save()) {
            return response()->json($tag, 201);
        } else {
            return response(null, 500);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        return $tag;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return response(null, 404);
        }

        $title = $request->input('title');
        $tag->title = $title;

        if ($title->save()) {
            return response()->json($tag);
        } else {
            return response(null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tag = Tag::find($id);
        if (!$tag) {
            return response(null, 404);
        }

        if ($tag->delete()) {
            return response(null, 200);
        } else {
            return response(null, 500);
        }
    }
}
