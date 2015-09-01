<?php do_action( 'main_bottom' ); ?>
</section> <!-- .main -->

<?php do_action( 'after_main' ); ?>

<footer class="site-footer" role="contentinfo">
	<?php do_action( 'footer_top' ); ?>
    <div class="design-credit">
        <span>
            <?php
                $site_url = 'https://www.competethemes.com/chosen/';
                $footer_text = sprintf( __( '<a href="%s">Chosen WordPress Theme</a> by Compete Themes.', 'chosen' ), esc_url( $site_url ) );
                $footer_text = apply_filters( 'ct_chosen_footer_text', $footer_text );
                echo $footer_text;
            ?>
        </span>
    </div>
</footer>
</div>
</div><!-- .overflow-container -->

<?php do_action( 'body_bottom' ); ?>

<?php wp_footer(); ?>

</body>
</html>