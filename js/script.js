let check = false;
$( document ).ready(function() {

  $('[popup-name=popup-2]').fadeIn(300);

  $('[popup-open]').on('click', function() {
    const popup_name = $(this).attr('popup-open');
    $('[popup-name="' + popup_name + '"]').fadeIn(300);
  });


  $('[popup-close]').on('click', function() {
    const popup_name = $(this).attr('popup-close');
    $('[popup-name="' + popup_name + '"]').fadeOut(300);
  });
  
  $('.popup').on('click', function() {
    const popup_name = $(this).find('[popup-close]').attr('popup-close');
    $('[popup-name="' + popup_name + '"]').fadeOut(300);

  }).children().click(function() {
    $('.dont').on('click', function() {
      check = true;
    });
  
    if (check === true) {
      check = false;
      return true;
    } else {
      return false;
    }

  });   

  $(".menu-toggle-btn").click(function(){
    $(this).toggleClass("fa-times");
    $(".navigation-menu").toggleClass("active");
  });
});