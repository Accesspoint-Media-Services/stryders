<?php

/* Template Name: Contact */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>
    <main id="primary" class="site-main">
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="entry-content container">
                <?php the_content(); ?>
            </div>
        </article>
    </main>
<?php endwhile; ?>

<?php if ( have_rows( 'office_locations' ) ) : ?>
    <section class="office-locations container">

        <?php while ( have_rows( 'office_locations' ) ) : the_row();
            $office_name = get_sub_field( 'location_name' );
            $content     = get_sub_field( 'content' );
            $address     = get_sub_field( 'address' );
            $phone       = get_sub_field( 'phone_number' );
            $google_map  = get_sub_field( 'google_map' );
        ?>
            <?php if ( $office_name || $address || $content || $google_map ) : ?>
                <div class="office-locations__item has-primary-background-color">

                    <?php if ( $office_name || $address || $content ) : ?>
                        <div class="office-locations__inner--content">
                            <?php if ( $office_name ) : ?>
                                <h2 class="office-locations__inner--office-name"><?php echo esc_html( $office_name ); ?></h2>
                            <?php endif; ?>

                            <?php if ( $content ) : ?>
                                <div class="office-locations__inner--copy">
                                    <?php echo wp_kses_post( $content ); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ( $address || $phone ) : ?>
                                <div class="office-locations__inner--address">
                                    <?php echo esc_html( $address ); ?>

                                    <?php if ( $phone ) : ?>
                                        <div class="office-locations__inner--phone">
                                            <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>">
                                                <span class="helper">T:</span> <?php echo esc_html( $phone ); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                        </div>
                    <?php endif; ?>

                    <?php if ( $google_map ) : ?>
                        <div class="office-locations__inner--map">
                            <?php
                            // If 'google_map' is ACF's native Google Map field type, this
                            // returns an array (lat, lng, zoom...), not markup — echoing it
                            // directly will print "Array" rather than a map. Confirm the
                            // field type; happy to swap this for a proper embed if so.
                            echo ( $google_map );
                            ?>
                        </div>
                    <?php endif; ?>

                </div>
            <?php endif; ?>
        <?php endwhile; ?>

    </section>
<?php endif; ?>

<?php
get_footer();