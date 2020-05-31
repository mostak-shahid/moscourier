<?php 
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
                var_dump(is_wp_error($result));
                echo $user->get_error_message();
                wp_die('Login failed. Wrong password or user name?');
            }
            // redirect back to the requested page if login was successful    
            header('Location: ' . $_POST['redirect_to']);
            exit;
        }
        if( isset( $_POST['register_user_form_field'] ) && wp_verify_nonce( $_POST['register_user_form_field'], 'register_user_form') ) {
            $user_email = sanitize_text_field( $_POST['email'] );
            $brand_name = sanitize_text_field( $_POST['brand_name'] );
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
global $moscourier_options;
if (is_home()) $page_id = get_option( 'page_for_posts' );
elseif (is_front_page()) $page_id = get_option('page_on_front');
else $page_id = get_the_ID();
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="<?php echo get_post_meta( get_the_ID(),'_yoast_wpseo_focuskw', true ) ?>">
    <meta name="description" content="<?php echo get_post_meta( get_the_ID(),'_yoast_wpseo_metadesc', true ) ?>">
	<meta name="author" content="Md. Mostak Shahid">
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/respond.min.js"></script>
<![endif]-->
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<input id="loader-status" type="hidden" value="<?php echo $moscourier_options['misc-page-loader'] ?>">
<?php if (@$moscourier_options['misc-page-loader']) : ?>
    <div class="se-pre-con">
    <?php if ($moscourier_options['misc-page-loader-image']['url']) : ?>
        <img class="img-responsive animation <?php echo $moscourier_options['misc-page-loader-image-animation'] ?>" src="<?php echo do_shortcode( $moscourier_options['misc-page-loader-image']['url'] ); ?>">
    <?php else : ?>
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
    <?php endif; ?>
    </div>
<?php endif; ?>
<div class="container">
	

	<?php // echo do_shortcode(get_post_field('post_content', '10670')); ?>

	</div>
	<!-- <div id="contact-bar" class="theme-bg">
		<div class="content-wrap">
			<div class="container">
				<div class="text-center"><?php // echo do_shortcode( "[phone all=1 seperator=', ']" ); ?></div>
			</div>
		</div>
	</div> -->
	<?php 
	$header_class=@$moscourier_options['sections-header-class']; 
	$title_class=@$moscourier_options['sections-title-class']; 
	$breadcrumbs_class=@$moscourier_options['sections-breadcrumbs-class']; 
	?>
	<header id="main-header" class="<?php if(@$moscourier_options['sections-header-background-type'] == 1) echo @$moscourier_options['sections-header-background'] . ' ';?><?php if(@$moscourier_options['sections-header-color-type'] == 1) echo @$moscourier_options['sections-header-color'];?> <?php echo $header_class?>">
		<div class="content-wrap">
			<div class="container">
			<?php if (@$moscourier_options['sections-header-layout']) : ?>
				<?php 
				$my_postid = $moscourier_options['sections-header-layout'];//This is page id or post id
				// echo do_shortcode(get_post_field('post_content', '10670'));
				$shortcodes_custom_css = get_post_meta( $my_postid, '_wpb_shortcodes_custom_css', true );
				if ( ! empty( $shortcodes_custom_css ) ) {
				    $shortcodes_custom_css = strip_tags( $shortcodes_custom_css );
				    echo '<style type="text/css" data-type="vc_shortcodes-custom-css">';
				    echo $shortcodes_custom_css;
				    echo '</style>';
				}
				$content_post = get_post($my_postid);
				$content = $content_post->post_content;
				$content = apply_filters('the_content', $content);
				$content = str_replace(']]>', ']]&gt;', $content);
				echo $content;
				?>
			<?php else : ?>
				<nav class="navbar navbar-expand-md navbar-light navbar-custom-bg">			
					<a class="navbar-brand" href="<?php echo home_url(); ?>">
						<span class="<?php if($moscourier_options['logo']['id']) echo 'd-md-none';?>">
						<?php if (has_site_icon()) : ?>
							<img class="img-responsive img-fluid" src="<?php echo get_site_icon_url(32)?>" width="32" height="32" alt="<?php echo bloginfo( 'name' ); ?> - Logo">
						<?php else : ?>
							<?php echo bloginfo( 'name' ); ?>
						<?php endif; ?>
						</span>
						<?php if(@$moscourier_options['logo']['id']) : ?>
							<span class="d-none d-md-inline-block">
								<img class="img-responsive img-fluid" src="<?php echo $moscourier_options['logo']['url']?>" width="<?php echo $moscourier_options['logo']['width']?>" height="<?php echo $moscourier_options['logo']['height']?>" alt="<?php echo bloginfo( 'name' ); ?> - Logo">
							</span>
						<?php endif ?>
					</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar" aria-controls="collapsibleNavbar" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<?php
					wp_nav_menu([
						'menu'            => 'mainmenu',
						'theme_location'  => 'mainmenu',
						'container'       => 'div',
						'container_id'    => 'collapsibleNavbar',
						'container_class' => 'collapse navbar-collapse',
						'menu_id'         => false,
						'menu_class'      => 'navbar-nav ml-auto',
						'depth'           => 2,
						'fallback_cb'     => 'bs4navwalker::fallback',
						//'walker'          => new bs4navwalker()
						]);
					?>
				</nav>	
			<?php endif; ?>			
			</div>
		</div>
	</header>
	<?php if (get_post_meta($page_id, '_moscourier_banner_enable', true ) OR is_404()) : ?>
		<?php 
		$banner_img = get_post_meta( get_the_ID(), '_moscourier_banner_cover', true ); 
		$banner_mp4 = get_post_meta( get_the_ID(), '_moscourier_banner_mp4', true ); 
		$banner_webm = get_post_meta( get_the_ID(), '_moscourier_banner_webm', true ); 
		$banner_shortcode = get_post_meta( get_the_ID(), '_moscourier_banner_shortcode', true ); 
		?>
		<section id="page-title" class="<?php if(@$moscourier_options['sections-title-background-type'] == 1) echo @$moscourier_options['sections-title-background'] . ' ';?><?php if(@$moscourier_options['sections-title-color-type'] == 1) echo @$moscourier_options['sections-title-color'];?> <?php echo $title_class ?>">
			<?php if ($banner_shortcode) : ?>
				<div class="shortcode-output"><?php echo do_shortcode( $banner_shortcode ); ?></div>
			<?php elseif ($banner_mp4 OR $banner_webm) : ?>
				<div class="video-output">
					<video id="banner-video" autoplay loop muted playsinline <?php if ($banner_img) : ?> style="background-image:url(<?php echo $banner_img ?>)" <?php endif; ?>>
					<?php if($banner_mp4) : ?>
						<source src="<?php echo $banner_mp4 ?>">
					<?php endif; ?>
					<?php if($banner_webm) : ?>
						<source src="<?php echo $banner_webm ?>">
					<?php endif; ?>
					</video>					
				</div>
			<?php endif; ?>
			<div class="content-wrap">
				<div class="container">
					<?php 
					if (is_home()) :
						$page_for_posts = get_option( 'page_for_posts' );
					$title = get_the_title($page_for_posts);
					elseif (is_404()) :
						$title = '404 Page';
					else :
						$title = get_the_title();
					endif; 
					?>
					<span class="heading"><?php echo $title ?></span>
				</div>
			</div>
		</section>
	<?php endif ?>
	<?php if (get_post_meta($page_id, '_moscourier_breadcrumb_enable', true )) : ?>
		<section id="section-breadcrumbs" class="<?php if(@$moscourier_options['sections-breadcrumbs-background-type'] == 1) echo @$moscourier_options['sections-breadcrumbs-background'] . ' ';?><?php if(@$moscourier_options['sections-breadcrumbs-color-type'] == 1) echo @$moscourier_options['sections-breadcrumbs-color'];?> <?php echo $breadcrumbs_class ?>">
			<div class="content-wrap">
				<div class="container">
					<?php mos_breadcrumbs(); ?>
				</div>
			</div>
		</section>
	<?php endif; ?>