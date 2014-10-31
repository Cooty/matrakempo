<?php get_header(); ?>

<?php # Include the top part (header) of the site ?>
<?php include('inc/top.php'); ?>

<?php # Start content ?>
<article class="box-404">
    <h1 class="box-404__heading txt txt--align-center wf wf--roboto wf--roboto--bold">404 - :(</h1>
    <div class="box-404__box txt txt--body-copy">
        Sajnos ezen címen nincs tartalom! Esetleg elgépelted a címet, vagy az adott tartalmat már törölték.
        Próbálj meg visszamenni a <a href="<?php bloginfo('url'); ?>">főoldalra</a>!
    </div>
</article>

<?php get_footer(); ?>