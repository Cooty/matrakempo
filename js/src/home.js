require(['headerscroll',
         'drawermenu',
         'search',
         'backtotop',
         'textslideshow',
         'imagestream'], function(headerScroll, drawerMenu, search, backToTop, textSlideshow, imageStream) {
            headerScroll.init();
            drawerMenu.init();
            search.init();
            backToTop.init();
            textSlideshow.init();
            imageStream.init();
    });
