<?php
global $outdoor_opt;

// Footer options
$footer_text        = ( isset( $outdoor_opt['od-footer-text'] ) )       ? $outdoor_opt['od-footer-text'] : '';
$footer_subtext     = ( isset( $outdoor_opt['od-footer-subtext'] ) )    ? $outdoor_opt['od-footer-subtext'] : '';
$footer_copyright   = ( isset( $outdoor_opt['od-footer-copyright'] ) )  ? $outdoor_opt['od-footer-copyright'] : '';
$show_gotop         = ( isset( $outdoor_opt['od-footer-gotop'] ) )      ? $outdoor_opt['od-footer-gotop'] : true;
$preloader          = ( isset( $outdoor_opt['od-show-preloader'] ) )    ? $outdoor_opt['od-show-preloader'] : true;
?>
<!-- FOOTER -->
<section id="footer">
    <div class="container-fluid footer" >
        <div class="row">

            <div class="col-xs-12">
                <?php if( $show_gotop == true ) : ?>
                <a class="go-up" href="#wrapper">
                    <i class="fa fa-angle-up"></i>
                </a>
                <?php endif; ?>
            </div>
            <div class="col-xs-12">
                <span class="thanks-forvisit"><?php echo $footer_text; ?></span>
                <p class="share-us"><?php echo $footer_subtext; ?></p>
            </div>

            <div class="col-xs-12">
                <?php
                // Show GetShare social buttons
                outdoor_share_buttons(); ?>
            </div>
            <div class="col-xs-12"><span class="corp"><?php echo $footer_copyright; ?></span></div>

        </div>
    </div>
</section>
<!-- / FOOTER -->

<?php if( $preloader ) : ?>
<div class="preloader page-preloader">
    <div class="preload-img"></div>
</div>
<?php endif; ?>

</div> <!-- / WRAPPER -->

<?php wp_footer(); ?>

</body>
</html>