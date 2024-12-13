@extends('backend.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="container">
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
                <h1 class="m-0">Team Members</h1>
                <a href="{{ route('admin.teams.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>Add
                    </a>
                <a href="{{ url('admin') }}" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard v1</li>
                </ol>
            </div>
        </div>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>S.N.</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Phone Number</th>
                    <th>Role</th>
                    <th>Email</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>@php
                $serialNumber = ($teamMembers->currentPage() - 1) * $teamMembers->perPage() + 1;
            @endphp

                @foreach ($teamMembers as $member)
                    <tr data-widget="expandable-table" aria-expanded="false">
                        <td width="5%">{{ $serialNumber }}</td>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->position }}</td>
                        <td>{{ $member->phone_no }}</td>
                        <td>{{ $member->role }}</td>
                        <td>{{ $member->email }}</td>
                        <td><img id="preview{{ $loop->iteration }}"
                                src="{{ $member->image ? asset('uploads/team/' . $member->image) : '' }}"
                                style="width: 150px; height:150px" /></td>
                        <td>
                            <div style="display: flex; flex-direction:row;">
                                <button class="btn btn-warning btn-sm" data-toggle="modal"
                                    data-target="#editModal{{ $member->id }}" style="margin-right: 5px;"><i
                                        class="fas fa-edit"></i> Edit</button>
                                <button class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#deleteModal{{ $member->id }}"><i class="fas fa-trash"></i>
                                    Delete</button>
                            </div>
                        </td>
                    </tr>
                    @php
                    $serialNumber++;
                @endphp

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal{{ $member->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="editModalLabel{{ $member->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel{{ $member->id }}">Edit Team Member</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Your edit form content here -->
                                    <p>Edit form content goes here</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <a href="{{ route('admin.teams.edit', $member->id) }}" class="btn btn-primary">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal{{ $member->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="deleteModalLabel{{ $member->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $member->id }}">Delete Team Member
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this team member?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <form id="deleteForm{{ $member->id }}"
                                        action="{{ route('admin.teams.destroy', $member->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>

        </table>
         <!-- Pagination -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        @if ($teamMembers->onFirstPage())
            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $teamMembers->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        @foreach ($teamMembers->getUrlRange(1, $teamMembers->lastPage()) as $page => $url)
            @if ($page == $teamMembers->currentPage())
                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
            @endif
        @endforeach

        @if ($teamMembers->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $teamMembers->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
        @endif
    </ul>
</nav>
    </div>
@endsection
