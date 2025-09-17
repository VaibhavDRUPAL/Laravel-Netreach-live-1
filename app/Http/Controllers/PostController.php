<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {

        $this->middleware('permission:view-post');
        $this->middleware('permission:create-post', ['only' => ['create','store']]);
        $this->middleware('permission:update-post', ['only' => ['edit','update']]);
        $this->middleware('permission:destroy-post', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		
        if ($request->has('search')) {
            $posts = Post::with(['user','category'])->where('post_title', 'like', '%'.$request->search.'%')->paginate(setting('record_per_page', 15));
        }else{
            $posts = Post::with(['user','category'])->paginate(setting('record_per_page', 15));
        }
        $title =  'Manage CMS';
        return view('post.index', compact('posts','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create post';
        $categories = Category::pluck('category_name', 'id');
        return view('post.create', compact('categories', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $request->merge(['user_id' => Auth::user()->id]);       
        
		$data["post_title"] = $request->cms_title;
		$data["post_body"] = $request->cms_body;
		$data["category_id"] = $request->category_id;
		$data["user_id"] = Auth::user()->id;
		$data["status"] = $request->status;
		
		
        Post::create($data);
        flash('Post created successfully!')->success();
        return redirect()->route('post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $title = "Post Details";
        $post->with(['category','user']);
        return view('post.show', compact('title', 'post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $title = "Post Details";
        $post->with(['category','user']);
        $categories = Category::pluck('category_name', 'id');
        return view('post.edit', compact('title', 'categories', 'post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        
		$postdata["post_title"] = $request->cms_title;
		$postdata["post_body"] = $request->cms_body;
		$postdata["category_id"] = $request->category_id;
		$postdata["user_id"] = Auth::user()->id;
		$postdata["status"] = $request->status;
	   
        $post->update($postdata);
        flash('Post updated successfully!')->success();
        return redirect()->route('post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        flash('Post deleted successfully!')->info();
        return back();
    }
}
