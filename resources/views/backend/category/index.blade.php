@extends('backend.layouts.master')

@section('content')
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

                <!-- Link to create a new category -->
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add</a>
                <!-- Link to go back to admin dashboard -->
                <a href="{{ url('admin') }}" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back</a>

            </div>
            <div class="col-sm-6">
                <!-- Breadcrumb -->
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard v1</li>
                </ol>
            </div>
        </div>

        <!-- Check if categories are available -->
        @if ($categories->isEmpty())
            <p>No categories found.</p>
        @else
            <!-- Display categories in a table -->
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $perPage = $categories->perPage(); // the number of results per page
                    $currentPage = $categories->currentPage(); // current page number
                    $serialNumber = ($currentPage - 1) * $perPage + 1; // calculate the starting serial number for the current page
                @endphp
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $serialNumber++ }}</td>
                            <td>{{ $category->title }}</td>
                            <td>
                                <!-- Action buttons: Edit and Delete -->
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                @if ($categories->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $categories->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                @endif

                @foreach ($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                    @if ($page == $categories->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                @if ($categories->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $categories->nextPageUrl() }}" rel="next">&raquo;</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                @endif
            </ul>
        </nav>
        @endif
    </div>
@endsection
