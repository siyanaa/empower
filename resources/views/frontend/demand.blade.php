@extends('frontend.layouts.master')


@section('content')
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


<section class="sample_page pb-5">
    <div class="container">
        <div class="row mx-1">
            <div class="col-lg-8 col-md-8 col-sm-12 order-1 order-md-1 ">
                <img src="{{ asset('uploads/demands/' . $demand->image) }}" alt="Demand Image"
                    class="sample_page_image">
                    <h5 class="d-flex justify-content-between">
    <span>{{ $demand->from_date }} <span class="to">to</span> {{ $demand->to_date }}</span>
    <p class="card-text md-text-bd mb-0 d-flex">
        <i class="bi bi-people mx-1"></i>
        <span>{{ $demand->number_of_people_required }}</span>
    </p>
</h5>




            </div>




            <div class="col-lg-12 col-md-12 col-sm-12 order-2 order-md-3 sample_page_content p-0 m-0 mx-1">
                <p class="md-text p-0 m-0">{{$demand->vacancy}}</p>
            </div>


            <div class="col-lg-12 col-md-12 col-sm-12 order-2 order-md-3 sample_page_content  p-0 m-0">
                @if (app()->getLocale() == 'ne')
                    <p>{!! $demand->content_ne !!}</p>
                @else
                    <p class="m-0">{!! $demand->content !!}</p>
                @endif


                <!-- Apply button linked to the apply route -->
                <a href="{{ route('apply', ['id' => $demand->id]) }}" class="btn">Apply now</a>
            </div>


            <div class="col-lg-4 col-md-4 col-sm-12 order-3 order-md-2 sample_page_list mt-2 mb-2 p-4">
                <h3 class="">{{ trans('messages.Demands') }}</h3>
                <ul>
                    @foreach ($listdemands as $demand)
                        <li class="sm-text-bd">
                            <a href="{{ route('SingleDemand', ['id' => $demand->id]) }}">
                                <span>
                                    @if (app()->getLocale() == 'ne')
                                        {{ $demand->country->name_ne }}
                                    @else
                                        {{ $demand->country->name }}
                                    @endif
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>


<!-- Custom CSS -->
<!-- <style>
        .apply-btn {
            background-color: rgba(99, 2, 2, 0.8);
            color: whitesmoke;
            border: 1px solid black;
            padding: 1px 10px;
            cursor: pointer;
            margin-left: 350px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 10px;
        }


        .apply-btn:hover {
            background-color: grey;
            color: whitesmoke;
        }
    </style> -->
@endsection



