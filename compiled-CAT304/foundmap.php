<?php
include_once 'header.php';
include 'locations_modelfound.php';
//get_unconfirmed_locations();exit;
?>
<script>
        /**
         * Create new map
         */
        var infowindow;
        var map;
        var red_icon =  'http://maps.google.com/mapfiles/ms/icons/red-dot.png' ;
        var purple_icon =  'http://maps.google.com/mapfiles/ms/icons/purple-dot.png' ;
        var locations = <?php get_confirmed_locations() ?>;
        var markers = {};

    
</script>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Places Search Box</title>
    <link rel="icon" href="images/favicon.png">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <link rel="stylesheet" type="text/css" href="searchbox-map.css" />
    <link rel="stylesheet" type="text/css" href="header-user-map.css" />
    <link rel="stylesheet" href="displaylost.css" />
    <link rel="stylesheet" type="text/css" href="style.css" />
  <!--  <script src="index.js"></script> -->
  </head>
  <header>
        
        <div id="menu" class="fas fa-bars"></div>

        <a href="#" class="logo"> <i class="fas fa-paw"></i> PAWTASTIC</a>
        <h2 class="title">      Mark Location You Found the Pet</h2>
        <nav class="navbar">
            <a href="found.html">Done</a>
        </nav>

        <div class="icons">
            <a href="#" class="fas fa-user"></a>
        </div>
    </header>
  <body>
    <input
      id="pac-input"
      class="controls"
      type="text"
      placeholder="Search Box" style="width:500px;height:50px";
    />
    <div id="map"></div>
    <script>// This example adds a search box to a map, using the Google Place Autocomplete
// feature. People can enter geographical searches. The search box will return a
// pick list containing a mix of places and predicted search terms.
// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
function initAutocomplete() {
  const map = new google.maps.Map(document.getElementById("map"), {
      center: new google.maps.LatLng(3.1390,101.6869),
    zoom: 13,
    mapTypeId: "roadmap",
  });
  
  /**
         * SAVE save marker from map.
         * @param lat  A latitude of marker.
         * @param lng A longitude of marker.
         */
  
        
         
      /**
         * Concatenates given lat and lng with an underscore and returns it.
         * This id will be used as a key of marker to cache the marker in markers object.
         * @param {!number} lat Latitude.
         * @param {!number} lng Longitude.
         * @return {string} Concatenated marker id.
         */
       var getMarkerUniqueId= function(lat, lng) {
        return lat + '_' + lng;
    };

    /**
     * Creates an instance of google.maps.LatLng by given lat and lng values and returns it.
     * This function can be useful for getting new coordinates quickly.
     * @param {!number} lat Latitude.
     * @param {!number} lng Longitude.
     * @return {google.maps.LatLng} An instance of google.maps.LatLng object
     */
    var getLatLng = function(lat, lng) {
        return new google.maps.LatLng(lat, lng);
    };

    /**
     * Binds click event to given map and invokes a callback that appends a new marker to clicked location.
     */
    var addMarker = google.maps.event.addListener(map, 'click', function(e) {
        var lat = e.latLng.lat(); // lat of clicked point
        var lng = e.latLng.lng(); // lng of clicked point
        var markerId = getMarkerUniqueId(lat, lng); // an that will be used to cache this marker in markers object.
        var marker = new google.maps.Marker({
            position: getLatLng(lat, lng),
            map: map,
            animation: google.maps.Animation.DROP,
            id: 'marker_' + markerId,
            html: "    <div id='info_"+markerId+"'>\n" +
            "        <table class=\"map1\">\n" +
            "            <tr>\n" +
            "                <td><a>Description:</a></td>\n" +
            "                <td><textarea  id='manual_description' placeholder='Description'></textarea></td></tr>\n" +
            "            <tr><td></td><td><input type='button' value='Save' onclick='saveData("+lat+","+lng+")'/></td></tr>\n" +
            "        </table>\n" +
            "    </div>"
        });
        markers[markerId] = marker; // cache marker in markers object
        bindMarkerEvents(marker); // bind right click event to marker
        bindMarkerinfo(marker); // bind infowindow with click event to marker
    });

    /**
     * Binds  click event to given marker and invokes a callback function that will remove the marker from map.
     * @param {!google.maps.Marker} marker A google.maps.Marker instance that the handler will binded.
     */
    var bindMarkerinfo = function(marker) {
        google.maps.event.addListener(marker, "click", function (point) {
            var markerId = getMarkerUniqueId(point.latLng.lat(), point.latLng.lng()); // get marker id by using clicked point's coordinate
            var marker = markers[markerId]; // find marker
            infowindow = new google.maps.InfoWindow();
            infowindow.setContent(marker.html);
            infowindow.open(map, marker);
            // removeMarker(marker, markerId); // remove it
        });
    };

    /**
     * Binds right click event to given marker and invokes a callback function that will remove the marker from map.
     * @param {!google.maps.Marker} marker A google.maps.Marker instance that the handler will binded.
     */
    var bindMarkerEvents = function(marker) {
        google.maps.event.addListener(marker, "rightclick", function (point) {
            var markerId = getMarkerUniqueId(point.latLng.lat(), point.latLng.lng()); // get marker id by using clicked point's coordinate
            var marker = markers[markerId]; // find marker
            removeMarker(marker, markerId); // remove it
        });
    };

    /**
     * Removes given marker from map.
     * @param {!google.maps.Marker} marker A google.maps.Marker instance that will be removed.
     * @param {!string} markerId Id of marker.
     */
    var removeMarker = function(marker, markerId) {
        marker.setMap(null); // set markers setMap to null to remove it from map
        delete markers[markerId]; // delete marker instance from markers object
    };


    /**
     * loop through (Mysql) dynamic locations to add markers to map.
     */
    var i ; var confirmed = 0;
    for (i = 0; i < locations.length; i++) {
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map,
            icon :   locations[i][4] === '1' ?  red_icon  : purple_icon,
            html: "<div>\n" +
            "<table class=\"map1\">\n" +
            "<tr>\n" +
            "<td><a>Description:</a></td>\n" +
            "<td><textarea disabled id='manual_description' placeholder='Description'>"+locations[i][3]+"</textarea></td></tr>\n" +
            "</table>\n" +
            "</div>"
        });

        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infowindow = new google.maps.InfoWindow();
                confirmed =  locations[i][4] === '1' ?  'checked'  :  0;
                $("#confirmed").prop(confirmed,locations[i][4]);
                $("#id").val(locations[i][0]);
                $("#description").val(locations[i][3]);
                $("#form").show();
                infowindow.setContent(marker.html);
                infowindow.open(map, marker);
            }
        })(marker, i));
    }
    

    
  window.saveData = function saveData(lat,lng) {
  var description = document.getElementById('manual_description').value;
  var url = 'locations_modelfound.php?add_location&description=' + description + '&lat=' + lat + '&lng=' + lng;
  downloadUrl(url, function(data, responseCode) {
      if (responseCode === 200  && data.length > 1) {
          var markerId = getMarkerUniqueId(lat,lng); // get marker id by using clicked point's coordinate
          var manual_marker = markers[markerId]; // find marker
          manual_marker.setIcon(purple_icon);
          infowindow.close();
          infowindow.setContent("<div style=' color: purple; font-size: 25px;'> Waiting for admin confirm!!</div>");
          infowindow.open(map, manual_marker);

      }else{
          console.log(responseCode);
          console.log(data);
          infowindow.setContent("<div style='color: red; font-size: 25px;'>Inserting Errors</div>");
      }
  });
}
onclick="window.saveData()"


function downloadUrl(url, callback) {
  var request = window.ActiveXObject ?
      new ActiveXObject('Microsoft.XMLHTTP') :
      new XMLHttpRequest;

  request.onreadystatechange = function() {
      if (request.readyState == 4) {
          callback(request.responseText, request.status);
      }
  };

  request.open('GET', url, true);
  request.send(null);
}
  // Create the search box and link it to the UI element.
  const input = document.getElementById("pac-input");
  const searchBox = new google.maps.places.SearchBox(input);

  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
  // Bias the SearchBox results towards current map's viewport.
  map.addListener("bounds_changed", () => {
    searchBox.setBounds(map.getBounds());
  });

  let markers = [];
  /**
         * SAVE save marker from map.
         * @param lat  A latitude of marker.
         * @param lng A longitude of marker.
         */
 function saveData(lat,lng) {
  var description = document.getElementById('manual_description').value;
  var url = 'locations_model.php?add_location&description=' + description + '&lat=' + lat + '&lng=' + lng;
  downloadUrl(url, function(data, responseCode) {
      if (responseCode === 200  && data.length > 1) {
          var markerId = getMarkerUniqueId(lat,lng); // get marker id by using clicked point's coordinate
          var manual_marker = markers[markerId]; // find marker
          manual_marker.setIcon(purple_icon);
          infowindow.close();
          infowindow.setContent("<div style=' color: purple; font-size: 25px;'> Waiting for admin confirm!!</div>");
          infowindow.open(map, manual_marker);

      }else{
          console.log(responseCode);
          console.log(data);
          infowindow.setContent("<div style='color: red; font-size: 25px;'>Inserting Errors</div>");
      }
  });
}

function downloadUrl(url, callback) {
  var request = window.ActiveXObject ?
      new ActiveXObject('Microsoft.XMLHTTP') :
      new XMLHttpRequest;

  request.onreadystatechange = function() {
      if (request.readyState == 4) {
          callback(request.responseText, request.status);
      }
  };

  request.open('GET', url, true);
  request.send(null);
}

  // Listen for the event fired when the user selects a prediction and retrieve
  // more details for that place.
  searchBox.addListener("places_changed", () => {
    const places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }

    // Clear out the old markers.
    markers.forEach((marker) => {
      marker.setMap(null);
    });
    markers = [];

    // For each place, get the icon, name and location.
    const bounds = new google.maps.LatLngBounds();

    places.forEach((place) => {
      if (!place.geometry || !place.geometry.location) {
        console.log("Returned place contains no geometry");
        return;
      }

      const icon = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25),
      };

      // Create a marker for each place.
      markers.push(
        new google.maps.Marker({
          map,
          icon,
          title: place.name,
          position: place.geometry.location,
        })
      );
      if (place.geometry.viewport) {
        // Only geocodes have viewport.
        bounds.union(place.geometry.viewport);
      } else {
        bounds.extend(place.geometry.location);
      }
    });
    map.fitBounds(bounds);
  });
}
</script>
    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDO6gNaI7GkOqQJg2Mh0-Sb3DAyXxF6HYc&callback=initAutocomplete&libraries=places&v=weekly"
      async
    ></script>
  </body>
</html>