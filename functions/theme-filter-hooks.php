<?php
function add_slug_body_class( $classes ) {
    global $post;
    if ( isset( $post ) AND $post->post_type == 'page' ) {
        $classes[] = $post->post_type . '-' . $post->post_name;
    } else {
        $classes[] = $post->post_type . '-archive';
    }
    return $classes;
}
// add_filter( 'body_class', 'add_slug_body_class' );

add_action( 'action_below_footer', 'back_to_top_fnc', 10, 1 );
function back_to_top_fnc () {
    global $moscourier_options;
    if ($moscourier_options['misc-back-top']) :
    ?>
    <a href="javascript:void(0)" class="scrollup" style="display: none;"><img width="40" height="40" src="<?php echo get_template_directory_uri() ?>/images/icon_top.png" alt="Back To Top"></a>
    <?php 
    endif;
}
function custom_admin_script(){
    $frontpage_id = get_option( 'page_on_front' );
    if ($_GET['post'] == $frontpage_id){ 
        ?>
        <script>
        jQuery(document).ready(function($){
            $('#_moscourier_banner_details').hide();
        });
        </script>
        <?php 
    }
        
}
// add_action('admin_head', 'custom_admin_script');
add_filter('wpcf7_form_elements', function($content) {
    $content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);
    return $content;
});
function make_tml_forms_bootstrap_compatible() {
    foreach ( tml_get_forms() as $form ) {
        foreach ( tml_get_form_fields( $form ) as $field ) {
            if ( 'hidden' == $field->get_type() ) {
                continue;
            }

            $field->render_args['before'] = '<div class="form-group">';
            $field->render_args['after'] = '</div>';
            if ( 'checkbox' != $field->get_type() ) {
                $field->add_attribute( 'class', 'form-control' );
            } elseif ('submit' != $field->get_type()) {
                $field->add_attribute( 'class', 'btn btn-success' );
            }
        }
    }
}
add_action( 'init', 'make_tml_forms_bootstrap_compatible' );