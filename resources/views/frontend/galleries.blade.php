@extends('frontend.layouts.master')
@section('content')
<style>
 .gallerycontainer img {
    border-radius: 8px !important;
    position: relative;
    width: 100%; /* Ensure the image takes full width */
    height: 100%; /* Ensure the image takes full height */
}
.gallerimage {
    position: relative;
    overflow: hidden; /* Ensures description doesn't overflow outside the image */
}
.des {
    position: absolute;
    top: 0; /* Initially position at the top */
    left: 0;
    width: 100%;
    height: 100%; /* Cover the entire image */
    background: rgba(64, 153, 255, 0.3); /* Semi-transparent yellow light background */
    color: black; /* Text color for better contrast */
    padding: 20px;
    border-radius: 8px;
    transform: translateY(-100%); /* Start from above the image */
    opacity: 0; /* Make it invisible initially */
    transition: transform 0.7s ease, opacity 0.7s ease; /* Smooth transition */
}
.gallerimage:hover .des {
    transform: translateY(0); /* Move to its original position */
    opacity: 1; /* Fade in */
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}
.image-title{
    font-size: 18px;
    color:white;
    text-transform:capitalize;
}

.gallery-filters {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 15px;
    }
    .gallery-filters .btn {
        margin-left: 5px;
    }
    .gallery-filters .btn.active {
        background-color: #4099ff;
        color: white;
    }
    .gallery-item {
        display: block;
        transition: opacity 0.3s ease;
    }
    .gallery-item.hidden {
        display: none;
    }
</style>
<div class="container py-3">
    <div class="row">
        <div class="col-lg-5">
            <h2 class="extralarger greenhighlight">Images Gallery</h2>
            <p class="sm-text">A view of our work</p>
        </div>
    </div>
</div>

<section class="container-fluid p-0 m-0 pb-4">
    <div class="container gallerycontainer p-0">
        <div class="row gallery-container">
            @foreach($images->sortByDesc('updated_at') as $image)
                <div class="col-md-4 rounded py-1 p-0 m-0 gallery-item" data-category="{{ $image->category->slug ?? 'uncategorized' }}">
                    <div class="col-md-11">
                        <div class="gallerimage">
                            @if(!empty($image->img) && is_array($image->img))
                                {{-- Use the first image from the array, or the most recently uploaded image --}}
                                <img src="{{ asset(last($image->img)) }}" alt="{{ $image->title }}" class="col-12 rounded p-0 m-0" style="height:300px; object-fit: cover;">
                            @endif
                            <div class="des">
                                <h5 class="image-title">{{ $image->title }}</h5>
                                <a href="{{ route('singleImage', $image->slug) }}" class="btn btn-light">Other Images</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.gallery-filters .btn');
        const galleryItems = document.querySelectorAll('.gallery-item');
    
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
    
                const filter = this.getAttribute('data-filter');
    
                galleryItems.forEach(item => {
                    const itemCategory = item.getAttribute('data-category');
                    
                    if (filter === 'all' || itemCategory === filter) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    });
    </script>
@endsection