<?php
/**
 * Custom widgets.
 *
 * @package PT_Magazine
 */
if ( !class_exists( 'envo_magazine_Popular_Posts' ) ) :

	/**
	 * Popular posts widget class.
	 *
	 * @since 1.0.0
	 */
	class envo_magazine_Popular_Posts extends WP_Widget {

		function __construct() {
			$opts = array(
				'classname'		 => 'popular-posts widget_popular_posts',
				'description'	 => esc_html__( 'Widget to display popular posts with thumbnail and date. Recommended to be used in sidebar or footer.', 'envo-magazine' ),
			);

			parent::__construct( 'envo-magazine-popular-posts', esc_html__( 'Envo Magazine: Popular posts', 'envo-magazine' ), $opts );
		}

		function widget( $args, $instance ) {

			$title = apply_filters( 'widget_title', empty( $instance[ 'title' ] ) ? '' : $instance[ 'title' ], $instance, $this->id_base );

			$post_number = !empty( $instance[ 'post_number' ] ) ? $instance[ 'post_number' ] : 4;

			echo $args[ 'before_widget' ];
			?>

			<div class="popular-news-section">

				<?php
				if ( !empty( $title ) ) {
					echo $args[ 'before_title' ] . esc_html( $title ) . $args[ 'after_title' ];
				}
				?>


					<?php
					$popular_args = array(
						'posts_per_page'		 => absint( $post_number ),
						'no_found_rows'			 => true,
						'post__not_in'			 => get_option( 'sticky_posts' ),
						'ignore_sticky_posts'	 => true,
						'post_status'			 => 'publish',
						'orderby'				 => 'comment_count',
						'order'					 => 'desc',
					);

					$popular_posts = new WP_Query( $popular_args );

					if ( $popular_posts->have_posts() ) :


						while ( $popular_posts->have_posts() ) :

							$popular_posts->the_post();
							?>

							<div class="news-item layout-two">
								<?php envo_magazine_thumb_img( 'envo-magazine-thumbnail' ); ?>
								<div class="news-text-wrap">
									<?php envo_magazine_the_title(); ?>
									<?php envo_magazine_widget_date_comments(); ?>
								</div><!-- .news-text-wrap -->
							</div><!-- .news-item -->

							<?php
						endwhile;

						wp_reset_postdata();
						?>

					<?php endif; ?>

				</div>

				<?php
				echo $args[ 'after_widget' ];
			}

			function update( $new_instance, $old_instance ) {
				$instance					 = $old_instance;
				$instance[ 'title' ]		 = sanitize_text_field( $new_instance[ 'title' ] );
				$instance[ 'post_number' ]	 = absint( $new_instance[ 'post_number' ] );

				return $instance;
			}

			function form( $instance ) {

				$instance = wp_parse_args( (array) $instance, array(
					'title'			 => esc_html__( 'Popular posts', 'envo-magazine' ),
					'post_number'	 => 5,
				) );
				?>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'envo-magazine' ); ?></label>
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance[ 'title' ] ); ?>" />
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_name( 'post_number' ) ); ?>">
						<?php esc_html_e( 'Number of posts:', 'envo-magazine' ); ?>
					</label>
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'post_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_number' ) ); ?>" type="number" value="<?php echo absint( $instance[ 'post_number' ] ); ?>" />
				</p>

				<?php
			}

		}

endif;
