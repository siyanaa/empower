<!-- news.blade.php -->
@extends('frontend.layouts.master')

@section('content')
    <div class="background">
        <h1 class="page_title">{{ __('News') }}</h1>
    </div>

   

    <section class="multi_post">
        <div class="container">
            <div class="multi_poster row justify-content-center">

                @foreach ($newsPosts as $post)
                <div class="card col-lg-4">
                    <div class="multi_post_image">
                        @if ($post->image)
                            <img src="{{ asset('uploads/post/' . $post->image) }}"
                                class="card-img-top" alt="Post Image">
                        @else
                            <img src="https://plus.unsplash.com/premium_photo-1705091309202-5838aeedd653?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwyfHx8ZW58MHx8fHx8"
                                class="card-img-top" alt="Services Image">
                        @endif
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text">
                            {{ Str::limit(strip_tags($post->description), 250) }}
                        </p>
                        <a href="{{ route('singlePost', ['slug' => $post->slug]) }}">
                            <button class="btn bg-primary text-white">Read More &nbsp;&nbsp;<i
                                class="fa-solid fa-arrow-right"></i></button>                        </a>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>

@endsection