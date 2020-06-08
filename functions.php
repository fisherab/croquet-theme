<?php
function croquet_enqueue_styles() {

    $parent_style = 'twentyseventeen-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
    wp_enqueue_style('font-awesome', 'https://use.fontawesome.com/releases/v5.0.6/css/all.css'); 
}
add_action( 'wp_enqueue_scripts', 'croquet_enqueue_styles' );

function mucd_primary_table_to_copy($primary_tables) {
    $primary_tables[] = 'duplicator_packages';
    $primary_tables[] = 'supsystic_tbl_columns';
    $primary_tables[] = 'supsystic_tbl_diagrams';
    $primary_tables[] = 'supsystic_tbl_rows';
    $primary_tables[] = 'supsystic_tbl_tables';
    $primary_tables[] = 'masterslider_sliders';
    $primary_tables[] = 'masterslider_options';
    return $primary_tables;
}

add_filter('mucd_default_primary_tables_to_copy', 'mucd_primary_table_to_copy');
add_filter( 'allow_subdirectory_install', 
  create_function( '', 'return true;' )
);
add_theme_support( 'sportspress' );

?>
