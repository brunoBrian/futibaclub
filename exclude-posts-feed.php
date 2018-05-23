function abril_paywall_exclude_closed_posts_feeds( $query ) {
		if ( ! is_admin() && $query->is_main_query() && is_feed() ):
			$closed_paywall_posts = abril_paywall_get_closed_posts();
			$query->set( 'post__not_in', $closed_paywall_posts );
		endif;
	}

	add_action( 'pre_get_posts', 'abril_paywall_exclude_closed_posts_feeds' );

	function abril_paywall_get_closed_posts() {

		$closed_paywall_posts = array();

		$args = array(
			'es'         => Abril_Utils::abril_is_wpcom(),
			'meta_query' => array(
				array(
					'key'     => 'tipo_paywall',
					'value'   => 'closed',
					'compare' => '=',
				),
			),
		);

		if ( function_exists( 'abril_piano_get_marca_post_types_allowed' ) ) {
			$post_types        = abril_piano_get_marca_post_types_allowed();
			$args['post_type'] = $post_types;
		}

		$paywall_query = new WP_Query( $args );

		if ( $paywall_query->have_posts() ) {

			while ( $paywall_query->have_posts() ) {
				$paywall_query->the_post();
				array_push( $closed_paywall_posts, get_the_ID() );
			}
			wp_reset_postdata();
		}

		return $closed_paywall_posts;

	}
