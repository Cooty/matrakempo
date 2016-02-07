define('imagestream', ['jquery', 'utils'], function(jquery, utils) {
    var flickrApiKey = '2edaa390ab4c6d22d111ca7fcceb3a01',
        flickrUserId = '122560839@N03',
        page = 1,
        apiServiceURL = 'https://api.flickr.com/services/rest/?'+
                        'method=flickr.people.getPublicPhotos' +
                        '&api_key=' + flickrApiKey +
                        '&user_id=' + flickrUserId +
                        '&format=json'+
                        '&nojsoncallback=1'+
                        '&per_page=5'+
                        '&page=',
        $imageStreamContainer = $('[data-picstream-container]'),
        $imageStreamSection = $('[data-picstream-section]'),
        $reloadButton = $('[data-reload-images]'),
        imageStreamSectionTop = parseInt($imageStreamSection.position().top, 10) - 800,
        closedCssClassName = 'closed',
        rotationAnimCssClassName = 'rotate',
        $window = $(window),
        pages = 1;
    
    function openSection() {
        if ($imageStreamSection.hasClass(closedCssClassName)) {
            $imageStreamSection.removeClass(closedCssClassName);
        }
    }
    
    function closeSection() {
        if (!$imageStreamSection.hasClass(closedCssClassName)) {
            $imageStreamSection.addClass(closedCssClassName);
        }
    }
    
    function insertPhotosToDOM(photos, openContainer) {
        var photosHTML = '',
            i = 0,
            l = photos.length;
        
        for(i; i < l; i++) {
            photosHTML += '<a href="https://www.flickr.com/photos/gyongyoskempo/' + photos[i].id + '/" target="_blank" class="picture-stream__item blk blk--i">' + 
                            '<img src="https://farm' +
                            photos[i].farm +
                            '.staticflickr.com/' +
                            photos[i].server +
                            '/' + photos[i].id + '_' + photos[i].secret + '_n.jpg' +
                            '" class="picture-stream__img blk"'+
                            'title="'+ photos[i].title +'"' + 
                            '>'+
                        '</a>';   
        };
        
        $imageStreamContainer.html(photosHTML);
        
        if (openContainer) {
            window.setTimeout(function() {
                $imageStreamSection.removeClass(closedCssClassName);
            }, 500);
        }
        
    }
    
    function getPhotosFromFlicker(openContainer) {
        var photos = false,
            pagedServiceURL;
        
        pagedServiceURL = apiServiceURL + page;
        
        $.ajax({
            url: pagedServiceURL,
            method: 'GET',
            dataType: 'json'
        })
        .done(function(data) {
            if (data.stat === 'ok') {
                photos = data.photos.photo;
                pages = data.photos.pages;
                insertPhotosToDOM(photos, openContainer);
            } else {
                console.log('======= image-stream / getPhotosFromFlicker ======');
                console.log('stat: ', data.stat, 'code: ', data.code, 'message: ', data.message);
                console.log('==================================================');
            }
        })
        .fail(function( jqXHR, textStatus, errorThrown) {
            if (window.console) {
                console.log('======= image-stream / getPhotosFromFlicker ======');
                console.log('jqXHR: ', jqXHR, 'status: ', textStatus, 'error: ', errorThrown);
                console.log('==================================================');
            }
        });
    }
    
    /**
    * Returns a random integer between min (inclusive) and max (inclusive)
    * Using Math.round() will give you a non-uniform distribution!
    */
    function getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
    
    function reloadPhotos() {
        var randomPageNum = getRandomInt(1, pages);
        if (randomPageNum === page) {
            page = getRandomInt(1, pages);
        } else {
            page = randomPageNum;
        }
        
        $reloadButton.addClass(rotationAnimCssClassName);
        closeSection();
        window.setTimeout(function(){
            getPhotosFromFlicker(true);
            $reloadButton.removeClass(rotationAnimCssClassName);
        },300);
    }
    
    function openSectionInViewPort() {
        if(parseInt($window.scrollTop(), 10) >= imageStreamSectionTop) {
            openSection();
            $window.off('scroll.openSection');
        }
    }
    
    function bindEvents() {
        $window.on({
            'scroll.openSection': utils.debounce(openSectionInViewPort, 20) 
        });
        
        $window.on({
            'load': openSectionInViewPort
        });
        
        $reloadButton.on({
            'click.reloadPhotos': reloadPhotos
        });
        
    }
    
    function initImageStream() {
        getPhotosFromFlicker();
        bindEvents();
    }
    
    return {
        init: initImageStream
    }
    
});