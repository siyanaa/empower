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
                <h1 class="m-0">{{ $page_title }}</h1>
                <a href="{{ route('admin.photo-galleries.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                    Add </a>
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

        <!-- Table for displaying photo galleries -->
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>S.N.</th>
                    <th>Title</th>
                    <th>Image Description</th>
                    <th>Images</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $perPage = $gallery->perPage(); // the number of results per page
                    $currentPage = $gallery->currentPage(); // current page number
                    $serialNumber = ($currentPage - 1) * $perPage + 1; // calculate the starting serial number for the current page
                @endphp
                @foreach ($gallery as $image)
                    <tr>
                        <td>{{ $serialNumber++ }}</td>
                        <td>{{ $image->title }}</td>
                        <td>{{ $image->img_desc ?? '' }}</td>
                        <td>
                            @if (is_array($image->img))
                                <div class="album-container">
                                    @foreach ($image->img as $index => $imagePath)
                                        <img class="album-image"
                                            id="preview{{ $loop->parent->iteration }}{{ $index }}"
                                            src="{{ asset($imagePath) }}"
                                            style="width: 100px; height:100px; margin-right: 5px;" />
                 @endforeach
                                </div>
                            @else
                                <img id="preview{{ $loop->iteration }}" src="{{ asset($image->img) }}"
                                    style="width: 150px; height:150px" />
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; flex-direction:row;">
                                <!-- Edit button triggers edit modal -->
                                <button class="btn btn-warning btn-sm" data-toggle="modal"
                                    data-target="#editModal{{ $image->id }}" style="margin-right: 5px;"><i
                                        class="fas fa-edit"></i> Edit</button>
                                <!-- Delete button triggers delete modal -->
                                <button class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#deleteModal{{ $image->id }}"><i class="fas fa-trash"></i>
                                    Delete</button>
                            </div>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal{{ $image->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="editModalLabel{{ $image->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <!-- Modal header -->
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel{{ $image->id }}">Edit Photo Gallery</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <p>Are you sure you want to edit this photo gallery?</p>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <a href="{{ route('admin.photo-galleries.edit', $image->id) }}"
                                        class="btn btn-primary">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal{{ $image->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="deleteModalLabel{{ $image->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $image->id }}">Delete Photo Gallery
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete this photo gallery?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <form id="deleteForm{{ $image->id }}"
                                        action="{{ route('admin.photo-galleries.destroy', $image->id) }}" method="POST">
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
        @if ($gallery->onFirstPage())
            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $gallery->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        @foreach ($gallery->getUrlRange(1, $gallery->lastPage()) as $page => $url)
            @if ($page == $gallery->currentPage())
                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
            @endif
        @endforeach

        @if ($gallery->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $gallery->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
        @endif
    </ul>
</nav>

    </div>
@endsection
