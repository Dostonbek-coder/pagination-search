<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index(Request $request)
    {
        $searchTerm = $request->get('query', '');
        if ($searchTerm) {
        $posts = Post::where('title', 'like', "%$searchTerm%")->orWhere('body', 'like', "%$searchTerm%")->paginate(20);
        } else {
        $posts = Post::paginate(10);
        }
        return response()->json([
            'status' => 200,
            'data' => $posts
        ]);
    }    
    
    /** 
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request)
    {
        $post = Post::create($request->only('title', 'content'));
        return response()->json([
            'status' => 201,
            'data' => $post
        ], 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post topilmadi'], 404);
        }
        return response()->json([
            'status' => 200,
            'data' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post topilmadi'], 404);
        }
    
        $post->update($request->only('title', 'body'));
    
        return response()->json([
            'status' => 200,
            'data' => $post
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post topilmadi'], 404);
        }
        $post->delete();
        return response()->json(['message' => 'Post ochirildi'], 200);
    }
}
