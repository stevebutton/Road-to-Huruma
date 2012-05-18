$(document).ready(function(){
	

	
	// 1. Example
	$('#circles').oSlider({
		autoStart: false,
		pauseOnHover: true,
		listNavThumbs: false,
		arrowsNavHide: true,
		layers: {
			first: {
				className: 'circles-one',
				offset: 6,
				direction: 'ltr'
			},
			second: {
				className: 'circles-two',
				offset: 16,
				direction: 'ltr'
			}
		}
	});
	
	
	
});