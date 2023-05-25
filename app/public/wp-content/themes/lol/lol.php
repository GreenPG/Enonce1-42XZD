<?php
/*
Template Name: lol
*/
function get_some_data( $value ){
    echo "<script>console.log('Debug Objects:' );</script>";
    global $wpdb;
    return $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wp_totalsurvey_entries" );
}