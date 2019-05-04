<?php
/**
 * Custom widgets.
 *
 * @package PT_Magazine
 */

if ( ! function_exists( 'envo_magazine_load_widgets' ) ) :

	/**
	 * Load widgets.
	 *
	 * @since 1.0.0
	 */
	function envo_magazine_load_widgets() {


		// Two Column news.
		register_widget( 'envo_magazine_Two_Column_News' );

		// Mix Column news.
		register_widget( 'envo_magazine_Mix_Column_News' );

		// Three Column news.
		register_widget( 'envo_magazine_Three_Column_News' );

		// Featured Column news.
		register_widget( 'envo_magazine_Featured_Column_News' );

		// Extended Recent Post.
		register_widget( 'envo_magazine_Extended_Recent_Posts' );

		// Popular Post.
		register_widget( 'envo_magazine_Popular_Posts' );
		
		// One Column news.
		register_widget( 'envo_magazine_one_Column_News' );
		
		// Spit images news.
		register_widget( 'envo_magazine_split_images_News' );

	}

endif;

add_action( 'widgets_init', 'envo_magazine_load_widgets' );

/**
 * Two Column News Widget
 */
require get_template_directory() . '/includes/widgets/two-column-news.php';

/**
 * Mix Column News Widget
 */
require get_template_directory() . '/includes/widgets/mix-column-news.php';

/**
 * Three Column News Widget
 */
require get_template_directory() . '/includes/widgets/three-column-news.php';

/**
 * Featured Column News Widget
 */
require get_template_directory() . '/includes/widgets/featured-column-news.php';

/**
 * Recent Posts Widget
 */
require get_template_directory() . '/includes/widgets/recent-posts.php';

/**
 * Popular Posts Widget
 */
require get_template_directory() . '/includes/widgets/popular-posts.php';

/**
 * One Column News Widget
 */
require get_template_directory() . '/includes/widgets/one-column-news.php';

/**
 * Split Images News Widget
 */
require get_template_directory() . '/includes/widgets/split-images-news.php';