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
        <div class="col-sm-6">
            <h1 class="m-0">{{ $page_title }}</h1>
            <a href="{{ route('admin.posts.index') }}">
                <button class="btn btn-primary btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </button>
            </a>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <form id="quickForm" method="POST" action="{{ route('admin.posts.update', $post->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $post->id }}">
                <div class="form-group">
                    <label for="title">Post Title</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="University Title"
                        value="{{ $post->title }}" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <div id="description">{!! $post->description !!}</div>
                    <textarea class="form-control d-none" id="descriptionInput" name="description">{!! $post->description !!}</textarea>
                </div>


                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select name="category_id" class="form-control" id="category_id" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" class="form-control" id="image" onchange="previewImage(event)">
                    <img id="preview1" src="{{ asset('uploads/post/' . $post->image) }}"
                        style="max-width: 300px; max-height:300px" />
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </section>



    <!-- Main row -->
    <script>
        $(document).ready(function() {
            // Initialize Summernote
            $('#description').summernote({
                height: 300,
                callbacks: {
                    onChange: function(contents) {
                        // Update the hidden textarea with Summernote content
                        $('#descriptionInput').val(contents);
                    }
                }
            });
        });
    </script>
    <script>
        const previewImage = e => {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview1').src = e.target.result;
            }
            reader.readAsDataURL(e.target.files[0]);
        };
    </script>
@endsection
