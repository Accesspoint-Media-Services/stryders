<?php

get_header();

$team_title = get_post_meta( get_the_ID(), 'field_team_title', TRUE );
$team_email = get_post_meta( get_the_ID(), 'field_team_email', TRUE );
$team_mobile = get_post_meta( get_the_ID(), 'field_team_mobile', TRUE );
$team_accordion = get_post_meta( get_the_ID(), 'team_accordion' );
$team_quotes = get_post_meta( get_the_ID(), 'team_quotes' );
$telephone_link = $team_mobile['url']??'';
$telephone_number = $team_mobile['title']??'';

$specialisms = get_the_terms( get_the_ID(), 'team-specialism' );

?>

<div class="banner">
	<div class="banner__content">
		<div class="banner__title">
			<h1><?php the_title(); ?></h1>
		</div>
	</div>
	<img src="<?= esc_url(get_theme_file_uri('/images/background-our-team.png')); ?>" alt="<?php the_title(); ?>">
</div>

<div class="beige-background">
	<div class="container team-profile">

	<?php while (have_posts()) : the_post(); ?>

		<aside>
			<div class="team-profile__image">
			<?php
			if ( has_post_thumbnail() ) :
				$banner_id = get_post_thumbnail_id();

				echo wp_get_attachment_image($banner_id, 'full');
			else :
			?>
				<img src="<?= esc_url(get_theme_file_uri('/images/blank-profile-picture.png')); ?>" alt="<?php the_title(); ?>">
			<?php
			endif;
			?>
			</div>

			<div class="team-profile__details">
				<h2><?php the_title(); ?></h2>

				<?php
				if ($team_title) :
				?>
				<p class="team-title underline underline-left"><strong><?= esc_html($team_title); ?></strong></p>
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
		</aside>

		<article <?php post_class('entry'); ?> id="post-<?php the_ID(); ?>">
			<div class="gutenberg">
				<?php the_content(); ?>
			</div>
			<div class="specialisms">
				<?php
				if ($specialisms) :
				?>
				<h3 class="underline underline-left">Specialism(s)</h3>
				<ul>
				<?php
					foreach ($specialisms as $specialism) :
					?>
					<li>
						<img src="<?= esc_url(get_theme_file_uri('/images/tick.png')); ?>" alt="✓">
						<?= esc_html($specialism->name); ?>
					</li>
					<?php
					endforeach;
				?>
				</ul>
				<?php
				endif;
				?>
			</div>
		</article>

	<?php endwhile; ?>

	</div>
</div>
<div class="mint-background">
	<div class="container team-details">
		<?php
		if ($team_accordion) :
			$acc_count = $team_accordion[0];
			$acc_tracker = 0;
			if($acc_tracker < $acc_count) :
			?>
			<div class="team-accordion is-layout-flow wp-block-group inset-group has-primary-background-color has-background">
			<?php
			while ($acc_tracker < $acc_count) :
				$acc_title = 'team_accordion_'.($acc_tracker).'_team_accordion_title';
				$acc_text = 'team_accordion_'.($acc_tracker).'_team_accordion_text';
				$acc_item_title = get_post_meta( get_the_ID(), $acc_title );
				$acc_item_text = get_post_meta( get_the_ID(), $acc_text );
				?>
				<div class="wp-block-pb-accordion-item c-accordion__item js-accordion-item" data-initially-open="false" data-click-to-close="true" data-auto-close="true" data-scroll="false" data-scroll-offset="0">
					<h2 id="at-<?= esc_attr( $acc_tracker ); ?>" class="c-accordion__title js-accordion-controller" role="button" tabindex="0" aria-controls="ac-<?= esc_attr( $acc_tracker ); ?>" aria-expanded="false">
						<?= esc_html($acc_item_title[0]); ?>
					</h2>
					<div id="ac-<?= esc_attr( $acc_tracker ); ?>" class="c-accordion__content" hidden="hidden">
						<p><?= esc_html($acc_item_text[0]); ?></p>
					</div>
				</div>
				<?php
				$acc_tracker++;
			endwhile;

			?>
			</div>

			<?php
			endif;
		endif;

		if ($team_quotes) :
			$qt_count = $team_quotes[0];
			$qt_tracker = 0;

			if ($qt_count > 1) :
				$slider_class = 'quote-slider';
			else :
				$slider_class = 'no-slide';
			endif;

			?>
			<div class="slide-container dark-dots">
				<div class="<?= esc_attr($slider_class); ?>">
			<?php
			while($qt_tracker < $qt_count) :
				$qt_tracker++;
				$qt_text = 'team_quotes_'.($qt_tracker - 1).'_quote_text';
				$qt_cite = 'team_quotes_'.($qt_tracker - 1).'_quote_citation';
				$qt_item_cite = get_post_meta( get_the_ID(), $qt_cite );
				$qt_item_text = get_post_meta( get_the_ID(), $qt_text );
				?>
					<div class="slide">
						<div class="wp-block-quote">
							<p><?= esc_html($qt_item_text[0]); ?></p>
							<cite><?= esc_html($qt_item_cite[0]); ?></cite>
						</div>
					</div>
				<?php
			endwhile;
			?>
				</div>
			</div>
			<?php
		endif;
		?>
	</div>
</div>

<?php get_footer();
