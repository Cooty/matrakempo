<?php
  if (function_exists('get_header')) {
    get_header();
  } else {
    die();
  }
?>

<?php # Include the top part (header) of the site ?>
<?php include('inc/top.php'); ?>

<?php # Start content ?>
<section class="content grow-tall">
    <?php # Start hero ?>
    <?php
        if(!has_post_thumbnail()) {
            $random_num_suffix = rand(1, 9);
            $small_image_suffix = is_mobile() ? 's/' : '';
            $bg_image_path = get_bloginfo('template_directory').'/img/content/hero_page/'.$small_image_suffix.'bg_'.$random_num_suffix.'.jpg';
        } else {
            $thumb_id = get_post_thumbnail_id();
            $arr_image_attachment = wp_get_attachment_image_src($thumb_id, 'page-poster');
            $bg_image_path = $arr_image_attachment[0];
        }
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
