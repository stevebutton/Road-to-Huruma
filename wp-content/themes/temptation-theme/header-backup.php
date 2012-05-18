<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	
	<title><?php
		if ( is_front_page() ) {
		} elseif ( is_category() ) {
			_e( 'Category: ', LANGUAGE ); wp_title( '' ); echo ' - ';
		} elseif ( function_exists( 'is_tag' ) && is_tag() ) {
			single_tag_title( __( 'Tag Archive for &quot;', LANGUAGE ) ); echo '&quot; - ';
		} elseif ( is_archive() ) {
			wp_title( '' ); _e( ' Archive - ', LANGUAGE );
		} elseif ( is_page() ) {
			echo wp_title( '' ); echo ' - ';
		} elseif ( is_search() ) {
			_e( 'Search for &quot;', LANGUAGE ); echo esc_html( $s ) . '&quot; - ';
		} elseif ( ! ( is_404() ) && ( is_single() ) || ( is_page() ) ) {
			wp_title( '' ) ; echo ' - ';
		} elseif ( is_404() ) {
			_e( 'Not Found - ', LANGUAGE );
		} bloginfo( 'name' );
	 ?></title>
	 
	 <?php require( CELTA_LIB . "theme-options-vars.php" ); ?>
	 
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" media="screen" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/presentation/<?php echo str_replace( ' ', '', strtolower( $celta_skin ) ); ?>.css" type="text/css" media="screen" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="shortcut icon" href="<?php echo $celta_favicon; ?>" />
	<style type="text/css">
      html { overflow: hidden;}
      .page {
        margin: 0;
        padding: 0px 10px 0 30px;
        top: 0;
        bottom: 0;
        position: relative;
        height: 100%;
        overflow: auto;
      }
      #right {
        top: 0px;
        bottom: 0;
        overflow: visible;
      }
      #left, #right { display: block; }

      h2 { margin-top: 30px; }
  </style>
	<?php wp_head(); ?>
	
	<?php if ( is_single() ) { ?>
		<script type="text/javascript">
			jQuery(document).ready( function() {
				jQuery('#navigation a').each( function() {
					var hash = jQuery(this).attr('href');
					jQuery(this).attr('href', '<?php echo home_url(); ?>'+'/'+hash);
				});
			})
		</script>
	<?php } ?>
	
	<style>
		<?php if ( $celta_custom_css != '' ) { echo stripslashes( $celta_custom_css ); } ?>
	</style>

<!--TIMEMAP-->
  <script type="text/javascript">var $ = jQuery;</script>
<!--<script src="http://maps.google.com/maps?file=api&v=3&key=ABQIAAAA6_dV86BKC_gLYZ5tApeZ9xTSt96hixEnaeI_G75f3vOosJRVGxTF82F0dUIsP0tta6IBfx4oTYy2rw" type="text/javascript"></script>-->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<!--<script type="text/javascript" src="/newest/newest_tm/lib/jquery-1.6.2.min.js"></script>-->

<script type="text/javascript" src="timemap.2.0/lib/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="/newest/newest_tm/lib/mxn/mxn.js?(googlev3)"></script>
    <script type="text/javascript" src="/newest/newest_tm/lib/timeline-2.3.0.js"></script>
    <script src="/newest/newest_tm/src/timemap.js" type="text/javascript"></script>
    <script src="/newest/newest_tm/src/param.js" type="text/javascript"></script>
    <script src="/newest/newest_tm/src/loaders/xml.js" type="text/javascript"></script>
    <script src="/newest/newest_tm/src/loaders/georss.js" type="text/javascript"></script>
  <script type="text/javascript">
var tm;
var debug;

var ladate = new Date();
ladate = ladate.toGMTString();

var zoomLevel = 1;
var zoomLevelMonths = 2;
var zoomLevelWeeks = 1;
var zoomLevelDays = 0;

var debug;

function findTheInfoWindow() {
/*
** Debug function: May be used later to style InfoWindow through CSS hardcoding.
**
** USE: $(findTheInfoWindow()[0]).parent().prev();
**  - Will return the div containing the window styling.
** ISSUES:
**  - We have to fire this up every time a new window is opened. So more digging inside the core files.
**  - Not first on priority list so I' ll see this later.
*/  
  var all = $('#map div');
  var rtrn = [];
  var i = 0;
  all.each(function() {
    var t = $(this);
    if ((t.width() == 10) && (t.height() == 10)) { rtrn[i] = t[0]; i++; }
  });
  return rtrn;
}

function redoMap() {
    var from = tl.getBand(0).getMinVisibleDate();
    var to = tl.getBand(0).getMaxVisibleDate();
    var v = [];
    var arr = tm.datasets.ds0.items;
    var len = arr.length;
    var swla, swlo, nela, nelo;

    for (var i = 0; i < len; i++) {
        var f = arr[i].getStartTime();
        if ((f > from) && (f < to) && (arr[i].placemark)) {
            v.push(arr[i].placemark.location);
        }
    }
    len = v.length;
    if (len > 0) {
        swla=v[0].lat;swlo=v[0].lon;nela=v[0].lat;nelo=v[0].lon;
        if (len > 1) {
            for (var i = 0; i < len; i++) {
                swla = (v[i].lat < swla) ? v[i].lat : swla;
                swlo = (v[i].lon < swlo) ? v[i].lon : swlo;
                nela = (v[i].lat > nela) ? v[i].lat : nela;
                nelo = (v[i].lom > nelo) ? v[i].lon : nelo;
            }
        }
        tm.map.setBounds(new mxn.BoundingBox(swla,swlo,nela,nelo));
    }
}

function zoomTo(zoomNeeded) {
      var rtrndate = tl.getBand(1).getCenterVisibleDate();
      var zoomBool = (zoomLevel > zoomNeeded) ? true : false;
      
      while (zoomLevel != zoomNeeded) {
        for (var i = 0; i < 2; i++) { tl.getBand(i).zoom(zoomBool);}
        zoomLevel = ((zoomLevel > zoomNeeded) ? zoomLevel - 1 : zoomLevel + 1);
      }
      for (var i = 0; i < 2; i++) { tl.getBand(i).paint();}
      tl.getBand(1).setCenterVisibleDate(rtrndate);
      redoMap();
}
function zoomToMonths() { zoomTo(zoomLevelMonths); }
function zoomToWeeks() { zoomTo(zoomLevelWeeks); }
function zoomToDays() { zoomTo(zoomLevelDays); }                             
function zoomToToday() { tl.getBand(0).scrollToCenter(Timeline.DateTime.parseGregorianDateTime(ladate)); }
function slideToLeft() { var rtrntime = tl.getBand(0).getMinVisibleDate(); tl.getBand(0).scrollToCenter(Timeline.DateTime.parseGregorianDateTime(rtrntime)); }
function slideToRight() { var rtrntime = tl.getBand(0).getMaxVisibleDate(); tl.getBand(0).scrollToCenter(Timeline.DateTime.parseGregorianDateTime(rtrntime)); }
function zoomStepsArray(a, b) { return new Array(
  {pixelsPerInterval: a, unit: ((b) ? Timeline.DateTime.DAY : Timeline.DateTime.WEEK)},
  {pixelsPerInterval: a, unit: ((b) ? Timeline.DateTime.WEEK : Timeline.DateTime.MONTH)},
  {pixelsPerInterval: a, unit: ((b) ? Timeline.DateTime.MONTH : Timeline.DateTime.YEAR)});
}

var tomorrow = new Date();
tomorrow.setTime(tomorrow.getTime() + (1000 * 3600 * 72));
var dec = new Timeline.SpanHighlightDecorator({
            startDate:  ladate,
            endDate:    tomorrow,
            color:      "#FF0000",
            opacity:    50,
            startLabel: "foo",
            endLabel:   "bar",
            cssClass:   "epite"
          });

$(function() {
    // make a custom map style
    var styledMapType = new google.maps.StyledMapType([
        { featureType: "water", elementType: "all", stylers: [ { saturation: 0 }, { lightness: 100 } ] },
        { featureType: "all", elementType: "all", stylers: [ { saturation: -100 } ] }],
      { name: "white" });
    tm = TimeMap.init({
        mapId: "map",               // Id of map div element (required)
        timelineId: "my-timeline",     // Id of timeline div element (required)
        options: {eventIconPath: '/newest/newest_tm/images/'},
        datasets: [
            {
                title: "Recent Earthquakes",
                theme: "red",
                type: "georss", // Data to be loaded in GeoRSS - must be a local URL
                options: { 
                    url: "/index.php?feed=georss&cat=4",
                    extraTags: ['link'],
                    infoTemplate: '<div class="infotitle"><a href="{{link}}">{{title}}</a></div>' + 
                                  '<div class="infodescription">{{description}}</div>'
                }
            }
        ],
        bandInfo: [
            {
               width:          "85%", 
               intervalUnit:   Timeline.DateTime.WEEK, 
               intervalPixels: 210,
               zoomIndex:      zoomLevel,
               zoomSteps:      zoomStepsArray(210, true),
               decorators:     dec,
               highlight:      true
            },
            {
               width:          "15%", 
               intervalUnit:   Timeline.DateTime.MONTH, 
               intervalPixels: 150,
               showEventText:  false,
               trackHeight:    0.2,
               trackGap:       0.2,
               zoomIndex:      zoomLevel,
               zoomSteps:      zoomStepsArray(150, false),
               decorators:     dec,
               highlight:      true
            }
        ]
    });

    // Custom Map Set
    var gmap = tm.getNativeMap();
    gmap.mapTypes.set("white", styledMapType);
    gmap.setMapTypeId("white");

    tl = tm.timeline;
    tl.getBand(0).addOnScrollListener(function() { redoMap(); });
    document.getElementById('right').scrollTop=0;
    redoMap();
});
    </script>
    <!--<link href="/newest/newest_tm/examples/examples.css" type="text/css" rel="stylesheet"/>-->
    <link href="timemap.2.0/lib/master2.css" type="text/css" rel="stylesheet"/>
    <!--<link rel="stylesheet" type="text/css" media="screen" href="timemap.2.0/lib/demopage.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="timemap.2.0/lib/jquery.content-panel-switcher.css" /> 
    <script type='text/javascript' src='timemap.2.0/lib/jquery.js'></script>
    <script type='text/javascript' src='timemap.2.0/lib/jquery.content-panel-switcher.js'></script>-->  
   <script>
    //doesn't block the load event
    function createIframe(){
      var i = document.createElement("iframe");
      i.src = "/testoslide.html";
      i.scrolling = "auto";
      i.frameborder = "0";
      i.width = "100%";
      i.height = "100%";
      document.getElementById("iframeholder").appendChild(i);
      $('#iframeholder').hide();
    };
    // Check for browser support of event handling capability
    if (window.addEventListener)
      window.addEventListener("load", createIframe, false);
    else if (window.attachEvent)
      window.attachEvent("onload", createIframe);
    else window.onload = createIframe;
  </script>
</head>
<body <?php body_class(); ?>>