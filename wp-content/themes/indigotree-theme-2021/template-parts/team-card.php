<?php
	$team_title = get_post_meta( get_the_ID(), 'field_team_title', TRUE );
	$team_email = get_post_meta( get_the_ID(), 'field_team_email', TRUE );
	$team_mobile = get_post_meta( get_the_ID(), 'field_team_mobile', TRUE );
	$telephone_link = $team_mobile['url']??'';
	$telephone_number = $team_mobile['title']??'';

	//get taxonomy
	$titles = wp_get_post_terms( get_the_ID(), array( 'team-title' ) );

	$title_list = '';

	foreach ( $titles as $the_title ) :
		$title_list .= $the_title->slug . ' ';
	endforeach;

?>
<div class="column column--sm-6 column--md-4 filter-col <?= esc_attr( $title_list ); ?>">
	<div class="card team-card">
		<div class="card__media">
			<?php if (has_post_thumbnail()) : ?>
				<?php the_post_thumbnail('large'); ?>
			<?php else : ?>
				<img src="<?= esc_url(get_theme_file_uri('/images/blank-profile-picture.png')); ?>" alt="<?php the_title(); ?>">
			<?php endif; ?>
		</div>

		<div class="card__content">
			<p class="card__title"><?php the_title(); ?></p>

			<?php
			if ($team_title) :
			?>
			<p class="team-title underline underline-left"><?= esc_html($team_title); ?></p>
			<?php
			endif;

			if ($team_email) :
			?>
			<p class="team-email"><strong>E:</strong> <a href="mailto:<?= esc_attr($team_email); ?>"><?= esc_html($team_email); ?></a></p>
			<?php
			endif;

			if ($telephone_link && $telephone_number) :
			?>
			<p class="team-phone"><strong>T:</strong> <a href="<?= esc_attr($telephone_link); ?>"><?= esc_html($telephone_number); ?></a></p>
			<?php
			endif;
			?>
		</div>

		<div class="card__footer">
			<a href="<?php the_permalink(); ?>" class="button button--secondary">View Profile</a>
		</div>
	</div>
</div>
