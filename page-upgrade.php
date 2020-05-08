<?php get_header() ?>
<?php 
global $wpdb;
$table = $wpdb->prefix.'orders';
$args = array(
	'post_type' => 'courierorder',
	'posts_per_page' => 2000,
    'meta_query' => array(
        array(
            'key'     => '_mos_courier_payments',
            // 'compare' => 'NOT EXISTS',
        ),
    ),	
);
// The Query
$query = new WP_Query( $args );
 
// The Loop
if ( $query->have_posts() ) {
	while ( $query->have_posts() ) : $query->the_post();
	$post_id = get_the_ID();
	$payments = get_post_meta( $post_id, '_mos_courier_payments', true );
	if (@$payments){
        foreach($payments as $date => $paid_amount){
        	add_post_meta( $post_id, '_mos_courier_payment_amount', $paid_amount);
        }							        	
    }
    delete_post_meta( $post_id, '_mos_courier_payments');
	endwhile;
} else {
	echo 'Updated';
}
/* Restore original Post Data */
wp_reset_postdata();
?>
Done
<?php get_footer() ?>