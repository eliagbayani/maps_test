/**
 * @fileoverview This demo is used for MarkerClusterer. It will show 100 markers
 * using MarkerClusterer and count the time to show the difference between using
 * MarkerClusterer and without MarkerClusterer.
 * @author Luke Mahe (v2 author: Xiaoxi Wu)
 */

function $(element) {
  return document.getElementById(element);
}

var speedTest = {};

speedTest.pics = null;
speedTest.map = null;
speedTest.markerClusterer = null;
speedTest.markers = [];
speedTest.infoWindow = null;

var markerSpiderfier = null;

var statuz = [];        //for back button
var statuz_all = [];    //for next button


//start customized controls
function CenterControl(controlDiv, map) {
    // Set CSS for GO BACK
    var goBackUI = document.createElement('div');
    goBackUI.id = 'goBackUI';                       //.id here is used in HTML <style>
    goBackUI.title = 'Go back one step';
    controlDiv.appendChild(goBackUI);
    // Set CSS for text
    var goBackText = document.createElement('div');
    goBackText.id = 'goBackText';
    goBackText.innerHTML = 'Go Back';
    goBackUI.appendChild(goBackText);

    // Set CSS for GO NEXT
    var goNextUI = document.createElement('div');
    goNextUI.id = "goNextUI";
    goNextUI.title = 'Move forward one step';
    controlDiv.appendChild(goNextUI);
    // Set CSS for text
    var goNextText = document.createElement('div');
    goNextText.id = 'goNextText';
    goNextText.innerHTML = 'Move Next';
    goNextUI.appendChild(goNextText);

    // Set up the click event listener
    goBackUI.addEventListener('click', function() {speedTest.back();});
    goNextUI.addEventListener('click', function() {speedTest.next();});
  
}

//end customized controls

function get_center_lat_long()
{
    var bound = new google.maps.LatLngBounds();
    speedTest.pics = data.photos;
    var numMarkers = speedTest.pics.length;
    for (var i = 0; i < numMarkers; i++) 
    {
      bound.extend( new google.maps.LatLng(speedTest.pics[i].latitude, speedTest.pics[i].longitude) );
    }
    // console.log( bound.getCenter() );
    return bound.getCenter();
}

speedTest.init = function() {
  // var latlng = new google.maps.LatLng(39.91, 116.38);
  
  //start centering map
  center_latlong = get_center_lat_long()
  var latlng = new google.maps.LatLng(center_latlong["G"], center_latlong["K"]);
  //end centering map
  
  var options = {
    'zoom': 2,      //2 has overlapping continents
    'center': latlng,
    'mapTypeId': google.maps.MapTypeId.ROADMAP,
    'scaleControl': true
  };

  speedTest.map = new google.maps.Map($('map'), options);
  speedTest.pics = data.photos;
  speedTest.map.enableKeyDragZoom();  //for key-drag-zoom
  
  //start spiderfy
  var spiderConfig = {
          keepSpiderfied: true,
          event: 'mouseover'
      };
      
  markerSpiderfier = new OverlappingMarkerSpiderfier(speedTest.map, spiderConfig);
  //end spiderfy
  
  var useGmm = document.getElementById('usegmm');
  google.maps.event.addDomListener(useGmm, 'click', speedTest.change);
  
  /* for <select> no. of markers
  var numMarkers = document.getElementById('nummarkers');
  google.maps.event.addDomListener(numMarkers, 'change', speedTest.change);
  */
  
  speedTest.infoWindow = new google.maps.InfoWindow();
  
  speedTest.showMarkers();
  
  google.maps.event.addListener(speedTest.map, 'idle', function(){record_history();}); //for back-button    //other option for event 'tilesloaded'
  
  //start customized controls
    var centerControlDiv = document.createElement('div');
    var centerControl = new CenterControl(centerControlDiv, speedTest.map);
    centerControlDiv.index = 1;
    centerControlDiv.style['padding-top'] = '10px';
    speedTest.map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);
  //end customized controls
  
};

//start back button
function record_history()
{
    var current = {};
    current.center = speedTest.map.getCenter();
    current.zoom = speedTest.map.getZoom();
    current.mapTypeId = speedTest.map.getMapTypeId();
    statuz.push(current);
    statuz_all.push(current);
    
}
speedTest.back = function()
{
    if(statuz.length > 1) {
        statuz.pop();
        speedTest.map.setOptions(statuz.pop());
    }
}
speedTest.next = function()
{
    if(statuz_all.length > 1) {
        statuz_all.pop();
        speedTest.map.setOptions(statuz_all.pop());
    }
}
//end back button

speedTest.showMarkers = function() {
  speedTest.markers = [];

  var type = 1;
  if ($('usegmm').checked) {
    type = 0;
  }

  if (speedTest.markerClusterer) {
    speedTest.markerClusterer.clearMarkers();
  }

  var panel = $('markerlist');
  panel.innerHTML = '';
  
  // var numMarkers = $('nummarkers').value; //for <select> no. of markers
  
  var numMarkers = speedTest.pics.length;
  $('total_markers').innerHTML = numMarkers;

  for (var i = 0; i < numMarkers; i++) {
    var titleText = speedTest.pics[i].photo_title;
    if (titleText === '') {
      titleText = 'No title';
    }

    var item = document.createElement('DIV');
    var title = document.createElement('A');
    title.href = '#';
    title.className = 'title';
    title.innerHTML = titleText;

    item.appendChild(title);
    panel.appendChild(item);

    var latLng = new google.maps.LatLng(speedTest.pics[i].latitude, speedTest.pics[i].longitude);
    var imageUrl = 'http://chart.apis.google.com/chart?cht=mm&chs=24x32&chco=' + 'FFFFFF,008CFF,000000&ext=.png';
    var markerImage = new google.maps.MarkerImage(imageUrl, new google.maps.Size(24, 32));
    var marker = new google.maps.Marker({
      'position': latLng,
      // 'icon': markerImage
      'icon': "https://storage.googleapis.com/support-kms-prod/SNP_2752125_en_v0"
    });

    var fn = speedTest.markerClickFunction(speedTest.pics[i], latLng);
    google.maps.event.addListener(marker, 'click', fn);
    google.maps.event.addDomListener(title, 'click', fn);
    speedTest.markers.push(marker);
    
    // /*
    //start spiderfy
    markerSpiderfier.addMarker(marker); // Adds the Marker to OverlappingMarkerSpiderfier
    //end spiderfy
    // */
    
  }//end looping of markers
  
  // /*
  //start spiderfy
  markerSpiderfier.addListener('click', function(marker, e) {
      speedTest.infoWindow.open(speedTest.map, marker);
  });
  markerx = speedTest.markers;
  markerSpiderfier.addListener('spiderfy', function(markerx) {speedTest.infoWindow.close();});
  //end spiderfy
  // */
  
  window.setTimeout(speedTest.time, 0);
};

speedTest.markerClickFunction = function(pic, latlng) {
  return function(e) {
    e.cancelBubble = true;
    e.returnValue = false;
    if (e.stopPropagation) {
      e.stopPropagation();
      e.preventDefault();
    }
    var title = pic.photo_title;
    var url = pic.photo_url;
    var fileurl = pic.photo_file_url;

    var infoHtml = '<div class="info"><h3>' + title +
      '</h3><div class="info-body">' +
      '<a href="' + url + '" target="_blank"><img src="' +
      fileurl + '" class="info-img"/></a></div>' +
      '<a href="http://www.panoramio.com/" target="_blank">' +
      '<img src="http://maps.google.com/intl/en_ALL/mapfiles/' +
      'iw_panoramio.png"/></a><br/>' +
      '<a href="' + pic.owner_url + '" target="_blank">' + pic.owner_name +
      '</a></div></div>';

    speedTest.infoWindow.setContent(infoHtml);
    speedTest.infoWindow.setPosition(latlng);
    speedTest.infoWindow.open(speedTest.map);
  };
};

speedTest.clear = function() {
  $('timetaken').innerHTML = 'cleaning...';
  for (var i = 0, marker; marker = speedTest.markers[i]; i++) {
    marker.setMap(null);
  }
};

speedTest.change = function() {
  speedTest.clear();
  speedTest.showMarkers();
};

speedTest.time = function() {
  $('timetaken').innerHTML = 'timing...';
  var start = new Date();
  if ($('usegmm').checked) {
    speedTest.markerClusterer = new MarkerClusterer(speedTest.map, speedTest.markers);
  } else {
    for (var i = 0, marker; marker = speedTest.markers[i]; i++) {
      marker.setMap(speedTest.map);
    }
  }

  var end = new Date();
  $('timetaken').innerHTML = end - start;
};
