<?php get_header(); ?>

<?php # Include the top part (header) of the site ?>
<?php include('inc/top.php'); ?>

<?php # Start content ?>
<section class="content grow-tall">
    <?php # Start hero ?>
    <?php
      $random_num_suffix = rand(1, 9);
      $small_image_suffix = is_mobile() ? 's/' : ''; 
      $bg_image_path = get_bloginfo('template_directory').'/img/content/hero_page/'.$small_image_suffix.'bg_'.$random_num_suffix.'.jpg';
    ?>
    <header class="hero hero--subpage z-bottom bg-dark2-grey">
        <div class="hero__img" style="background-image: url(<?= $bg_image_path; ?>)">
            <div class="cover cover--decor-pattern cover--decor-pattern-left blk blk--full-h blk--align-tl hide-below-welterweight"></div>
            <div class="cover cover--decor-pattern cover--decor-pattern-right blk blk--full-h blk--align-tr hide-below-welterweight"></div> 
        </div>
    </header><?php # End hero ?>
  
    <div class="wrapper wrapper--narrow bg-white">
        <?php include('inc/loop.php'); ?>
    </div>
  
</section><?php # End content ?>

<?php get_footer(); ?>