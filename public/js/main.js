//Slider
$(window).on('load', function() {
    $('#slider').nivoSlider({
        effect: 'sliceDown', // Specify sets like: 'fold,fade,sliceDown'
        slices: 15, // For slice animations
        boxCols: 3, // For box animations
        boxRows: 6, // For box animations
        animSpeed: 500, // Slide transition speed
        pauseTime: 4000, // How long each slide will show
        startSlide: 0, // Set starting Slide (0 index)
        directionNav: false, // Next & Prev navigation
        controlNav: false, // 1,2,3... navigation
        controlNavThumbs: false, // Use thumbnails for Control Nav
        pauseOnHover: false, // Stop animation while hovering
        manualAdvance: false, // Force manual transitions
        randomStart: false, // Start on a random slide
    });
});

//header-fixed
$( window ).scroll(function() {
	var sticky = $('body'),
		scroll = $(window).scrollTop();
	if (scroll >= 100) sticky.addClass('header-fixed');
	else sticky.removeClass('header-fixed');
});

$(document).ready(function($) {
    //parallax
    $('.parallax-window').parallax({ imageSrc: 'images/production_pic.jpg' });
    //fancybox
    $("[data-fancybox]").fancybox({
		buttons : [
        //'slideShow',
        //'fullScreen',
        //'thumbs',
        //'share',
        //'download',
        //'zoom',
        'close'
    	]
	});
	//gototop
	$('.gototop').click(function(event) {
		event.preventDefault();
		$('html,body').animate({
			scrollTop:0},
			700);
	});
	//AOS
	AOS.init({
		easing: 'ease-out-back',
		duration: 3000
	});
	//scrollbtn
    $('.btn-scroll').click(function () {
        var t = $(this).attr('href');
        $.scrollTo(t, 500);
        return false;
    });
    //aside
    $('.open-btn').click(function(event) {
    	$('body').toggleClass('open');
    });
});
