$(document).ready(function() {
  var navbar = $('nav');
  var img = $('.logo');
  var scrolledImg = $('.scrolledLogo');
  var is = $('nav i');
  var lis = $('nav li');

  $(window).scroll(function() {
    if ($(window).scrollTop() > 0) {
      navbar.css({
        'background': '#FFF',
        'padding': '8px 0',
        'boxShadow': '0 0 8px 0 rgba(224, 223, 223, 1)'
      });
      img.css('display', 'none');
      scrolledImg.css('display', 'inherit');
      is.add(lis).css('color', '#404E6C');
    } else {
      navbar.css({
        'background': 'transparent',
        'padding': '',
        'boxShadow': ''
      });
      img.css('display', 'inherit');
      scrolledImg.css('display', 'none');
      is.add(lis).css('color', '#FFF');
    }
  });
});