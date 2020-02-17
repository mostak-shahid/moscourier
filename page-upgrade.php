<?php get_header() ?>
<?php 
global $wpdb;
$table = $wpdb->prefix.'orders';
$args = array(
	'post_type' => 'courierorder',
	'posts_per_page' => 2000,
    'meta_query' => array(
        array(
            'key'     => '_mos_courier_delivery_man_update',
            'compare' => 'NOT EXISTS',
        ),
    ),	
);
// The Query
$query = new WP_Query( $args );
 
// The Loop
if ( $query->have_posts() ) {
	while ( $query->have_posts() ) : $query->the_post();
	$post_id = get_the_ID();
	$delivery_man = get_post_meta( $post_id, '_mos_courier_delivery_man', true );
	update_post_meta( $post_id, '_mos_courier_delivery_man_update', 1 );
	// $brand_name = get_user_meta( $merchant_id, 'brand_name', true );
	// $cn = get_the_title();

	// $receiver_name = get_post_meta( $post_id, '_mos_courier_receiver_name', true );
	// $receiver_address = get_post_meta( $post_id, '_mos_courier_receiver_address', true );
	// $receiver_number = get_post_meta( $post_id, '_mos_courier_receiver_number', true );
	// $receiver = '<h5>'.$receiver_name.'</h5><div>'.$receiver_address.'</div><div>'.$receiver_number.'</div>';

	// $booking_date = get_post_meta( $post_id, '_mos_courier_booking_date', true );
	// $date = date_create($booking_date);
	// $booking = date_format($date,"Y-m-d");

	// $delivery_status = get_post_meta( $post_id, '_mos_courier_delivery_status', true );
	// $payment_status = get_post_meta( $post_id, '_mos_courier_payment_status', true );

	// $brand = get_post_meta( $post_id, '_mos_courier_brand_name', true );
	//$exists = $wpdb->get_var( "SELECT COUNT(*) FROM {$table} WHERE post_id={$post_id} AND delivery_man_id!=''" );
	//var_dump($exists);
	//if (!@$exists){
		//ID	post_id	merchant_id	receiver	cn	booking	delivery_status	payment_status	brand
		$wpdb->update( 
			$table, 
			array( 
				// 'post_id' => $post_id, 
				// 'merchant_id' => $merchant_id, 
				// 'receiver' => $receiver, 
				// 'cn' => $cn, 
				// 'booking' => $booking, 
				// 'delivery_status' => $delivery_status, 
				// 'payment_status' => $payment_status, 
				// 'brand' => $brand_name,
				'delivery_man_id' => $delivery_man,
			),
			array(
				'post_id' => $post_id,
			)
		);
	//}

	endwhile;
} else {
	echo 'Updated';
}
/* Restore original Post Data */
wp_reset_postdata();
?>
Done
<?php get_footer() ?>