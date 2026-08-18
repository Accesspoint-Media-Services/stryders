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

<div class="beige-background">
	<div class="container">
		<?php
			$post = get_post(29);
			$content = apply_filters('the_content', $post->post_content);
			echo $content;
		?>
	</div>
</div>

<div class="container">
	<?php
	if (!empty($sticky)) :
		$sticky_post = get_post($sticky[0]);
	?>
		<div class="row cards m--b-sm featured-post">
			<div class="column column--sm-12">
				<a href="<?php the_permalink(); ?>" class="card insight-card">
					<div class="card__media">
						<?php if (has_post_thumbnail()) : ?>
							<?php the_post_thumbnail('card-thumb'); ?>
						<?php else :
							$default = get_field('default_banner', 'options');
							$banner_id = esc_html($default['ID']);
							echo wp_get_attachment_image($banner_id, 'full');
						endif; ?>
					</div>
					<div class="card__overlay">
						<div class="card__inner">
							<div class="card__header">
								<h2 class="card__title"><?php echo esc_html( $sticky_post->post_title ); ?></h2>
							</div>
							<span class="card__meta">
								<?= get_the_author(); ?>
							</span>
						</div>
					</div>
				</a>
			</div>
		</div>
	<?php
		wp_reset_postdata();
	endif;

	?>

	<h3 class="underline center-text outfit-font primary-color">Latest Insights</h3>

	<?php

	$args = array(
		'ignore_sticky_posts' => 1,
	);
	$the_query = new WP_Query($args);

	if ($the_query->have_posts()) : ?>

		<div class="row cards m--b-sm">
			<?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
				<?php get_template_part('template-parts/insight-card'); ?>
			<?php endwhile; ?>
		</div>

		<?php origin_archive_pagination(); ?>

		<?php wp_reset_postdata(); ?>
	<?php else : ?>

		<p>Sorry, no items matched your criteria.</p>

	<?php endif; ?>

</div>

<?php get_footer();
