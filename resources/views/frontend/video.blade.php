@extends('frontend.layouts.master')
@section('content')
<div class="container py-3">
    <div class="row">
        <div class="col-lg-5">
            <h2 class="extralarger greenhighlight">Video Gallery</h2>
            <p class="sm-text">A showcase of our work</p>
        </div>
    </div>
</div>
<section class="single_page">
    <div class="container">
        <div class="row mt-3">
            @forelse ($videos as $video)
            <div class="col-md-4">
                <div class="card video_card mt-2 mb-2">
                    <div class="video-container">
                        <iframe
                            class="youtube-player"
                            width="100%"
                            height="315"
                            src="https://www.youtube.com/embed/{{ $video->url }}"
                            title="{{ $video->title }}"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            loading="lazy">
                        </iframe>
                    </div>
                    <div class="card-body text-center">
                        <span class="vid_desc">
                            {{ $video->title ?? 'Untitled Video' }}
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fa fa-video-camera"></i> 
                    No videos available at the moment. 
                    Check back soon!
                </div>
            </div>
        @endforelse
        </div>
    </div>
</section>
@push('styles')
<style>
    .video_card {
        height: 100%;
        background: #fff;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    .video_card:hover {
        transform: scale(1.03);
    }
    .video-container {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
        height: 0;
        overflow: hidden;
        background: #F8F9FA;
        border-radius: 4px 4px 0 0;
    }
    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
    }
    .vid_desc {
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }
</style>
@endpush
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const players = document.querySelectorAll('.youtube-player');
    players.forEach(function(iframe) {
        iframe.parentElement.classList.add('loading');
        iframe.addEventListener('load', function() {
            iframe.parentElement.classList.remove('loading');
        });
        iframe.addEventListener('error', function() {
            const container = iframe.parentElement;
            container.innerHTML = `
                <div class="alert alert-warning m-2">
                    <i class="fa fa-exclamation-triangle"></i>
                    Video temporarily unavailable
                </div>
            `;
        });
    });
});
</script>
@endpush
@endsection

