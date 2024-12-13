@extends('backend.layouts.master')
@section('content')
<div class="container">
    <h1>Edit User</h1>
    <form method="POST" action="{{ route('backend.usermanagement.update', $user->id) }}"> <!-- Update the route name -->
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select class="form-control" id="role" name="role" required>
                <option value="user" @if($user->hasRole('user')) selected @endif>User</option>
                <option value="editor" @if($user->hasRole('editor')) selected @endif>Editor</option>
                <option value="admin" @if($user->hasRole('admin')) selected @endif>Admin</option>
                <!-- Add more role options if needed -->
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
