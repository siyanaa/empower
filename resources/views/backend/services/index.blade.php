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
            <a href="{{ route('admin.services.create') }}"><button class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>Add
                    </button></a>
            <a href="{{ url('admin') }}"><button class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i>
                    Back</button></a>
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
                <th>Keywords</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>
            @php
                $serialNumber = ($services->currentPage() - 1) * $services->perPage() + 1;
            @endphp
            @foreach ($services as $service)
                <tr data-widget="expandable-table" aria-expanded="false">
                    <td width="5%">{{ $serialNumber }}</td>
                    <td>{{ $service->title ?? '' }}</td>
                    <td> <img id="preview{{ $loop->iteration }}" src="{{ asset('uploads/service/' . $service->image) }}"
                            style="width: 150px; height:150px" /></td>
                    <td>
                        <!-- Displaying Summernote content -->
                        {{ Str::limit(strip_tags($summernoteContent->processContent($service->description)), 200) }}
                    </td>
                    <td>{{ $service->keywords ?? '' }}</td>

                    <td>
                        <div style="display: flex; flex-direction:row;">
                            <button class="btn btn-warning btn-sm" data-toggle="modal"
                                data-target="#editModal{{ $service->id }}" style="margin-right: 5px;"><i
                                    class="fas fa-edit"></i> Edit</button>
                            <button class="btn btn-danger btn-sm" data-toggle="modal"
                                data-target="#deleteModal{{ $service->id }}"><i class="fas fa-trash"></i> Delete</button>
                        </div>
                    </td>
                </tr>
                @php
                $serialNumber++;
            @endphp

                <!-- Edit Modal -->

                <div class="modal fade" id="editModal{{ $service->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="editModalLabel{{ $service->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <!-- Modal header -->
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $service->id }}">Edit Service</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <p>Are you sure you want to edit this service?</p>
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <form action="{{ route('admin.services.edit', $service->id) }}" method="GET">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Edit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal{{ $service->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="deleteModalLabel{{ $service->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $service->id }}">Delete Service</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this service?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <form id="deleteForm{{ $service->id }}"
                                    action="{{ route('admin.services.destroy', $service->id) }}" method="POST">
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
                @if ($services->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $services->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                @endif

                @foreach ($services->getUrlRange(1, $services->lastPage()) as $page => $url)
                    @if ($page == $services->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                @if ($services->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $services->nextPageUrl() }}" rel="next">&raquo;</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                @endif
            </ul>
        </nav>
@endsection
