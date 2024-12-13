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
            <a href="{{ url('admin') }}">
                <button class="btn btn-primary btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </button>
            </a>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
        </div>
    </div>

    <form id="quickForm" method="POST" action="{{ route('admin.about-us.update', $about->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Title</label>
                <span style="color:red; font-size:large"> *</span>
                <input type="text" name="title" class="form-control" placeholder="Title" value="{{ $about->title }}" required>
            </div>
            
            <div class="form-group">
                <label for="exampleInputEmail1">Subtitle</label>
                <input type="text" name="subtitle" class="form-control" placeholder="Subtitle" value="{{ $about->subtitle }}">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Image</label>
                <input type="file" name="image" class="form-control" onchange="previewImage(event)" placeholder="Image">
                <img id="preview" src="{{ asset('storage/' . $about->image) }}" style="max-width: 500px; max-height: 500px;" />
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <span style="color:red; font-size:large"> *</span>
                <textarea style="width: 100%; min-height: 150px;" type="text" class="form-control" name="description" id="description" placeholder="Add Description">{{ $about->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="summernote">Content </label>
                <span style="color:red; font-size:large"> *</span>
                <textarea style="width: 100%; min-height: 200px;" id="summernote" name="content">{{ $about->content }}</textarea>
            </div>

            {{-- <div class="form-group">
                <label for="scope">Scope </label>
                <textarea style="width: 100%; min-height: 150px;" type="text" class="form-control" name="scope" id="scope" placeholder="Add Scope">{{ $about->scope }}</textarea>
            </div> --}}

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>

    <!-- Main row -->
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 300, // set editor height
                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor
                focus: true // set focus to editable area after initializing summernote
            });
            $('#summernote_ne').summernote({
                height: 300, // set editor height
                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor
                focus: true // set focus to editable area after initializing summernote
            });
        });

        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@stop
