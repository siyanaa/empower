@extends('backend.layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Edit Demand</span>
                            <a href="{{ route('admin.demands.index') }}" class="btn btn-primary">Back</a> <!-- Back button -->
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.demands.update', $demand->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="country_id">Country</label>
                                <select name="country_id" id="country_id" class="form-control">
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" {{ $demand->country_id == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="from_date">From Date</label>
                                <input type="date" name="from_date" id="from_date" class="form-control" value="{{ $demand->from_date }}">
                            </div>

                            <div class="form-group">
                                <label for="to_date">To Date</label>
                                <input type="date" name="to_date" id="to_date" class="form-control" value="{{ $demand->to_date }}">
                            </div>

                            <div class="form-group">
                                <label for="vacancy">Vacancy Title</label>
                                <input type="text" name="vacancy" id="vacancy" class="form-control" value="{{ $demand->vacancy }}">
                            </div>

                            <div class="form-group">
                                <label for="number_of_people_required">Number of people required </label>
                                <input type="text" name="number_of_people_required" id="number_of_people_required" class="form-control" value="{{ $demand->number_of_people_required }}">
                            </div>

                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" name="image" class="form-control" id="image" onchange="previewImage(event)">
                                <img id="preview1" src="{{ asset('uploads/demands/' . $demand->image) }}" style="max-width: 300px; max-height:300px" />
                            </div>
                            <div id="imagePreview" class="mt-2"></div>

                            <div class="form-group">
                                <label for="content">Content </label>
                                <textarea class="form-control summernote" id="content" name="content" rows="5" required>{{ $demand->content }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                placeholder: 'Enter message here...',
                tabsize: 2,
                height: 100
            });
        });

        const previewImage = e => {
            const reader = new FileReader();
            reader.readAsDataURL(e.target.files[0]);
            reader.onload = () => {
                const preview = document.getElementById('preview1');
                preview.src = reader.result;
            };
        };
    </script>
@endsection
