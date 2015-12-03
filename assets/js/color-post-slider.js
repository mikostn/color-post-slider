jQuery(document).ready(function($) {
	// First remove all opened, if any...
	$('.color, .colorPost, .colorPosts, .colorPostSlider').removeClass('opened');

	// set colors height to match slider
	// $(window).on("resize", repositionDivOnResize)
	$('.color, .colorPost, .colorPosts').height($('.colorPostSlider').height());

	$('.color, .colorPost').click(function() {
		// get clicked color slide
		$colorSlide = $('[data-color='+$(this).data('color')+']');
		// toggle clicked slide state
		$colorSlide.toggleClass('opened');
		// is anything opened?
		$ifOpened = $('.color, .colorPost').hasClass('opened');
		// close all other slides if any opend
		if($ifOpened){
			$colorSlide.siblings().removeClass('opened');
		}
		// toggle parents state
		$colorSlide.closest('.colorPosts, .colorPostSlider').toggleClass('opened', $ifOpened);
	});
})