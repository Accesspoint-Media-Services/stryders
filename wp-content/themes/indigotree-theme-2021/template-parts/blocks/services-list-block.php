<?php
//get problems list
$args = array(
  'numberposts' => 10,
  'post_type'   => 'your-problems',
  'no_found_rows' => true
);
$problems = get_posts( $args );

$left_col_title = get_field('first_col_title');
$left_col_items = get_field('first_col_items');
$servicesblock_image = get_field('servicesblock_image');
$wrapper_class = $servicesblock_image ? '' : ' no-image';
?>
<div class="services-block container">
	<div class="services-block__wrapper<?=  esc_attr($wrapper_class); ?>">
		<div class="services-block__left">
			<h3 class="underline underline-left"><?= $left_col_title ?: esc_html($left_col_title); ?></h3>
			<?php
			if ($left_col_items) :
			?>
			<ul>
			<?php
				foreach ($left_col_items as $col_item) :
					if (isset($col_item['first_col_item']['url'])) :
				?>
				<li><a href="<?= esc_url($col_item['first_col_item']['url']); ?>"><?= esc_html($col_item['first_col_item']['title']); ?></a></li>
				<?php
					endif;
				endforeach;
			?>
			</ul>
			<?php
			endif;
			?>
		</div>
		<div class="services-block__right">
			<h3 class="underline underline-left">What are you facing?</h3>
			<?php
			if ($problems) : ?>
			<ul>
			<?php
			foreach ( $problems as $problem ) :
				setup_postdata( $problem );
			?>
				<li><a href="<?= esc_url( get_permalink( $problem->ID ) ); ?>"><?= esc_html($problem->post_title); ?></a></li>
			<?php endforeach; ?>
			<?php wp_reset_postdata(); ?>
			</ul>
			<?php endif; ?>
			<a href="/contact-us" class="button button--secondary">Contact us today</a>
		</div>
	</div>
	<?php
	if ($servicesblock_image) :
	?>
	<div class="services-block__image">
		<?php echo wp_get_attachment_image($servicesblock_image['id'], 'full'); ?>
	</div>
	<?php
	endif;
	?>
</div>
