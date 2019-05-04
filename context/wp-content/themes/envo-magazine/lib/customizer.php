<?php
/**
 * Envo Magazine Theme Customizer
 *
 * @package Envo Magazine
 */

$envo_magazine_sections = array( 'info' );

foreach( $envo_magazine_sections as $s ){
    require get_template_directory() . '/lib/customizer/' . $s . '.php';
}

function envo_magazine_customizer_scripts() {
    wp_enqueue_style( 'envo-magazine-customize',get_template_directory_uri().'/lib/customizer/css/customize.css', '', 'screen' );
    wp_enqueue_script( 'envo-magazine-customize', get_template_directory_uri() . '/lib/customizer/js/customize.js', array( 'jquery' ), '20170404', true );
}
add_action( 'customize_controls_enqueue_scripts', 'envo_magazine_customizer_scripts' );
