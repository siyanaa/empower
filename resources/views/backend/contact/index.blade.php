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
            <a href="{{ url('admin') }}"><button class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back</button></a>
        </div>
        
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th width="5%">S.N</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                @php
                $serialNumber = ($contacts->currentPage() - 1) * $contacts->perPage() + 1;
                @endphp

                @foreach ($contacts as $contact)
                    <tr>
                        <td>{{ $serialNumber }}</td>
                        <td>{{ $contact->name ?? '' }}</td>
                        <td>{{ $contact->phone_no ?? '' }}</td>
                        <td>{{ $contact->message ?? '' }}</td>
                    </tr>
                    @php
                    $serialNumber++;
                    @endphp
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            @if ($contacts->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $contacts->previousPageUrl() }}" rel="prev">&laquo;</a></li>
            @endif

            @foreach ($contacts->getUrlRange(1, $contacts->lastPage()) as $page => $url)
                @if ($page == $contacts->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach

            @if ($contacts->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $contacts->nextPageUrl() }}" rel="next">&raquo;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
            @endif
        </ul>
    </nav>

@stop
