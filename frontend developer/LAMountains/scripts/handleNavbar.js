$(document).ready(function() {
  var navbar = $('nav');
  var img = $('.logo');
  var scrolledImg = $('.scrolledLogo');
  var as = $('nav a');
  var lis = $('nav li');

  $(window).scroll(function() {
    if ($(window).scrollTop() > 0) {
      navbar.css('background', '#FFF');
      navbar.css('padding', '8px')
      img.css('display', 'none')
      scrolledImg.css('display', 'inherit')
      as.css('color', '#404E6C');
      lis.css('color', '#404E6C');
    } else {
      navbar.css('background', 'transparent');
      img.css('display', 'inherit')
      navbar.css('padding', '')
      scrolledImg.css('display', 'none')
      as.css('color', '#FFF');
      lis.css('color', '#FFF');
    }
  });
});