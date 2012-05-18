<?php require( CELTA_LIB . "theme-options-vars.php" ); ?>


<div id="left">
<div id="mastertitle">
<div id="masterbannerleft"></div>
<div id="masterbanner"></div>
<!--<div id="rightcontainer">

    
    <div id="goarrowleft"></div>
	<div id="goarrowright"></div>
	</div>-->

</div>
   
<ul id="navigation">
		<?php 
			$pages = get_pages( 'sort_order=asc&sort_column=menu_order&depth=1' );
			foreach ( $pages as $pag ) {
				$new_title = str_replace( " ", "", strtolower( $pag->post_name ) );
				echo '<li><a href="#' . $new_title . '" title="' . $pag->post_title . '">' . $pag->post_title . '</a></li>';
			}
		?>
   
   <div id="ssswitch"> <div id="sstext">Explanation of this and how to use itExplanation of this and how to use itExplanation of this and how to use itExplanation of this and how to use it</div></div>
  
  </ul>
 
<!--<div id="mapmenu"></div>-->
	<div id="logo">
      
   
		<h1>
			<a href="#home">
				<?php if ( $celta_logo != '' ) { ?>
					<img src="<?php echo $celta_logo; ?>" alt="" />
				<?php } else { ?>
					<?php bloginfo( 'name' ); ?>
				<?php } ?>
			</a>
		</h1>
		<p><?php bloginfo( 'description' ); ?></p>
	</div>
    
    <div id="mapmenucontainer">

    <div id="goyears"></div>
    <div id="gomonths"></div>
    <div id="goweeks"></div>
    <div id="godays"></div>
    <div id="gotoday"></div>
    <div id="gozoom"></div>
    <div id ="tempdates">
    
     <div id="go2002" style="padding: 10px;">2002</div>
     <div id="go2005" style="padding: 10px;">2005</div>
     <div id="go2006" style="padding: 10px;">2006</div>
     <div id="go2010" style="padding: 10px;">2010</div>
     <div id="go2011" style="padding: 10px;">2011</div>
     <div id="go2015" style="padding: 10px;">2015</div>
    
  </div>
   
</div>
    
	<p id="copyright"><?php echo $celta_copyright; ?></p>
    
</div><!-- end left -->	

<script>


</script>