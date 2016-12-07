$(function() {
 
  $(window).scroll(function() {
    // Stick navigation menu when it's over 200px, plus
    // don't add class 'navbar-fixed' to navigation menu
    // if screen size is below 480px
    // console.log($(window).scrollTop())
    if ($(window).scrollTop() > 200 && $(window).width() > 480) {
      $('.navigational-wrapper').addClass('navbar-fixed');
    }
    if ($(window).scrollTop() < 201) {
      $('.navigational-wrapper').removeClass('navbar-fixed');
    }
  });

}); // END MAIN JQUERY FUNCTION