<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogCategories;

class BlogCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blog_categories = BlogCategories::orderBy('blog_category_name', 'ASC')->get(); 

        return view('blogCategories/allBlogCategories', compact('blog_categories'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blogCategories/createBlogCategories');
    }


   /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $blog_categories = new BlogCategories;

        $request->validate([
            'blog_category_name' => 'required|max:255'
        ]);
 
        $blog_categories->blog_category_name = $request->blog_category_name;
        $blog_categories->status = $request->status??0;
        $blog_categories->save();
        flash('Blog Category added successfully!')->success();
        return redirect(route('blog_categories_all'));
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
        $blog_categories = BlogCategories::find($id);
        return view('blogCategories/editBlogCategories', compact('blog_categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $blog_categories = BlogCategories::find($id);

        $request->validate([
            'blog_category_name' => 'required|max:255'
        ]);
 

        $blog_categories->blog_category_name = $request->blog_category_name;
        $blog_categories->status = $request->status;
        $blog_categories->save();
        flash('Blog Category updated successfully!')->success();
        return redirect(route('blog_categories_all'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog_categories = BlogCategories::find($id);
        if(!is_null($blog_categories)){
            $blog_categories->delete();
        }
        flash('Blog category deleted successfully!')->success();
        return redirect(route('blog_categories_all'));
    }
}
