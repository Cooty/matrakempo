require(['headerscroll',
         'drawermenu',
         'search',
         'backtotop',
         'share'], function(headerScroll, drawerMenu, search, backToTop, share) {
            headerScroll.init();
            drawerMenu.init();
            search.init();
            backToTop.init();
            share.init();
    });
