<?php get_header();?>
<?php/*Template Name: music*/?>
<link href="<?php bloginfo('template_directory'); ?>/music/style.css?ver=1680" type="text/css" rel="stylesheet"/>
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/music/dist/APlayer.min.css">
<?php
	$id = 31153529;
	if($id==''){exit;}
	$arr = file_get_contents('http://music.163.com/api/playlist/detail?id='.$id);
	$arr = json_decode($arr,true);
?>
<div class="main">
        <div class="mod_data">
            <span class="data__cover">
		<img src="<?=$arr['result']['coverImgUrl']?>"  alt="" class="data__photo js_index">
            </span>
            <div class="data__cont">
                <div class="data__name">
		    <h1 class="data__name_txt js_index" title=""><?=$arr['result']['name']?></h1>
                </div>
				
                <div class="data__desc" id="singer_desc">
                    <div class="data__desc_txt" id="short_desc"><?=$arr['result']['description']?></div>
                    
                </div>
				

                <ul class="mod_data_statistic">
		
					 <li class="data_statistic__item">
                        <a class="js_goto_tab"><span class="data_statistic__tit"><i class="iconfont">&#xe671;</i>歌曲</span><strong class="data_statistic__number"><?=$arr['result']['trackCount']?></strong></a>
                    </li>
					
					 <li class="data_statistic__item">
                        <a  class="js_goto_tab"><span class="data_statistic__tit"><i class="iconfont">&#xe602;</i>收听</span><strong class="data_statistic__number"><?=$arr['result']['playCount']?></strong></a>
                    </li>
					
                    <li class="data_statistic__item">
                        <a  class="js_goto_tab"><span class="data_statistic__tit"><i class="iconfont">&#xe61a;</i>收藏</span><strong class="data_statistic__number"><?=$arr['result']['subscribedCount']?></strong></a>
                    </li>
		
		
                    <li class="data_statistic__item">
                        <a class="js_goto_tab"><span class="data_statistic__tit"><i class="iconfont">&#xe647;</i>分享</span><strong class="data_statistic__number"><?=$arr['result']['shareCount']?></strong></a>
                    </li>
		
		
                 
		
                </ul>
                
				<div class="data__desc" id="singer_desc">
                    <div class="data__desc_txt ctime" id="short_desc"><i class="iconfont" style="font-size: 15px;">&#xe632;</i><?php echo date("Y-m-d",$arr['result']['createTime']/1000)?> - <?php echo date("Y-m-d",$arr['result']['updateTime']/1000)?></div>
                    
                </div>
				
            </div>
        </div><!--mod-data-end-->
        
        
		<div class="play"><div id="player1" class="aplayer"></div></div>
		
		
      <div class="js_tab" id="index_tab">
          
          <table class="table table-striped table-hover ">
        <thead><tr><th style="width:1.8%">序号</th><th style="width:5%">歌曲</th><th style="width:3%">歌手</th><th style="width:10%">专辑</th><th style="width:3%">时长</th><th style="width:2%">试听</th><th style="width:2%">下载</th></tr></thead>
        <tbody>
		<?php foreach($arr['result']['tracks'] as $v){
			$i++;
		?>
		
		<tr id="id_<?=$i?>"><td class="info" data-title="<?=$v['name']?>" data-author="<?=$v['artists'][0]['name']?>" data-url="http://c.orzaa.com/code/163music/music.php?id=<?=$v['id']?>" data-pic="<?=$v['album']['picUrl']?>"></td><td><?=$i?></td><td><?=$v['name']?></td><td><?=$v['artists'][0]['name']?></td><td><?=$v['album']['name']?></td><td><i class="iconfont" style="font-size: 16px;">&#xe632;</i><?php echo str_replace('.',':',sprintf("%.2f", $v['duration']/1000/60)); ?></td><td><i class="iconfont margin_left" onclick="play(<?=$i?>);">&#xe606;</i></td><td><a href="http://c.orzaa.com/code/163music/music.php?id=<?=$v['id']?>" target="_blank"><i class="iconfont" class="margin_left">&#xe6be;</i></a></td></tr>
		<?php } ?>  
            
        </tbody>
    </table>
          
          
          
          
	</div>  
        
        
        <p class="center" style="text-align: center;">音乐来源网易云音乐</p>
        
    </div><!--main-end-->
	

<script src="<?php bloginfo('template_directory'); ?>/music/dist/APlayer.min.js"></script>
<script>
	var ap1;
	function play(id){
		if ($(".aplayer-music").length > 0){
			ap1.pause();
		}
		var music = {
            "title": $("#id_"+id+" .info").data("title"),
            "author": $("#id_"+id+" .info").data("author"),
            "url": $("#id_"+id+" .info").data("url"),
            "pic": $("#id_"+id+" .info").data("pic")
        };
		ap1 = new APlayer({
			element: document.getElementById('player1'),
			narrow: false,
			autoplay: false,
			showlrc: false,
			music: music
		});
		

		$(".aplayer-play").trigger("click");
		
	}
	

	play(1);
     
	
	
  
</script> 
<?php get_footer();?>