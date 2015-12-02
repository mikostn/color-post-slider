jQuery(document).ready(function($) {
	$('.colorPost').click(function() {
		$(this).toggleClass('opened');
		$(this).closest('.colorPosts').toggleClass('opened');
		$(this).closest('.colorPostSlider').toggleClass('opened');
	});
})