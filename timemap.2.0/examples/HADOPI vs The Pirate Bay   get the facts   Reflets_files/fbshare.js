(function() {

	// default case
	
	if (typeof fbShare == 'undefined') {
		fbShare = {};
	}

	var getUrlVars = function()
	{
	  var vars = [], hash;
	  var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
	  for(var i = 0; i < hashes.length; i++)
	  {
	    hash = hashes[i].split('=');
	    vars.push(hash[0]);
	    vars[hash[0]] = hash[1];
	  }
	  return vars;
	}

	var src = 'http://widgets.fbshare.me/files/fbshare.php';
	//var src = 'fbshare.php';
	src += '?size=';
	switch(fbShare.size) {
		case 'small':
			src += 'small';
			width = 80;
			height = 18;
			break
	    case 'large':
	    default:
	    	src += 'large';
	    	width = 53;
	    	height = 69;
	    	break;  
	}
	src += "&url=";
	if ( fbShare.url ) {
		src += encodeURI(fbShare.url);
		var pageParams = getUrlVars();
		if ( pageParams['awesm'] ) {
			src += '&awesm_parent=' + pageParams['awesm'];
		}
	} else {
		src += encodeURI(location.href);
	}
	src += "&title=";
	if ( fbShare.title ) {
		src += fbShare.title;
	} else {
		src += document.title;
	}
	if ( fbShare.google_analytics ) {
		src += "&google_analytics=" + fbShare.google_analytics;	
	}
	if ( fbShare.awesm_api_key ){
		src += "&awesm_api_key=" + fbShare.awesm_api_key;		
	}
	if ( fbShare.badge_color) {
		src += "&badge_color=" + fbShare.badge_color;
	}
	if ( fbShare.badge_text ) {
		src += "&badge_text=" + fbShare.badge_text;
	}
	document.write('<iframe src="' + src + '" width="' + width + '" height="' + height + '" frameborder="0" scrolling="no" allowtransparency="true"></iframe>'); 
})();