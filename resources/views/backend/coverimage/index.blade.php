@extends('backend.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
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
            <a href="{{ route('admin.cover-images.create') }}"><button class="btn btn-primary btn-sm"><i
                        class="fa fa-plus"></i>Add</button></a>
            <a href="{{ url('admin') }}"><button class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i>
                    Back</button></a>
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
                <th>S.N.</th>
                <th>Title</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $serialNumber = ($coverimages->currentPage() - 1) * $coverimages->perPage() + 1;
            @endphp
            @foreach ($coverimages as $coverimage)
                <tr data-widget="expandable-table" aria-expanded="false">
                    <td width="5%">{{ $serialNumber }}</td>
                    <td>{{ $coverimage->title ?? '' }}</td>
                    <td> <img id="preview{{ $loop->iteration }}"
                            src="{{ asset('uploads/coverimage/' . $coverimage->image) }}"
                            style="width: 150px; height:150px" /></td>
                    <td>
                        <div style="display: flex; flex-direction:row;">
                            <!-- Edit button triggers edit modal -->
                            <button class="btn btn-warning btn-sm" data-toggle="modal"
                                data-target="#editCoverImageModal{{ $coverimage->id }}" style="margin-right: 5px;">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <!-- Delete button triggers delete modal -->
                            <button class="btn btn-danger btn-sm" data-toggle="modal"
                                data-target="#deleteCoverImageModal{{ $coverimage->id }}">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </td>
                </tr>
                @php
        $serialNumber++;
    @endphp

                <!-- Edit Cover Image Modal -->
                <div class="modal fade" id="editCoverImageModal{{ $coverimage->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="editCoverImageModalLabel{{ $coverimage->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <!-- Modal header -->
                            <div class="modal-header">
                                <h5 class="modal-title" id="editCoverImageModalLabel{{ $coverimage->id }}">Edit 
                                    Image</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <!-- Form for editing the cover image -->
                                <form id="editCoverImageForm{{ $coverimage->id }}"
                                    action="{{ route('admin.cover-images.edit', $coverimage->id) }}" method="GET">
                                    @csrf
                                    <!-- Your form fields for editing -->
                                </form>
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary"
                                    form="editCoverImageForm{{ $coverimage->id }}">Edit</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Cover Image Modal -->
                <div class="modal fade" id="deleteCoverImageModal{{ $coverimage->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="deleteCoverImageModalLabel{{ $coverimage->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <!-- Modal header -->
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteCoverImageModalLabel{{ $coverimage->id }}">Delete Cover
                                    Image</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <!-- Content for deleting cover image goes here -->
                                Are you sure you want to delete this cover image?
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <form id="deleteCoverImageForm{{ $coverimage->id }}"
                                    action="{{ route('admin.cover-images.destroy', $coverimage->id) }}" method="POST">
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
            @if ($coverimages->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $coverimages->previousPageUrl() }}" rel="prev">&laquo;</a></li>
            @endif

            @foreach ($coverimages->getUrlRange(1, $coverimages->lastPage()) as $page => $url)
                @if ($page == $coverimages->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach

            @if ($coverimages->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $coverimages->nextPageUrl() }}" rel="next">&raquo;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
            @endif
        </ul>
    </nav>
    <script>
        const previewImage1 = e => {
            const reader = new FileReader();
            reader.readAsDataURL(e.target.files[0]);
            reader.onload = () => {
                const preview = document.getElementById('preview1');
                preview.src = reader.result;
            };
        };
    </script>
    
@endsection
