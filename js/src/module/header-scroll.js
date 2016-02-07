define('headerscroll', ['jquery', 'utils'], function(jquery, utils) {
    
    var topHeight = parseInt($('[data-top]').height(), 10),
        $body = $('body'),
        $window = $(window),
        modifierCSSClass = 'header--scrolled';
    
    return {
        init: function() {         
            $window.on({
                'scroll.headerPosition': utils.debounce(function(e){
                        if (parseInt($window.scrollTop(), 10) >= topHeight) {
                            if (!$body.hasClass(modifierCSSClass)) {
                                $body.addClass(modifierCSSClass);
                            }
                        }
                        else {
                            if ($body.hasClass(modifierCSSClass)) {
                                $body.removeClass(modifierCSSClass);
                            }   
                        }
                    }, 50)    
            });
        }
    }
    
});