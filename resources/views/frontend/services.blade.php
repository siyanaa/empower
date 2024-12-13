@extends('frontend.layouts.master')
@section('content')

<div class="container py-3 ">
    <div class="row ">
        <div class="col-lg-5">
            <h2 class="extralarger greenhighlight" >Service</h2>
            <p class="sm-text">The services we provide</p>
        </div>
    </div>
</div>
<!-- multiple post of service -->
<section class="custom-multi-post">
    <div class="container">
        <div class="row"> <!-- Use Bootstrap's grid with gaps -->
            @foreach ($services as $service)
                <div class="col-md-4 mb-2 ">
                    <div class="custom-card custom-card-wrapper">
                        <a href="{{ route('SingleService', ['slug' => $service->slug]) }}">
                            <div class="custom-multi-post-image">
                                @if ($service->image)
                                    <img src="{{ asset('uploads/service/' . $service->image) }}" class="custom-card-img-top" alt="Post Image">
                                @else
                                    <img src="https://plus.unsplash.com/premium_photo-1705091309202-5838aeedd653?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwyfHx8ZW58MHx8fHx8" class="custom-card-img-top" alt="Post Image">
                                @endif
                            </div>
                            <div class="custom-card-body mx-2 text-center">
                                <p class="custom-card-text">
                                {{Str::limit(strip_tags($service->description), 150) }}

                                </p>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
