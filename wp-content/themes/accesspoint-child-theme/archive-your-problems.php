<?php

get_header();

$default = get_field('default_banner', 'options');
$banner_id = esc_html($default['ID']);

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

<div class="beige-background">
	<div class="container">
		<?php $page = origin_get_archive_page('your-problems');
			$post = get_post($page->ID);
			$content = apply_filters('the_content', $post->post_content);
			echo $content;
		?>
</div>

<div class="container your-problems">
	<?php

	if (!is_singular()) :
		the_archive_description();
	endif;

	if (have_posts()) : ?>

		<div class="row problem-list">
			<h3 class="underline underline-left">What are you facing?</h3>
			<ul>
			<?php while (have_posts()) : the_post(); ?>
				<li>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</li>
			<?php endwhile; ?>
			</ul>
		</div>

		<?php origin_archive_pagination(); ?>

	<?php else : ?>

		<p>Sorry, no items matched your criteria.</p>

	<?php endif; ?>

</div>

<?php get_footer();
