@extends('backend.layouts.master')

@section('content')
    <div class="container">
        <h1>Add New Post</h1>
        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control summernote" id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" class="form-control" id="image" name="image" required
                    onchange="previewImage(event)">
                <div id="imagePreview" class="mt-2"></div> <!-- Image preview container -->
            </div>
            <div class="form-group">
                <label for="category_id">Category:</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
        <script>
            $(document).ready(function() {
                $('.summernote').summernote(); // Initialize Summernote
            });

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
        </script>
    </div>
@endsection
