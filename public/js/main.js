var swiper = new Swiper(".slide-container", {
    slidesPerView: 1,
    spaceBetween: 10,
    loop:true,
    centerSlide:"true",
    grabCursor:"true",
    fade:"true",
    autoplay:{
        delay:2000,
    },

    breakpoints: {
        400:{
            slidesPerView:2,
            // spaceBetween:40,
        },
       
      768: {
        slidesPerView: 3,
        spaceBetween: 40,
      },
      1024: {
        slidesPerView: 4,
        spaceBetween: 50,
      },
    },
  });

  var swiper = new Swiper(".mySwiper", {
    slidesPerView: "2",
    spaceBetween: 30,
    loop:true,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    breakpoints:{
      
      300:{
        slidesPerView:1,
      },
      1000:{
        slidesPerView:2,
      }
    }
  });