<?php
//get latest insights
$args = array(
  'numberposts' => 3,
  'post_type'   => 'post',
  'no_found_rows' => true
);
$insights = get_posts( $args );

$the_title = get_field('insights_title');
?>
<div class="latest-insights">
	<?php
	if ($the_title) :
	?>
	<div class="latest-insights__header">
		<h2 class="underline"><?= esc_html($the_title); ?></h2>
	</div>
	<?php
	endif;
	?>
	<div class="latest-insights__row">
	<?php
	if ($insights) :
		foreach ( $insights as $insight ) :
			setup_postdata( $insight );
	?>
	<div class="insight">
		<div class="insight__media">
			<?php if (has_post_thumbnail($insight->ID)) : ?>
				<?= get_the_post_thumbnail($insight->ID, 'large'); ?>
			<?php else :
				$default = get_field('default_banner', 'options');
				$banner_id = esc_html($default['ID']);
				echo wp_get_attachment_image($banner_id, 'full');
			endif; ?>
			<span class="insight__media--date"><?= get_the_date('M Y', $insight->ID); ?></span>
		</div>
		<div class="insight__content">
			<h3><?= esc_html($insight->post_title); ?></h3>
			<?= esc_html( excerpt('30', $insight->ID) ); ?>
		</div>
		<div class="insight__footer">
			<a href="<?= esc_url( get_permalink( $insight->ID ) ); ?>" class="button button--primary">Read More</a>
		</div>
	</div>
	<?php
		endforeach;
		wp_reset_postdata();
	endif; ?>
	</div>
	<div class="latest-insights__footer">
		<a href="/legal-insights" class="button button--secondary">View all legal insights</a>
	</div>
</div>