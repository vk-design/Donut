<?php get_header();?>
<style>
    .footer{display:none;}
</style>
    <div class="polist">
    <article id="post" class="single js-gallery">
          <h1 class="single-title">
            <?php the_title();?>
            <div class="views"><time datetime="<?php echo get_the_date( 'Y-m-d H:i'); ?>">
                <?php echo '發布於 '.timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ); ?>
              </time> - <?php echo getPostViews(get_the_ID()); ?> <?php edit_post_link(); ?></div>
          </h1>
          <div class="post-body"><?php if (have_posts()) { while (have_posts()) { the_post(); the_content();
            } }; ?>
            <?php setPostViews(get_the_ID()); ?>
          </div>
        </article>

<?php get_footer();?>