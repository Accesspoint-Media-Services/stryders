<?php 
$quotes = get_field('quote');

if( $quotes ) :
?>
<div class="quote-slider">
    <?php
    foreach( $quotes as $quote ) :
        $text = $quote['text'];
        $cite = $quote['citation'];
    ?>
    <div class="slide">
        <div class="wp-block-quote">
            <p><?php echo esc_html( $text ); ?></p>
            <cite><?php echo esc_html( $cite ); ?></cite>
        </div>
    </div>

    <?php
    endforeach;
    ?>
</div>
<?php
endif;
?>