@extends('frontend.layouts.master')

@section('content')
    <div class="background">
        <h1 class="page_title">{{ __('Countries') }}</h1>
    </div>
    <section class="multi_post">
        <div class="container">
            <div class="multi_poster row justify-content-center">
                @foreach ($countries as $country)
                <div class="card col-lg-4">
                    <div class="multi_post_image">
                        @if ($country->image)
                            <img src="{{ asset('uploads/country/' . $country->image) }}" class="card-img-top" alt="Country Image">
                        @else
                            <img src="https://plus.unsplash.com/premium_photo-1705091309202-5838aeedd653?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwyfHx8ZW58MHx8fHx8" class="card-img-top" alt="Country Image">
                        @endif
                    </div>
                    <div class="card-body">
                        <span>
                            @if (app()->getLocale() == 'ne')
                                {{ $country->name_ne }}
                            @else
                                {{ $country->name }}
                            @endif
                        </span>
                        <p class="card-text pb-4">
                            <span>
                                @if (app()->getLocale() == 'ne')
                                    {!! $country->content_ne !!}
                                @else
                                    {!! $country->content !!}
                                @endif
                            </span>
                        </p>
                        <a href="{{ route('singleCountry', ['slug' => $country->slug]) }}">
                            <button class="btn text-white">{{ trans('messages.ReadMore') }} &nbsp;&nbsp;<i class="fa-solid fa-arrow-right"></i></button>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
