<?php get_header();?>
<?php/*Template Name: about*/?>
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
        </article>
      </div>
    </div>
  </div>
<?php get_footer();?>