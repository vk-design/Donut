<?php
	$id = $_GET['id'];
	if($id==''){exit;}
	
	$url = 'http://music.163.com/song/media/outer/url?id='.$id.'.mp3';
	$url = getrealurl($url);
	header('Location: '.$url);
	
	
	function getrealurl($url){  
    $header = get_headers($url,1);  
    if (strpos($header[0],'301') || strpos($header[0],'302')) {  
        if(is_array($header['Location'])) {  
            return $header['Location'][count($header['Location'])-1];  
        }else{  
            return $header['Location'];  
        }  
    }else {  
        return $url;  
    }  
}  
	
?>