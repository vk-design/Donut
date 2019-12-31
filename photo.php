<?php get_header();?>
<?php/*Template Name: Photo*/?>
<div class="about-me about_mob" style="display: inherit;">
          <div class="profile">
              <?php echo get_avatar(get_the_author_meta('user_email', 1), 450);
 ?>
              <div class="info aboutinfo">
            <h1><?php bloginfo( 'name'); ?><span class="online">在线：<?php echo floor((time()-strtotime("2012-07-11"))/86400); ?> 天</span></h1>
            <p><?php bloginfo( 'description' ); ?></p>
            <div class="counts" style="
    text-align: left;
">
          <ul>
            <li><?php $count_posts = wp_count_posts(); echo $published_posts = $count_posts->publish; ?> Articles</li>
            <li><?php $total_comments = get_comment_count(); echo $total_comments['approved'];?> Reviews</li>
            <li><?php echo $count_tags = wp_count_terms('post_tag'); ?> Tag</li>
          </ul>
        </div>
          </div>
              
          </div>
          
          
          
      </div>
<div class="prandom"><!--<h3 class="heading-title heading-title--dark heading-title--smaller"><i class="iconfont">&#xe610;</i> Photography album</h3>-->
<div class="post-random"><ul class="js-photos"><ul>
<?php 
	query_posts('showposts=48&cat=62&orderby=rand');
	while(have_posts()) : the_post();
?>
<li class="photo photo_shows"><a class="photo-item" href="<?php the_permalink(); ?>" target="_blank"><!--<div class="itemrandom"><?php the_title(); ?></div>--><div class="mask transition3"><?php the_title(); ?></div><img src="<?php echo esc_url( Bing_crop_thumbnail( get_content_first_image(get_the_content()), 350, 350 ) ) ; ?>"></a></li>
<?php endwhile; ?>
<div class="clear"></div>
</ul>
</ul></div></div>
<div class="photo_showmore" onclick="location.reload();" ><a href="#top">围观更多</a></div>
<?php get_footer();?>