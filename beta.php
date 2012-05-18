<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php /*?><?php include "http//sameheart.designannexe.com/timemap.2.0/examples/user.php" ?><?php */?>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>The Same Heart</title>
    <link href="timemap.2.0/lib/master.css" type="text/css" rel="stylesheet"/>
    <link href='http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold' rel='stylesheet' type='text/css' />
   <script src="http://maps.google.com/maps?file=api&v=2&sensor=false&key=ABQIAAAA6_dV86BKC_gLYZ5tApeZ9xTSt96hixEnaeI_G75f3vOosJRVGxTF82F0dUIsP0tta6IBfx4oTYy2rw"
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
     
  
  
   <script src="http://sameheart.designannexe.com/javascripts/timeline_js/timeline-api.js" type="text/javascript"></script>
  <script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
 <script>
 Timeline_ajax_url="http://sameheart.designannexe.com/javascripts/timeline_ajax/simile-ajax-api.js";
 Timeline_urlPrefix="http://sameheart.designannexe.com/javascripts/timeline_js/";       
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
  
  var customTheme = Timeline.ClassicTheme.create(); 
	customTheme.event.bubble.width = 520; 
	/*customTheme.event.bubble.height = 520;*/
	customTheme.event.bubble.maxWidth = 520; 
	/*customTheme.event.bubble.maxHeight = 520;*/ 

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
          zoomSteps:      zoomStepsArray,
        theme:				customTheme
		 
     }),
	  Timeline.createBandInfo({
	 eventSource:    eventSource2,
          date:           "Jun 28 2011 00:00:00 GMT",
          width:          "70px", 
          intervalUnit:   Timeline.DateTime.MONTH, 
          intervalPixels: 400,
		      zoomIndex:      zoomLevel,
          zoomSteps:      zoomStepsArray,
        theme:				customTheme
     }),
	  Timeline.createBandInfo({
	        eventSource:    eventSource1,
          date:           "Jun 28 2011 00:00:00 GMT",
          width:          "70px", 
          intervalUnit:   Timeline.DateTime.MONTH, 
          intervalPixels: 400,
		      zoomIndex:      zoomLevel,
          zoomSteps:      zoomStepsArray,
        theme:				customTheme
     }),
	 Timeline.createBandInfo({
	        eventSource:    eventSource,
          date:           "Jun 28 2011 00:00:00 GMT",
          width:          "70px", 
          intervalUnit:   Timeline.DateTime.MONTH, 
          intervalPixels: 400,
		      zoomIndex:      zoomLevel,
          zoomSteps:      zoomStepsArray,
        theme:				customTheme
     }),
     Timeline.createBandInfo({
	     /* eventSource:    eventSource,*/
          date:           "Jun 28 2011 00:00:00 GMT",
          width:          "30px", 
          intervalUnit:   Timeline.DateTime.MONTH, 
          intervalPixels: 600,
		      zoomIndex:      zoomLevel,
          zoomSteps:      zoomStepsArray,
        theme:				customTheme		 
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
          zoomSteps:      zoomStepsArray,
        theme:				customTheme
     })
   ];
    var tomorrow = new Date();
    tomorrow.setTime(tomorrow.getTime() + (1000 * 3600 * 24));
    
    var i = 0;
    while (i < bandInfos.length) {
    	if (bandInfos[i] != null) {
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
						opacity:    ((i != 4) ? ((i == 6) ? 30 : 10) : 100),
						startLabel: "",
						endLabel:   ((i != 4) ? "" : ""),
						cssClass: 't-highlight1'
					})
				];
			}
		}
		else { alert("NULL__" + i + "__/__" + bandInfos.length + "__"); }
		i++;
	}
   
    tl = Timeline.create(document.getElementById("my-timeline"), bandInfos);
    Timeline.loadXML("http://sameheart.designannexe.com/index.php?feed=timeline&cat=4", function(xml, url) { eventSource.loadXML(xml, url); });
    Timeline.loadXML("http://sameheart.designannexe.com/index.php?feed=timeline&cat=4", function(xml, url) { eventSource1.loadXML(xml, url); });
    Timeline.loadXML("http://sameheart.designannexe.com/index.php?feed=timeline&cat=4", function(xml, url) { eventSource2.loadXML(xml, url); });
    Timeline.loadXML("http://sameheart.designannexe.com/index.php?feed=timeline&cat=4", function(xml, url) { eventSource3.loadXML(xml, url); });

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
  tl.getBand(1).scrollToCenter(Timeline.DateTime.parseGregorianDateTime(ladate));
}

function slideToLeft() {
	var rtrntime = tl.getBand(1).getMinVisibleDate();
	tl.getBand(1).scrollToCenter(Timeline.DateTime.parseGregorianDateTime(rtrntime));
}

function slideToRight() {
    var rtrntime = tl.getBand(1).getMaxVisibleDate();
    tl.getBand(1).scrollToCenter(Timeline.DateTime.parseGregorianDateTime(rtrntime));
}

var tm;
$(function() {
 
    // make a custom map style
    var styledMapType = new google.maps.StyledMapType([
        {
            featureType: "water",
            elementType: "all",
			
            stylers: [
              { saturation: 30 },
              { lightness: 50 }
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
            icon:			"http://sameheart.designannexe.com/customicons/marker.png",
        	iconShadow:		"http://sameheart.designannexe.com/customicons/marker.png",
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
					
                    url: "newvisitors.php",
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

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-21908527-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</head>

 <body onLoad="onLoad();" onResize="onResize();">
  
<!-- **************SLIDING BACKGROUND CONTENT*********************-->
    <div id="header">
    <div id="subscription">
    <div id="subscriptiontext">
    <div class="block mid margin_auto"> <blockquote>Suspendisse semper, magna eu blandit pellentesque, elit purus tristique orci, sit amet congue lectus purus ut nisi. Curabitur mollis purus sed purus commodo vitae malesuada sem viverra? Nunc mattis cursus elit, eget accumsan diam semper a. Mauris imperdiet fringilla ipsum, sed ultrices nunc auctor vel.
</blockquote> 
</div>
    </div>
    <div id="subscriptionform">
    <p>Suspendisse semper, magna eu blandit pellentesque, elit purus tristique orci, sit amet congue lectus purus ut nisi. Curabitur mollis purus sed purus commodo vitae malesuada sem viverra? Nunc mattis cursus elit, eget accumsan diam semper a. Mauris imperdiet fringilla ipsum, sed ultrices nunc auctor vel. 
</p>
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
<!--<h2>LE PROJET CRASH BOX</h2>-->
	<!--<div class="contheader">
 
		<div class="nav_buttons"> 
			<a id="home" class="switcher set1">Le Projet</a> 
			<a id="photography" class="switcher set1">GASC DÉMOLITION</a> 
			<a id="design" class="switcher set1">Subscribe</a> 
			<a id="music" class="switcher set1">Music</a> 
			<a id="about" class="switcher set1">About</a> 
		</div> 
	</div>-->
		<div id="switcher-panel"></div>
		
		<!-- Dummy Data -->
		<div id="home-content" class="switcher-content set1 show">
		<!--<h2>LE PROJET CRASH BOX</h2>-->
		<blockquote>Suspendisse semper, magna eu blandit pellentesque, elit purus tristique orci, sit amet congue lectus purus ut nisi. Curabitur mollis purus sed purus commodo vitae malesuada sem viverra? Nunc mattis cursus elit, eget accumsan diam semper a. Mauris imperdiet fringilla ipsum, sed ultrices nunc auctor vel. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Integer porta pellentesque vulputate.
</blockquote>



		</div>
		<div id="photography-content" class="switcher-content set1">
		
				</div>
		<div id="design-content" class="switcher-content set1">
		
      Suspendisse semper, magna eu blandit pellentesque, elit purus tristique orci, sit amet congue lectus purus ut nisi. Curabitur mollis purus sed purus commodo vitae malesuada sem viverra? Nunc mattis cursus elit, eget accumsan diam semper a. Mauris imperdiet fringilla ipsum, sed ultrices nunc auctor vel. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Integer porta pellentesque vulputate. Mauris sed purus ac lorem sodales ullamcorper. Phasellus velit urna, sagittis 

		
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
  <!-- <h2>L’ÉQUIPE DE CRASH BOX</h2>-->
	<div class="contheader2">
   

		<div class="nav_buttons"> 
			<!--<a id="experience" class="switcher set2">L’ÉQUIPE DE CRASH BOX</a> -->
			<a id="gasc" class="switcher set2">The Focus of the Site</a>
            <a id="sextant" class="switcher set2">What You Are Seeing</a> 
			<a id="ginger" class="switcher set2">Contributing</a> 
			<a id="sublab" class="switcher set2">Sharing</a> 
			<!--<a id="dannexe" class="switcher set2">DESIGNANNEXE</a>-->
         
		</div> 
	</div>
		<div id="switcher-panel2"></div>
		
		<!-- Dummy Data -->
		<div id="gasc-content" class="switcher-content set2 show">
		<h2>SAME HEART</h2>
	<p>Suspendisse semper, magna eu blandit pellentesque, elit purus tristique orci, sit amet congue lectus purus ut nisi. Curabitur mollis purus sed purus commodo vitae malesuada sem viverra? Nunc mattis cursus elit, eget accumsan diam semper a. Mauris imperdiet fringilla ipsum, sed ultrices nunc auctor vel. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Integer porta pellentesque vulputate. Mauris sed purus ac lorem sodales ullamcorper. Phasellus velit urna, sagittis vitae scelerisque a, adipiscing sed mi? Suspendisse eget elit diam. Nullam lobortis turpis dolor, vel euismod enim. Etiam arcu libero, porta at dignissim nec; ullamcorper semper dui. Curabitur ac lacus nisi, eget tincidunt orci. Vivamus orci diam, viverra et pellentesque quis, luctus eu massa. Fusce aliquet nibh nec elit dapibus adipiscing. Aliquam a lacus non massa posuere tincidunt vitae id nisl.
</p>

</div>
        
        <div id="gascx-content" class="switcher-content set2">
        <h2>SAME HEART</h2>
		<p>Suspendisse semper, magna eu blandit pellentesque, elit purus tristique orci, sit amet congue lectus purus ut nisi. Curabitur mollis purus sed purus commodo vitae malesuada sem viverra? Nunc mattis cursus elit, eget accumsan diam semper a. Mauris imperdiet fringilla ipsum, sed ultrices nunc auctor vel. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Integer porta pellentesque vulputate. Mauris sed purus ac lorem sodales ullamcorper. Phasellus velit urna, sagittis vitae scelerisque a, adipiscing sed mi? Suspendisse eget elit diam. Nullam lobortis turpis dolor, vel euismod enim. Etiam arcu libero, porta at dignissim nec; ullamcorper semper dui. Curabitur ac lacus nisi, eget tincidunt orci. Vivamus orci diam, viverra et pellentesque quis, luctus eu massa. Fusce aliquet nibh nec elit dapibus adipiscing. Aliquam a lacus non massa posuere tincidunt vitae id nisl.
</p>
</div>
		<div id="sextant-content" class="switcher-content set2">
		<h2>Content That Moves</h2>
		<p>Suspendisse semper, magna eu blandit pellentesque, elit purus tristique orci, sit amet congue lectus purus ut nisi. Curabitur mollis purus sed purus commodo vitae malesuada sem viverra? Nunc mattis cursus elit, eget accumsan diam semper a. Mauris imperdiet fringilla ipsum, sed ultrices nunc auctor vel. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Integer porta pellentesque vulputate. Mauris sed purus ac lorem sodales ullamcorper. Phasellus velit urna, sagittis vitae scelerisque a</p>

        <p><a href="http://www.sextantetplus.org" target="_blank">www.sextantetplus.org</a></p>		</div>
		<div id="ginger-content" class="switcher-content set2">
		<h2>Media Voices</h2>
		<p>Suspendisse semper, magna eu blandit pellentesque, elit purus tristique orci, sit amet congue lectus purus ut nisi. </p>
        <object width="100%" height="300"><param name="allowFullScreen" value="true" /><param name="flashvars" value="showMenu=false"/><param name="movie" value="http://www.vuvox.com/collage_express/collage.swf?collageID=029d8005dc"/><embed src="http://www.vuvox.com/collage_express/collage.swf?collageID=029d8005dc" flashvars="showMenu=false" allowFullScreen="true" type="application/x-shockwave-flash" width="100%" height="300"></embed></object>
<p><a href="http://www.cebtpdemolition.com" target="_blank">www.cebtpdemolition.com</a></p>
		</div>
		<div id="sublab-content" class="switcher-content set2">
		<h2>Another</h2>
		<p>Suspendisse semper, magna eu blandit pellentesque, elit purus tristique orci, sit amet congue lectus purus ut nisi. Curabitur mollis purus sed purus commodo vitae malesuada sem viverra? Nunc mattis cursus elit, eget accumsan diam semper a. Mauris imperdiet fringilla ipsum, sed ultrices nunc auctor vel. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Integer porta pellentesque vulputate. Mauris sed purus ac lorem sodales ullamcorper. Phasellus velit urna, sagittis vitae scelerisque a</p>

<p><a href="http://www.sublab.tv" target="_blank">www.sublab.tv</a></p>
		</div>
		<div id="work-content" class="switcher-content set2 show">
			
		</div>
        	<div id="dannexe-content" class="switcher-content set2">
		<h2>DESIGNANNEXE</h2>
		<p>Société de développement interactif spécialisée dans des projets impliquant la vidéo comme source principale de contenu, en charge de la conception et la maintenance du site Internet Crash Box et de la réalisation du système de diffusion simultanée et essaimée des vidéos sur le web.</p>

<p><a href="http://annexe.squarespace.com" target="_blank">designannexe | portfolio site</a></p>
<p><a href="mailto:contact@stevebutton.net">designannexe | contact</a></p>
		</div>
</div>
</td>
</tr>
</table>
   
</div>
    
    
   		<div id="headercontrols">
   			<!-- <button id="go1">&raquo; BACKGROUND</button><button id="go2">&raquo; HIDE</button>-->
           <div id="enter"><img src="gfx/entercrashbox.png" alt="" /></div>
           <div id="plus"><img src="gfx/plusover.png" alt="" /></div>
           <div id="minus"><img src="gfx/minus.png" alt="" /></div>  
   		   </div>
           
         
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
                <div id="timer">
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

</div>
<div id="mapbt"><img src="gfx/timemapbt.png" alt="" /></div><div id="mapbt2"><img src="gfx/timemapbtback.png" alt="" /></div></div>
       
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
         <!--TEST VUVOX FEED <object width="100%" height="200"><param name="allowFullScreen" value="true" /><param name="flashvars" value="showMenu=false"/><param name="movie" value="http://www.vuvox.com/collage_express/collage.swf?collageID=0113aee81c"/><embed src="http://www.vuvox.com/collage_express/collage.swf?collageID=0113aee81c" flashvars="showMenu=false" allowFullScreen="true" type="application/x-shockwave-flash" width="100%" height="200"></embed></object>
         -->
      
         	<div id="footercontrols">
   		
           		<div id="footerplus"><img src="gfx/footerplus.png" alt="" /></div>
           		<div id="footerminus"><img src="gfx/footerminus.png" alt="" /></div>
                <div id="headersocial">
         
         <script language="javascript">AC_FL_RunContent = 0;</script>
<script src="AC_RunActiveContent.js" language="javascript"></script>

<script language="javascript">
	if (AC_FL_RunContent == 0) {
		alert("This page requires AC_RunActiveContent.js.");
	} else {
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0',
			'width', '140',
			'height', '45',
			'src', 'crashboxsocial',
			'quality', 'high',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'align', 'middle',
			'play', 'true',
			'loop', 'true',
			'scale', 'showall',
			'wmode', 'transparent',
			'devicefont', 'false',
			'id', 'crashboxsocial',
			'bgcolor', '#ffffff',
			'name', 'crashboxsocial',
			'menu', 'true',
			'allowFullScreen', 'false',
			'allowScriptAccess','sameDomain',
			'movie', 'gfx/crashboxsocial',
			'salign', ''
			); //end AC code
	}
</script>
<noscript>
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="140" height="45" id="crashboxsocial" align="middle">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="allowFullScreen" value="false" />
    <param name="wmode" value="transparent" />
	<param name="movie" value="gfx/crashboxsocial.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" />	<embed src="gfx/crashboxsocial.swf" quality="high" bgcolor="#ffffff" width="140" height="45" name="crashboxsocial" align="middle" wmode="transparent" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>
</noscript>
</div>
                <div id ="subscribebt"><img src="gfx/subscribebt.png" alt="" /></div>  
   		   </div>
           
           		
 <div id="footerleft">
  <table>
<tr>
<td>
<div class="block3 mid margin_auto">
	<div class="contheader3">
		<div class="nav_buttons2"> 
			<a id="2013" class="switcher set3">Library</a> 
            
			<a id="footer" class="switcher set3">about the site</a>		</div> 
	</div>
		
        <div id="switcher-panelbottom"></div>
		
		<!-- Dummy Data -->
		<div id="2013-content" class="switcher-content set3">
 <iframe src="http://widget.calameo.com/library/?type=subscription&id=273784&rows=1&sortBy=latestPublished&theme=white&bgColor=&thumbSize=normal&showTitle=true&showShadow=true&showGloss=true&showInfo=&linkTo=embed" width="100%" height="185" frameborder="0"></iframe></div>
		<div id="footer-content" class="switcher-content set3 show">
		<h2>ABOUT THE SITE</h2>
		<p>Lorem ipsum ea cum congue bonorum, pri no natum clita. His ne vide omnis forensibus. Eum cetero imperdiet et. Id mutat mazim quo, recusabo consequat scribentur te pro, nam laudem eripuit at.</p>

<p>Lorem ipsum ea cum congue bonorum, pri no natum clita. His ne vide omnis forensibus. Eum cetero imperdiet et. Id mutat mazim quo, recusabo consequat scribentur te pro, nam laudem eripuit at.</p>

<p>Lorem ipsum ea cum congue bonorum, pri no natum clita. His ne vide omnis forensibus. Eum cetero imperdiet et. Id mutat mazim quo, recusabo consequat scribentur te pro, nam laudem eripuit at.</p>		</div>
		<div id="credits-content" class="switcher-content set3">
		<h2>CRÉDITS</h2>
		Lorem ipsum ea cum congue bonorum, pri no natum clita. His ne vide omnis forensibus. Eum cetero imperdiet et. Id mutat mazim quo, recusabo consequat scribentur te pro, nam laudem eripuit at.
		<br/>
		Inani nominati sit eu. Te ubique cotidieque philosophia mel, vix id omnes iudico prompta. Ex usu nihil mediocritatem. Sea quod vituperata no, omittam offendit vel in. Noster voluptua luptatum id mea. Et voluptatum adversarium usu, rebum nominati recteque vix ei.		</div>
		<div id="contact-content" class="switcher-content set3">
		<h2>Contact</h2>
		</div>
		<div id="work-content" class="switcher-content set3">
		<h2>Work</h2>
		Lorem ipsum ea cum congue bonorum, pri no natum clita. His ne vide omnis forensibus. Eum cetero imperdiet et. Id mutat mazim quo, recusabo consequat scribentur te pro, nam laudem eripuit at.
		<br/>
		Inani nominati sit eu. Te ubique cotidieque philosophia mel, vix id omnes iudico prompta. Ex usu nihil mediocritatem. Sea quod vituperata no, omittam offendit vel in. Noster voluptua luptatum id mea. Et voluptatum adversarium usu, rebum nominati recteque vix ei.		</div>
        	<div id="cebtp-content" class="switcher-content set3">
		<h2>Work</h2>
		Lorem ipsum ea cum congue bonorum, pri no natum clita. His ne vide omnis forensibus. Eum cetero imperdiet et. Id mutat mazim quo, recusabo consequat scribentur te pro, nam laudem eripuit at.
		<br/>
		Inani nominati sit eu. Te ubique cotidieque philosophia mel, vix id omnes iudico prompta. Ex usu nihil mediocritatem. Sea quod vituperata no, omittam offendit vel in. Noster voluptua luptatum id mea. Et voluptatum adversarium usu, rebum nominati recteque vix ei.		</div>
</div></td>
</tr>
</table>
  </div>
  <!--<div id="footerright"><a href="http://www.contentthatmoves.com/" target="_blank"><img src="gfx/ctmlogo.png" alt="" /></a></div>--> 
</div>       
<!--  **************SLIDING FOOTER+CREDITS*********************    -->    
    
    
 
    
    <script>



/**********MAIN PANEL ANIM**************/
/**********HEADER**************/
/**********enter the site**************/
$("#enter").hover(function() {
 $(this).css('cursor','pointer');
 }, function() {
 $(this).css('cursor','auto');
});

$("#plus").hover(function() {
 $(this).css('cursor','pointer');
 }, function() {
 $(this).css('cursor','auto');
});

$("#minus").hover(function() {
 $(this).css('cursor','pointer');
 }, function() {
 $(this).css('cursor','auto');
});

$("#footerplus").hover(function() {
 $(this).css('cursor','pointer');
 }, function() {
 $(this).css('cursor','auto');
});

$("#footerminus").hover(function() {
 $(this).css('cursor','pointer');
 }, function() {
 $(this).css('cursor','auto');
});

$("#subscribebt").hover(function() {
 $(this).css('cursor','pointer');
 }, function() {
 $(this).css('cursor','auto');
});

$("#mapbt").hover(function() {
 $(this).css('cursor','pointer');
 }, function() {
 $(this).css('cursor','auto');
});

$("#mapbt2").hover(function() {
 $(this).css('cursor','pointer');
 }, function() {
 $(this).css('cursor','auto');
});



/**********ENTER SITE**************/
$( "#enter" ).click(function(){
  $( "#header" ).animate({ top: "-525px" }, 500 )
 	$( "#timebox" ).animate({ top: "30px" }, 500 )
	$( "#subscription" ).hide("slow");
	 $( "#timer" ).fadeIn("fast");
	 $( "#mapbt" ).fadeIn("fast");
  $( "#plus" ).show();
  $( "#headersocial" ).show();
 $( "#enter" ).hide();
 $( "#footer" ).animate({height: "35px" }, 500 ).fadeIn("slow");
  $( "#footerplus" ).show("slow");
  $( "#subscribebt" ).show("slow");
});


/**********SHOW TOP INFO PANELS**************/

$( "#plus" ).click(function(){
  $( "#header" ).animate({ top: "0px" }, 500 )
/*  .animate({ height: "50%" }, 500 )
*/   $( "#timebox" ).animate({ top: "240px" }, 500 )
$( "#footer" ).animate({height: "35px" }, 500 )
 $( "#footerplus" ).show();
   $( "#footerminus" ).hide();
   $( "#background" ).fadeIn(1000);
 $( "#plus" ).hide();

 $( "#minus" ).show();

});

$( "#minus" ).click(function(){
  $( "#header" ).animate({ top: "-525px" }, 500 )
   /* .animate({ height: "400px" }, 500 )*/
 $( "#timebox" ).animate({ top: "30px" }, 500 )
  $( "#plus" ).show();
 $( "#minus" ).hide();
});


/**********FOOTER-SHOW CREDITS**************/
$( "#footerplus" ).click(function(){

 $( "#footerminus" ).show();
  $( "#footerplus" ).hide();
   $( "#header" ).animate({ top: "-525px" }, 500 )
   /* .animate({ height: "400px" }, 500 )*/
 $( "#timebox" ).animate({ top: "30px" }, 500 )
 /* $( "#footer" ).animate({ top: "440px" }, 500 )*/
  $( "#footer" ).animate({ height: "330px" }, 500 )
  /*$( "#footer" ).animate({ top: "435px" }, 500 )*/
/* $( "#timebox" ).animate({ top: "30px" }, 500 )*/
  $( "#footerleft" ).fadeIn(1000);
   $( "#plus" ).show();
 $( "#minus" ).hide();
  /* $( "#footerright" ).fadeIn(2000);*/
});

/**********FOOTER-HIDE CREDITS**************/
$( "#footerminus" ).click(function(){
/*  $( "#footer" ).animate({top: "600px" }, 500 )*/
 $( "#footer" ).animate({height: "35px" }, 500 )
 $( "#timebox" ).animate({ top: "30px" }, 500 )
  $( "#footerplus" ).show();
   $( "#footerminus" ).hide();
});

/**********SUBSCRIBE**************/
$( "#subscribebt" ).click(function(){
$( "#footer" ).animate({height: "0px" }, 500 )
$( "#timebox" ).animate({ top: "180px" }, 500 )
$( "#header" ).animate({ top: "-95px" }, 500 )
 $( "#plus" ).hide();
  $( "#minus" ).hide();
   $( "#timer" ).fadeOut("fast");
 $( "#enter" ).show();
  $( "#mapbt" ).hide();
	 $( "#mapbt2" ).hide();
 $( "#background" ).fadeOut(200);
 $( "#subscription" ).fadeIn(1000);
});

/**********TIMELINE/MAP**************/

$("#mapbt").click(function(){
  $( "#timebox" ).animate({ top: "-280px" }, 500 )
   $( "#header" ).animate({ top: "-525px" }, 500 )
 $( "#footer" ).animate({height: "35px" }, 500 )
  $( "#footerplus" ).show();
   $( "#footerminus" ).hide();

    $( "#mapbt" ).hide();
	 $( "#mapbt2" ).show();
   $( "#plus" ).show();
    $( "#minus" ).hide();

});





$( "#mapbt2" ).click(function(){
$( "#mapbt" ).show();
$( "#mapbt2" ).hide();
  $( "#timebox" ).animate({ top: "30px" }, 500 )
   $( "#header" ).animate({ top: "-525px" }, 500 )
    $( "#footer" ).animate({height: "35px" }, 500 )
	 $( "#footerplus" ).show();
   $( "#footerminus" ).hide();

});
/**********MAIN ANIM end**************/


</script>

  
    
        </body>
</html>
