<?php get_header();?>
<div class="showlist left">

<div class="content">
<section class="blockGroup">
        <?php
    if(have_posts()) :
        while(have_posts()) : the_post();
            if ( has_post_format( 'status' )) { //状态 ?>
            
            
            <article class="post-list">

<div class="quote_box">		
			<div class="quote_ttl"><?php the_title();?></div>			
			<div class="quote_center"><a href="<?php the_permalink();?>"><?php the_excerpt(strip_tags($post->post_content),0,200,"..."); ?></a></div>
			<div class="quote_ttl2"><?php echo get_the_date( 'Y年m月d日'); ?></div>
</div>
<!--<div class="hr-list bordered-bottom"></div>-->


<!--<div class="posttype">
            <div class="posts padding5"><div class="clear"></div>
 
 <div class="images_show js-gallery">
     <a href="<?php the_permalink();?>"><div class="twitter_p">
     <?php echo mb_strimwidth(strip_shortcodes(strip_tags(apply_filters('the_content', $post->post_content))), 0, 220,"...");?>
     </div></a>
     </div>



                </div>
            </div>-->
</article>
            
            
<!--twitter-end-->
        <?php }
            else if ( has_post_format( 'image' )) { //照片 ?>
            
            <article class="post-list">
<div class="posttype">
            <div class="post padding5"><div id="gallery_padding" class="images_title"><div class="images_header"><a href="<?php the_permalink();?>"><?php the_title();?><span class="times"><?php echo '發布於 '.timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ); ?></span></a></div></div><div class="clear"></div>
 
 <div class="images_show js-gallery">
 <a href="<?php echo catch_that_image(); ?>" rel="gallery"><div class="post_images">
     <img data-original="<?php echo esc_url(post_thumbnail(750, 350) ) ; ?>" src="<?php echo esc_url(post_thumbnail(750, 350) ) ; ?>"/>
     
     
     
 </div></a></div>



                </div>
            </div><!--<div class="hr-list bordered-bottom"></div>-->
</article>
            
            
            
            
            <!--photo-end-->
<?php }
            else if ( has_post_format( 'gallery' )) { //相册 ?>

            <article class="post-list">
<div class="posttype">
            <div class="post js-gallery"><div id="gallery_padding" class="posttitle gallery_padding"><a href="<?php the_permalink();?>"><?php the_title();?></a><span class="times"><?php echo '發布於 '.timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ); ?></span></div><?php echo do_shortcode('[gallery columns="4" size="thumbnail" link="file"]'); ?>
                </div>
            </div>
</article><!--postpost-end-->
<?php }

            else{ //文章 ?> 
<article class="post-list"><a href="<?php the_permalink();?>">
<div class="posttype"><div class="thumpic" style="
    background-image: url(<?php echo esc_url(post_thumbnail(450, 450) ) ; ?>);background-position:center center;
"></div>
            <div class="post"><div class="posttitle"><?php the_title();?><span class="times"><?php echo '發布於 '.timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ); ?></span></div>
<div class="postcontent"><?php echo mb_strimwidth(strip_shortcodes(strip_tags(apply_filters('the_content', $post->post_content))), 0, 190,"...");?>
                </div>
                </div>
            </div></a><!--<div class="hr-list bordered-bottom"></div>-->
</article><!--postpost-end-->
        <?php    }
    endwhile;?>
<?php endif;?>
</section>
  </div><!--content-end-->
  <div class="clear"></div>
<nav class="navigator">
        <?php previous_posts_link('Previous page') ?><?php next_posts_link('Next page') ?>
	</nav>
	<div class="clear"></div>
	</div>
	<?php get_sidebar();?>
	<div class="clear"></div>

<?php get_footer();?>