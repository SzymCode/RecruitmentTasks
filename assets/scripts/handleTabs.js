$(document).ready(function() {
  var mtnItem1 = $('.mountain-item-1');
  var mtnItem2 = $('.mountain-item-2');
  var mtnImages = $('.mountain-images img');
  var mtnImg1 = $('.mountain-image-1');
  var mtnImg2 = $('.mountain-image-2');
  var element1 = $('.element1');
  var element2 = $('.element2');

  mtnItem1.click(function() {
    mtnImages.hide();
    mtnItem1.css({
      'background': 'var(--lightgray)',
      'color': 'var(--blue)',
      'text-decoration': 'underline',
      'text-underline-position': 'under'
    });
    mtnItem2.css({
      'background': 'var(--blue)',
      'color': 'var(--lightgray)',
      'text-decoration': '',
      'text-underline-position': ''
    });
    mtnImg1.show();
    element1.css({
      'display': 'flex'
    });
    element2.hide();
  });

  mtnItem2.click(function() {
    mtnImages.hide();
    mtnItem1.css({
      'background': 'var(--blue)',
      'color': 'var(--lightgray)',
      'text-decoration': '',
      'text-underline-position': ''
    });
    mtnItem2.css({
      'background': 'var(--lightgray)',
      'color': 'var(--blue)',
      'text-decoration': 'underline',
      'text-underline-position': 'under'
    });
    mtnImg2.show()
    element1.hide();
    element2.css({
      'display': 'flex'
    });
  });
});