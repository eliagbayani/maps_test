<!DOCTYPE html>
<html xml:lang="en" xmlns:fb="http://ogp.me/ns/fb#" xmlns:og="http://ogp.me/ns#" xmlns="http://www.w3.org/1999/xhtml" lang="en"><head>
<title>Silvereye - Zosterops lateralis - Maps - Encyclopedia of Life</title>
<meta charset="utf-8">
<script src="Silvereye%20-%20Zosterops%20lateralis%20-%20Maps%20-%20Encyclopedia%20of%20Life_files/e154e34f12.js" type="text/javascript"></script><script src="Silvereye%20-%20Zosterops%20lateralis%20-%20Maps%20-%20Encyclopedia%20of%20Life_files/nr-852.js"></script><script src="Silvereye%20-%20Zosterops%20lateralis%20-%20Maps%20-%20Encyclopedia%20of%20Life_files/analytics.js" async=""></script><script type="text/javascript">window.NREUM||(NREUM={});NREUM.info={"beacon":"bam.nr-data.net","errorBeacon":"bam.nr-data.net","licenseKey":"e154e34f12","applicationID":"446884","transactionName":"JQpeRxBWXV9RFE1MUx4EH14DSUIcXQgGXUo=","queueTime":0,"applicationTime":161,"agentToken":null,"agent":"","ttGuid":"9b8f178d14e6385c"}</script>
<script type="text/javascript">(window.NREUM||(NREUM={})).loader_config={xpid:"UQYEVEVXDAUIXFU="};window.NREUM||(NREUM={}),__nr_require=function(t,e,n){function r(n){if(!e[n]){var o=e[n]={exports:{}};t[n][0].call(o.exports,function(e){var o=t[n][1][e];return r(o||e)},o,o.exports)}return e[n].exports}if("function"==typeof __nr_require)return __nr_require;for(var o=0;o<n.length;o++)r(n[o]);return r}({QJf3ax:[function(t,e){function n(){}function r(t){function e(t){return t&&t instanceof n?t:t?a(t,i,o):o()}function s(n,r,o){t&&t(n,r,o);for(var i=e(o),a=f(n),s=a.length,c=0;s>c;c++)a[c].apply(i,r);return i}function c(t,e){d[t]=f(t).concat(e)}function f(t){return d[t]||[]}function u(){return r(s)}var d={};return{on:c,emit:s,create:u,listeners:f,context:e,_events:d}}function o(){return new n}var i="nr@context",a=t("gos");e.exports=r()},{gos:"7eSDFh"}],ee:[function(t,e){e.exports=t("QJf3ax")},{}],3:[function(t){function e(t){try{i.console&&console.log(t)}catch(e){}}var n,r=t("ee"),o=t(1),i={};try{n=localStorage.getItem("__nr_flags").split(","),console&&"function"==typeof console.log&&(i.console=!0,-1!==n.indexOf("dev")&&(i.dev=!0),-1!==n.indexOf("nr_dev")&&(i.nrDev=!0))}catch(a){}i.nrDev&&r.on("internal-error",function(t){e(t.stack)}),i.dev&&r.on("fn-err",function(t,n,r){e(r.stack)}),i.dev&&(e("NR AGENT IN DEVELOPMENT MODE"),e("flags: "+o(i,function(t){return t}).join(", ")))},{1:21,ee:"QJf3ax"}],4:[function(t){function e(t,e,n,i,a){try{f?f-=1:r("err",[a||new UncaughtException(t,e,n)])}catch(c){try{r("ierr",[c,(new Date).getTime(),!0])}catch(u){}}return"function"==typeof s?s.apply(this,o(arguments)):!1}function UncaughtException(t,e,n){this.message=t||"Uncaught error with no additional information",this.sourceURL=e,this.line=n}function n(t){r("err",[t,(new Date).getTime()])}var r=t("handle"),o=t(6),i=t("ee"),a=t("loader"),s=window.onerror,c=!1,f=0;a.features.err=!0,t(3),window.onerror=e;try{throw new Error}catch(u){"stack"in u&&(t(4),t(5),"addEventListener"in window&&t(1),a.xhrWrappable&&t(2),c=!0)}i.on("fn-start",function(){c&&(f+=1)}),i.on("fn-err",function(t,e,r){c&&(this.thrown=!0,n(r))}),i.on("fn-end",function(){c&&!this.thrown&&f>0&&(f-=1)}),i.on("internal-error",function(t){r("ierr",[t,(new Date).getTime(),!0])})},{1:5,2:8,3:3,4:7,5:6,6:22,ee:"QJf3ax",handle:"D5DuLP",loader:"G9z0Bl"}],5:[function(t,e){function n(t){for(var e=t;e&&!e.hasOwnProperty("addEventListener");)e=Object.getPrototypeOf(e);e&&r(e)}function r(t){a.inPlace(t,["addEventListener","removeEventListener"],"-",o)}function o(t){return t[1]}var i=t("ee").create(),a=t(1)(i),s=t("gos");e.exports=i,r(window),"getPrototypeOf"in Object?(n(document),n(XMLHttpRequest.prototype)):XMLHttpRequest.prototype.hasOwnProperty("addEventListener")&&r(XMLHttpRequest.prototype),i.on("addEventListener-start",function(t){if(t[1]){var e=t[1];if("function"==typeof e){var n=s(e,"nr@wrapped",function(){return a(e,"fn-",null,e.name||"anonymous")});this.wrapped=t[1]=n}else"function"==typeof e.handleEvent&&a.inPlace(e,["handleEvent"],"fn-")}}),i.on("removeEventListener-start",function(t){var e=this.wrapped;e&&(t[1]=e)})},{1:23,ee:"QJf3ax",gos:"7eSDFh"}],6:[function(t,e){var n=t("ee").create(),r=t(1)(n);e.exports=n,r.inPlace(window,["requestAnimationFrame","mozRequestAnimationFrame","webkitRequestAnimationFrame","msRequestAnimationFrame"],"raf-"),n.on("raf-start",function(t){t[0]=r(t[0],"fn-")})},{1:23,ee:"QJf3ax"}],7:[function(t,e){function n(t,e,n){t[0]=i(t[0],"fn-",null,n)}function r(t,e,n){this.method=n,this.timerDuration="number"==typeof t[1]?t[1]:0,t[0]=i(t[0],"fn-",this,n)}var o=t("ee").create(),i=t(1)(o);e.exports=o,i.inPlace(window,["setTimeout","setImmediate"],"setTimer-"),i.inPlace(window,["setInterval"],"setInterval-"),i.inPlace(window,["clearTimeout","clearImmediate"],"clearTimeout-"),o.on("setInterval-start",n),o.on("setTimer-start",r)},{1:23,ee:"QJf3ax"}],8:[function(t,e){function n(){f.inPlace(this,l,"fn-",o)}function r(t,e){f.inPlace(e,["onreadystatechange"],"fn-",o)}function o(t,e){return e}function i(t,e){for(var n in t)e[n]=t[n];return e}var a=t("ee").create(),s=t(1),c=t(2),f=c(a),u=c(s),d=window.XMLHttpRequest,l=["onload","onerror","onabort","onloadstart","onloadend","onprogress","ontimeout"];e.exports=a,window.XMLHttpRequest=function(t){var e=new d(t);try{a.emit("new-xhr",[e],e),e.hasOwnProperty("addEventListener")&&u.inPlace(e,["addEventListener","removeEventListener"],"-",o),e.addEventListener("readystatechange",n,!1)}catch(r){try{a.emit("internal-error",[r])}catch(i){}}return e},i(d,XMLHttpRequest),XMLHttpRequest.prototype=d.prototype,f.inPlace(XMLHttpRequest.prototype,["open","send"],"-xhr-",o),a.on("send-xhr-start",r),a.on("open-xhr-start",r)},{1:5,2:23,ee:"QJf3ax"}],9:[function(t){function e(t){var e=this.params,r=this.metrics;if(!this.ended){this.ended=!0;for(var o=0;u>o;o++)t.removeEventListener(f[o],this.listener,!1);if(!e.aborted){if(r.duration=(new Date).getTime()-this.startTime,4===t.readyState){e.status=t.status;var i=this.lastSize||n(t);if(i&&(r.rxSize=i),this.sameOrigin){var s=t.getResponseHeader("X-NewRelic-App-Data");s&&(e.cat=s.split(", ").pop())}}else e.status=0;r.cbTime=this.cbTime,c.emit("xhr-done",[t],t),a("xhr",[e,r,this.startTime])}}}function n(t){var e=t.responseType,n="arraybuffer"===e||"blob"===e||"json"===e?t.response:t.responseText;return r(n)}function r(t){if("string"==typeof t&&t.length)return t.length;if("object"!=typeof t)return void 0;if("undefined"!=typeof ArrayBuffer&&t instanceof ArrayBuffer&&t.byteLength)return t.byteLength;if("undefined"!=typeof Blob&&t instanceof Blob&&t.size)return t.size;if("undefined"!=typeof FormData&&t instanceof FormData)return void 0;try{return JSON.stringify(t).length}catch(e){return void 0}}function o(t,e){var n=s(e),r=t.params;r.host=n.hostname+":"+n.port,r.pathname=n.pathname,t.sameOrigin=n.sameOrigin}var i=t("loader");if(i.xhrWrappable){var a=t("handle"),s=t(2),c=t("ee"),f=["load","error","abort","timeout"],u=f.length,d=t(1),l=t(3),p=window.XMLHttpRequest;i.features.xhr=!0,t(5),t(4),c.on("new-xhr",function(t){var n=this;n.totalCbs=0,n.called=0,n.cbTime=0,n.end=e,n.ended=!1,n.xhrGuids={},n.lastSize=0,l&&(l>34||10>l)||window.opera||t.addEventListener("progress",function(t){n.lastSize=t.loaded},!1)}),c.on("open-xhr-start",function(t){this.params={method:t[0]},o(this,t[1]),this.metrics={}}),c.on("open-xhr-end",function(t,e){"loader_config"in NREUM&&"xpid"in NREUM.loader_config&&this.sameOrigin&&e.setRequestHeader("X-NewRelic-ID",NREUM.loader_config.xpid)}),c.on("send-xhr-start",function(t,e){var n=this.metrics,o=t[0],i=this;if(n&&o){var a=r(o);a&&(n.txSize=a)}this.startTime=(new Date).getTime(),this.listener=function(t){try{"abort"===t.type&&(i.params.aborted=!0),("load"!==t.type||i.called===i.totalCbs&&(i.onloadCalled||"function"!=typeof e.onload))&&i.end(e)}catch(n){try{c.emit("internal-error",[n])}catch(r){}}};for(var s=0;u>s;s++)e.addEventListener(f[s],this.listener,!1)}),c.on("xhr-cb-time",function(t,e,n){this.cbTime+=t,e?this.onloadCalled=!0:this.called+=1,this.called!==this.totalCbs||!this.onloadCalled&&"function"==typeof n.onload||this.end(n)}),c.on("xhr-load-added",function(t,e){var n=""+d(t)+!!e;this.xhrGuids&&!this.xhrGuids[n]&&(this.xhrGuids[n]=!0,this.totalCbs+=1)}),c.on("xhr-load-removed",function(t,e){var n=""+d(t)+!!e;this.xhrGuids&&this.xhrGuids[n]&&(delete this.xhrGuids[n],this.totalCbs-=1)}),c.on("addEventListener-end",function(t,e){e instanceof p&&"load"===t[0]&&c.emit("xhr-load-added",[t[1],t[2]],e)}),c.on("removeEventListener-end",function(t,e){e instanceof p&&"load"===t[0]&&c.emit("xhr-load-removed",[t[1],t[2]],e)}),c.on("fn-start",function(t,e,n){e instanceof p&&("onload"===n&&(this.onload=!0),("load"===(t[0]&&t[0].type)||this.onload)&&(this.xhrCbStart=(new Date).getTime()))}),c.on("fn-end",function(t,e){this.xhrCbStart&&c.emit("xhr-cb-time",[(new Date).getTime()-this.xhrCbStart,this.onload,e],e)})}},{1:"XL7HBI",2:10,3:12,4:8,5:5,ee:"QJf3ax",handle:"D5DuLP",loader:"G9z0Bl"}],10:[function(t,e){e.exports=function(t){var e=document.createElement("a"),n=window.location,r={};e.href=t,r.port=e.port;var o=e.href.split("://");!r.port&&o[1]&&(r.port=o[1].split("/")[0].split("@").pop().split(":")[1]),r.port&&"0"!==r.port||(r.port="https"===o[0]?"443":"80"),r.hostname=e.hostname||n.hostname,r.pathname=e.pathname,r.protocol=o[0],"/"!==r.pathname.charAt(0)&&(r.pathname="/"+r.pathname);var i=!e.protocol||":"===e.protocol||e.protocol===n.protocol,a=e.hostname===document.domain&&e.port===n.port;return r.sameOrigin=i&&(!e.hostname||a),r}},{}],11:[function(t,e){function n(t){return function(){r(t,[(new Date).getTime()].concat(i(arguments)))}}var r=t("handle"),o=t(1),i=t(2);"undefined"==typeof window.newrelic&&(newrelic=window.NREUM);var a=["setPageViewName","addPageAction","setCustomAttribute","finished","addToTrace","inlineHit","noticeError"];o(a,function(t,e){window.NREUM[e]=n("api-"+e)}),e.exports=window.NREUM},{1:21,2:22,handle:"D5DuLP"}],12:[function(t,e){var n=0,r=navigator.userAgent.match(/Firefox[\/\s](\d+\.\d+)/);r&&(n=+r[1]),e.exports=n},{}],gos:[function(t,e){e.exports=t("7eSDFh")},{}],"7eSDFh":[function(t,e){function n(t,e,n){if(r.call(t,e))return t[e];var o=n();if(Object.defineProperty&&Object.keys)try{return Object.defineProperty(t,e,{value:o,writable:!0,enumerable:!1}),o}catch(i){}return t[e]=o,o}var r=Object.prototype.hasOwnProperty;e.exports=n},{}],D5DuLP:[function(t,e){function n(t,e,n){return r.listeners(t).length?r.emit(t,e,n):void(r.q&&(r.q[t]||(r.q[t]=[]),r.q[t].push(e)))}var r=t("ee").create();e.exports=n,n.ee=r,r.q={}},{ee:"QJf3ax"}],handle:[function(t,e){e.exports=t("D5DuLP")},{}],XL7HBI:[function(t,e){function n(t){var e=typeof t;return!t||"object"!==e&&"function"!==e?-1:t===window?0:i(t,o,function(){return r++})}var r=1,o="nr@id",i=t("gos");e.exports=n},{gos:"7eSDFh"}],id:[function(t,e){e.exports=t("XL7HBI")},{}],G9z0Bl:[function(t,e){function n(){if(!h++){var t=p.info=NREUM.info,e=f.getElementsByTagName("script")[0];if(t&&t.licenseKey&&t.applicationID&&e){s(d,function(e,n){t[e]||(t[e]=n)});var n="https"===u.split(":")[0]||t.sslForHttp;p.proto=n?"https://":"http://",a("mark",["onload",i()]);var r=f.createElement("script");r.src=p.proto+t.agent,e.parentNode.insertBefore(r,e)}}}function r(){"complete"===f.readyState&&o()}function o(){a("mark",["domContent",i()])}function i(){return(new Date).getTime()}var a=t("handle"),s=t(1),c=window,f=c.document;t(2);var u=(""+location).split("?")[0],d={beacon:"bam.nr-data.net",errorBeacon:"bam.nr-data.net",agent:"js-agent.newrelic.com/nr-852.min.js"},l=window.XMLHttpRequest&&XMLHttpRequest.prototype&&XMLHttpRequest.prototype.addEventListener&&!/CriOS/.test(navigator.userAgent),p=e.exports={offset:i(),origin:u,features:{},xhrWrappable:l};f.addEventListener?(f.addEventListener("DOMContentLoaded",o,!1),c.addEventListener("load",n,!1)):(f.attachEvent("onreadystatechange",r),c.attachEvent("onload",n)),a("mark",["firstbyte",i()]);var h=0},{1:21,2:11,handle:"D5DuLP"}],loader:[function(t,e){e.exports=t("G9z0Bl")},{}],21:[function(t,e){function n(t,e){var n=[],o="",i=0;for(o in t)r.call(t,o)&&(n[i]=e(o,t[o]),i+=1);return n}var r=Object.prototype.hasOwnProperty;e.exports=n},{}],22:[function(t,e){function n(t,e,n){e||(e=0),"undefined"==typeof n&&(n=t?t.length:0);for(var r=-1,o=n-e||0,i=Array(0>o?0:o);++r<o;)i[r]=t[e+r];return i}e.exports=n},{}],23:[function(t,e){function n(t){return!(t&&"function"==typeof t&&t.apply&&!t[i])}var r=t("ee"),o=t(1),i="nr@original",a=Object.prototype.hasOwnProperty,s=!1;e.exports=function(t){function e(t,e,r,a){function nrWrapper(){var n,i,s,c;try{i=this,n=o(arguments),s="function"==typeof r?r(n,i):r||{}}catch(u){d([u,"",[n,i,a],s])}f(e+"start",[n,i,a],s);try{return c=t.apply(i,n)}catch(l){throw f(e+"err",[n,i,l],s),l}finally{f(e+"end",[n,i,c],s)}}return n(t)?t:(e||(e=""),nrWrapper[i]=t,u(t,nrWrapper),nrWrapper)}function c(t,r,o,i){o||(o="");var a,s,c,f="-"===o.charAt(0);for(c=0;c<r.length;c++)s=r[c],a=t[s],n(a)||(t[s]=e(a,f?s+o:o,i,s))}function f(e,n,r){if(!s){s=!0;try{t.emit(e,n,r)}catch(o){d([o,e,n,r])}s=!1}}function u(t,e){if(Object.defineProperty&&Object.keys)try{var n=Object.keys(t);return n.forEach(function(n){Object.defineProperty(e,n,{get:function(){return t[n]},set:function(e){return t[n]=e,e}})}),e}catch(r){d([r])}for(var o in t)a.call(t,o)&&(e[o]=t[o]);return e}function d(e){try{t.emit("internal-error",e)}catch(n){}}return t||(t=r),e.inPlace=c,e.flag=i,e}},{1:22,ee:"QJf3ax"}]},{},["G9z0Bl",4,9]);</script>
<meta content="text/html; charset=UTF-8" http-equiv="Content-type">
<meta content="Silvereye, Zosterops lateralis, Silvereye Maps, Zosterops lateralis Maps" name="keywords">
<meta content="true" name="MSSmartTagsPreventParsing">
<meta content="EOL V2 Beta" name="app_version">
<meta content="178073175624351" property="fb:app_id">
<meta content="b66f2f698251d22cb57762567a66cab1" name="p:domain_verify">
<meta content="http://www.eol.org/pages/1177389/maps" property="og:url">
<meta content="Encyclopedia of Life" property="og:site_name">
<meta content="website" property="og:type">
<meta content="Silvereye - Zosterops lateralis - Maps - Encyclopedia of Life" property="og:title">
<meta content="http://media.eol.org/content/2015/01/28/02/66409_260_190.jpg" property="og:image">

<link href="http://www.eol.org/pages/1177389/maps" rel="canonical">
<link href="http://media.eol.org//assets/favicon-9de6ee8ce10b9ad7b2662236411f4539.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">
<link href="http://www.eol.org/opensearchdescription.xml" rel="search" title="Encyclopedia of Life" type="application/opensearchdescription+xml">
<link href="Silvereye%20-%20Zosterops%20lateralis%20-%20Maps%20-%20Encyclopedia%20of%20Life_files/application_pack-5d0e6b3d873a7348c53606e1081f416e.css" media="all" rel="stylesheet" type="text/css">
<!--[if IE 7]>
<link href="http://media.eol.org//assets/ie7-c57e47a075a11e68dc6c709f672e2d49.css" media="all" rel="stylesheet" type="text/css" />
<![endif]-->
<script src="Silvereye%20-%20Zosterops%20lateralis%20-%20Maps%20-%20Encyclopedia%20of%20Life_files/application-95dd1edb6072133d07900959e450e11e.js" type="text/javascript"></script>
<meta content="authenticity_token" name="csrf-param">
<meta content="019IkKiWgy27HcejF2ZHNSWCYWlZ7bCk38w9Ozdgxn0=" name="csrf-token">

</head>
<body>
<div id="central">
<div class="section" role="main">
<!-- ======================== -->

<div class="with_nav" id="page_heading">
<div class="site_column">
<div class="hgroup">
<h1 class="scientific_name">
<i>Zosterops lateralis</i>
<span class="assistive"> &amp;mdash; Maps</span>
</h1>
<h2 title="Preferred common name for this taxon.">
Silvereye
<small><a href="http://www.eol.org/pages/1177389/names">learn more about names for this taxon</a></small>
</h2>


</div>
<div class="page_actions">
<ul>
<li>
<a href="http://www.eol.org/collections/choose_collect_target?item_id=1177389&amp;item_type=TaxonConcept" class="button">Add to a collection</a>

</li>
<!-- - if @taxon_data && @taxon_data.downloadable? -->
<!-- %li -->
<!-- = link_to I18n.t(:download_data), taxon_overview_path(@taxon_page), :class => 'button', :onclick => 'return false' -->
</ul>
</div>

<ul class="nav">
<li><a href="http://www.eol.org/pages/1177389/overview">Overview</a></li>
<li><a href="http://www.eol.org/pages/1177389/details">Detail</a></li>
<li><a href="http://www.eol.org/pages/1177389/data">Data</a></li>
<li><a href="http://www.eol.org/pages/1177389/media">225 Media</a></li>
<li class="active"><a href="http://www.eol.org/pages/1177389/maps">3 Maps</a></li>
<li><a href="http://www.eol.org/pages/1177389/names">Names</a></li>
<li><a href="http://www.eol.org/pages/1177389/communities">Community</a></li>
<li><a href="http://www.eol.org/pages/1177389/resources">Resources</a></li>
<li><a href="http://www.eol.org/pages/1177389/literature">Literature</a></li>
<li><a href="http://www.eol.org/pages/1177389/updates">Updates</a></li>
<li></li>
</ul>
</div>
</div>
<div id="content">
<div class="site_column">
<div class="site_column" id="taxon_maps">
<div id="media_list">
<div class="article">
<div class="header">
<h3>Media tagged as 'map'</h3>
</div>
</div>

<div id="main">

<?php
$html = file_get_contents("http://localhost/maps_test/js-marker-clusterer-gh-pages/examples/speed_test_example.html");
echo $html;

// header("Location: http://localhost/maps_test/js-marker-clusterer-gh-pages/examples/speed_test_example.html"); 

// <iframe src="http://localhost/maps_test/js-marker-clusterer-gh-pages/examples/speed_test_example.html" style="width: 100%; height: 100%;">
    // <script>
    // // window.location.href='http://localhost/maps_test/js-marker-clusterer-gh-pages/examples/speed_test_example.html'; 
    // <script src="http://localhost/maps_test/js-marker-clusterer-gh-pages/examples/speed_test_example.html" type="text/javascript"></script>
    // </script>

?>




</div>

<div class="disclaimer copy">
<h3 class="assistive">Disclaimer</h3>
<p>EOL content is automatically assembled from many different content 
providers. As a result, from time to time you may find pages on EOL that
 are confusing.</p>
<p>To request an improvement, please leave a comment on the page. Thank you!</p>
</div>
</div>
</div>

<!-- ======================== -->
</div>
</div>
<div id="banner">
<div class="site_column">
<p>Become part of the EOL community—<a href="https://support.si.edu/site/SPageServer?pagename=EOL_email_signup&amp;s_src=nmnh_web_eol_banner">sign up for the EOL Newsletter today</a></p>
</div>
</div>
<div id="header">
<div class="section">
<h1><a href="http://www.eol.org/" title="This link will take you to the home page of the Encyclopedia of Life Web site">Encyclopedia of Life</a></h1>
<div class="global_navigation" role="navigation">
<h2 class="assistive">Global Navigation</h2>
<ul class="nav">
<li>
<a href="http://www.eol.org/discover">Education</a>
</li>
<li>
<a href="http://www.eol.org/help">Help</a>
</li>
<li>
<a href="http://www.eol.org/about">What is EOL?</a>
</li>
<li>
<a href="http://www.eol.org/news">EOL News</a>
</li>
<li>
<a href="https://support.si.edu/site/SPageServer?pagename=api_eol_main%5C&amp;s_src=web_eol_hl">Donate</a>
</li>
</ul>
</div>

<div class="actions">
<div class="language">
<p class="en" title="This is the currently selected language.">
<a href="http://www.eol.org/language"><span>
English
</span>
</a></p>
<ul>
<li class="ms">
<a href="http://www.eol.org/set_language?language=ms&amp;return_to=http%3A%2F%2Fwww.eol.org%2Fpages%2F1177389%2Fmaps" title="Switch the site language to bahasa Melayu">bahasa Melayu</a>
</li>
<li class="de">
<a href="http://www.eol.org/set_language?language=de&amp;return_to=http%3A%2F%2Fwww.eol.org%2Fpages%2F1177389%2Fmaps" title="Switch the site language to Deutsch">Deutsch</a>
</li>
<li class="en">
<a href="http://www.eol.org/set_language?language=en&amp;return_to=http%3A%2F%2Fwww.eol.org%2Fpages%2F1177389%2Fmaps" title="Switch the site language to English">English</a>
</li>
<li class="es">
<a href="http://www.eol.org/set_language?language=es&amp;return_to=http%3A%2F%2Fwww.eol.org%2Fpages%2F1177389%2Fmaps" title="Switch the site language to español">español</a>
</li>
<li class="fr">
<a href="http://www.eol.org/set_language?language=fr&amp;return_to=http%3A%2F%2Fwww.eol.org%2Fpages%2F1177389%2Fmaps" title="Switch the site language to français">français</a>
</li>
<li class="gl">
<a href="http://www.eol.org/set_language?language=gl&amp;return_to=http%3A%2F%2Fwww.eol.org%2Fpages%2F1177389%2Fmaps" title="Switch the site language to Galego">Galego</a>
</li>
<li class="it">
<a href="http://www.eol.org/set_language?language=it&amp;return_to=http%3A%2F%2Fwww.eol.org%2Fpages%2F1177389%2Fmaps" title="Switch the site language to Italiano">Italiano</a>
</li>
<li class="nl">
<a href="http://www.eol.org/set_language?language=nl&amp;return_to=http%3A%2F%2Fwww.eol.org%2Fpages%2F1177389%2Fmaps" title="Switch the site language to Nederlands">Nederlands</a>
</li>
<li class="nb">
<a href="http://www.eol.org/set_language?language=nb&amp;return_to=http%3A%2F%2Fwww.eol.org%2Fpages%2F1177389%2Fmaps" title="Switch the site language to Norsk bokmål">Norsk bokmål</a>
</li>
<li class="oc">
<a href="http://www.eol.org/set_language?language=oc&amp;return_to=http%3A%2F%2Fwww.eol.org%2Fpages%2F1177389%2Fmaps" title="Switch the site language to Occitan">Occitan</a>
</li>
<li class="pt-BR">
<a href="http://www.eol.org/set_language?language=pt-BR&amp;return_to=http%3A%2F%2Fwww.eol.org%2Fpages%2F1177389%2Fmaps" title="Switch the site language to português do Brasil">português do Brasil</a>
</li>
<li class="sv">
<a href="http://www.eol.org/set_language?language=sv&amp;return_to=http%3A%2F%2Fwww.eol.org%2Fpages%2F1177389%2Fmaps" title="Switch the site language to Svenska">Svenska</a>
</li>
<li class="tl">
<a href="http://www.eol.org/set_language?language=tl&amp;return_to=http%3A%2F%2Fwww.eol.org%2Fpages%2F1177389%2Fmaps" title="Switch the site language to Tagalog">Tagalog</a>
</li>
<li class="mk">
<a href="http://www.eol.org/set_language?language=mk&amp;return_to=http%3A%2F%2Fwww.eol.org%2Fpages%2F1177389%2Fmaps" title="Switch the site language to македонски">македонски</a>
</li>
<li class="sr">
<a href="http://www.eol.org/set_language?language=sr&amp;return_to=http%3A%2F%2Fwww.eol.org%2Fpages%2F1177389%2Fmaps" title="Switch the site language to српски језик">српски језик</a>
</li>
<li class="uk">
<a href="http://www.eol.org/set_language?language=uk&amp;return_to=http%3A%2F%2Fwww.eol.org%2Fpages%2F1177389%2Fmaps" title="Switch the site language to українська мова">українська мова</a>
</li>
<li class="ar">
<a href="http://www.eol.org/set_language?language=ar&amp;return_to=http%3A%2F%2Fwww.eol.org%2Fpages%2F1177389%2Fmaps" title="Switch the site language to ‫العربية">‫العربية</a>
</li>
<li class="zh-Hans">
<a href="http://www.eol.org/set_language?language=zh-Hans&amp;return_to=http%3A%2F%2Fwww.eol.org%2Fpages%2F1177389%2Fmaps" title="Switch the site language to 简体中文">简体中文</a>
</li>
<li class="zh-Hant">
<a href="http://www.eol.org/set_language?language=zh-Hant&amp;return_to=http%3A%2F%2Fwww.eol.org%2Fpages%2F1177389%2Fmaps" title="Switch the site language to 繁體中文">繁體中文</a>
</li>
<li class="ko">
<a href="http://www.eol.org/set_language?language=ko&amp;return_to=http%3A%2F%2Fwww.eol.org%2Fpages%2F1177389%2Fmaps" title="Switch the site language to 한국어">한국어</a>
</li>
</ul>
</div>
</div>
<form action="http://www.eol.org/search?q=" id="simple_search" method="get" role="search">
<h2 class="assistive">Search the site</h2>
<fieldset>
<label class="assistive" for="autocomplete_q">Search EOL</label>
<div class="text">
<input data-autocomplete="/search/autocomplete_taxon" data-include-site_search="form#simple_search" data-min-length="3" id="autocomplete_q" maxlength="250" name="q" placeholder="Search EOL ..." size="250" title="Enter a common name or a scientific name of a living creature you would like to know more about. You can also search for EOL members, collections and communities." type="text">
</div>
<input data_error="You must enter a search term." data_unchanged="Search EOL ..." name="search" value="Go" type="submit">
</fieldset>
</form>

<div class="session join">
<h3 class="assistive">Login or Create Account</h3>
<p>Become part of the <abbr title="Encyclopedia of Life">EOL</abbr> community!</p>
<p><a href="http://www.eol.org/users/register">Join <abbr title="Encyclopedia of Life">EOL</abbr> now</a></p>
<p>
Already a member?
<a href="http://www.eol.org/login?return_to=http%3A%2F%2Fwww.eol.org%2Fpages%2F1177389%2Fmaps">Sign in</a>
</p>
</div>

</div>
</div>
<div id="footer" role="contentinfo">
<div class="section">
<h2 class="assistive">Site information</h2>
<div class="wrapper">
<div class="about">
<h6>About EOL</h6>
<ul>
<li><a href="http://www.eol.org/about">What is EOL?</a></li>
<li><a href="http://www.eol.org/traitbank">What is TraitBank?</a></li>
<li><a href="http://blog.eol.org/">The EOL Blog</a></li>
<li><a href="http://www.eol.org/discover">Education</a></li>
<li><a href="http://www.eol.org/statistics">Statistics</a></li>
<li><a href="http://www.eol.org/info/glossary">Glossary</a></li>
<li><a href="http://podcast.eol.org/podcast">Podcasts</a></li>
<li><a href="https://support.si.edu/site/SPageServer?pagename=api_eol_main%5C&amp;s_src=web_eol_fl">Donate</a></li>
<li><a href="http://www.eol.org/info/citing">Citing EOL</a></li>
<li><a href="http://www.eol.org/help">Help</a></li>
<li><a href="http://www.eol.org/terms_of_use">Terms of Use</a></li>
<li><a href="http://www.eol.org/contact_us">Contact Us</a></li>
</ul>
</div>
<div class="learn_more">
<h6>Learn more about</h6>
<ul>
<li>
<ul>
<li><a href="http://www.eol.org/info/animals">Animals</a></li>
<li><a href="http://www.eol.org/info/mammals">Mammals</a></li>
<li><a href="http://www.eol.org/info/birds">Birds</a></li>
<li><a href="http://www.eol.org/info/amphibians">Amphibians</a></li>
<li><a href="http://www.eol.org/info/reptiles">Reptiles</a></li>
<li><a href="http://www.eol.org/info/fishes">Fishes</a></li>
</ul>
</li>
<li>
<ul>
<li><a href="http://www.eol.org/info/invertebrates">Invertebrates</a></li>
<li><a href="http://www.eol.org/info/crustaceans">Crustaceans</a></li>
<li><a href="http://www.eol.org/info/mollusks">Mollusks</a></li>
<li><a href="http://www.eol.org/info/insects">Insects</a></li>
<li><a href="http://www.eol.org/info/spiders">Spiders</a></li>
<li><a href="http://www.eol.org/info/worms">Worms</a></li>
</ul>
</li>
<li>
<ul>
<li><a href="http://www.eol.org/info/plants">Plants</a></li>
<li><a href="http://www.eol.org/info/flowering_plants">Flowering Plants</a></li>
<li><a href="http://www.eol.org/info/trees">Trees</a></li>
</ul>
<ul>
<li><a href="http://www.eol.org/info/fungi">Fungi</a></li>
<li><a href="http://www.eol.org/info/mushrooms">Mushrooms</a></li>
<li><a href="http://www.eol.org/info/molds">Molds</a></li>
</ul>
</li>
<li>
<ul>
<li><a href="http://www.eol.org/info/bacteria">Bacteria</a></li>
</ul>
<ul>
<li><a href="http://www.eol.org/info/algae">Algae</a></li>
</ul>
<ul>
<li><a href="http://www.eol.org/info/protists">Protists</a></li>
</ul>
<ul>
<li><a href="http://www.eol.org/info/archaea">Archaea</a></li>
</ul>
<ul>
<li><a href="http://www.eol.org/info/viruses">Viruses</a></li>
</ul>
</li>
</ul>
<div class="partners">
<h6><a href="http://www.biodiversitylibrary.org/">Biodiversity Heritage Library</a></h6>
<p>Visit the Biodiversity Heritage Library</p>
</div>
<ul class="social_media">
<li><a href="http://twitter.com/#%21/EOL" class="twitter" rel="nofollow">Twitter</a></li>
<li><a href="http://www.facebook.com/encyclopediaoflife" class="facebook" rel="nofollow">Facebook</a></li>
<li><a href="http://www.flickr.com/groups/encyclopedia_of_life/" class="flickr" rel="nofollow">Flickr</a></li>
<li><a href="http://www.youtube.com/user/EncyclopediaOfLife/" class="youtube" rel="nofollow">YouTube</a></li>
<li><a href="http://pinterest.com/eoflife/" class="pinterest" rel="nofollow">Pinterest</a></li>
<li><a href="http://vimeo.com/groups/encyclopediaoflife" class="vimeo" rel="nofollow">Vimeo</a></li>
<li><a href="http://plus.google.com/+encyclopediaoflife?prsrc=3" class="google_plus" rel="publisher"><img alt="&lt;span class=" translation_missing"="" title="translation missing: en.layouts.footer.google_plus">Google Plus" src="//ssl.gstatic.com/images/icons/gplus-32.png" /&gt;</a></li>
</ul>
</div>
<div class="questions">
<h6>Tell me more</h6>
<ul>
<li><a href="http://www.eol.org/info/about_biodiversity">What is biodiversity?</a></li>
<li><a href="http://www.eol.org/info/species_concepts">What is a species?</a></li>
<li><a href="http://www.eol.org/info/discovering_diversity">How are species discovered?</a></li>
<li><a href="http://www.eol.org/info/naming_species">How are species named?</a></li>
<li><a href="http://www.eol.org/info/taxonomy_phylogenetics">What is a biological classification?</a></li>
<li><a href="http://www.eol.org/info/invasive_species">What is an invasive species?</a></li>
<li><a href="http://www.eol.org/info/indicator_species">What is an indicator species?</a></li>
<li><a href="http://www.eol.org/info/model_organism">What is a model organism?</a></li>
<li><a href="http://www.eol.org/info/contribute_research">How can I contribute to research?</a></li>
<li><a href="http://www.eol.org/info/evolution">What is evolution?</a></li>
</ul>
</div>
</div>
</div>


</div>
<script src="Silvereye%20-%20Zosterops%20lateralis%20-%20Maps%20-%20Encyclopedia%20of%20Life_files/head.js" type="text/javascript"></script>
<script>
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-3298646-10']);
  _gaq.push(['_trackPageview']);
  EOL.after_onload_JS(('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js');
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-3298646-12', 'eol.org');
  ga('send', 'pageview');
</script>
<script>
  var _qevents = _qevents || [];
  _qevents.push( { qacct:"p-4apKRWRet-IDY"} );
  EOL.after_onload_JS((document.location.protocol == 'https:' ? 'https://secure' : 'http://edge') + '.quantserve.com/quant.js');
</script>
<noscript>
<div style='display: none;'>
<img alt='' height='1' src='http://pixel.quantserve.com/pixel/p-4apKRWRet-IDY.gif' width='1'>
</div>
</noscript>
<script src="Silvereye%20-%20Zosterops%20lateralis%20-%20Maps%20-%20Encyclopedia%20of%20Life_files/webtrends-92726b1d5deb10270efcb59ac081b531.js" type="text/javascript"></script>
<script>
  (function() {
    var _tag=new WebTrends();
    _tag.dcsGetId();
    _tag.dcsCollect();
  })();
</script>
<noscript>
<div style='display: none;'>
<img alt='' height='1' id='DCSIMG' src='http://logs1.smithsonian.museum/dcsg0chobadzpxfga2extd7pb_7c2s/njs.gif?dcsuri=/nojavascript&amp;amp;WT.js=No&amp;amp;WT.tv=9.4.0&amp;amp;dcssip=www.eol.org' width='1'>
</div>
</noscript>



<script src="Silvereye%20-%20Zosterops%20lateralis%20-%20Maps%20-%20Encyclopedia%20of%20Life_files/ga.js" type="text/javascript"></script><script src="Silvereye%20-%20Zosterops%20lateralis%20-%20Maps%20-%20Encyclopedia%20of%20Life_files/quant.js" type="text/javascript"></script></body></html>