@extends('frontend.layouts.master')

@section('content')
    <div class="background">
        <h1 class="page_title">{{ __('Our Team') }}</h1>
    </div>
    <header>
        <div class="title">
            <h3>The creative crew</h3>
        </div>
        <div class="content">
            <h5>who we are</h5>
            <p>We are team of creatively diverse. driven. innovative individuals working to create something mind
                boggling.</p>
        </div>
    </header>

    <main>
        @foreach ($teams as $team)
            <div class="profile">
                <figure data-value="{{ $team->position }}">
                    <figcaption>{{ $team->name }}</figcaption>
                </figure>
            </div>
        @endforeach


    </main>
    </div>
@endsection
