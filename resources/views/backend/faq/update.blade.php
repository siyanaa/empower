@extends('backend.layouts.master')

@section('content')
    <div class="container">
        <h1>Edit FAQ</h1>
        <form method="POST" action="{{ route('admin.faqs.update', $faq->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="question">Question</label>
                <input type="text" class="form-control" id="question" name="question" value="{{ $faq->question }}" required>
            </div>
            <div class="form-group">
                <label for="answer">Answer</label>
                <textarea class="form-control" id="answer" name="answer" rows="5" required>{{ $faq->answer }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
