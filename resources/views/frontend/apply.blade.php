
@extends('frontend.layouts.master')
@section('content')
<div class="container my-5 shadow p-4">
    <h1 class="mb-4 extralarger  greenhighlight">Application For {{ $demand->vacancy }}</h1>
    <form id="applicationForm" action="{{ route('apply.store', ['id' => $demand->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="name" class="form-label">{{ trans('messages.Name') }}</label><span style="color:red; font-size:large"> *</span>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="email" class="form-label">{{ trans('messages.Email') }}</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="address" class="form-label">{{ trans('messages.Address') }}</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}">
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="phone_no" class="form-label">{{ trans('messages.Phone Number') }}</label><span style="color:red; font-size:large"> *</span>
                <input type="tel" class="form-control @error('phone_no') is-invalid @enderror" id="phone_no" name="phone_no" value="{{ old('phone_no') }}" required>
                @error('phone_no')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="whatsapp_no" class="form-label">{{ trans('messages.WhatsApp Number') }}</label>
                <input type="tel" class="form-control @error('whatsapp_no') is-invalid @enderror" id="whatsapp_no" name="whatsapp_no" value="{{ old('whatsapp_no') }}">
                @error('whatsapp_no')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="cv" class="form-label">{{ trans('messages.Upload CV') }} </label><span style="color:red; font-size:large"> * </span><span>( PDF )</span>
                <input type="file" class="form-control @error('cv') is-invalid @enderror" id="cv" name="cv" required>
                @error('cv')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-2">
                <label for="photo" class="form-label">{{ trans('messages.Upload Photo') }}</label>
                <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo">
                @error('photo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="g-recaptcha" data-sitekey="6LdAPAoqAAAAADCgyV-AMkcB0Il2IkaZuAMlgjYx"></div>
                @if ($errors->has('g-recaptcha-response'))
                    <div class="invalid-feedback d-block">{{ $errors->first('g-recaptcha-response') }}</div>
                @endif
            </div>
        </div>
        <div class="">
            <button type="submit" class="py-3 btn btn-primary">Submit Application</button>
        </div>
    </form>
</div>
    <!-- Custom CSS -->
    <style>
    </style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<script>
    document.getElementById('applicationForm').addEventListener('submit', function(event) {
        var recaptchaResponse = document.querySelector('.g-recaptcha-response');
        if (!recaptchaResponse || recaptchaResponse.value === '') {
            event.preventDefault(); // Prevent the form submission
            Swal.fire({
                icon: 'warning',
                title: 'Hold up!',
                text: 'Please tick the reCAPTCHA box before submitting.',
                confirmButtonText: 'Got it!',
                confirmButtonColor: '#f39c12' // Custom button color (optional)
            });
        }
    });
</script>

@endsection






