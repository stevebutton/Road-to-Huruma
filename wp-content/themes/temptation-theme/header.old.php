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
 <script src="http://maps.google.com/maps?file=api&v=2&key=ABQIAAAA6_dV86BKC_gLYZ5tApeZ9xTSt96hixEnaeI_G75f3vOosJRVGxTF82F0dUIsP0tta6IBfx4oTYy2rw" type="text/javascript"></script>
<!--    <script type="text/javascript" src="/newest/newest_tm/lib/jquery-1.6.2.min.js"></script>
-->    <script type="text/javascript" src="/newest/newest_tm/lib/mxn/mxn.js?(google)"></script>
    <script type="text/javascript" src="/newest/newest_tm/lib/timeline-1.2.js"></script>
    <script src="/newest/newest_tm/src/timemap.js" type="text/javascript"></script>
    <script src="/newest/newest_tm/src/param.js" type="text/javascript"></script>
    <script src="/newest/newest_tm/src/loaders/xml.js" type="text/javascript"></script>
    <script src="/newest/newest_tm/src/loaders/georss.js" type="text/javascript"></script>
  <script type="text/javascript">
var tm;
var debug;

var zoomLevel = 2;
var zoomLevelMonths = 2;
var zoomLevelWeeks = 1;
var zoomLevelDays = 0;

var debug;

function redoMap() {
    var from = tl.getBand(0).getMinVisibleDate();
    var to = tl.getBand(0).getMaxVisibleDate();
    var v = [];
    var arr = tm.datasets.ds0.items;
    var len = arr.length;
    var swla, swlo, nela, nelo;

    for (var i = 0; i < len; i++) {
        var f = arr[i].getStartTime();
        if ((f > from) && (f < to)) {
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
        for (var i = 0; i < 2; i++) {
          tl.getBand(i).zoom(zoomBool);
        }
        zoomLevel = ((zoomLevel > zoomNeeded) ? zoomLevel - 1 : zoomLevel + 1);
      }
      for (var i = 0; i < 2; i++) {
        tl.getBand(i).paint();
      }
      tl.getBand(1).setCenterVisibleDate(rtrndate);
}
function zoomToMonths() { zoomTo(zoomLevelMonths); }
function zoomToWeeks() { zoomTo(zoomLevelWeeks); }
function zoomToDays() { zoomTo(zoomLevelDays); }                             
function zoomToToday() { tl.getBand(1).scrollToCenter(Timeline.DateTime.parseGregorianDateTime(ladate)); }
function slideToLeft() { var rtrntime = tl.getBand(0).getMinVisibleDate(); tl.getBand(0).scrollToCenter(Timeline.DateTime.parseGregorianDateTime(rtrntime)); }
function slideToRight() { var rtrntime = tl.getBand(0).getMaxVisibleDate(); tl.getBand(0).scrollToCenter(Timeline.DateTime.parseGregorianDateTime(rtrntime)); }

$(function() {
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
                    // GeoRSS file to load
                    url: "/index.php?feed=georss&cat=4",
                    // additional tags to load
                    extraTags: ['link'],
                    // custom template to use the extra data
                    infoTemplate: '<div class="infotitle"><a href="{{link}}">{{title}}</a></div>' + 
                                  '<div class="infodescription">{{description}}</div>'
                }
            }
        ],
        bandInfo: [
            {
               width:          "85%", 
               intervalUnit:   Timeline.DateTime.DAY, 
           intervalPixels: 210
            },
            {
               width:          "15%", 
               intervalUnit:   Timeline.DateTime.WEEK, 
               intervalPixels: 150,
               showEventText:  false,
               trackHeight:    0.2,
               trackGap:       0.2
            }
        ]
    });
    tl = tm.timeline;
    tl.getBand(0).addOnScrollListener(function() { redoMap(); });
});
    </script>
    <link href="/newest/newest_tm/examples/examples.css" type="text/css" rel="stylesheet"/>

    <link href="timemap.2.0/lib/master2.css" type="text/css" rel="stylesheet"/>
   


    <!--<link rel="stylesheet" type="text/css" media="screen" href="timemap.2.0/lib/demopage.css" />--> 
<!--<link rel="stylesheet" type="text/css" media="screen" href="timemap.2.0/lib/jquery.content-panel-switcher.css" /> 
<script type='text/javascript' src='timemap.2.0/lib/jquery.js'></script>
<script type='text/javascript' src='timemap.2.0/lib/jquery.content-panel-switcher.js'></script>-->  
   
   

    
</head>

<body <?php body_class(); ?>>