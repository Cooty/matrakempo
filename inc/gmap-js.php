<script>
  var googleMapContainer = document.getElementById('gmap'),
      markerHref = googleMapContainer.getAttribute('data-href'),
      markerTitle = googleMapContainer.getAttribute('data-title');
  
  function initGmap() {
    var mapSkin = [{"stylers":[{"hue":"#ff1a00"},{"invert_lightness":true},{"saturation":-100},{"lightness":33},{"gamma":0.5}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#2D333C"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#eeeeee"},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"},{"weight":3}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#2D333C"}]}],
        place = new google.maps.LatLng(47.7757522, 19.9361529),
        mapOptions = {
          zoom: 14,
          center: place,
          styles: mapSkin,
          scrollwheel: false
        },
        map = new google.maps.Map(googleMapContainer, mapOptions),
        iconPath = 'http://www.matrakempose.hu/wp-content/themes/matrakempo/img/asset/map_marker@2x.png';
        
        var marker = new google.maps.Marker({
            position: place,
            map: map,
            icon: new google.maps.MarkerImage(iconPath, null, null, null, new google.maps.Size(32,38)),
            title: markerTitle
        });
        
        google.maps.event.addListener(marker, 'click', function() {
          window.location.href = markerHref;
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