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



    <form id="quickForm" novalidate="novalidate" method="POST" action="{{ route('admin.services.store') }}"
        enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="title">Title </label><span style="color:red; font-size:large"> *</span>
                <input style="width:auto;" type="text" name="title" class="form-control" id="title"
                    value="{{ old('title') }}" placeholder="Title">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Image</label>
                <input type="file" name="image" class="form-control" onchange="previewImage(event)" placeholder="Image"
                    required>
            </div>
            <img id="preview1" style="max-width: 200px; max-height:500px" />


            <div>
                <label for="description">Description </label><span style="color:red; font-size:large"> *</span>
                <textarea style="max-width: 100%; min-height: 200px;" class="form-control summernote" name="description" id="summernote"
                    placeholder="Add Description">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="keywords">Keywords</label>
                <input style="width:auto;" type="text" name="keywords" class="form-control" id="keywords" 
                    value="{{ old('keywords') }}" placeholder="Keywords">
            </div>

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>


    <!-- Main row -->


    <!-- Include Summernote JS -->

    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 150, // Set the height of the editor
                minHeight: null, // Set the minimum height of the editor
                maxHeight: null, // Set the maximum height of the editor
                focus: true // Set focus to editable area after initializing Summernote
            });
        });
    </script>


    <script>
        const previewImage = e => {
            const reader = new FileReader();
            reader.readAsDataURL(e.target.files[0]);
            reader.onload = () => {
                const preview = document.getElementById('preview1');
                preview.src = reader.result;
            };
        };
    </script>
    <script>
        $(document).ready(function() {
            function extractPlainTextFromSummernote() {
                var plainText = $('.note-editable')
                    .text(); // Assuming '.note-editable' is the class used by Summernote
                console.log(plainText); // For demonstration purposes, you can log the plainText to the console
                // Now, you can do something with the plainText, such as saving it to your database
            }
        });
    </script>

@stop
