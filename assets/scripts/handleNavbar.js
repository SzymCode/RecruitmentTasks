$(document).ready(function() {
  var navbar = $('nav');
  var img = $('.logo');
  var scrolledImg = $('.scrolledLogo');
  var is = $('nav i');
  var lis = $('nav li');

  $(window).scroll(function() {
    if ($(window).scrollTop() > 0) {
      img.hide();
      scrolledImg.show();
      navbar.css({
        'background': '#FFF',
        'padding': '8px 0',
        'boxShadow': '0 0 8px 0 rgba(224, 223, 223, 1)'
      });
      is.add(lis).css('color', '#404E6C');
    } else {
      img.show();
      scrolledImg.hide();
      navbar.css({
        'background': 'transparent',
        'padding': '',
        'boxShadow': ''
      });
      is.add(lis).css('color', '#FFF');
    }
  });
});