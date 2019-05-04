<?php
add_action( 'after_setup_theme', 'envo_magazine_setup' );

if ( !function_exists( 'envo_magazine_setup' ) ) :

	/**
	 * Global functions
	 */
	function envo_magazine_setup() {

		// Theme lang.
		load_theme_textdomain( 'envo-magazine', get_template_directory() . '/languages' );

		// Add Title Tag Support.
		add_theme_support( 'title-tag' );

		// Register Menus.
		register_nav_menus(
			array(
				'main_menu' => esc_html__( 'Main Menu', 'envo-magazine' ),
				'top_menu_left' => esc_html__( 'Top Menu left', 'envo-magazine' ),
				'top_menu_right' => esc_html__( 'Top Menu right', 'envo-magazine' ),
			)
		);

		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 300, 300, true );
		add_image_size( 'envo-magazine-single', 1140, 641, true );
		add_image_size( 'envo-magazine-med', 720, 405, true );
		add_image_size( 'envo-magazine-thumbnail', 160, 120, true );

		// Add Custom Background Support.
		$args = array(
			'default-color' => 'ffffff',
		);
		add_theme_support( 'custom-background', $args );

		add_theme_support( 'custom-logo', array(
			'height'		 => 60,
			'width'			 => 200,
			'flex-height'	 => true,
			'flex-width'	 => true,
			'header-text'	 => array( 'site-title', 'site-description' ),
		) );

		// Adds RSS feed links to for posts and comments.
		add_theme_support( 'automatic-feed-links' );
		
		// Set the default content width.
		$GLOBALS['content_width'] = 1140;
		
		add_theme_support( 'custom-header', apply_filters( 'envo_magazine_custom_header_args', array(
			'width'                  => 2000,
			'height'                 => 200,
			'wp-head-callback'       => 'envo_magazine_header_style',
		) ) );
		
		// WooCommerce support.
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
  		add_theme_support( 'wc-product-gallery-lightbox' );
  		add_theme_support( 'wc-product-gallery-slider' );
		
		/*
		* This theme styles the visual editor to resemble the theme style,
		* specifically font, colors, icons, and column width.
		*/
	   add_editor_style( array( 'css/bootstrap.css', envo_magazine_fonts_url(), 'css/editor-style.css' ) );
	}

endif;

if ( ! function_exists( 'envo_magazine_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog.
 */
function envo_magazine_header_style() {
	$header_image = get_header_image();
	$header_text_color = get_header_textcolor();
	// If no custom options for text are set, let's bail.
	if ( empty( $header_image ) && display_header_text() == true ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css" id="envo-magazine-header-css">
	<?php
		// Has a Custom Header been added?
		if ( ! empty( $header_image ) ) :
	?>
		.site-header {
			background-image: url(<?php header_image(); ?>);
			background-repeat: no-repeat;
			background-position: 50% 50%;
			-webkit-background-size: cover;
			-moz-background-size:    cover;
			-o-background-size:      cover;
			background-size:         cover;
		}
		.site-title a, .site-title, .site-description {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
	<?php endif; ?>
	<?php
		// Has the text been hidden?
		if ( display_header_text() !== true ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		endif;
	?>	
	</style>
	<?php
}
endif; // envo_magazine_header_style

/**
 * Set Content Width
 */
function envo_magazine_content_width() {
	
	$content_width = $GLOBALS['content_width'];

	// Get layout.
	$page_layout = get_theme_mod( 'content-width', '1170' );
	
	if ( is_active_sidebar( 'envo-magazine-right-sidebar' ) ) {
		if ( '980' === $page_layout ) {
			$content_width = 623;
		} elseif ( '1024' === $page_layout ) {
			$content_width = 652;
		} elseif ( '1170' === $page_layout ) {
			$content_width = 750;
		} elseif ( '1280' === $page_layout ) {
			$content_width = 823;
		} elseif ( '1440' === $page_layout ) {
			$content_width = 930;
		}
	} else {
		if ( '980' === $page_layout ) {
			$content_width = 950;
		} elseif ( '1024' === $page_layout ) {
			$content_width = 994;
		} elseif ( '1170' === $page_layout ) {
			$content_width = 1040;
		} elseif ( '1280' === $page_layout ) {
			$content_width = 1250;
		} elseif ( '1440' === $page_layout ) {
			$content_width = 1410;
		}
	}

	/**
	 * Filter Twenty Seventeen content width of the theme.
	 *
	 * @since Twenty Seventeen 1.0
	 *
	 * @param int $content_width Content width in pixels.
	 */
	$GLOBALS['content_width'] = apply_filters( 'envo_magazine_content_width', $content_width );
}

add_action( 'template_redirect', 'envo_magazine_content_width', 0 );

/**
 * Register custom fonts.
 */
function envo_magazine_fonts_url() {
	$fonts_url = '';

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Roboto Condensed, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$roboto_condensed = _x( 'on', 'Roboto Condensed font: on or off', 'envo-magazine' );

	if ( 'off' !== $roboto_condensed ) {
		$font_families = array();

		$font_families[] = 'Roboto Condensed:300,400,700';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Enqueue Styles (normal style.css and bootstrap.css)
 */
function envo_magazine_theme_stylesheets() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'envo-magazine-fonts', envo_magazine_fonts_url(), array(), null );
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '3.3.7' );
	// Theme stylesheet.
	wp_enqueue_style( 'envo-magazine-stylesheet', get_stylesheet_uri(), array('bootstrap'), '1.3.4'  );
	// Load Font Awesome css.
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.7.0' );
}

add_action( 'wp_enqueue_scripts', 'envo_magazine_theme_stylesheets' );

/**
 * Register Bootstrap JS with jquery
 */
function envo_magazine_theme_js() {
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '3.3.7', true );
	wp_enqueue_script( 'envo-magazine-theme-js', get_template_directory_uri() . '/js/customscript.js', array( 'jquery' ), '1.3.4', true );
}

add_action( 'wp_enqueue_scripts', 'envo_magazine_theme_js' );


/**
 * Register Custom Navigation Walker include custom menu widget to use walkerclass
 */
require_once( trailingslashit( get_template_directory() ) . 'lib/wp_bootstrap_navwalker.php' );

/**
 * Widgets
 */
require_once( trailingslashit( get_template_directory() ) . 'includes/widgets.php' );

/**
 * Register Theme Info Page
 */
require_once( trailingslashit( get_template_directory() ) . 'lib/dashboard.php' );

/**
 * Register PRO notify
 */
require_once( trailingslashit( get_template_directory() ) . 'lib/customizer.php' );

add_action( 'widgets_init', 'envo_magazine_widgets_init' );

/**
 * Register the Sidebar(s)
 */
function envo_magazine_widgets_init() {
	register_sidebar(
		array(
			'name'			 => esc_html__( 'Homepage Full Width Section #1', 'envo-magazine' ),
			'id'			 => 'envo-magazine-homepage-area',
			'before_widget'	 => '<div id="%1$s" class="widget %2$s">',
			'after_widget'	 => '</div>',
			'before_title'	 => '<div class="widget-title"><h3>',
			'after_title'	 => '</h3></div>',
		)
	);
	register_sidebar(
		array(
			'name'			 => esc_html__( 'Homepage Row #1 - 2/3 Section', 'envo-magazine' ),
			'id'			 => 'envo-magazine-homepage-area-2',
			'before_widget'	 => '<div id="%1$s" class="widget %2$s">',
			'after_widget'	 => '</div>',
			'before_title'	 => '<div class="widget-title"><h3>',
			'after_title'	 => '</h3></div>',
		)
	);
	register_sidebar(
		array(
			'name'			 => esc_html__( 'Homepage Row #1 - 1/3 Section', 'envo-magazine' ),
			'id'			 => 'envo-magazine-homepage-area-2-sidebar',
			'before_widget'	 => '<div id="%1$s" class="widget %2$s">',
			'after_widget'	 => '</div>',
			'before_title'	 => '<div class="widget-title"><h3>',
			'after_title'	 => '</h3></div>',
		)
	);
	register_sidebar(
		array(
			'name'			 => esc_html__( 'Homepage Full Width Section #2', 'envo-magazine' ),
			'id'			 => 'envo-magazine-homepage-area-3',
			'before_widget'	 => '<div id="%1$s" class="widget %2$s">',
			'after_widget'	 => '</div>',
			'before_title'	 => '<div class="widget-title"><h3>',
			'after_title'	 => '</h3></div>',
		)
	);
	register_sidebar(
		array(
			'name'			 => esc_html__( 'Homepage Row #2 - 2/3 Section', 'envo-magazine' ),
			'id'			 => 'envo-magazine-homepage-area-4',
			'before_widget'	 => '<div id="%1$s" class="widget %2$s">',
			'after_widget'	 => '</div>',
			'before_title'	 => '<div class="widget-title"><h3>',
			'after_title'	 => '</h3></div>',
		)
	);
	register_sidebar(
		array(
			'name'			 => esc_html__( 'Homepage Row #2 - 1/3 Section', 'envo-magazine' ),
			'id'			 => 'envo-magazine-homepage-area-4-sidebar',
			'before_widget'	 => '<div id="%1$s" class="widget %2$s">',
			'after_widget'	 => '</div>',
			'before_title'	 => '<div class="widget-title"><h3>',
			'after_title'	 => '</h3></div>',
		)
	);
	register_sidebar(
		array(
			'name'			 => esc_html__( 'Homepage Full Width Section #3', 'envo-magazine' ),
			'id'			 => 'envo-magazine-homepage-area-5',
			'before_widget'	 => '<div id="%1$s" class="widget %2$s">',
			'after_widget'	 => '</div>',
			'before_title'	 => '<div class="widget-title"><h3>',
			'after_title'	 => '</h3></div>',
		)
	);
	register_sidebar(
		array(
			'name'			 => esc_html__( 'Right Sidebar', 'envo-magazine' ),
			'id'			 => 'envo-magazine-right-sidebar',
			'before_widget'	 => '<div id="%1$s" class="widget %2$s">',
			'after_widget'	 => '</div>',
			'before_title'	 => '<div class="widget-title"><h3>',
			'after_title'	 => '</h3></div>',
		)
	);
	register_sidebar(
		array(
			'name'			 => esc_html__( 'Header Section', 'envo-magazine' ),
			'id'			 => 'envo-magazine-header-area',
			'before_widget'	 => '<div id="%1$s" class="widget %2$s">',
			'after_widget'	 => '</div>',
			'before_title'	 => '<div class="widget-title"><h3>',
			'after_title'	 => '</h3></div>',
		)
	);
	register_sidebar(
		array(
			'name'			 => esc_html__( 'Footer Section', 'envo-magazine' ),
			'id'			 => 'envo-magazine-footer-area',
			'before_widget'	 => '<div id="%1$s" class="widget %2$s col-md-3">',
			'after_widget'	 => '</div>',
			'before_title'	 => '<div class="widget-title"><h3>',
			'after_title'	 => '</h3></div>',
		)
	);
}

function envo_magazine_main_content_width_columns() {

	$columns = '12';

	if ( is_active_sidebar( 'envo-magazine-right-sidebar' ) ) {
		$columns = $columns - 4;
	}

	echo absint( $columns );
}

if ( !function_exists( 'envo_magazine_entry_footer' ) ) :

	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function envo_magazine_entry_footer() {

		// Get Categories for posts.
		$categories_list = get_the_category_list( ' ' );

		// Get Tags for posts.
		$tags_list = get_the_tag_list( '', ' ' );

		// We don't want to output .entry-footer if it will be empty, so make sure its not.
		if ( $categories_list || $tags_list || get_edit_post_link() ) {

			echo '<div class="entry-footer">';

			if ( 'post' === get_post_type() ) {
				if ( $categories_list || $tags_list ) {

					// Make sure there's more than one category before displaying.
					if ( $categories_list ) {
						echo '<div class="cat-links"><span class="space-right">' . esc_html__( 'Category', 'envo-magazine' ) . '</span>' . wp_kses_data( $categories_list ) . '</div>';
					}

					if ( $tags_list ) {
						echo '<div class="tags-links"><span class="space-right">' . esc_html__( 'Tags', 'envo-magazine' ) . '</span>' . wp_kses_data( $tags_list ) . '</div>';
					}
				}
			}

			edit_post_link();

			echo '</div>';
		}
	}

endif;

if ( !function_exists( 'envo_magazine_generate_construct_footer' ) ) :
	/**
	 * Build footer
	 */
	add_action( 'envo_magazine_generate_footer', 'envo_magazine_generate_construct_footer' );

	function envo_magazine_generate_construct_footer() {
		?>
		<div class="footer-credits-text text-center">
			<?php 
			/* translators: %s: WordPress name with wordpress.org URL */
			printf( esc_html__( 'Proudly powered by %s', 'envo-magazine' ), '<a href="' . esc_url( __( 'https://wordpress.org/', 'envo-magazine' ) ) . '">WordPress</a>' );
			?>
			<span class="sep"> | </span>
			<?php 
			/* translators: %1$s: Envo Magazine name with envothemes.com URL */
			printf( esc_html__( 'Theme: %1$s', 'envo-magazine' ), '<a href="' . esc_url( 'https://envothemes.com/' ) . '">Envo Magazine</a>' );
			?>
		</div> 
		<?php
	}

endif;

if ( ! function_exists( 'envo_magazine_get_the_excerpt' ) ) :

	/**
	 * Returns post excerpt.
	 */
	function envo_magazine_get_the_excerpt( $length = 0, $post_object = null ) {
		global $post;

		if ( is_null( $post_object ) ) {
			$post_object = $post;
		}

		$length = absint( $length );
		if ( 0 === $length ) {
			return;
		}

		$source_content = $post_object->post_content;

		if ( ! empty( $post_object->post_excerpt ) ) {
			$source_content = $post_object->post_excerpt;
		}

		$source_content = strip_shortcodes( $source_content );
		$trimmed_content = wp_trim_words( $source_content, $length, '...' );
		return $trimmed_content;
	}

endif;

if ( ! function_exists( 'envo_magazine_widget_date_comments' ) ) :

	/**
	 * Returns date for widgets.
	 */
	function envo_magazine_widget_date_comments( ) {
	?>
	<span class="posted-date">
		<?php echo esc_html( get_the_date() ); ?>
	</span>
	<span class="comments-meta">
		<?php
			if ( !comments_open() ) 
				{ esc_html_e('Off','envo-magazine'); }
			else { ?>
				<a href="<?php the_permalink(); ?>#comments" rel="nofollow" title="<?php esc_attr_e( 'Comment on ', 'envo-magazine' ) . the_title_attribute(); ?>">
					<?php echo absint( get_comments_number() ); ?>
				</a>
			<?php } ?>
		<i class="fa fa-comments-o"></i>
	</span>
	<?php
	}

endif;

if ( ! function_exists( 'envo_magazine_excerpt_length' ) ) :
	/**
	 * Excerpt limit.
	 */
	function envo_magazine_excerpt_length( $length ) {
		return 20;
	}

	add_filter( 'excerpt_length', 'envo_magazine_excerpt_length', 999 );
	
endif;

if ( ! function_exists( 'envo_magazine_excerpt_more' ) ) :
	/**
	 * Excerpt more.
	 */
	function envo_magazine_excerpt_more( $more ) {
		return '&hellip;';
	}
	
	add_filter( 'excerpt_more', 'envo_magazine_excerpt_more' );
	
endif;

if ( ! function_exists( 'envo_magazine_thumb_img' ) ) :

	/**
	 * Returns widget thumbnail.
	 */
	function envo_magazine_thumb_img( $img = 'full', $col = '', $link = true, $single = false ) {
		if ( function_exists( 'envo_magazine_pro_thumb_img' ) ) {
			envo_magazine_pro_thumb_img( $img, $col, $link, $single );
		} elseif ( ( has_post_thumbnail() && $link == true ) ) { ?>
			<div class="news-thumb <?php echo esc_attr( $col ); ?>">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
					<img src="<?php the_post_thumbnail_url( $img ); ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>" />
				</a>
			</div><!-- .news-thumb -->
		<?php } elseif ( has_post_thumbnail() ) { ?>
			<div class="news-thumb <?php echo esc_attr( $col ); ?>">
				<img src="<?php the_post_thumbnail_url( $img ); ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>" />
			</div><!-- .news-thumb -->	
		<?php
		}
	}

endif;

/**
 * Check if the category ID exists. If not return default category
 */
if ( ! function_exists( 'envo_magazine_check_cat' ) ) :
	function envo_magazine_check_cat( $catid ) {
		$cat_to_check = get_term_by( 'id', $catid, 'category' );
		if ( $cat_to_check ) {
			return absint( $catid );
		} else {
			return '0';
		}
	}
endif;
/**
 * Single previous next links
 */
if ( ! function_exists( 'envo_magazine_prev_next_links' ) ) :
	
	function envo_magazine_prev_next_links() {
		$prevPost = get_previous_post();
		$nextPost = get_next_post();
		?>
		<div class="prev-next-links">
		<?php	
		if ( !empty( $prevPost ) ) { 
		$prevthumbnail = get_the_post_thumbnail( $prevPost->ID, 'envo-magazine-thumbnail' );	
			?>
			<div class="arrowLeft">
				<?php previous_post_link('%link', '<i class="fa fa-angle-double-left fa-2x" aria-hidden="true"></i>'); ?>
				<div class="prev-next-links-thumb">
					<?php previous_post_link('%link', $prevthumbnail ); ?>
				</div>
				<div class="prev-next-links-title">
					<?php previous_post_link('%link' ); ?>
				</div>	
			</div>
		<?php } 
		if ( !empty( $nextPost ) ) { 
		$nextthumbnail = get_the_post_thumbnail( $nextPost->ID, 'envo-magazine-thumbnail' );
			?>	
			<div class="arrowRight">
				<?php next_post_link('%link', '<i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>'); ?>
				<div class="prev-next-links-thumb">
					<?php next_post_link('%link', $nextthumbnail ); ?>
				</div>
				<div class="prev-next-links-title">
					<?php next_post_link('%link' ); ?>
				</div>	
			</div>
		
		<?php } ?>
		</div>
		<?php
	}
endif;

/**
 * Post title funciton
 */
if ( ! function_exists( 'envo_magazine_the_title' ) ) :
	function envo_magazine_the_title( ) {
		if ( function_exists( 'envo_magazine_pro_the_title' ) ) {
			envo_magazine_pro_the_title( );
		} else {
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}
	}
endif;

/**
 * Post author meta funciton
 */
if ( ! function_exists( 'envo_magazine_author_meta' ) ) :
	function envo_magazine_author_meta( ) {
	?>
		<span class="author-meta">
			<span class="author-meta-by"><?php esc_html_e( 'By', 'envo-magazine' ); ?></span>
			<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) ); ?>">
				<?php the_author(); ?>
			</a>
		</span>
	<?php	
	}
endif;

/**
 * Display random widgets
 */
function envo_magazine_home_widgets() {
	$number = 5;
	$categories	 = get_categories();
	$view_all_text = esc_html__( 'View All', 'envo-magazine' );
	if ( $number > count( $categories ) )
		$number	= count( $categories );

	// If no categories are available or none were requested, return an empty array
	if ( $number === 0 ) 
		return array();
	shuffle( $categories );
	foreach ( $categories as $key ) {
		$cat[]	 = $key->term_id;
		$name[]	 = $key->name;
	}
	$number_cat = $number - 1;
	$random_cat1 = rand(0, $number_cat);
	$random_cat2 = rand(0, $number_cat);
	$random_cat3 = rand(0, $number_cat);
	if ( (!is_active_sidebar( 'envo-magazine-homepage-area' ) && !is_active_sidebar( 'envo-magazine-homepage-area-2' ) && !is_active_sidebar( 'envo-magazine-homepage-area-2-sidebar' ) && !is_active_sidebar( 'envo-magazine-homepage-area-3' ) && !is_active_sidebar( 'envo-magazine-homepage-area-4' ) && !is_active_sidebar( 'envo-magazine-homepage-area-4-sidebar' ) && !is_active_sidebar( 'envo-magazine-homepage-area-5' ) ) || envo_magazine_is_preview() ) {
		?>
		<div class="homepage-main-content-page">
			<div class="homepage-area"> 
				<?php
				the_widget( 'envo_magazine_split_images_News', 'title=', 'before_title=<div class="widget-title"><h3>&after_title=</h3></div>&before_widget=<div class="widget widget_recent_entries">&after_widget=</div>' );
				?>
			</div>
			<div class="row">
				<div class="homepage-area-2 col-md-8">
					<?php
					the_widget( 'envo_magazine_Featured_Column_News', 'view_all_text=' . $view_all_text . '&mix_category=' . $cat[absint($random_cat1)] . '&title=' . $name[absint($random_cat1)], '&before_title=<div class="widget-title"><h3>&after_title=</h3></div>&before_widget=<div class="widget widget_recent_entries">&after_widget=</div>' );
					?>
				</div>	
				<div class="homepage-area-2-sidebar col-md-4">	
					<?php
					the_widget( 'envo_magazine_Extended_Recent_Posts', 'title=' . esc_html__( 'Recent Posts', 'envo-magazine' ), 'before_title=<div class="widget-title"><h3>&after_title=</h3></div>&before_widget=<div class="widget widget_recent_entries">&after_widget=</div>' );
					?>
				</div>
			</div>
			<div class="homepage-area-3">
				<?php
				the_widget( 'envo_magazine_Three_Column_News', 'view_all_text=' . $view_all_text . '&mix_category='.$cat[absint($random_cat2)].'&title=' . $name[absint($random_cat2)], 'before_title=<div class="widget-title"><h3>&after_title=</h3></div>&before_widget=<div class="widget widget_recent_entries">&after_widget=</div>' );
				?>
			</div>
			<div class="row">
				<div class="homepage-area-area-4 col-md-8">
					<?php
					the_widget( 'envo_magazine_Mix_Column_News', 'view_all_text=' . $view_all_text . '&mix_category='.$cat[absint($random_cat3)].'&title=' . $name[absint($random_cat3)], 'before_title=<div class="widget-title"><h3>&after_title=</h3></div>&before_widget=<div class="widget widget_recent_entries">&after_widget=</div>' );
					?>
				</div>	
				<div class="homepage-area-area-4-sidebar col-md-4">
					<?php
					the_widget( 'envo_magazine_Popular_Posts', 'title=' . esc_html__( 'Popular posts', 'envo-magazine' ), 'before_title=<div class="widget-title"><h3>&after_title=</h3></div>&before_widget=<div class="widget widget_recent_entries">&after_widget=</div>' );
					?>
				</div>
			</div>
		</div> 
		<?php
	} else {
		get_template_part( 'template-parts/homepage', 'widgets' );
	}
}

function envo_magazine_is_preview() {
	return false;
}