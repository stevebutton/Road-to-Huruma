$(document).ready(function(){
	
	// 0. Start page
	$('#start').oSlider({
		autoStart: false,
		animSpeed: 650,
		layers: {
			first: {
				className: 'start-blur',
				offset: 2,
				direction: 'ltr'
			},
			second: {
				className: 'start-flakes',
				offset: 5,
				direction: 'ltr'
			}
		}
	});
	
	// 1. Example
	$('#circles').oSlider({
		autoStart: true,
		pauseOnHover: true,
		listNavThumbs: true,
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
	
	// 2. Example
	$('#color_lines').oSlider({
		layers: {
			first: {
				className: 'layer-color-lines',
				offset: 20,
				direction: 'ltr'
			}
		}
	});
	
	// 3. Example
	$('#rhombuses').oSlider({
		layers: {
			first: {
				className: 'layer-rhombuses',
				offset: 5,
				direction: 'rtl'
			}
		}
	});
	
	// 4. Examples
	$('#blackwhite').oSlider({
		layers: {
			first: {
				className: 'layer-blackwhite',
				offset: 10,
				direction: 'ltr'
			}
		}
	});
	
	// 5. Examples
	$('#orange_flakes').oSlider({
		animSpeed: 650,
		liquidLayout: false,
		layers: {
			first: {
				className: 'orange-flakes-one',
				offset: 5,
				direction: 'ltr'
			},
			second: {
				className: 'orange-flakes-two',
				offset: 2,
				direction: 'ltr'
			}
		}
	});
	
	// 6. Example
	$('#small').oSlider({
		animSpeed: 750,
		liquidLayout: false,
		layers: {
			first: {
				className: 'flowers-pattern',
				offset: 10,
				direction: 'ltr'
			}
		}
	});
	
});