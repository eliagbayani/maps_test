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

var initial_map = false;


//start customized controls
function CenterControl(controlDiv, map) {
    // Set CSS for GO BACK
    var goBackUI = document.createElement('div');
    goBackUI.id = 'goBackUI';                       //.id here is used in HTML <style>
    goBackUI.title = 'Go back one step';
    controlDiv.appendChild(goBackUI);
    // CSS for text
    var goBackText = document.createElement('div');
    goBackText.id = 'goBackText';
    goBackText.innerHTML = 'Go Back';
    goBackUI.appendChild(goBackText);

    // Set CSS for GO NEXT
    var goNextUI = document.createElement('div');
    goNextUI.id = "goNextUI";
    goNextUI.title = 'Move forward one step';
    controlDiv.appendChild(goNextUI);
    // CSS for text
    var goNextText = document.createElement('div');
    goNextText.id = 'goNextText';
    goNextText.innerHTML = 'Move Next';
    goNextUI.appendChild(goNextText);

    // Set CSS for GO ORIGINAL POS
    var goOrigUI = document.createElement('div');
    goOrigUI.id = "goOrigUI";
    goOrigUI.title = 'Back to original map';
    controlDiv.appendChild(goOrigUI);
    // CSS for text
    var goOrigText = document.createElement('div');
    goOrigText.id = 'goOrigText';
    goOrigText.innerHTML = 'Initial Map';
    goOrigUI.appendChild(goOrigText);

    // Set CSS for Radio
    var goRadioUI = document.createElement('div');
    goRadioUI.id = "goRadioUI";
    goRadioUI.title = 'Toggle Clustering';
    controlDiv.appendChild(goRadioUI);
    // CSS for text
    var goRadioText = document.createElement('div');
    goRadioText.id = 'goRadioText';
    goRadioText.innerHTML = 'Clusters ON';
    goRadioUI.appendChild(goRadioText);

    // Set CSS for Panel
    var goPanelUI = document.createElement('div');
    goPanelUI.id = "goPanelUI";
    goPanelUI.title = 'Toggle Panel';
    controlDiv.appendChild(goPanelUI);
    // CSS for text
    var goPanelText = document.createElement('div');
    goPanelText.id = 'goPanelText';
    goPanelText.innerHTML = 'Panel ON';
    goPanelUI.appendChild(goPanelText);

//===========
    // Set CSS for Panel
    var goFullUI = document.createElement('div');
    goFullUI.id = "goFullUI";
    goFullUI.title = 'Go Fullscreen';
    controlDiv.appendChild(goFullUI);
    // CSS for text
    var goFullText = document.createElement('div');
    goFullText.id = 'goFullText';
    goFullText.innerHTML = 'Go Fullscreen';
    goFullUI.appendChild(goFullText);
//===========

    // Set up the click event listener
    goBackUI.addEventListener('click', function() {speedTest.back();});
    goNextUI.addEventListener('click', function() {speedTest.next();});
    goOrigUI.addEventListener('click', function() {speedTest.map.setOptions(initial_map);
        statuz = [];
        statuz_all = [];
        });

    goRadioUI.addEventListener('click', function() {clustersOnOff();});
    goPanelUI.addEventListener('click', function() {panelShowHide();});
    goFullUI.addEventListener('click', function() {goFullScreen();});
    
}
//end customized controls

function goFullScreen()
{
    var elem = document.getElementById("map-container");
    if (elem.requestFullscreen)
    {
      alert(1);
      elem.requestFullscreen();
    } else if (elem.msRequestFullscreen)
    {
      alert(2);
      elem.msRequestFullscreen();
    } else if (elem.mozRequestFullScreen)
    {
      // alert(3);
      elem.mozRequestFullScreen();
    } 
    else if (elem.webkitRequestFullscreen)
    {
        alert(4);
        // elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        elem.style.width = "100%";
        elem.style.height = "100%";
        elem.webkitRequestFullscreen();
    }
    
    // speedTest.map.setOptions(initial_map);
}

document.onkeypress = function(evt) {
    evt = evt || window.event;
    if (evt.keyCode == 27) { // alert("Esc was pressed");
        var elem = document.getElementById("map-container");
        elem.style.width = "";
    }
};

function panelShowHide()
{
    if ($('goPanelText').innerHTML == "Panel ON")
    {
        $('goPanelText').innerHTML = "Panel OFF";
        var el = document.getElementById("panel");
        el.style.display = 'none';
        el.style.width = 0;
        google.maps.event.trigger(speedTest.map, 'resize');
    }
    else
    {
        $('goPanelText').innerHTML = "Panel ON";
        var el = document.getElementById("panel");
        el.style.display = 'block';
        el.style.width = "17%";
        google.maps.event.trigger(speedTest.map, 'resize');
    }
}


function clustersOnOff()
{
    if ($('goRadioText').innerHTML == "Clusters ON") {$('goRadioText').innerHTML = "Clusters OFF";}
    else                                             {$('goRadioText').innerHTML = "Clusters ON";}
    speedTest.change();
}

function get_center_lat_long()
{
    var bound = new google.maps.LatLngBounds();
    speedTest.pics = data.records;
    var numMarkers = speedTest.pics.length;
    for (var i = 0; i < numMarkers; i++) 
    {
      bound.extend( new google.maps.LatLng(speedTest.pics[i].lat, speedTest.pics[i].lon) );
    }
    // console.log( bound.getCenter() );
    return bound.getCenter();
}

speedTest.init = function() {

  //start centering map
  center_latlong = get_center_lat_long()
  // var latlng = new google.maps.LatLng(39.91, 116.38);
  var latlng = new google.maps.LatLng(center_latlong.lat(), center_latlong.lng());
  //end centering map
  
  var options = {
    'zoom': 2,      //2 has overlapping continents
    'center': latlng,
    'mapTypeId': google.maps.MapTypeId.ROADMAP,
    'scaleControl': true
  };

  speedTest.map = new google.maps.Map($('map'), options);

  //start customized controls
    var centerControlDiv = document.createElement('div');
    var centerControl = new CenterControl(centerControlDiv, speedTest.map);
    centerControlDiv.index = 1;
    centerControlDiv.style['padding-top'] = '10px';
    speedTest.map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);
  //end customized controls

  speedTest.pics = data.records;
  speedTest.map.enableKeyDragZoom();  //for key-drag-zoom
  
  //start spiderfy
  var spiderConfig = {
          keepSpiderfied: true,
          event: 'mouseover'
      };
      
  markerSpiderfier = new OverlappingMarkerSpiderfier(speedTest.map, spiderConfig);
  //end spiderfy
  
  speedTest.infoWindow = new google.maps.InfoWindow();
  speedTest.showMarkers();
  google.maps.event.addListener(speedTest.map, 'idle', function(){record_history();}); //for back-button    //other option for event 'tilesloaded'
  
  
  
  
  
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
    
    if(!initial_map) initial_map = current;
}
speedTest.back = function()
{
    if(statuz.length > 1) {
        statuz.pop();
        var current = statuz.pop();
        speedTest.map.setOptions(current);
        if(JSON.stringify(current) == JSON.stringify(initial_map)){
            statuz = [];
            statuz_all = [];
        }
    }
}
speedTest.next = function()
{
    if(statuz_all.length > 1) {
        statuz_all.pop();
        var current = statuz_all.pop();
        speedTest.map.setOptions(current);
        if(JSON.stringify(current) == JSON.stringify(initial_map)){
            statuz = [];
            statuz_all = [];
        }
    }
}
//end back button

speedTest.showMarkers = function() {
  speedTest.markers = [];

  if (speedTest.markerClusterer) {
    speedTest.markerClusterer.clearMarkers();
  }

  var panel = $('markerlist');
  panel.innerHTML = '';
  
  var numMarkers = speedTest.pics.length;
  $('total_markers').innerHTML = numMarkers;

  for (var i = 0; i < numMarkers; i++) {
    var titleText = speedTest.pics[i].catalogNumber;
    if (titleText === '') {
      titleText = 'No catalog number';
    }

    var item = document.createElement('DIV');
    var title = document.createElement('A');
    title.href = '#';
    title.className = 'title';
    title.innerHTML = titleText;

    item.appendChild(title);
    panel.appendChild(item);

    var latLng = new google.maps.LatLng(speedTest.pics[i].lat, speedTest.pics[i].lon);
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
    var title = pic.sciname;
    var infoHtml = '<div class="info"><h3>' + title + '</h3>';

    if(pic.pic_url)       {infoHtml += '<div class="info-body"><img src="' + pic.pic_url + '" class="info-img"/></div><br/>';}
    if(pic.catalogNumber) {infoHtml += 'Catalog number: ' + pic.catalogNumber + '<br/>';}
    infoHtml += 'Source portal: <a href="http://www.gbif.org/occurrence/' + pic.gbifID + '" target="_blank">GBIF data</a>' + '<br/>' +
                'Publisher: <a href="http://www.gbif.org/publisher/' + pic.publisher_id + '" target="_blank">' + pic.publisher + '</a><br/>' +
                'Dataset: <a href="http://www.gbif.org/dataset/' + pic.dataset_id + '" target="_blank">' + pic.dataset + '</a><br/>';
    if(pic.recordedBy)   {infoHtml += 'Recorded by: ' + pic.recordedBy + '<br/>';}
    if(pic.identifiedBy) {infoHtml += 'Identified by: ' + pic.identifiedBy + '<br/>';}
    infoHtml += '</div>';
    
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

  if (!document.getElementById("goRadioText")) {speedTest.markerClusterer = new MarkerClusterer(speedTest.map, speedTest.markers);}
  else
  {
      if ($('goRadioText').innerHTML == "Clusters ON") {
        speedTest.markerClusterer = new MarkerClusterer(speedTest.map, speedTest.markers);
      } else {
        for (var i = 0, marker; marker = speedTest.markers[i]; i++) {
          marker.setMap(speedTest.map);
        }
      }
  }

  var end = new Date();
  $('timetaken').innerHTML = end - start;
};
