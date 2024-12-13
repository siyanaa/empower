@extends('backend.layouts.master')

@section('content')
    <div class="container">
        <h1>Add New Category</h1>
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Category Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>

    @if (session('success'))
        <div class="container mt-5">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if ($categories->isNotEmpty())
        <div class="container mt-5">
            {{-- <h1>Categories</h1> --}}
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
                        $serialNumber = 1;
                    @endphp
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $serialNumber++ }}</td>
                            <td>{{ $category->title }}</td>
                            <td>
                                <!-- Add action buttons here -->
                                <!-- Example: Edit and Delete buttons -->
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
        </div>
    @endif
@endsection
