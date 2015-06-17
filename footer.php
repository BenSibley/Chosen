</section> <!-- .main -->

<?php get_sidebar( 'primary' ); ?>


<footer class="site-footer" role="contentinfo">
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

<?php wp_footer(); ?>

<!--[if IE 8 ]>
<script src="<?php echo get_template_directory_uri() . 'js/build/respond.min.js'; ?>"></script>
<![endif]-->

</body>
</html>