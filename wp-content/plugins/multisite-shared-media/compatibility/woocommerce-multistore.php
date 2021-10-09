<?php
/**
 * Created by PhpStorm.
 * User: johannes
 * Date: 4.4.2017
 * Time: 15:38
 */


/**
 * @param $attachment \MSMMediaItem
 *
 * @return mixed
 * Woocommerce Multistore handles product image synchronization. Skip all media files which have product as parent post.
 */
function msm_ignore_product_images( $attachment ){

    /* Ignore all media files submitted in product edit screen */
    if( 'editpost' === $_POST['action'] && 'product' === $_POST['post_type'] ){
        $attachment->mark_ignored();
    }

    /* Ignore also if attachment parent is of type product */
    $parent = wp_get_post_parent_id( $attachment->get_post() );
    $parent_type = ($parent > 0) ? get_post_type( $parent ) : 'undefined';

    $skipped_types = array( 'product', 'product_variation' );

    if( true === in_array( $parent_type, $skipped_types, true ) ) {
	    $attachment->mark_ignored();
    }

    return $attachment;
}


function msm_compat_wc_multistore() {
	if ( function_exists( 'is_plugin_active' ) && is_plugin_active( 'woocommerce-multistore/woocommerce-multistore.php' ) ) {
		add_filter( 'msm_filter_replicable_attachments', 'msm_ignore_product_images' );
	}
}
add_action( 'wp_loaded', 'msm_compat_wc_multistore' );