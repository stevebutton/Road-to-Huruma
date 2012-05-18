//
//BASETRACK MAP//////////////
//(using simile timeline and google maps via: http://code.google.com/p/timemap/)
//current tag for filtering
//search in (timeM.js if want to change this filter variable)
var selectedTag;
//number of seconds to scroll depending on zoom level
var scrollDays =  14;
//ratio for adjusting scroll amount depending on users window
var scrollRatio = jQuery(window) .width()/1440;
//whether json has loaded already
var hasLoaded = false;

//dates of earliest and latest events
var earliestEventDate;
var latestEventDate;




//url to data feed 
/*var dataURL = siteURL+"?json=1&count=10000&custom_fields=latitude,longitude,place&include=title,custom_fields,excerpt,content,categories,author,date,url";
*/

//for truncatingString.prototype.trunc =
String.prototype.trunc = function(n,useWordBoundary){
         var toLong = this.length>n,
             s_ = toLong ? this.substr(0,n-1) : this;
         s_ = useWordBoundary && toLong ? s_.substr(0,s_.lastIndexOf(' ')) : s_;
         return  toLong ? s_ +'&hellip;' : s_;
      };

jQuery(document).ready(function ($) {
	SimileAjax.History.enabled = false;
	
  var eventSource = new Timeline.DefaultEventSource(0);


  var theme = Timeline.ClassicTheme.create();
  theme.event.instant.iconWidth = 15;  // These are for the default stand-alone icon
  theme.event.instant.iconHeight = 15;
	theme.event.track.height = 1; 
	theme.event.label.offsetFromLine = 5;  //the distance between your
	theme.mouseWheel = "scroll";
	

	var bandInfos = [Timeline.createBandInfo({
        width:          "100%", 
        intervalUnit: Timeline.DateTime.WEEK, 
        intervalPixels: 550,
        eventSource:    eventSource,
        theme:          theme,
        layout:         'original'  // original, overview, detailed
				,
        zoomIndex:      10,
        zoomSteps:      new Array(
          {pixelsPerInterval: 250,  unit: Timeline.DateTime.DAY},
          {pixelsPerInterval: 550,  unit: Timeline.DateTime.WEEK},
          {pixelsPerInterval: 650,  unit: Timeline.DateTime.MONTH}
        )
    })
  ];

  // set up custom icon for map
	//v2
  /*customIcon = new GIcon(G_DEFAULT_ICON);
  customIcon.image = templateURL+"/images/tm-map-event-but.png";
  customIcon.iconSize = new GSize(30, 30);
  customIcon.iconAnchor = new GPoint(15, 15);
	customIcon.imageMap = new Array(0,0,60,0,60,60,0,60);
  customIcon.shadow = "";*/

	//v3 marker
	customIcon = new google.maps.Marker({
		icon: templateURL+"/images/tm-map-event-but.png"
	})
	
	//see if is a post, determine the id and have the timeline scroll there
	//if no id, then home, so don't scroll anywhere
	var scrollToDate;
	if(!isHome && isPost)
	{
		scrollToDate = curPostDate;
	}	else
	{
		scrollToDate = "latest";
	}								
	
	//ref to timemap
	window.timeM = TimeMap.init({
    mapId: "map",               // Id of map div element (required)
    timelineId: "timeline",     // Id of timeline div element (required) 
		bands: bandInfos,
		type: 'progressive',
		scrollTo: scrollToDate,
		options: 
		{
			mapType: "satellite",
			showMapCtrl: false,
			mapCenter: new google.maps.LatLng(33,65),
			mapZoom: 5,
			icon: customIcon,
			eventIconImage: "tm-timeline-event-but.png",
			eventIconPath: templateURL+"/images/"
		},
    datasets: 
		[
      {
        title: "BASETRACK POSTS",
        type: "json_php",
        options: {
          url: dataURL,    // Must be a local URL
					jsonData: jsonData,
					//function to transform the wordpress json into an array of json that the timemap will accept
					transformFunction: function(data)
					{
						//alert("transforming data: "+JSON.stringify(data));
						//whether has already loaded since calling twice because often errors
						if(!hasLoaded)
						{
							hasLoaded = true;
							//transform wordpress json to json that timemap can use
							var transJSON = [];
							var category;
							//data.count_total = 10;
							data.posts = JSON.parse(data.posts);
							for(var i=0;i<data.count_total;i++)
							{
								var iconDiv = "<div class='icondiv'>";
								for(var j = 0;j<data.posts[i].categories.length;j++)
								{
									category = data.posts[i].categories[j];
									//look in categories for icons
									if(category == "photo")
									{
										iconDiv+="<div class='photoIcon'></div>";
									}
									if(category == "video")
									{
										iconDiv+="<div class='videoIcon'></div>";
									}
									if(category == "prose")
									{
										iconDiv+="<div class='proseIcon'></div>";
									}
								}	
								iconDiv+="</div>";
							
								var excerpt = data.posts[i].excerpt;
								
								//check for earliest and latest dates
								var iD = Timeline.DateTime.parseIso8601DateTime(data.posts[i].date);
								if(iD < earliestEventDate || earliestEventDate == null)
								{
									earliestEventDate = iD;
								}
								if(iD > latestEventDate || latestEventDate == null)
								{
									latestEventDate = iD;
								}
								
								//to keep dots from being on top of each other
								var lat = parseFloat(data.posts[i].custom_fields.latitude);
								var lng = parseFloat(data.posts[i].custom_fields.longitude);
								var place = data.posts[i].custom_fields.place;
								var iWC = "<div class='infomapwindow'>";
															
								//see if has thumb
								if(data.posts[i].thumb != "")
								{
									iWC += "<div class='infopic'>"+
													"<img width='100px' src='"+data.posts[i].thumb+"' alt='"+data.posts[i].title+"'/>"+
													"</div><div class='infodescription'>";
								} else
								{
									iWC += "<div class='infodescription2'>";
								}
								//set content for infowindow
								iWC += "<div class='infotitle'><a href='"+data.posts[i].url+"'>"+data.posts[i].title+
																"</a></div><div class='infoauthor'>"+data.posts[i].author+"&nbsp;&nbsp;"+data.posts[i].date+"&nbsp;GMT</div>"+excerpt+"</div>"+iconDiv;
								
												
												
								if(lat != undefined || place != undefined)
								{
									iWC += "<div class='infopostzoom' onclick='zoomToPosition();'>ZOOM TO LOCATION</div>";
								} else
								{
									iWC += "<div class='infopostzoom'>&nbsp;</div>";
								}
								iWC += "<div class='infopostlink'><a href='"+data.posts[i].url+"'>VIEW POST</a></div></div>";
								var pJSON = {
									"point": {"lon": lng, "lat": lat},
									"title": data.posts[i].title,
									"start": data.posts[i].date,
									"postID": data.posts[i].id,
									"options": {
										"place": place,
										"tags": [data.posts[i].author.toString()],
										//just add values directly to template so quicker
										"infoTemplate": iWC
									}
								};	
								transJSON.push(pJSON);
							}	
							return transJSON;
						}
					}
       	}
			}
		]
  });

	
	
	//listen for mouse movement and update lat and lng on map
	google.maps.event.addListener(timeM.map,"mousemove",function(e) {
		//update lat and lng on map text areas
		var lat = $("#mouse-lat");
		var lng = $("#mouse-lng");
		lat.text(e.latLng.lat().toFixed(4)+" N");
		lng.text(e.latLng.lng().toFixed(4)+" E");
	});
	
	google.maps.event.addListener(timeM.map,"idle",function() {
		//update lat and lng on map text areas
		var lat = $("#mouse-lat");
		var lng = $("#mouse-lng");
		lat.text(timeM.map.getCenter().lat().toFixed(4)+" N");
		lng.text(timeM.map.getCenter().lng().toFixed(4)+" E");
	});
	

	
	
  // make sure events are tied together
  timeM.timeline.getBand(0).addOnScrollListener(function() {
		if(!window.oversTiedTogether)
		{
      tieMapTimelineOvers();
			timeM.isNotFirst = true;
		}
  });

	
	
	//listen for resize and adjust scroll ratio and position
	jQuery(window).resize(function() 
	{
		scrollRatio = jQuery(window).width()/1440;
		jQuery('#timemapbutton').css('left',Math.max(Math.min(jQuery(window).width()-jQuery('#timemapbutton').outerWidth()-80,1600),700));
	});

	//add filters for filtering tags
	timeM.addFilter("map", TimeMap.filters.hasSelectedTag); // hide map markers on fail
	timeM.addFilter("timeline", TimeMap.filters.hasSelectedTag); // hide timeline events on fail

	//scrolling timeline
	$('#timearrowleft').click(function() {
		var cD = new Date(timeM.timeline.getBand(0).getCenterVisibleDate());
		var cD2 = new Date();
		cD2.setTime(cD.valueOf());
		cD2.setDate(cD.getDate()-Math.round(scrollDays*scrollRatio));
		if(timeM.timeline.getBand(0).getMinVisibleDate()>earliestEventDate)
		{
			timeM.timeline.getBand(0).scrollToCenter(cD2);
		}
	});

	$('#timearrowright').click(function() {
		var cD = new Date(timeM.timeline.getBand(0).getCenterVisibleDate());
		var cD2 = new Date();
		cD2.setTime(cD.valueOf());
		cD2.setDate(cD.getDate()+Math.round(scrollDays*scrollRatio));
		if(timeM.timeline.getBand(0).getMaxVisibleDate()<latestEventDate)
		{
			timeM.timeline.getBand(0).scrollToCenter(cD2);
		}
	});
	
	
	
	//zooming
	
	//init zoom index
	timeM.timeline.getBand(0)._zoomIndex = 1;
	$('#weekbutton').css('background-position',"0 -40px");
	
	//day button
	$('#daybutton').click(function(){
		clearTimelineIntervals();
		var b = timeM.timeline.getBand(0);
      //var E = SimileAjax.DOM.getEventRelativeCoordinates(H, G);
			//get center value of timeline
			var l = $('#timeline-band-0').css('left');
			var xPos = timeM.timeline.getPixelLength()/2 - l.substring(0,l.length-2);
			if(b._zoomIndex == 2)
			{
				timeM.timeline.zoom(true, xPos, 100, b._div);
			}
			var l = $('#timeline-band-0').css('left');
			var xPos = timeM.timeline.getPixelLength()/2 - l.substring(0,l.length-2);
			if(b._zoomIndex == 1)
			{
				timeM.timeline.zoom(true, xPos, 100, b._div);
			}
			scrollDays = 5;
			$(this).css('background-position',"0 -40px");
			tieMapTimelineOvers(window.timeM);
	});
	
	//week button
	$('#weekbutton').click(function(){
		clearTimelineIntervals();
		var b = timeM.timeline.getBand(0);
    //var E = SimileAjax.DOM.getEventRelativeCoordinates(H, G);
		//get center value of timeline
		var l = $('#timeline-band-0').css('left');
		var xPos = timeM.timeline.getPixelLength()/2 - l.substring(0,l.length-2);
		if(b._zoomIndex == 2)
		{
			timeM.timeline.zoom(true, xPos, 100, b._div);
		}
		if(b._zoomIndex == 0)
		{
			timeM.timeline.zoom(false, xPos, 100, b._div);
		}
		scrollDays = 14;
		$(this).css('background-position',"0 -40px");
		tieMapTimelineOvers(window.timeM);
	});
	
	//month button
	$('#monthbutton').click(function(){
		clearTimelineIntervals();
		var b = timeM.timeline.getBand(0);
		var l = $('#timeline-band-0').css('left');
		var xPos = timeM.timeline.getPixelLength()/2 - l.substring(0,l.length-2);
		if(b._zoomIndex == 0)
		{
			timeM.timeline.zoom(false, xPos, 100, b._div);
		}
		var l = $('#timeline-band-0').css('left');
		var xPos = timeM.timeline.getPixelLength()/2 - l.substring(0,l.length-2);
		if(b._zoomIndex == 1)
		{
			timeM.timeline.zoom(false, xPos, 100, b._div);
		}
		scrollDays = 60;
		$(this).css('background-position',"0 -40px");
		tieMapTimelineOvers(window.timeM);
	});
	
	//filtering
	/*$("#journalistfilter").change(function(){
    var idx = this.selectedIndex;
    selectedTag = this.options[idx].value;
		if(selectedTag == "-1")
		{
			selectedTag = false;
		}
    // run filters
    timeM.filter('map');
    timeM.filter('timeline');
		tieMapTimelineOvers(window.timeM);
	});*/
	
	

	
	//
	//TimeMap Animation/////////////////
	
	//set center button
	jQuery('#timemapbutton').css('left',Math.max(Math.min(jQuery(window).width()-jQuery('#timemapbutton').outerWidth()-80,1600),700));
	$('#timemapbutton').css('display','block');
	
	//overs for map button
	$('#timemapbutton').mouseout(function() {
		if(isMapShown)
		{
			$(this).css('background-position','0 0px');
		} else
		{
			$(this).css('background-position','0 -69px');
		}
	});
	
	$('#timemapbutton').mouseover(function() {
		if(isMapShown)
		{
			$(this).css('background-position','0 -69px');
		} else
		{
			$(this).css('background-position','0 0px');
		}
	});
	
	//if timemap up then if click anywhere bring it down
	function addMapUpListener() {
		$('#timemapbutton').unbind('click');
		$('#timemap').click(function(){
			var fPos;
			
			fPos = 0;
			isMapShown = true;
			$('#timemapbutton').css('background-position', '0 0');
			
			$('#movingcontent').animate({
				"margin-top": fPos
				}, 300,'easeOutQuad',function() {
					//Animation complete
					//remove anywhere click map goes down
					removeMapUpListener();
			});
		})
	}
	
	function removeMapUpListener()
	{
		$('#timemap').unbind('click');
		//fPos = -472;
		$('#timemapbutton').click(function() {
			var fPos = -458;
			isMapShown = false;
			$('#timemapbutton').css('background-position', '0 -69px');
		
			$('#movingcontent').animate({
				"margin-top": fPos
				}, 300,'easeOutQuad',function() {
					//Animation complete
					//add anywhere click map goes up
					addMapUpListener();
			});
		});
	}
	
	
	/*$('#timemapbutton').click(function() {
		var fPos;
		if(isMapShown)
		{
			//fPos = -472;
			fPos = -458;
			isMapShown = false;
			$('#timemapbutton').css('background-position', '0 -69px');
			//add anywhere click map goes up
			addMapUpListener();
		} else
		{
			fPos = 0;
			isMapShown = true;
			$('#timemapbutton').css('background-position', '0 0');
			
			removeMapUpListener();
		}
		$('#movingcontent').animate({
			"margin-top": fPos
			}, 300,'easeOutQuad',function() {
				//Animation complete
		});
	});*/
	
	//whether to show map and logo on this page
	//use for animation
	if(!isMapShown)
	{	
		addMapUpListener();
		$('#timemapbutton').css('background-position','0 -69px');
	} else
	{
		removeMapUpListener();
	}
	
	//if index then treat as home in menu
	if(isHome)
	{
		$('.page_item').first().addClass('current_page_item');
	}
	
	
	//show map and logo in correct position
	$('#movingcontent').css('visibility','visible');
	
	
	//reset button backgrounds for timeline intervals
	function clearTimelineIntervals() {
		$('#daybutton').css('background-position','0 0');
		$('#weekbutton').css('background-position','0 0');
		$('#monthbutton').css('background-position','0 0');
	}
	
//end of initial load
});

//for zooming into position on map
function zoomToPosition()
{
	var point = window.timeM.getCurItem().placemark.getPosition();
	window.timeM.cancelPan();
	window.timeM.map.setZoom(15);
	window.timeM.map.panTo(point);
}




//filter via tag
TimeMap.filters.hasSelectedTag = function(item) {
    // if no tag was selected, every item should pass the filter
    if (!selectedTag) {
        return true;
    }
    if (item.opts.tags) {
        // look for selected tag
        if (item.opts.tags.indexOf(selectedTag.toString()) >= 0) {
            // tag found, item passes
            return true;
        } 
        else {
            // indexOf() returned -1, so the tag wasn't found
            return false;
        }
    }
    else {
        // item didn't have any tags
        return false;
    }
}

TimeMap.loaders.json_php = function(options) {
    var loader = new TimeMap.loaders.basic(options);
    
		//for loading as json and then parsing custom to BASETRACK
		loader.data = JSON.stringify(options.jsonData);
    /**
     * Parse a JSON string into a JavaScript object, using the json2.js library.
     * @name TimeMap.loaders.json_string#parse
     * @function
     * @param {String} json     JSON string to parse
     * @returns {Object}        Parsed JavaScript object
     */
    loader.parse = JSON.parse;
    
    return loader;
};


//override layout because it breaks mouseover
Timeline._Impl.prototype.layout = function() {
	//ADDED FOR BASETRACK
  this._autoWidthCheck(true);
  this._distributeWidths();
	tieMapTimelineOvers(this.tMap);
};


//tie all markers in map and timeline together for rollovers
function tieMapTimelineOvers(tm) {
	var $ = jQuery.noConflict();
	//window.oversTiedTogether = true;
	if(!(navigator.userAgent.match(/iPhone/i)) && !(navigator.userAgent.match(/iPod/i)) && !(navigator.userAgent.match(/iPad/i))) 
	{
		//for inconsistencies in scope with ie versus everyone else
		if(tm == undefined)
		{
			tm = window.timeM;
		}
		//remove any previous listeners
		removeMapTimelineOvers(tm);
		
		var itemsAR = tm.getItems();
		var tlID;
		for(var i=0;i<itemsAR.length;i++)
		{
			tlID = itemsAR[i].event.getID();
			pm = itemsAR[i].placemark;
			$("#icon-tl-0-0-"+tlID).data('placemark',pm);
				$("#icon-tl-0-0-"+tlID).mouseover(function() {
					$(this).find('img').attr('src',templateURL+"/images/tm-timeline-event-but-on.png");
					$(this).next().css('color','#0279fe');
					if($(this).data('placemark') != null)
					{
						$(this).data('placemark').setIcon(templateURL+"/images/tm-map-event-but-on.png");
						//hide this placemark, then loop through and find which marker isn't visible
						$(this).data('placemark').setZIndex(1000);
					}
				});
				$("#icon-tl-0-0-"+tlID).mouseout(function() {
					$(this).find('img').attr('src',templateURL+"/images/tm-timeline-event-but.png");
					$(this).next().css('color','#fff');
					if($(this).data('placemark') != null)
					{
						$(this).data('placemark').setIcon(templateURL+"/images/tm-map-event-but.png");
						$(this).data('placemark').setZIndex(1);
					}
				});
		
				$("#label-tl-0-0-"+tlID).data('placemark',pm);
				$("#label-tl-0-0-"+tlID).mouseover(function() {
					$(this).prev().find('img').attr('src',templateURL+"/images/tm-timeline-event-but-on.png");
					$(this).css('color','#0279fe');
					if($(this).data('placemark') != null)
					{
						$(this).data('placemark').setIcon(templateURL+"/images/tm-map-event-but-on.png");
				
						//move placemark up in stack
						$(this).data('placemark').setZIndex(1000);
					}
				});
				$("#label-tl-0-0-"+tlID).mouseout(function() {
					$(this).prev().find('img').attr('src',templateURL+"/images/tm-timeline-event-but.png");
					$(this).css('color','#fff');
					if($(this).data('placemark') != null)
					{
						$(this).data('placemark').setIcon(templateURL+"/images/tm-map-event-but.png");
						$(this).data('placemark').setZIndex(1);
					}
				});
		
			//set rollover for marker
			if(pm != null)
			{				
				pm.tl_id = tlID;
				
				
				google.maps.event.addListener(pm,"mouseover",function(){
					this.setIcon(templateURL+"/images/tm-map-event-but-on.png");
					$("#icon-tl-0-0-"+this.tl_id).find('img').attr('src',templateURL+"/images/tm-timeline-event-but-on.png");
					$("#label-tl-0-0-"+this.tl_id).css('color','#0279fe');
					if(pm)
					{
						pm.setZIndex(1000);	
					}
					//hide this placemark, then loop through and find which marker isn't visible
					/*this.setMap(null);
					//finding is ugly, but google maps act weird
					var i = 0;
					$('#map div:first').children().first().children().each(function() {
						if(i == 6)
						{
							$(this).find('img').each(function() {
								if($(this).css('visibility') == 'hidden')
								{
									$(this).css('z-index',10000);
								} else
								{
									$(this).css('z-index',1);
								}
							})
						}
						i++;
					});
					this.show();*/
				});
				pm.mapTimeListener = google.maps.event.addListener(pm,"mouseout",function(){
					this.setIcon(templateURL+"/images/tm-map-event-but.png");
					$("#icon-tl-0-0-"+this.tl_id).find('img').attr('src',templateURL+"/images/tm-timeline-event-but.png");
					$("#label-tl-0-0-"+this.tl_id).css('color','#fff');
					if(pm)
					{
						pm.setZIndex(1000);	
					}
				});	
			}
		}
	}
	$.noConflict();
}

function removeMapTimelineOvers(tm)
{
	var itemsAR = tm.getItems();
	var tlID;
	for(var i=0;i<itemsAR.length;i++)
	{
		tlID = itemsAR[i].event.getID();
		pm = itemsAR[i].placemark;
		//for ie for first time (won't recognize jquery??)
		try {
			jQuery("#icon-tl-0-0-"+tlID).unbind();
			jQuery("#label-tl-0-0-"+tlID).unbind();
				GEvent.removeListener(pm.mapTimeListener);
		} catch(e)
		{
		}
	}
	
}
