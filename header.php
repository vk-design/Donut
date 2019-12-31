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
    <div class="logogravatar"><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo( 'name'); ?>" ><div class="blogname">時光<span class="names">記</span></div></a></div>

<div class="logo_name"><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo( 'name'); ?>" ><div class="blogname">時光<span class="names">記</span></div></a></div>
</div>

<div class="bloginfos">
<div class="bloginfo"><form method="get" action="<?php bloginfo('url'); ?>">
                <input class="search_key" name="s" autocomplete="off" placeholder="<?php bloginfo( 'description' ); ?>"
                type="text" value="" required="required">
                <button alt="Search" id="searchsubmit" type="submit">
                  Search
                </button>
              </form></div>

<div class="winfo"><div id="top-nav" class="nav"><?php echo wp_nav_menu(array('theme_location' => 'header_nav', 'echo' => false));?></div></div>
</div>


              <div class="clear"></div>
              </div>
</div></div>
<div class="clear"></div>
<div id="container">