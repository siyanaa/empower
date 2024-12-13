@extends('backend.layouts.master')

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
    @endif

    <div class="row mb-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $page_title }}</h1>
                <a href="{{ route('admin.blog-posts-categories.create') }}">
                    <button class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> Add
                    </button>
                </a>
                <a href="http://127.0.0.1:8000/admin/blog-posts-categories">
                    <!-- Replace 'admin' with the actual URL you want to redirect to -->
                    <button class="btn btn-primary btn-sm">
                        <i class="fa fa-arrow-left"></i> Back
                    </button>
                </a>

            </div>
        </div>

        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
        </div>
    </div>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>S.N</th>
                <th>Title</th>
                <th>Image</th>
                <th>Content</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr data-widget="expandable-table" aria-expanded="false">
                    <td width="5%">{{ $loop->iteration }}</td>
                    <td>{{ $category->title }}</td>
                    <td> <img id="preview{{ $loop->iteration }}"
                            src="{{ asset('uploads/blogpostcategory/' . $category->image) }}"
                            style="width: 150px; height:150px" /></td>
                            <td>{{ Str::limit(strip_tags($summernoteContent->processContent($category->content)), 200) }}</td>

                    <td>
                        <!-- Edit Button with Modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#editModal{{ $category->id }}">Edit</button>

                        <!-- Delete Button with Modal -->
                        <button type="button" class="btn btn-danger" data-toggle="modal"
                            data-target="#deleteModal{{ $category->id }}">Delete</button>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="editModalLabel{{ $category->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel{{ $category->id }}">Edit Blog Post
                                            Category</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Form for editing the category -->
                                        <form action="{{ route('admin.blog-posts-categories.edit', $category->id) }}"
                                            method="POST">
                                            @csrf
                                            <!-- Your form fields for editing -->
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <form id="editForm{{ $category->id }}" method="GET"
                                            action="{{ route('admin.blog-posts-categories.edit', $category->id) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Edit</button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="deleteModalLabel{{ $category->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{ $category->id }}">Delete Blog
                                            Post Category</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this category?
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('admin.blog-posts-categories.destroy', $category->id) }}"
                                            method="POST" id="deleteForm{{ $category->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
@endsection
