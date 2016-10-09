<?php
// Add custom functions here

wp_register_script( 'bdrumes-js', get_stylesheet_directory_uri().'/assets/js/bdrumes.js', 'jquery', "1.0", true);

wp_register_script( 'slick', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js', null, null, true);
wp_register_style( 'slick', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css', array(), null);
wp_register_style( 'slick-theme', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick-theme.css', array(), null);


wp_enqueue_script( 'bdrumes-js' );
wp_enqueue_script( 'slick' );
wp_enqueue_style( 'slick-theme' );