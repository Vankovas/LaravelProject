<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

//Use Post from App
use App\Post;

class PostsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('updated_at', 'asc')->get();
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth::guest()) {
            return redirect('/posts')->with('error', 'You do not have access to this page. You need to be logged in to create a post');
        }
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        //File upload
        if ($request->hasFile('cover_image')) {

            //Get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            $image = $request->file('cover_image');
            $img = \Image::make($image->getRealPath())->resize(300, 300);
            $pixelated_img = \Image::make($image->getRealPath())->resize(300, 300)->pixelate(8);
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            //Upload image
            $location = storage_path('app/public/cover_images/') . $fileNameToStore;
            $pixelated_location = storage_path('app/public/cover_images/') . "pixelated_" . $fileNameToStore;

            //adding picture as a watermark to the image of the post

            $watermark = \Image::make(storage_path('app/public/watermark_images/logowatermark.png'))->resize(150, 45)->save();
            $img = \Image::make($image->getRealPath())->resize(320, 240)->insert($watermark, 'bottom-right', 10, 5)->save($location);
            //adding text as a watermark to the image of the post
            $img->text('www.thehealthyway.com', 105, 285);

            //Save image
            $img->save($location);
            $pixelated_img->save($pixelated_location);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }
        //Create post
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();
        return redirect('/posts')->with('success', 'Post Created');
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        //Check for correct user
        if (Auth::check()) {
            if (auth()->user()->id !== $post->user_id && \auth()->user()->type != "admin")
                return redirect('/posts')->with('error', 'You do not have access to this page.');
        } else
            return redirect('/posts')->with('error', 'You do not have access to this page.');

        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        if ($request->hasFile('cover_image')) {
            //Get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            //Upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }
        //Create post
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if ($request->hasFile('cover_image')) {
            $post->cover_image = $fileNameToStore;
        }
        $post->save();
        return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if (Auth::check()) {
            if (auth()->user()->id !== $post->user_id && \auth()->user()->type != "admin")
                return redirect('/posts')->with('error', 'You do not have access to this page.');
        } else
            return redirect('/posts')->with('error', 'You do not have access to this page.');

        if ($post->cover_image != 'noimage.jpg') {
            //Delete image
            Storage::delete('public/cover_images/' . $post->cover_image);
        }
        $post->delete();
        return redirect('/posts')->with('success', 'Post Removed');
    }
}
