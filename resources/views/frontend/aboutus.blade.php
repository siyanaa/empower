

@extends('frontend.layouts.master')

@section('content')
<!-- herosection -->
<section class="aboutherosection">
    <div class="container py-5">
        <div class="row align-items-center mx-5">
            <div class="col-md-7 order-md-1 order-2">
                <h3 class="text-center pt-4">{{ trans('messages.What We Give') }}</h3>
                <p class="lead">
                    {!! app()->getLocale() === 'ne' ? $about->content_ne : $about->content !!}
                </p>
            </div>
            <div class="col-md-5 order-md-2 order-1">
                <img src="{{ asset('uploads/about/' . $about->image) }}" alt="" style="max-width: 100%; height: auto;">
            </div>
        </div>
    </div>
</section>

<!-- Description -->
<section class="container py-4">
    <div class="companydes-section">
        <div class="row featurette d-flex justify-content-center align-items-center">
            <div class="col-md-6 order-md-2 order-1">
                <h3 class="featurette-heading fw-normal lh-5 py-1 text-center">
                    {{ trans('messages.Company Description') }}
                </h3>
                <p class="lead text-justify">
                    {{ app()->getLocale() === 'ne' ? $about->description_ne : $about->description }}
                </p>
            </div>
            <div class="col-md-5 col-xs-12 order-md-1 order-2">
                <img src="{{ asset("image/comp.jpg")}}" alt="About Image" style="max-width: 100%; height: auto;">
            </div>
        </div>
    </div>

</section>

<!-- Our Team Member -->

<section class="single_page">
    <div class="container">
        <div class="row mt-3">
            <h3 class="featurette-heading fw-normal lh-5 py-1 p-0 m-0  ">
                {{ trans('messages.OurTeams') }}
            </h3>
            @if ($teams->isNotEmpty())
                @foreach ($teams as $team)
                    <div class="col-md-3">
                        <div class="card team_card mt-2 mb-2">
                            @if ($team->image)
                                <img src="{{ asset('uploads/team/' . $team->image) }}" class="card-img-top image rounded" alt="">
                            @else
                                <img src="{{ asset('images/girl.jpg') }}" class="card-img-top image rounded" alt="Default Image">
                            @endif
                            <div class="card-body">
                                <span class="team_name">
                                    @if (app()->getLocale() == 'ne')
                                        {{ $team->name_ne }}
                                    @else
                                        {{ $team->name }}
                                    @endif
                                </span><br>
                                <span class="team_position">
                                    @if (app()->getLocale() == 'ne')
                                        {{ $team->position_ne }}
                                    @else
                                        {{ $team->position }}
                                    @endif
                                </span><br>
                                <span class="flex">
                                    <a href="https://www.facebook.com/login" target="_blank">
                                        <i class="fa-brands fa-facebook"></i>
                                    </a>
                                    <a href="https://www.instagram.com/accounts/login/" target="_blank">
                                        <i class="fa-brands fa-square-instagram"></i>
                                    </a>
                                    <a href="https://accounts.google.com/ServiceLogin?service=youtube" target="_blank">
                                        <i class="fa-brands fa-youtube"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="sm-text-bd">No team members available.</p>
            @endif
        </div>
    </div>
</section>
@endsection

