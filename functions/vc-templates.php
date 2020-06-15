<?php
/*for more details
https://kb.wpbakery.com/docs/inner-api/vc_map/
https://github.com/proteusthemes/visual-composer-elements
*/
/*
function bartag_func( $atts = array(), $content = '' ) {
	$atts = shortcode_atts( array(
		'foo' => 'something',
		'color' => '#FFF'
	), $atts, 'bartag' );	
	return '<div style="color:'.$atts['color'].'" data-foo="'.$atts['foo'].'">'.$content.'</div>';
}
add_shortcode( 'bartag', 'bartag_func' );
add_action( 'vc_before_init', 'your_name_integrateWithVC' );
function your_name_integrateWithVC() {
	vc_map( array(
		"name" => __( "Bar tag test", "my-text-domain" ),
		"base" => 'bartag',
		"class" => "",
		"category" => __( "Content", "my-text-domain"),
		// 'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
		// 'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
		'icon'     => get_template_directory_uri() . '/images/mos-vc.png',
				
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Text", "my-text-domain" ),
				"param_name" => "foo",
				"value" => __( "Default param value", "my-text-domain" ),
				"description" => __( "Description for foo param.", "my-text-domain" )
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __( "Text color", "my-text-domain" ),
				"param_name" => "color",
				"value" => '#FF0000', //Default Red color
				"description" => __( "Choose text color", "my-text-domain" )
			),
			array(
				"type" => "textarea_html",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Content", "my-text-domain" ),
				"param_name" => "content", // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
				"value" => __( "<p>I am test text block. Click edit button to change this text.</p>", "my-text-domain" ),
				"description" => __( "Enter your content.", "my-text-domain" )
			),
            // Design Options
            array(
	            'type' => 'css_editor',
	            'heading' => __( 'Css' ),
	            'param_name' => 'css',
	            'group' => __( 'Design Options' ),
            )
		)
	));
}
*/
function navigation_func( $atts = array(), $content = '' ) {
	global $moscourier_options;
	$atts = shortcode_atts( array(
	    'menu_name'        	=> '',
		'nav_class'			=> '',
	    'container'         => 'div',
	    'container_class'   => 'collapse navbar-collapse',
	    'menu_class'        => 'navbar-nav ml-auto',
	    'menu_type'        => 'bootstrap',
	    'logo'        => 'yes',
	), $atts, 'navigation' );
	$html = '';
	if ($atts['menu_name']) :
				$html .= '<nav class="navbar navbar-expand-md navbar-light '.$atts['nav_class'].'">';	
				if ($atts['logo'] == 'yes') :

					$html .= '<a class="navbar-brand" href="'.home_url().'">';
					if($moscourier_options['logo']['url']) :
						$html .= '<img class="img-responsive img-fluid" src="'.$moscourier_options['logo']['url'].'" width="'.$moscourier_options['logo']['width'].'" height="'.$moscourier_options['logo']['height'].'" alt="'.get_bloginfo( 'name' ).' - Logo">';
					endif;
					$html .= '</a>';
				endif;
					$html .= '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar" aria-controls="collapsibleNavbar" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>';
					
					$html .= wp_nav_menu([
						'menu'            => $atts['menu_name'],
						'container'       => $atts['container'],
						'container_class' => $atts['container_class'],
						'menu_class'      => $atts['menu_class'],
						'depth'           => 2,
						'fallback_cb'     => 'bs4navwalker::fallback',
						'echo'			  => false,
						'walker'          => ($atts['menu_type'] == 'bootstrap')?new bs4navwalker():'',
					]);					
				$html .= '</nav>';
	endif;				
	return $html;	
}
add_shortcode( 'navigation', 'navigation_func' );
add_action( 'vc_before_init', 'navigationVC' );
function navigationVC() {
	vc_map( array(
		"name" => __( "Mos Navigation", "my-text-domain" ),
		"base" => 'navigation',
		"class" => "",
		"category" => __( "Content", "my-text-domain"),
		// 'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
		// 'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
		'icon'     => get_template_directory_uri() . '/images/mos-vc.png',
				
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",				
				"admin_label" => false,
				"heading" => __( "Nav Name", "my-text-domain" ),
				"param_name" => "menu_name",
				"value" => __( "", "my-text-domain" ),
			),
			array(
				"type" => "textfield",			
				"admin_label" => false,
				"heading" => __( "Nav Class", "my-text-domain" ),
				"param_name" => "nav_class",
				"value" => __( "", "my-text-domain" ),
				"description" => __( "You can add background color class.", "my-text-domain" )
			),
			array(
				"type" => "textfield",			
				"admin_label" => false,
				"heading" => __( "Container Element", "my-text-domain" ),
				"param_name" => "container",
				"value" => __( "div", "my-text-domain" ),
				"description" => __( "You can add div, nav etc or 0.", "my-text-domain" )
			),
			array(
				"type" => "textfield",			
				"admin_label" => false,
				"heading" => __( "Container Class", "my-text-domain" ),
				"param_name" => "container_class",
				"value" => __( "collapse navbar-collapse", "my-text-domain" ),
				"description" => __( "You can add any class.", "my-text-domain" )
			),
			array(
				"type" => "textfield",				
				"admin_label" => false,
				"heading" => __( "Menu Class", "my-text-domain" ),
				"param_name" => "menu_class",
				"value" => __( "collapse navbar-collapse", "my-text-domain" ),
				"description" => __( "You can add any class.", "my-text-domain" )
			),
			array(
				"type" => "dropdown",
				"edit_field_class" => "vc_col-xs-6",
				"heading" => __( "Menu Type", "my-text-domain" ),
				"param_name" => "menu_type",	
				"value" => array( 
					'Bootstrap' => 'bootstrap',
					'Default' => 'default', 
				)
			),
			array(
				"type" => "dropdown",
				"edit_field_class" => "vc_col-xs-6",
				"heading" => __( "Enable Logo", "my-text-domain" ),
				"param_name" => "logo",	
				"value" => array( 
					'Yes' => 'yes',
					'No' => 'no', 
				)
			),
            // Design Options
            array(
	            'type' => 'css_editor',
	            'heading' => __( 'Css' ),
	            'param_name' => 'css',
	            'group' => __( 'Design Options' ),
            )
		)
	));
}

function login_form_func( $atts = array(), $content = '' ) {
	$html = '';
	$atts = shortcode_atts( array(
		'registration_url' => '',
		'lostpass_url' => '',
	), $atts, 'login-form' );
	$registration_url = $atts['registration_url'];
	if ($registration_url){
		if (is_array(vc_build_link($registration_url))) $output_registration_url = vc_build_link($atts['registration_url'])["url"];
		else $output_registration_url = wp_registration_url();
	} else $output_registration_url = wp_registration_url();
	$lostpass_url = $atts['lostpass_url'];
	if ($lostpass_url){
		if (is_array(vc_build_link($lostpass_url))) $output_lostpass_url = vc_build_link($atts['lostpass_url'])["url"];
		else $output_lostpass_url = wp_login_url().'?action=lostpassword';
	} else $output_lostpass_url = wp_login_url().'?action=lostpassword';
	$html .= '<div class="mos mos-login">
		<form action="" method="POST" class="needs-validation" novalidate>'.wp_nonce_field( 'login_user_form', 'login_user_form_field' ).'
			<div class="form-group">
				<label class="login-form-label">Email Address</label>
				<input type="email" class="form-control" name="log" placeholder="Email" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
			</div>
			<div class="form-group">
				<label class="login-form-label">Password</label>
				<input type="password" class="form-control" name="pwd" placeholder="Password" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
			</div>
			<div class="form-group">
				<div class="custom-control custom-checkbox mr-sm-2">
					<input name="rememberme" type="checkbox" class="custom-control-input" id="remember-me">
					<label class="custom-control-label" for="remember-me"> Remember Me</label>
				</div>
			</div>
			<button name="wp-submit" type="submit" class="btn btn-primary btn-login" value="Log In">Login</button>
			<input type="hidden" name="redirect_to" value="'.home_url().'/admin/">
			<input type="hidden" name="testcookie" value="1">
		</form>
		<p id="nav">
			<a href="'.$output_registration_url.'">Register</a> | <a href="'.$output_lostpass_url.'">Lost your password?</a>
		</p>
	</div>';
	return $html;
}
add_shortcode( 'login-form', 'login_form_func' );

add_action( 'vc_before_init', 'loginFormVC' );
function loginFormVC() {
	vc_map( array(
		"name" => __( "Login Form", "my-text-domain" ),
		"base" => 'login-form',
		"class" => "",
		"category" => __( "Content", "my-text-domain"),
		// 'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
		// 'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
		'icon'     => get_template_directory_uri() . '/images/mos-vc.png',
				
		"params" => array(
			array(
				"type" => "vc_link",
				"heading" => __( "Registration URL", "my-text-domain" ),
				"param_name" => "registration_url",
				"value" => __( "", "my-text-domain" )
			),
			array(
				"type" => "vc_link",
				"heading" => __( "Lost password URL", "my-text-domain" ),
				"param_name" => "lostpass_url",
				"value" => __( "", "my-text-domain" )
			),
		)
	));
}
function registration_form_func( $atts = array(), $content = '' ) {
	$html = '';
	$atts = shortcode_atts( array(
		'login_url' => '',
		'lostpass_url' => '',
	), $atts, 'registration-form' );
	$login_url = $atts['login_url'];
	if ($login_url){
		if (is_array(vc_build_link($login_url))) $output_login_url = vc_build_link($atts['login_url'])["url"];
		else $output_login_url = wp_login_url();
	} else $output_login_url = wp_login_url();
	$lostpass_url = $atts['lostpass_url'];
	if ($lostpass_url){
		if (is_array(vc_build_link($lostpass_url))) $output_lostpass_url = vc_build_link($atts['lostpass_url'])["url"];
		else $output_lostpass_url = wp_login_url().'?action=lostpassword';
	} else $output_lostpass_url = wp_login_url().'?action=lostpassword';
	$html .= '<div class="mos mos-login">
		<form action="" method="POST" class="needs-validation" novalidate>'.wp_nonce_field( 'register_user_form', 'register_user_form_field' ).'
			<input type="hidden" name="login-url" value="'.$output_login_url.'">
			<div class="form-row">
				<div class="col-lg-6">										
					<div class="form-group">
						<label for="brand_name">Brand Name</label>
						<input type="text" class="form-control" name="brand_name" placeholder="Brand Name" required>
						<div class="valid-feedback">Valid.</div>
						<div class="invalid-feedback">Please fill out this field.</div>
					</div>	
				</div>
				<div class="col-lg-6">		
					<div class="form-group">
						<label for="phone">Contact No.</label>
						<input type="text" class="form-control mb-2" name="phone" placeholder="Phone" required>
						<div class="valid-feedback">Valid.</div>
						<div class="invalid-feedback">Please fill out this field.</div>
					</div>
				</div>
			</div>
			<div class="form-row">
				<div class="col-lg-6">
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" name="email" placeholder="Email" required>
						<div class="valid-feedback">Valid.</div>
						<div class="invalid-feedback">Please fill out this field.</div>
					</div>								
				</div>
				<div class="col-lg-6">										
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" name="password" placeholder="Password" required>
						<div class="valid-feedback">Valid.</div>
						<div class="invalid-feedback">Please fill out this field.</div>
					</div>
				</div>
			</div>
			<div class="form-group form-check">
				<label class="form-check-label">
					<input class="form-check-input" type="checkbox" name="agree" required> I agree with the terms &amp; conditions.
					<div class="valid-feedback">Valid.</div>
					<div class="invalid-feedback">Check this checkbox to continue.</div>
				</label>
			</div>
			<button type="submit" class="btn btn-primary">Register</button>
		</form>
		<p id="nav">
			<a href="'.$output_login_url.'">Log in</a> | <a href="'.$output_lostpass_url.'">Lost your password?</a>
		</p>
	</div>';
	return $html;
}
add_shortcode( 'registration-form', 'registration_form_func' );

add_action( 'vc_before_init', 'registrationFormVC' );
function registrationFormVC() {
	vc_map( array(
		"name" => __( "Register Form", "my-text-domain" ),
		"base" => 'registration-form',
		"class" => "",
		"category" => __( "Content", "my-text-domain"),
		// 'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
		// 'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
		'icon'     => get_template_directory_uri() . '/images/mos-vc.png',
				
		"params" => array(
			array(
				"type" => "vc_link",
				"heading" => __( "Login URL", "my-text-domain" ),
				"param_name" => "login_url",
				"value" => __( "", "my-text-domain" )
			),
			array(
				"type" => "vc_link",
				"heading" => __( "Lost password URL", "my-text-domain" ),
				"param_name" => "lostpass_url",
				"value" => __( "", "my-text-domain" )
			),
		)
	));
}
function mos_textbox_func( $atts = array(), $content = '' ) {
	$css_class = $html ='';
	$atts = shortcode_atts( array(
		'image' => '',
		'title' => '',
		'title-tag' => 'h3',
		'animation' => '',
		'class-name' => '',
		'css' => '',
	), $atts, 'mos-textbox' );	
	// var_dump($atts['animation']);
	if (@$atts['animation']){
		// Build the animation classes
	    // $css_class .= $this->getCSSAnimation( $atts['animation'] );
	    $css_class .=  ' wpb_animate_when_almost_visible wpb_'.$atts['animation'].' '.$atts['animation'];
	}
	if (@$atts['css']){
		$data = explode('{', $atts['css']);	
		$css_class .= ' '.str_replace(".", "", $data[0]);
	}
	if (@$atts['class-name']){
		$css_class .= ' '.$atts['class-name'];
	}
	$html .= '<div class="mos-textbox-wrapper'.$css_class.'">';
		if(@$atts['image']) $html .= '<div class="image-wrapper"><img class="img-fluid img-mos-text-box w-100" src="'.wp_get_attachment_url($atts['image']).'"></div>';
		if(@$atts['title']) $html .= '<div class="title-wrapper"><'.$atts['title-tag'].'>'.$atts['title'].'</'.$atts['title-tag'].'></div>';
		$html .= '<div class="content-wrapper">'.$content.'</div>';
	$html .= '</div>';
	return $html;
}
add_shortcode( 'mos-textbox', 'mos_textbox_func' );
add_action( 'vc_before_init', 'mosTextBoxVC' );
function mosTextBoxVC() {
	vc_map( array(
		"name" => __( "Mos textbox", "my-text-domain" ),
		"base" => 'mos-textbox',
		"class" => "",
		"category" => __( "Content", "my-text-domain"),
		// 'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
		// 'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
		'icon'     => get_template_directory_uri() . '/images/mos-vc.png',
				
		"params" => array(
			array(
				"type" => "attach_image",							
				"heading" => __( "Image", "my-text-domain" ),
				"param_name" => "image"
			),
			array(
				"type" => "textarea",			
				"edit_field_class" => "vc_col-xs-6",				
				"heading" => __( "Title", "my-text-domain" ),
				"param_name" => "title",				
				"admin_label" => true
			),
			array(
				"type" => "dropdown",
				"edit_field_class" => "vc_col-xs-6",
				"heading" => __( "Title HTML Tag", "my-text-domain" ),
				"param_name" => "title-tag",	
				"value" => array( 
					'H1' => 'h1', 
					'H2' => 'h2', 
					'H3' => 'h3', 
					'H4' => 'h4',
					'H5' => 'h5',
					'H6' => 'h6',
				),
				"std" => 'h3',
				// "value" => __( "Default param value", "my-text-domain" ),
				// "description" => __( "Description for foo param.", "my-text-domain" )
			),
			array(
				"type" => "textarea_html",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Content", "my-text-domain" ),
				"param_name" => "content", // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
				// "value" => __( "<p>I am test text block. Click edit button to change this text.</p>", "my-text-domain" ),
				"description" => __( "Enter your content.", "my-text-domain" )
			), 
            array(
                'type' => 'animation_style',
                'heading' => __( 'CSS Animation', 'text-domain' ),
                'param_name' => 'animation',
                'description' => __( 'Select type of animation for element to be animated when it "enters" the browsers viewport (Note: works only in modern browsers).', 'text-domain' ),
                'admin_label' => false,
                'weight' => 0,
                // 'group' => 'Custom Group',
            ),
			array(
				"type" => "textfield",							
				"heading" => __( "Extra class name", "my-text-domain" ),
				"param_name" => "class-name",
				//"value" => __( "Default param value", "my-text-domain" ),
				"description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "my-text-domain" )
			),
            // Design Options
            array(
	            'type' => 'css_editor',
	            'heading' => __( 'Css' ),
	            'param_name' => 'css',
	            'group' => __( 'Design Options' ),
            )
		)
	));
}
function mos_map_func( $atts = array(), $content = '' ) {
	$html = '';
	$atts = shortcode_atts( array(
		'url' => '',
	), $atts, 'mos-map' );	
	$html .= '<div class="embed-responsive embed-responsive-21by9">';
		$html .= '<iframe class="embed-responsive-item" src="'.$atts['url'].'"></iframe>';
	$html .= '</div>';
	return $html;
}
add_shortcode( 'mos-map', 'mos_map_func' );
add_action( 'vc_before_init', 'mos_map_vc' );
function mos_map_vc() {
	vc_map( array(
		"name" => __( "Mos Map", "my-text-domain" ),
		"base" => "mos-map",
		"class" => "",
		"category" => __( "Content", "my-text-domain"),
		'icon'     => get_template_directory_uri() . '/images/mos-vc.png',
				
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => __( "MAP URL", "my-text-domain" ),
				"admin_label" => false,
				"param_name" => "url",
				"description" => __( "Embed Map URL of Google MAP.", "my-text-domain" )
			),
		)
	));
}

function mos_counter_func( $atts = array(), $content = '' ) {
	$html = '';
	$atts = shortcode_atts( array(
		'image' => '',
		'number' => 0,
		'icon' => '+',
		'text' => '',
		'link' => '',
		'animation' => '',
		'class-name' => '',
		'css' => '',
	), $atts, 'mos-counter' );
	if (@$atts['animation']){
	    $css_class .=  ' wpb_animate_when_almost_visible wpb_'.$atts['animation'].' '.$atts['animation'];
	}
	if (@$atts['css']){
		$data = explode('{', $atts['css']);	
		$css_class .= ' '.str_replace(".", "", $data[0]);
	}
	if (@$atts['class-name']){
		$css_class .= ' '.$atts['class-name'];
	}	
	$html .= '<div class="card mos-counter-unit'.$css_class.'">';
	if (@$atts['image']){
		$html .= '<img src="'.wp_get_attachment_url( $atts['image'] ).'" class="card-img-top rounded-0" alt="'.$atts['text'].'">';
	}
		$html .= '<div class="card-body">';
		if (@$atts['number']){
			$html .= '<h5 class="card-title"><span class="counter">'.$atts['number'].'</span>'.$atts['icon'].'</h5>';
		}
		if (@$atts['text']){
			$html .= '<div class="card-text">'.$atts['text'].'</div>';
		}
		$html .= '</div>';

	if (@$atts['link']){
		$link = $atts['link'];
		if (is_array(vc_build_link($link))) $link = vc_build_link($atts['link'])["url"];
		$html .= '<a class="hidden-link" href="'.$link.'">Read More</a>';
	}
	$html .= '</div>';
	return $html;
}
add_shortcode( 'mos-counter', 'mos_counter_func' );
add_action( 'vc_before_init', 'mos_counter_vc' );
function mos_counter_vc() {
	vc_map( array(
		"name" => __( "Mos Counter", "my-text-domain" ),
		"base" => "mos-counter",
		"class" => "",
		"category" => __( "Content", "my-text-domain"),
		// 'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
		// 'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
		'icon'     => get_template_directory_uri() . '/images/mos-vc.png',
				
		"params" => array(
			array(
				"type" => "textfield",
				"admin_label" => true,
				"heading" => __( "Text", "my-text-domain" ),
				"param_name" => "text",
			),
			array(
				"type" => "attach_image",
				"heading" => __( "Image", "my-text-domain" ),
				"param_name" => "image",
			),
			array(
				"type" => "textfield",
				"admin_label" => true,
				"class" => "mos-count-vc-number",
				"heading" => __( "Number", "my-text-domain" ),
				"param_name" => "number",
				"value" => 0,
			),
			array(
				"type" => "textfield",
				"admin_label" => true,
				"class" => "mos-count-vc-icon",
				"heading" => __( "Number", "my-text-domain" ),
				"param_name" => "icon",
				"value" => '+',
			),
			array(
				"type" => "vc_link",
				"admin_label" => false,
				"class" => "mos-count-vc-link",
				"heading" => __( "Link", "my-text-domain" ),
				"param_name" => "link",
			), 
            array(
                'type' => 'animation_style',
                'heading' => __( 'CSS Animation', 'text-domain' ),
                'param_name' => 'animation',
                'description' => __( 'Select type of animation for element to be animated when it "enters" the browsers viewport (Note: works only in modern browsers).', 'text-domain' ),
                'admin_label' => false,
                'weight' => 0,
                // 'group' => 'Custom Group',
            ),
			array(
				"type" => "textfield",							
				"heading" => __( "Extra class name", "my-text-domain" ),
				"param_name" => "class-name",
				//"value" => __( "Default param value", "my-text-domain" ),
				"description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "my-text-domain" )
			),
            // Design Options
            array(
	            'type' => 'css_editor',
	            'heading' => __( 'Css' ),
	            'param_name' => 'css',
	            'group' => __( 'Design Options' ),
            )
		)
	));
}
/*Custom components*/
// Create multi dropdown param type
vc_add_shortcode_param( 'dropdown_multi', 'dropdown_multi_settings_field' );
function dropdown_multi_settings_field( $param, $value ) {
   $param_line = '';
   $param_line .= '<select multiple name="'. esc_attr( $param['param_name'] ).'" class="select2 wpb_vc_param_value wpb-input wpb-select '. esc_attr( $param['param_name'] ).' '. esc_attr($param['type']).'">';
   foreach ( $param['value'] as $text_val => $val ) {
       if ( is_numeric($text_val) && (is_string($val) || is_numeric($val)) ) {
                    $text_val = $val;
                }
                $text_val = __($text_val, "js_composer");
                $selected = '';

                if(!is_array($value)) {
                    $param_value_arr = explode(',',$value);
                } else {
                    $param_value_arr = $value;
                }

                if (@$value!=='' && in_array($val, $param_value_arr)) {
                    $selected = ' selected="selected"';
                }
                $param_line .= '<option class="'.$val.'" value="'.$val.'"'.$selected.'>'.$text_val.'</option>';
            }
   $param_line .= '</select>';

   return  $param_line;
}
/*Custom components*/
?>