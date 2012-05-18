// JavaScript Document

 <script>
   /**********ENTER**************/
	$("#mapicon").hover(function() {
		$(this).css('cursor','pointer');
	}, function() {
 		$(this).css('cursor','auto');
	});
	
	$("#titlelanding").hover(function() {
		$(this).css('cursor','pointer');
	}, function() {
 		$(this).css('cursor','auto');
	});

	$( "#enter" ).click(function(){
	$( "#titlelanding" ).fadeOut(1000);
		$( "#farright" ).delay(1000).animate({ width: "75px" }, 1000 )
		/*$( "#left" ).css('visibility', 'visible');
		*/$( "#left" ).delay(600).fadeIn(1000);
		$( "#right" ).delay(600).fadeIn(1000);
		
		$('#iframeholder').show();
	});
	
	$( "#titlelanding" ).click(function(){
	$( "#titlelanding" ).fadeOut(1000);
		$( "#farright" ).delay(1000).animate({ width: "75px" }, 1000 )
		/*$( "#left" ).css('visibility', 'visible');
		*/$( "#left" ).delay(600).fadeIn(1000);
		$( "#right" ).delay(600).fadeIn(1000);
		$( "#enter" ).delay(600).fadeIn(1000);
		
		$('#iframeholder').show();
	});

	$( "#mapicon" ).click(function(){
		$( "#right" ).fadeOut(1000);
		$( "#left" ).fadeOut(1000);
		$( "#farright" ).delay(1000).animate({ width: "100%" }, 1000 )
		$( "#titlelanding" ).delay(2000).fadeIn(1000);
		/*$( "#left" ).animate({ left: "0px" }, 500 )
		$( "#right" ).animate({ left: "350px" }, 500 )
	*/});
</script>