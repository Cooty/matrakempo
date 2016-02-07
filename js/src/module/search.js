// AMD module for the UI control of the search panel in the header
// @requires    jQuery, loaded by require.js
define('search', ['jquery'], function(jquery) {
    
    var $search = $('[data-search]'),
        $searchQuery = $('[data-search-query]'),
        $searchToggler = $('[data-search-toggler]'),
        $searchForm = $('[data-search-form]'),
        // Modifier styles defined in scss/module/_search.scss
        // it only has effect when 'csstransition' class from Modernizr is on the HTML root element to make the fallback animation easier
        modifierCSSClass = 'search--opened',
        // parameters passed to jQuery.animate() in case Modernizr.csstreansition reports FALSE - Keep consistent with external CSS!
        fallBackAnimH = '120px',
        fallBackAnimT = 200;
    
    /**
     * Switch for the state of the search container
     * Fallback for no-csstransitions, and a condition for touch devices included
     * @requires    jQuery, Modernizr
    */   
    function toggleSearch() {
        // open
        if (!$search.hasClass(modifierCSSClass)) {
            $search.addClass(modifierCSSClass);
            
            // autofocus the input
            $searchQuery.focus();
            
            // animation fallback
            if (!Modernizr.csstransitions) {
                $search.animate({height: fallBackAnimH}, fallBackAnimT);
            }
        }
        // close
        else {
            $search.removeClass(modifierCSSClass);
            // animation fallback
            if (!Modernizr.csstransitions) {
                $search.animate({height: '0'}, fallBackAnimT);
            }
            
        }
    };
    
    function initBindings() {
        $searchToggler.on({
            'click.toggleSearch': toggleSearch
        });
        
        $searchForm.on({
            'submit.prevntEmpty': function(e) {
                if ($searchQuery.val() === '') {
                    e.preventDefault();
                }
            }
        });
        
    };   
        
    return {
        init: function() {           
            initBindings();
        }
    }
    
});