@extends('frontend.layouts.master')

@section('content')
<div class="container py-3 ">
    <div class="row ">
        <div class="col-lg-5">
            <h2 class="extralarger greenhighlight" >demand</h2>
            <p class="sm-text">Avialable Vacancies</p>
        </div>
    </div>
</div>
<!-- multiple post of service -->
<section class="custom-multi-post">
    <div class="container">
        <div class="row">
            @forelse ($demands->where('to_date', '>=', now()->toDateString()) as $demand)
                <div class="col-md-4 mb-2 ">
                    <div class="custom-card custom-card-wrapper">
                        <a href="{{ route('SingleDemand', ['id' => $demand->id]) }}">
                            <div class="multi_post_image">
                                @if ($demand->image)
                                    <img src="{{ asset('uploads/demands/' . $demand->image) }}" class="custom-card-img-top" alt="Demand Image">
                                @else
                                    <img src="https://plus.unsplash.com/premium_photo-1705091309202-5838aeedd653?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwyfHx8ZW58MHx8fHx8"
                                         class="card-img-top" alt="Post Image">
                                @endif
                            </div>
                            <div class="custom-card-body mx-2 text-center mt-2">
                                <div class="card-text d-flex justify-content-between my-2">
                                    <div class="d-flex">
                                        <i class="bi bi-calendar mx-1 forhide"></i>
                                        <span class="xs-text">Valid : {{ $demand->to_date }}</span>
                                    </div>
                                    <p class="card-text sm-text-bd mr-4 mb-0 d-flex">
                                        <i class="bi bi-people mx-1"></i>
                                        <span>{{ $demand->number_of_people_required }}</span>
                                    </p>
                                </div>
                                <h5 class="custom-card-title">
                                    {{ $demand->vacancy }}
                                </h5>
                                <p class="custom-card-text">
                                    {{Str::limit(strip_tags($demand->title), 300) }}
                                </p>
                                <p class="custom-card-text">
                                    {{Str::limit(strip_tags($demand->content), 300) }}
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="alert alert-info sm-text-md">No active job demands available at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection