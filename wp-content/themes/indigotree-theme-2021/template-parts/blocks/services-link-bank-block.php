<?php
//get problems list
$args = array(
  'numberposts' => 15,
  'post_type'   => 'your-problems',
  'no_found_rows' => true
);
$problems = get_posts( $args );

$left_col_title = get_field('first_col_title');
$left_col_items = get_field('first_col_items');
$servicesblock_image = get_field('servicesblock_image');
?>

<div class="services-link-bank">
  <?php
  if ($problems) :
  ?>
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
</div>
