
// Sends the post_id and receives whether the post will be blocked on the paywall
$posts_closed = apply_filters( 'abril_remove_posts_of_closed_taxonomy', $post->ID );

function remove_posts_of_closed_taxonomy( $id ) {
    $exclude_taxonomies = apply_filters( 'exclude_paywall_of_taxonomies', array() );
    $tax_blockeds = get_option('option_fields')['tab-piano']['blocked_blogs'];
    $term_list = get_the_terms($id, $exclude_taxonomies);
    $remove_term = false;

    if ( is_array( $term_list ) ) {
        foreach ( $tax_blockeds as $tax ) {
            foreach ( $term_list as $term ) {           
                if ( $term->slug === $tax ) {
                    $remove_term = true;
                }
            }
        }
    }

    return $remove_term;
}

add_filter( 'abril_remove_posts_of_closed_taxonomy', 'remove_posts_of_closed_taxonomy' );
