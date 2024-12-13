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
            <h1 class="m-0">FAQs</h1>
            <a href="{{ route('admin.faqs.create') }}"><button class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add
                    </button></a>
            <a href="{{ url('admin') }}"><button class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i>
                    Back</button></a>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                <li class="breadcrumb-item active">FAQs</li>
            </ol>
        </div>
    </div>

    <div class="container">
        <div class="accordion" id="faqAccordion">
            @php
            $serialNumber = ($faqs->currentPage() - 1) * $faqs->perPage() + 1;
        @endphp
        
            @foreach ($faqs as $faq)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $faq->id }}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $faq->id }}" aria-expanded="true"
                            aria-controls="collapse{{ $faq->id }}">
                            {{ $faq->question }}
                        </button>
                    </h2>
                    <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse"
                        aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <p>{{ $faq->answer }}</p>
                            <div class="btn-group" role="group" aria-label="FAQ Actions">
                                <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST"
                                    style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Pagination -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        @if ($faqs->onFirstPage())
            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $faqs->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        @foreach ($faqs->getUrlRange(1, $faqs->lastPage()) as $page => $url)
            @if ($page == $faqs->currentPage())
                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
            @endif
        @endforeach

        @if ($faqs->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $faqs->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
        @endif
    </ul>
</nav>
  
@endsection
