(function($) {
  "use strict";

  // global variables
  var $ = jQuery,
    userTouchDev = navigator.userAgent.match(/iPad|iPhone|Android/i),
    $body = $('body'),
    $windowBrowser = $(window),
    usrBrowser = navigator.userAgent,
    link = '.single-page-nav a',
    cache = [],
    slider_container_height = 0;

    /* add class touch device */
  (function(){
    if(userTouchDev) $body.addClass('touch-device');
    else $body.addClass('no-touch-device');
  })();

/* -------------------------------------------------------*/
/* ----------- Load img with http://placehold.it/---------*/
/* -------------------------------------------------------*/

$(window).load(function() {

  $('img:not(".logo-img")').each(function() {

    if(this.src.match(/.svg$/i) !== -1)
      return false;

    if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)){
      var ieversion=new Number(RegExp.$1)

      if (ieversion>=9) {
        if (typeof this.naturalWidth === "undefined" || this.naturalWidth === 0) {
          this.src = "http://placehold.it/" + ($(this).attr('width') || this.width || $(this).naturalWidth()) + "x" + (this.naturalHeight || $(this).attr('height') || $(this).height());
        }
      }
    } else {
      if (!this.complete || typeof this.naturalWidth === "undefined" || this.naturalWidth === 0) {
      this.src = "http://placehold.it/" + ($(this).attr('width') || this.width) + "x" + ($(this).attr('height') || $(this).height());
    }
  }
  });
});


/* --------------------------------------------------------------*/
/* ----------------------- DOCUMENT READY -----------------------*/
$(document).ready(function($) {

  // --------------------
  // EVENT HANDLERS -----

  // open menu slide 
  var $menuElem = $("#wrapper, #slide-menu, #wrapper-header");
  $("#menu-open").click(function() {  
    if ($menuElem.hasClass("open-menu")) {
      $menuElem.removeClass("open-menu");   
    }
    else {
      $menuElem.addClass("open-menu");     
    }
  });
  $(".menu-close, #wrapper").click(function() {  
    $menuElem.removeClass("open-menu");   
  });
  // portfolio carousels
  $('.portfolio').on('click', '.element-item', function () {
    // Select current element ID
    var currentAlbomID = $(this).data('albumid');
    // ReInit after click
    cache = [];
    $('.element-item:visible').each(function(index, element) {
      var AlbomID = $(element).data('albumid');
      cache.push(AlbomID);
    });
    var current_element_id = $.inArray(currentAlbomID, cache);
    var nextAlbomID = getNextID(current_element_id);
    var prevAlbomID = getPrevID(current_element_id);  
    // Get JSON
    create(currentAlbomID, nextAlbomID, prevAlbomID);
  });
  $body.on('click', '.prev.p-scroll',function() {
    var albom_id = $(this).data('albomid');
    var current_element_id = $.inArray(albom_id, cache);
    var nextAlbomID = getNextID(current_element_id);
    var prevAlbomID = getPrevID(current_element_id);
    create(albom_id, nextAlbomID, prevAlbomID);
    return false;
  });

  $body.on('click', '.next.p-scroll', function() {
    var albom_id = $(this).data('albomid');
    
    var current_element_id = $.inArray(albom_id, cache);
    var nextAlbomID = getNextID(current_element_id);
    var prevAlbomID = getPrevID(current_element_id);

    create(albom_id, nextAlbomID, prevAlbomID);
    return false;
  });

  // SCROLL TOP and other files
  $body.on('click', '.go-up', function(e) {
    var $link = $(this).attr('href');
    $('body, html').animate({
      scrollTop: $('body, html').offset().top
    }, 1600);
    e.preventDefault();
  });

  /* add class fixed for menu
   -------------------------------------------------------------------*/
  if($(".front-page #wrapper-header").length>0) {
	var lastScrollTop = 0;
    $(window).scroll(function(){
      /*var navHeight = $(window).height() - 100;
      var window_top = $(window).scrollTop() - navHeight;
      var div_top = $('#nav-anchor').offset().top;
      if (window_top > div_top) {
        $('#wrapper-header').addClass('fixed');
      } else {
        $('#wrapper-header').removeClass('fixed');
      }*/
	  var window_top = $(window).scrollTop();
	  if(window_top == 0){
		  $('#wrapper-header').removeClass('fixed').addClass('fixed');
	  } else {
		  if (window_top > lastScrollTop){
			  $('#wrapper-header').removeClass('fixed');
		  } else {
			  $('#wrapper-header').addClass('fixed');
		  }
		  lastScrollTop = window_top;
	  }
    });
  }

  // SCROLL to object
  $body.on('click', '.p-scroll', function(e) {
    var $link = $(this).attr('href');
    $('body, html').animate({
      scrollTop: $($link).offset().top - (-70)
    }, 800);
    e.preventDefault();
  }); 

  $body.on('click', '.go-down', function(e) {
    e.preventDefault();
    var $first_block = $('.cont-box').eq(0);
    if($first_block.length > 0) {
      $('body, html').animate({
        scrollTop: $first_block.offset().top - (-10)
      }, 400);
    }
  });

  // open second ul menu slide
  $body.on('click', ".collapsed", function(e){
    $(this).toggleClass("start-collapsed");
  });

  $('#menu-second-menu').on('click', 'a', function(e){
    var url = $(this).attr('href');
    if('#' == url) {
      e.preventDefault();
    }
  });

  $('#menu-second-menu .collapsed')
    .prepend('<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="13px" height="13px" viewBox="-0.024 -0.028 13 13" enable-background="new -0.024 -0.028 13 13" xml:space="preserve" class="plus">' +
             '<path fill="#E66E6E" d="M6.504,12.996C2.9,12.998-0.002,10.093,0,6.49C0.003,2.902,2.903,0.005,6.496,0  C10.095-0.005,13.005,2.908,13,6.509C12.996,10.097,10.092,12.996,6.504,12.996z M7.585,5.412c0-0.725,0.004-1.41-0.002-2.095  C7.58,2.93,7.363,2.713,6.98,2.704C6.674,2.698,6.367,2.7,6.06,2.703C5.627,2.708,5.418,2.92,5.416,3.358  C5.414,3.953,5.415,5.315,5.415,5.412c-0.72,0-1.396-0.004-2.073,0.001C2.92,5.416,2.712,5.628,2.707,6.048  c-0.003,0.252,0,0.505-0.001,0.758c0,0.607,0.168,0.777,0.766,0.777c0.638,0,1.276,0,1.943,0c0,0.115-0.003,1.481,0.001,2.078  c0.004,0.404,0.215,0.621,0.615,0.629c0.315,0.008,0.631,0.009,0.948,0c0.384-0.01,0.599-0.229,0.604-0.613  c0.006-0.451,0.002-1.834,0.002-2.094c0.692,0,1.351,0.002,2.008,0c0.504,0,0.697-0.197,0.701-0.708c0-0.244,0-0.487,0-0.731  c-0.002-0.547-0.186-0.732-0.732-0.732C8.914,5.411,8.267,5.412,7.585,5.412z"/>' +
             '</svg>' +
             '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="13px" height="13px" viewBox="-0.024 -0.028 13 13" enable-background="new -0.024 -0.028 13 13" xml:space="preserve" class="minus">' +
             '<path fill="#E66E6E" d="M6.492,12.997C2.893,12.995-0.008,10.083,0,6.479C0.008,2.893,2.917-0.003,6.508,0  C10.109,0.004,13.011,2.919,13,6.521C12.99,10.108,10.083,12.999,6.492,12.997z M9.638,7.585c0.438-0.002,0.648-0.211,0.654-0.646  c0.004-0.307,0.008-0.614,0-0.92c-0.01-0.387-0.224-0.593-0.612-0.604c-0.146-0.004-4.349-0.002-6.306,0  c-0.458,0-0.664,0.207-0.667,0.658c-0.002,0.271-0.001,0.542,0,0.812c0.002,0.509,0.195,0.701,0.707,0.701  C4.442,7.587,8.591,7.587,9.638,7.585z"/>' +
             '</svg>');

  // scroll to link in menu
  $body.on('click', link, function(e) {
    var target = $(this).attr('href');
    if(target.length > 0 && target.indexOf('#')) {
      target = target.substr(target.indexOf('#'));
      var element = $(target);
      if(element.length > 0) {
        e.preventDefault();
        $('body, html').animate({scrollTop: element.offset().top}, 400);
      }
    }
  });

  // Accordion
  if ($('.accordion')) {
    $body.on('hidden.bs.collapse', '.accordion', toggleChevron);
    $body.on('shown.bs.collapse', '.accordion', toggleChevron);
  }; 

  // Contact Us form
  $('#contactform').validate({
    rules: {
      'uname': {
        required: true
      },
      'email': {
        required: true
      },
      'comment': {
        required: true
      }
    },
    submitHandler: function(form) {
      var ajax_url = window.outdoor.ajax_url || '';
      if( ajax_url == '' ) {
        console.error('Error: Ajax url');
        return;
      }
      var $this_form = $(form),
          args = $this_form.serialize(),
          $form_message = $this_form.find('.form-message');

      $.post(ajax_url, {
        action: 'outdoor_send_contact_form',
        args: args
      }, function(response){
        response = $.parseJSON(response);
        if('success' === response.status) {
          $form_message.text(response.text).css({
            opacity: 1
          }).show();
          setTimeout(function(){
            $form_message.animate({
              opacity: 0
            }, 2000, function(){
              $(this).hide();
            });
          }, 3000);
        } else if('fail' === response.status && response.error != '') {
          console.log(response.error);
        }
      });
      return false;
    },
    invalidHandler: function(event, validator){
      var errors = validator.numberOfInvalids();

    }
  });

  // Comment form validate
  $('#commentform').validate({
    rules: {
      'author': {
        required: true
      },
      'email': {
        required: true
      },
      'comment': {
        required: true
      }
    }
  });

  // Newsletters form
  $('#newsletters-form').validate({
    rules: {
      'newsletters-email': {
        required: true,
        email: true
      }
    },
    submitHandler: function(form) {
      var ajax_url = window.outdoor.ajax_url || '';
      if( ajax_url == '' ) {
        console.error('Error: Ajax url');
        return;
      }
      var $this_form = $(form),
        args = $this_form.serialize(),
        $form_message = $this_form.find('.form-message'),
        $form_error = $this_form.find('.form-error');

      $.post(ajax_url, {
        action: 'outdoor_newsletter_form',
        args: args
      }, function(response){
        response = $.parseJSON(response);
        if('success' === response.status) {
          $form_message.text(response.text).css({
            opacity: 1
          }).show();
          setTimeout(function(){
            $form_message.animate({
              opacity: 0
            }, 2000, function(){
              $(this).hide();
            });
          }, 3000);
        } else if('fail' === response.status && response.error != '') {
          console.log(response.error);
          $form_error.text(response.error).css({
            opacity: 1
          }).show();
          setTimeout(function(){
            $form_error.animate({
              opacity: 0
            }, 2000, function(){
              $(this).hide();
            });
          }, 3000);
        }
      });
      return false;
    },
    invalidHandler: function(event, validator){
      var errors = validator.numberOfInvalids();
    }
  });

  //play-video
  $body.on('click', '.play-video', function (e) {
    e.preventDefault();
    var videoContainer = $('.video-block'),
        video_url = $(this).data('video-url');
    if(video_url != '') {
      videoContainer.prepend('<iframe src="' + video_url + '" width="500" height="281" class="stretch-both" frameborder="0" webkitallowfullscreen="webkitallowfullscreen" mozallowfullscreen="mozallowfullscreen" allowfullscreen="allowfullscreen"></iframe>');
      videoContainer.fadeIn(300);
    }


  });
  // Close Video
  $body.on('click', '.close-video', function (e) {
      $('.video-block').fadeOut(400, function () {
          $("iframe", this).remove().fadeOut(300);
      });
  });

  $body.on('click', '.a-sliders-close', function() {
    console.log('close');
    $('.sliders .container').hide();
    destroy('#albom');
    $(".sliders").css('min-height', 0);
    setTimeout(function(){
      $('body, html').animate({
        scrollTop: $('#back-top').offset().top - (200)
      }, 250);
    },0);
      
    return false;
  });

  // EVENT HANDLER ON SCROLL
  var refElement, thisTop, scrollPos;

  $windowBrowser.on('scroll', function() {
    scrollPos = $windowBrowser.scrollTop() + 1;

    // menu waypoint
    $(link).each(function(i) {
      var $this  = $(this),
          target = $this.attr('href');

      if(target.length > 0 && target.indexOf('#')) {
        target = target.substr(target.indexOf('#'));
        refElement = $(target);
        if(refElement.length > 0) {
          thisTop = refElement.position().top;
          if (thisTop <= scrollPos && (thisTop + refElement.innerHeight()) > scrollPos) {
            $(link).removeClass('current');
            $this.addClass('current');
          } else $this.removeClass('current');
        }
      }
    });

  });

  // END EVENT HANDLERS - 
  // --------------------

  
  /*----------------- Add Animate CSS  -----------------*/
  // function animations() {
    // Calculating The Browser Scrollbar Width
    var parent, child, scrollWidth, bodyWidth;

  if (scrollWidth === undefined) {
    parent = $('<div style="width: 50px; height: 50px; overflow: auto"><div/></div>').appendTo('body');
    child = parent.children();
    scrollWidth = child.innerWidth() - child.height(99).innerWidth();
    parent.remove();
  }

  $('.appear-block').each(function() {
    var $this = $(this);
    $this.addClass('appear-animation');

    if(!$body.hasClass('no-csstransitions') && ($body.width() + scrollWidth) > 767) {
      $this.appear(function() {
      var delay = ($this.attr('data-appear-animation-delay') ? $this.attr('data-appear-animation-delay') : 1);

        if(delay > 1) $this.css('animation-delay', delay + 'ms');
        $this.addClass($this.attr('data-appear-animation'));

        setTimeout(function() {
          $this.addClass('appear-animation-visible');
        }, delay);
      }, {accX: 0, accY: -150});
    } else {
      $this.addClass('appear-animation-visible');
    }
  });
    
  /* Animation Progress Bars */
  $('.progress').each(function() {
  var $this = $(this);

  $this.appear(function() {
    var delay = ($this.attr('data-appear-animation-delay') ? $this.attr('data-appear-animation-delay') : 1);

    if(delay > 1) $this.css('animation-delay', delay + 'ms');
    
    $this.find('.progress-bar').addClass($this.attr('data-appear-animation'));

    setTimeout(function() {
      $this.find('.progress-bar').animate({
        width: $this.attr('data-appear-progress-animation')
      }, 500, 'easeInCirc', function() {
        $this.find('.progress-bar').animate({
        textIndent: 10
        }, 1500, 'easeOutBounce');
      });
      }, delay);
    }, {accX: 0, accY: -50});
  });

  /* -------------------- jqplot Chart 1 ------------------- */
  if($("#chart1").length>0) {
    
    var data = [
      ['One', 25],['Two', 15], ['Three', 16], 
      ['Four', 17],['Five', 12], ['Six', 15]
  ];
  var plot1 = jQuery.jqplot ('chart1', [data], { 
    seriesDefaults: {
      shadow: false,
      renderer:$.jqplot.DonutRenderer,
        rendererOptions: {
        startAngle: -90,
        diameter: 140,
        dataLabelPositionFactor: 0.6,
        innerDiameter: 28,
        showDataLabels: true
      }
    },
    grid:{
      background:'transparent',
      borderColor:'transparent',
      shadow:false,
      drawBorder:false,
      shadowColor:'transparent'
    },
    seriesColors: [
      "#3f4bb8",
      "#e13c4c",
      "#ff8137",
      "#ffbb42",
      "#20bdd0",
      "#2b70bf",
      "#f25463",
      "#f1a114",
      "#f5707d",
      "#ffd07d",
      "#4c7737"],
    legend: { 
      show:false, 
      location: 'e'
    }
  });
  $windowBrowser.resize(function() {
    plot1.replot({
      resetAxes: true
    });
  });
  }

  /*-------------------------------- Morris -------------------------*/
  if($("#graph").length>0) {
    new Morris.Line({
      // ID of the element in which to draw the chart.
      element: 'graph',
      // Chart data records -- each entry in this array corresponds to a point on
      // the chart.
      data: [
        {"month": "2012-10", "sales": 4000, "rents": 5000},
        {"month": "2012-09", "sales": 4000, "rents": 5500},
        {"month": "2012-08", "sales": 3300, "rents": 5100},
        {"month": "2012-07", "sales": 3300, "rents": 5150},
        {"month": "2012-06", "sales": 3100, "rents": 4800},
        {"month": "2012-05", "sales": 2900, "rents": 4100},
        {"month": "2012-04", "sales": 2300, "rents": 4600},
        {"month": "2012-03", "sales": 2300, "rents": 3500},
        {"month": "2012-02", "sales": 2700, "rents": 1700},
        {"month": "2012-01", "sales": 2000, "rents": 1000}
      ],
      // The name of the data record attribute that contains x-values.
      xkey: 'month',
      // A list of names of data record attributes that contain y-values.
      ykeys: ['sales', 'rents'],
      // Labels for the ykeys -- will be displayed when you hover over the
      // chart.
      labels: ['sales', 'rents'],
      barRatio: 0.4,
      xLabelAngle: 35,
      hideHover: 'auto',
      smooth: false,
      resize: true,
      lineColors: ['#98b025','#d45050', '#000099']
    });
    }

    if($("#hero-bar").length>0) {
    Morris.Bar({
      element: 'hero-bar',
      data: [
        {month: 'Jan.', sales: 2000, rents:2400},
        {month: 'Feb.', sales: 3000, rents:3100},
        {month: 'Mar.', sales: 3600, rents:3000},
        {month: 'Apr.', sales: 4300, rents:4100},
        {month: 'May.', sales: 3300, rents:3500},
        {month: 'Jun.', sales: 3000, rents:3800},
        {month: 'Jul.', sales: 3400, rents:2900},
        {month: 'Aug.', sales: 2900, rents:3500},
        {month: 'Sep.', sales: 4000, rents:3500},
        {month: 'Oct.', sales: 3900, rents:3400}
      ],
      xkey: 'month',
      ykeys: ['sales', 'rents'],
      labels: ['sales', 'rents'],
      barRatio: 0.4,
      xLabelAngle: 35,
      hideHover: 'auto',
      resize: true,
      lineColors: ['#98b025','#d45050', '#000099']
    });
  }

   // ----------------------------- Responsive slider -----------------------
  if($("#full-width-slider").length>0) {
    setTimeout(function(){
      $('#full-width-slider').responsiveSlides({
          auto: true,             // Boolean: Animate automatically, true or false
          speed: 1000,            // Integer: Speed of the transition, in milliseconds
          timeout: 5000,          // Integer: Time between slide transitions, in milliseconds
          pager: true,           // Boolean: Show pager, true or false
          nav: false,             // Boolean: Show navigation, true or false
          random: false,          // Boolean: Randomize the order of the slides, true or false
          pause: false,           // Boolean: Pause on hover, true or false
          pauseControls: true,    // Boolean: Pause when hovering controls, true or false
          prevText: "Previous",   // String: Text for the "previous" button
          nextText: "Next",       // String: Text for the "next" button
          maxwidth: "",           // Integer: Max-width of the slideshow, in pixels
          navContainer: "",       // Selector: Where controls should be appended to, default is after the 'ul'
          manualControls: "",     // Selector: Declare custom pager navigation
          namespace: "transparent-btns",   // String: Change the default namespace used
          before: function(){},   // Function: Before callback
          after: function(){}     // Function: After callback
      });
    },0);
  
  }

  /* ------------------- Add class if IE 11 or IE10 ------------------*/
  if ((usrBrowser.match(/MSIE 10.0/i))) {
    $body.addClass('ie10');

  } else if((usrBrowser.match(/rv:11.0/i))){
    $body.addClass('ie11');
  }

  /* ---------------------------- GOOGLE MAPS  ----------------------- */
  if($("#map-canvas").length>0) {
    initializeMap($body);
  }

  /* ------------------- height first slider ---------------------*/
  initMainSlider();
  $('.front-page #primary-banner-title, .other-style #primary-banner-title, .video-section, #full-width-slider').css( "height", $(window).height());

  /* ---------------------------- ????????????? -------------*/ 
//  var url = window.location.pathname,
//      urlRegExp = new RegExp(url.replace(/\/$/,'') + "$"); // create regexp to match current url pathname and remove trailing slash if present as it could collide with the link in navigation in case trailing slash wasn't present there
//
//  // now grab every link from the navigation
//  $('#navigation-menu a').each(function(){
//      // and test its normalized href against the url pathname regexp
//      if(urlRegExp.test(this.href.replace(/\/$/,''))){
//        $(this).addClass('active');
//      }
//  });

  /* -------------------------- STYLED SELECT  --------------------- */
  if($("select").length>0){
    $('select').styler();
  }

  /* ---------------------------- ISOTOPE  ----------------------- */
  if($(".isotope").length>0) {
    // initialize Isotope after all images have loaded
    var $container = $('.isotope').imagesLoaded(function() {
      $container.isotope({
        itemSelector: '.element-item',
        layoutMode: 'fitRows'
      });
    });
      
    // filter functions
    var itemReveal = Isotope.Item.prototype.reveal;
    Isotope.Item.prototype.reveal = function() {
      itemReveal.apply( this, arguments );
      $( this.element ).removeClass('isotope-hidden');
    };
  
    var itemHide = Isotope.Item.prototype.hide;
    Isotope.Item.prototype.hide = function() {
      itemHide.apply( this, arguments );
      $( this.element ).addClass('isotope-hidden');
    };
    
    // demo code
    $(function() {
      var $container = $('.isotope');
      $container.isotope({
        layoutMode: 'fitRows'
      });
      $('#filters').on( 'click', 'button', function() {
        var filtr = $( this ).attr('data-filter');
        $container.isotope({ filter: filtr });
      });
    });

    // change is-checked class on buttons
    $('.button-group').each( function( i, buttonGroup ) {
      var $buttonGroup = $(buttonGroup);
      $buttonGroup.on( 'click', 'button', function() {
        $buttonGroup.find('.is-checked').removeClass('is-checked');
        $(this).addClass('is-checked');
      });
    });

  }

  /*-------------------------------- myTab -------------------------*/
//  if($(".myTab").length>0){
//    $('.myTab').tabCollapse();
//  }

  /*-------------------------------- Fancy box -------------------------*/
  if($(".fancybox").length>0){
    $(".fancybox").fancybox({
      openEffect : 'none',
      closeEffect : 'none',
      helpers: {
        overlay: {
          locked: false
        }
      }
    });
  }

  /* Demo 2 */
  if($('#slider-with-blocks-1').length>0) {
    $.rsCSS3Easing.easeOutBack = 'cubic-bezier(0.175, 0.885, 0.320, 1.275)';
    $('#slider-with-blocks-1').royalSlider({
      arrowsNav: true,
      arrowsNavAutoHide: false,
      fadeinLoadedSlide: false,
      controlNavigationSpacing: 0,
      controlNavigation: 'bullets',
      blockLoop: true,
      loop: true,
      numImagesToPreload: 6,
      transitionType: 'fade',
      keyboardNavEnabled: true,
      autoScaleSlider: true, 
      block: {
        delay: 400
      },
      imageScaleMode: 'fill',
      imageAlignCenter: true
    });  
  }

  /* --------- shareCount -------------- */
  setTimeout(function() {
    shareCount();
    setTimeout(function() {
      shareCount();
    }, 2000);
  }, 1000);

  /*------- SKILLS SIRCLES --------*/
  initSkillSircles('.skill-item');

  /* ----------------------- Remove Video -----------------------*/
  if(userTouchDev) {
    $('.bg-video, .header-video').find('video').remove();
  }

  /* ------------------------- RETINA ---------------------------*/
  if( 'devicePixelRatio' in window && window.devicePixelRatio >= 2 ){
    var imgToReplace = $('img.replace-2x').get();
   
    for (var i=0,l=imgToReplace.length; i<l; i++) {
      var src = imgToReplace[i].src;
      src = src.replace(/\.(png|jpg|gif)+$/i, '@2x.$1');
      imgToReplace[i].src = src;
     
      $(imgToReplace[i]).load(function(){
        $(this).addClass('loaded');
      });
    }
  }

  /* ------------------------- Clit title ---------------------------*/
  if($('.slider-overlay').length>0) {
    titleParams();
  }

  /* -------------------- carousels ----------------------*/
  initCarousels();

  /* ---------------- Blur ------------------*/
  if(typeof($.fn.blurjs) !== 'undefined') {
    if(!userTouchDev && $body.width() >= 1023) {
      if($(".blur").length>0) {
          $('.blur .overlay').blurjs({
            source: '.blur',
            radius: 30,
            overlay: 'rgba(0, 0, 0, .2)'
          });
      }
    }
  }

  /* Add navigation for calendar widget*/
  $('.widget_calendar #prev').html('<i class="fa fa-angle-left"></i>');
  $('.widget_calendar #next').html('<i class="fa fa-angle-right"></i>');

  /* mCustomScrollbar
   ----------------------------------------------------------------------*/
  if($("#slide-menu .wrapper-slide-menu-content").length>0) {
//    $('#slide-menu .wrapper-slide-menu-content').mCustomScrollbar();
  }

  /* Disable parallax on the mobile device
  ------------------------------------------------------------------------*/
  if($body.width() < 780) {
    $('.dzsparallaxer').each(function(index, el){
      var $this = $(el),
        bg_img = $this.find('.divimage').css('background-image'),
        $new_div = $('<div class="layer" />');
      $new_div.css({
        'background-image' : bg_img
      });
      $this.after($new_div);
      $this.remove();
    });
  }

  // Smooth scrolling init
  $('html').niceScroll();

});
/*                END READY                    */
/* ------------------------------------------- */ 

/* --------------------------------------------*/
/*-------------- WINDOW LOAD ------------------*/
$windowBrowser.load(function(){
  //Background Clip Title 
   if($('.slider-overlay').length>0) { 
    titleCanvas();
  }

  /* Hide preloader
   -------------------------------------------------------------------*/
  $('.preloader').fadeOut('slow',function(){$(this).remove();});

  /* ---------------------- SOCIAL BUTTONS --------------------------*/
  if($(".social-inp").length>0) {
    var urlsoc = location.href;
    $('.shared-btn').each(function(){
      new GetShare({
        root: $(this),
        network: $(this).data('network'),
        button: {text: ''},
        share: {
          url: urlsoc,
          message: 'Link to '+urlsoc+' '
        }
      });
    });
  }

});
/* ---------- END WINDOW LOAD ---------------- */ 
/* --------------------------------------------*/

/* --------------------------------------------*/
/* --------------- RESIZE ---------------------*/
$windowBrowser.on('resize', function() {
  /*------ height first slider ----------------*/
  // initMainSlider();
  $('.front-page #primary-banner-title, .other-style #primary-banner-title, .video-section, #full-width-slider').css( "height", $(window).height());

  /* ----- Background Clip Title -------------*/
  if($('.slider-overlay').length>0) {
    titleParams();
    titleCanvas();
  }
  
  // re-init carousels 
  initCarousels();
  // Google maps
  initializeMap($body);

});
/* ------------- END RESIZE ---------------- */
/* ----------------------------------------- */ 




/* ------------------------------------------- */
/*              FUNCTION LIST                  */

  /* --------- Background Clip Title ----------- */
  function titleParams() {
    var title = $('.title-box .title'),
        padding = $('.slider-overlay .bg-padding');
    
    if (title.attr('data-fontsize') !== undefined && title.attr('data-fontsize') !== false && title.attr('data-fontsize') !== '') {
      var fontSize = title.attr('data-fontsize');
      
      title.css('fontSize', fontSize + 'px');
      padding.css('height', fontSize * 0.16);
      
      if ($body.width() < 992 && $body.width() > 767) {
        title.css('fontSize', (fontSize * 0.57) + 'px');
        padding.css('height', fontSize * 0.57 * 0.16);
      } else if ($('body').width() < 768) {
        title.css('fontSize', (fontSize * 0.25) + 'px');
        padding.css('height', fontSize * 0.25 * 0.16);
      }
    }
    
    if (title.attr('data-fontweight') !== undefined && title.attr('data-fontweight') !== false && title.attr('data-fontweight') !== '') {
      title.css('fontWeight', title.attr('data-fontweight'));
    }
    
    if (title.attr('data-fontfamily') !== undefined && title.attr('data-fontfamily') !== false && title.attr('data-fontfamily') !== '') {
      title.css('fontFamily', title.attr('data-fontfamily'));
    }
    
    if (title.attr('data-bg') !== undefined && title.attr('data-bg') !== false && title.attr('data-bg') !== '') {
      $('.slider-overlay .slider-content .bg').css('background', title.attr('data-bg'));
    }
  }

  /* ----------------------- Accordion --------------------------- */
  function toggleChevron(e) {
    $(e.target).prev('.panel-heading')
      .find("i.indicator")
        .toggleClass('glyphicon-minus glyphicon-plus');
  }

  /* --------- shareCount -------------- */
  function shareCount() {
    var numb = $('.post-soc-icon .social-inp .getshare-counter'),
      allCount = 0;
    numb.each(function () {
      allCount = allCount + Number($(this).html());
    });
    $('.count-shared .quantity').html(allCount);
  }

  /* --------------------------------- */ 
  function titleCanvas() {
    var titleBox    = $('.title-box'),
        title       = titleBox.find('.title'),
        titleWidth  = title.width(),
        titleHeight = title.height(),
        fontSize    = 190,
        fontWeight  = 800,
        fontFamily  = '"Raleway", sans-serif',
        bg          = 'rgba(255, 255, 255, 0.85)';
      
    fontSize = parseFloat(title.css('font-size'));
    
    if (title.attr('data-fontweight') !== undefined && title.attr('data-fontweight') !== false && title.attr('data-fontweight') !== '') {
      fontWeight =  parseFloat(title.attr('data-fontweight'));
    }
    
    if (title.attr('data-fontfamily') !== undefined && title.attr('data-fontfamily') !== false && title.attr('data-fontfamily') !== '') {
      fontFamily = title.attr('data-fontfamily');
    }
    
    if (title.attr('data-bg') !== undefined && title.attr('data-bg') !== false && title.attr('data-bg') !== '') {
      bg = title.attr('data-bg');
    }

    $('.title-canvas').remove();
    
    titleBox.find('.title').after('<canvas class="title-canvas" width="' + titleWidth + '" height="' + titleHeight + '"></canvas>');
    
    var canvas = titleBox.find('.title-canvas').get(0),
      ctx = canvas.getContext("2d");

    ctx.fillStyle = bg; 
    ctx.fillRect(0,0,titleWidth,titleHeight);
    
    ctx.font = fontWeight + ' ' + fontSize + 'px ' + fontFamily;
    ctx.fillStyle = '#333';
    ctx.textAlign = 'center';

    ctx.globalCompositeOperation = 'destination-out';
    wrapText(ctx, title.text(), titleWidth / 2 , fontSize * 0.87, titleWidth, fontSize);
    title.addClass('hidden-title');
    titleBox.closest('.slider-overlay').addClass('loaded');
  }
  function wrapText(ctx, text, x, y, maxWidth, lineHeight) {
    var words = text.split(' ');
    var line = '';

    for(var n = 0; n < words.length; n++) {
      var testLine = line + words[n] + '';
      var metrics = ctx.measureText(testLine);
      var testWidth = metrics.width;
      if (testWidth > maxWidth && n > 0) {
        ctx.fillText(line, x, y);
        line = words[n] + '';
        y += lineHeight;
      }
      else {
        line = testLine;
      }
    }
    ctx.fillText(line, x, y);
  }

  /* -------------- GOOGLE MAPS ------------------------------------ */ 
  function initializeMap($body){
    var bodyW = $body.width(),
        num2, choordsMap1, choordsMap2,
        map_canvas = document.getElementById('map-canvas');

    if(null != map_canvas) {
      choordsMap1 = outdoor.map_lat || '';
      choordsMap2 = outdoor.map_lng || '';

      setTimeout(function(){
        var mapOptions = {
          zoom: 10,
          draggable: false,
          disableDefaultUI: true,
          disableDoubleClickZoom: true,

          scrollwheel: false,
          center: new google.maps.LatLng(choordsMap1, choordsMap2)
          // 41.2, -73.98
        },

        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions),
        image = outdoor.map_marker_url || '',
        myLatLng = new google.maps.LatLng(choordsMap1, choordsMap2), //num2
        beachMarker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          icon: image,
          title: ''
        });

        if(bodyW < 480) {
          map.panBy(0,-350);
        } else {
          map.panBy(-300,0);
        }

      },0);
    }
  }

  /*------- SKILLS SIRCLES --------*/
  function initSkillSircles(classElem) {
    var $skillItem = $(classElem);
    if ($skillItem) {
      $skillItem.each(function(){
        var $this = $(this),
            title,
            dataPercent = dataAttrSkills($this, 'percent', '50'),
            startcolorline = dataAttrSkills($this, 'start-color', 'transparent'),
            color = dataAttrSkills($this,'color', '#111');

        title = $this.text();
        // advanced settings
        $this.appear(function() {
          $this.easyCircleSkill({
            percent        : dataPercent,
            linesize       : 3,
            startcolorline : startcolorline,
            skillName      : title,
            colorline      : color
          });
        });    

      });
    };
  };

  function dataAttrSkills(elem, dataName, setDefault) {
    var data = elem.data(dataName),
      res= !!data ? data : setDefault;
    return res;
  }

  /* ------------------- height first slider ---------------------*/
  function initMainSlider(){
    if($(".first-page, .royalSlider").length>0) {
      $('.first-page, .royalSlider').css('height', $body.innerHeight);
    }
  }

  /* ----- element height 100% ------------- */ 
  function setFullHeight(elem){
    elem.height(document.body.clientHeight);
  }
  
  /* ------------- Carousel -----------------*/
  function initCarousels(){
    $('.carousel-box').each(function(index){
      var self = $(this),
          prevBtn = '.prev'+index,
          nextBtn = '.next'+index,
          maxItem = self.data('item-max'),
          widthItem = self.data('item-width'), 
          initCaroucel;     
      self.attr('id', 'fredsel'+index);
      $('button.prev').each(function(index){
        $(this).addClass('prev'+index);
      });
      $('button.next').each(function(index){
        $(this).addClass('next'+index);
      });

      setTimeout(function(){
        initCaroucel = $('#'+self.attr('id'));

        initCaroucel.carouFredSel({
          responsive: true,
          width: '100%',
          prev: prevBtn,
          next: nextBtn,
          scroll: {
            items: 1,
            speed: 500,
            timeoutDuration:300000},
         
          items: {
            width: widthItem,
            height: 'auto',
            visible: {
              min: 1,
              max: maxItem
            }
          },
          onCreate: function(){
            self.addClass('init');
            var max_height = 0;
            self.children().each(function(index, el){
              var $el = $(el);
              if($el.height() > max_height) max_height = $el.height();
            });
            setTimeout(function() {
              self.parent().add(self).css('height', max_height + 'px');
            }, 500);
            var top = self.find('.img-block img').height();
            self.closest('.post-slider, .posted-slider, .slider-people').find('.prev, .next').css('top', top / 2);
          }
        }).touchwipe({
            wipeLeft: function() {
              console.log('touchswipe work!!!!!!!!!');
              initCaroucel.trigger('next', 1);
            },
            wipeRight: function() {
              initCaroucel.trigger('prev', 1);
            },
            preventDefaultEvents: false
          });
        
      },0);
    });
  }

  // portfolio sliders
  function initSlider(selector) {
    
    $(selector).responsiveSlides({
      auto: false,             // Boolean: Animate automatically, true or false
      speed: 500,            // Integer: Speed of the transition, in milliseconds
      timeout: 4000,          // Integer: Time between slide transitions, in milliseconds
      pager: false,           // Boolean: Show pager, true or false
      nav: true,             // Boolean: Show navigation, true or false
      random: false,          // Boolean: Randomize the order of the slides, true or false
      pause: false,           // Boolean: Pause on hover, true or false
      pauseControls: true,    // Boolean: Pause when hovering controls, true or false
      prevText: "Previous",   // String: Text for the "previous" button
      nextText: "Next",       // String: Text for the "next" button
      maxwidth: "",           // Integer: Max-width of the slideshow, in pixels
      navContainer: "",       // Selector: Where controls should be appended to, default is after the 'ul'
      manualControls: "",     // Selector: Declare custom pager navigation
      namespace: "rslides",   // String: Change the default namespace used
      before: function(){},   // Function: Before callback
      after: function(){}     // Function: After callback
    });
  }
  
  function buildSlider(data) {

    var html = false;

    if (data) {
      html = '<h4 class="album-name text-center">'+data.title+'</h4>';
      
      // while photos
      if($(data.photos).size()) {
        html += '<div class="wrap-slider"><div class="photos-container">';
        $.each(data.photos, function(i, photo){
          html += '<div><img class="replace-2xx" src="'+photo+'" alt="'+data.title+'" /></div>';
        });
        html += '</div></div>';
      }
      
      // Add info about alboms
      html += '<div class="additional-info row">\
                <div class="col-md-7">\
                  <div class="heading">Description</div>\
                  <div class="description">'+data.description+'</div>\
                </div>\
                <div class="col-md-5">\
                  <div class="heading">Info</div>\
                  <div class="adinfo-category"><strong>categories: </strong>'+data.category+'</div>\
                  <div class="client"><strong>client: </strong>'+data.client+'</div>\
                  <div class="link"><strong>link: </strong><a href="'+data.url+'">VISIT SITE</a></div>\
                </div>\
              </div>';
    }
    
    return html;
  }
  
  function getNextID(current_element_id) {
    var nextAlbomID = false;
    if ((cache.length - 1) != current_element_id) {
      nextAlbomID = cache[current_element_id + 1];
    } else {
      nextAlbomID = cache[0];
    }
    return nextAlbomID;
  }
    
  function getPrevID(current_element_id) {
    var prevAlbomID = false;
    if (current_element_id != 0) {
      prevAlbomID = cache[current_element_id - 1];
    } else {
      prevAlbomID = cache[cache.length - 1];
    }
    return prevAlbomID;
  }
  
  function getJsonArray(elements, callback_success, callback_error) {
    $.getJSON('data.json', function(data) {     
      for (var index = 0; index < elements.length; ++index) {
        // buildAlbumSlider(elements[index], data[elements[index]]);
      }
      if (callback_success && typeof(callback_success) === "function") {
        callback_success(data);
      }
    });
  }

  function getJsonID(id, callback_success, callback_error) {
    var ajax_url = window.outdoor.ajax_url || '';
    if( ajax_url == '' ) {
      console.error('Error: Ajax url');
      return;
    }

    $.post(ajax_url, {
      action: 'outdoor_portfolio_item',
      item_id: id
    }, function(data){
      if(data <= 0) {
        console.log('Error load portfolio data');
        return;
      }
      if (callback_success && typeof(callback_success) === "function") {
        callback_success($.parseJSON(data));
      }
    });

  }

  function destroy(selector){
    $(selector).html("");
  }
  
  function create(current_id, next_id, prev_id) {
    /* Fix height */
    $(".sliders").css('min-height', slider_container_height);   
    $('.sliders .sliders-preloader').removeClass('loaded');   
    $('.sliders .container').fadeOut({
      complete: function() {

        getJsonID(current_id, function(data){
          var html = buildSlider(data);

          $(".sliders a.next").data('albomid', next_id);
          $(".sliders a.prev").data('albomid', prev_id);
          
          $("#albom").html(html);
              
          initSlider('.photos-container');
              
          $('.sliders .container').fadeIn({
            easing: 'swing',
            complete: function() {
              slider_container_height = $(".sliders .row .container").height();
              $('.sliders .sliders-preloader').addClass('loaded');
            }
          });
        });
      }
    });
  }

})(jQuery); 