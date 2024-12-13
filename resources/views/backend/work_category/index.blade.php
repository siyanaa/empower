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
            <a href="{{ route('admin.work_categories.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>Add
                </a>
            <a href="{{ url('admin') }}" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->


    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Image</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $serialNumber = ($work_categories->currentPage() - 1) * $work_categories->perPage() + 1;
            @endphp
            
            @foreach ($work_categories as $work_category)
                <tr data-widget="expandable-table" aria-expanded="false">
                    <td width="5%">{{ $serialNumber }}</td>
                    <td>{{ $work_category->title ?? '' }}</td>
                    <td><img id="preview{{ $loop->iteration }}" src="{{ asset('uploads/workcategory/' . $work_category->image) }}"
                            style="width: 150px; height:150px" /></td>
                    <td>{{ Str::limit(strip_tags($work_category->description), 200) }}</td>
                    <td>
                        <div style="display: flex; flex-direction:row;">
                            <button class="btn btn-warning btn-sm" data-toggle="modal"
                                data-target="#editModal{{ $work_category->id }}" style="margin-right: 5px;"><i
                                    class="fas fa-edit"></i> Edit</button>
                            <button class="btn btn-danger btn-sm" data-toggle="modal"
                                data-target="#deleteModal{{ $work_category->id }}"><i class="fas fa-trash"></i> Delete</button>
                        </div>
                    </td>
                </tr>
                @php
        $serialNumber++;
    @endphp

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal{{ $work_category->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="editModalLabel{{ $work_category->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $work_category->id }}">Edit Work Category</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Your edit form content here -->
                                <p>Edit form content goes here</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <a href="{{ route('admin.work_categories.edit', $work_category->id) }}" class="btn btn-primary">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal{{ $work_category->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="deleteModalLabel{{ $work_category->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $work_category->id }}">Delete</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this work category?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <form id="deleteForm{{ $work_category->id }}"
                                    action="{{ route('admin.work_categories.destroy', $work_category->id) }}" method="POST">
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

    <script>
        const previewImage = e => {
            const reader = new FileReader();
            reader.readAsDataURL(e.target.files[0]);
            reader.onload = () => {
                const preview = document.getElementById('preview');
                preview.src = reader.result;
            };
        };
    </script>
    <!-- Pagination -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        @if ($work_categories->onFirstPage())
            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $work_categories->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        @foreach ($work_categories->getUrlRange(1, $work_categories->lastPage()) as $page => $url)
            @if ($page == $work_categories->currentPage())
                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
            @endif
        @endforeach

        @if ($work_categories->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $work_categories->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
        @endif
    </ul>
</nav>
@endsection
