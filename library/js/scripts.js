/*
 * Bones Scripts File
 * Author: Eddie Machado
 *
 * This file should contain any js scripts you want to add to the site.
 * Instead of calling it in the header or throwing it inside wp_head()
 * this file will be called automatically in the footer so as not to
 * slow the page load.
 *
 * There are a lot of example functions and tools in here. If you don't
 * need any of it, just remove it. They are meant to be helpers and are
 * not required. It's your world baby, you can do whatever you want.
*/


/*
 * Get Viewport Dimensions
 * returns object with viewport dimensions to match css in width and height properties
 * ( source: http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript )
*/
function updateViewportDimensions() {
	var w=window,d=document,e=d.documentElement,g=d.getElementsByTagName('body')[0],x=w.innerWidth||e.clientWidth||g.clientWidth,y=w.innerHeight||e.clientHeight||g.clientHeight;
	return { width:x,height:y };
}
// setting the viewport width
var viewport = updateViewportDimensions();


/*
 * Throttle Resize-triggered Events
 * Wrap your actions in this function to throttle the frequency of firing them off, for better performance, esp. on mobile.
 * ( source: http://stackoverflow.com/questions/2854407/javascript-jquery-window-resize-how-to-fire-after-the-resize-is-completed )
*/
var waitForFinalEvent = (function () {
	var timers = {};
	return function (callback, ms, uniqueId) {
		if (!uniqueId) { uniqueId = "Don't call this twice without a uniqueId"; }
		if (timers[uniqueId]) { clearTimeout (timers[uniqueId]); }
		timers[uniqueId] = setTimeout(callback, ms);
	};
})();

// how long to wait before deciding the resize has stopped, in ms. Around 50-100 should work ok.
var timeToWaitForLast = 100;



function loadGravatars() {
	// set the viewport using the function above
	viewport = updateViewportDimensions();
	// if the viewport is tablet or larger, we load in the gravatars
	if (viewport.width >= 768) {
		jQuery('.comment img[data-gravatar]').each(function(){
			jQuery(this).attr('src',jQuery(this).attr('data-gravatar'));
		});
	}
} // end function


/*
 * Put all your regular jQuery in here.
*/
jQuery(document).ready(function($) {
	var win = $(window);
	var html = $('html');
	var body = $('body');
	
	// check what page we're on
	if (typeof isSingleWork === "undefined") var isSingleWork = body.hasClass('single-works');
	
	// Hide wp admin bar
	$('#wpadminbar').addClass('hidden').append('<div class="wpadminbar-activator"></div>').hover(
		function() {
			$(this).removeClass('hidden');
		},
		function() {
			$(this).addClass('hidden');
		}
	);
	
	win.resize(function() {
		waitForFinalEvent( function() {
			mobileDeviceBodyClass();
			checkSingleWorkHeight();
		}, timeToWaitForLast, 'resizeWindow');
	});

	// Mobile device classes
	function mobileDeviceType() {
		if (win.width() > 1024) {
			return false;
		} else if (win.width() < 768) {
			return 'mobile';
		} else {
			return 'tablet';
		}
	}
	function mobileDeviceBodyClass() {
		if (mobileDeviceType() == 'mobile') {
			body.addClass('mobile').removeClass('tablet');
		} else if (mobileDeviceType() == 'tablet') {
			body.addClass('tablet').removeClass('mobile');
		} else {
			body.removeClass('mobile tablet');
		}
	}
	mobileDeviceBodyClass();
	
	// function for Single Works page to make sure description text isn't obscured if gallery area is too small
	function checkSingleWorkHeight() {
		var workDesc = $('.WORK_DESCRIPTION');
		var workContain = $('.WORK_CONTAINER');		
		if ( workDesc.height() >= workContain.height() || win.height() < (parseInt(workDesc.height()) + parseInt($('.HEADER').height()) + parseInt(workContain.css('padding-top'))) ) {
			body.addClass('height-limited');
		} else {
			body.removeClass('height-limited');
		}
	}
	
	// Control mobile main nav
	$('.TRIGGER_NAV').click(function(e) {
		e.preventDefault();
		if ($(this).hasClass('active')) {
			setTimeout(function() {
				html.removeClass('mobile-nav-active');
			}, 375);
		} else {
			html.addClass('mobile-nav-active');
		}
		$(this).add('.MAIN_NAV').toggleClass('active');
	});
	
	$('.MAIN_NAV').on('click','a',function(e) {
		if (mobileDeviceType()) {
			$('.TRIGGER_NAV').click();
		}
	});
	
	if (isSingleWork) {
		var galleryImgSet = $('.WORK_GALLERY img');
		var galleryImgCount = galleryImgSet.length;
		var loadedImgCount = 0;
		function allImagesLoaded() {
			if (loadedImgCount == galleryImgCount) {
				checkSingleWorkHeight();
			}
		}
		allImagesLoaded(); // run this once just in case there are no images
		galleryImgSet.each(function() {
			var thisImg = new Image();
			thisImg.onload = function() {
				loadedImgCount++;
				allImagesLoaded();
			}
			thisImg.src = $(this).attr('src');
		});
	}

	/*
	* Let's fire off the gravatar function
	* You can remove this if you don't need it
	*/
	//loadGravatars();


}); /* end of as page load scripts */
