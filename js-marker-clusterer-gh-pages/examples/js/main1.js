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

speedTest.recs = null;
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
    // Set CSS for Full
    var goFullUI = document.createElement('div');
    goFullUI.id = "goFullUI";
    goFullUI.title = 'Toggle Fullscreen';
    controlDiv.appendChild(goFullUI);
    // CSS for text
    var goFullText = document.createElement('div');
    goFullText.id = 'goFullText';
    goFullText.innerHTML = 'Fullscreen OFF orig';
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
    var elem = document.getElementById("gmap"); //gmap or map-container

    // if (elem.requestFullscreen)         {elem.requestFullscreen();} 
    // else if (elem.msRequestFullscreen)  {elem.msRequestFullscreen();} 
    // else if (elem.mozRequestFullScreen) {elem.mozRequestFullScreen();} //Firefox 
    // else if (elem.webkitRequestFullscreen) //Chrome and Safari
    // {
    //     // elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
    //     elem.style.width = "100%";
    //     elem.style.height = "100%";
    //     elem.webkitRequestFullscreen();
    // }

    if (!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement ) 
    {  // current working methods
      $('goFullText').innerHTML = "Fullscreen ON";
      if      (elem.requestFullscreen)      {elem.requestFullscreen();} 
      else if (elem.msRequestFullscreen)    {elem.msRequestFullscreen();} 
      else if (elem.mozRequestFullScreen)   {elem.mozRequestFullScreen();} 
      else if (elem.webkitRequestFullscreen) {
        elem.style.width = "100%";
        elem.style.height = "100%";
        

        elem.webkitRequestFullscreen(); //Element.ALLOW_KEYBOARD_INPUT
        // panelShowHide();
        // panelShowHide();
        // speedTest.change();
        
      }
    } else
    {
      $('goFullText').innerHTML = "Fullscreen OFF";
      if      (document.exitFullscreen) {document.exitFullscreen();} 
      else if (document.msExitFullscreen) {document.msExitFullscreen();} 
      else if (document.mozCancelFullScreen) {document.mozCancelFullScreen();} 
      else if (document.webkitExitFullscreen) {
        elem.style.width = "";
        document.webkitExitFullscreen();
      }
    }

    google.maps.event.trigger(speedTest.map, 'resize');
    
}

// start: listeners for fullscreenchanges
if (document.addEventListener) {
    document.addEventListener('webkitfullscreenchange', exitHandler, false);
    document.addEventListener('mozfullscreenchange', exitHandler, false);
    document.addEventListener('fullscreenchange', exitHandler, false);
    document.addEventListener('MSFullscreenChange', exitHandler, false);
}
function exitHandler() {
    if (document.webkitIsFullScreen || document.mozFullScreen || document.msFullscreenElement !== null)
    {
        if(!document.webkitIsFullScreen)
        {
            $('goFullText').innerHTML = "Fullscreen OFF2";
            var elem = document.getElementById("gmap"); //gmap or map-container
            elem.style.width = "";
        }
        if(document.mozFullScreen) $('goFullText').innerHTML = "Fullscreen ON2";
    }
}
// end: listeners for fullscreenchanges

function panelShowHide()
{
    var el = document.getElementById("panel");
    if ($('goPanelText').innerHTML == "Panel ON")
    {
        $('goPanelText').innerHTML = "Panel OFF";
        // el.style.display = 'none';
        el.style.width = 0;
    }
    else
    {
        $('goPanelText').innerHTML = "Panel ON";
        // el.style.display = 'block';
        el.style.width = "17%";
    }
    google.maps.event.trigger(speedTest.map, 'resize');
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
    speedTest.recs = data.records;
    var numMarkers = speedTest.recs.length;
    for (var i = 0; i < numMarkers; i++) 
    {
      bound.extend( new google.maps.LatLng(speedTest.recs[i].lat, speedTest.recs[i].lon) );
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
    'zoom': 3,      //2 has overlapping continents
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

  speedTest.recs = data.records;
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
  
  var numMarkers = speedTest.recs.length;
  $('total_markers').innerHTML = numMarkers;

  for (var i = 0; i < numMarkers; i++) {
    var titleText = speedTest.recs[i].catalogNumber;
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

    var latLng = new google.maps.LatLng(speedTest.recs[i].lat, speedTest.recs[i].lon);
    var imageUrl = 'http://chart.apis.google.com/chart?cht=mm&chs=24x32&chco=' + 'FFFFFF,008CFF,000000&ext=.png';
    var markerImage = new google.maps.MarkerImage(imageUrl, new google.maps.Size(24, 32));
    var marker = new google.maps.Marker({
      'position': latLng,
      // 'icon': markerImage
      'icon': "https://storage.googleapis.com/support-kms-prod/SNP_2752125_en_v0"
    });

    var fn = speedTest.markerClickFunction(speedTest.recs[i], latLng);
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
  for (var i = 0, marker; marker = speedTest.markers[i]; i++) {
    marker.setMap(null);
  }
};

speedTest.change = function() {
  speedTest.clear();
  speedTest.showMarkers();
};

speedTest.time = function() {
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
};
