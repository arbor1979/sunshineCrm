$(document).ready(function() {
  $('#tab-nav-1 > ul > li > a').click(function() {
    var $parentItem = $(this).parent(),
        slideAmt = $(this).next().width(),
        direction;

    if (parseInt($parentItem.css('marginLeft'), 10) < 0) {
      direction = '+=';
      $(this).removeClass('expanded');
    } else {
      $(this).addClass('expanded');
      direction = '-=';
    }
    $parentItem
      .animate({marginLeft: direction + slideAmt}, 400);
    return false;
  });
 
});

$(document).ready(function() {
  var $topLinks2 = $('#tab-nav-2 > ul > li > a');
  $topLinks2.click(function() {
    var $parentItem = $(this).parent(),
        slideAmt = $(this).next().width(),
        direction;
    $topLinks2.removeClass('expanded');
    if (parseInt($parentItem.css('marginLeft'), 10) < 0) {
      direction = '+=';
    } else {
      $(this).addClass('expanded');
      direction = '-=';
    }
    $parentItem
      .animate({marginLeft: direction + slideAmt}, 400)
        .siblings()
        .animate({marginLeft: '0'}, 150);
    return false;
  });
});


$(document).ready(function() {
  var closeAll,
      $topLinks3 = $('#tab-nav-3 > ul > li > a');

  $('#tab-nav-3 ul ul').css('opacity', '0.5');
  
  setTabIndex();
  
  $topLinks3.click(function() {
    var $parentItem = $(this).parent(),
        slideAmt = $(this).next().width(),
        direction;
    $topLinks3.removeClass('expanded');
    if (parseInt($parentItem.css('marginLeft'), 10) < 0) {
      direction = '+=';
    } else {
      $(this).addClass('expanded');
      direction = '-=';
    }
    $parentItem
    .animate({marginLeft: direction + slideAmt}, 400)
      .siblings()
      .animate({marginLeft: '0'}, 150);
        
    setTabIndex();
    
    return false;
  });
  //www.kaiwo123.com
  $('#tab-nav-3')
  .mouseleave(function() {
    closeAll = setTimeout(function() {
      $topLinks3.removeClass('expanded').parent().animate({marginLeft: '0'}, 150);
    }, 1000);
  }).mouseenter(function() {
    clearTimeout(closeAll);
  });

  function setTabIndex() {
    $topLinks3.each(function(index) {
      if ($(this).is('.expanded')) {
        $(this).next().find('a').removeAttr('tabIndex');
      } else {
        $(this).next().find('a').attr({tabIndex: '-1'});
      }
    });
  }

  
});
//www.kaiwo123.com