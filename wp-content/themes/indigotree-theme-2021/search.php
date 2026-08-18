<?php

get_header(); 

$default = get_field('default_banner', 'options');
$banner_id = esc_html($default['ID']);

$sticky = get_option('sticky_posts');

?>

<div class="banner">
	<div class="banner__content">
		<div class="banner__title">
			<?php the_archive_title('<h1>', '</h1>'); ?>
		</div>
	</div>
	<?php 
	if ($banner_id) :
		echo wp_get_attachment_image($banner_id, 'full');
	endif;
	?>
</div>

<div class="container">
	<?php

	if (have_posts()) : ?>

		<div class="row cards m--b-sm">
			<?php while (have_posts()) : the_post(); ?>
				<?php get_template_part('template-parts/insight-card'); ?>
			<?php endwhile; ?>
		</div>

		<?php origin_archive_pagination(); ?>

	<?php else : ?>

		<p>Sorry, no items matched your criteria.</p>

	<?php endif; ?>

</div>

<?php get_footer();
