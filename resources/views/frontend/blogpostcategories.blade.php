@extends('frontend.layouts.master')
@section('content')
<!-- herosection -->
<section class="herosectionforallpage my-4">
    <div class="container">
    <img src="./image/demandbg.png" alt="" class="rounded">
    <div class="d-flex flex-column innercontent">
     <span class="maintitle">BLOG</span>
     <span class="navigatetitle py-2 px-3 mb-1">
      <a href="" style="color: white !important; text-decoration: none;">Home</a> > <span>Blog</span>
  </span>
    </div>
  </div>
  </section>
    <!-- <div class="">
        <h1 class="page_title"> {{ trans('messages.Blogs') }} </h1>
    </div> -->


    <section class="multi_post">
    <div class="container">
        <div class=" row justify-content-center">
            @foreach ($blogpostcategories as $blogpostcategory)
                <div class="col-lg-4 mb-4">
                    <a href="{{ route('SingleBlogpostcategory', ['slug' => $blogpostcategory->slug]) }}" class="post-link">
                        <div class="multi_post_image">
                            @if ($blogpostcategory->image)
                                <img src="{{ asset('uploads/blogpostcategory/' . $blogpostcategory->image) }}"
                                    class="img-fluid" alt="Services Image">
                            @else
                                <img src="https://plus.unsplash.com/premium_photo-1705091309202-5838aeedd653?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwyfHx8ZW58MHx8fHx8"
                                    class="img-fluid" alt="Services Image">
                            @endif
                        </div>

                        <div class="post-body">
                            <h5 class="md-text greenhighlight py-1">
                                {{ app()->getLocale() === 'ne' ? $blogpostcategory->title_ne : $blogpostcategory->title }}
                            </h5>

                            <p class="post-description ">
                                {{  Str::limit(strip_tags($blogpostcategory->content), 250) }}
                            </p>
                            <a href="{{ route('SingleBlogpostcategory', ['slug' => $blogpostcategory->slug]) }}" class="read-more-link">
                                {{ trans('messages.ReadMore') }} &nbsp;&nbsp;<i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </a>
                </div>
            
            @endforeach
        </div>
    </div>
</section>



@endsection