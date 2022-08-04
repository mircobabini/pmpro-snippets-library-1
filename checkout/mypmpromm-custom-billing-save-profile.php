<?php
/**
 * This recipe will geocode custom billing fields upon saving a member's profile.
 *
 * title: Geocode custom billing fields upon saving profile
 * layout: snippet
 * collection: checkout
 * category: custom geocode
 *
 * You can add this recipe to your site by creating a custom plugin
 * or using the Code Snippets plugin available for free in the WordPress repository.
 * Read this companion article for step-by-step directions on either method.
 * https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */

function mypmpromm_save_profile_billing_fields( $user_id ){

	if( !function_exists( 'pmpromm_geocode_address' ) ){
		return;
	}

	$pmpro_baddress1 = ( !empty( $_REQUEST['pmpro_baddress1'] ) ) ? $_REQUEST['pmpro_baddress1'] : "";
	$pmpro_baddress2 = ( !empty( $_REQUEST['pmpro_baddress2'] ) ) ? $_REQUEST['pmpro_baddress2'] : "";
	$pmpro_bcity = ( !empty( $_REQUEST['pmpro_bcity'] ) ) ? $_REQUEST['pmpro_bcity'] : "";
	$pmpro_bstate = ( !empty( $_REQUEST['pmpro_bstate'] ) ) ? $_REQUEST['pmpro_bstate'] : "";
	$pmpro_bzipcode = ( !empty( $_REQUEST['pmpro_bzipcode'] ) ) ? $_REQUEST['pmpro_bzipcode'] : "";

	$member_address = array(
		'street' 	=> $pmpro_baddress1.' '.$pmpro_baddress2,
		'city' 		=> $pmpro_bcity,
		'state' 	=> $pmpro_bstate,
		'zip' 		=> $pmpro_bzipcode
	);

	$coordinates = pmpromm_geocode_address( $member_address );

	if( is_array( $coordinates ) ){
		update_user_meta( $user_id, 'pmpro_lat', $coordinates['lat'] );
		update_user_meta( $user_id, 'pmpro_lng', $coordinates['lng'] );
	}

}
add_action( 'profile_update', 'mypmpromm_save_profile_billing_fields' );
