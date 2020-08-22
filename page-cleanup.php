<?php get_header() ?>
<?php 
global $wpdb;
$orders = $wpdb->get_results( "SELECT ID FROM {$wpdb->prefix}posts WHERE post_type='courierorder' limit 2000", OBJECT );
if($orders) {
    courierorderDelete($orders);
}

function courierorderDelete($orders){
    global $wpdb;
    foreach ($orders as $row) {
        // $wpdb->delete( $wpdb->prefix."posts", array( 'ID' => $row->ID ) );
        // $wpdb->query($wpdb->prepare("DELETE FROM ".$wpdb->prefix."postmeta WHERE post_id = %d",$row->ID));

        wp_delete_post( $row->ID, true );


        $wpdb->query($wpdb->prepare("DELETE FROM ".$wpdb->prefix."orders WHERE post_id = %d",$row->ID));

    }
    $orders = $wpdb->get_results( "SELECT ID FROM ".$wpdb->prefix."posts WHERE post_type='courierorder' limit 2000", OBJECT );  
    if($orders) {
        courierorderDelete($orders);
    }
}
echo 'All Orders have been deleted <br/>';

$expences = $wpdb->get_results( "SELECT ID FROM {$wpdb->prefix}expence WHERE 1 limit 2000", OBJECT );
if($expences) {
    courierexpenceDelete($expences);
}

function courierexpenceDelete($expences){
    global $wpdb;
    foreach ($expences as $row) {
        $wpdb->delete( $wpdb->prefix."expence", array( 'ID' => $row->ID ) );

    }
    $expences = $wpdb->get_results( "SELECT ID FROM {$wpdb->prefix}expence WHERE 1 limit 2000", OBJECT ); 
    if($expences) {
        courierorderDelete($expences);
    }
}
echo 'All expences have been deleted <br/>';

$users = get_users( [ 'role__in' => [ 'operator', 'merchant' ] ] );
// Array of WP_User objects.
foreach ( $users as $user ) {
    wp_delete_user( $user->ID );
    // echo '<span>' . $user->ID . '.'.$user->display_name . '</span><br/>';
}
echo 'All users have been deleted <br/>';
?>
<?php get_footer() ?>