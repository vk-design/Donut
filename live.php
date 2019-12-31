<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<?php wp_head();?>
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="default" />
<meta name="description" content="<?php bloginfo( 'description' ); ?>">
<link type="image/vnd.microsoft.icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico" rel="shortcut icon">
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php bloginfo('rss2_url'); ?>" />
<link href="<?php bloginfo('template_url'); ?>/style.css?ver=1811" type="text/css" rel="stylesheet"/>
<script type="text/javascript"src="<?php bloginfo('template_directory'); ?>/js/jquery-1.10.2.min.js?ver=1.10.2"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/jquery.lazyload.js?v=1.9.3"></script>
<!--[if lt IE 9]>
<script src="//cdn.bootcss.com/html5shiv/r29/html5.min.js"></script>
<script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
    <div class="bodycontent"><div class="midd">
<div class="header">
<div class="logonav">
<div class="logo">
    
    <div class="blog_name">
    <div class="logogravatar"><a href="#" title="<?php bloginfo( 'name'); ?>" ><div class="blogname">手术<span class="names">直播</span></div></a></div>

<div class="logo_name"><a href="#" title="<?php bloginfo( 'name'); ?>" ><div class="blogname">手术<span class="names">直播</span></div></a></div>
</div>

<div class="bloginfos">


<div class="winfo"><div id="top-nav" class="nav"><?php echo wp_nav_menu(array('theme_location' => 'header_nav', 'echo' => false));?></div></div>
</div>


              <div class="clear"></div>
              </div>
</div></div>
<div class="clear"></div>
<div id="container">
<?php/*Template Name: live*/?>
<style>
    .logogravatar,.footer {display: none;}
    .logonav {max-width: 1020px;}
    .winfo {float: left;}
    
</style>
  <div class="pjax">
    <div class="content">
      <div class="wrapperppage page">
        <article id="post" class="single">
          <!--<h1 class="post-title">
            <?php the_title();?>
          </h1>-->
          <div class="post-body js-gallery mb">
            <?php if (have_posts()) { while (have_posts()) { the_post(); the_content();
            } }; ?>
          </div>
<div style="display:none;"><script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_2134430'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com/stat.php%3Fid%3D2134430%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script></div> 
        </article><?php 
        if(comments_open( get_the_ID() ))  {
            comments_template('', true); 
        }
?>
<?php if ('open' != $post->comment_status) : ?>
            <div class="closecomment">抱歉，评论已关闭！</div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div><a class="go-top"><i class="icon iconfont">&#xe613;</i></a>
<div class="clear"></div>
<div class="footer"><div class="mobile_nav"><ul id="mobilenav">
            <?php echo wp_nav_menu(array('theme_location' => 'header_nav', 'echo' => false));?>
          </ul></div><div class="foote"><?php error_reporting(0);
$tip = the_author_meta('mylinks');
$tip = str_replace("\r","",$tip);
$tips = explode("\n",$tip);
if(is_array($tips)){foreach($tips as $tip){$str .= $tip."\n";}echo $str;}
?><?php error_reporting(0);
$tip = the_author_meta('adlinks');
$tip = str_replace("\r","",$tip);
$tips = explode("\n",$tip);
if(is_array($tips)){foreach($tips as $tip){$str .= $tip."\n";}echo $str;}
?></div><?php printf(__('&copy; %d %s', 'thoughtstheme'), date('Y'), get_option('blogname' ) ) ?> · <a rel="nofollow" target="_blank" href="https://my.hupohost.com/aff.php?aff=421">Hupohost</a> · <a rel="nofollow" target="_blank" href="https://www.namesilo.com/" se_prerender_url="loading">NameSilo</a> · <a rel="nofollow" href="https://cn.wordpress.org/" title="WordPress">WordPress</a> · <a href="http://199508.com/1457"  target="_blank" >Dount</a><span class="icp"><a href="http://www.miitbeian.gov.cn"><?php echo get_option( 'zh_cn_l10n_icp_num' );?></a></span> </span>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $("img").lazyload({ 
        effect : "fadeIn"
    });
});
</script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/cupcake.js"></script>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?7f6dd1c954e0a719d0929b5846c11c49";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>

<?php wp_footer();?>
</body>
</html>