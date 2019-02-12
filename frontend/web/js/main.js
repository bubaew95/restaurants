/* ******************************************** */
/*  JS for SLIDER REVOLUTION  */
/* ******************************************** */
jQuery(document).ready(function() {
    jQuery('.tp-banner').revolution(
        {
            delay:9000,
            startheight:500,
            hideThumbs:10,
            navigationType:"bullet",
            hideArrowsOnMobile:"on",
            touchenabled:"on",
            onHoverStop:"on",
            navOffsetHorizontal:0,
            navOffsetVertical:20,
            stopAtSlide:-1,
            stopAfterLoops:-1,
            shadow:0,
            fullWidth:"on",
            fullScreen:"off"
        });
});
/* ******************************************** */
/*  JS for FlexSlider  */
/* ******************************************** */
$(window).load(function(){
    $('.flexslider-recent').flexslider({
        animation:		"fade",
        animationSpeed:	1000,
        controlNav:		true,
        directionNav:	false
    });
    $('.flexslider-testimonial').flexslider({
        animation: 		"fade",
        slideshowSpeed:	5000,
        animationSpeed:	1000,
        controlNav:		true,
        directionNav:	false
    });
});
/* Gallery */
jQuery(".gallery-img-link").prettyPhoto({
    overlay_gallery: false, social_tools: false
});