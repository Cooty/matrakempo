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
      $random_num_suffix = rand(1, 5);
      $small_image_suffix = is_mobile() ? 's/' : '';
      $bg_image_path = get_bloginfo('template_directory').'/img/content/hero_home/'.$small_image_suffix.'bg_'.$random_num_suffix.'.jpg';
    ?>
    <header class="hero hero--homepage z-bottom bg-dark2-grey" style="background-image: url(<?= $bg_image_path; ?>)">
        <?php include('inc/home-text-scroller.php'); ?>
        <div class="hero__cta txt txt--align-center">
          <a href="<?php bloginfo('url'); ?>/a-gyongyosi-kemporol/" class="btn btn--green btn--icon btn--grow ie7-i-blk-fix wf wf--roboto wf--roboto--light no-selection">
            Ismerj meg minket!
            <span class="icon sprite arrow-right"></span>
          </a>
        </div>
    </header><?php # End hero ?>

    <div class="wrapper">
        <?php include('inc/loop.php'); ?>
    </div>

    <?php # Pictures from Flickr ?>
    <?php include('inc/picture-stream.php'); ?>

</section><?php # End content ?>

<?php get_footer(); ?>
