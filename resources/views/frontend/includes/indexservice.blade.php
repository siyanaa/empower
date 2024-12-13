<style>
    .swiper {
        width: 100%;
        height: 100%;
        overflow: hidden;
    }
    .swiper-wrapper {
        display: flex;
    }
    .card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 10px;
        margin: 5px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
</style>
<section class="container-fluid explorecat sectiongap">
    <div class="container">
        <div class="row fcc">
            <img src="{{ asset('image/contacts.png') }}" alt="" class="col-md-4 lgimage-lg" />
            <div class="col-8">
                <div class="swiper swiper-container col-md-8">
                    <div class="d-flex flex-column mb-md-4">
                        <span class="extralarger">Provide</span>
                        <span class="greenhighlight extralarger">Services</span>
                    </div>
                    <!-- Swiper Wrapper -->
                    <div class="swiper-wrapper">
                        @foreach($services as $service)
                            <div class="swiper-slide">
                                <a href="{{ route('SingleService', ['slug' => $service->slug]) }}" class="text-decoration-none">
                                    <div class="card d-flex p-0 mx-4 col-10 mx-md-0 pt-2">
                                        <img class="mdimage" src="{{ asset('uploads/service/' . $service->image) }}" alt="{{ $service->title }}">
                                        <div class="card-body">
                                            <p class="sm-text-bd text-center">{{Str::limit(strip_tags($service->title), 12) }}</p>
                                            <p class="xs-text text-center">Multifaceted</p>
                                        </div>
                                    </div>
                                </a>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Include Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    const swiper = new Swiper('.swiper-container', {
        direction: 'horizontal',
        loop: true,
        spaceBetween: 0,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 3,
            },
            1200: {
                slidesPerView: 4,
            }
        }
    });
</script>