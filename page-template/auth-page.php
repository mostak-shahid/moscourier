<?php /*Template Name: Gallery Page Template*/ ?>
<?php 
global $moscourier_options;
$from_theme_option = $moscourier_options['general-page-sections'];
$from_page_option = get_post_meta( get_the_ID(), '_moscourier_page_section_layout', true );
$sections = (@$from_page_option['Enabled'])?$from_page_option['Enabled']:$from_theme_option['Enabled'];
unset($sections['content']);
get_header();
$class = @$moscourier_options['sections-content-class'];
$page_details = array( 'id' => get_the_ID(), 'template_file' => basename( get_page_template() ));
do_action( 'action_avobe_content', $page_details ); 
?>
<section id="page" class="page-content <?php if(@$moscourier_options['sections-content-background-type'] == 1) echo @$moscourier_options['sections-content-background'] . ' ';?><?php if(@$moscourier_options['sections-content-color-type'] == 1) echo @$moscourier_options['sections-content-color'];?> <?php echo $class ?>">
	<div class="content-wrap">
		<div class="container">
			<div class="auth-wrapper">	
				<div class="row">
					<div class="col-lg-6">
						<div class="text-wrapper">
							<div class="welcome">Welcome to</div>
							<div class="company-name"><?php echo get_bloginfo('name'); ?></div>							
							
						</div>
						<?php 
						$atts = 'class="img-wrapper"';
						echo do_shortcode("[feature-image wrapper_element='div' wrapper_atts='".$atts."' height='' width='']");
						?>
					</div>
					<div class="col-lg-6">
						<?php if ( have_posts() ) :?>
							<?php while ( have_posts() ) : the_post(); ?>
								<?php get_template_part( 'content', 'page' ) ?>
							<?php endwhile;?>	
						<?php endif;?>						
					</div>
				</div>
			</div>

		</div>	
	</div>
</section>
<?php do_action( 'action_below_content', $page_details  ); ?>
<?php if($sections ) { foreach ($sections as $key => $value) { get_template_part( 'template-parts/section', $key );}}?>
<?php get_footer() ?>