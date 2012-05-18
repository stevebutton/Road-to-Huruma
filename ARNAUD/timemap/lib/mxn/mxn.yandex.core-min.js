/*
Copyright (c) 2011 Tom Carden, Steve Coast, Mikel Maron, Andrew Turner, Henri Bergius, Rob Moran, Derek Fowler
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

 * Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
 * Neither the name of the Mapstraction nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/
mxn.register("yandex",{Mapstraction:{init:function(b,c){var d=this;if(YMaps){var a=this.maps[c]=new YMaps.Map(b);YMaps.Events.observe(a,a.Events.Click,function(f,h){var e=h.getCoordPoint().getX();var g=h.getCoordPoint().getY();d.click.fire({location:new mxn.LatLonPoint(e,g)})});YMaps.Events.observe(a,a.Events.SmoothZoomEnd,function(e){d.changeZoom.fire()});this.loaded[c]=true;d.load.fire()}else{alert(c+" map script not imported")}},applyOptions:function(){var a=this.maps[this.api];if(this.options.enableScrollWheelZoom){a.enableScrollZoom(true)}if(this.options.enableDragging){a.enableDragging()}else{a.disableDragging()}},resizeTo:function(b,a){this.currentElement.style.width=b;this.currentElement.style.height=a;this.maps[this.api].redraw()},addControls:function(a){var b=this.maps[this.api];if(a.zoom=="large"){this.addLargeControls()}else{if(a.zoom=="small"){this.addSmallControls()}}if(a.pan){this.controls.unshift(new YMaps.ToolBar());this.addControlsArgs.pan=true;b.addControl(this.controls[0])}if(a.scale){this.controls.unshift(new YMaps.ScaleLine());this.addControlsArgs.scale=true;b.addControl(this.controls[0])}if(a.overview){if(typeof(a.overview)!="number"){a.overview=5}this.controls.unshift(new YMaps.MiniMap(a.overview));this.addControlsArgs.overview=true;b.addControl(this.controls[0])}if(a.map_type){this.addMapTypeControls()}},addSmallControls:function(){var a=this.maps[this.api];this.controls.unshift(new YMaps.SmallZoom());this.addControlsArgs.zoom="small";a.addControl(this.controls[0])},addLargeControls:function(){var a=this.maps[this.api];this.controls.unshift(new YMaps.SmallZoom());this.addControlsArgs.zoom="large";a.addControl(this.controls[0])},addMapTypeControls:function(){var a=this.maps[this.api];this.controls.unshift(new YMaps.TypeControl());this.addControlsArgs.map_type=true;a.addControl(this.controls[0])},setCenterAndZoom:function(a,b){var d=this.maps[this.api];var c=a.toProprietary(this.api);d.setCenter(c,b)},addMarker:function(b,a){var d=this.maps[this.api];var c=b.toProprietary(this.api);d.addOverlay(c);return c},removeMarker:function(a){var b=this.maps[this.api];b.removeOverlay(a.proprietary_marker)},declutterMarkers:function(a){throw"Not supported"},addPolyline:function(b,a){var d=this.maps[this.api];var c=b.toProprietary(this.api);d.addOverlay(c);return c},removePolyline:function(a){var b=this.maps[this.api];b.removeOverlay(a.proprietary_polyline)},getCenter:function(){var c=this.maps[this.api];var b=c.getCenter();var a=new mxn.LatLonPoint(b.getLat(),b.getLng());return a},setCenter:function(a,b){var d=this.maps[this.api];var c=a.toProprietary(this.api);d.setCenter(c)},setZoom:function(a){var b=this.maps[this.api];b.setZoom(a)},getZoom:function(){var b=this.maps[this.api];var a=b.getZoom();return a},getZoomLevelForBoundingBox:function(e){var d=this.maps[this.api];var c=e.getNorthEast().toProprietary(this.api);var a=e.getSouthWest().toProprietary(this.api);var b=new YMaps.GeoBounds(c,a).getMapZoom(d);return b},setMapType:function(a){var b=this.maps[this.api];switch(a){case mxn.Mapstraction.ROAD:b.setType(YMaps.MapType.MAP);break;case mxn.Mapstraction.SATELLITE:b.setType(YMaps.MapType.SATELLITE);break;case mxn.Mapstraction.HYBRID:b.setType(YMaps.MapType.HYBRID);break;default:b.setType(a||YMaps.MapType.MAP)}},getMapType:function(){var b=this.maps[this.api];var a=b.getType();switch(a){case YMaps.MapType.MAP:return mxn.Mapstraction.ROAD;case YMaps.MapType.SATELLITE:return mxn.Mapstraction.SATELLITE;case YMaps.MapType.HYBRID:return mxn.Mapstraction.HYBRID;default:return null}},getBounds:function(){var d=this.maps[this.api];var b=d.getBounds();var c=b.getLeftBottom();var a=b.getRightTop();return new mxn.BoundingBox(c.getLat(),c.getLng(),a.getLat(),a.getLng())},setBounds:function(d){var g=this.maps[this.api];var b=d.getSouthWest();var f=d.getNorthEast();var a=new YMaps.GeoPoint(b.lon,b.lat);var c=new YMaps.GeoPoint(f.lon,f.lat);var e=new YMaps.GeoBounds(a,c);g.setZoom(e.getMapZoom(g));g.setCenter(e.getCenter())},addImageOverlay:function(c,a,g,l,h,i,e,k){var b=this.maps[this.api];var f=this;var j=function(m){var n;this.onAddToMap=function(p,o){n=o;n.appendChild(m);this.onMapUpdate()};this.onRemoveFromMap=function(){if(n){n.removeChild(m)}};this.onMapUpdate=function(){f.setImagePosition(c)}};var d=new j(k.imgElm);b.addOverlay(d);this.setImageOpacity(c,g);this.setImagePosition(c)},setImagePosition:function(g,d){var f=this.maps[this.api];var c=new YMaps.GeoPoint(d.latLng.left,d.latLng.top);var b=new YMaps.GeoPoint(d.latLng.right,d.latLng.bottom);var e=f.converter.coordinatesToMapPixels(c);var a=f.converter.coordinatesToMapPixels(b);d.pixels.top=e.y;d.pixels.left=e.x;d.pixels.bottom=a.y;d.pixels.right=a.x},addOverlay:function(b,c){var d=this.maps[this.api];var a=new YMaps.KML(b);d.addOverlay(a);YMaps.Events.observe(a,a.Events.Fault,function(e,f){alert("KML upload faults. Error: "+f)})},addTileLayer:function(l,f,e,k,g,m){var b=this.maps[this.api];var a=new YMaps.TileDataSource(l,true,true);a.getTileUrl=function(n,o){return this._tileUrlTemplate.replace(/\{X\}/g,n.x).replace(/\{Y\}/g,n.y).replace(/\{Z\}/g,o)};var j=new YMaps.Layer(a);j._$element.css("opacity",f);if(m){var i=Math.round(Math.random()*Date.now()).toString();YMaps.Layers.add(i,j);var c=new YMaps.MapType([i],e,{textColor:"#706f60",minZoom:k,maxZoom:g});var h;for(var d in b.__controls){if(b.__controls[d] instanceof YMaps.TypeControl){h=b.__controls[d];break}}if(!h){h=new YMaps.TypeControl();b.addControl(h)}h.addType(c)}else{b.addLayer(j);b.addCopyright(e)}this.tileLayers.push([l,j,true]);return j},toggleTileLayer:function(c){var b=this.maps[this.api];for(var a=0;a<this.tileLayers.length;a++){if(this.tileLayers[a][0]==c){if(this.tileLayers[a][2]){this.maps[this.api].removeLayer(this.tileLayers[a][1]);this.tileLayers[a][2]=false}else{this.maps[this.api].addLayer(this.tileLayers[a][1]);this.tileLayers[a][2]=true}}}},getPixelRatio:function(){throw"Not implemented"},mousePosition:function(a){var c=document.getElementById(a);if(c!==null){var b=this.maps[this.api];YMaps.Events.observe(b,b.Events.MouseMove,function(e,g){var d=g.getGeoPoint();var f=d.getY().toFixed(4)+" / "+d.getX().toFixed(4);c.innerHTML=f});c.innerHTML="0.0000 / 0.0000"}}},LatLonPoint:{toProprietary:function(){return new YMaps.GeoPoint(this.lon,this.lat)},fromProprietary:function(a){this.lat=a.getLat();this.lon=a.getLng();return this}},Marker:{toProprietary:function(){var c={hideIcon:false,draggable:this.draggable};if(this.iconUrl){var e=new YMaps.Style();var d=e.iconStyle=new YMaps.IconStyle();d.href=this.iconUrl;if(this.iconSize){d.size=new YMaps.Point(this.iconSize[0],this.iconSize[1]);var b;if(this.iconAnchor){b=new YMaps.Point(this.iconAnchor[0],this.iconAnchor[1])}else{b=new YMaps.Point(0,0)}d.offset=b}if(this.iconShadowUrl){d.shadow=new YMaps.IconShadowStyle();d.shadow.href=this.iconShadowUrl;if(this.iconShadowSize){d.shadow.size=new YMaps.Point(this.iconShadowSize[0],this.iconShadowSize[1]);d.shadow.offset=new YMaps.Point(0,0)}}c.style=e}var a=new YMaps.Placemark(this.location.toProprietary("yandex"),c);if(this.hoverIconUrl){var f=this;YMaps.Events.observe(a,a.Events.MouseEnter,function(h,i){var g=a.getOptions();if(!f.iconUrl){f.iconUrl=a._icon._context._computedStyle.iconStyle.href;g.style=a._icon._context._computedStyle}g.style.iconStyle.href=f.hoverIconUrl;a.setOptions(g)});YMaps.Events.observe(a,a.Events.MouseLeave,function(h,i){var g=a.getOptions();g.style.iconStyle.href=f.iconUrl;a.setOptions(g)})}if(this.labelText){a.name=this.labelText}if(this.infoBubble){a.setBalloonContent(this.infoBubble)}YMaps.Events.observe(a,a.Events.DragEnd,function(h){var g=new mxn.LatLonPoint().fromProprietary("yandex",h.getGeoPoint());this.mapstraction_marker.location=g;this.mapstraction_marker.dragend.fire(g)});return a},openBubble:function(){this.proprietary_marker.openBalloon()},closeBubble:function(){this.proprietary_marker.closeBalloon()},hide:function(){this.proprietary_marker._$iconContainer.addClass("YMaps-display-none")},show:function(){this.proprietary_marker._$iconContainer.removeClass("YMaps-display-none")},update:function(){point=new mxn.LatLonPoint();point.fromProprietary("yandex",this.proprietary_marker.getGeoPoint());this.location=point}},Polyline:{toProprietary:function(){var d=[];for(var b=0,c=this.points.length;b<c;b++){d.push(this.points[b].toProprietary("yandex"))}var a={style:{lineStyle:{strokeColor:this.color.replace("#",""),strokeWidth:this.width}}};if(this.closed||d[0].equals(d[c-1])){a.style.polygonStyle=a.style.lineStyle;if(this.fillColor){a.style.polygonStyle.fill=true;var e=(Math.round((this.opacity||1)*255)).toString(16);a.style.polygonStyle.fillColor=this.fillColor.replace("#","")+e}return new YMaps.Polygon(d,a)}else{return new YMaps.Polyline(d,a)}},hide:function(){this.proprietary_polyline._container._$container.addClass("YMaps-display-none")},show:function(){this.proprietary_polyline._container._$container.removeClass("YMaps-display-none")}}});