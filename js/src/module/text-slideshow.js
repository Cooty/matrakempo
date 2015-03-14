define('textslideshow', ['jquery'], function(jquery) {
    
    var $textSlideshow = $('[data-text-slideshow]'),
        $slides = $textSlideshow.find('[data-text-slideshow-item]'),
        slideshowSpeed = 3000,
        animationSpeed = 700,
        index = 0,
        slideNumber = $slides.length,
        showCssClass = 'animate-in',
        hideCssClass = 'animate-out';
    
    function showSlide($slide) {
        $slide.addClass(showCssClass);
    }
    
    function hideSlide($slide) {
        $slide.addClass(hideCssClass);
        
        if (Modernizr.csstransitions) {
           cleanSlideClasses($slide); 
        } else {
            window.setTimeout(cleanSlideClasses($slide), animationSpeed);
        }
        
        
    }
    
    function stepSlides($slide) {
        showSlide($slide);
        window.setTimeout(function() {
            hideSlide($slide);
        }, slideshowSpeed);
    }
    
    function cleanSlideClasses($slide) {
        if ($slide.hasClass(showCssClass) && $slide.hasClass(hideCssClass)) {
            $slide.removeClass(showCssClass);
            $slide.removeClass(hideCssClass);
        }
    }
    
    function initSlideshow() {
        var $slide = $($slides[index]);
        
        stepSlides($slide);
        
        if (index === slideNumber - 1) {
            index = 0
        } else {
            index++;    
        }
        window.setTimeout(initSlideshow, slideshowSpeed);
        
    }
    
    return {
        init: initSlideshow
    }
    
});