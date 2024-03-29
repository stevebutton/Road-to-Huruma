
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Earthquake GeoRSS Example</title>
  <script src="http://maps.google.com/maps?file=api&v=2&sensor=false&key=ABQIAAAA6_dV86BKC_gLYZ5tApeZ9xTSt96hixEnaeI_G75f3vOosJRVGxTF82F0dUIsP0tta6IBfx4oTYy2rw"
    <script type="text/javascript" src="http://timemap.googlecode.com/svn/tags/2.0.1/lib/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="http://timemap.googlecode.com/svn/tags/2.0.1/lib/mxn/mxn.js?(google)"></script>
    <script type="text/javascript" src="http://timemap.googlecode.com/svn/tags/2.0.1/lib/timeline-1.2.js"></script>
    <script src="http://timemap.googlecode.com/svn/tags/2.0.1/src/timemap.js" type="text/javascript"></script>
    <script src="http://timemap.googlecode.com/svn/tags/2.0.1/src/param.js" type="text/javascript"></script>
    <script src="http://timemap.googlecode.com/svn/tags/2.0.1/src/loaders/xml.js" type="text/javascript"></script>
    <script src="http://timemap.googlecode.com/svn/tags/2.0.1/src/loaders/georss.js" type="text/javascript"></script>
	<script type="text/javascript">
var tm;
$(function() {
  jQuery.noConflict();
    tm = TimeMap.init({
        mapId: "map",               // Id of map div element (required)
        timelineId: "timeline",     // Id of timeline div element (required)
        options: {eventIconPath: '../images/'},
        datasets: [
            {
                title: "Recent Earthquakes",
                theme: "red",
                type: "georss", // Data to be loaded in GeoRSS - must be a local URL
                options: { 
                    // GeoRSS file to load
                    url: "/index.php?feed=georss&cat=4"
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
});
    </script>
    <link href="examples.css" type="text/css" rel="stylesheet"/>
    <style>
    div#timelinecontainer{ height: 310px; }
    div#mapcontainer{ height: 300px; }
    div.infodescription { height: 130px; }
    </style>
  </head>

  <body>
    <div id="help">
    <h1>GeoRSS Dataset</h1>
    This is a timemap of earthquakes over a 30-day period, loaded via GeoRSS. Data was taken from <a href="http://earthquake.usgs.gov/" target="_blank">USGS Shakemaps</a>. This is basically a recreation of the mash-up created by <a href="http://www.oe-files.de" target="_blank">J&ouml;rn Clausen</a> that served as an inspiration for the TimeMap library. Note the use of the "extraTags" parameter to load non-standard data and display in the info window.
    </div>
    <div id="timemap">
        <div id="timelinecontainer">
          <div id="timeline"></div>
        </div>
        <div id="mapcontainer">
          <div id="map"></div>
        </div>
    </div>
  </body>
</html>
