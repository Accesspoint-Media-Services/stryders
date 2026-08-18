<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<header class="header" role="banner">
		<div class="header__main">
			<div class="container">

				<a href="<?= esc_url(home_url()); ?>" class="header__logo">
					<img src="<?= esc_url(get_theme_file_uri('/images/main-logo.png')); ?>" alt="<?= esc_attr(get_bloginfo('name')); ?> Logo">
				</a>

				<div class="header__content">
					<nav role="navigation" class="navbar">
						<button type="button" class="navbar__toggle" id="navbar-toggle" data-target=".navbar__collapse" aria-expanded="false">
							<?= file_get_contents(get_theme_file_path('/images/icons/hamburger.svg')); // phpcs:ignore ?>
                            <span class="sr-only">Open Menu</span>
						</button>
						<?php wp_nav_menu([
							'theme_location' => 'primary',
							'container' => 'div',
							'container_class' => 'collapse navbar__collapse',
							'menu_class' => 'navbar__nav',
							'depth' => 2,
							'fallback_cb' => '__return_empty_string',
							'walker' => new \IndigoTree\AmendedNavWalker\AmendedWalkerNavMenu()
						]); ?>
					</nav>
				</div>

				<div class="header__contact">
					<?php
					$emergency_number = get_field('emergency-number', 'options');
					$emergency_number_url = $emergency_number['url'] ?? '';
					$emergency_number_title = $emergency_number['title'] ?? '';
					?>
					<a href="<?php echo esc_html($emergency_number_url); ?>">
						<?php echo file_get_contents(get_theme_file_path('/images/icons/phone.svg')); // phpcs:ignore ?>
						<strong>Emergency 24 hour line:</strong>
						<span><?php echo esc_html($emergency_number_title); ?></span>
					</a>
				</div>

			</div>
		</div>

	</header>

	<main id="main" class="main" role="main">
