<div class="list-side">
      <div class="about-me">
          <div class="profile">
              
              <div class="info">
            <h1><?php bloginfo( 'name'); ?><span class="online">在线：<?php echo floor((time()-strtotime("2015-10-09"))/86400); ?> 天</span></h1>
            <p><?php bloginfo('url'); ?></p>
            <p><?php bloginfo( 'description' ); ?></p>
          </div>
              <?php echo get_avatar(get_the_author_meta('user_email', 1), 450);
 ?>
          </div>
          
          <div class="counts">
          <ul>
            <li><?php $count_posts = wp_count_posts(); echo $published_posts = $count_posts->publish; ?> Articles</li>
            <li><?php $total_comments = get_comment_count(); echo $total_comments['approved'];?> Reviews</li>
            <li><?php echo $count_tags = wp_count_terms('post_tag'); ?> Tag</li>
          </ul>
        </div>
          
      </div>
        
    <div id="float" class="random-article"><!--
        <div class="heading-title">随机文章</div>-->
        <ul>
            <?php $rand_posts = get_posts('numberposts=8&orderby=rand');
foreach( $rand_posts as $post ) : ?>
   <li>
        <div class="list-itemImage"><div class="thumpicrad" style="
    background-image: url(<?php echo esc_url(post_thumbnail(250, 250) ) ; ?>);background-position:center center;
"></div></div><div class="list-itemInfo"><h4 class="random-list"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4><p class="random-info"><?php echo getPostViews(get_the_ID()); ?> ，<?php $id=$post->ID; echo get_post($id)->comment_count;?>  則留言</p></div>
   </li>
<?php endforeach; ?>
        </ul>
    </div>
        
    </div>