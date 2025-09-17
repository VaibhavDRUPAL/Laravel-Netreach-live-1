@extends('layouts.app')
@push('pg_btn') 
@endpush
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-header bg-transparent">
                <div class="row">
                    <div class="col-lg-8">
                        <h3 class="mb-0">All Blogs</h3>
                    </div>
                    <div class="col-lg-4">
                         <a href="{{route('blog_create')}}" class="btn btn-primary float-right"><i class="fa fa-plus"></i> Add Blog</a>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <div>
                        <table class="table table-hover align-items-center">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Image</th> 
                                    <th scope="col">Title</th> 
                                    <th scope="col">Category</th> 
                                    <th scope="col">Date</th>
                                    <th scope="col">Status</th> 
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @if ($blogs)
                                    @foreach($blogs as $blog)
                                    <tr>
                                        <th>
                                            <img src="{{ asset('storage/blog/'.$blog->image) }}"  height="80" width="120">
                                        </th>
                                        <th>
                                            {{$blog->title}}
                                        </th>
                                        <th> 
                                            @if ($blog->blogCategories->deleted_at)
                                            @else
                                                {{ $blog->blogCategories->blog_category_name }}
                                            @endif
                                            
                                        </th>
                                        <td>
                                            {{ parseDateTime($blog->created_at,'M d, Y') }}
                                        </td>
                                        <td>
                                            @if($blog->status)
                                            <span class="badge badge-pill badge-lg badge-primary">Active</span>
                                            @else
                                            <span class="badge badge-pill badge-lg badge-danger">Disabled</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{route('blog_edit',$blog->blog_id)}}" class="px-1 edit-greeting">
                                                <i class="fas text-primary fa-edit"></i>
                                            </a>
                                            <a href="{{route('blog_destroy',$blog->blog_id)}}" class="px-1">
                                                <i class="fas text-danger fa-trash delete-greeting"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            {{$blogs->links("pagination::bootstrap-4")}}
                                        </td>
                                    </tr>
                                @else  
                                    <td colspan="4" class="text-center">
                                        No Data Found
                                    </td>
                                @endif
                                
                            </tbody>
                             
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection