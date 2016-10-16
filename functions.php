<?php
// Add custom functions here

add_filter('body_class','bdr_add_category_to_single');

add_action('wp_footer', 'bdr_add_authoring_menu');
add_action( 'init', 'bdr_add_editor_styles' );

wp_register_script( 'bdrumes-js', get_stylesheet_directory_uri().'/assets/js/bdrumes.js', 'jquery', "1.0", true);

wp_register_script( 'slick-js', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js', null, null, true);
wp_register_style( 'slick-css', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css', array(), null);
wp_register_style( 'slick-theme', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick-theme.css', array(), null);

wp_register_style( 'bootswatch-paper-css', 'https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/paper/bootstrap.min.css', array(), null);
wp_register_script( 'bootstrap-js', 'https://bootswatch.com/bower_components/bootstrap/dist/js/bootstrap.min.js', array ('jquery', 'kadence_plugins'), "1.0", true );

wp_register_script('isotope-js', '//npmcdn.com/isotope-layout@3/dist/isotope.pkgd.js', null, null, true);

wp_enqueue_script( 'bdrumes-js' );
wp_enqueue_script( 'slick-js' );
wp_enqueue_style( 'slick-css' );
wp_enqueue_style( 'slick-theme' );
wp_enqueue_script( 'isotope-js' );

/*wp_enqueue_style( 'bootswatch-paper-css' );*/

function bdr_get_category_by_slug($slug) {

    $bdrumes_category_auteur = get_term_by( 'slug', $slug, 'category' );
    return $bdrumes_category_auteur;
}

function bdr_is_auteur_post() {
    $BDRUMES_CATEGORY_AUTEUR_SLUG = 'auteurs';
    $post = get_post( $post->ID );
    $cat_auteurs = bdr_get_category_by_slug($BDRUMES_CATEGORY_AUTEUR_SLUG);
    if ($cat_auteurs == NULL)
         return false;
    $terms = get_the_terms( $post->ID, 'category');
    foreach( $terms as $term ) {
        if (cat_is_ancestor_of($cat_auteurs , $term) or is_category($cat_auteurs))
            return true;
        }
    return false;
}

function bdr_get_auteur_presence($days) {
    $BDRUMES_CATEGORY_PRESENCE_SLUG = 'presence';
    $presences = [];
    $cat_presence = bdr_get_category_by_slug($BDRUMES_CATEGORY_PRESENCE_SLUG);
    $post = get_post( $post->ID );
    $terms = get_the_terms( $post->ID, 'category');
    foreach ($days as $day) {
        $cat_day = bdr_get_category_by_slug($day);
        $presences[$day] = in_category($cat_day, $post);
    }
    return $presences;
}

/**
 * Get taxonomies terms links.
 *
 * @see get_object_taxonomies()
 */
function wpdocs_custom_taxonomies_terms_links() {
    // Get post by post ID.
    $post = get_post( $post->ID );

    // Get post type by post.
    $post_type = $post->post_type;

    // Get post type taxonomies.
    $taxonomies = get_object_taxonomies( $post_type, 'objects' );

    $out = array();

    foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){

        // Get the terms related to post.
        $terms = get_the_terms( $post->ID, $taxonomy_slug );

        if ( ! empty( $terms ) ) {
            $out[] = "<h2>" . $taxonomy->label . "</h2>\n<ul>";
            foreach ( $terms as $term ) {
                $out[] = sprintf( '<li><a href="%1$s">%2$s</a></li>',
                    esc_url( get_term_link( $term->slug, $taxonomy_slug ) ),
                    esc_html( $term->name )
                );
            }
            $out[] = "\n</ul>\n";
        }
    }
    return implode( '', $out );
}

//add_shortcode( 'access', 'access_check_shortcode' );
function access_check_shortcode( $attr, $content = null ) {
	extract( shortcode_atts( array( 'capability' => 'read' ), $attr ) );
	if ( current_user_can( $capability ) && !is_null( $content ) && !is_feed() )
		return $content;
	return '';
}

function is_user_in_role( $attr ) {
	extract( shortcode_atts( array( 'capability' => 'read' ), $attr ) );
	if ( current_user_can( $capability ) && !is_feed() )
		return TRUE;
	return FALLSE;
}

function clean_custom_menu( $menu_name ) {
  if (TRUE) {
        $menu_list  = '<nav class="navbar navbar-default">' ."\n";
        $menu_list .= '<div class="container-fluid">' ."\n";
        $menu_list .= '<!-- Brand and toggle get grouped for better mobile display -->' ."\n";
        $menu_list .= '<div class="navbar-header">' ."\n";
        $menu_list .= '<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">' ."\n";
        $menu_list .= '<span class="sr-only">Toggle navigation</span>' ."\n";
        $menu_list .= '<span class="icon-bar"></span>' ."\n";
        $menu_list .= '<span class="icon-bar"></span>' ."\n";
        $menu_list .= '<span class="icon-bar"></span>' ."\n";
        $menu_list .= '</button>' ."\n";
        $menu_list .= '<a class="navbar-brand" href="' . home_url() . '">' . get_bloginfo( 'name' ) . '</a>';
        $menu_list .= '</div>' ."\n";

        $menu_list .= '<!-- Collect the nav links, forms, and other content for toggling -->';

        //$menu = get_term( $locations[$theme_location], 'nav_menu' );
        $menu_items = wp_get_nav_menu_items($menu_name);

        $menu_list .= '<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">' ."\n";
        $menu_list .= '<ul class="nav navbar-nav">' ."\n";

        foreach( $menu_items as $menu_item ) {
            if( $menu_item->menu_item_parent == 0 ) {

                $parent = $menu_item->ID;

                $menu_array = array();
                foreach( $menu_items as $submenu ) {
                    if( $submenu->menu_item_parent == $parent ) {
                        $bool = true;
                        $menu_array[] = '<li><a href="' . $submenu->url . '">' . $submenu->title . '</a></li>' ."\n";
                    }
                }
                if( $bool == true && count( $menu_array ) > 0 ) {

                    $menu_list .= '<li class="dropdown">' ."\n";
                    $menu_list .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">' . $menu_item->title . ' <span class="caret"></span></a>' ."\n";

                    $menu_list .= '<ul class="dropdown-menu">' ."\n";
                    $menu_list .= implode( "\n", $menu_array );
                    $menu_list .= '</ul>' ."\n";

                } else {

                    $menu_list .= '<li>' ."\n";
                    $menu_list .= '<a href="' . $menu_item->url . '">' . $menu_item->title . '</a>' ."\n";
                }
          }

            // end <li>
            $menu_list .= '</li>' ."\n";
        }

        $menu_list .= '</ul>' ."\n";
        $menu_list .= '</div>' ."\n";
        $menu_list .= '</div><!-- /.container-fluid -->' ."\n";
        $menu_list .= '</nav>' ."\n";

    } else {
        $menu_list = '<!-- not in authoring  -->';
    }

    echo $menu_list;
}

function bdr_authoring_menu( $menu_name ) {
    $menu_list = '<button type="button" class="hamburger is-closed" data-toggle="offcanvas">';
    $menu_list .= '    <span class="hamb-top"></span>';
    $menu_list .= '    <span class="hamb-middle"></span>';
    $menu_list .= '    <span class="hamb-bottom"></span>';
    $menu_list .= '</button>';

    $menu_list .= '<nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">';
    $menu_list .= '    <ul class="nav sidebar-nav">';
    $menu_list .= '        <li class="sidebar-brand">';
    $menu_list .= '            <a href="#">Authoring</a>';
    $menu_list .= '        </li>';

    $menu_list .= '<!-- Collect the nav links, forms, and other content for toggling -->';

    //$menu = get_term( $locations[$theme_location], 'nav_menu' );
    $menu_items = wp_get_nav_menu_items($menu_name);

    foreach( $menu_items as $menu_item ) {
        if( $menu_item->menu_item_parent == 0 ) {

            $parent = $menu_item->ID;

            $menu_array = array();
            foreach( $menu_items as $submenu ) {
                if( $submenu->menu_item_parent == $parent ) {
                    $bool = true;
                    $menu_array[] = '<li><a href="' . $submenu->url . '">' . $submenu->title . '</a></li>' ."\n";
                }
            }
            if( $bool == true && count( $menu_array ) > 0 ) {

                $menu_list .= '<li class="dropdown">' ."\n";
                $menu_list .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">' . $menu_item->title . ' <span class="caret"></span></a>' ."\n";

                $menu_list .= '<ul class="dropdown-menu dl-submenu">' ."\n";
                $menu_list .= '<li class="dl-back"><a href="#">back</a></li>';
                $menu_list .= implode( "\n", $menu_array );
                $menu_list .= '</ul>' ."\n";

            } else {

                $menu_list .= '<li>' ."\n";
                $menu_list .= '<a href="' . $menu_item->url . '">' . $menu_item->title . '</a>' ."\n";
            }
      }

        // end <li>
        $menu_list .= '</li>' ."\n";
    }

    $menu_list .= '</ul>' ."\n";
    $menu_list .= '</nav>' ."\n";

    return $menu_list;
}

function bdr_add_authoring_menu() {
    $menu_name = 'Authoring';

    if (current_user_can( 'edit_posts' )) {
        $content = '<div class="authoring-menu">';
        $content .= bdr_authoring_menu( $menu_name );
        $content .= '</div>';
        echo $content;
    } else {
        echo '<!-- not in authoring  -->';
    }
}

function bdr_add_category_to_single($classes) {
  if (is_single() ) {
    global $post;
    foreach((get_the_category($post->ID)) as $category) {
      // add category slug to the $classes array
      $classes[] = "cat-".$category->category_nicename;
    }
  }
  // return the $classes array
  return $classes;
}

/* Add custom stylesheet to editor */

function bdr_add_editor_styles() {
    add_editor_style( 'custom-editor-style.css' );
}

function bdr_mce_buttons_2( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
// Register our callback to the appropriate filter
add_filter( 'mce_buttons_2', 'bdr_mce_buttons_2' );


/*
* Callback function to filter the MCE settings
*/



function bdr_mce_before_init_insert_formats( $init_array ) {

    // Define the style_formats array
	$style_formats = array(
        /*
        * Each array child is a format with it's own settings
        * Notice that each array has title, block, classes, and wrapper arguments
        * Title is the label which will be visible in Formats menu
        * Block defines whether it is a span, div, selector, or inline style
        * Classes allows you to define CSS classes
        * Wrapper whether or not to add a new block-level element around any selected elements
        */
		array(
			'title' => 'Separateur',
			'block' => 'div',
			'classes' => 'clearfix wp-editor',
			'wrapper' => true,

		),
		array(
			'title' => 'Auteur: Sources',
			'block' => 'p',
			'classes' => 'sources',
			'wrapper' => false,
		)
	);
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = json_encode( $style_formats );

	return $init_array;

}
// Attach callback to 'tiny_mce_before_init'
add_filter( 'tiny_mce_before_init', 'bdr_mce_before_init_insert_formats' );
