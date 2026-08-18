<?php 
    /* Template Name: Contact */

    get_header(); 
?>


<section class="office-locations">
    <div class="office-locations__inner">
        <?php if (have_rows('office_locations') ) :?>
                <?php while (have_rows('office_locations') ) : the_row(); ?>
                    test
                <?php endwhile ; ?>
        <?php endif ; ?>

    </div>
</section>


<?php
get_footer();