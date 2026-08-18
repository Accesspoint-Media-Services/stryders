<?php 
    /* Template Name: Contact */

    get_header(); 
?>

<?php if (have_rows('office_locations') ) :?>
    <section class="office-locations container">
        
            <?php while (have_rows('office_locations') ) : the_row(); 
                $office_name = get_sub_field('location_name');
                $content = get_sub_field('content');
                $address = get_sub_field('address');
                $phone = get_sub_field('phone_number');
                $google_map = get_sub_field('google_map');
            ?>
                <?php if( $office_name or $address or $content or $google_map ) : ?>
                    <div class="office-locations__item has-primary-background-color">
                        
                        <div class="office-locations__inner--content">  
                            <?php if($office_name) : ?>
                                <h2 class="office-locations__inner--office-name"><?php echo ($office_name); ?></h2>
                            <?php endif; ?>

                            <?php if($content) : ?>
                                <div class="office-locations__inner--copy">
                                    <?php echo ($content); ?>
                                </div>
                            <?php endif; ?>

                            <?php if($address) : ?>
                                <div class="office-locations__inner--address">
                                    <?php echo ($address); ?>
                                </div>
                            <?php endif; ?>

                        </div>

                        <?php if($google_map) : ?>
                        <div class="office-locations__inner--map">
                            <?php echo ($google_map); ?>
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endwhile ; ?>
        
    </section>
<?php endif ; ?>


<?php
get_footer();