/*
Copyright (c) 2011 Tom Carden, Steve Coast, Mikel Maron, Andrew Turner, Henri Bergius, Rob Moran, Derek Fowler
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

 * Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
 * Neither the name of the Mapstraction nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/
mxn.register("google",{Mapstraction:{init:function(a,b){var d=this;if(GMap2){if(GBrowserIsCompatible()){this.maps[b]=new GMap2(a);GEvent.addListener(this.maps[b],"click",function(f,e){if(f&&f.mapstraction_marker){f.mapstraction_marker.click.fire()}else{if(e){d.click.fire({location:new mxn.LatLonPoint(e.y,e.x)})}}if(e){d.clickHandler(e.y,e.x,e,d)}});GEvent.addListener(this.maps[b],"moveend",function(){d.moveendHandler(d);d.endPan.fire()});GEvent.addListener(this.maps[b],"zoomend",function(){d.changeZoom.fire()});this.loaded[b]=true;d.load.fire()}else{alert("browser not compatible with Google Maps")}}else{alert(b+" map script not imported")}},applyOptions:function(){var a=this.maps[this.api];if(this.options.enableScrollWheelZoom){a.enableContinuousZoom();a.enableScrollWheelZoom()}if(this.options.enableDragging){a.enableDragging()}else{a.disableDragging()}},resizeTo:function(b,a){this.currentElement.style.width=b;this.currentElement.style.height=a;this.maps[this.api].checkResize()},addControls:function(a){var b=this.maps[this.api];if(this.controls){while((ctl=this.controls.pop())){b.removeControl(ctl)}}else{this.controls=[]}c=this.controls;if(a.zoom||a.pan){if(a.zoom=="large"){this.addLargeControls()}else{this.addSmallControls()}}if(a.scale){this.controls.unshift(new GScaleControl());b.addControl(this.controls[0]);this.addControlsArgs.scale=true}if(a.overview){c.unshift(new GOverviewMapControl());b.addControl(c[0]);this.addControlsArgs.overview=true}if(a.map_type){this.addMapTypeControls()}},addSmallControls:function(){var a=this.maps[this.api];this.controls.unshift(new GSmallMapControl());a.addControl(this.controls[0]);this.addControlsArgs.zoom="small";this.addControlsArgs.pan=true},addLargeControls:function(){var a=this.maps[this.api];this.controls.unshift(new GLargeMapControl());a.addControl(this.controls[0]);this.addControlsArgs.zoom="large";this.addControlsArgs.pan=true},addMapTypeControls:function(){var a=this.maps[this.api];this.controls.unshift(new GMapTypeControl());a.addControl(this.controls[0]);this.addControlsArgs.map_type=true},setCenterAndZoom:function(a,b){var e=this.maps[this.api];var d=a.toProprietary(this.api);e.setCenter(d,b)},addMarker:function(b,a){var e=this.maps[this.api];var d=b.toProprietary(this.api);e.addOverlay(d);GEvent.addListener(d,"infowindowopen",function(){b.openInfoBubble.fire()});GEvent.addListener(d,"infowindowclose",function(){b.closeInfoBubble.fire()});return d},removeMarker:function(a){var b=this.maps[this.api];b.removeOverlay(a.proprietary_marker)},declutterMarkers:function(a){throw"Not supported"},addPolyline:function(b,a){var d=this.maps[this.api];gpolyline=b.toProprietary(this.api);d.addOverlay(gpolyline);GEvent.addListener(gpolyline,"click",function(){b.click.fire()});return gpolyline},removePolyline:function(a){var b=this.maps[this.api];b.removeOverlay(a.proprietary_polyline)},getCenter:function(){var d=this.maps[this.api];var b=d.getCenter();var a=new mxn.LatLonPoint(b.lat(),b.lng());return a},setCenter:function(a,b){var e=this.maps[this.api];var d=a.toProprietary(this.api);if(b&&b.pan){e.panTo(d)}else{e.setCenter(d)}},setZoom:function(a){var b=this.maps[this.api];b.setZoom(a)},getZoom:function(){var a=this.maps[this.api];return a.getZoom()},getZoomLevelForBoundingBox:function(g){var f=this.maps[this.api];var e=g.getNorthEast();var a=g.getSouthWest();var b=new GLatLngBounds(a.toProprietary(this.api),e.toProprietary(this.api));var d=f.getBoundsZoomLevel(b);return d},setMapType:function(a){var b=this.maps[this.api];switch(a){case mxn.Mapstraction.ROAD:b.setMapType(G_NORMAL_MAP);break;case mxn.Mapstraction.SATELLITE:b.setMapType(G_SATELLITE_MAP);break;case mxn.Mapstraction.HYBRID:b.setMapType(G_HYBRID_MAP);break;case mxn.Mapstraction.PHYSICAL:b.setMapType(G_PHYSICAL_MAP);break;default:b.setMapType(a||G_NORMAL_MAP)}},getMapType:function(){var b=this.maps[this.api];var a=b.getCurrentMapType();switch(a){case G_NORMAL_MAP:return mxn.Mapstraction.ROAD;case G_SATELLITE_MAP:return mxn.Mapstraction.SATELLITE;case G_HYBRID_MAP:return mxn.Mapstraction.HYBRID;case G_PHYSICAL_MAP:return mxn.Mapstraction.PHYSICAL;default:return null}},getBounds:function(){var g=this.maps[this.api];var f,a,b,e;var d=g.getBounds();a=d.getSouthWest();f=d.getNorthEast();return new mxn.BoundingBox(a.lat(),a.lng(),f.lat(),f.lng())},setBounds:function(b){var e=this.maps[this.api];var a=b.getSouthWest();var d=b.getNorthEast();var f=new GLatLngBounds(new GLatLng(a.lat,a.lon),new GLatLng(d.lat,d.lon));e.setCenter(f.getCenter(),e.getBoundsZoomLevel(f))},addImageOverlay:function(d,a,g,k,h,j,f){var b=this.maps[this.api],i=new GLatLngBounds(new GLatLng(h,k),new GLatLng(f,j)),e=new GGroundOverlay(a,i);b.addOverlay(e)},setImagePosition:function(b,a){},addOverlay:function(a,b){var e=this.maps[this.api];var d=new GGeoXml(a);if(b){GEvent.addListener(d,"load",function(){d.gotoDefaultViewport(e)})}e.addOverlay(d)},addTileLayer:function(i,b,a,h,e,j){var d=new GCopyright(1,new GLatLngBounds(new GLatLng(-90,-180),new GLatLng(90,180)),0,"copyleft");var f=new GCopyrightCollection(a);f.addCopyright(d);var g=[];g[0]=new GTileLayer(f,h,e);g[0].isPng=function(){return true};g[0].getOpacity=function(){return b};g[0].getTileUrl=function(m,l){url=i;url=url.replace(/\{Z\}/g,l);url=url.replace(/\{X\}/g,m.x);url=url.replace(/\{Y\}/g,m.y);return url};if(j){var k=new GMapType(g,new GMercatorProjection(19),a,{errorMessage:"More "+a+" tiles coming soon"});this.maps[this.api].addMapType(k)}else{k=new GTileLayerOverlay(g[0]);this.maps[this.api].addOverlay(k)}this.tileLayers.push([i,k,true]);return k},toggleTileLayer:function(b){for(var a=0;a<this.tileLayers.length;a++){if(this.tileLayers[a][0]==b){if(this.tileLayers[a][2]){this.maps[this.api].removeOverlay(this.tileLayers[a][1]);this.tileLayers[a][2]=false}else{this.maps[this.api].addOverlay(this.tileLayers[a][1]);this.tileLayers[a][2]=true}}}},getPixelRatio:function(){var f=this.maps[this.api];var b=G_NORMAL_MAP.getProjection();var g=f.getCenter();var e=f.getZoom();var d=b.fromLatLngToPixel(g,e);var a=b.fromPixelToLatLng(new GPoint(d.x+3,d.y+4),e);return 10000/a.distanceFrom(g)},mousePosition:function(a){var d=document.getElementById(a);if(d!==null){var b=this.maps[this.api];GEvent.addListener(b,"mousemove",function(e){var f=e.lat().toFixed(4)+" / "+e.lng().toFixed(4);d.innerHTML=f});d.innerHTML="0.0000 / 0.0000"}},openBubble:function(a,b){var d=this.maps[this.api];d.openInfoWindowHtml(a.toProprietary(this.api),b)},closeBubble:function(){var a=this.maps[this.api];a.closeInfoWindow()}},LatLonPoint:{toProprietary:function(){return new GLatLng(this.lat,this.lon)},fromProprietary:function(a){this.lat=a.lat();this.lon=a.lng()}},Marker:{toProprietary:function(){var f=this;var e,g,i,a;var j={};if(this.labelText){j.title=this.labelText}if(this.iconUrl){var h=new GIcon(G_DEFAULT_ICON,this.iconUrl);h.printImage=h.mozPrintImage=h.image;if(this.iconSize){h.iconSize=new GSize(this.iconSize[0],this.iconSize[1]);var d;if(this.iconAnchor){d=new GPoint(this.iconAnchor[0],this.iconAnchor[1])}else{d=new GPoint(this.iconSize[0]/2,this.iconSize[1]/2)}h.iconAnchor=d}if(typeof(this.iconShadowUrl)!="undefined"){h.shadow=this.iconShadowUrl;if(this.iconShadowSize){h.shadowSize=new GSize(this.iconShadowSize[0],this.iconShadowSize[1])}}else{h.shadow="";h.shadowSize=""}if(this.transparent){h.transparent=this.transparent}if(this.imageMap){h.imageMap=this.imageMap}j.icon=h}if(this.draggable){j.draggable=this.draggable}var b=new GMarker(this.location.toProprietary("google"),j);if(this.infoBubble){if(this.hover){g="mouseover"}else{g="click"}GEvent.addListener(b,g,function(){b.openInfoWindowHtml(f.infoBubble,{maxWidth:100})})}if(this.hoverIconUrl){GEvent.addListener(b,"mouseover",function(){b.setImage(f.hoverIconUrl)});GEvent.addListener(b,"mouseout",function(){b.setImage(f.iconUrl)})}if(this.infoDiv){if(this.hover){g="mouseover"}else{g="click"}GEvent.addListener(b,g,function(){document.getElementById(f.div).innerHTML=f.infoDiv})}return b},openBubble:function(){var a=this.proprietary_marker;a.openInfoWindowHtml(this.infoBubble)},closeBubble:function(){var a=this.proprietary_marker;a.closeInfoWindow()},hide:function(){this.proprietary_marker.hide()},show:function(){this.proprietary_marker.show()},isHidden:function(){return this.proprietary_marker.isHidden()},update:function(){point=new mxn.LatLonPoint();point.fromProprietary("google",this.proprietary_marker.getPoint());this.location=point}},Polyline:{toProprietary:function(){var a=[];for(var b=0,d=this.points.length;b<d;b++){a.push(this.points[b].toProprietary("google"))}if(this.closed){return new GPolygon(a,this.color,this.width,this.opacity,this.fillColor||"#5462E3",this.fillOpacity||0.3)}else{return new GPolyline(a,this.color,this.width,this.opacity)}},show:function(){var a=this.proprietary_polyline;if(a.supportsHide()){a.show()}},hide:function(){var a=this.proprietary_polyline;if(a.supportsHide()){a.hide()}},isHidden:function(){return this.proprietary_polyline.isHidden()}}});