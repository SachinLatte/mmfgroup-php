//Homepage Hero Carousel
$('.slider-content').slick({
  autoplay: true,
  speed: 1000,
  lazyLoad: 'progressive',
  asNavFor: '.slider-thumb',
  arrows: false,
  dots: false,
  pauseOnHover: false
}).slickAnimation();

$('.slider-thumb').slick({
  slidesToShow: 3,
  slidesToScroll: 3,
  asNavFor: '.slider-content',
  dots: false,
  centerMode: false,
  focusOnSelect: true,
  autoplay: true,
  pauseOnHover: false
});

//Homepage Counter
var counter = document.querySelectorAll(".counter")
window.addEventListener("load", function () {
  counter.forEach(function (k, v) {
    var start = counter[v].getAttribute('data-count-start')
    var end = counter[v].getAttribute('data-count-end')
    var speed = counter[v].getAttribute('data-speed')
    setInterval(function () {
      start++;
      if (start > end) {
        return false;
      }
      counter[v].innerText = start;
    }, speed)
  })
}, false);

// Smoothscroll
const lenis = new Lenis({
  autoRaf: true,
});

//Homepage Brands Carousel
$(".brands-carousel1").slick({
  dots: false,
  infinite: true,
  slidesToShow: 6,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 0,
  cssEase: 'linear',
  speed: 1800,
  pauseOnFocus: false,
  pauseOnHover: false,
  pauseOnDotsHover: false,
});
$(".brands-carousel2").slick({
  dots: false,
  infinite: true,
  slidesToShow: 6,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 0,
  rtl: true,
  cssEase: 'linear',
  speed: 1800,
  pauseOnFocus: false,
  pauseOnHover: false,
  pauseOnDotsHover: false,
});

//Sticky Navbar
window.addEventListener('scroll', function () {
  let header = document.querySelector('.main-header');
  header.classList.toggle('sticky', window.scrollY > 0);
});

//Scroll to top js
var btn = $('#scroll-to-top-button');
$(window).scroll(function() {
  if ($(window).scrollTop() > 300) {
    btn.addClass('show');
  } else {
    btn.removeClass('show');
  }
});
btn.on('click', function(e) {
  e.preventDefault();
  $('html, body').animate({scrollTop:0}, '300');
});

//Aos Animation
AOS.init({
  duration: 1200,
  once:true
})

//Current year script
let CurrentDate = new Date();
document.querySelector('.currentYear').innerText = CurrentDate.getFullYear();


