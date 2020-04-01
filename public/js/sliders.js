$('.multiple-items').slick({
  infinite: false,
  slidesToShow: 3,
  slidesToScroll: 3,
  variableWidth: true,
  arrows: false,
  dots: true,
  responsive: [
    {
      breakpoint: 1800,
      settings: {
        arrows: false,
        dots: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 1024,
      settings: {
        arrows: false,
        dots: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 768,
      settings: {
        arrows: false,
        dots: true,
        slidesToShow: 1,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        dots: true,
      }
    }
  ]
});

$('.responsive').slick({
  arrows: false,
  dots: true,
  infinite: true,
  speed: 300,
  variableWidth: true,
  slidesToShow: 1,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 1800,
      settings: {
        arrows: false,
        dots: true,
        infinite: true
      }
    },
    {
      breakpoint: 1440,
      settings: {
        arrows: false,
        dots: true,
        infinite: true,
      }
    },
    {
      breakpoint: 1280,
      settings: {
        arrows: false,
        dots: true,
        infinite: true,
      }
    },
    {
      breakpoint: 1024,
      settings: {
        arrows: false,
        dots: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 768,
      settings: {
        arrows: false,
        dots: true,
        slidesToShow: 1,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
        arrows: false,
      }
    }
  ]
});

$('.single-item').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  dots: true,
  variableWidth: true,
});