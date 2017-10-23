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

    <div class="wrapper wrapper--narrow wrapper--search-opened">
        <?php include('inc/loop.php'); ?>
    </div>

</section><?php # End content ?>

<?php get_footer(); ?>
