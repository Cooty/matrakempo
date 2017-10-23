<!DOCTYPE html>
<html class="no-js" lang="<?php bloginfo('language'); ?>">
    <head prefix="og:http://ogp.me/ns# fb:http://ogp.me/ns/fb#">
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>
        <?php
	    if(is_404()) {
		echo '404 :( - az oldal nincs meg | ';
		bloginfo('name');
	    } else {
		wp_title('/',true,'right');
		bloginfo('name');
	    }
	?>
    </title>
    <?php #TODO: Find a way to automatically metadata on all subpages ?>
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <meta name="keywords" content="Kempo, kenpo, zen bu kan kempo, kempo Gyöngyös">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:title" content="<?php
        wp_title('/',true,'right');
        bloginfo('name');
    ?>">
    <?php if(is_page() || is_single()): ?>
	<meta property="og:type" content="article">
    <?php else: ?>
	<meta property="og:type" content="website">
    <?php endif;?>
    <?php if(!is_single()): ?>
	<meta property="og:image" content="<?php bloginfo('template_directory')?>/img/content/fb_default_image.jpg?v=<?=filemtime(get_template_directory().'/img/content/fb_default_image.jpg')?>">
    <?php else: ?>
	<?php if(has_post_thumbnail()): ?>
	    <?php
		$thumb_id = get_post_thumbnail_id();
		$thumb_url = wp_get_attachment_image_src($thumb_id, 'single-poster');
	    ?>
	    <meta property="og:image" content="<?= $thumb_url[0]; ?>">
	<?php else: ?>
	    <meta property="og:image" content="<?php bloginfo('template_directory')?>/img/content/fb_default_image.jpg?v=<?=filemtime(get_template_directory().'/img/content/fb_default_image.jpg')?>">
	<?php endif; ?>
    <?php endif;?>
    <meta property="og:description" content="<?php bloginfo('description'); ?>">
    <?php #<meta property="og:fb:app_id" content="1429005784035762"> ?>

    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="<?php
        wp_title('/', true, 'right');
        bloginfo('name');
    ?>">
    <meta name="twitter:description" content="<?php bloginfo('description'); ?>">
    <meta name="twitter:image:src" content="<?php bloginfo('template_directory')?>/img/content/fb_default_image.jpg?v=<?=filemtime(get_template_directory().'/img/content/fb_default_image.jpg')?>">
    <meta name="twitter:domain" content="<?php bloginfo('url'); ?>">

    <!--[if gte IE 10]>
        <meta name="application-name" content="">
        <meta name="msapplication-tooltip" content="<?php bloginfo('name'); ?>">
        <meta name="msapplication-tilecolor" content="#3cbf39">
        <meta name="msapplication-tileimage" content="<?php bloginfo('template_directory')?>/img/content/fb_default_image.jpg?v=<?=filemtime(get_template_directory().'/img/content/fb_default_image.jpg')?>">
    <![endif]-->

    <link type="image/x-icon" href="<?php bloginfo('template_directory')?>/img/icons/favicon.ico" rel="icon">

    <link rel="apple-touch-icon" sizes="57x57" href="<?php bloginfo('template_directory')?>/img/icons/apple-touch-icon.png?v=<?=filemtime(get_template_directory().'/img/icons/apple-touch-icon.png')?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php bloginfo('template_directory')?>/img/icons/apple-touch-icon-72x72-precomposed.png?v=<?=filemtime(get_template_directory().'/img/icons/apple-touch-icon-72x72-precomposed.png')?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php bloginfo('template_directory')?>/img/icons/apple-touch-icon-76x76-precomposed.png?v=<?=filemtime(get_template_directory().'/img/icons/apple-touch-icon-76x76-precomposed.png')?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php bloginfo('template_directory')?>/img/icons/apple-touch-icon-114x114-precomposed.png?v=<?=filemtime(get_template_directory().'/img/icons/apple-touch-icon-114x114-precomposed.png')?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php bloginfo('template_directory')?>/img/icons/apple-touch-icon-120x120-precomposed.png?v=<?=filemtime(get_template_directory().'/img/icons/apple-touch-icon-120x120-precomposed.png')?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php bloginfo('template_directory')?>/img/icons/apple-touch-icon-144x144-precomposed.png?v=<?=filemtime(get_template_directory().'/img/icons/apple-touch-icon-144x144-precomposed.png')?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php bloginfo('template_directory')?>/img/icons/apple-touch-icon-152x152-precomposed.png?v=<?=filemtime(get_template_directory().'/img/icons/apple-touch-icon-152x152-precomposed.png')?>">

    <link rel="stylesheet" href="<?php bloginfo('template_directory')?>/css/style.css?v=<?=filemtime(get_template_directory().'/css/style.css')?>">
    <?php if( is_single() || is_page() ): ?>
       <link rel="stylesheet" href="<?php bloginfo('template_directory')?>/css/single.css?v=<?=filemtime(get_template_directory().'/css/single.css')?>">
    <?php endif; ?>
    <!--[if lte IE 7]>
        <link rel="stylesheet" href="<?php bloginfo('template_directory')?>/css/i7e.css?v=<?=filemtime(get_template_directory().'/css/single.css')?>">
    <![endif]-->

    <!--[if lt IE 9]>
        <script src="<?php bloginfo('template_directory')?>/js/lib/html5shiv.min.js"></script>
    <![endif]-->
    <script src="<?php bloginfo('template_directory')?>/js/lib/modernizr-2.7.2-custom.min.js"></script>
    <link href="//fonts.googleapis.com/css?family=Roboto+Slab:400,700,300&amp;subset=latin-ext" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Tinos:400,700,400italic,700italic&subset=latin-ext" rel="stylesheet">
    <style type="text/css">
        .wf { visibility: visible; }
        strong, b { font-weight: 700; }
    </style>
    <?php wp_head(); ?>
</head>
    <body <?= (is_404() ? 'class="page-404"' : '') ;?> >
