<?php get_header(); ?>

<?php # Include the top part (header) of the site ?>
<?php include('inc/top.php'); ?>

<?php # Start content ?>
<section class="content grow-tall"> 
    <div class="wrapper wrapper--push-down">
        <h1 class="heading heading--beta heading--on-texture txt txt--align-center wf wf--roboto wf--roboto--light mb-20">
            <?php single_tag_title('Címkék&nbsp;/&nbsp;'); ?>
        </h1>
        
        <?php include('inc/loop.php'); ?>
    </div>
</section><?php # End content ?>

<?php get_footer(); ?>