@extends('backend.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create Demand</div>

                    <div class="card-body">
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

                        <form method="POST" action="{{ route('admin.demands.store') }}" id="demandForm"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="country_id">Country</label>
                                <select name="country_id" id="country_id" class="form-control">
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="from_date">From Date</label>
                                <input type="date" name="from_date" id="from_date" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="to_date">To Date</label>
                                <input type="date" name="to_date" id="to_date" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="vacancy">Vacancy Title</label>
                                <input type="text" name="vacancy" id="vacancy" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="number_of_people_required">Number of people required </label>
                                <input type="text" name="number_of_people_required" id="number_of_people_required" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" name="image" id="image" class="form-control-file" onchange="previewImage(event)">
                                <div id="imagePreview"></div>
                            </div>
                           

                            <div class="form-group">
                                <label for="content">Content </label>
                                <textarea name="content" id="content" class="form-control summernote" rows="5"></textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

function previewImage(event) {
                var input = event.target;
                var preview = document.getElementById('imagePreview');

                while (preview.firstChild) {
                    preview.removeChild(preview.firstChild); // Clear previous preview
                }

                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        var img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxWidth = '200px'; // Adjust the maximum width as needed
                        img.style.maxHeight = '200px'; // Adjust the maximum height as needed
                        preview.appendChild(img);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

        $(document).ready(function() {
            $('.summernote').summernote({
                height: 200, // Set the height of the editor
                minHeight: null, // Set the minimum height of the editor
                maxHeight: null, // Set the maximum height of the editor
                focus: true // Set focus to the editor after initialization
            });
        });
    </script>
@endsection
