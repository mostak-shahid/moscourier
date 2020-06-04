<?php
function mos_home_url_replace($data) {
    $replace_fnc = str_replace('home_url()', home_url(), $data);
    $replace_br = str_replace('{{home_url}}', home_url(), $replace_fnc);
    return $replace_br;
}
//var_dump(mos_get_posts('layout'));
function mos_get_posts($post_type = 'post'){
	$output = array();
	$args = array(
		'post_type' => $post_type,
		'posts_per_page' => -1,
	);
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) {
	    while ( $the_query->have_posts() ) { $the_query->the_post();
	        $output[get_the_ID()] = get_the_title();
	    }
	}
	wp_reset_postdata();
	return $output;	
}
/*Variables*/
$template_parts = array(
    'Enabled'  => array(
        'content' => 'Content Section',
        'widgets' => 'Widgets Section',
    ),
    'Disabled' => array(
        'banner' => 'Home Banner',
    ),
);
/*Variables*/