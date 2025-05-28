$(function() {
  $('.slider').slick({
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    speed: 500,          
    autoplaySpeed: 2000, 
    autoplay: true,
    centerMode: true,
    centerPadding: '0',
    arrows: false,
    dots: true,

    responsive: [
      {
        breakpoint: 1224,
        settings: {
          slidesToShow: 1,
          centerPadding: '120px'
        }
      },
      {
        breakpoint: 924,
        settings: {
          slidesToShow: 1,
          centerPadding: '80px'
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
          centerPadding: '60px'
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          centerPadding: '40px'
        }
      }
    ]
  });
});

