<script>
  var googleMapContainer = document.getElementById('gmap'),
      markerHref = googleMapContainer.getAttribute('data-href'),
      markerHref2 = googleMapContainer.getAttribute('data-href-2'),
      markerTitle = googleMapContainer.getAttribute('data-title'),
      markerTitle2 = googleMapContainer.getAttribute('data-title-2'),
      markerTitle3 = googleMapContainer.getAttribute('data-title-3');

  function initGmap() {
    var mapSkin = [{"stylers":[{"hue":"#ff1a00"},{"invert_lightness":true},{"saturation":-100},{"lightness":33},{"gamma":0.5}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#2D333C"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#eeeeee"},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"},{"weight":3}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#2D333C"}]}],
        place = new google.maps.LatLng(47.7652613, 19.9227251),
        place2 = new google.maps.LatLng(47.7833455, 19.9223769),
        place3 = new google.maps.LatLng(47.748594, 19.9184788),
        mapOptions = {
          zoom: 12,
          center: place,
          styles: mapSkin,
          scrollwheel: false
        },
        map = new google.maps.Map(googleMapContainer, mapOptions),
        iconPath = '<?php bloginfo('template_directory'); ?>/img/asset/map_marker@2x.png';

        var marker = new google.maps.Marker({
            position: place,
            map: map,
            icon: new google.maps.MarkerImage(iconPath, null, null, null, new google.maps.Size(32,38)),
            title: markerTitle
        });

        var marker2 = new google.maps.Marker({
            position: place2,
            map: map,
            icon: new google.maps.MarkerImage(iconPath, null, null, null, new google.maps.Size(32,38)),
            title: markerTitle2
        });

        var marker3 = new google.maps.Marker({
            position: place3,
            map: map,
            icon: new google.maps.MarkerImage(iconPath, null, null, null, new google.maps.Size(32,38)),
            title: markerTitle3
        });

        google.maps.event.addListener(marker, 'click', function() {
          window.location.href = markerHref;
        });

        google.maps.event.addListener(marker2, 'click', function() {
          window.location.href = markerHref2;
        });
  }

  function loadScript() {
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&' +
        'callback=initGmap';
    document.body.appendChild(script);
  }

  window.onload = loadScript;
</script>
