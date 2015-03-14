define('drawermenu', ['jquery'], function(jquery) {
    
    var $body = $('body'),
        modifierCSSClass = 'drawer-menu-opened',
        $drawerOpener = $('[data-drawer-opener]'),
        $drawerCloser = $('[data-drawer-closer]');
        
    function openDrawer() {
        if (!$body.hasClass(modifierCSSClass)) {
            $body.addClass(modifierCSSClass);
        }
    }
    
    function closeDrawer() {
        if ($body.hasClass(modifierCSSClass)) {
            $body.removeClass(modifierCSSClass);
        }
    }
    
    function initBindings() {
        $drawerOpener.on({
            'click.openDrawer': openDrawer
        });
        
        $drawerCloser.on({
            'click.closeDrawer': closeDrawer
        });
        
    }
        
        
    return {
        init: function() {           
            initBindings();
        }
    }
    
});