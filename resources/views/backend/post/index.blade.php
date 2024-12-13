@extends('backend.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="container">
        <!-- Display success and error messages -->
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
            <div class="col-sm-6">
                <h1 class="m-0">Posts</h1>
                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>Add</a>
                <!-- Use url()->previous() to go back to the previous page -->
                <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard v1</li>
                </ol>
            </div>
        </div>

        <!-- Table for displaying posts -->
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>S.N.</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody> @php
                $serialNumber = ($posts->currentPage() - 1) * $posts->perPage() + 1;
            @endphp
            
            @foreach ($posts as $post)
                <tr data-widget="expandable-table" aria-expanded="false">
                    <td width="5%">{{ $serialNumber }}</td>
                        <td>{{ $post->title ?? '' }}</td>
                        <td>{{ Str::limit(strip_tags($post->description), 200) }}</td>
                        <td>{{ $post->category->title ?? 'No Category' }}</td>
                        <td>
                            <img src="{{ url('uploads/post/' . $post->image) }}" alt="Post Image" style="max-width: 100px;">
                        </td>
                        <td>
                            <div style="display: flex; flex-direction: row;">
                                <!-- Edit button triggers edit modal -->
                                <button class="btn btn-warning btn-sm" data-toggle="modal"
                                    data-target="#editPostModal{{ $post->id }}" style="margin-right: 5px;">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <!-- Delete button triggers delete modal -->
                                <button class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#deletePostModal{{ $post->id }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    @php
        $serialNumber++;
    @endphp

                    <!-- Edit Post Modal -->
                    <div class="modal fade" id="editPostModal{{ $post->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="editPostModalLabel{{ $post->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <!-- Modal header -->
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editPostModalLabel{{ $post->id }}">Edit </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <!-- Form for editing the post -->
                                    <form id="editPostForm{{ $post->id }}" method="GET"
                                        action="{{ route('admin.posts.edit', $post->id) }}">
                                        @csrf
                                        <!-- Your form fields for editing -->
                                    </form>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary"
                                        form="editPostForm{{ $post->id }}">Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Post Modal -->
                    <div class="modal fade" id="deletePostModal{{ $post->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="deletePostModalLabel{{ $post->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <!-- Modal header -->
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deletePostModalLabel{{ $post->id }}">Delete </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <!-- Content for deleting post goes here -->
                                    Are you sure you want to delete this post?
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <form id="deletePostForm{{ $post->id }}"
                                        action="{{ route('admin.posts.destroy', $post) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
        <!-- Pagination -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        @if ($posts->onFirstPage())
            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $posts->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
            @if ($page == $posts->currentPage())
                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
            @endif
        @endforeach

        @if ($posts->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $posts->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
        @endif
    </ul>
</nav>
  
    </div>
@endsection
