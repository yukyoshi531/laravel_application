<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('posts.index',['posts'=>$posts]);
    }
    public function create()
    {
        dd('投稿画面だよ！！');
    }
    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = Auth::id();

        $post->save();
    
        return redirect()->route('post.index');
    }
    public function show($id)
    {
    
        $post = Post::findOrFail($id);

        return view('posts.show', ['post' => $post]);

    }
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== Auth::id()){
            return redirect('/');
        }
        dd('編集しようとした投稿データの情報');
    }
    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        
        if ($post->user_id !== Auth::id()){
            return redirect('/');
        }
    
        $post->title = $request->title;
        $post->body = $request->body;

        $post->save();

        return redirect('/');
    }
    public function delete($id)
    {
    
        $post = Post::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            return redirect('/');
        }

        $post->delete(); 

        return redirect('/');
    }



}
