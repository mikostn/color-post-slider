jQuery(document).ready(function ($) {

    /* TO DO:
     * 
     * -set elements width and height to fix current screen size:
     *      $(window).on("resize", repositionDivOnResize)
     * - touch support
     */

    function setColorInits(max) {
        max = max || 600;
        // set colors height to match slider
        if (max && jQuery(window).width() > max) {
            jQuery('.color, .colorPost, .colorPosts').height(jQuery('.colorPost .imageContainer').height());
        }else{
            jQuery('.color, .colorPost, .colorPosts').height('auto');
        }
    }

    // run init func with delay, wiat for resize to finish, + wait for css animations to finish!
    var resizeTimer;
    $(window).on('load resize', function (e) {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
            // Run code here, resizing has "stopped"
            setColorInits();
        }, 410);
    });

    // First remove all opened, if any...
    $('.colorPostSlider .opened').removeClass('opened');

    $('.colorPostSlider').on("click", ".color, .colorPost .imageContainer, .colorPost .header", function () {

//    $('.color, .colorPost .imageContainer, .colorPost .header').click(function () {

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