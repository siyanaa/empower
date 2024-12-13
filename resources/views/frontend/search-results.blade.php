@extends('frontend.layouts.master')
@section('content')

    <section class="multi_post">
        <div class="container">
            <div class="multi_poster row justify-content-center">
                @if (
                    $posts->isNotEmpty() ||
                        $abouts->isNotEmpty() ||
                        $services->isNotEmpty() ||
                        $categories->isNotEmpty() ||
                        $contacts->isNotEmpty() ||
                        $countries->isNotEmpty() ||
                        $work_categories->isNotEmpty() ||
                        $testimonials->isNotEmpty() ||
                        $blogCategories->isNotEmpty() ||
                        $studentDetails->isNotEmpty())
                    @if ($posts->isNotEmpty())
                        <h2>Posts</h2>
                        @foreach ($posts as $post)
                            <div class="post-list">
                                <a href="{{ route('singlePost', $post->slug) }}">
                                    <p>{{ $post->title }}</p>
                                </a>
                                <img src="{{ asset('uploads/post/' . $post->image) }}" alt="Post Image">

                            </div>
                        @endforeach
                    @endif

                    @if ($abouts->isNotEmpty())
                        <h2>Abouts</h2>
                        @foreach ($abouts as $about)
                            <div class="about-list">
                                <a href="{{ route('About', $about->slug) }}">
                                    <p>{{ $about->title }}</p>
                                </a>
                            </div>
                        @endforeach
                    @endif
                    @if ($services->isNotEmpty())
                        <h2>Services</h2>
                        @foreach ($services as $service)
                            <div class="service-list">
                                <a href="{{ route('SingleService', $service->slug) }}">
                                    <p>{{ $service->title }}</p>
                                </a>
                            </div>
                        @endforeach
                    @endif
                    @if ($blogCategories->isNotEmpty())
                        <h2>Blog Post Category</h2>
                        @foreach ($blogCategories as $blog)
                            <div class="blog-list">
                                <a href="{{ route('SingleBlogpostcategory', $blog->slug) }}">
                                    <p>{{ $blog->title }}</p>
                                </a>
                            </div>
                        @endforeach
                    @endif
                @else
                    <div>
                        <h2>No results found</h2>
                    </div>
                @endif
            </div>
        </div>
    </section>

@endsection
