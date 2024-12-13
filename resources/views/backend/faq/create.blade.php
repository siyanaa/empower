@extends('backend.layouts.master')

@section('content')
    <div class="container">
        <h1>Create New FAQ</h1>
        <form method="POST" action="{{ route('admin.faqs.store') }}">
            @csrf
            <div class="form-group">
                <label for="question">Question</label>
                <input type="text" class="form-control" id="question" name="question" required>
            </div>
            <div class="form-group">
                <label for="answer">Answer</label>
                <textarea class="form-control" id="answer" name="answer" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
