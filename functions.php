<?php
// Add custom functions here

wp_register_script( 'bdrumes-js', get_stylesheet_directory_uri().'/assets/js/bdrumes.js', 'jquery', "1.0", true);

wp_register_script( 'slick-js', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js', null, null, true);
wp_register_style( 'slick-css', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css', array(), null);
wp_register_style( 'slick-theme', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick-theme.css', array(), null);


wp_enqueue_script( 'bdrumes-js' );
wp_enqueue_script( 'slick-js' );
wp_enqueue_style( 'slick-css' );
wp_enqueue_style( 'slick-theme' );


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