jQuery(document).ready(function ($) {

    /* TO DO:
     * 
     * -set elements width and height to fix current screen size:
     *      $(window).on("resize", repositionDivOnResize)
     * - touch support
     */

    // First remove all opened, if any...
    $('.color, .colorPost, .colorPosts, .colorPostSlider').removeClass('opened');
//$(window).on("resize"

    $('.color, .colorPost').click(function () {
        // set colors height to match slider
//	$('.color, .colorPost, .colorPosts').height($('.colorPostSlider').height());
        $('.color, .colorPost, .colorPosts').height($('.colorPost .imageContainer img').height());

        // get clicked color slide
        $colorSlide = $('[data-color=' + $(this).data('color') + ']');
        // toggle clicked slide state
        $colorSlide.toggleClass('opened');
        // is anything opened?
        $ifOpened = $('.color, .colorPost').hasClass('opened');
        // close all other slides if any opend
        if ($ifOpened) {
            $colorSlide.siblings().removeClass('opened');
        }
        // toggle parents state
        $colorSlide.closest('.colorPostSlider, .colorPosts').toggleClass('opened', $ifOpened);
    });
});