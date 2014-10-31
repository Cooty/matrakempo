<?php
    /*
    * Require.js config Matra Kempo WP theme, included in footer.php
    * global variable for configuring Require.js scriptloader
    * Needs to be loaded before Require.js and has to be in the same scope
    * docs: http://requirejs.org/docs/api.html#config
    */
?>
<script>
    var require = {
        baseUrl: '<?php bloginfo('template_directory'); ?>/js/',
        paths: {
            jquery: '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min',
            utils: 'module/utils',
            backtotop: 'module/back-to-top',
            headerscroll: 'module/header-scroll',
            search: 'module/search',
            drawermenu: 'module/drawer-menu',
            textslideshow: 'module/text-slideshow',
            imagestream: 'module/image-stream'
        }
    },
    TemplateDirectory = '<?php bloginfo('template_directory'); ?>';
</script>