<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php include "user.php" ?>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Crash Box</title>
    <link href="timemap.2.0/lib/masterlaunch.css" type="text/css" rel="stylesheet"/>
    <link href='http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold' rel='stylesheet' type='text/css' />
   <script src="http://maps.google.com/maps?file=api&v=2&sensor=false&key=ABQIAAAAMZNg41bN521EXFwwh7cujhSpfjEP2QVILgdw8WK32V8c54kxEhTj9YRAas47HINQnOR-2mAByhouIQ"
      type="text/javascript"></script>
      <script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
    <script type="text/javascript" src="timemap.2.0/lib/jquery-1.5.1.js"></script>
   
	<script type="text/javascript" src="timemap.2.0/lib/jquery.easing.1.3.js"></script>
	   
    <!--<script type="text/javascript" src="timemap.2.0/lib/mxn/mxn.js?(googlev3)"></script>
    <script type="text/javascript" src="timemap.2.0/lib/timeline-2.3.0.js"></script>
    <script src="timemap.2.0/src/timemap.js" type="text/javascript"></script>
    <script src="timemap.2.0/src/param.js" type="text/javascript"></script>
    <script src="timemap.2.0/src/loaders/xml.js" type="text/javascript"></script>
    <script src="timemap.2.0/src/loaders/kml.js" type="text/javascript"></script>
     <script src="timemap.2.0/src/loaders/georss.js" type="text/javascript"></script>-->
     
  
  
   
        <script src="http://crash-box.fr/javascripts/timeline_js/timeline-api.js"    
 *     type="text/javascript">
 *   </script>
  <script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
 <script>
 Timeline_ajax_url="http://crash-box.fr/javascripts/timeline_ajax/simile-ajax-api.js";
 Timeline_urlPrefix="http://crash-box.fr/javascripts/timeline_js/";       
 Timeline_parameters='bundle=true';
 </script>	
  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src="slidingsite/lib/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="slidingsite/lib/mxn/mxn.js?(googlev3)"></script>
    <script src="slidingsite/src/timemap.js" type="text/javascript"></script>
      <script src="slidingsite/src/param.js" type="text/javascript"></script>
    <script src="slidingsite/src/loaders/xml.js" type="text/javascript"></script>
    <script src="slidingsite/src/loaders/georss.js" type="text/javascript"></script>
  
     
	 <script>
  var tl;

  var zoomLevel = 2;
  var zoomLevelMonths = 2;
  var zoomLevelWeeks = 1;
  var zoomLevelDays = 0;

  var ladate = new Date();
  ladate = ladate.toGMTString();


function onLoad() {
  var eventSource = new Timeline.DefaultEventSource();
  var eventSource1 = new Timeline.DefaultEventSource();
  var eventSource2 = new Timeline.DefaultEventSource();
  var eventSource3 = new Timeline.DefaultEventSource();
  var zoomStepsArray = new Array(
              {pixelsPerInterval: 400,  unit: Timeline.DateTime.DAY},
              //{pixelsPerInterval: 200,  unit: Timeline.DateTime.DAY},
              //{pixelsPerInterval: 100,  unit: Timeline.DateTime.DAY},
              //{pixelsPerInterval:  50,  unit: Timeline.DateTime.DAY},
              //{pixelsPerInterval: 400,  unit: Timeline.DateTime.MONTH},
              //{pixelsPerInterval: 200,  unit: Timeline.DateTime.MONTH},
              {pixelsPerInterval: 400,  unit: Timeline.DateTime.WEEK},
              {pixelsPerInterval: 400,  unit: Timeline.DateTime.MONTH} // DEFAULT zoomIndex
            );
            
   var bandInfos = [
     Timeline.createBandInfo({
	       eventSource:    eventSource3,
          date:           "Jun 28 2011 00:00:00 GMT",
          width:          "70px", 
          intervalUnit:   Timeline.DateTime.MONTH, 
          intervalPixels: 400,
		      zoomIndex:      zoomLevel,
          zoomSteps:      zoomStepsArray
		 
     }),
	  Timeline.createBandInfo({
	 eventSource:    eventSource2,
          date:           "Jun 28 2011 00:00:00 GMT",
          width:          "70px", 
          intervalUnit:   Timeline.DateTime.MONTH, 
          intervalPixels: 400,
		      zoomIndex:      zoomLevel,
          zoomSteps:      zoomStepsArray
     }),
	  Timeline.createBandInfo({
	        eventSource:    eventSource1,
          date:           "Jun 28 2011 00:00:00 GMT",
          width:          "70px", 
          intervalUnit:   Timeline.DateTime.MONTH, 
          intervalPixels: 400,
		      zoomIndex:      zoomLevel,
          zoomSteps:      zoomStepsArray
     }),
	 Timeline.createBandInfo({
	        eventSource:    eventSource,
          date:           "Jun 28 2011 00:00:00 GMT",
          width:          "70px", 
          intervalUnit:   Timeline.DateTime.MONTH, 
          intervalPixels: 400,
		      zoomIndex:      zoomLevel,
          zoomSteps:      zoomStepsArray
     }),
     Timeline.createBandInfo({
	     /* eventSource:    eventSource,*/
          date:           "Jun 28 2011 00:00:00 GMT",
          width:          "30px", 
          intervalUnit:   Timeline.DateTime.MONTH, 
          intervalPixels: 600,
		      zoomIndex:      zoomLevel,
          zoomSteps:      zoomStepsArray		 
     }),	 
	  Timeline.createBandInfo({
	     /* eventSource:    eventSource,*/
          date:           "Jun 28 2011 00:00:00 GMT",
           width:          "100px", 
          intervalUnit:   Timeline.DateTime.MONTH, 
          intervalPixels: 400
     }),
	  Timeline.createBandInfo({
	       <!-- eventSource:    eventSource3,    -->
          date:           "Jun 28 2011 00:00:00 GMT",
          width:          "50px", 
          intervalUnit:   Timeline.DateTime.MONTH, 
          intervalPixels: 400,
		      zoomIndex:      zoomLevel,
          zoomSteps:      zoomStepsArray
     }),
   ];
    var tomorrow = new Date();
    tomorrow.setTime(tomorrow.getTime() + (1000 * 3600 * 24));
<!--   ********TEST SETTING A COLOR BAND FOR DATE *************-->
   for (var i = 0; i < bandInfos.length; i++) {
      if (i != 4) {
         bandInfos[i].syncWith = 4;
          bandInfos[i].highlight = true;   
      }
      if (i != 5) {
				  bandInfos[i].highlight = true;
                bandInfos[i].decorators = [
                    new Timeline.SpanHighlightDecorator({
                        startDate:  ladate,
                        endDate:    tomorrow,
                        color:      "#FF0000",
                        opacity:    ((i != 4) ? 10 : 100),
                        startLabel: "",
                        endLabel:   ((i != 4) ? "" : ""),
                       // theme:      theme,
                       cssClass: 't-highlight1'
                    }),
                  /*  new Timeline.PointHighlightDecorator({
                        date:       "Tues Apr 5 2011 14:38:00 GMT-0600",
                        color:      "#FFC080",
                        opacity:    50,
                        //theme:      theme,
                        cssClass: 'p-highlight1'
                    }),
                    new Timeline.PointHighlightDecorator({
                        date:       "Tues Apr 5 2011 13:00:00 GMT-0600",
                        color:      "#FFC080",
                        opacity:    50
                        //theme:      theme
                    })*/
                ]; }
            }
   
			
			<!--   ********END TEST SETTING A COLOR BAND FOR DATE *************-->
    tl = Timeline.create(document.getElementById("my-timeline"), bandInfos);
    Timeline.loadXML("http://crash-box.fr/index.php?feed=timeline&cat=36", function(xml, url) { eventSource.loadXML(xml, url); });
    Timeline.loadXML("http://crash-box.fr/index.php?feed=timeline&cat=38", function(xml, url) { eventSource1.loadXML(xml, url); });
    Timeline.loadXML("http://crash-box.fr/index.php?feed=timeline&cat=37", function(xml, url) { eventSource2.loadXML(xml, url); });
    Timeline.loadXML("http://crash-box.fr/index.php?feed=timeline&cat=35", function(xml, url) { eventSource3.loadXML(xml, url); });

    tl.getBand(1).setCenterVisibleDate(Timeline.DateTime.parseGregorianDateTime(ladate));
 }
 var resizeTimerID = null;
 function onResize() {
     if (resizeTimerID == null) {
         resizeTimerID = window.setTimeout(function() {
             resizeTimerID = null;
             tl.layout();
         }, 500);
     }
 }
</script>
<!--   ***************END MASTER TIMELINE****************-->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><style type="text/css">
<!--
body {
	margin-top: 0px;
	margin-left: 0px;
	margin-right: 0px;
}
-->
    </style>

<!--************CODE FOR MAP AND TIMELINE******************      -->
    <script type="text/javascript">
                                       
function zoomTo(zoomNeeded) {
      var rtrndate = tl.getBand(1).getCenterVisibleDate();
      var zoomBool = (zoomLevel > zoomNeeded) ? true : false;
      
      while (zoomLevel != zoomNeeded) {
        for (var i = 0; i < 7; i++) {
          tl.getBand(i).zoom(zoomBool);
        }
        zoomLevel = ((zoomLevel > zoomNeeded) ? zoomLevel - 1 : zoomLevel + 1);
      }
      for (var i = 0; i < 7; i++) {
        tl.getBand(i).paint();
      }
      tl.getBand(1).setCenterVisibleDate(rtrndate);
}
function zoomToMonths() {
  zoomTo(zoomLevelMonths);
}
function zoomToWeeks() {
  zoomTo(zoomLevelWeeks);
}
function zoomToDays() {
  zoomTo(zoomLevelDays);
}                             
function zoomToToday() {
  tl.getBand(1).setCenterVisibleDate(Timeline.DateTime.parseGregorianDateTime(ladate));
}

function slideToLeft() {
/* REMINDER: Use getMinVisible and getMaxVisible to move by dynamic screen size instead*/
    var rtrntime = tl.getBand(1).getCenterVisibleDate();
    if (zoomLevel == zoomLevelMonths) {
      rtrntime.setTime(rtrntime.getTime() - ((1000 * 3600 * 24) * 30));
    } else if (zoomLevel == zoomLevelWeeks) {
      rtrntime.setTime(rtrntime.getTime() - ((1000 * 3600 * 24) * 7));
    } else if (zoomLevel == zoomLevelDays) {
      rtrntime.setTime(rtrntime.getTime() - ((1000 * 3600 * 24) * 1));
    };
    tl.getBand(1).setCenterVisibleDate(Timeline.DateTime.parseGregorianDateTime(rtrntime));
}

function slideToRight() {
    var rtrntime = tl.getBand(1).getCenterVisibleDate();
    if (zoomLevel == zoomLevelMonths) {
      rtrntime.setTime(rtrntime.getTime() + ((1000 * 3600 * 24) * 30));
    } else if (zoomLevel == zoomLevelWeeks) {3
      rtrntime.setTime(rtrntime.getTime() + ((1000 * 3600 * 24) * 7));
    } else if (zoomLevel == zoomLevelDays) {
      rtrntime.setTime(rtrntime.getTime() + ((1000 * 3600 * 24) * 1));
    };
    tl.getBand(1).setCenterVisibleDate(Timeline.DateTime.parseGregorianDateTime(rtrntime));
}

var tm;
$(function() {
 
    // make a custom map style
    var styledMapType = new google.maps.StyledMapType([
        {
            featureType: "water",
            elementType: "all",
			
            stylers: [
              { saturation: 0 },
              { lightness: 100 }
            ]
        },
        {
            featureType: "all",
            elementType: "all",
            stylers: [
              { saturation: -90 }
            ]
        }
    ], {
        name: "white"
    });
	//SET UP CUSTOM ICON FOR MAP
/*var customIcon = new google.maps.Marker({
		
		icon: templateURL+"/customicons/marker.png"
	})		*/
    tm = TimeMap.init({
        mapId: "map",               // Id of map div element (required)
        timelineId: "my-timeline",     // Id of timeline div element (required)
        options: {
            icon:			"http://crash-box.fr/customicons/marker.png",
        	iconShadow:		"http://crash-box.fr/customicons/marker.png",
        	iconShadowSize:	[30, 30],
        	iconAnchor:		[15, 15]
			
		/*mapType: "satellite",*/
			/*showMapCtrl: false,*/
			/*mapCenter: new google.maps.LatLng(33,65),*/
			/*mapZoom: 5
			/*icon: customIcon*/
			/*eventIconImage: "tm-timeline-event-but.png",
			eventIconPath: templateURL+"/images/"*/
        },
       datasets: [
            {
                title: "Recent Earthquakes",
                theme: "red",
                type: "georss", // Data to be loaded in GeoRSS - must be a local URL
                options: { 
                    // GeoRSS file to load
					
                    url: "rss_user.php",
                    // additional tags to load
                    extraTags: ['link'],
                    // custom template to use the extra data
                    infoTemplate: '<div class="infotitle">{{title}}</div>' + 
                                  '<div class="infodescription">{{description}}</div>'
                }
           
		   
		    }
        ],

       /* bandIntervals: [
            Timeline.DateTime.DECADE, 
            Timeline.DateTime.CENTURY
        ]*/
    });		
   // set the map to our custom style
    var gmap = tm.getNativeMap();
    gmap.mapTypes.set("white", styledMapType);
    gmap.setMapTypeId("white");

});

	

    </script>
    <link rel="stylesheet" type="text/css" media="screen" href="timemap.2.0/lib/demopage.css" /> 
<link rel="stylesheet" type="text/css" media="screen" href="timemap.2.0/lib/jquery.content-panel-switcher.css" /> 
<script type='text/javascript' src='timemap.2.0/lib/jquery.js'></script>
<script type='text/javascript' src='timemap.2.0/lib/jquery.content-panel-switcher.js'></script>  
<script type='text/javascript'>
$(document).ready(function() {
	jcps.fader(300, '#switcher-panel', '.set1');
	jcps.fader(300, '#switcher-panel2', '.set2');
	jcps.fader(300, '#switcher-panelbottom', '.set3');
});
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
</script>
</head>

 <body onLoad="onLoad();" onResize="onResize();">
  
<!-- **************SLIDING BACKGROUND CONTENT*********************-->
    <div id="header">
    <div id="subscription">
    <div id="subscriptiontext">
    <div class="block mid margin_auto"> <p><strong>Crash Box</strong> est une proposition artistique globale dont l'application interactive en ligne est une des apparitions.</p>
<p>Plateforme de distribution évolutive, <strong>Crash Box</strong> permet à ses membres connectés de propager en temps réel l'ensemble des informations et productions liées au développement du projet.</p>
<p>Si vous souhaitez bientôt prendre part à cette œuvre et devenir un des relais de cet essaimage, commencez par vous inscrire gratuitement sur la liste de diffusion du site.</p> <p>L'application interactive <strong>Crash Box</strong> sera opérationnelle à partir du 1er mai 2011.</p></div>
    </div>
    <div id="subscriptionform">
    <div id="mc_embed_signup">
<form action="http://crash-box.us2.list-manage1.com/subscribe/post?u=7990557be56e2ca87c95f68cf&amp;id=7293ef3dd2" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" style="font: normal 100% Arial, sans-serif;font-size: 10px;">
	<fieldset style="-moz-border-radius: 4px;border-radius: 4px;-webkit-border-radius: 4px;border: 0px solid #ccc;padding-top: .5em;margin: .5em 0;background-color: #fff;color: #000;text-align: left;">
	
<!--<div class="indicate-required" style="text-align: left;font-style: italic;overflow: hidden;color: #000;margin: 0 9% 0 0;">* indicates required</div>-->
<div class="mc-field-group" style="margin: 1.3em 5%;clear: both;overflow: hidden;">
<label for="mce-EMAIL" style="display: block;margin: .3em 0;line-height: 1em;font-weight: bold;">Adresse e-mail <strong class="note-required">*</strong>
</label>
<input type="text" value="" name="EMAIL" class="required email" id="mce-EMAIL" style="margin-right: 1.5em;border: 1px solid #ccc;padding: .2em .3em;width: 90%;float: left;z-index: 999;" />
</div>
<div class="mc-field-group" style="margin: 1.3em 5%;clear: both;overflow: hidden;">
    <label class="input-group-label" style="display: block;margin: .3em 0;line-height: 1em;font-weight: bold;">Format préféré </label>
    <div class="input-group" style="padding: .7em .7em .7em 0;font-size: .9em;margin: 0 0 1em 0;">
    <ul style="margin: 0;padding: 0;"><li style="list-style: none;overflow: hidden;padding: .2em 0;clear: left;display: block;margin: 0;"><input type="radio" value="html" name="EMAILTYPE" id="mce-EMAILTYPE-0" style="margin-right: 2%;padding: .2em .3em;width: auto;float: left;z-index: 999;" /><label for="mce-EMAILTYPE-0" style="display: block;margin: .4em 0 0 0;line-height: 1em;font-weight: bold;width: auto;float: left;text-align: left !important;">html</label></li>
<li style="list-style: none;overflow: hidden;padding: .2em 0;clear: left;display: block;margin: 0;"><input type="radio" value="text" name="EMAILTYPE" id="mce-EMAILTYPE-1" style="margin-right: 2%;padding: .2em .3em;width: auto;float: left;z-index: 999;" /><label for="mce-EMAILTYPE-1" style="display: block;margin: .4em 0 0 0;line-height: 1em;font-weight: bold;width: auto;float: left;text-align: left !important;">texte</label></li>
<li style="list-style: none;overflow: hidden;padding: .2em 0;clear: left;display: block;margin: 0;"><input type="radio" value="mobile" name="EMAILTYPE" id="mce-EMAILTYPE-2" style="margin-right: 2%;padding: .2em .3em;width: auto;float: left;z-index: 999;" /><label for="mce-EMAILTYPE-2" style="display: block;margin: .4em 0 0 0;line-height: 1em;font-weight: bold;width: auto;float: left;text-align: left !important;">mobile</label></li>
</ul>
    </div>
</div>
		<div id="mce-responses" style="float: left;top: -1.4em;padding: 0em .5em 0em .5em;overflow: hidden;width: 90%;margin: 0 5%;clear: both;">
			<div class="response" id="mce-error-response" style="display: none;margin: 1em 0;padding: 1em .5em .5em 0;font-weight: bold;float: left;top: -1.5em;z-index: 1;width: 80%;background: FBE3E4;color: #D12F19;"></div>
			<div class="response" id="mce-success-response" style="display: none;margin: 1em 0;padding: 1em .5em .5em 0;font-weight: bold;float: left;top: -1.5em;z-index: 1;width: 80%;background: #E3FBE4;color: #529214;"></div>
		</div>
		<div><input type="submit" value="Inscrivez-vous à la liste" name="subscribe" id="mc-embedded-subscribe" class="btn" style="clear: both;width: auto;display: block;margin: 1em 0 1em 5%;" /></div>
	</fieldset>	
	<a href="#" id="mc_embed_close" class="mc_embed_close" style="display: none;">Close</a>
</form>
</div>
<script type="text/javascript">
var fnames = new Array();var ftypes = new Array();fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[0]='EMAIL';ftypes[0]='email';
try {
    var jqueryLoaded=jQuery;
    jqueryLoaded=true;
} catch(err) {
    var jqueryLoaded=false;
}
var head= document.getElementsByTagName('head')[0];
if (!jqueryLoaded) {
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js';
    head.appendChild(script);
    if (script.readyState && script.onload!==null){
        script.onreadystatechange= function () {
              if (this.readyState == 'complete') mce_preload_check();
        }    
    }
}
var script = document.createElement('script');
script.type = 'text/javascript';
script.src = 'http://downloads.mailchimp.com/js/jquery.form-n-validate.js';
head.appendChild(script);
var err_style = '';
try{
    err_style = mc_custom_error_style;
} catch(e){
    err_style = 'margin: 1em 0 0 0; padding: 1em 0.5em 0.5em 0.5em; background: FFEEEE none repeat scroll 0% 0%; font-weight: bold; float: left; z-index: 1; width: 80%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; color: FF0000;';
}
var head= document.getElementsByTagName('head')[0];
var style= document.createElement('style');
style.type= 'text/css';
if (style.styleSheet) {
  style.styleSheet.cssText = '.mce_inline_error {' + err_style + '}';
} else {
  style.appendChild(document.createTextNode('.mce_inline_error {' + err_style + '}'));
}
head.appendChild(style);
setTimeout('mce_preload_check();', 250);

var mce_preload_checks = 0;
function mce_preload_check(){
    if (mce_preload_checks>40) return;
    mce_preload_checks++;
    try {
        var jqueryLoaded=jQuery;
    } catch(err) {
        setTimeout('mce_preload_check();', 250);
        return;
    }
    try {
        var validatorLoaded=jQuery("#fake-form").validate({});
    } catch(err) {
        setTimeout('mce_preload_check();', 250);
        return;
    }
    mce_init_form();
}
function mce_init_form(){
    jQuery(document).ready( function($) {
      var options = { errorClass: 'mce_inline_error', errorElement: 'div', onkeyup: function(){}, onfocusout:function(){}, onblur:function(){}  };
      var mce_validator = $("#mc-embedded-subscribe-form").validate(options);
      options = { url: 'http://crash-box.us2.list-manage1.com/subscribe/post-json?u=7990557be56e2ca87c95f68cf&id=7293ef3dd2&c=?', type: 'GET', dataType: 'json', contentType: "application/json; charset=utf-8",
                    beforeSubmit: function(){
                        $('#mce_tmp_error_msg').remove();
                        $('.datefield','#mc_embed_signup').each(
                            function(){
                                var txt = 'filled';
                                var fields = new Array();
                                var i = 0;
                                $(':text', this).each(
                                    function(){
                                        fields[i] = this;
                                        i++;
                                    });
                                $(':hidden', this).each(
                                    function(){
                                    	if ( fields[0].value=='MM' && fields[1].value=='DD' && fields[2].value=='YYYY' ){
                                    		this.value = '';
									    } else if ( fields[0].value=='' && fields[1].value=='' && fields[2].value=='' ){
                                    		this.value = '';
									    } else {
	                                        this.value = fields[0].value+'/'+fields[1].value+'/'+fields[2].value;
	                                    }
                                    });
                            });
                        return mce_validator.form();
                    }, 
                    success: mce_success_cb
                };
      $('#mc-embedded-subscribe-form').ajaxForm(options);      
      
    });
}
function mce_success_cb(resp){
    $('#mce-success-response').hide();
    $('#mce-error-response').hide();
    if (resp.result=="success"){
        $('#mce-'+resp.result+'-response').show();
        $('#mce-'+resp.result+'-response').html(resp.msg);
        $('#mc-embedded-subscribe-form').each(function(){
            this.reset();
    	});
    } else {
        var index = -1;
        var msg;
        try {
            var parts = resp.msg.split(' - ',2);
            if (parts[1]==undefined){
                msg = resp.msg;
            } else {
                i = parseInt(parts[0]);
                if (i.toString() == parts[0]){
                    index = parts[0];
                    msg = parts[1];
                } else {
                    index = -1;
                    msg = resp.msg;
                }
            }
        } catch(e){
            index = -1;
            msg = resp.msg;
        }
        try{
            if (index== -1){
                $('#mce-'+resp.result+'-response').show();
                $('#mce-'+resp.result+'-response').html(msg);            
            } else {
                err_id = 'mce_tmp_error_msg';
                html = '<div id="'+err_id+'" style="'+err_style+'"> '+msg+'</div>';
                
                var input_id = '#mc_embed_signup';
                var f = $(input_id);
                if (ftypes[index]=='address'){
                    input_id = '#mce-'+fnames[index]+'-addr1';
                    f = $(input_id).parent().parent().get(0);
                } else if (ftypes[index]=='date'){
                    input_id = '#mce-'+fnames[index]+'-month';
                    f = $(input_id).parent().parent().get(0);
                } else {
                    input_id = '#mce-'+fnames[index];
                    f = $().parent(input_id).get(0);
                }
                if (f){
                    $(f).append(html);
                    $(input_id).focus();
                } else {
                    $('#mce-'+resp.result+'-response').show();
                    $('#mce-'+resp.result+'-response').html(msg);
                }
            }
        } catch(e){
            $('#mce-'+resp.result+'-response').show();
            $('#mce-'+resp.result+'-response').html(msg);
        }
    }
}

</script>
<!--End mc_embed_signup-->
</div>
</div>

<div id="background">
    <table>
<tr>
<td>
<div class="block mid margin_auto">
	<div class="contheader">
 
		<div class="nav_buttons"> 
			<a id="home" class="switcher set1">Le Projet</a> 
			<!--<a id="photography" class="switcher set1">GASC DÉMOLITION</a> -->
			<!--<a id="design" class="switcher set1">Subscribe</a> -->
			<!--<a id="music" class="switcher set1">Music</a> 
			<a id="about" class="switcher set1">About</a> -->
		</div> 
	</div>
		<div id="switcher-panel"></div>
		
		<!-- Dummy Data -->
		<div id="home-content" class="switcher-content set1 show">
		<h2>LE PROJET CRASH BOX</h2>
		<p>Crash Box installe le regard au centre d'une démolition par foudroyage intégral, temps fondateur d’une onde de choc. Sa propagation est assurée par un réseau de connexions Internet fédérées par l’application interactive en ligne www.crash-box.fr.
Crash Box diffuse en temps réel sur sa plateforme d’essaimage, les images du noyau des explosions. Chaque vidéo est tournée en caméra ultra-rapide (dont la temporalité au millième de seconde est synchrone avec le temps des détonations successives) protégée d’une crash box et placée au cœur du bâti foudroyé.</p>
<p>Au temps-T d’une transmission, chaque personne connectée, localisée simultanément sur une mappemonde, devient un relais de l’onde de choc. L’ensemble des connexions en ligne déploie l’amplitude des explosions. 
Au final, Crash Box donnera lieu à la production d’un court-métrage projeté en salle de cinéma.</p>

<p>Mené en collaboration avec l’entreprise GINGER-CEBTP DÉMOLITION comme un laboratoire de recherche, Crash Box se structure sous la forme d’un Atelier de l’Euroméditerranée dans le cadre du programme de Marseille Provence 2013.
Le compte à rebours est réglé au 31/12/2013, date de clôture contractuelle du projet.</p>

		</div>
		<div id="photography-content" class="switcher-content set1">
		
				</div>
		<div id="design-content" class="switcher-content set1">
		
        Entry to the Crash Box project is marked by a halt in the countdown procedure.
With every new piece of information on the development of the Crash Box project, you will receive a warning by Email set to its transmission time. 
The whole chronology of the artistic laboratory, from the date of your subscription up until the closing date of the project on 31/12/2013, will be communicated in the form of a discount. 
If you wish to receive all of the alerts that will give rhythm to the evolution of this project, please subscribe with the form below.
The Gasc Démolition team thanks you for your interest in the Crash Box project.

		
		</div>
		<div id="music-content" class="switcher-content set1">
		<h2>Music</h2>
		Lorem ipsum ea cum congue bonorum, pri no natum clita. His ne vide omnis forensibus. Eum cetero imperdiet et. Id mutat mazim quo, recusabo consequat scribentur te pro, nam laudem eripuit at.
		<br/>
		Inani nominati sit eu. Te ubique cotidieque philosophia mel, vix id omnes iudico prompta. Ex usu nihil mediocritatem. Sea quod vituperata no, omittam offendit vel in. Noster voluptua luptatum id mea. Et voluptatum adversarium usu, rebum nominati recteque vix ei.
		</div>
		<div id="about-content" class="switcher-content set1">
		<h2>About</h2>
		Lorem ipsum ea cum congue bonorum, pri no natum clita. His ne vide omnis forensibus. Eum cetero imperdiet et. Id mutat mazim quo, recusabo consequat scribentur te pro, nam laudem eripuit at.
		<br/>
		Inani nominati sit eu. Te ubique cotidieque philosophia mel, vix id omnes iudico prompta. Ex usu nihil mediocritatem. Sea quod vituperata no, omittam offendit vel in. Noster voluptua luptatum id mea. Et voluptatum adversarium usu, rebum nominati recteque vix ei.
		</div>
</div>
</td>
<td>
<div class="block2 mid margin_auto">
	<div class="contheader2">
   
   
		<div class="nav_buttons"> 
			<!--<a id="experience" class="switcher set2">L’ÉQUIPE DE CRASH BOX</a> -->
			<a id="gasc" class="switcher set2">GASC DÉMOLITION</a>
            <a id="sextant" class="switcher set2">Sextant ET Plus</a> 
			<a id="ginger" class="switcher set2">GINGER-CEBTP DÉMOLITION</a> 
			<a id="sublab" class="switcher set2">SUBLAB</a> 
			<a id="dannexe" class="switcher set2">DESIGNANNEXE</a>
         
		</div> 
	</div>
		<div id="switcher-panel2"></div>
		
		<!-- Dummy Data -->
		<div id="experience-content" class="switcher-content set2 show">
		<h2>L’ÉQUIPE DE CRASH BOX</h2>
		L’équipe de recherche en charge de l’étude et de la réalisation de la proposition artistique Crash Box est constituée de : GASC DÉMOLITION, entreprise de l’artiste plasticienne Anne-Valérie Gasc, SEXTANT ET PLUS, association de promotion et de diffusion de l’art contemporain, GINGER-CEBTP DÉMOLITION, entreprise d’ingénierie en démolition, SUBLAB PRODUCTION, laboratoire de création audiovisuelle et DESIGN ANNEXE, société de web développement spécialisée dans la medium vidéo.
		
		
		</div>
        
        <div id="gasc-content" class="switcher-content set2">
        <h2>GASC DÉMOLITION</h2>
		<p>GASC DÉMOLITION conduit les projets de l’artiste Anne-Valérie Gasc qui détermine les stratégies adéquates aux modalités d'ébranlement du réel.
Elle établit et expérimente les protocoles nécessaires à l’avènement de l’art par une tactique préalable de dévastation et de fuite. 
Ces propositions interrogent l'utopie de la table rase comme modalité de création.</p><p>

Récemment, GASC DÉMOLITION a procédé à l’étude et l’expérimentation de la démolition par onde sonore de la galerie Hladilnica (194 dB, Centre Culturel de Pekarna, Maribor, Slovénie, 2009), par sabotage hydraulique du Château d’Avignon (La Fuite, Les Saintes-Maries-de-la-Mer, France, 2009), par foudroyage intégral de la VF Galerie (Boum Blocs, Marseille, France, 2008) ou encore par embrasement généralisé éclair de la Maison Rouge (Blockhaus, Paris, France, 2006).

Son travail est consultable en ligne sur le site : <a href="http://www.documentsdartistes.org/gasc" target="_blank">www.documentsdartistes.org/gasc</a></p>
<p>
Contact : 
GASC DÉMOLITION
Anne-Valérie GASC
La Friche La Belle de Mai, 
41 rue Jobin, 13003 Marseille, FRANCE</p>
+33 (0)6 18 39 56 23
 <a href="mailto:gascdemolition@gmail.com">gascdemolition@gmail.com</a></div>
		<div id="sextant-content" class="switcher-content set2">
		<h2>SEXTANT ET PLUS</h2>
		Association de promotion, de diffusion de l’art contemporain et plateforme de production, Sextant et plus est producteur délégué et coordinateur du projet. L'association est également engagée sur le volet transmission de la proposition artistique.

        <a href="http://www.sextantetplus.org" target="_blank">www.sextantetplus.org</a>		</div>
		<div id="ginger-content" class="switcher-content set2">
		<h2>GINGER-CEBTP DÉMOLITION</h2>
		Entreprise d’ingénierie en démolition dont la mission couvre les champs conjugués de l’étude et l’accompagnement dans la conception technique du dispositif audiovisuel, la logistique et l’assistance chantier des équipes de tournage ainsi que la production des films virtuels des démolitions (modélisations 3D).

<a href="http://www.cebtpdemolition.com" target="_blank">www.cebtpdemolition.com</a>
		</div>
		<div id="sublab-content" class="switcher-content set2">
		<h2>SUBLAB PRODUCTION</h2>
		Laboratoire de création audiovisuelle dont la mission rassemble la production, la conception technique et la réalisation des films en caméras ultra-rapides ainsi que l’accompagnement de la production des films virtuels des démolitions.

<a href="http://www.sublab.tv" target="_blank">www.sublab.tv</a>
		</div>
		<div id="work-content" class="switcher-content set2 show">
			
		</div>
        	<div id="dannexe-content" class="switcher-content set2">
		<h2>DESIGNANNEXE</h2>
		Société de web développement spécialisée dans des projets impliquant la vidéo comme source principale de contenu, en charge de la conception et la maintenance du site Internet Crash Box et de la réalisation du système de diffusion simultanée et essaimée des vidéos sur le web.

<a href="http://annexe.squarespace.com" target="_blank">http://annexe.squarespace.com</a>
		</div>
</div>
</td>
</tr>
</table>
   
</div>
    
    
   	<!--	<div id="headercontrols">
   			
           <div id="enter"><img src="gfx/entercrashbox.png" alt="" /></div>
           <div id="plus"><img src="gfx/plus.png" alt="" /></div>
           <div id="minus"><img src="gfx/minus.png" alt="" /></div>  
   		   </div>-->
 </div>


<!-- **************END SLIDING BACKGROUND CONTENT*********************-->

<!-- **************COMBINED TIMELINE+MAP*********************-->
<div id="timebox">
    

    
    
        <div id="timelinecontainer">
             
         
          <div id="my-timeline"></div>
           <div id="countdown">
       			<div id="logo">
	   <script language="javascript">
	if (AC_FL_RunContent == 0) {
		alert("This page requires AC_RunActiveContent.js.");
	} else {
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0',
			'width', '750',
			'height', '90',
			'src', 'Countdown_final',
			'quality', 'high',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'align', 'middle',
			'play', 'true',
			'loop', 'true',
			'scale', 'showall',
			'wmode', 'window',
			'devicefont', 'false',
			'id', 'Countdown_final',
			'wmode', 'transparent',
			'name', 'Countdown_final',
			'menu', 'true',
			'allowFullScreen', 'false',
			'allowScriptAccess','sameDomain',
			'movie', 'slidingsite/Countdown_final',
			'salign', ''
			); //end AC code
	}
</script>
<noscript>
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="750" height="90" id="Countdown_final" align="middle">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="allowFullScreen" value="false" />
	<param name="movie" value="slidingsite/Countdown_final.swf" /><param name="quality" value="high" /><param name="wmode" value="transparent" />	<embed src="slidingsite/Countdown_final.swf" quality="high" bgcolor="#ffffff" width="750" height="90" name="Countdown_final" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>
</noscript>
</div>
       			<div id="controls">
     <!--           <div id="timer">
	   <script language="javascript">
	if (AC_FL_RunContent == 0) {
		alert("This page requires AC_RunActiveContent.js.");
	} else {
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0',
			'width', '180',
			'height', '90',
			'src', 'control',
			'quality', 'high',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'align', 'middle',
			'play', 'true',
			'loop', 'true',
			'scale', 'showall',
			'wmode', 'transparent',
			'devicefont', 'false',
			'id', 'control',
			'bgcolor', '#ffffff',
			'name', 'control',
			'menu', 'true',
			'allowFullScreen', 'false',
			'allowScriptAccess','sameDomain',
			'movie', 'gfx/control',
			'salign', ''
			); //end AC code
	}
</script>
<noscript>
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="180" height="90" id="control" align="middle">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="allowFullScreen" value="false" />
    <param name="wmode" value="transparent" />
	<param name="movie" value="gfx/control.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" />	<embed src="gfx/control.swf" quality="high" bgcolor="#ffffff" width="180" height="90" name="control" align="middle" wmode="transparent" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>
</noscript>

</div>-->
<!--<div id="mapbt"><img src="gfx/timemapbt.png" alt="" /></div><div id="mapbt2"><img src="gfx/timemapbtback.png" alt="" /></div>--></div>
       
       </div>  
        
        </div>
        <div id="mapcontainer">
          <div id="map"></div>	
        </div>
      </div> 
<!-- **************END COMBINED TIMELINE+MAP*********************  -->

     <!--
 **************SLIDING FOOTER+CREDITS*********************    -->  
        
  
        
 
        
        
         <div id="footer">
         
        <!-- <div id="footercontrols">
   		
           <div id="footerplus"><img src="gfx/footerplus.png" alt="" /></div>
           <div id="footerminus"><img src="gfx/footerminus.png" alt="" /></div>  
   		   </div>-->
           
           <!--<div id="footerright"><img src="gfx/socmedia.png" alt="" /></div>-->
 
  <table>
<tr>
<td>
<div class="block mid margin_auto">
	<div class="contheader3">
		<div class="nav_buttons2"> 
			<a id="2013" class="switcher set3">Marseille 2013</a> 
			<a id="footer" class="switcher set3">Au Sujet du site</a> 
		
         
		</div> 
	</div>
		<div id="switcher-panelbottom"></div>
		

		<div id="2013-content" class="switcher-content set3 show">
		<h2>Marseille 2013</h2>
		CAPITALE EUROPÉENNE DE LA CULTURE
Marseille-Provence a été sélectionnée pour être Capitale Européenne de la Culture en 2013. Tout au long de l’année 2013, des centaines de manifestations culturelles et artistiques animeront tout le territoire de la Provence de Martigues à La Ciotat en passant par Istres, Arles, Salon de Provence, Aix-en-Provence, Gardanne, Aubagne… et bien entendu Marseille.


Marseille-Provence donne rendez-vous au monde en 2013 pour une année Capitale.
	
		
		
		</div>
		<div id="footer-content" class="switcher-content set3">
		<h2>AU SUJET DU SITE</h2>
		The Crash Box site uses code and libraries from many sources, but primarily  
Timemap by Nick Rabinowitz: http://code.google.com/p/timemap/. 

Timemap itself is a development of the Simile Timeline Project: http://www.simile-widgets.org/timeline/.

Site Design and concept by Steve Button | Designannexe
Additional programming Arnaud
		</div>
		<div id="credits-content" class="switcher-content set3">
		<h2>CRÉDITS</h2>
		Lorem ipsum ea cum congue bonorum, pri no natum clita. His ne vide omnis forensibus. Eum cetero imperdiet et. Id mutat mazim quo, recusabo consequat scribentur te pro, nam laudem eripuit at.
		<br/>
		Inani nominati sit eu. Te ubique cotidieque philosophia mel, vix id omnes iudico prompta. Ex usu nihil mediocritatem. Sea quod vituperata no, omittam offendit vel in. Noster voluptua luptatum id mea. Et voluptatum adversarium usu, rebum nominati recteque vix ei.
		</div>
		<div id="contact-content" class="switcher-content set3">
		<h2>Contact</h2>
	
		</div>
		<div id="work-content" class="switcher-content set3">
		<h2>Work</h2>
		Lorem ipsum ea cum congue bonorum, pri no natum clita. His ne vide omnis forensibus. Eum cetero imperdiet et. Id mutat mazim quo, recusabo consequat scribentur te pro, nam laudem eripuit at.
		<br/>
		Inani nominati sit eu. Te ubique cotidieque philosophia mel, vix id omnes iudico prompta. Ex usu nihil mediocritatem. Sea quod vituperata no, omittam offendit vel in. Noster voluptua luptatum id mea. Et voluptatum adversarium usu, rebum nominati recteque vix ei.
		</div>
        	<div id="cebtp-content" class="switcher-content set3">
		<h2>Work</h2>
		Lorem ipsum ea cum congue bonorum, pri no natum clita. His ne vide omnis forensibus. Eum cetero imperdiet et. Id mutat mazim quo, recusabo consequat scribentur te pro, nam laudem eripuit at.
		<br/>
		Inani nominati sit eu. Te ubique cotidieque philosophia mel, vix id omnes iudico prompta. Ex usu nihil mediocritatem. Sea quod vituperata no, omittam offendit vel in. Noster voluptua luptatum id mea. Et voluptatum adversarium usu, rebum nominati recteque vix ei.
		</div>
</div>
</td>
</tr>
</table>
   
   </div>
        
<!--  **************SLIDING FOOTER+CREDITS*********************    -->    
    
    
 
    
    <script>



/**********MAIN PANEL ANIM**************/
/**********HEADER**************/
/**********enter**************/
/*$("#enter").hover(function() {
 $(this).css('cursor','pointer');
 }, function() {
 $(this).css('cursor','auto');
});


$( "#enter" ).click(function(){
  $( "#header" ).animate({ top: "-470px" }, 500 )
 $( "#timebox" ).animate({ top: "30px" }, 500 )
 $("#plus").css({ opacity: 1 });
  $("#controls").css({ opacity: 1 });
   $( "#subscription" ).hide("slow");
 $( "#controls" ).show(2000);
  $( "#plus" ).show("slow");
 $( "#enter" ).hide();
 $("#footer").css({ opacity: 1 });
  $( "#footer" ).show("slow");
   $("#mapcontainer").css({ opacity: 1 });
  $( "#mapcontainer" ).show("slow").delay(2000);
   $( "#background" ).toggle();
});*/

/*$( "#plus" ).click(function(){
  $( "#header" ).animate({ top: "-10px" }, 500 )

$( "#timebox" ).animate({ top: "180px" }, 500 )

 
 $( "#plus" ).hide();
 $("#minus").css({ opacity: 1 });
 $( "#minus" ).show();

});

$( "#minus" ).click(function(){
  $( "#header" ).animate({ top: "-470px" }, 500 )
 $( "#timebox" ).animate({ top: "30px" }, 500 )
  $( "#plus" ).show();
 $( "#minus" ).hide();
});*/


/**********FOOTER**************/
/*$( "#footerplus" ).click(function(){
  $("#footerminus").css({ opacity: 1 });
 $( "#footerminus" ).show();
  $( "#footerplus" ).hide();
  $( "#footer" )
  .animate({ top: "440px" }, 500 )
 
 $( "#timebox" ).animate({ top: "30px" }, 500 )
});


$( "#footerminus" ).click(function(){
  $( "#footer" ).animate({ top: "95%" }, 500 )
 
 $( "#timebox" ).animate({ top: "30px" }, 500 )
  $( "#footerplus" ).show();
   $( "#footerminus" ).hide();
});

*/




/**********TIMELINE/MAP**************/

/*$("#mapbt").click(function(){
  $( "#timebox" ).animate({ top: "-280px" }, 500 )
   $( "#header" ).animate({ top: "-470px" }, 500 )
 
  $("#mapbt2").css({ opacity: 1 });
    $( "#mapbt" ).hide();
	 $( "#mapbt2" ).show();
   $( "#plus" ).show();
    $( "#minus" ).hide();

});*/





/*$( "#mapbt2" ).click(function(){
$( "#mapbt" ).show();
$( "#mapbt2" ).hide();
  $( "#timebox" ).animate({ top: "30px" }, 500 )
   $( "#header" ).animate({ top: "-470px" }, 500 )

});*/
/**********MAIN ANIM end**************/


</script>

  
    
        </body>
</html>
