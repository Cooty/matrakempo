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
    <?php if(has_post_thumbnail() && !in_category('klubtagok')): ?>
        <?php
            $thumb_id = get_post_thumbnail_id();
            $thumb_url = wp_get_attachment_image_src($thumb_id, 'single-poster');
        ?>

        <?php #Start hero ?>
        <header class="hero hero--subpage z-bottom bg-dark2-grey">
            <div class="hero__img post" style="background-image: url(<?= $thumb_url[0]; ?>)">
                <div class="cover cover--decor-pattern cover--decor-pattern-left blk blk--full-h blk--align-tl hide-below-welterweight"></div>
                <div class="cover cover--decor-pattern cover--decor-pattern-right blk blk--full-h blk--align-tr hide-below-welterweight"></div>
            </div>
        </header><?php #End hero ?>
    <?php endif;?>

    <?php #Wrapper ?>
    <div class="wrapper wrapper--narrow bg-white">

        <?php include('inc/loop.php'); ?>

        <?php # Fixed arrow pagers ?>
        <nav class="article-pager <?= (in_category('klubtagok') ? 'article-pager--person' : ''); ?>">
            <div class="article-pager__link left">
                <?php next_post_link('%link', '%title', true, '', 'category'); ?>
            </div>
            <div class="article-pager__link right">
                <?php previous_post_link('%link', '%title', true, '', 'category'); ?>
            </div>
        </nav><?php # End fixed arrow pagers ?>

        <?php if(!in_category('klubtagok')): ?>
            <div class="wrapper--narrow__spacer pt-20 mb-20"></div>
            <?php # Prev/next page title ?>
            <nav class="grid">
                <div class="grid__item one-half--welterweight">
                  <h2 class="heading heading--delta heading--beta wf wf--roboto grid__item__gutter pb-20">
                    <?php next_post_link('%link', '%title', true, '', 'category'); ?>
                  </h2>
                </div>
                <div class="grid__item one-half--welterweight">
                  <h2 class="heading heading--delta heading--beta wf wf--roboto grid__item__gutter pb-20">
                    <?php previous_post_link('%link', '%title', true, '', 'category'); ?>
                  </h2>
                </div>
            </nav><?php # End prev/next page title ?>


            <aside class="grid">
                <div class="grid__item one-half--welterweight">
                  <div class="grid__item__gutter">
                        <h3 class="heading heading--beta wf wf--roboto wf--roboto--light mb-20">
                            Legújabb cikkek
                        </h3>
                        <?php $my_query = new WP_Query('categoryname=cikkek&showposts=3&cat=-6'); ?>
                        <?php ($my_query->posts); ?>

                        <?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
                            <article class="media mb-20">
                                <?php $tn = bdw_get_images(); ?>

                                <?php
                                    $raw_excerpt = get_the_excerpt();
                                    $dots = '&nbsp;<a class="green-link" href="'.get_the_permalink().'">&hellip;</a>';
                                    $limit = 160;
                                    $truncated_excerpt = trim(tokenTruncate($raw_excerpt, $limit));

                                ?>

                                <?php if($tn) : ?>
                                    <a href="<?php the_permalink(); ?>" class="media__img media__img--small blk">
                                        <img src="<?= $tn ?>" alt="<?php the_title(); ?>" >
                                    </a>
                                <?php endif; ?>
                                <div class="media__desc">
                                    <h3 class="heading heading--delta wf wf--roboto mb-10">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>
                                    <?php
                                        if(strlen($raw_excerpt) > $limit) {
                                        echo '<p class="txt txt--aside-copy">'.$truncated_excerpt.$dots.'</p>';
                                        } else {
                                            echo '<p class="txt txt--aside-copy">'.$truncated_excerpt.'</p>';
                                        }
                                    ?>

                                </div>
                            </article>
                        <?php endwhile; ?>

                        <?php wp_reset_postdata(); ?>

                  </div>
                </div>
                <div class="grid__item one-half--welterweight">
                  <div class="grid__item__gutter">
                    <h3 class="heading heading--beta wf wf--roboto wf--roboto--light mb-20">
                      Ez megy a Facebookon
                    </h3>
                      <?php
                          $profile_id = "1418845781705809";
                          $app_id = "1429005784035762";
                          $app_secret = "2482eb6ebc21a06388b4980248d0717c";
                      ?>

                      <?=getFacebookPosts($profile_id, $app_id, $app_secret)?>
                  </div>
                </div>
            </aside>
        <?php endif; ?>
    </div><?php #End wrapper ?>

</section><?php # End content ?>

<?php get_footer(); ?>
