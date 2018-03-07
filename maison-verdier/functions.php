<?php

/*
* Add your own functions here. You can also copy some of the theme functions into this file.
* Wordpress will use those functions instead of the original functions then.
*/
add_filter('woocommerce_variable_price_html', 'custom_variation_price', 10, 2);

// Load languages from child theme
function maisonverdier_theme_setup() {
    load_child_theme_textdomain( 'Divi', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'maisonverdier_theme_setup' );

function custom_variation_price( $price, $product ) {
    $price = '';

    if ( !$product->min_variation_price || $product->min_variation_price !== $product->max_variation_price ) $price .= '<span class="from">' . _x('à partir de', 'min_price', 'woocommerce') . ' </span>';
    $price .= woocommerce_price($product->get_price());
    if ( $product->max_variation_price && $product->max_variation_price !== $product->min_variation_price ) {
        $price .= '<span class="to"> ' . _x('to', 'max_price', 'woocommerce') . ' </span>';

        $price .= woocommerce_price($product->max_variation_price);
    }

    return $price;
}



function woo_custom_taxonomy_in_body_class( $classes ){
    if( is_singular( 'product' ) )
    {
        $custom_terms = get_the_terms(0, 'product_cat');
        if ($custom_terms) {
            foreach ($custom_terms as $custom_term) {
                $classes[] = 'product_cat_' . $custom_term->slug;
            }
        }
    }
    return $classes;
}

add_filter( 'body_class', 'woo_custom_taxonomy_in_body_class' );

// woocommerce show more custom button
add_action( 'woocommerce_single_product_summary', 'woocommerce_show_more_button', 35 );

function woocommerce_show_more_button() {
    echo '<p id="showMoreInfosButton" class="cart"><a  rel="nofollow" class="button alt">'.__( "More informations", "Divi" ).'</a></p>';
}


