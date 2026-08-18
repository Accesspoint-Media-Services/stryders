	<?php $sra_snippet = get_field('footer_sra_snippet', 'options');
	$cyber_essentials = get_field('footer_cyber_essentials', 'options'); ?>
	</main>

	<footer class="footer" role="contentinfo">
		<div class="footer__contact-number">
			<?php
			$emergency_number = get_field('emergency-number', 'options');
			$emergency_number_url = $emergency_number['url'] ?? '';
			$emergency_number_title = $emergency_number['title'] ?? '';
			?>
			<a href="<?php echo esc_html($emergency_number_url); ?>">
				<?php
				// phpcs:ignore
				echo file_get_contents(get_theme_file_path('/images/icons/phone.svg')); ?>

				<strong>Emergency 24 hour line:</strong>
				<span><?php echo esc_html($emergency_number_title); ?></span>
			</a>
		</div>

		<div class="container">
			<div class="footer__top">
				<div class="footer-col__left">
					<?php dynamic_sidebar('footer-1'); ?>
				</div>
				<div class="footer-col__mid">
					<div class="footer-col__mid--top">
						<?php
						$arr = ksTagList();

						$contact_address = get_field('contact_address', 'options');

						if ($contact_address) :
							foreach ($contact_address as $address) :
						?>
						<div class="contact-address">
							<?php echo wp_kses($address['address'], $arr); ?>
						</div>
						<?php
							endforeach;
						endif;
						?>
					</div>
				</div>
				<div class="footer-col__right">
					<?php
					$opening_times = get_field('opening_times', 'options');
					?>
					<p><strong>Opening Hours</strong></p>
					<div class="opening-hours">
						<div class="days">
							<p>Monday<br/>
							Tuesday<br/>
							Wednesday<br/>
							Thursday<br/>
							Friday<br/>
							Saturday<br/>
							Sunday</p>
						</div>
						<div class="hours">
							<?php
							echo "<p>" . esc_html($opening_times['monday']) . "<br/>";
							echo esc_html($opening_times['tuesday']) . "<br/>";
							echo esc_html($opening_times['wednesday']) . "<br/>";
							echo esc_html($opening_times['thursday']) . "<br/>";
							echo esc_html($opening_times['friday']) . "<br/>";
							echo esc_html($opening_times['saturday']) . "<br/>";
							echo esc_html($opening_times['sunday']) . "</p>";
							?>
						</div>
					</div>
				</div>
			</div>
			<div class="footer__logos-wrapper">
				<?php
				$mobile_logos = get_field('footer_logos', 'options');

				if ($mobile_logos) :
					foreach ($mobile_logos as $moblogo) :
				?>
				<div class="footer-logo">
					<?php echo wp_get_attachment_image(esc_attr($moblogo['logo']['id']), 'full'); ?>
				</div>
				<?php
					endforeach;
				endif;
				if ($cyber_essentials) :
					?>
					<div class="footer-logo">
						<?php echo acf_esc_html($cyber_essentials) ?>
					</div>
					<?php endif;

				if ($sra_snippet) :
				?>
				<div class="footer-logo">
					<?php echo acf_esc_html($sra_snippet) ?>
				</div>
				<?php endif;?>

			</div>
			<div class="footer__bottom">
				<?php wp_nav_menu([
						'theme_location' => 'footer-copyright',
						'container' => false,
						'menu_class' => 'footer__copyright-menu',
						'depth' => 1,
						'fallback_cb' => '__return_empty_string'
					]); ?>
				<p><?= origin_theme_copyright(); // phpcs:ignore ?></p>

				<div class="footer__credit">
				    <?= origin_theme_credit(); // phpcs:ignore ?>
				</div>
			</div>
		</div>
	</footer>

	<?php wp_footer(); ?>

	<script src="https://www.reviewsolicitors.co.uk/widget/rs.js"></script>
		<div id="rswidget_t1jqy" style="position: relative; "></div>
		<script type="text/javascript">
		var props = {
		google: true,
		defaultposition: true,
		isClick: false,
		stats: [ 'satisfaction', 'wouldRecommend', 'valueForMoney' ],
		widgetStyle: 1,
		mr: 4,
		};
		rs.loadWidget('rswidget_t1jqy', 'side', 13588, props);
	</script>

	</body>

	</html>
