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

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">{{ $page_title }}</h1>
            <a href="{{ url('admin') }}">
                <button class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back</button>
            </a>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
        </div>
    </div>

    <form id="quickForm" method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="name">Name </label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Enter name" required>
            </div>
            
            <div class="form-group">
                <label for="exampleInputEmail1">Image</label>
                <input type="file" name="image" class="form-control" onchange="previewImage(event)" placeholder="Image"
                    required>
            </div>
            <img id="preview1" style="max-width: 200px; max-height:500px" />
            <div class="form-group">
                <label for="company_id">Company</label>
                <select name="company_id" class="form-control" id="company_id" required>
                    <option value="">Select Company</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="work_category_id">Work Category</label>
                <select name="work_category_id" class="form-control" id="work_category_id" required>
                    <option value="">Select Work Category</option>
                    @foreach ($work_categories as $work_category)
                        <option value="{{ $work_category->id }}">{{ $work_category->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description" rows="3" required></textarea>
            </div>
            
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>

    <script>
        const previewImage = e => {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview1').src = e.target.result;
            }
            reader.readAsDataURL(e.target.files[0]);
        };
    </script>
@stop
