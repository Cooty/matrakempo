<?php
    /**
     * The WP 'loop' for Matra Kempo theme, conditionaly rendered based on the type of templete
    */
?>
    
<?php # Home page ?>
<?php if(is_home()): ?>
    <?php # Don't show the 'Klubtagok' category here ?>
    <?php
        query_posts('cat=-4');
    ?>
    <?php # Start grid ?>
    <div class="grid txt txt--align-center mb-10">
        <?php while ( have_posts() ) : the_post(); ?>
            <div class="grid__item one-half--welterweight one-third--middleweight ie7-i-blk-fix">
                <div class="grid__item__gutter">
                    <article class="box">
                      <?php $has_featured_image = has_post_thumbnail(); ?>
                      
                      <a href="<?php the_permalink(); ?>" class="box__img blk <?= ($has_featured_image ? 'pattern' : ''); ?>" title="<?php the_title(); ?>">
                        <?php if($has_featured_image): ?>
                            <h1 class="heading box__img__header txt txt--align-left wf wf--roboto z-low">
                        <?php else: ?>
                            <h1 class="heading box__img__header box__img__header--no-img txt txt--align-left wf wf--roboto z-low">
                        <?php endif; ?>
                          <?php if($has_featured_image): ?>
                            <span class="highlight">
                              <?php the_title();?>
                            </span>
                          <?php else: ?>
                            <?php the_title();?>
                          <?php endif;?>
                        </h1>
                        <?php if($has_featured_image):?>
                            <?php
                                $thumb_id = get_post_thumbnail_id();
                                $thumb_url = wp_get_attachment_image_src($thumb_id, 'box-poster');
                            ?>
                            <img class="blk z-bottom" src="<?= $thumb_url[0]; ?>" alt="<?php the_title(); ?>">
                        <?php endif;?>
                      </a>
                      <div class="box__txt txt txt--align-left txt--body-copy">
                        <?php
                            $raw_excerpt = get_the_excerpt();
                            $dots = '&nbsp;<a class="green-link" href="'.get_the_permalink().'">&hellip;</a>';
                            $limit = ($has_featured_image ? 180 : 360);
                            $truncated_excerpt = trim(tokenTruncate($raw_excerpt, $limit));
                            
                            if(strlen($raw_excerpt) > $limit) {
                                echo $truncated_excerpt.$dots;
                            } else {
                                echo $truncated_excerpt;
                            }
                            
                        ?>
                      </div>
                    </article>
                </div>
            </div>
        <?php endwhile; ?>
    </div><?php #End grid ?>
    <div class="txt txt--align-center pb-40">
        <a href="<?php bloginfo('url'); ?>/cikkek/" class="btn btn--green btn--icon btn--grow ie7-i-blk-fix wf wf--roboto wf--roboto--light no-selection">
            További cikkek
            <span class="icon sprite arrow-right ie7-i-blk-fix"></span>
        </a>
    </div>
<?php endif;?>

<?php #A single post ?>
<?php if(is_single()): ?>
    <?php while ( have_posts() ) : the_post(); ?>
        <article>
            <header class="blk blk--rel">
            
            <?php if(in_category('klubtagok') && has_post_thumbnail()): ?>   
               <?php
                    $thumb_id = get_post_thumbnail_id();
                    $thumb_url = wp_get_attachment_image_src($thumb_id, 'avatar');
                ?>
                <img class="avatar" src="<?= $thumb_url[0]; ?>" alt="<?php the_title(); ?>">
            <?php endif; ?>
                
              <h1 class="heading heading--alpha wf wf--roboto mb-20 <?= (in_category('klubtagok') ? 'txt txt--align-center' : '') ?>">
                <?php the_title(); ?>
              </h1>
              <?php if(!in_category('klubtagok')): ?>
                <span class="txt txt--light2-grey txt--small blk mb-10 wf wf--roboto wf--roboto-light">
                  <?php the_date(); ?>
                </span>
              <?php endif;?>
              <?php #TODO: if the users will need multiple categories than use this ?>
              <?php /*<nav class="categories">
                <?php the_category(); ?>
              </nav>*/ ?>
            </header>
            
            <div class="wrapper--narrow__spacer mb-20"></div>
            
            <?php if(!in_category('klubtagok')): ?>
                <p class="mb-20 txt txt--body-copy wf wf--roboto wf--roboto-light">
                  <?php echo get_the_excerpt(); ?>
                </p>
            <?php endif; ?>
            
            <div class="txt txt--body-copy user-content wf mb-20 clearfix">
                <?php the_content(); ?>   
            </div>
            
            <?php if(has_tag()): ?>
                <nav class="tags pt-20 mb-20">
                    <?php
                        $posttags = get_the_tags();
                        foreach($posttags as $tag) {
                            echo '<a href="';echo bloginfo(url);
                            echo '/?tag=' . $tag->slug . '" class="tag" rel="tag">' . $tag->name . '</a>';
                        }
                    ?>
                </nav>
            <?php endif; ?>
            
            <div class="wrapper--narrow__spacer mb-20"></div> 
            
            <?php include('social_buttons.php')?>
            
          </article>
    <?php endwhile; ?>
<?php endif;?>

<?php # A Category archive page ?>
<?php if(is_category() || is_tag() || is_archive()): ?>
    <?php # Start grid ?>
    <div class="grid txt txt--align-center mb-10">
        <?php while ( have_posts() ) : the_post(); ?>
            <div class="grid__item <?= (in_category('klubtagok') ? 'one-third--welterweight one-sixth--middleweight' : 'one-half--welterweight one-third--middleweight'); ?> ie7-i-blk-fix">
                <div class="grid__item__gutter">
                    <?php if(!in_category('klubtagok')): ?>
                        <article class="box">
                          <?php $has_featured_image = has_post_thumbnail(); ?>
                          
                          <a href="<?php the_permalink(); ?>" class="box__img blk <?= ($has_featured_image ? 'pattern' : ''); ?>" title="<?php the_title(); ?>">
                            <?php if($has_featured_image): ?>
                                <h1 class="heading box__img__header txt txt--align-left wf wf--roboto z-low">
                            <?php else: ?>
                                <h1 class="heading box__img__header box__img__header--no-img txt txt--align-left wf wf--roboto z-low">
                            <?php endif; ?>
                              <?php if($has_featured_image): ?>
                                <span class="highlight">
                                  <?php the_title();?>
                                </span>
                              <?php else: ?>
                                <?php the_title();?>
                              <?php endif;?>
                            </h1>
                            <?php if($has_featured_image):?>
                                <?php
                                    $thumb_id = get_post_thumbnail_id();
                                    $thumb_url = wp_get_attachment_image_src($thumb_id, 'box-poster');
                                ?>
                                
                                <img class="blk z-bottom" src="<?= $thumb_url[0]; ?>" alt="<?php the_title(); ?>">
                            <?php endif;?>
                          </a>
                          <div class="box__txt txt txt--align-left txt--body-copy">
                            <?php
                                $raw_excerpt = get_the_excerpt();
                                $dots = '&nbsp;<a class="green-link" href="'.get_the_permalink().'">&hellip;</a>';
                                $limit = ($has_featured_image ? 180 : 360);
                                $truncated_excerpt = trim(tokenTruncate($raw_excerpt, $limit));
                                
                                if(strlen($raw_excerpt) > $limit) {
                                    echo $truncated_excerpt.$dots;
                                } else {
                                    echo $truncated_excerpt;
                                }
                                
                            ?>
                          </div>
                        </article>
                    <?php else: ?>
                        <a href="<?php the_permalink(); ?>" class="box box--person">
                            <?php
                                $avatar = get_bloginfo('template_directory').'/img/content/dummy_avatar.png';
                                if(has_post_thumbnail()) {
                                    $thumb_id = get_post_thumbnail_id();
                                    $thumb_url = wp_get_attachment_image_src($thumb_id, 'avatar');
                                    $avatar = $thumb_url[0];
                                }
                                
                            ?>
                            <img class="avatar" src="<?= $avatar; ?>" alt="<?php the_title(); ?>">
                            <h1 class="heading heading--beta wf wf--roboto wf--roboto--light mb-20">
                                <?php the_title(); ?>
                            </h1>
                        </a>
                    <?endif;?>
                </div>
            </div>
        <?php endwhile; ?>
    </div><?php #End grid ?>
    <div class="txt txt--align-center pb-40">
        <?php numeric_posts_nav(); ?>
    </div>
<?php endif; ?>

<?php # A single page ?>
<?php if(is_page()): ?>
    <?php while ( have_posts() ) : the_post(); ?>
        <article>
            <header class="blk blk--rel">
              <h1 class="heading heading--alpha wf wf--roboto mb-20">
                <?php the_title(); ?>
              </h1>
            </header>
            <div class="wrapper--narrow__spacer mb-20"></div>
            
            <?php if(has_excerpt()): ?>
                <p class="mb-20 txt txt--body-copy wf wf--roboto wf--roboto-light">
                    <?php the_excerpt(); ?>
                </p>
            <?php endif; ?>
            <!---start user content-->
            <div class="txt txt--body-copy user-content wf mb-20 clearfix">
                <?php the_content(); ?>
          </article>
    <?php endwhile; ?>
<?php endif;?>

<?php #A search results page ?>
<?php if(is_search()): ?>
    <?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
        <article class="media media--list mb-20 bg-white">
            <?php $tn = bdw_get_images(); ?>
            <?php if($tn) : ?>
                <a href="<?php the_permalink(); ?>" class="media__img media__img--small blk">
                    <img src="<?= $tn ?>" alt="<?php the_title(); ?>" >
                </a>
            <?php endif; ?>
            <div class="media__desc" <?= ($tn ? '' : 'style="padding-left: 20px;"'); ?>>
                <h3 class="heading heading--beta wf wf--roboto mb-10">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h3>
                <div class="txt txt--body-copy mb-10" >
                    <?php
                        $raw_excerpt = get_the_excerpt();
                        $dots = '&nbsp;<a class="green-link" href="'.get_the_permalink().'">&hellip;</a>';
                        $limit = 180;
                        $truncated_excerpt = trim(tokenTruncate($raw_excerpt, $limit));
                        
                        if(strlen($raw_excerpt) > $limit) {
                            echo $truncated_excerpt.$dots;
                        } else {
                            echo $truncated_excerpt;
                        }
                        
                    ?>
                </div>
                <span class="txt txt--light2-grey txt--small wf wf--roboto wf--roboto-light">
                    <?php the_date(); ?>
                </span>
            </div>
        </article>
    <?php endwhile; ?>
    <div class="txt txt--align-center pb-40">
        <?php numeric_posts_nav(); ?>
    </div>
    <?php else: ?>
        <article class="media media--list mb-20 bg-white">
            <div class="media__desc" style="padding-left: 20px;">
                <h3 class="heading heading--beta wf wf--roboto mb-10">
                    Sajnos nem találjuk :(
                </h3>
                <div class="txt txt--body-copy mb-10">
                    Sajnos a keresett kifejezésre nincs találat
                </div>
            </div>
        </article>
    <?php endif;?>
<?php endif;?>
