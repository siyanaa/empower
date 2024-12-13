@extends('frontend.layouts.master')

@section('content')
  


<!-- herosection -->
    <section class="aboutherosection">
    <div class="container py-5 ">
      <div class="row align-items-center mx-5">
        <div class="col-md-7 order-md-1 order-2">
          <h3 class="text-center pt-4">What We Give?</h3>
          <p style="text-align: justify; line-height: 1.6;">Embarking on an odyssey through the digital landscape of
            virtual reality, we are beckoned into a realm where pixels dance with possibility and imagination knows no
            bounds. But what is this elusive phenomenon that whispers promises of alternate realities and immersive
            experiences? Virtual reality, a symphony of code and creativity, transports us beyond the confines of the
            tangible world into a universe of endless potential. It's the artful fusion of technology and human
            curiosity, inviting us to explore realms both familiar and new.</p>
        </div>
        <div class="col-md-5 order-md-2 order-1">
          <img src="./image/aboutheroimage.png" alt="" style="max-width: 100%; height: auto;">
        </div>
      </div>
    </div>
  </section>

  


<!-- description  -->

    <section class="container py-4">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 160">
      <path fill="#9f9a9a55" fill-opacity="1"
        d="M0,128L120,117.3C240,107,480,85,720,90.7C960,96,1200,128,1320,144L1440,160L1440,320L1320,320C1200,320,960,320,720,320C480,320,240,320,120,320L0,320Z">
      </path>
    </svg>
  <div class="companydes-section">
    <div class="row featurette d-flex justify-content-center align-items-center">
      <div class="col-md-6 order-md-2 order-1">
        <h3 class="featurette-heading fw-normal lh-5 py-1 text-center">
          Company Description
        </h3>
        <p class="lead text-justify">
          embarking on an odyssey through the digital landscape clean of
          virtual reality, we are beckoned into a realm where pixels dance
          with possibility and imagination knows no bounds. But what is this
          elusive phenomenon that whispers promises of alternate reality
          immersive experiences? Virtual reality, a symphony of code and
          creativity, transports us beyond the confines of the tangible world
          into a universe of endless potential. It's the artful fusion of
          technology and human cur
        </p>
      </div>
      <div class="col-md-4 col-xs-12 order-md-1 order-2">
        <img src="./image/Frame 110.png" alt="Frame 110" class="img-fluid" />
      </div>
    </div>

    <div class="row featurette d-flex justify-content-center align-items-center text-justify whyuscustomcard py-4 mt-4">
      <div class="col-md-6 order-md-1 order-1">
        <h3 class="featurette-heading fw-normal lh-5 py-1">
          Company Scope
        </h3>
        <p class="lead d-flex text-justify">
          embarking on an odyssey through the digital landscape clean of
          virtual reality, we are beckoned into a realm where pixels dance
          with possibility and imagination knows no bounds. But what is this
          elusive phenomenon that whispers promises of alternate reality
          immersive experiences? Virtual reality, a symphony of code and
          creativity, transports us beyond the confines of the tangible world
          into a universe of endless potential.
        </p>
        <p class="lead">
          embarking on an odyssey through the digital landscape clean of
          virtual reality, we are beckoned into a realm where pixels dance
          with possibility and imagination knows no bounds. But what is this
          elusive phenomenon that whispers promises of alternate reality
          immersive experiences? Virtual reality, a symphony of code and
          creativity, transports us beyond the confines of the tangible world
          into a universe of endless potential.
        </p>
      </div>
      <div class="col-md-4 col-xs-12 order-md-2 order-2">
        <img src="./image/🌎 Map Maker_ Sinamangal, Kathmandu, Kathmandu, Bagmati Province, Nepal (Standard).png"
          alt="Map Maker" class="img-fluid" />
      </div>
    </div>
  </div>
</section>

 <!-- our team member -->


<section class="single_page">
        <div class="container">
            <div class="row mt-3">
                @foreach ($teams as $team)
                    <div class="col-md-3">
                        <div class="card team_card mt-2 mb-2">
                            @if ($team->image)
                                <img src="{{ asset('uploads/team/' . $team->image) }}" class="card-img-top image" alt="">
                            @else
                                <!-- Default image or placeholder -->
                                <img src="{{ asset('images/girl.jpg') }}" class="card-img-top image" alt="Default Image">
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
                                <span  class="flex">
                                <i class="fa-brands fa-facebook"></i>
                                <i class="fa-brands fa-square-instagram"></i>
                                 <i class="fa-brands fa-youtube"></i>
                                </span>
                               
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>





@endsection
