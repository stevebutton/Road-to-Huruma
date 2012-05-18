<?php
add_theme_support( 'post-thumbnails', array( 'post', 'portfolio_item', 'slide' ) );
set_post_thumbnail_size( 590, 240, true ); // Standard Size Thumbnails
add_image_size( 'related-thumb', 100, 80 ); // Related Posts Thumbnails
?>