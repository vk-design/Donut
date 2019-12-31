<?php get_header();?>
<?php/*Template Name: disk*/?>
<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1'); 
	require_once get_template_directory() . '/disk/source/init.php';
	$dir = @$_GET['dir'] ? $_GET['dir'] : '/';
	/****************** 
		删除文件
	******************/
	$file = @$_GET['del'] ? $_GET['del'] : '/';
	if($file!='/' && @$_SESSION['username']!=''){
		$upyun->delete($file);
	}
	
	/****************** 
		创建目录
	******************/
	$mkdir = @$_GET['mkdir'];
	if($mkdir!='' && @$_SESSION['username']!=''){
		$upyun->makeDir($dir.$mkdir.'/');
	}
	
?>
<style>
.show-list{/*width:1100px;height:auto;margin:auto;background-color:#fff;margin-top:3em;box-shadow:10px 10px 20px -15px rgba(0,0,0,.3),-10px 10px 20px -15px rgba(0,0,0,.3);border:1px solid #efefef*/    width: 100%;
    height: auto;
    margin: auto;
    background-color: #fff;
    margin-top: 0em;
    box-shadow: 10px 10px 20px -15px rgba(0,0,0,.3),-10px 10px 20px -15px rgba(0,0,0,.3);}
.login{width:540px;height:auto;margin:auto;background-color:#fff;margin-top:7em;box-shadow:10px 10px 20px -15px rgba(0,0,0,.3),-10px 10px 20px -15px rgba(0,0,0,.3);border:1px solid #efefef}
#shuo{text-align:center}
.btn.btn-raised.btn-primary{background-color:#009688;width:95px;height:23px;font-size:14px;font-family:微软雅黑;margin-left:12px;color:#fff;z-index:1}
.btn{border:none}
.up{padding:10em}
.show-list,.admin-login{padding:15px}
.table-responsive{min-height:.01%;overflow-x:auto}
.table{width:100%;max-width:100%;}
.table-striped>tbody>tr:nth-of-type(odd){background-color:#f9f9f9}
.table>tbody>tr>td,.table>tbody>tr>th,.table>tfoot>tr>td,.table>tfoot>tr>th,.table>thead>tr>td,.table>thead>tr>th{padding:8px;line-height:1.42857143;vertical-align:top;border-top:1px solid #ddd;text-align:left;width: 5%;}
.up-info{color:#888;font-size:15px;left:5px;position:relative}
.file-list{border-bottom:1px solid rgba(0,0,0,.05)}
.footer{font-size:12px;text-align:center;padding-top:15px;border-top: 0px solid #eee;}
#login-button{background-color:#009688;width:100%;height:40px;font-size:20px;font-family:微软雅黑;margin-left:12px;margin-top:15px;color:#fff;z-index:1}
.form-control{background-color:#F1F1F1;clear:both;resize:none;color:#555;height:45px;padding:10px;width:100%;box-sizing:border-box;border:0 solid rgba(160,160,160,.1);font-size:15px;line-height:25px}
button,input,textarea{outline:0}
.login-but{width:35%;margin:auto}</style>
<div class="content">
        <div class="show-list">
            <div class="file-list">
                <!--<h1 id="page_title">文件列表</h1>-->
				<?php
					if(@$_SESSION['username']==''){
				?>
				<?php }else{ ?>
				<div class="if-admin">
					<a href="./logout.php">退出</a>
					<span class="up-info">选择一个文件开始上传
					<form  action="./upload.php" method="POST" id="upload_form" enctype="multipart/form-data">
						<div class="btn_div">
							<span>选择文件</span>
							<input type="hidden" name="dir" value="<?=$dir?>"></button>
							<input type="file" onchange="upload_submit()" name="file"></button>
						</div>
						
					</form>
						
						<button id="pickfiles" class="btn btn-raised btn-primary" onclick="mkdir();">创建目录</button>
					</span>
				</div>
				<?php } ?>
               
			   <div class="table-responsive">
	<!--<?php
		$current = @$_SESSION['username']=='' ? '' : '<p style="float:right;">当前已用空间：'.intval($upyun->getFolderUsage()/1024/1024).'MB</p>'; 
		echo '<div class="current"><p>当前路径：'.$dir.'<a href="javascript:history.go(-1);">向上一页</a></p>'.$current.'</div>';
	?>-->
    <table class="table table-striped table-hover ">
        <thead><tr><th style="width: 10%;">文件名</th><th style="width: 1%;">大小</th><th style="width: 2%;">上传日期</th><th style="width: 1%;">操作</th></tr></thead>
        <tbody>
<?php	
	/****************** 
		获取文件列表 
	******************/
	
	$list = $upyun->getList($dir);
	foreach ($list as $v){
		$name		= $v['name'];
		$type		= $v['type'];
		$size		= $type=='folder' ? '-' : intval($v['size'] / 1024);
		$time		= date("Y-m-d H:i:s",$v['time']);
		$dir_url	= $dir.$name;
		if($type=='folder'){
			$next_dir = urlencode($dir_url.'/');
			$url = '<a href="./?dir='.$next_dir.'" >进入</a>';
			$file_url = "./?dir=$next_dir";
		}else{
			$url = '<a href="http://flydigi-img.b0.upaiyun.com'.$dir_url.'" target="_blank">下载</a>';
			$file_url = "http://flydigi-img.b0.upaiyun.com$dir_url";
		}
		$del_url = './?dir='.urlencode($dir).'&del='. urlencode($dir_url);
		$del	= @$_SESSION['username']=='' ? '' : '<a onclick="del_warning(\''.$del_url.'\');" style="
    cursor: no-drop;
">删除</a>';
		
		echo '<tr>
			<td><!--<a href="'.$file_url.'">-->'. $name .'</a></td>
			<td>'. $size .'kb</td>
			<td>'. $time .'</td>
			<td>'. $url .' '. $del .'</td>
		</tr>';
		
		
		
	}
?>	
            
            
        </tbody>
    </table>
</div>
                
            </div>
            <div class="footer">&copy;又拍云个人网盘<div class="if-admin" style="margin-left:12px;">
				</div></div>
        </div>
    </div>