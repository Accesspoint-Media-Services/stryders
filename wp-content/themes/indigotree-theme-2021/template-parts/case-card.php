<?php
	//get taxonomy
	$types = wp_get_post_terms( get_the_ID(), array( 'case-type' ) );

	$type_list = '';

	foreach ( $types as $team_type ) :
		$type_list .= $team_type->slug . ' ';
	endforeach;

?>
<div class="column column--sm-12 column--md-6 filter-col <?= esc_attr( $type_list ); ?>">
	<div class="card case-card">
		<div class="card__media">
			<?php if (has_post_thumbnail()) : ?>
				<?php the_post_thumbnail('large'); ?>
			<?php else :
				$default = get_field('default_banner', 'options');
				$banner_id = esc_html($default['ID']);

				echo wp_get_attachment_image($banner_id, 'full');
			endif; ?>
		</div>

		<div class="card__content">
			<h3 class="card__title underline underline-left"><?php the_title(); ?></h3>

			<?php the_excerpt(); ?>
			<a href="<?php the_permalink(); ?>" class="button button--secondary">View Case</a>
		</div>
	</div>
</div>
