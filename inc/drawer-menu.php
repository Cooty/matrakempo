<?php
    /**
     * Drawer menu for Matra Kempo WP theme - output only visible in layout-versions below 960px-width
     * The menu is the same as the WP-menu in the header comes from admin
    */
?>
<div class="drawer-menu-opened-overlay z-middle" data-drawer-closer></div>

<nav class="drawer-menu z-heigh">
    <button class="btn btn--circle drawer-menu__close" type="button" title="Menü bezárása" data-drawer-closer>
        <span class="icon close sprite"></span>
    </button>

    <?
        $defaults = array(
            'menu'            => 'main_menu',
            'container'       => false,
            'container_class' => '',
            'container_id'    => '',
            'menu_class'      => '',
            'menu_id'         => '',
            'echo'            => false,
            'fallback_cb'     => 'wp_page_menu',
            'before'          => '',
            'after'           => '',
            'link_before'     => '',
            'link_after'      => '',
            'items_wrap'      => '%3$s',
            'depth'           => 0,
            'walker'          => new main_nav_drawer_menu()
         );

        echo strip_tags(wp_nav_menu( $defaults ), '<a>');
    ?>
</nav>
