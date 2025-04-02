<?php
/**
 * Executed when the GG Forms plugin is uninstalled.
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$delete_data = get_option( 'ggf_delete_data_on_uninstall' );

if ( $delete_data ) {
	delete_option( 'ggf_delete_data_on_uninstall' );
	delete_option( 'ggf_affiliate_link' );
	delete_option( 'ggf_review_author_type' );
	delete_option( 'ggf_review_author_name' );
	delete_option( 'ggf_review_datePublished' );
	delete_option( 'ggf_reviewRating' );
	delete_option( 'ggf_reviewBody' );
}
