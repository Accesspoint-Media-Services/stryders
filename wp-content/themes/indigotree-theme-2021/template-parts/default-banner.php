<?php
global $page;
	if ( has_post_thumbnail() ) :
		$banner_id = get_post_thumbnail_id();
	else :
		$default = get_field('default_banner', 'options');
		$banner_id = esc_html($default['ID']);
	endif;
?>
<div class="banner <?php echo $args['class'] ?: ''; ?>">
	<div class="banner__content">
		<div class="banner__title">
			<h1><?php echo $args['title'] ?: ''; ?></h1>
		</div>
	</div>
    <?php 
    if ($banner_id) :
        echo wp_get_attachment_image($banner_id, 'full');
    endif;
    ?>
</div>