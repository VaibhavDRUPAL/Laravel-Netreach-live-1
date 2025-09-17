<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\User;
use App\Models\BlogCategories;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::with('blogCategories')->orderBy('blog_id', 'DESC')->paginate(10);

        return view('blogs/allBlogs', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $blog_categories = BlogCategories::pluck('blog_category_name', 'blog_category_id');
        return view('blogs/createBlog', compact('blog_categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $blog = new Blog;

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'blog_category_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'tags' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required',
            'author_name' => 'required',
            'author_details' => 'required'
        ]);

        $fileName = time() . '.' . $request->image->extension();
        $request->image->storeAs('blog', $fileName);

        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->blog_category_id = $request->blog_category_id;
        $blog->image = $fileName;
        $blog->youtube_video_embed = $request->youtube_video_embed??"";
        $blog->tags = $request->tags;
        $blog->meta_title = $request->meta_title;
        $blog->meta_description = $request->meta_description;
        $blog->meta_keywords = $request->meta_keywords;
        $blog->author_name = $request->author_name;
        $blog->author_details = $request->author_details;
        $blog->facebook = $request->facebook;
        $blog->whatsapp = $request->whatsapp;
        $blog->instagram = $request->instagram;
        $blog->status = $request->status??0;
        $user->blogs()->save($blog);
        flash('Blog added successfully!')->success();
        return redirect(route('blogs_all'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::find($id);
        $blog_categories = BlogCategories::pluck('blog_category_name', 'blog_category_id');
        return view('blogs/editBlog', compact('blog','blog_categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $blog = Blog::find($id);

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'blog_category_id' => 'required',
            'tags' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required',
            'author_name' => 'required',
            'author_details' => 'required'
        ]);
        if ($request->image) {
            $fileName = time() . '.' . $request->image->extension();
            $request->image->storeAs('blog', $fileName);
            $blog->image = $fileName;
        }

        $blog->title = $request->title;
        $blog->blog_category_id = $request->blog_category_id;
        $blog->description = $request->description;
        $blog->youtube_video_embed = $request->youtube_video_embed??"";
        $blog->tags = $request->tags;
        $blog->meta_title = $request->meta_title;
        $blog->meta_description = $request->meta_description;
        $blog->meta_keywords = $request->meta_keywords;
        $blog->author_name = $request->author_name;
        $blog->author_details = $request->author_details;
        $blog->facebook = $request->facebook;
        $blog->whatsapp = $request->whatsapp;
        $blog->instagram = $request->instagram;
        $blog->status = $request->status;
        $blog->save();
        flash('Blog updated successfully!')->success();
        return redirect(route('blogs_all'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::find($id);
        if (!is_null($blog)) {
            $blog->delete();
        }
        flash('Blog deleted successfully!')->success();
        return redirect(route('blogs_all'));
    }
}
