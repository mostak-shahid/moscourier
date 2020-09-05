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
if ( is_plugin_active( 'theme-my-login/theme-my-login.php' ) ) {
    function make_tml_forms_bootstrap_compatible() {
        foreach ( tml_get_forms() as $form ) {
            foreach ( tml_get_form_fields( $form ) as $field ) {
                if ( 'hidden' == $field->get_type() ) {
                    continue;
                }

                $field->render_args['before'] = '<div class="form-group">';
                $field->render_args['after'] = '</div>';
                if ('submit' == $field->get_type()) {
                    $field->add_attribute( 'class', 'btn btn-success' );
                }
                elseif ( 'checkbox' != $field->get_type() ) {
                    $field->add_attribute( 'class', 'form-control' );
                } 
            }
        }
    }
    add_action( 'init', 'make_tml_forms_bootstrap_compatible' );
}

add_action( 'after_setup_theme', 'register_form_submission_func' );
function register_form_submission_func(){
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        /*foreach ($_POST as $field => $value) {
            echo "$"."_POST['"."$field"."']"." == '$value'<br>";
        }
        die();*/
        if( isset( $_POST['login_user_form_field'] ) && wp_verify_nonce( $_POST['login_user_form_field'], 'login_user_form') ) {
            /*var_dump($_POST);
            die();*/

            $creds = array(
                'user_login'    => $_POST['log'],
                'user_password' => $_POST['pwd'],
                'remember'      => true
            );
            $result = wp_signon( $creds, false );

            if(is_wp_error($result)) {
                // var_dump(is_wp_error($result));
                // echo $user->get_error_message();
                wp_die('Login failed. Wrong password or user name?');
            }
            // redirect back to the requested page if login was successful    
            header('Location: ' . $_POST['redirect_to']);
            exit;


        }
        if( isset( $_POST['register_user_form_field'] ) && wp_verify_nonce( $_POST['register_user_form_field'], 'register_user_form') ) {
            $user_email = sanitize_text_field( $_POST['email'] );
            $brand_name = sanitize_text_field( $_POST['brand_name'] );
            $phone = sanitize_text_field( $_POST['phone'] );
            $login_url = sanitize_text_field( $_POST['login-url'] );
            $password = $_POST['password'];
            $user_id = username_exists( $user_email );           
            if ( ! $user_id && false == email_exists( $user_email ) ) {
                // $random_password = wp_generate_password( $length = 12, $include_standard_special_chars = false );
                // $user_id = wp_create_user( $user_name, $random_password, $user_email );
                $user_id = wp_create_user( $user_email, $password, $user_email );
                update_user_meta( $user_id, 'brand_name', $brand_name );
                update_user_meta( $user_id, 'phone', $phone );
                update_user_meta( $user_id, 'user_role', 'Regular' );
                update_user_meta( $user_id, 'activation', 'Deactive' );
                $u = new WP_User( $user_id );
                $u->remove_role( 'subscriber' );
                $u->add_role( 'merchant' );         
                wp_redirect( $login_url );
                exit;
            }
        }
    }
}