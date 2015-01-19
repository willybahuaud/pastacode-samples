<?php
//Take WordPress SVN, for example
//register a provider
add_filter( 'pastacode_services', '_pastacode_services' );
function _pastacode_services( $services ) {
    $services['wordpress'] = 'core.svn.wordpress.org'; // key for shortcode, and value for text
    return $services;
}

//Define pastabox lightbox inputs
add_action( 'pastacode_fields', '_pastacode_fields' );
function _pastacode_fields( $fields ) { 
    $fields['wordpress'] = array(  // 'wordpress' or 'whatever'
        'classes'     => array( 'wordpress' ), // same value as the key
        'label'       => sprintf( __('File path relative to %s', 'pastacode'), 'http://core.svn.wordpress.org/' ), 
        'placeholder' =>'trunk/wp-config-sample.php', //if placeholder isn't defined, it will be a textarea
        'name'        => 'path_id' //these value return shortcode attribute (path_id, repos, name, user, version)
        );
    return $fields;
}

//Build the function to retrieve the code
// "pastacode_wordpress" hook name (1st param) = "pastacode_" + "wordpress" or "whatever"
add_action( 'pastacode_wordpress', '_pastacode_wordpress', 10, 2 );
function _pastacode_wordpress( $source, $atts ) {
    extract( $atts );
    if( $path_id ) {
        $req  = wp_sprintf( 'http://core.svn.wordpress.org/%s', str_replace( 'http://core.svn.wordpress.org/', '', $path_id ) );
        $code = wp_remote_get( $req );
        if( ! is_wp_error( $code ) && 200 == wp_remote_retrieve_response_code( $code ) ) {
            $data = wp_remote_retrieve_body( $code );
            $source[ 'url' ]  = $req; //url to view source
            $source[ 'name' ] = basename( $req ); //filename
            $source[ 'code' ] = esc_html( $data ); //the code !!   
            //$source[ 'raw' ] contain raw source code. But there are no raw source code delivered by WordPress SVN             
        }
    }
    return $source;
}