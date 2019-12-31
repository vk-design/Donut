<?php

add_shortcode( 'pullquote', 'type_shortcode_pullquote' );
function type_shortcode_pullquote( $atts, $content = null )
{
	$content = trim( do_shortcode( shortcode_unautop( $content ) ) );
	extract( shortcode_atts( array(), $atts ) );

	return '<quote class="pullquote">' . $content . '</quote>';
}
//shortcode - old
//download
function downbox($atts, $content=null, $code="") {
	$return = "<div class='scontent'><div class='stext sdown'>";
	$return .= do_shortcode($content);
	$return .= "</div></div>";
	return $return;
}
add_shortcode('down' , 'downbox' );
//author
function authorbox($atts, $content=null, $code="") {
	$return = "<div class='scontent'><div class='stext sauthor'>";
	$return .= do_shortcode($content);
	$return .= "</div></div>";
	return $return;
}
add_shortcode('author' , 'authorbox' );
//textbox
function textbox($atts, $content=null, $code="") {
	$return = "<div class='scontent'><div class='stext sdocument'>";
	$return .= do_shortcode($content);
	$return .= "</div></div>";
	return $return;
}
add_shortcode('text' , 'textbox' );
//blink
function linkbox($atts, $content=null, $code="") {
	$return = "<div class='scontent'><div class='stext slink'>";
	$return .= do_shortcode($content);
	$return .= "</div></div>";
	return $return;
}
add_shortcode('link' , 'linkbox' );
//chat
function chatbox($atts, $content=null, $code="") {
	$return = "<div class='scontent'><div class='stext schat'>";
	$return .= do_shortcode($content);
	$return .= "</div></div>";
	return $return;
}
add_shortcode('chat' , 'chatbox' );

//shortcode - new

//newauthor
function newauthorbox($atts, $content=null, $code="") {
	extract(shortcode_atts(array("title" => ''), $atts));
	$output = "<div class='snewcon'><div class='newtitle newauthor'><h2>".$title."</h2></div><div class='newcontent'>"; 
	$output .= do_shortcode($content);
	$output .= "</div></div>";
	return $output;
}
add_shortcode('newauthor' , 'newauthorbox' );

//newchat
function newchatbox($atts, $content=null, $code="") {
	extract(shortcode_atts(array("title" => ''), $atts));
	$output = "<div class='snewcon'><div class='newtitle newchat'><h2>".$title."</h2></div><div class='newcontent'>"; 
	$output .= do_shortcode($content);
	$output .= "</div></div>";
	return $output;
}
add_shortcode('newchat' , 'newchatbox' );

//newdown
function newdowndbox($atts, $content=null, $code="") {
	extract(shortcode_atts(array("title" => ''), $atts));
	$output = "<div class='snewcon'><div class='newtitle newdown'><h2>".$title."</h2></div><div class='newcontent'>"; 
	$output .= do_shortcode($content);
	$output .= "</div></div>";
	return $output;
}
add_shortcode('newdown' , 'newdowndbox' );

//newlink
function newlinkbox($atts, $content=null, $code="") {
	extract(shortcode_atts(array("title" => ''), $atts));
	$output = "<div class='snewcon'><div class='newtitle newlink'><h2>".$title."</h2></div><div class='newcontent'>"; 
	$output .= do_shortcode($content);
	$output .= "</div></div>";
	return $output;
}
add_shortcode('newlink' , 'newlinkbox' );

//newtext
function newtextbox($atts, $content=null, $code="") {
	extract(shortcode_atts(array("title" => ''), $atts));
	$output = "<div class='snewcon'><div class='newtitle newtext'><h2>".$title."</h2></div><div class='newcontent'>"; 
	$output .= do_shortcode($content);
	$output .= "</div></div>";
	return $output;
}
add_shortcode('newtext' , 'newtextbox' );

//-------------iconsbutton Optimization version by mugee
function button_author($atts, $content = null) {
	extract(shortcode_atts(array("href"=>'http://'), $atts));		
	return "<div class='newtitlebtn newauthor'><h2><a href='$href' target='_blank'>$content</a></h2></div>";
}
add_shortcode('butauthor', 'button_author');

function button_chat($atts, $content = null) {
	extract(shortcode_atts(array("href"=>'http://'), $atts));		
	return "<div class='newtitlebtn newchat'><h2><a href='$href' target='_blank'>$content</a></h2></div>";
}
add_shortcode('butchat', 'button_chat');

function button_download($atts, $content = null) {
	extract(shortcode_atts(array("href"=>'http://'), $atts));		
	return "<div class='newtitlebtn newdown'><h2><a href='$href' target='_blank'>$content</a></h2></div>";
}
add_shortcode('butdown', 'button_download');

function button_link($atts, $content = null) {
	extract(shortcode_atts(array("href"=>'http://'), $atts));		
	return "<div class='newtitlebtn newlink'><h2><a href='$href' target='_blank'>$content</a></h2></div>";
}
add_shortcode('butlink', 'button_link');

function button_text($atts, $content = null) {
	extract(shortcode_atts(array("href"=>'http://'), $atts));		
	return "<div class='newtitlebtn newtext'><h2><a href='$href' target='_blank'>$content</a></h2></div>";
}
add_shortcode('buttext', 'button_text');

//music
function musiclink($atts, $content=null){
	extract(shortcode_atts(array("auto"=>'0',"replay"=>'0',),$atts));	
	return '<embed src="'.get_bloginfo("template_url").'/images/shortcode/dewplayer.swf?mp3='.$content.'&amp;autostart='.$auto.'&amp;autoreplay='.$replay.'" wmode="transparent" height="20" width="240" type="application/x-shockwave-flash" />';
}
add_shortcode('music','musiclink');

//----------toggle by mugee	 
function post_toggle($atts, $content=null){
	extract(shortcode_atts(array("title"=>''),$atts));	
	return '<div class="toggle_title">'.$title.'</div><div class="toggle_content">'.$content.'</div>';
} 
add_shortcode('toggle','post_toggle');

//////////////
function self_embed_handler_youku( $matches, $attr, $url, $rawattr ) { return apply_filters( 'embed_youku', '<embed src="http://player.youku.com/player.php/sid/' . esc_attr($matches[1]) . '/v.swf" quality="high" width="608" height="400" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque"></embed>', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( 'youku', '#http://v.youku.com/v_show/id_(.*?).html#i', 'self_embed_handler_youku' );

function self_embed_handler_tudou( $matches, $attr, $url, $rawattr ) { return apply_filters( 'embed_tudou', '<embed src="http://www.tudou.com/v/' . esc_attr($matches[1]) . '/v.swf"  quality="high" width="610" height="400" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque"></embed>', $matches, $attr, $url, $rawattr );}
wp_embed_register_handler( 'tudou', '#http://www.tudou.com/programs/view/(.*?)/#i', 'self_embed_handler_tudou' );

function wp_embed_handler_ku6( $matches, $attr, $url, $rawattr ) { return apply_filters( 'embed_ku6', '<embed src="http://player.ku6.com/refer/' . esc_attr($matches[1]) . '/v.swf" quality="high" width="610" height="400" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque"></embed>', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( 'ku6', '#http://player.ku6.com/refer/(.*?)/v.swf#i', 'wp_embed_handler_ku6' );

function wp_embed_handler_yinyuetai( $matches, $attr, $url, $rawattr ) { return apply_filters( 'embed_yinyuetai', '<embed src="http://player.yinyuetai.com/swf/explayer.$31818.swf?videoId=' . esc_attr($matches[1]) . '&refererdomain=yinyuetai.com&epId=0" quality="high" width="610" height="400" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" allowfullscreen="true" wmode="opaque"></embed>', $matches, $attr, $url, $rawattr ); }
wp_embed_register_handler( 'yinyuetai', '#http://www.yinyuetai.com/video/(.*?)/#i', 'wp_embed_handler_yinyuetai' );

?>