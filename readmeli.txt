https://googlemaps.github.io/libraries
https://developers.google.com/maps/documentation/javascript/examples/
----------------------------------------

very nice use if divs and html and css: http://stackoverflow.com/questions/15632287/set-max-height-on-inner-div-so-scroll-bars-appear-but-not-on-parent-div
---------------------------------------
https://developers.google.com/maps/articles/toomanymarkers?hl=en

----------------------------------------
Fusion Tables

oauth2callback

client_id.json: text file content here:
{"web":{"client_id":"876796271201-h0fu8tvtbauf07vc3kdjqiik39rgvbgl.apps.googleusercontent.com",
    "project_id":"eol-connectors",
    "auth_uri":"https://accounts.google.com/o/oauth2/auth","token_uri":"https://accounts.google.com/o/oauth2/token","auth_provider_x509_cert_url":"https://www.googleapis.com/oauth2/v1/certs",
    "client_secret":"3MSqStGNeqbrIzWWulwaqJOr","redirect_uris":["http://localhost/oauth2callback"],"javascript_origins":["http://localhost"]}}

Client ID:
876796271201-h0fu8tvtbauf07vc3kdjqiik39rgvbgl.apps.googleusercontent.com

API key:
AIzaSyCXt2WPrcQniaMomonEruEOi3EHYlGEi3U

insect_dataset:

"tableId": "1jyJICpGHuxXcJHlS9-IqoJ0KxMtUIu1VSOMbIujb",

https://www.google.com/fusiontables/DataSource?docid=1DOsi2-wJKJI1ccGYLik1PQUEJx7h74r4W9G7KZxI

https://www.googleapis.com/fusiontables/v2/tables/1DOsi2-wJKJI1ccGYLik1PQUEJx7h74r4W9G7KZxI/columns?key=AIzaSyCXt2WPrcQniaMomonEruEOi3EHYlGEi3U

----------------------------------------
select all rows from fusion tables:
https://www.googleapis.com/fusiontables/v2/query?sql=SELECT%20*%20FROM%201YPvGpDseeNeODm8uAdd-TPm_WjI89c-uat0Dy-H8&key=AIzaSyAm9yWCV7JPCTHCJut8whOjARd7pwROFDQ
-----------------------------------------
http://stackoverflow.com/questions/23206190/insert-a-row-to-google-fusion-table-using-php
https://github.com/metaodi/GFTPrototype/blob/master/examples/php/UpdateTable.php
https://github.com/google/google-api-php-client/blob/master/src/Google/Service/Fusiontables.php



===========================================================================================
drag zoom feature: 
http://google-maps-utility-library-v3.googlecode.com/svn/tags/keydragzoom/1.0/docs/examples.html
https://code.google.com/archive/p/gmaps-utility-library-dev/

----------------------------------------

clusterer:
https://googlemaps.github.io/js-marker-clusterer/docs/examples.html

"Hold your shift key while drag a box."

----------------------------------------

Bring Google Map Markers to Front on Hover
http://stackoverflow.com/questions/15600523/google-maps-api-markers-with-duplicate-latitude-and-longitude (Google Maps API - Markers with duplicate latitude and longitude)
http://biostall.com/bring-google-map-marker-to-front-on-hover/
http://biostall.com/bring-google-map-marker-to-front-on-hover/


----------------------------------------
Google MarkerClusterer Handling Multiple Markers On Same Geo Location


http://jaspreetchahal.org/google-markerclusterer-handling-multiple-markers-on-same-geo-location/

----------------------------------------
Marker Clusterer Plus & Overlapping Marker Spiderfier

https://github.com/yagoferrer/markerclusterer-plus-spiderfier-example

----------------------------------------

https://github.com/jawj/OverlappingMarkerSpiderfier

----------------------------------------

http://stackoverflow.com/questions/20490654/more-than-one-marker-on-same-place-markerclusterer
sol'n here is to add a random no. to lat or long to differentiate similar lat-longs
----------------------------------------

http://stackoverflow.com/questions/9726920/integrating-spiderfier-js-into-markerclusterer-v3-to-explode-multi-markers-with

----------------------------------------
back button
https://groups.google.com/forum/#!topic/google-maps-js-api-v3/L6NnpItTND0

----------------------------------------
used code for centering map
http://stackoverflow.com/questions/10634199/find-center-of-multiple-locations-in-google-maps

another option is to use fitbounds: didn't use this
http://stackoverflow.com/questions/1556921/google-map-api-v3-set-bounds-and-center

----------------------------------------
// function goFullScreen() {
//   if (!document.fullscreenElement &&    // alternative standard method
//       !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement ) 
//   {  // current working methods
//     $('goFullText').innerHTML = "Fullscreen ON";
//     if (document.documentElement.requestFullscreen) {
//       document.documentElement.requestFullscreen();
//     } else if (document.documentElement.msRequestFullscreen) {
//       document.documentElement.msRequestFullscreen();
//     } else if (document.documentElement.mozRequestFullScreen) {
//       document.documentElement.mozRequestFullScreen();
//     } else if (document.documentElement.webkitRequestFullscreen) {
//       document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
//     }
//   } else 
//   {
//     $('goFullText').innerHTML = "Fullscreen OFF";
//     if (document.exitFullscreen) {
//       document.exitFullscreen();
//     } else if (document.msExitFullscreen) {
//       document.msExitFullscreen();
//     } else if (document.mozCancelFullScreen) {
//       document.mozCancelFullScreen();
//     } else if (document.webkitExitFullscreen) {
//       document.webkitExitFullscreen();
//     }
//   }
// }

----------------------------------------
/*
document.onkeypress = function(evt) {
    evt = evt || window.event;
    var charCode = evt.charCode || evt.keyCode || evt.which;
    if (charCode == 27) { // alert("Esc was pressed");
        alert("esc is pressed");
        if ($('goFullText').innerHTML == "Fullscreen ON 3")
        {
            $('goFullText').innerHTML = "Fullscreen OFF 3";
        }
    }
};
document.keypress = function(e){
    var charCode = e.charCode || e.keyCode || e.which;
    if(charCode == 27){
        alert("esc 3");
    }
};
document.keyup = function(e) {
  var charCode = e.charCode || e.keyCode || e.which;
  if (charCode == 27) 
  {
      alert("esc is pressed 2");
      if ($('goFullText').innerHTML == "Fullscreen ON")
      {
          $('goFullText').innerHTML = "Fullscreen OFF";
      }

  }
};
*/

----------------------------------------
----------------------------------------

