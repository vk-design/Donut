<?php get_header();?>
    <div class="pjax">
    <div class="content">
      <div class="wrapperppage">
        <article id="post" class="single">
          <h1 class="single-title">
            <?php the_title();?>
          </h1>
          <div class="post-body js-gallery mb">
            <?php if (have_posts()) { while (have_posts()) { the_post(); the_content();
            } }; ?>
          </div>
          <div class="meta split split--responsive">
            <div id="social-share">
              <span class="entypo-share">
                <span class="sharetitle">分享到：</span><button class="button button--vertical button--share js-action is-active" data-action="showSharePopover" data-title="<?php echo $log_title; ?>" data-url="<?php echo get_permalink(); ?>" data-image="">
<button class="button button--chromeless button-share js-action" data-action-value="weibo" data-action="share">分享到微博</button><button class="button button--chromeless button-share js-action" data-action-value="qq" data-action="share">分享到QQ空间</button>
</button>
              </span>
            </div>
            <div class="post-like">
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
        </article>
      </div>
    </div>
  </div>
<?php get_footer();?>