<?php
add_action( 'wp_enqueue_scripts', 'custom_enqueue_script', 11 );
function custom_enqueue_script() {
	wp_deregister_script( 'prismjs' );
	wp_register_script( 'prismjs', get_stylesheet_directory_uri() . '/my-prismjs.css', false, true );
}

add_filter( 'pastacode_langs', 'pastacode_new_langages' );
function pastacode_new_langages( $languages ) {
	unset( $languages['cpp'] ); // I dont want C++
	$languages['scala'] = 'Scala'; // I want Scala :-)
	return $languages;
}