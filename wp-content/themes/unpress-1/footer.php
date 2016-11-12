<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content.
 *
 * @package UnPress
 * @since UnPress 1.0
 */
 global $ft_option;
?>

<!-- Shop Footer -->

<?php get_template_part('shop', 'footer');?>

<!-- Footer -->
<footer id="footer">
    
    <?php get_sidebar( 'footer' ); // Output the footer sidebars ?>
    
    
    <div class="footer-2-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!--<div class="pull-left"><a href="#">unPress Magazine</a> - All right reserved</div>-->
                    <div class="pull-right"><?php echo $ft_option["copyright_text"]; ?></div>
                </div>
            </div>
        </div>	
    </div>
    
</footer>
</div>
<!--/#inner-wrap-->
</div>
<!--/#outer-wrap-->
<?php wp_footer(); ?> 
</body>
</html>