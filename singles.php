<?php get_header();?>
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
        <div class="meta split split--responsive">
            <div id="social-share">
              <span class="entypo-share">
                <span class="sharetitle">分享到：</span><button class="button button--vertical button--share js-action is-active" data-action="showSharePopover" data-title="<?php echo $log_title; ?>" data-url="<?php echo get_permalink(); ?>" data-image="">
<button class="button button--chromeless button-share js-action" data-action-value="weibo" data-action="share">分享到微博</button><button class="button button--chromeless button-share js-action" data-action-value="qq" data-action="share">分享到QQ空间</button>
</button>
              </span>
            </div>
            <div class="post-like"><?php the_tags( '<span class="ctags" title="标签">', ' , ', '</span>'); ?>
         <button data-action="ding" data-id="<?php the_ID(); ?>" class="button button--chromeless<?php if(isset($_COOKIE['bigfa_ding_'.$post->ID])) echo ' is-active';?>"><i class="iconfont">&#xe607;</i> 喜欢 <span class="count">
            <?php if( get_post_meta($post->ID,'bigfa_ding',true) ){            
                    echo get_post_meta($post->ID,'bigfa_ding',true);
                 } else {
                    echo '0';
                 }?></span>
        </button>
 </div>
 <div class="clear"></div>
          </div>
          <!--<div id="cat_related">
              <h3>Do you like?</h3>
<?php
global $post;
$cats = wp_get_post_categories($post->ID);
if ($cats) {
    $args = array(
          'category__in' => array( $cats[0] ),
          'post__not_in' => array( $post->ID ),
          'showposts' => 8,
          'caller_get_posts' => 1
      );
  query_posts($args);
  if (have_posts()) {
    while (have_posts()) {
      the_post(); update_post_caches($posts); ?>
  <div class="relevant">
      <span class="title_relevant"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></span>
  <span class="time_rel"><?php echo '發布於 '.timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ); ?></span>
  </div>
<?php
    }
  }
  else {
    echo '<li>暂无相关文章</li>';
  }
  wp_reset_query();
}
else {
  echo '<li>暂无相关文章</li>';
}
?>
<div class="clear"></div>
</div>-->
<?php 
        if(comments_open( get_the_ID() ))  {
            comments_template('', true); 
        }
?></div>
<?php if ('open' != $post->comment_status) : ?>
            <div class="closecomment"><i class="iconfont">&#xe600;</i> 抱歉，评论已关闭！</div>
        <?php endif; ?>
<?php get_footer();?>