$(function(){
  $('.menu-button').on('click', function(){
    $('.menu-button').each(function(){
      $(this).removeClass('selected');
    });
    $(this).addClass('selected');
  });
});