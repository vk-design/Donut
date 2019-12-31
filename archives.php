<?php
/*
Template Name: archives
*/
?>
<?php get_header();?>
<style>
    .logogravatar {display: none;}
    .logonav {max-width: 1020px;}
    .winfo {float: left;}
    .month-title{position: relative;}
    .month-title:before{content:"#";color:#42b983;position:absolute;left:-.8em;top:1px;font-size:1.2em}
</style>
<div class="polist page">
    <article id="post">
          <div class="post-archbody">
            <p><?php archives_list_SHe(); ?></p>
             
          </div>
        </article>
  </div>
<?php get_footer();?>