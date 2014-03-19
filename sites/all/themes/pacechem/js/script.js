/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */

// JavaScript should be made compatible with libraries other than jQuery by
// wrapping it with an "anonymous closure". See:
// - https://drupal.org/node/1446420
// - http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth
(function ($, Drupal, window, document, undefined) {

    $(document).ready(function(){


		// ---------------------
		// GLOBAL SCRIPTS
		// ---------------------
		
		// Define Global Mobile
		window.isMobile = false;
		window.deviceHasChanged = false;
		LAYOUT.checkMobile;
		
		// Define if on mobile (based on CCS media Queries : Device < 960px wide)
		var resizeTimer;
		LAYOUT.timerResize();
		$(window).resize(function() {
			clearTimeout(resizeTimer);
			resizeTimer = setTimeout(function() { LAYOUT.timerResize(); }, 100);
		});
		
		// Wait before images are loaded to launch the first Timer Resize Script
		$('#main').waitForImages(function() {
			LAYOUT.timerResize();
		});
		
		// Open external links in a new window
		$('a[rel*=external]').click(function(){
			window.open($(this).attr('href'));
			return false; 
		});
		
		// LOGIN PANEL
		$('#login_toggle a.login').click( function(){
			if($(this).hasClass('open')){
				$(this).removeClass('open');
				$(this).addClass('close');
				if($('body').hasClass('forgot-open')){
					$('body').removeClass('forgot-open');
					setTimeout(function (){
						$('body').addClass('login-open');
					}, 350);
				}else{
					$('body').addClass('login-open');
				}
			} else{
				$(this).addClass('open');
				$(this).removeClass('close');
				$('body').removeClass('login-open');
			}
			return false;
		});
		$('#login .item-list a').click( function(){
			$('body').removeClass('login-open');
			$('#login_toggle a').removeClass('close');
			$('#login_toggle a').addClass('open');
			setTimeout(function (){
				$('body').addClass('forgot-open');
			}, 350);
			$.ajax({
				type: 'GET',
				url: $(this).attr('href')+' #user-pass',
				data: { response_type: 'ajax' },
				success: function(html) {
					$('#forgot-password .load').removeClass('loading').html(html);
				}
			});
			return false
		});
		$('a.closex').click( function(){
			$('#login_toggle a.login').addClass('open').removeClass('close');
			$('body').removeClass('login-open').removeClass('forgot-open');
		});
		
		// Call fitvids()
		if($('.fitvids').length > 0){
			$('.fitvids').fitVids();
		}
		
		// Wrap rows	
		LAYOUT.wrapRows();
		$(window).resize(function() {
			$('.grid-third .row > .grid').unwrap();
			LAYOUT.wrapRows();
		})
		
		

		// ------------------------
		// MOBILE SPECIFIC
		// ------------------------
		
		// Add class for mobile dropdowns
		$('.nav div > ul.menu > li').has('ul').addClass('dropdown');
		$('.nav ul.menu li.dropdown > a').removeAttr('href');
		LAYOUT.dropDowns();
		
		// Click on Mobile Nav Toggle
		$('.mobile_toggle a').click(function(){
			nav = $(this).parent().attr('id');
			MOBILE.toggleNav($(this), $('.'+nav));
			return false;
		});
		
		if(window.isMobile){
			// Enable mobile submenu action
			MOBILE.subs();
		}

        
        
    }); // END DOCUMENT READY
	
	

    // ---------------------
	// LAYOUT
	// ---------------------
	
    var LAYOUT = {};
    LAYOUT.timerResize = function(){
        
        // Define if mobile
        this.checkMobile();

		// Enable functions
        if(window.isMobile){
            MOBILE.removeSubs();
			MOBILE.subs();
			LAYOUT.dropDowns();
        }

        // Display navigation if not mobile
        if(!window.isMobile){
            MOBILE.showNav();
			MOBILE.removeSubs();
			LAYOUT.dropDowns();
        }
    };
	
    LAYOUT.checkMobile = function (){
        // Define if on mobile (based on CCS media Queries : Device < 800px wide)
        if ( $("#main").css("position") === 'relative') {
			if( window.isMobile ){
                window.deviceHasChanged = false;
            }else{
               window.deviceHasChanged = true; 
               window.isMobile = true;
			   MOBILE.hideNav();
            }  
        }else{
            if( !window.isMobile ){
                window.deviceHasChanged = false;
            }else{
                window.deviceHasChanged = true;
                window.isMobile = false;
				MOBILE.showNav();
            }
        }
    };
	
	// Click on .dropdown touch screen
	LAYOUT.dropDowns = function (){
		if(!window.isMobile){
			$('.nav ul.menu li.dropdown > a').click( function(){
				ul = $(this).next();
				if(ul.is(':visible')){
					ul.hide();
				}else{
					ul.show();
				}
			}).hover( function(){
				ul = $(this).next();
				ul.removeAttr('style');
			});
		}else{
			$('.nav ul.menu li.dropdown > a').unbind('hover');
		}
	}
	
	// Wraprows for grid styling
	LAYOUT.wrapRows = function(){
		winW = $(window).width();
		blocks = 3;
		if(winW <= 800){
			blocks = 2;
		}
		if(winW <= 600){
			blocks = 1;
		}
		$('.grid-third:not(.view-news)').each( function(){
			var divs = $(this).find('.grid');
			for(var i = 0; i < divs.length; i+=blocks) {
			  divs.slice(i, i+blocks).wrapAll('<div class="row clearfix"></div>');
			}
		})
	}

    
    // ---------------------
	// MOBILE
	// ---------------------
	
    var MOBILE = {};
	MOBILE.subs = function(){
		$('.nav ul.menu li.dropdown > a').click( function(){
			$(this).next().slideToggle('fast');
			if($(this).hasClass('open')){
				$(this).removeClass('open');
			}else{
				$(this).addClass('open');
			}
			return false;
		});
	};
	MOBILE.removeSubs = function(){
		$('.nav ul.menu li.dropdown > a').removeClass('open').unbind('click');
		if(!window.isMobile){
			$('.nav ul.menu li.dropdown > ul').removeAttr('style');
		}
	}
    MOBILE.toggleNav = function (button, nav){
		id = button.parent().attr('id');
        if (button.hasClass('open')){
            button.addClass('close');
			button.removeClass('open');
			nav.slideDown("fast");
        }else{
			button.addClass('open');
			button.removeClass('close');
            nav.slideUp("fast"); 
        }
		switch(id){
			case 'nav_toggle':
				$('#search_toggle a').removeClass('close');
				$('#search_toggle a').addClass('open');
				$('.search_toggle').slideUp("fast");
			break;
			case 'search_toggle':
				$('#nav_toggle a').removeClass('close');
				$('#nav_toggle a').addClass('open');
				$('.nav_toggle').slideUp("fast");
			break;
		}
    };
    MOBILE.showNav = function (button, nav){
		$('.mobile_ui').show();
        $('.mobile_toggle a').removeClass('close');
		$('.mobile_toggle a').addClass('open');
    };
    MOBILE.hideNav = function (button, nav){
		$('.mobile_ui').hide();
		$('.mobile_toggle a').removeClass('close');
		$('.mobile_toggle a').addClass('open');
    };

    
})(jQuery, Drupal, this, this.document);
