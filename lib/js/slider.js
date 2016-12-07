$(function() {

  $('nav.slider').hover(sliderOn, sliderOff);
  function sliderOn() {
    $(this).animate({
      'left': '0px'
    });
  }
  function sliderOff() {
    $('this').animate({
      'left': '-200px'
    });
  }
  
  
});  // End Doc Ready

