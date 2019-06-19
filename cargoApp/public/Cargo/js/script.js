jQuery(document).ready(function ($) {
  var scrollTop;
  if ($('#navbar').offset().top >= 100) {

    $('#navbar').addClass('scrolled-nav');
  } else {
    $('#navbar').removeClass('scrolled-nav');
  }
  $(window).scroll(function () {
    scrollTop = $(window).scrollTop();
    $('.counter').html(scrollTop);

    if (scrollTop >= 100) {
      $('#navbar').addClass('scrolled-nav');
    } else if (scrollTop < 100) {
      $('#navbar').removeClass('scrolled-nav');
    }
  });
  // $("html").niceScroll({
  //   cursorcolor: "#229999",
  //   cursorborder: "0px solid #fff",
  //   cursorwidth: "7",
  //   zindex: 10,
  //   scrollspeed: "60"
  // });
});
  // var scrollButton = $("#shm");
  // $(window).scroll(function () {
  //     $(window).scrollTop() >= 490 ? scrollButton.show() : scrollButton.hide();
  //     console.log("hi")
  // });
  // scrollButton.click(function () {
  //     $("html,body").animate({
  //         scrollTop: 0
  //     }, 800);
  // });



