<?php
// 读者墙
if(!function_exists("deep_in_array")) {
    function deep_in_array($value, $array) {
        $i = -1;
        foreach($array as $item => $v) {
            $i++;
            if($v["email"] == $value) return $i;
        }
        return -1;
    }
}

get_template_part('disk/shortcode');
add_action('media_buttons','add_sc_select',11);
function add_sc_select(){
	    $array = array(
			"----图标面板短代码-----" => "",
			"down" => "[down]这里填写内容[/down]",
			"author" => "[author]''这里填写内容[/author]",
			"text" => "[text]这里填写内容[/text]",
			"link" => "[link]这里填写内容[/link]",
			"chat" => "[chat]这里填写内容[/chat]",
			"----标题面板短代码-----" => "",
			"pullquote" => "[pullquote]这里填写内容[/pullquote]" ,
			"newdown" => "[newdown title='这里填写标题']这里填写内容[/newdown]",
			"newauthor" => "[newauthor title='这里填写标题']这里填写内容[/newauthor]",
			"newtext" => "[newtext title='这里填写标题']这里填写内容[/newtext]",
			"newlink" => "[newlink title='这里填写标题']这里填写内容[/newlink]",
			"newchat" => "[newchat title='这里填写标题']这里填写内容[/newchat]",
			"----音乐短代码-----" => "",
			"music" => "[music]可外链MP3的网址[/music]",
            "player" => "[player autoplay='1']",
			"----按钮链接-----" => "",
			"butlink" => "[butlink href='http://oneiro.me/']链接文字[/butlink]",
			"butdown" => "[butdown href='http://oneiro.me/']链接文字[/butdown]",
			"butauthor" => "[butauthor href='http://oneiro.me/']链接文字[/butauthor]",
			"buttext" => "[buttext href='http://oneiro.me/']链接文字[/buttext]",
			"butchat" => "[butchat href='http://oneiro.me/']链接文字[/butchat]"
		);
	    echo '&nbsp;<select id="sc_select">';
	
	    foreach ($array as $key => $val){
			$shortcodes_list .= '<option value="'.$val.'" title="'.$val.'">'.$key.'</option>';
	    }
	    echo $shortcodes_list;
	    echo '</select>';
	}
	add_action('admin_head', 'button_js');
	function button_js() {
		echo '<script type="text/javascript">
		jQuery(document).ready(function(){
		   jQuery("#sc_select").change(function() {
				if(jQuery("#sc_select :selected").val()!="") send_to_editor(jQuery("#sc_select :selected").val());
	        		  return false;
			});
		});
		</script>';
	}

function get_active_friends($num = null,$size = null,$days = null) {
    $num = $num ? $num : 15;
    $size = $size ? $size : 34;
    $days = $days ? $days : 30;
    $array = array();
    $comments = get_comments( array('status' => 'approve','author__not_in'=>1,'date_query'=>array('after' => $days . ' days ago')) );
    if(!empty($comments))    {
        foreach($comments as $comment){
            $email = $comment->comment_author_email;
            $author = $comment->comment_author;
            $url = $comment->comment_author_url;
            $data = human_time_diff(strtotime($comment->comment_date));
            if($email!=""){
                $index = deep_in_array($email, $array);
                if( $index > -1){
                    $array[$index]["number"] +=1;
                }else{
                    array_push($array, array(
                        "email" => $email,
                        "author" => $author,
                        "url" => $url,
                        "date" => $data,
                        "number" => 1
                    ));
                }
            }
        }
        foreach ($array as $k => $v) {
            $edition[] = $v['number'];
        }
        array_multisort($edition, SORT_DESC, $array); // 数组倒序排列
    }
    $output = '<ul class="active-items">';
    if(empty($array)) {
        $output = '<li>none data.</li>';
    } else {
        $max = ( count($array) > $num ) ? $num : count($array);
        for($o=0;$o < $max;$o++) {
            $v = $array[$o];
            $active_avatar = get_avatar($v["email"],$size);
            $active_url = $v["url"] ? $v["url"] : "#";
            $active_alt = $v["author"] . ' - 共'. $v["number"]. ' 条评论，最后评论于'. $v["date"].'前。';
            $output .= '<li class="active-item"><a target="_blank" href="'.$active_url.'" title="'.$active_alt.'">'.$active_avatar.'</a></li>';
        }
    }
    $output .= '</ul>';
    return  $output;
}
function active_shortcode( $atts, $content = null ) {

    extract( shortcode_atts( array(
            'num' => '',
            'size' => '',
            'days' => '',
        ),
        $atts ) );
    return get_active_friends($num,$size,$days);
}
add_shortcode('active', 'active_shortcode');

/*自动中文重名*/
function tin_custom_upload_name($file){
    if(preg_match('/[一-龥]/u',$file['name'])):
    $ext=ltrim(strrchr($file['name'],'.'),'.');
    $file['name']=preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])).'_'.date('Y-m-d_H-i-s').'.'.$ext;
    endif;
    return $file;
}
add_filter('wp_handle_upload_prefilter','tin_custom_upload_name',5,1);
/*文章内链*/
function fa_insert_posts( $atts, $content = null ){
    extract( shortcode_atts( array(

        'ids' => ''

    ),
        $atts ) );
    global $post;
    $content = '';
    $postids =  explode(',', $ids);
    $inset_posts = get_posts(array('post__in'=>$postids));
    foreach ($inset_posts as $key => $post) {
        setup_postdata( $post );
        $content .=  '<article class="post-list">
<a href="' . get_permalink() . '"><div class="posttype"><div class="thumpic" style="
    background-image: url(' . esc_url(post_thumbnail(450, 450) ). ');background-position:center center;
"></div>
            <div class="post"><div class="posttitle">' . get_the_title() . '</div>
<div class="postcontent">' . mb_strimwidth(strip_shortcodes(strip_tags(apply_filters('the_content', $post->post_content))), 0, 210,"..."). '
                </div>
                </div>
            </div></a>
</article>';
    }
    wp_reset_postdata();
    return $content;
}
add_shortcode('fa_insert_post', 'fa_insert_posts');
//首页不显示分类
/*function exclude_category_home( $query ) {
    if ( $query->is_home ) {
    $query->set( 'cat', '-5' );
    //你要排除的分类ID，这里排除了689和125
    }
    return $query;
    }
    
    add_filter( 'pre_get_posts', 'exclude_category_home' );*/
//图片延迟加载
function lazyload($content) {
    $loadimg_url=get_bloginfo('template_directory').'/images/img_loading.gif';
    if(!is_feed()||!is_robots) {
        $content=preg_replace('/<img(.+)src=[\'"]([^\'"]+)[\'"](.*)>/i',"<img\$1data-original=\"\$2\" src=\"$loadimg_url\"\$3>\n<noscript>\$0</noscript>",$content);
    }
    return $content;
}
add_filter ('the_content', 'lazyload');
//发布文章或者更新文章时邮件通知评论用户
add_action( 'submitpost_box', 'fo_submit_box');
function fo_submit_box( ){
echo '<div id="fo_side-sortables" class="meta-box-sortables ui-sortable">';
echo '<div id="fo_submit_box" class="postbox ">';
echo '<div class="handlediv" title="点击以切换"><br></div>';
echo '<h3 class="hndle"><span>邮件通知</span></h3>';
echo '<div class="inside"><div class="submitbox">';
echo ' <div style="padding: 10px 10px 0;text-align: left;"><label class="selectit" title="慎用此功能，重要文章才勾选嘛，以免引起读者反感哈"><input type="checkbox" name="FO_emaill_report_user" value="true" title="勾选此项，将邮件通知博客所有评论者"/>邮件通知博客所有评论者</label></div>';
echo '</div></div>';
echo '</div>';
echo '</div>';
}
//开始
add_action( 'publish_post', 'fo_emaill_report_users' );
function fo_emaill_report_users($post_ID)
{
//如果未勾选保存远程图片，不进行任何操作
if($_POST['FO_emaill_report_user'] != 'true'){
return;
}

//修订版本不通知，以免滥用
if( wp_is_post_revision($post_ID) ){
return;
}

//获取wp数据操作类
global $wpdb;
// 读数据库，获取所有用户的email
$wp_user_emails = $wpdb->get_results("SELECT DISTINCT comment_author, comment_author_email FROM $wpdb->comments WHERE TRIM(comment_author_email) IS NOT NULL AND TRIM(comment_author_email) != ''");

// 获取博客名称
$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
// 获取博客URL
$blogurl = get_bloginfo("siteurl");

//文章链接
$post_link = get_permalink($post_ID);
//文章标题$post -> post_title
$post_title = strip_tags($_POST['post_title']);
//文章内容$post->post_content
$post_content = strip_tags($_POST['post_content']);
//文章摘要
$output = preg_replace('/^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,0}((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,200}).*/s','\1',$post_content).'......';

//邮件头，以免乱码
$message_headers = "Content-Type: text/html; charset=\"utf-8\"\n";
// 邮件标题
$subject = '《'.$blogname.'》有新文章发表了,速来围观。';

foreach ( $wp_user_emails as $wp_user_email )
{
// 邮件内容
$message = '
<div style="MARGIN-RIGHT: auto; MARGIN-LEFT: auto;">
<strong style="line-height: 1.5; font-family:Microsoft YaHei;">
亲爱的'.$wp_user_email->comment_author.'：
</strong>
<p style="FONT-SIZE: 14px; PADDING-TOP: 6px">
您曾经来访过的博客《'.$blogname.'》有新文章发表了，小伙伴都去围观了，就差您了。
</p>
<p style="FONT-SIZE: 14px; PADDING-TOP: 6px">
文章标题：<a title="'.$post_title.'" href="'.$post_link.'" target="_top">'.$post_title.'</a>
<br/>
文章摘要：'.$output.'
</p>
<p style="FONT-SIZE: 14px; PADDING-TOP: 6px">
您可以点击链接
<a href="'.$blogurl.'" style="line-height: 1.5;">'.$blogname.'</a>
>
<a title="'.$post_title.'" href="'.$post_link.'" target="_top">'.$post_title.'</a>
详细查看
</p>
<p style="font-size: 14px; padding-top: 6px; text-align: left;">
<span style="line-height: 1.5; color: rgb(153, 153, 153);">
来自：
</span>
<a href="'.$blogurl.'" style="line-height: 1.5;">'.$blogname.'</a>
</p>
<div style="font-size: 12px; border-top-color: rgb(204, 204, 204); border-top-width: 1px; border-top-style: solid; height: 35px; width: 500px; color: rgb(102, 102, 102); line-height: 35px; background-color: rgb(245, 245, 245);">
该邮件为系统发送邮件，请勿直接回复！如有打扰，请向博主留言反映。灰常感谢您的阅读！
</div>
</div>';

wp_mail($wp_user_email->comment_author_email, $subject, $message, $message_headers);
}
}
add_action('wp_footer', 'infinite_scroll_js', 100);
if(!function_exists('Baidu_Submit')){
    function Baidu_Submit($post_ID) {
        $WEB_TOKEN  = '3Tx8qXOBNFD4DYKJ';  //这里请换成你的网站的百度主动推送的token值
        $WEB_DOMAIN = get_option('home');
        //已成功推送的文章不再推送
        if(get_post_meta($post_ID,'Baidusubmit',true) == 1) return;
        $url = get_permalink($post_ID);
        $api = 'http://data.zz.baidu.com/urls?site='.$WEB_DOMAIN.'&token='.$WEB_TOKEN;
        $request = new WP_Http;
        $result = $request->request( $api , array( 'method' => 'POST', 'body' => $url , 'headers' => 'Content-Type: text/plain') );
        $result = json_decode($result['body'],true);
        //如果推送成功则在文章新增自定义栏目Baidusubmit，值为1
        if (array_key_exists('success',$result)) {
            add_post_meta($post_ID, 'Baidusubmit', 1, true);
        }
    }
    add_action('publish_post', 'Baidu_Submit', 0);
}
//移除默认高宽
add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );
 
function remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
}
// 后台禁用Google Open Sans字体，加速网站
function remove_open_sans() {    
    wp_deregister_style( 'open-sans' );    
    wp_register_style( 'open-sans', false );    
    wp_enqueue_style('open-sans','');    
}    
add_action( 'init', 'remove_open_sans' );

//评论邮件通知
function comment_mail_notify($comment_id) {
$comment = get_comment($comment_id);
$parent_id = $comment->comment_parent ? $comment->comment_parent : '';
$spam_confirmed = $comment->comment_approved;
if (($parent_id != '') && ($spam_confirmed != 'spam')) {
$wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));//发件人e-mail地址
$to = trim(get_comment($parent_id)->comment_author_email);
$subject = '你在 [' . get_the_title($comment->comment_post_ID) . '] 的评论有回复啦 by：' . get_option('blogname') . '';
$message = '
<div id="isForwardContent"><div>
<table border="0" cellspacing="0" cellpadding="0">
</table>
<div>
<h2 style="border-bottom:1px solid #e9e9e9;font-size:15px;font-weight:normal;padding:10px 0 10px;"><span style="color: #12ADDB">&gt; </span>您在 <a style="text-decoration:none;color: #12ADDB;" href="' . get_option('home') . '" title="' . get_option('blogname') . '" target="_blank">' . get_option('blogname') . '</a> 中的留言有回复啦！</h2>
<div style="font-size:15px;color:#777;margin-top:18px"><p style="
    background-color: #cbcf57;
    color: #fff;
    padding-left: 25px;
    width: 15%;
">你说</p>

<p style="background-color: #f5f5f5;padding: 10px 15px;margin:18px 0">' . nl2br(get_comment($parent_id)->comment_content) . '</p>
<p style="
    background-color: #4DB9AB;
    color: #fff;
    padding-left: 25px;
    width: 30%;
">' . trim($comment->comment_author) . ' 说</p>
<p style="background-color:#f5f5f5;padding: 10px 15px;margin:18px 0">' . nl2br($comment->comment_content) . '</p>
<p><a style="text-decoration:none; color:#12addb" href="' . htmlspecialchars(get_comment_link($parent_id)) . '" title="单击查看完整的回复内容" target="_blank">查看完整的回复內容</a>，欢迎再次光临 <a style="text-decoration:none; color:#12addb" href="' . get_option('home') . '" title="' . get_option('blogname') . '" target="_blank">' . get_option('blogname') . '</a>！</p>
</div>
</div>
<div style="color:#D5D5D5;letter-spacing: 3px;font-size:14px;text-align:center;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;margin-top:15px;margin-right:0;margin-left:0;text-transform: uppercase;border-top: 1px solid rgba(0,0,0,.05);">Cupcake：<a target="_blank" style="text-decoration:none;" href="http://199508.com/1457"><span style="color:#D5D5D5;padding-bottom: 2px;border-bottom: 1px solid #D5D5D5;letter-spacing: 3px;font-size:14px;">199508.com</span></a></div>
</div>
</div>';
$from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
$headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
wp_mail( $to, $subject, $message, $headers );
//echo 'mail to ', $to, '<br/> ' , $subject, $message; // for testing
}
}
add_action('comment_post', 'comment_mail_notify');


// 反全英文垃圾评论
	function scp_comment_post( $incoming_comment ) {
		$pattern = '/[一-龥]/u';

		if(!preg_match($pattern, $incoming_comment['comment_content'])) {
			ajax_comment_err( "You should type some Chinese word (like \"你好\") in your comment to pass the spam-check, thanks for your patience! 您的评论中必须包含汉字!" );
		}
		return( $incoming_comment );
	}
	add_filter('preprocess_comment', 'scp_comment_post');

	/**
	 * when comment check the comment_author comment_author_email
	 * @param unknown_type $comment_author
	 * @param unknown_type $comment_author_email
	 * @return unknown_type
	 *防止访客冒充博主发表评论 by Winy
	 */
	function CheckEmailAndName(){
		global $wpdb;
		$comment_author       = ( isset($_POST['author']) )  ? trim(strip_tags($_POST['author'])) : null;
		$comment_author_email = ( isset($_POST['email']) )   ? trim($_POST['email']) : null;
		if(!$comment_author || !$comment_author_email){
			return;
		}
		$result_set = $wpdb->get_results("SELECT display_name, user_email FROM $wpdb->users WHERE display_name = '" . $comment_author . "' OR user_email = '" . $comment_author_email . "'");
		if ($result_set) {
			if ($result_set[0]->display_name == $comment_author){
				ajax_comment_err(__('You CANNOT use this name.'));//昵称
			}else{
				ajax_comment_err(__('You CANNOT use this email.'));//邮箱
			}
			fail($errorMessage);
		}
	}
	add_action('pre_comment_on_post', 'CheckEmailAndName');
// 加载 AJAX 评论提及 & 文章评分插件
require get_template_directory() . '/ajax-comment/do.php';

//文章形式
add_theme_support( 'post-formats', 
           array( 
            'status','image','gallery'
 ) );

//文章浏览统计   
function getPostViews($postID){
    $count_key = 'views';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 次检阅";
    }
    return $count.' 次检阅';
}
 
function setPostViews($postID) {
    $count_key = 'views';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

// 去除默认相册样式
add_filter( 'use_default_gallery_style', '__return_false' );

//---- 主题设置接口 -
add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );
function extra_user_profile_fields( $user ) { ?>
<h3>主题设置</h3>
<table class="form-table">

<tr>
<th><label for="alipay">支付宝</label></th>
<td><input type="text" name="alipay" id="alipay" value="<?php esc_attr_e( get_the_author_meta( 'alipay', $user->ID ) ); ?>" placeholder="用于收款二维码图片地址" class="regular-text">
</td>
</tr>
<tr>
<th><label for="wechatpay">微信</label></th>
<td><input type="text" name="wechatpay" id="wechatpay" value="<?php esc_attr_e( get_the_author_meta( 'wechatpay', $user->ID ) ); ?>" placeholder="用于收款二维码图片地址" class="regular-text">
</td>
</tr>

<tr>
<th><label for="weibo">新浪微博</label></th>
<td><input type="text" name="weibo" id="weibo" value="<?php esc_attr_e( get_the_author_meta( 'weibo', $user->ID ) ); ?>" class="regular-text"></td>
</tr>
<tr>
<th><label for="tencent">腾讯QQ</label></th>
<td><input type="text" name="tencent" id="tencent" value="<?php esc_attr_e( get_the_author_meta( 'tencent', $user->ID ) ); ?>" class="regular-text"></td>
</tr>
<tr>
<th><label for="douban">豆瓣</label></th>
<td><input type="text" name="douban" id="douban" value="<?php esc_attr_e( get_the_author_meta( 'douban', $user->ID ) ); ?>" class="regular-text"></td>
</tr>
<tr>
<th><label for="bloginfo">首页个性句子</label></th>
<td><input type="text" name="bloginfo" id="bloginfo" value="<?php esc_attr_e( get_the_author_meta( 'bloginfo', $user->ID ) ); ?>" class="regular-text"></td>
</tr>
<tr>
<th><label for="adlinks">广告链接</label></th>
<td><textarea name="adlinks" id="adlinks" rows="5" cols="30"><?php esc_attr_e( get_the_author_meta( 'adlinks', $user->ID ) ); ?></textarea>
<p class="description">每行一条，例：<br/><code>&lt;li&gt;&lt;a lass="home-link-item" target="_blank" href="http://199508.com/"&gt;nob太雄&lt;/a&gt;&lt;/li&gt;</code></p>
</td>
</tr>

<tr>
<th><label for="mylinks">友情链接</label></th>
<td>
<textarea name="mylinks" id="mylinks" rows="5" cols="30"><?php esc_attr_e( get_the_author_meta( 'mylinks', $user->ID ) ); ?></textarea>
<p class="description">每行一条，例：<br/><code>&lt;a class="home-link-item" href="http://199508.com/" title="" target="_blank"&gt;nob太雄&lt;/a&gt;</code></p>
</td>
</tr>
<tr>
<th><label for="mycode">自定义代码</label></th>
<td>
<textarea name="mycode" id="mycode" rows="5" cols="30"><?php esc_attr_e( get_the_author_meta( 'mycode', $user->ID ) ); ?></textarea>
<p class="description">可以使用CNZZ、百度统计、腾讯分析的统计代码，也可以放置CSS、JS脚本（页脚隐藏）。</p>
</td>
</tr>
</table>
<?php }
add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );
function save_extra_user_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
	//更新
	update_usermeta( $user_id, 'alipay', $_POST['alipay'] );
	update_usermeta( $user_id, 'wechatpay', $_POST['wechatpay'] );
	update_usermeta( $user_id, 'weibo', $_POST['weibo'] );
	update_usermeta( $user_id, 'tencent', $_POST['tencent'] );
	update_usermeta( $user_id, 'douban', $_POST['douban'] );
	update_usermeta( $user_id, 'bloginfo', $_POST['bloginfo'] );
	update_usermeta( $user_id, 'adlinks', $_POST['adlinks'] );
	update_usermeta( $user_id, 'mylinks', $_POST['mylinks'] );
	update_usermeta( $user_id, 'mycode', $_POST['mycode'] );
}
//---- 主题设置结束 -

// 注册菜单
if (function_exists('register_nav_menus')){
register_nav_menus( array(
   'header_nav' => __('站点导航')
//,'footer_nav' => __('底部菜单')
) );
}
// 引入AJAX
add_action('wp_ajax_nopriv_load_postlist', 'load_postlist_callback');
add_action('wp_ajax_load_postlist', 'load_postlist_callback');
function load_postlist_callback(){
$postlist = '';
$paged = $_POST["paged"];
$total = $_POST["total"];
$category = $_POST["category"];
$author = $_POST["author"];
$tag = $_POST["tag"];
$search = $_POST["search"];
$year = $_POST["year"];
$month = $_POST["month"];
$day = $_POST["day"];
$query_args = array(
"posts_per_page" => get_option('posts_per_page'),
"cat" => $category,
"tag" => $tag,
"author" => $author,
"post_status" => "publish",
"post_type" => "post",
"paged" => $paged,
"s" => $search,
"year" => $year,
"monthnum" => $month,
"day" => $day
);
$the_query = new WP_Query( $query_args );
while ( $the_query->have_posts() ){
$the_query->the_post();
$postlist .= make_post_section();
}
$code = $postlist ? 200 : 500;
wp_reset_postdata();
$next = ( $total > $paged )? ( $paged + 1 ) : '' ;
echo json_encode(array('code'=>$code,'postlist'=>$postlist,'next'=> $next));
die;
}

// 优化代码

remove_filter( 'comment_text', 'make_clickable',  9 );//禁止WordPress评论里的网址自动转换为可点击的链接
remove_action( 'wp_head', 'feed_links_extra', 3 ); // 额外的feed,例如category, tag页
remove_action( 'wp_head', 'wp_generator' ); //隐藏wordpress版本
remove_filter('the_content', 'wptexturize'); //取消标点符号转义
remove_action( 'admin_print_scripts',	'print_emoji_detection_script'); // 禁用Emoji表情
remove_action( 'admin_print_styles',	'print_emoji_styles');
remove_action( 'wp_head',		'print_emoji_detection_script',	7);
remove_action( 'wp_print_styles',	'print_emoji_styles');
remove_filter( 'the_content_feed',	'wp_staticize_emoji');
remove_filter( 'comment_text_rss',	'wp_staticize_emoji');
remove_filter( 'wp_mail',		'wp_staticize_emoji_for_email');
add_filter('login_errors', create_function('$a', "return null;")); //取消登录错误提示
add_filter( 'show_admin_bar', '__return_false' ); //删除AdminBar
if ( function_exists('add_theme_support') )add_theme_support('post-thumbnails'); //添加特色缩略图支持
// 移除菜单冗余代码
add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1);
add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1);
add_filter('page_css_class', 'my_css_attributes_filter', 100, 1);
function my_css_attributes_filter($var) {
return is_array($var) ? array_intersect($var, array('current-menu-item','current-post-ancestor','current-menu-ancestor','current-menu-parent')) : '';
}
// 禁止wp-embed.min.js
function disable_embeds_init() {
    global $wp;
    $wp->public_query_vars = array_diff( $wp->public_query_vars, array(
        'embed',
    ) );
    remove_action( 'rest_api_init', 'wp_oembed_register_route' );
    add_filter( 'embed_oembed_discover', '__return_false' );
    remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
    remove_action( 'wp_head', 'wp_oembed_add_host_js' );
    add_filter( 'tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin' );
    add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
}
add_action( 'init', 'disable_embeds_init', 9999 );
function disable_embeds_tiny_mce_plugin( $plugins ) {
    return array_diff( $plugins, array( 'wpembed' ) );
}
function disable_embeds_rewrites( $rules ) {
    foreach ( $rules as $rule => $rewrite ) {
        if ( false !== strpos( $rewrite, 'embed=true' ) ) {
            unset( $rules[ $rule ] );
        }
    }
    return $rules;
}
function disable_embeds_remove_rewrite_rules() {
    add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'disable_embeds_remove_rewrite_rules' );
function disable_embeds_flush_rewrite_rules() {
    remove_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'disable_embeds_flush_rewrite_rules' );
// Gravatar头像使用中国服务器
function gravatar_cn( $url ){ 
$gravatar_url = array('0.gravatar.com','1.gravatar.com','2.gravatar.com');
return str_replace( $gravatar_url, 'fdn.geekzu.org', $url );
}
add_filter( 'get_avatar_url', 'gravatar_cn', 4 );
// 阻止站内文章互相Pingback 
function theme_noself_ping( &$links ) { 
$home = get_option( 'home' );
foreach ( $links as $l => $link )
if ( 0 === strpos( $link, $home ) )
unset($links[$l]); 
}
add_action('pre_ping','theme_noself_ping');
// 网页标题
function Bing_add_theme_support_title(){ 
    add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'Bing_add_theme_support_title' );
// 编辑器增强
 function enable_more_buttons($buttons) { 
 $buttons[] = 'hr'; 
 $buttons[] = 'del'; 
 $buttons[] = 'sub'; 
 $buttons[] = 'sup';
 $buttons[] = 'fontselect';
 $buttons[] = 'fontsizeselect';
 $buttons[] = 'cleanup';
 $buttons[] = 'styleselect';
 $buttons[] = 'wp_page';
 $buttons[] = 'anchor'; 
 $buttons[] = 'backcolor'; 
 return $buttons;
 } 
add_filter("mce_buttons_3", "enable_more_buttons");

// Time Ago by Fanr
function time_ago( $type = 'commennt', $day = 30 ) {
    $d = $type == 'post' ? 'get_post_time' : 'get_comment_time';
    $timediff = time() - $d('U');
    if ($timediff <= 60*60*24*$day){
        echo  human_time_diff($d('U'), strtotime(current_time('mysql', 0))), 'ago';
    }
    if ($timediff > 60*60*24*$day){
        echo  date('Y/m/d',get_comment_date('U')), ' ', get_comment_time('H:i');
    };
}

//自定义评论结构
function mytheme_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    global $commentcount,$insertAD;;
    if(!$commentcount) {
        $page = ( !empty($in_comment_loop) ) ? get_query_var('cpage')-1 : get_page_of_comment( $comment->comment_ID, $args )-1;
        $cpp=get_option('comments_per_page');
        $commentcount = $cpp * $page;
    }
?><?php 
if (current_time('timestamp') - get_comment_time('U') < 518400 )//六天
{$cmt_time = human_time_diff( get_comment_time('U') , current_time('timestamp') ) . '前';}
else{$cmt_time = get_comment_date( 'Y-n-j' );};
 ;?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>" itemprop="reviews" itemscope itemtype="http://schema.org/Review">
    <?php if( !$parent_id = $comment->comment_parent){ ?>
    
    
    
        <div id="comment-<?php comment_ID(); ?>" class="comment-body">
			<div class="comment_left"><?php echo get_avatar( $comment, $size = '52'); ?></div>
			<div class="comment_right">
			<div class="comment-head">
				<div class="report"><span class="name"><?php printf(__('%s'), get_comment_author_link()) ?></span></div>
				
				<div class="commentinfo"><span class="date">NO:<?php comment_ID(); ?> / 發布於 - <?php echo $cmt_time ;?></span>
				<span class="floor"><?php if(!$parent_id = $comment->comment_parent) {printf('#%1$s', ++$commentcount);} ?></span>
<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => "回复"))) ?></div>
       </div>
     <div class="comment-entry"><?php comment_text() ?></div>
     </div>
     <div class="clear"></div>
   	</div> 
   	
   	
   	
   	
    <?php } else { ?>
    
    
    
        <div id="comment-<?php comment_ID(); ?>" class="comment-body cl">
			<div class="comment_left"><?php echo get_avatar( $comment, $size = '40'); ?></div>
		    <div class="comment_right">
			<div class="comment-head">
				<div class="report"><!--<span class="name"><?php printf(__('%s'), get_comment_author_link()) ?></span>--></div>
				<div class="commentinfo"><span class="date"><span class="rename"><?php printf(__('%s'), get_comment_author_link()) ?></span> 發布於 - <?php echo $cmt_time ;?></span>
				<span class="floor"><?php if(!$parent_id = $comment->comment_parent) {printf('#%1$s', ++$commentcount);} ?></span>
<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => "回复"))) ?></div>
       </div>
     <div class="comment-entry"><?php comment_text() ?></div>
     </div>
     
     <div class="clear"></div>
   	</div> 
   	
   	
   	
    <?php } ;?>
<?php
}

// @父评论
add_filter('comment_text','comment_add_at_parent');
function comment_add_at_parent($comment_text){
    $comment_ID = get_comment_ID();
    $comment = get_comment($comment_ID);
    if ($comment->comment_parent ) {
        $parent_comment = get_comment($comment->comment_parent);
        $comment_text = '<a href="#comment-' . $comment->comment_parent . ' "class="reportname"><i class="iconfont">&#xe60f;</i>'.$parent_comment->comment_author.'</a> ' . $comment_text;
    }
    return $comment_text;
}


//评论者的链接新窗口打开
function comment_author_link_window() {
global $comment;
$url    = get_comment_author_url();
$author = get_comment_author();
if ( empty( $url ) || 'http://' == $url )
 $return = $author;
 else
 $return = "<a href='$url'  target='_blank'>$author</a>"; 
 return $return;
}
add_filter('get_comment_author_link', 'comment_author_link_window');

// 缩略图技术 by：http://www.bgbk.org
if( !defined( 'THEME_THUMBNAIL_PATH' ) ) define( 'THEME_THUMBNAIL_PATH', '/cache/theme-thumbnail' ); //存储目录
function Bing_build_empty_index( $path ){
	$index = $path . '/index.php';
	if( is_file( $index ) ) return;
	wp_mkdir_p( $path );
	file_put_contents( $index, "<?php\n// Silence is golden.\n" );
}
function Bing_crop_thumbnail( $url, $width, $height = null ){
	$width = (int) $width;
	$height = empty( $height ) ? $width : (int) $height;
	$hash = md5( $url );
	$file_path = WP_CONTENT_DIR . THEME_THUMBNAIL_PATH . "/$hash-$width-$height.jpg";
	$file_url = content_url( THEME_THUMBNAIL_PATH . "/$hash-$width-$height.jpg" );
	if( is_file( $file_path ) ) return $file_url;
	$editor = wp_get_image_editor( $url );
	if( is_wp_error( $editor ) ) return $url;
	$size = $editor->get_size();
	if( !$dims = image_resize_dimensions( $size['width'], $size['height'], $width, $height, true ) ) return $url;
	$cmp_x = $size['width'] / $width;
	$cmp_y = $size['height'] / $height;
	$cmp = min( $cmp_x, $cmp_y );
	$min_width = round( $width * $cmp );
	$min_height = round( $height * $cmp );
	$crop = $editor->crop( $dims[2], $dims[3], $min_width, $min_height, $width, $height );
	if( is_wp_error( $crop ) ) return $url;
	Bing_build_empty_index( WP_CONTENT_DIR . THEME_THUMBNAIL_PATH );
	$save = $editor->save( $file_path, 'image/jpg' );
	return is_wp_error( $save ) ? $url : $file_url;
}
function Bing_add_support_post_thumbnails(){
	add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'Bing_add_support_post_thumbnails' );
// 获取文章第一张图片
function get_content_first_image($content){
	if ( $content === false ) $content = get_the_content(); 
	preg_match_all('|<img.*?src=[\'"](.*?)[\'"].*?>|i', $content, $images);
	if($images){
		return $images[1][0];
	}else{
		return false;
	}
}
function catch_that_image() {
global $post, $posts;
$first_img = '';
ob_start();
ob_end_clean();
$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
 
//获取文章中第一张图片的路径并输出
$first_img = $matches [1] [0];
 
//如果文章无图片，获取自定义图片
 
if(empty($first_img)){ //Defines a default image
$first_img = "/images/default.jpg";
 
//请自行设置一张default.jpg图片
}
 
return $first_img;
}
//缩略图获取post_thumbnail
function post_thumbnail($width = 275,$height = 170 )
{
    global $post;
    //如果有特色图片则取特色图片
	if( has_post_thumbnail( $post->ID ) ){
		$thumbnail_ID = get_post_thumbnail_id( $post->ID );
		$thumbnailsrc = wp_get_attachment_image_src( $thumbnail_ID, 'full' );
        $thumbnailsrc = $thumbnailsrc[0];

		return Bing_crop_thumbnail($thumbnailsrc,$width,$height);
	}
    else
    {
        $content = $post->post_content;
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
        if(count($strResult[1]) > 0)
        {
            return Bing_crop_thumbnail($strResult[1][0],$width,$height);
        }
        else
        {
            return false;
        }
    }
}
/**
 * Theme Update Checker Library 1.2 ／ 主题更新推送
 * http://w-shadow.com/
 * Copyright 2012 Janis Elsts
 * Licensed under the GNU GPL license.
 * http://www.gnu.org/licenses/gpl.html
 */
if ( !class_exists('ThemeUpdateChecker') ):
class ThemeUpdateChecker {
	public $theme = '';
	public $metadataUrl = '';
	public $enableAutomaticChecking = true;
	protected $optionName = '';
	protected $automaticCheckDone = false;
	protected static $filterPrefix = 'tuc_request_update_';
	public function __construct($theme, $metadataUrl, $enableAutomaticChecking = true){
		$this->metadataUrl = $metadataUrl;
		$this->enableAutomaticChecking = $enableAutomaticChecking;
		$this->theme = $theme;
		$this->optionName = 'external_theme_updates-'.$this->theme;
		$this->installHooks();		
	}
	public function installHooks(){
		if ( $this->enableAutomaticChecking ){
			add_filter('pre_set_site_transient_update_themes', array($this, 'onTransientUpdate'));
		}
		add_filter('site_transient_update_themes', array($this,'injectUpdate'));
		add_action('delete_site_transient_update_themes', array($this, 'deleteStoredData'));
	}
	public function requestUpdate($queryArgs = array()){
		$queryArgs['installed_version'] = $this->getInstalledVersion(); 
		$queryArgs = apply_filters(self::$filterPrefix.'query_args-'.$this->theme, $queryArgs);
		$options = array(
			'timeout' => 10,
		);
		$options = apply_filters(self::$filterPrefix.'options-'.$this->theme, $options);
		$url = $this->metadataUrl; 
		if ( !empty($queryArgs) ){
			$url = add_query_arg($queryArgs, $url);
		}
		$result = wp_remote_get($url, $options);
		$themeUpdate = null;
		$code = wp_remote_retrieve_response_code($result);
		$body = wp_remote_retrieve_body($result);
		if ( ($code == 200) && !empty($body) ){
			$themeUpdate = ThemeUpdate::fromJson($body);
			if ( ($themeUpdate != null) && version_compare($themeUpdate->version, $this->getInstalledVersion(), '<=') ){
				$themeUpdate = null;
			}
		}
		$themeUpdate = apply_filters(self::$filterPrefix.'result-'.$this->theme, $themeUpdate, $result);
		return $themeUpdate;
	}
	public function getInstalledVersion(){
		if ( function_exists('wp_get_theme') ) {
			$theme = wp_get_theme($this->theme);
			return $theme->get('Version');
		}
		foreach(get_themes() as $theme){
			if ( $theme['Stylesheet'] === $this->theme ){
				return $theme['Version'];
			}
		}
		return '';
	}
	public function checkForUpdates(){
		$state = get_option($this->optionName);
		if ( empty($state) ){
			$state = new StdClass;
			$state->lastCheck = 0;
			$state->checkedVersion = '';
			$state->update = null;
		}
		$state->lastCheck = time();
		$state->checkedVersion = $this->getInstalledVersion();
		update_option($this->optionName, $state);
		$state->update = $this->requestUpdate();
		update_option($this->optionName, $state);
	}
	public function onTransientUpdate($value){
		if ( !$this->automaticCheckDone ){
			$this->checkForUpdates();
			$this->automaticCheckDone = true;
		}
		return $value;
	}
	public function injectUpdate($updates){
		$state = get_option($this->optionName);
		if ( !empty($state) && isset($state->update) && !empty($state->update) ){
			$updates->response[$this->theme] = $state->update->toWpFormat();
		}
		return $updates;
	}
	public function deleteStoredData(){
		delete_option($this->optionName);
	}
	public function addQueryArgFilter($callback){
		add_filter(self::$filterPrefix.'query_args-'.$this->theme, $callback);
	}
	public function addHttpRequestArgFilter($callback){
		add_filter(self::$filterPrefix.'options-'.$this->theme, $callback);
	}
	public function addResultFilter($callback){
		add_filter(self::$filterPrefix.'result-'.$this->theme, $callback, 10, 2);
	}
}
endif;
if ( !class_exists('ThemeUpdate') ):
class ThemeUpdate {
	public $version;
	public $details_url;
	public $download_url;
	public static function fromJson($json){
		$apiResponse = json_decode($json);
		if ( empty($apiResponse) || !is_object($apiResponse) ){
			return null;
		}
		$valid = isset($apiResponse->version) && !empty($apiResponse->version) && isset($apiResponse->details_url) && !empty($apiResponse->details_url);
		if ( !$valid ){
			return null;
		}
		$update = new self();
		foreach(get_object_vars($apiResponse) as $key => $value){
			$update->$key = $value;
		}
		return $update;
	}
	public function toWpFormat(){
		$update = array(
			'new_version' => $this->version,
			'url' => $this->details_url,
		);
		if ( !empty($this->download_url) ){
			$update['package'] = $this->download_url;
		}
		return $update;
	}
}
endif;
$mytheme_update_checker = new ThemeUpdateChecker(
	'cupcake',
	'http://199508.com/cupcake/update.json'
);

//归档
function archives_list_SHe() {
     global $wpdb,$month;
     $lastpost = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_date <'" . current_time('mysql') . "' AND post_status='publish' AND post_type='post' AND post_password='' ORDER BY post_date DESC LIMIT 1");
     $output = get_option('SHe_archives_'.$lastpost);
     if(empty($output)){
         $output = '';
         $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE 'SHe_archives_%'");
         $q = "SELECT DISTINCT YEAR(post_date) AS year, MONTH(post_date) AS month, count(ID) as posts FROM $wpdb->posts p WHERE post_date <'" . current_time('mysql') . "' AND post_status='publish' AND post_type='post' AND post_password='' GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC";
         $monthresults = $wpdb->get_results($q);
         if ($monthresults) {
             foreach ($monthresults as $monthresult) {
             $thismonth    = zeroise($monthresult->month, 2);
             $thisyear    = $monthresult->year;
             $q = "SELECT ID, post_date, post_title, comment_count FROM $wpdb->posts p WHERE post_date LIKE '$thisyear-$thismonth-%' AND post_date AND post_status='publish' AND post_type='post' AND post_password='' ORDER BY post_date DESC";
             $postresults = $wpdb->get_results($q);
             if ($postresults) {
                 $text = sprintf('%s %d', $month[zeroise($monthresult->month,2)], $monthresult->year);
                 $postcount = count($postresults);
                 $output .= '<div class="list list--archive"><h3 class="month-title">' . $text . ' &nbsp;(' . count($postresults) . '&nbsp;篇文章)</h3><ul class="blockGroup is-ordered">' . "\n";
             foreach ($postresults as $postresult) {
                 if ($postresult->post_date != '0000-00-00 00:00:00') {
                 $url = get_permalink($postresult->ID);
                 $arc_title    = $postresult->post_title;
                 if ($arc_title)
                     $text = wptexturize(strip_tags($arc_title));
                 else
                     $text = $postresult->ID;
                     $title_text = 'View this post, &quot;' . wp_specialchars($text, 1) . '&quot;';
                     $output .= '<li class="archive-item">' . mysql2date('d日', $postresult->post_date) . ':&nbsp;' . "<a href='$url' title='$title_text'>$text</a>";
                     $output .= '<span class="pid">ID：' . $postresult->ID . '</span>';
                     $output .= '</li>' . "\n";
                 }
                 }
             }
             $output .= '</ul></div>' . "\n";
             }
         update_option('SHe_archives_'.$lastpost,$output);
         }else{
             $output = '<div class="errorbox">Sorry, no posts matched your criteria.</div>' . "\n";
         }
     }
     echo $output;
 }
//点击喜欢
add_action('wp_ajax_nopriv_bigfa_like', 'bigfa_like');
add_action('wp_ajax_bigfa_like', 'bigfa_like');
function bigfa_like(){
    global $wpdb,$post;
    $id = $_POST["um_id"];
    $action = $_POST["um_action"];
    if ( $action == 'ding'){
    $bigfa_raters = get_post_meta($id,'bigfa_ding',true);
    $expire = time() + 99999999;
    $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false; // make cookies work with localhost
    setcookie('bigfa_ding_'.$id,$id,$expire,'/',$domain,false);
    if (!$bigfa_raters || !is_numeric($bigfa_raters)) {
        update_post_meta($id, 'bigfa_ding', 1);
    } 
    else {
            update_post_meta($id, 'bigfa_ding', ($bigfa_raters + 1));
        }
   
    echo get_post_meta($id,'bigfa_ding',true);
    
    } 
    
    die;
}
/*时间格式化*/
function timeago( $ptime ) {
    $ptime = strtotime($ptime);
    $etime = time() - $ptime;
    if ($etime < 1) return '刚刚';     
    $interval = array (         
        12 * 30 * 24 * 60 * 60  =>  ' 年前 ('.date('Y年m月d日', $ptime).')',
        30 * 24 * 60 * 60       =>  ' 个月前 ('.date('m月d日', $ptime).')',
        7 * 24 * 60 * 60        =>  ' 周前 ('.date('m月d日', $ptime).')',
        24 * 60 * 60            =>  ' 天前',
        60 * 60                 =>  ' 小时前',
        60                      =>  ' 分钟前',
        1                       =>  ' 秒前'
    );
    foreach ($interval as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . $str;
        }
    };
}
/*function Qiniu_cdn(){ob_start( 'Qiniu_cdn_replace' );}
add_action( 'template_redirect', 'Qiniu_cdn' );
// 替换静态资源链接为七牛 CDN
function Qiniu_cdn_replace( $code ){
	$cdn_exts = 'png|jpg|jpeg|gif|bmp';
	$cdn_dirs = str_replace( '-', '\-', 'wp-content|wp-includes' );
	$regex = '/' . str_replace( '/', '\/', site_url() ) . '\/((' . $cdn_dirs . ')\/[^\s\?\\\'\"\;\>\<]{1,}.(' . $cdn_exts . '))([\"\\\'\s\?]{1})/';
	return preg_replace( $regex, '//cdn.imsou.cn/$1$4', $code );
}*/
/*搜索增强*/
if(is_search()){
add_filter('posts_orderby_request', 'search_orderby_filter');
}
function search_orderby_filter($orderby = ''){
    global $wpdb;
    $keyword = $wpdb->prepare($_REQUEST['s']);
    return "((CASE WHEN {$wpdb->posts}.post_title LIKE '%{$keyword}%' THEN 2 ELSE 0 END) + (CASE WHEN {$wpdb->posts}.post_content LIKE '%{$keyword}%' THEN 1 ELSE 0 END)) DESC,
{$wpdb->posts}.post_modified DESC, {$wpdb->posts}.ID ASC";
}

// 修改WordPress用户名过滤机制，通过Email获取用户名
function ludou_allow_email_login($username, $raw_username, $strict) {
  if (filter_var($raw_username, FILTER_VALIDATE_EMAIL)) {
    $user_data = get_user_by('email', $raw_username);
    
    if (empty($user_data))
      wp_die(__('<strong>ERROR</strong>: There is no user registered with that email address.'), '用户名不正确');
    else
      return $user_data->user_login;
  }
  else {
    return $username;
  }
}

//头像缓存
function my_avatar($avatar) {   
  $tmp = strpos($avatar, 'http');   
  $g = substr($avatar, $tmp, strpos($avatar, "'", $tmp) - $tmp);   
  $tmp = strpos($g, 'avatar/') + 7;   
  $f = substr($g, $tmp, strpos($g, "?", $tmp) - $tmp);   
  $w = get_bloginfo('wpurl');   
  $e = ABSPATH .'avatar/'. $f .'.jpg';   
  $t = 1209600; //設定14天, 單位:秒   
  if ( !is_file($e) || (time() - filemtime($e)) > $t ) { //當頭像不存在或文件超過14天才更新   
    copy(htmlspecialchars_decode($g), $e);   
  } else  $avatar = strtr($avatar, array($g => $w.'/avatar/'.$f.'.jpg'));   
  if (filesize($e) < 500) copy($w.'/avatar/default.jpg', $e);   
  return $avatar;   
}   
add_filter('get_avatar', 'my_avatar');
// 全部配置完毕
?>
