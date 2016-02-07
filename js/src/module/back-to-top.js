define('backtotop', ['jquery', 'utils'], function(jquery, utils) {
    
    var $backToTop = $('[data-back-to-top]'),
        $window = $(window),
        modifierCSSClass = 'back-to-top--show',
        headerHeight = parseInt($('[data-header]').height(), 10);    
    
    return {
        init: function() {         
            
            $backToTop.on({
                'click.backToTop': function(e) {
                   $('html, body').animate({
                        scrollTop: 0
                    }, 300); 
                   e.preventDefault(); 
                }
            });
            
            $window.on({
                'scroll.backToTop': utils.debounce(function(e){
                        if (parseInt($window.scrollTop(), 10) >= headerHeight) {
                            if (!$backToTop.hasClass(modifierCSSClass)) {
                                $backToTop.addClass(modifierCSSClass);
                            }
                        }
                        else {
                            if ($backToTop.hasClass(modifierCSSClass)) {
                                $backToTop.removeClass(modifierCSSClass);
                            }   
                        }
                    }, 100)    
            });
        }
    }
    
});