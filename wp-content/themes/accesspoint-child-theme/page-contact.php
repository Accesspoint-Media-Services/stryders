<?php 
    /* Template Name: Contact */

    get_header(); 
?>



    <?php if (have_rows('office_locations') ) :?>
        <section class="office-locations">
            <div class="office-locations__inner">
                <?php while (have_rows('office_locations') ) : the_row(); 
                    $office_name = get_sub_field('location_name');
                ?>
                    <div class="office-locations__inner--content">  
                        <?php if($office_name) : ?>
                            <h2 class="office-locations__inner--office-name"><?php echo ($office_name) ?></h2>
                        <?php endif; ?>

                    </div>
                    <div class="office-locations__inner--map">


                    </div>
                <?php endwhile ; ?>
            </div>
        </section>
    <?php endif ; ?>


<?php
get_footer();