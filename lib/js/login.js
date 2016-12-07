/* 
 * Pepster's Place 
 * A Website Design & Development Company
 * President John R Pepp
 */

$(function () {
    $('.icon').on('click', function (e) {
        e.preventDefault();
        $('.login').hide();
        if ($('ul#myTopnav').hasClass('responsive')) {
            $('ul#myTopnav').removeClass('responsive');
            $('.loginBtn').css('display', 'inline-block');
        } else {
            $('ul#myTopnav').addClass('responsive');
            $('.loginBtn').css('display', 'none');
        }
    });
    $(".loginBtn").on('click', function (e) {
        e.preventDefault();
        $(".login").slideToggle("slow");
    });
});

