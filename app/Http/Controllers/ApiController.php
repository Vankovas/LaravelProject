<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Resources\Post as PostResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

//Use Post from App
use App\Post;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        //Get a certain number of posts 
        $posts = Post::paginate(4);
        //Return collection of posts as a resource
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = $request->isMethod('put') ? Post::findOrFail
        ($request->post_id) : new Post;
        $post->id = $request -> input('post_id');
        $post->title = $request -> input('title');
        $post->body = $request -> input('body');
        $post->user_id = $request -> input('user_id');
        $post->cover_image = $request -> input('cover_image');

        if($post->save()){
            return new PostResource($post);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        //Get post
        $post = Post::findOrFail($id);
        //Return single post as resource
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Get article
        $post = Post::findOrFail($id);
        if($post->delete()){
        return response('Post deleted!', 200);
        }
    }
}
