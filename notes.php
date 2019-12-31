<?php get_header();?>
<?php/*Template Name: note*/?>
<link rel="stylesheet" type="text/css" media="screen" href="https://199508.com/tool/style.css" />
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
            <div class=wrapper>
<span>
<?php echo date("M jS, l");?>
</span>
<div style="margin-top: 0px;  margin-bottom: 7px;  border-bottom: 1px dashed #C5C5C5;
">
<form method="POST" action="./note.php"> 
    <div><textarea name="msg" rows="4"></textarea></div>
    <div class=btn><input name="Btn" type="submit" value="提交"></div>
</form>
</div>

<?php
/******************************Configurations*******************************************/

$SAME_FILE = True;    //这里设置新的一个月开始时，是否要写入原文件。True将写入原文件，False将在月初新开一个文件。如果你的帖子较多，建议设置False，如果帖子不多，可以设为True

/***************************************************************************************/
$filename = "./posts.txt";
file_exists($filename) or file_put_contents($filename, "\xEF\xBB\xBF<div class=post><div class=time>".date("M d##H:i##D")."</div><div class=msg>-- start --</div></div>");
$original_posts = file_get_contents($filename);
if (isset($_POST["msg"])) {
    $msg = $_POST["msg"];
    ($msg=='') and die('Empty message.');
    $msg = preg_replace("/\bhttp:\/\/(\w+)+.*\b/",'<a href="$0">$0</a>',$msg);
    preg_match("/(\w{3}) (\d{2})##\d{2}:\d{2}##\w{3}/s",$original_posts,$matches) or die('No date found.');
    $post_month= $matches[1];
    $post_day= $matches[2];
    $current_month = date("M");
    $current_day = date("d");
    if($SAME_FILE || ($current_month===$post_month)){
        if($current_day===$post_day && $current_month===$post_month){
            $time = date("H:i");
        }
        else{
            $time = date("M d##H:i##D");
        }
        $posts = "<div class=post><div class=time>$time</div><div class=msg>$msg</div></div>" . $original_posts;
        file_put_contents($filename, $posts);
        $posts = preg_replace("/(>\w{3} \d{2})##(\d{2}:\d{2})##(\w{3}<)/","$1<br />$2<br />$3",$posts);
        echo nl2br($posts);
    }
    else{
        $time = date("M d##H:i##D");
        $posts = "<div class=post><div class=time>$time</div><div class=msg>$msg</div></div>";
        if($post_month==='Dec' && $current_month==='Jan'){
            $newfile = "posts_".strval(intval(date("Y"))-1).'_'.$post_month.'.txt';
        }
        else{
            $newfile = "posts_".date("Y").'_'.$post_month.'.txt';
        }
        if (rename($filename, $newfile)){
            file_put_contents($filename, "\xEF\xBB\xBF".$posts);
        }
        else{
            die('Unable to rename $filename to $newfile');
        }
        $posts = preg_replace("/(>\w{3} \d{2})##(\d{2}:\d{2})##(\w{3}<)/","$1<br />$2<br />$3",$posts);
        echo nl2br($posts);
    }    
    redirect('index.php');
}
else{
    $posts = preg_replace("/(>\w{3} \d{2})##(\d{2}:\d{2})##(\w{3}<)/","$1<br />$2<br />$3",$original_posts);
    echo nl2br($posts);
}

function redirect($url, $statusCode = 303)
{
   header('Location: ' . $url, true, $statusCode);
   die();
}

?>
</div>
          </div>
        </article>
      </div>
    </div>
  </div>
<?php get_footer();?>