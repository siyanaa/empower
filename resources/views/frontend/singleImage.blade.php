@extends('frontend.layouts.master')
@section('content')
<div class="container py-3">
    <div class="row ">
        <div class="col-lg-5">
            <h2 class="extralarger greenhighlight" >{{ $image->title }}</h2>
            <p class="sm-text">A view of all images</p>
        </div>
    </div>
</div>
<section class="single_page">
    <div class="container">
        <div class="row mt-3">
            
            @foreach (array_reverse($image->img) as $imgUrl)
            <div class="col-md-4 mb-3">
                <a class="image-link" href="{{ asset($imgUrl) }}" style="color: var(--first)">
                    <img src="{{ asset($imgUrl) }}" class="gallery_image">
                </a>
            </div>
        @endforeach
        <p class="text-center sm-text"> <span>
                    {{ $image->img_desc }}
            </span></p>
        </div>
    </div>
</section>
<!-- Include Magnific Popup CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
<!-- Include jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Include Magnific Popup JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
<script>
    $(document).ready(function(){
        $('.image-link').magnificPopup({
            type: 'image',
            gallery:{
                enabled:true
            }
        });
    });
</script>
@endsection