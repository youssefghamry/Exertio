<?php if ( is_active_sidebar( 'exertia-blog-widget' ) ) { ?>
<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
    <aside class="blog-sidebar">
      <?php dynamic_sidebar( 'exertia-blog-widget' ); ?>
    </aside>
</div>
<?php } ?>