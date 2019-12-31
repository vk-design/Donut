<?php get_header();?><h2 class="pagetitle"><span class="search-terms">关键词：<?php echo $s; ?></span><span class="search-info">&nbsp;<?php
  global $wp_query;
  echo '搜到 ' . $wp_query->found_posts . ' 篇文章';
?></span>
</h2>
<div class="showlist left">
<!--<article class="post-list">
<div class="status">
<a href="http://www.douyu.com/bear1995" se_prerender_url="complete"><p class="twitter">斗鱼日常码农直播
</p></a>
</div></article>-->
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="heading heading--borderedBottom heading--section heading--light heading--thin"><div class="heading-content"><!--<h3 class="heading-title heading-title--dark heading-title--smaller">atest literature</h3>--></div></div></div>
<div class="content">
<section class="blockGroup">
        <?php
    if(have_posts()) :
        while(have_posts()) : the_post();
            if ( has_post_format( 'status' )) { //状态 ?>
<article class="post-list">
<div class="status">
<a href="<?php the_permalink();?>#article" se_prerender_url="complete">
    
    
    <div class="status_avatar"><?php echo get_avatar(get_the_author_meta('user_email', 1), 450);
 ?></div>
    
    <div class="twitter"><i class="row-icon"></i><?php the_title();?><?php echo mb_strimwidth(strip_shortcodes(strip_tags(apply_filters('the_content', $post->post_content))), 0, 220,"...");?></div>
    
    
    
    
    
    
    </a>
    <div class="clear"></div>
</div></article><!--twitter-end-->
        <?php }
            else if ( has_post_format( 'image' )) { //照片 ?>

            <article class="post-in-list post-list">
    <section class="post-excerpt">
    <a href="<?php the_permalink();?>#article">
    <p><!--<img data-original="<?php echo esc_url(post_thumbnail(750, 350) ) ; ?>"alt="<?php the_title();?>" src="<?php echo esc_url(post_thumbnail(750, 350) ) ; ?>">-->
    <div class="post_images" style="
    background-image: url(<?php echo esc_url(post_thumbnail(750, 350) ) ; ?>);
    background-position:center center;
"></div>
    </p>
    <span class="mask transition3"><?php the_title();?> - <?php echo mb_strimwidth(strip_shortcodes(strip_tags(apply_filters('the_content', $post->post_content))), 0, 60,"...");?></span>
    <!--<div class="info-mask">
<div class="mask-wrapper">
<h2 class="image-title"><?php the_title();?></h2>
</div>
</div>--></a>
    </section>
    
</article><!--photo-end-->
<?php }
            else if ( has_post_format( 'gallery' )) { //相册 ?>

            <article class="post-list">
<div class="posttype">
            <div class="post js-gallery"><a href="<?php the_permalink();?>#article"><div id="gallery_padding" class="posttitle gallery_padding"><?php the_title();?><span class="times"><?php echo '發布於 '.timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ); ?></span></div></a><?php echo do_shortcode('[gallery columns="4" size="thumbnail" link="file"]'); ?>
                </div>
            </div>
</article><!--postpost-end-->
<?php }

            else{ //文章 ?> 
<article class="post-list">
<a href="<?php the_permalink();?>#article"><div class="posttype"><div class="thumpic" style="
    background-image: url(<?php echo esc_url(post_thumbnail(450, 450) ) ; ?>);background-position:center center;
"></div>
            <div class="post"><div class="posttitle"><?php the_title();?><span class="times"><?php echo '發布於 '.timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ); ?></span></div>
<div class="postcontent"><?php echo mb_strimwidth(strip_shortcodes(strip_tags(apply_filters('the_content', $post->post_content))), 0, 190,"...");?>
                </div>
                </div>
            </div></a>
</article><!--postpost-end-->
        <?php    }
    endwhile;?>
<?php endif;?>
</section>
  </div><!--content-end-->
  <div class="clear"></div><nav class="navigator">
        <?php previous_posts_link('Previous page') ?><?php next_posts_link('Next page') ?>
	</nav>
	<div class="clear"></div>
	</div>
	<?php get_sidebar();?>
	<div class="clear"></div>

<?php get_sidebar();?>
<?php get_footer();?>