<?php
// This is a comment
$test = array( 'World' );
$test = array_splice( $test, 1, 0, 'Hello' );
echo implode( array_reverse( $test ), ' ' ) . '!';

