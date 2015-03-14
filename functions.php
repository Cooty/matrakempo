<?php
    /**
     * Functions for the 'Matra Kempo' WP theme
     * v1.0
    */
    
    // Add support for menus (1 menu)
    register_nav_menus( array(
	'main_menu' => 'Főmenü'
    ) );
    
    class main_nav extends Walker_Nav_Menu {
	function start_el (&$output, $item, $depth, $args) {
	    // add 'active' class for current page, current category and current parent
	    $active_class_name = in_array('current-page-item', $item->classes) || in_array('current-menu-parent', $item->classes) || in_array('current-menu-item', $item->classes)  ? ' active' : '';
	    
	    $item_output = '<a href="' . $item -> url. '" class="header__menu__item blk blk--i ie7-i-blk-fix wf wf--roboto wf--roboto--light'.$active_class_name.'" title="'.$item -> title.'" data-debug="'.$item->classes.'">' . $item -> title . '</a>';
	    $output .= apply_filters ('walker_nav_menu_start_el', $item_output, $item,  $depth, $args);
	}
    }
      
    class main_nav_drawer_menu extends Walker_Nav_Menu {
	function start_el (&$output, $item, $depth, $args) {
	    $item_output = '<li><a href="' . $item -> url. '" class="drawer-menu__item blk txt txt--nowrap wf wf--roboto" title="'.$item -> title.'">' . $item -> title . '</a>';
	    $output .= apply_filters ('walker_nav_menu_start_el', $item_output, $item,  $depth, $args);
	}
    }
    
    // Add custom style-sheet for the WYSIWIG-editor on the admin
    add_editor_style();
    
    remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
    remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
    remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
    remove_action( 'wp_head', 'index_rel_link' ); // index link
    remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.
    remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version
    
    // get the first image of the post
    function bdw_get_images($poster = false) {
        // Get the post ID
        $iPostID = get_the_ID();
        // Get images for this post
        $arrImages =& get_children('post_type=attachment&post_mime_type=image&post_parent=' . $iPostID );
        // If images exist for this page
        if($arrImages) {
            // Get array keys representing attached image numbers
            $arrKeys = array_keys($arrImages);
     
            // Get the first image attachment
            $iNum = $arrKeys[0];
     
            // Get the thumbnail url for the attachment
	    if(!$poster) {
		$sThumbUrl = wp_get_attachment_thumb_url($iNum);
	    }
	    else {
		$arrReturnedAttachments = wp_get_attachment_image_src('full');
		$sThumbUrl = $arrReturnedAttachments[0];
	    }
     
            // UNCOMMENT THIS IF YOU WANT THE FULL SIZE IMAGE INSTEAD OF THE THUMBNAIL
            //$sImageUrl = wp_get_attachment_url($iNum);
            // Print the image
            return $sThumbUrl;
        }
    }
    
    // Get a remote url with CURL
    function fetchUrl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        // You may need to add the line below
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $postsData = curl_exec($ch);
        curl_close($ch); 
        
        return $postsData;
    }
    
    // Truncate a string
    function truncate($string, $length) {
        return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
    }
    
    function tokenTruncate($string, $your_desired_width, $dots = '&nbsp;&hellip;') {
	$parts = preg_split('/([\s\n\r]+)/', $string, null, PREG_SPLIT_DELIM_CAPTURE);
	$parts_count = count($parts);
      
	$length = 0;
	$last_part = 0;
	for (; $last_part < $parts_count; ++$last_part) {
	  $length += strlen($parts[$last_part]);
	  if ($length > $your_desired_width) { break; }
	}
	
	return implode(array_slice($parts, 0, $last_part));
    }
    
    // Get posts from a Facebook user and display the first 5
    function getFacebookPosts($profileId, $appId, $appSecret) {
        //Retrieve auth token
        $authToken = fetchUrl("https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id={$appId}&client_secret={$appSecret}");
        
        $json_object = fetchUrl("https://graph.facebook.com/{$profileId}/posts?{$authToken}");
        
        $postsarray = json_decode($json_object);
        
        $posts = $postsarray->data;
        
        $arrPostHTML = array();
        
        for($i = 0; $i < 4; $i++) {
            
            $messageOutPut = ($posts[$i]->message ? truncate($posts[$i]->message, 160) : '');
            $linkLinkOutPut = ($posts[$i]->link ? '<br><a href="'.$posts[$i]->link.'" target="_blank" class="txt txt--nowrap">'.truncate($posts[$i]->link, 50).'</a>' : '');
            $postId = substr($posts[$i]->id, strpos($posts[$i]->id, '_') + 1);
            
            if($posts[$i]->message || $posts[$i]->link) {
                
                $arrPostHTML[$i] = '<div class="media media--fb mb-20">'
                                        .'<a class="media__img blk" href="https://www.facebook.com/gyongyoskempo/posts/'.$postId.'" target="_blank">'.count($posts[$i]->likes->data).'</a>'
                                        .'<p class="media__desc txt txt--aside-copy">'
                                            .$messageOutPut
                                            .$linkLinkOutPut
                                        .'</p>'
                                    .'</div>';  
            }
        }
        
        return implode($arrPostHTML);    
    }
    
    function is_mobile() {
	$useragent = $_SERVER['HTTP_USER_AGENT'];
	if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
	    return 1;    
	}
	else {
	    return 0;
	}
	

    }
    
    /**
     * Add custom class names to the output of previous_ and next_post_link() template tags
     * by: http://css-tricks.com/snippets/wordpress/add-class-to-links-generated-by-next_posts_link-and-previous_posts_link/
    */
    add_filter('previous_posts_link_attributes', 'prev_posts_link_attributes');
    add_filter('next_posts_link_attributes', 'next_posts_link_attributes');
    
    function prev_posts_link_attributes() {
	return 'class="article-pager__link left blk"';
    }
    
    function next_posts_link_attributes() {
	return 'class="article-pager__link right blk"';
    }
    
    /**
     * Change the lengt of the excerpt
    */
    function new_excerpt_length($length) {
	return 20;
    }
    add_filter('excerpt_length', 'new_excerpt_length');
    
    /**
     * Add custom image sizes
    */
    
    // Switch on the 'post thumbnail box'
    add_theme_support( 'post-thumbnails' ); 
    
    // Size for the boxes
    add_image_size('box-poster', 500, 281, array( 'center', 'top' ));
    
    // Single poster size
    add_image_size('single-poster', 800, 400, array( 'center', 'top' ));
    
    // Page poster size
    add_image_size('page-poster', 1440, 300, array( 'center', 'top' ));
    
    // Avatar size for 'Klubtagok'
    add_image_size('avatar', 250, 270, array( 'center', 'top' ));
    
    /**
    * Attach a class to linked images' parent anchors
    * e.g. a img => a.img img
    */
   function give_linked_images_class($html, $id, $caption, $title, $align, $url, $size, $alt = '' ){
    $classes = 'img-link'; // separated by spaces, e.g. 'img image-link'
   
    // check if there are already classes assigned to the anchor
    if ( preg_match('/<a.*? class=".*?">/', $html) ) {
       $html = preg_replace('/(<a.*? class=".*?)(".*?>)/', '$1 ' . $classes . '$2', $html);
    } else {
       $html = preg_replace('/(<a.*?)>/', '$1 class="' . $classes . '" >', $html);
    }
    return $html;
   }
   add_filter('image_send_to_editor','give_linked_images_class',10,8);
    
    /*
    Plugin Name: Image P tag remover
    Description: Plugin to remove p tags from around images in content outputting, after WP autop filter has added them. (oh the irony)
    Version: 1.0
    Author: Fublo Ltd
    Author URI: http://fublo.net/
    */
    function filter_ptags_on_images($content) {
	// do a regular expression replace...
	// find all p tags that have just
	// <p>maybe some white space<img all stuff up to /> then maybe whitespace </p>
	// replace it with just the image tag...
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
    }
    
    // we want it to be run after the autop stuff... 10 is default.
    add_filter('the_content', 'filter_ptags_on_images');
    
    /**
     * Numric pagination
    */
    function numeric_posts_nav() {

	if( is_singular() )
	    return;
    
	    global $wp_query;
    
	    /** Stop execution if there's only 1 page */
	    if( $wp_query->max_num_pages <= 1 )
		    return;
    
	    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	    $max   = intval( $wp_query->max_num_pages );
    
	    /**	Add current page to the array */
	    if ( $paged >= 1 )
		    $links[] = $paged;
    
	    /**	Add the pages around the current page to the array */
	    if ( $paged >= 3 ) {
		    $links[] = $paged - 1;
		    $links[] = $paged - 2;
	    }
    
	    if ( ( $paged + 2 ) <= $max ) {
		    $links[] = $paged + 2;
		    $links[] = $paged + 1;
	    }
    
	    echo '<div class="pager blk blk--i ie7-i-blk-fix no-selection"><ul>' . "\n";
    
	    /**	Previous Post Link */
	    if ( get_previous_posts_link() )
		    printf( '<li>%s</li>' . "\n", get_previous_posts_link() );
    
	    /**	Link to first page, plus ellipses if necessary */
	    if ( ! in_array( 1, $links ) ) {
		    $class = 1 == $paged ? ' class="active"' : '';
    
		    printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
    
		    if ( ! in_array( 2, $links ) )
			    echo '<li>…</li>';
	    }
    
	    /**	Link to current page, plus 2 pages in either direction if necessary */
	    sort( $links );
	    foreach ( (array) $links as $link ) {
		    $class = $paged == $link ? ' class="active"' : '';
		    printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
	    }
    
	    /**	Link to last page, plus ellipses if necessary */
	    if ( ! in_array( $max, $links ) ) {
		    if ( ! in_array( $max - 1, $links ) )
			    echo '<li>…</li>' . "\n";
    
		    $class = $paged == $max ? ' class="active"' : '';
		    printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
	    }
    
	    /**	Next Post Link */
	    if ( get_next_posts_link() )
		    printf( '<li>%s</li>' . "\n", get_next_posts_link() );
    
	    echo '</ul></div>' . "\n";
    
    }
    
    /**
     * Convert an image to base64 string
     * @arg {String}	$path - the path to the image
    */
    function image_to_base64($path) {
	$type = pathinfo($path, PATHINFO_EXTENSION);
	$data = file_get_contents($path);
	$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
	return $base64;
    }
    
?>