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
            <a href="{{ url('admin') }}"><button class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i>
                    Back</button></a>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
        </div>
    </div>

    <form id="quickForm" method="POST" action="{{ route('admin.work_categories.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Title </label>
                <input type="text" name="title" class="form-control" placeholder="Title" required>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Image</label>
                <input type="file" name="image" class="form-control" onchange="previewImage(event)" placeholder="Image"
                    required>
                <img id="preview" style="max-width: 200px; max-height:500px; display:none" />
            </div>

            <div class="form-group">
                <label for="description">Description </label>

                <textarea style="max-width: 100%; min-height: 100px;" type="text" class="form-control summernote" name="description"
                    id="description" placeholder="Add Description" value="{{ old('description') }}"></textarea>
            </div>

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>

    <script>
        // Function to preview the selected image
        const previewImage = e => {
            const file = e.target.files[0];
            const reader = new FileReader();
            const preview = document.getElementById('preview');

            reader.onload = () => {
                preview.src = reader.result;
                preview.style.display = 'block';
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        };

        // Initialize Summernote on the description textarea
        $(document).ready(function() {
            $('.summernote').summernote({
                placeholder: 'Add Description...',
                tabsize: 2,
                height: 100
            });
        });
    </script>
@stop
