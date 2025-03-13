//Homepage Hero Carousel
$('.slider-content').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: true,
  fade: true,
  infinite: true,
  speed: 1000,
  loop: true,
  asNavFor: '.slider-thumb',
  arrows: false,
  autoplaySpeed: 4000,
  autoplay: true,
});
$('.slider-thumb').slick({
  slidesToShow: 3,
  slidesToScroll: 3,
  asNavFor: '.slider-content',
  dots: false,
  centerMode: false,
  focusOnSelect: true
});