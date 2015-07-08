<div class="col-sm-12 col-md-3" id="right-sidebar">
    <div class="row">

    <?php if ( is_active_sidebar( 'default' ) ) : ?>
        <?php dynamic_sidebar( 'default' ); ?>
    <?php endif; ?>

    </div><!-- /row -->
</div><!-- / right-sidebar -->