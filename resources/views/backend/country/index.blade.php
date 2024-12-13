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
            <a href="{{ route('admin.countries.create') }}"><button class="btn btn-primary btn-sm"><i
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

    <!-- Countries Table -->
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>S.N.</th>
                <th>Name</th>
                <th>Image</th>
                <th>Content</th>
                <th>Action</th>
                
            </tr>
        </thead>
        <tbody>
            @php
                $serialNumber = ($countries->currentPage() - 1) * $countries->perPage() + 1;
            @endphp
            @if ($countries && count($countries) > 0)
                @foreach ($countries as $country)
                    <tr data-widget="expandable-table" aria-expanded="false">
                        <td width="5%">{{ $serialNumber }}</td>
                        <td width="5%">{{ $loop->iteration }}</td>
                        <td>{{ $country->name }}</td>
                        <td> <img id="preview{{ $loop->iteration }}" src="{{ asset('uploads/country/' . $country->image) }}"
                                style="width: 150px; height:150px" /></td>
                        <td>
                            <!-- Displaying Summernote content -->
                            {{ Str::limit(strip_tags($country->content), 200) }}
                        </td>
                        <td>
                            <div style="display: flex; flex-direction:row;">
                                <!-- Edit Button with Modal -->
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                    data-target="#editModal{{ $country->id }}" style="margin-right: 5px;">
                                    <i class="fas fa-edit"></i> Edit
                                </button>

                                <!-- Delete Button with Modal -->
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#deleteModal{{ $country->id }}">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    @php
                    $serialNumber++;
                @endphp


                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal{{ $country->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="editModalLabel{{ $country->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel{{ $country->id }}">Edit Country</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Form for editing the country -->
                                    <form action="{{ route('admin.countries.update', $country->id) }}" method="POST">
                                        @csrf
                                        <!-- Your form fields for editing -->
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <!-- Change made: Added form with action and method -->
                                    <form id="editForm{{ $country->id }}" method="GET" action="{{ route('admin.countries.edit', $country->id) }}">
                                        <!-- CSRF token -->
                                        @csrf
                                        <!-- Edit button -->
                                        <button type="submit" class="btn btn-primary">Edit</button>
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                    </div>




                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal{{ $country->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="deleteModalLabel{{ $country->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $country->id }}">Delete Country</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this country?
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('admin.countries.destroy', $country->id) }}" method="POST"
                                        id="deleteForm{{ $country->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <tr>
                    <td colspan="5">No countries found.</td>
                </tr>
            @endif
        </tbody>
    </table>
    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            @if ($countries->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $countries ->previousPageUrl() }}" rel="prev">&laquo;</a></li>
            @endif

            @foreach ($countries ->getUrlRange(1, $countries ->lastPage()) as $page => $url)
                @if ($page == $countries ->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach

            @if ($countries ->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $countries->nextPageUrl() }}" rel="next">&raquo;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
            @endif
        </ul>
    </nav>
@endsection
