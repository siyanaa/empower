@extends('frontend.layouts.master')

@section('content')
    <div class="background">
        <h1 class="page_title">
            @if (app()->getLocale() == 'ne')
            {{ $work_category->title_ne }}
        @else
            {{ $work_category->title }}
        @endif<h1>
    </div>

    <section class="sample_page">
        <div class="container">
            <div class="row">

                <div class="col-lg-8 col-md-8 col-sm-12 order-1 order-md-1">

                    <img class="sample_page_image" src="{{ asset('uploads/workcategory/' . $work_category->image) }}" alt="Country Image">



                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 order-2 order-md-3 sample_page_content">
                    @if (app()->getLocale() == 'ne')
                    {!! $work_category->description_ne !!}
                @else
                    {!! $work_category->description !!}
                @endif
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 order-3 order-md-2 sample_page_list mt-2 mb-2 p-4">
                    <h3 class="">{{ trans('messages.Employment') }}
                    </h3>
                    <ul>
                        @foreach ($listwork_category as $work_category)
                            <li>
                                <a href="{{ route('singleworkCategory', ['slug' => $work_category->slug]) }}">
                                    @if (app()->getLocale() == 'ne')
                                    {{ $work_category->title_ne }}
                                @else
                                    {{ $work_category->title }}
                                @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
