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
            <a href="{{ url('admin') }}"><button class="btn-primary btn-sm"><i class="fa fa-arrow-left"></i>
                    Back</button></a>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->

    <form id="quickForm" method="POST" action="{{ route('admin.favicons.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div>
                <div class="form-group">
                    <label for="android_chrome_oneninetwo">Favicon 192*192</label><span style="color:red; font-size:large">
                        *</span>
                    <input type="file" name="android_chrome_oneninetwo" class="form-control"
                        id="android_chrome_oneninetwo" onchange="previewImage(event, 'preview_android_chrome_oneninetwo')"
                        required>
                    <img id="preview_android_chrome_oneninetwo" style="max-width: 500px; max-height:500px" />
                </div>

                <div class="form-group">
                    <label for="android_chrome_fiveonetwo">Favicon 512*512</label><span style="color:red; font-size:large">
                        *</span>
                    <input type="file" name="android_chrome_fiveonetwo" class="form-control"
                        id="android_chrome_fiveonetwo" onchange="previewImage(event, 'preview_android_chrome_fiveonetwo')"
                        required>
                    <img id="preview_android_chrome_fiveonetwo" style="max-width: 500px; max-height:500px" />
                </div>

                <div class="form-group">
                    <label for="favicon_thirtyTwo">Favicon 32* 32</label><span style="color:red; font-size:large"> *</span>
                    <input type="file" name="favicon_thirtyTwo" class="form-control" id="favicon_thirtyTwo" required
                        onchange="previewImage(event, 'preview_favicon_thirtyTwo')">
                    <img id="preview_favicon_thirtyTwo" style="max-width: 500px; max-height:500px" />
                </div>

                <div class="form-group">
                    <label for="favicon_sixteen">Favicon 16*16</label><span style="color:red; font-size:large"> *</span>
                    <input type="file" name="favicon_sixteen" class="form-control" id="favicon_sixteen" required
                        onchange="previewImage(event, 'preview_favicon_sixteen')">
                    <img id="preview_favicon_sixteen" style="max-width: 500px; max-height:500px" />
                </div>

                <div class="form-group">
                    <label for="favicon_ico">Favicon ICO</label><span style="color:red; font-size:large"> *</span>
                    <input type="file" name="favicon_ico" class="form-control" id="favicon_ico" required
                        onchange="previewImage(event, 'preview_favicon_ico')">
                    <img id="preview_favicon_ico" style="max-width: 500px; max-height:500px" />
                </div>

                <div class="form-group">
                    <label for="apple_touch_icon"> apple_touch_icon</label><span style="color:red; font-size:large">
                        *</span>
                    <input type="file" name="apple_touch_icon" class="form-control" id="apple_touch_icon" required
                        onchange="previewImage(event, 'preview_apple_touch_icon')">
                    <img id="preview_apple_touch_icon" style="max-width: 500px; max-height:500px" />
                </div>

                <div class="form-group">
                    <label for="file">Site manifest</label><span style="color:red; font-size:large"> *</span>
                    <input type="file" name="site_webmanifest" class="form-control" id="site_webmanifest" required
                        onchange="previewImage(event, 'preview_site_webmanifest')">
                    <img id="preview_site_webmanifest" style="max-width: 500px; max-height:500px" />
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn-primary">Submit</button>
        </div>
    </form>

    <script>
        const previewImage = (event, previewId) => {
            const reader = new FileReader();
            reader.readAsDataURL(event.target.files[0]);
            reader.onload = () => {
                const preview = document.getElementById(previewId);
                preview.src = reader.result;
            };
        };
    </script>
@stop
