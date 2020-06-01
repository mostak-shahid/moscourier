<?php 
global $moscourier_options;
$class = @$moscourier_options['sections-footer-class'];
$page_details = array( 'id' => get_the_ID(), 'template_file' => basename( get_page_template() ));
?>
  <?php get_template_part( 'template-parts/section', 'widgets' ); ?>
  <footer id="footer" class="<?php if(@$moscourier_options['sections-footer-background-type'] == 1) echo @$moscourier_options['sections-footer-background'] . ' ';?><?php if(@$moscourier_options['sections-footer-color-type'] == 1) echo @$moscourier_options['sections-footer-color'];?> <?php echo $class ?>">
    <div class="content-wrap">
      <div class="container">
      <?php if (@$moscourier_options['sections-footer-layout']) : ?>
        <?php 
        $my_postid = $moscourier_options['sections-footer-layout'];//This is page id or post id
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
        <?php echo do_shortcode( @$moscourier_options['sections-footer-content'] ); ?>
      <?php endif; ?>
        <div class="row align-items-center">
          <div class="col-md-2 text-center text-md-left"><?php echo do_shortcode('[site-identity]'); ?></div>
          <div class="col-md-8 text-center"><?php echo do_shortcode('[copyright-symbol]')?> 2016 - <?php echo do_shortcode('[this-year]')?> <?php echo do_shortcode('[site-name]')?>. All right reserved. Developed by <a class="theme-credit" href="https://www.mdmostakshahid.me" target="_blank">Md. Mostak Shahid</a></div>
          <!-- <div class="col-md-2 text-center text-md-right">Social Links</div> -->
        </div>
      </div>
    </div>
  </footer>
<?php
if (@$moscourier_options['misc-back-top']) :
    ?>
    <a href="javascript:void(0)" class="scrollup" style="display: none;"><img width="40" height="40" src="<?php echo get_template_directory_uri() ?>/images/icon_top.png" alt="Back To Top"></a>
    <?php 
    endif;
?>
<?php wp_footer(); ?> 
<?php if(@$moscourier_options['basic-background-color']) : ?>
  <style>.theme-bg,.bg-theme {background-color:<?php echo $moscourier_options['basic-background-color'] ?>}svg .bg-theme{fill:<?php echo $moscourier_options['basic-background-color'] ?>}
  </style>
<?php endif; ?>
<?php if (@$moscourier_options['misc-settings-css']) : ?>
  <style>
    <?php echo $moscourier_options['misc-settings-css'] ?>    
  </style>
<?php endif; ?>
<?php if (@$moscourier_options['misc-settings-js']) : ?>
  <script>
    <?php echo $moscourier_options['misc-settings-js'] ?> 
  </script>
<?php endif; ?>
</body>
</html>