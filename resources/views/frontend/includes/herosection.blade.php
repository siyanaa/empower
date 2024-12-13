<!-- @section('content')
<section class="banner ">
    <div class="container-fluid">
        <div class="row g-4 align-items-center">
                <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($coverImages as $key => $coverImage)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}" data-bs-interval="2000">
                                <img src="{{ asset('uploads/coverimage/' . $coverImage->image) }}"
                                    class="d-block banners-imgs" width="100%" height="550px" alt="Cover Image" />
                                <div class="carousel-caption d-md-block">
                                    <h1 class="herosectiontitle">
                                            {{ $coverImage->title }}
                                    </h1>
                                    <a href="{{ route('About') }}"><button class="btn">
                                                READ MORE
                                        </button></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleInterval" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleInterval" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
            </div>
        </div>
    </div>
</section> -->
<!-- <section class="country ">
    <div class="container swiper">
        <div class="slide-container">
            <div class="card-wrapper swiper-wrapper">
                @foreach ($demands as $demand)
                    <div class="card swiper-slide text-center d-flex flex-column">
                        <a href="{{ route('SingleDemand', ['id' => $demand->id]) }}" class="flex-grow-1 d-flex flex-column">
                            <div class="img-box">
                                <img src="{{ asset('uploads/demands/' . ($demand->image ?? 'default.jpg')) }}"
                                    alt="Demand Image" />
                            </div>
                            <div class="profile-details flex-grow-1">
                                <h3 class="pb-2">
                                    <span>
                                        @if (app()->getLocale() == 'ne')
                                            {{ $demand->country->name_ne ?? 'Default Country Name' }}
                                        @else
                                            {{ $demand->country->name ?? 'Default Country Name' }}
                                        @endif
                                    </span>
                                </h3>
                                <h6>
                                    {{ $demand->from_date ?? 'N/A' }} <span class="to">to</span>
                                    {{ $demand->to_date ?? 'N/A' }} <br />
                                </h6>
                                <span class="my-1">
                                    {{ trans('messages.Vacancy') }}:
                                    @if (app()->getLocale() == 'ne')
                                        {{ $demand->vacancy_ne ?? 'N/A' }}
                                    @else
                                        {{ $demand->vacancy ?? 'N/A' }}
                                    @endif
                                </span>
                            </div>
                        </a>
                        <div class="apply-button mt-2">
                            <a href="{{ route('apply', ['id' => $demand->id]) }}" class="apply-btn">
                                {{ 'Apply now' }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section> -->
<style>
    /* Custom Section Styles */
    .custom-section {
        padding: 4px 0;
    }
    .inderherosection {
       /* Dark background for the container */
        background-color: var(--primary-off-off);
        color: #fff;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        height: 85vh;
    }
    .inderherosection:hover {
        background-color: var(--primary-off); /* Dark background for the container */
        color: #fff;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        height: 85vh;
    }
    /* Text Styling */
    /* Button Styling */
    .custom-btn {
        background-color:var(--white);
        color: var(--off-black) !important;
        border: none;
        padding: 12px 25px;
        width:28%;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s, transform 0.3s;
    }
    .custom-btn:hover {
        background-color:  var(--third); /* Darker shade on hover */
        transform: scale(1.1); /* Button zoom effect on hover */
    }
    /* Hero Image */
    .hero-image {
        width: 100%;
        height:70vh;
        border-radius: 10px;
    }
    /* Responsive Design for smaller screens */
    @media (max-width: 767px) {
        .herosectiontitle {
            font-size: 28px;
        }
        .custom-btn {
            width: 100%;
            padding: 14px;
        }
        .hero-image {
        width: 100%;
        height:auto;
        border-radius: 10px;
    }
    }
    </style>
    <section class="container-fluid custom-section">
        <div class="container inderherosection rounded">
            <div class="row gap-md-5">
                <div class="col-md-6 fcc flex-column mb-2">
                <h2 class="herosectiontitle whitehighlight">Global <br>Provider of <br>Skills Manpower!</h2>
                    <div class="d-flex flex-column gap-2">
                        <div class="sm-text whitehighlight p-0 m-0 ">Need skilled manpower for permanent or temporary roles? Manpower.<br>Empower is here to assist!
                        </div>
                        <p class="sm-text">
                            <span>Get in touch with us:</span>
                            <span class="sm-text-bd">
                                @if (!empty($sitesetting->office_contact))
                                    @php
                                        $officeContacts = json_decode($sitesetting->office_contact, true);
                                        $latestContact = is_array($officeContacts) ? end($officeContacts) : $sitesetting->office_contact;
                                    @endphp
                                    <span>{{ $latestContact }}</span>
                                @endif
                            </span>
                        </p>
                        <a href="{{ route('Contact') }}" class="btn custom-btn">Contact Us</a>
                    </div>
                </div>
                
                @foreach ($coverImages as $coverImage)
    <div class="col-md-5">
        <img src="{{ asset('uploads/coverimage/' . $coverImage->image) }}" alt="{{ $coverImage->title }}" class="hero-image">
    </div>
@endforeach
                {{-- <div class="col-md-5">
                    <img src="{{ asset('uploads/coverimage/' . $coverImage->image) }}" alt="{{ $coverImage->title }}" class="hero-image">
                </div> --}}
            </div>
        </div>
    </section>