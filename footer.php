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
?></div><?php printf(__('&copy; %d %s', 'thoughtstheme'), date('Y'), get_option('blogname' ) ) ?> · <a rel="nofollow" target="_blank" href="https://my.hupohost.com/aff.php?aff=421">Hupohost</a> · <a rel="nofollow" target="_blank" href="https://www.namesilo.com/" se_prerender_url="loading">NameSilo</a> · <a rel="nofollow" href="https://cn.wordpress.org/" title="WordPress">WordPress</a> · <a href="http://#"  target="_blank" >Dount</a><span class="icp"><a href="http://www.miitbeian.gov.cn"><?php echo get_option( 'zh_cn_l10n_icp_num' );?></a></span> </span>
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