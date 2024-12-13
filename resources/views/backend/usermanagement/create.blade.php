@extends('backend.layouts.master')

@section('content')
<div class="container">
    <h1>Create User</h1>
    <form method="POST" action="{{ route('backend.usermanagement.store') }}"> <!-- Update the route name -->
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select class="form-control" id="role" name="role" required>
                <option value="user">User</option>
                <option value="editor">Editor</option>
                <option value="admin">Admin</option>
                <!-- Add more role options if needed -->
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create </button>
    </form>
</div>
@endsection
