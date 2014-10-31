<?php # Start header ?>
<header class="header z-heigh" data-header>
    
    <?php # Start top stripe (black)?>
    <div class="header__top" data-top>
        <h1 class="header__top__title txt txt--nowrap txt--upper wrapper">
          <span class="wf wf--roboto wf--roboto--bold">Mátra</span> <span class="wf wf--roboto wf--roboto--light">Kempo SE</span>
        </h1>
    </div><?php # End top stripe ?>
    
    <?php # Start green stripe (wawy pattern) ?>
    <div class="header__nav grow-tall decor decor--top">
      
      <?php # Start header navigation wrapper (mobile menu/search buttons and main nav menu) ?>
    <div class="wrapper wrapper--posr full-h txt txt--align-right">
        <a href="<?php bloginfo('url'); ?>" class="header__logo blk" title="Főoldal">
            <img src="<?php bloginfo('template_directory'); ?>/img/asset/logo_222x244.png" class="header__logo__img blk" alt="<?php bloginfo('name'); ?>">  
        </a>
            
        <?php #Opener buttons for the search panel and the portable-size drawer menu ?>
        <?php if(!is_search()): ?>
            <button type="button" class="btn btn--green-border btn--square btn--menu btn--menu--search  ie7-i-blk-fix" data-search-toggler>
                <span class="icon loupe sprite"></span>
            </button>
        <?php endif;?>
          
        <button type="button" class="btn btn--green-border btn--square ml-20 btn--menu btn--menu--list  ie7-i-blk-fix hide-above-middleweight" data-drawer-opener>
          <span class="icon list sprite"></span>
        </button>
        <?php #End buttons ?>
        
        <?php #Start main menu ?>
        <nav class="header__menu txt txt--nowrap">
            <?
                $defaults = array(
                    'menu'            => 'main_menu',
                    'container'       => false,
                    'container_class' => '',
                    'container_id'    => '',
                    'menu_class'      => 'header__menu__item blk blk--i ie7-i-blk-fix wf wf--roboto wf--roboto--light',
                    'menu_id'         => '',
                    'echo'            => false,
                    'fallback_cb'     => 'wp_page_menu',
                    'before'          => '',
                    'after'           => '',
                    'link_before'     => '',
                    'link_after'      => '',
                    'items_wrap'      => '%3$s',
                    'depth'           => 0,
                    'walker'          => new main_nav()
                 );
                
                echo strip_tags(wp_nav_menu( $defaults ), '<a>');
            ?>
        </nav><?php #End main menu ?>
      </div><?php #End header navigation wrapper ?>     
    </div><?php #End green stripe ?>
    
    <?php #Start search container ?>
    <nav class="search<?= (is_search() ? ' search--opened' : ''); ?>" data-search>
        <?php get_search_form(); ?>
    </nav>
    <?php #End search container ?> 
    
</header><?php # End header ?>