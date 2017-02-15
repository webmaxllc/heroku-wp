
jQuery(function($) {

	'use strict',



	  //Window Loaded Handler

  $(window).load(function(){'use strict';
		 $(".loader").fadeOut("slow");
		 
  });

	if($('#wpadminbar').length > 0){
		$('#main-navigation').addClass("admin_menu_top");
		$('.main-button').addClass("admin_menu_top");
	}
	
   	
	 
  
  // ========================================================================= 
	//	Back to Top
	// ========================================================================= 
	 
	if ($('.go-top').length) {
    var scrollTrigger = 100, // px
        backToTop = function () {
            var scrollTop = $(window).scrollTop();
            if (scrollTop > scrollTrigger) {
                $('.go-top').addClass('show');
            } else {
                $('.go-top').removeClass('show');
            }
        };
    backToTop();
    $('.go-top').on('click', function (e) {
        e.preventDefault();
        $('html,body').animate({
            scrollTop: 0
        }, 700);
    });
}
  
  
//Contact Us
  $("#btn_submit").click(function() { 
        //get input field values
        var user_name       = $('input[name=name]').val(); 
        var user_email      = $('input[name=email]').val();
		var user_message    = $('textarea[name=message]').val();
        
        //simple validation at client's end
        var proceed = true;
        if(user_name==""){ 
            proceed = false;
        }
        if(user_email==""){ 
            proceed = false;
        }
		if(user_message=="") {  
            proceed = false;
        }

        //everything looks good! proceed...
        if(proceed) 
        {
            //data to be sent to server
            post_data = {'userName':user_name, 'userEmail':user_email, 'userMessage':user_message};
            
            //Ajax post data to server
            $.post('contact_me.php', post_data, function(response){  

                //load json data from server and output message     
				if(response.type == 'error')
				{
					output = '<div class="alert-danger">'+response.text+'</div>';
				}else{
				    output = '<div class="alert-success">'+response.text+'</div>';
					
					//reset values in all input fields
					$('.form-inline input').val(''); 
					$('.form-inline textarea').val(''); 
				}
				
				$("#result").hide().html(output).slideDown();
            }, 'json');
			
        }
    });
    
    //reset previously set border colors and hide all message on .keyup()
    $(".form-inline input, .form-inline textarea").keyup(function() { 
        $("#result").slideUp();
    });

  

//Change Diffrent Logos on Nav
	if($('#navigation').hasClass('enable_affix') == false){
		jQuery(window).scroll(function() {
			if (jQuery(window).scrollTop() >= 25) {
				jQuery(".logo > img").attr("src", bizone_params.url_logo);
			}
			else {
				jQuery(".logo > img").attr("src", bizone_params.url_logo_white);
			}
		});
	}

   

// Scroll One Page Menu
  $('a.page-scroll, .cbp-spmenu a').on('click', function(event){
	  var $anchor = $(this);
		  if($anchor.attr('href').length > 0 && $anchor.attr('href') != '#'){
			  var res = $anchor.attr('href').split("#");
			  if(res[1].length>0){
				  if( $('body').find('#'+res[1]).length > 0 ){

					  $('html, body').stop().animate({
						  scrollTop: $('#'+res[1]).offset().top
					  }, 1200, 'easeInOutExpo');
					  event.preventDefault();;

					  $('#navigation').affix({offset: {top: 50} });
					  return false;
				  }
			  }
		  }
   });

	var home_url = window.location.href;
	if(home_url.length > 0){
		var res = home_url.split("#");
		if(res[1] !=  null){
			$(window).load(function(){'use strict';
				setTimeout(function(){
					if( $('body').find('#'+res[1]).length > 0 ){

						$('html, body').stop().animate({
							scrollTop: $('#'+res[1]).offset().top
						}, 1200, 'easeInOutExpo');

						$('#navigation').affix({offset: {top: 50} });
						$(window).trigger('scroll');
					}
				},500);
			});
		}
	}

	var nav=$('.navbar-nav');
	var sections=$('.bravo_container');
	$(window).on('scroll', function () {
		backToTop();
		var cur_pos = $(this).scrollTop();
		sections.each(function() {
			var nav_height=jQuery('.navbar-nav').height();
			var height_wpadminbar = 0;
			if($('#wpadminbar').length >0){
				height_wpadminbar = $('#wpadminbar').height();
			}
			var top = $(this).offset().top - nav_height - height_wpadminbar,
				bottom = top + $(this).outerHeight();
			var id=$(this).find('div:first-child').attr('id');
			if(!id) {
				id=$(this).find('section:first-child').attr('id');
			}
			if(!id) {
				return;
			}
			if (cur_pos >= top && cur_pos <= bottom) {
				find_rs=nav.find('a[href$="#'+id+'"]');
				if(find_rs.length)
				{
					nav.find('li').removeClass('active');
					find_rs.closest('li').addClass('active');
				}else{
					nav.find('li').removeClass('active');
				}
			}
		});
	});



//Facts Counters Home Page
	 $(".number-counters").appear(function () {
		$(".number-counters [data-to]").each(function () {
		  var e = $(this).attr("data-to");
		  $(this).delay(6e3).countTo({
			 from: 50,
			 to: e,
			 speed: 3e3,
			 refreshInterval: 50
		  })
		})
	 });
		  
	 
	
 //FOr Circular Progress show
	 $('.some').appear(function () {
		 $('.myStat2').circliful() 
	 });   
	 

  
//For Testinomial 
	$("#testinomial-slider").owlCarousel({
		  autoPlay : true,
		  navigation : true,
		  slideSpeed : 250,
		  pagination : false,
		  navigationText :["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
		  singleItem:true
	
	 });

  
//For Publication Section(Home Page)
	$('.publication-slider').each(function(){
		$(this).owlCarousel({
			autoPlay: true,
			pagination : false,
			navigationText :["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
			navigation : true,
			items : 3,
			itemsDesktop : [1199,3],
			itemsDesktopSmall : [979,3]

		});
	});

  //Paralax Page Slider
	var owl = $(".paralax-slider");
	owl.each(function(){
		$(this).owlCarousel({
			autoPlay: 3000,
			navigation : false,
			singleItem : true,
		});
	});

    
  
	  // portfolio filtering
    $(".project-wrapper").mixItUp();
	 
	 
	 
 // Popup
   $(".fancybox").fancybox({
		openEffect : 'fade',
		closeClick : true,

    });
	 //Video Popup
	 $('.fancybox-media').fancybox({
		openEffect  : 'fade',
		closeEffect : 'none',
		helpers : {
			media : {}
		}
	});
	
	
	//Push Menu on click
	$('.toggle-menu').jPushMenu();
	  $(document).on('click', function () {
        $('.cbp-spmenu-right').removeClass('menu-open');
		  setTimeout(function(){
			  $(window).trigger('resize');
		  },500)
    });
    $('#menu-toggle').on('click', function (e) {
        e.stopPropagation();
        $('.cbp-spmenu-right').toggleClass('menu-open');
		setTimeout(function(){
			$(window).trigger('resize');
		},500)
    });
    $('.cbp-spmenu-right').on('click', function (e) {
        e.stopPropagation();
		setTimeout(function(){
			$(window).trigger('resize');
		},500)
    });

//Parallax effects
$('#bg-paralax ').parallax("50%", 0.3);
$('#testinomial').parallax("50%", 0.2);
$('.text-rotator').parallax("50%", 0.2);


	 
		  //Initiat WOW JS
		 new WOW().init(); 
		 
  
  });
 if(screen.width <720 ){ 
 jQuery('div, img, input, textarea, button, a').removeClass('wow'); // to remove transition
 }