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
            <a href="{{ route('admin.video-galleries.index') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-arrow-left"></i> Back
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
            <form id="quickForm" method="POST" action="{{ route('admin.video-galleries.update', $video->id) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $video->id }}">
                
                <div class="form-group">
                    <label for="title">Title</label><span style="color:red; font-size:large"> *</span>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Title" value="{{ old('title', $video->title) }}" required>
                </div>
                
                <div class="form-group">
                    <label for="url">YouTube URL</label><span style="color:red; font-size:large"> *</span>
                    <input type="text" name="url" class="form-control" id="url" placeholder="YouTube URL" value="{{ old('url', $video->full_url) }}" required>
                    <small class="form-text text-muted">Paste the full YouTube video URL (e.g., https://youtu.be/videoId)</small>
                </div>
                
                <div class="form-group">
                    <label>Preview</label>
                    <div>
                        <iframe width="400" height="225" src="https://www.youtube.com/embed/{{ $video->url }}"
                            title="{{ $video->title }}" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </section>
@endsection