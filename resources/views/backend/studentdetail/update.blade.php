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
            <a href="{{ route('admin.student-details.index') }}"><button class="btn btn-primary btn-sm"><i
                        class="fa fa-arrow-left"></i>
                    Back</button></a>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
        </div>
    </div>

    <form id="quickForm" method="POST" action="{{ route('admin.student-details.update', $studentDetail->id) }}"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <!-- Name -->
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ $studentDetail->name }}"
                    required>
            </div>
            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email"
                    value="{{ $studentDetail->email }}">
            </div>
            <!-- Phone Number -->
            <div class="form-group">
                <label for="phone_no">Phone Number</label>
                <input type="text" name="phone_no" class="form-control" id="phone_no"
                    value="{{ $studentDetail->phone_no }}">
            </div>
            <!-- Country -->
            <div class="form-group">
                <label for="country_id">Country</label>
                <select name="country_id" class="form-control" id="country_id" required>
                    <option value="">Select Country</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}"
                            {{ $studentDetail->country_id == $country->id ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <!-- Company -->
            <div class="form-group">
                <label for="company_id">Company</label>
                <select name="company_id" class="form-control" id="company_id" required>
                    <option value="">Select Company</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}"
                            {{ $studentDetail->company_id == $company->id ? 'selected' : '' }}>
                            {{ $company->title }}</option>
                    @endforeach
                </select>
            </div>
            <!-- Course -->
            <div class="form-group">
                <label for="work_category_id">Work Category</label>
                <select name="work_category_id" class="form-control" id="work_category_id" required>
                    <option value="">Select Work Category</option>
                    @foreach ($work_categories as $work_category)
                        <option value="{{ $work_category->id }}"
                            {{ $studentDetail->work_category_id == $work_category->id ? 'selected' : '' }}>
                            {{ $work_category->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <!-- Intake Date -->
            <div class="form-group">
                <label for="intake_month_year">Intake Date</label>
                <input type="date" name="intake_month_year" class="form-control" id="intake_month_year"
                    value="{{ $studentDetail->intake_month_year }}" required>
            </div>
            <!-- Image -->
            <div class="form-group">
                <label for="image">Image</label>
                @if ($studentDetail->image)
                    <div>
                        <img id="currentImage" src="{{ asset('uploads/students_detail/image/' . $studentDetail->image) }}"
                            style="max-width: 150px; max-height:150px; margin-bottom:10px;">
                    </div>
                @endif
                <input type="file" name="image" class="form-control" id="image" onchange="previewImage(event)">
                <img id="preview" style="max-width: 150px; max-height:150px; margin-top:10px; display: none;">
            </div>

            <!-- Documents -->
            <div class="form-group">
                <label for="documents">Upload Documents</label>
                @if ($studentDetail->documents && is_array(json_decode($studentDetail->documents, true)))
                    <ul id="documentList">
                        @foreach (json_decode($studentDetail->documents, true) as $document)
                            <li>
                                <a href="{{ asset($document) }}" target="_blank">View Document</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
                <input type="file" class="form-control-file" id="documents" name="documents[]" multiple
                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif">
                <small class="form-text text-muted">Supported formats: pdf, doc, docx, jpg, jpeg, png, gif.</small>
            </div>


            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
    </form>

    <script>
        const previewImage = event => {
            const reader = new FileReader();
            reader.onload = function() {
                const preview = document.getElementById('preview');
                preview.src = reader.result;
                preview.style.display = 'block'; // Show the preview
                const currentImage = document.getElementById('currentImage');
                if (currentImage) {
                    currentImage.style.display = 'none'; // Hide the current image
                }
            };
            reader.readAsDataURL(event.target.files[0]);
        };
    </script>
    {{-- <script>
        const updateDocumentList = () => {
            const documentList = document.getElementById('documentList');
            if (documentList) {
                documentList.innerHTML = ''; // Clear the document list
                const files = document.getElementById('documents').files;
                const start = Math.max(files.length - 2, 0); // Start from the 2nd last file
                for (let i = start; i < files.length; i++) {
                    const listItem = document.createElement('li');
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(files[i]);
                    link.textContent = 'View Document';
                    listItem.appendChild(link);
                    documentList.appendChild(listItem);
                }
            }
        };

        document.getElementById('documents').addEventListener('change', updateDocumentList);
    </script> --}}
@endsection
