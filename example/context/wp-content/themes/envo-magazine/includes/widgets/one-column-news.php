<?php
/**
 * Custom widgets.
 *
 */
if ( !class_exists( 'envo_magazine_one_Column_News' ) ) :

	/**
	 * Two Column News widget class.
	 *
	 */
	class envo_magazine_one_Column_News extends WP_Widget {

		function __construct() {
			$opts = array(
				'classname'		 => 'one-col-section',
				'description'	 => esc_html__( 'Widget to display news in one column layout.', 'envo-magazine' ),
			);

			parent::__construct( 'envo-magazine-one-column-news', esc_html__( 'Envo Magazine: One column news', 'envo-magazine' ), $opts );
		}

		function widget( $args, $instance ) {

			$title = apply_filters( 'widget_title', empty( $instance[ 'title' ] ) ? '' : $instance[ 'title' ], $instance, $this->id_base );

			$one_category = !empty( $instance[ 'one_category' ] ) ? $instance[ 'one_category' ] : 0;

			$view_all_text = !empty( $instance[ 'view_all_text' ] ) ? $instance[ 'view_all_text' ] : '';

			$post_number = !empty( $instance[ 'post_number' ] ) ? $instance[ 'post_number' ] : 6;

			$excerpt_length = !empty( $instance[ 'excerpt_length' ] ) ? $instance[ 'excerpt_length' ] : 30;

			echo $args[ 'before_widget' ];
			?>

			<div class="one-news-section">

				<div class="section-title">

					<?php
					if ( !empty( $title ) ) {
						echo $args[ 'before_title' ] . esc_html( $title ) . $args[ 'after_title' ];
					}
					$one_category = envo_magazine_check_cat( $one_category );
					if ( !empty( $view_all_text ) ) {
						$page_for_posts = get_option( 'page_for_posts' );
						if ( absint( $one_category ) > 0 ) {

							$cat_link = get_category_link( $one_category );
						} elseif ( isset( $page_for_posts ) && ( $page_for_posts != '' ) && ( $page_for_posts != '0' ) ) {

							$cat_link = get_permalink( $page_for_posts );
						} else {

							$cat_link = '';
						}
						if ( !empty( $cat_link ) ) {
							?>

							<a href="<?php echo esc_url( $cat_link ); ?>"><?php echo esc_html( $view_all_text ); ?></a>

							<?php
						}
					}
					?>

				</div>

				<div class="inner-wrapper">
					<?php
					$one_args = array(
						'posts_per_page'		 => absint( $post_number ),
						'no_found_rows'			 => true,
						'post__not_in'			 => get_option( 'sticky_posts' ),
						'ignore_sticky_posts'	 => true,
					);

					if ( absint( $one_category ) > 0 ) {

						$one_args[ 'cat' ] = absint( $one_category );
					}


					$one_posts = new WP_Query( $one_args );

					if ( $one_posts->have_posts() ) :


						while ( $one_posts->have_posts() ) :

							$one_posts->the_post();
							?>

							<div class="news-item row">
								<?php envo_magazine_thumb_img( 'envo-magazine-med', 'col-md-6' ); ?>
								<div class="news-text-wrap col-md-6">
									<?php envo_magazine_widget_date_comments(); ?>
									<?php envo_magazine_the_title(); ?>
									<?php envo_magazine_author_meta(); ?>

									<div class="post-excerpt">
										<?php
										$first_content = envo_magazine_get_the_excerpt( absint( $excerpt_length ) );
										echo wp_kses_post( $first_content ) ? wp_kses_post( wpautop( $first_content ) ) : '';
										?>
									</div><!-- .post-excerpt -->

								</div><!-- .news-text-wrap -->

							</div><!-- .news-item -->

							<?php
						endwhile;

						wp_reset_postdata();
						?>

					<?php endif; ?>
				</div><!-- .inner-wrapper -->

			</div><!-- .mix-column-news -->

			<?php
			echo $args[ 'after_widget' ];
		}

		function update( $new_instance, $old_instance ) {
			$instance						 = $old_instance;
			$instance[ 'title' ]			 = sanitize_text_field( $new_instance[ 'title' ] );
			$instance[ 'one_category' ]		 = absint( $new_instance[ 'one_category' ] );
			$instance[ 'view_all_text' ]	 = sanitize_text_field( $new_instance[ 'view_all_text' ] );
			$instance[ 'post_number' ]		 = absint( $new_instance[ 'post_number' ] );
			$instance[ 'excerpt_length' ]	 = absint( $new_instance[ 'excerpt_length' ] );

			return $instance;
		}

		function form( $instance ) {

			$instance	 = wp_parse_args( (array) $instance, array(
				'title'			 => '',
				'one_category'	 => '',
				'view_all_text'	 => esc_html__( 'View All', 'envo-magazine' ),
				'post_number'	 => 6,
				'excerpt_length' => 30,
			) );
			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'envo-magazine' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance[ 'title' ] ); ?>" />
			</p>


			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'one_category' ) ); ?>"><strong><?php esc_html_e( 'Category:', 'envo-magazine' ); ?></strong></label>
				<?php
				$cat_args	 = array(
					'orderby'			 => 'name',
					'hide_empty'		 => 0,
					'class'				 => 'widefat',
					'taxonomy'			 => 'category',
					'name'				 => $this->get_field_name( 'one_category' ),
					'id'				 => $this->get_field_id( 'one_category' ),
					'selected'			 => absint( $instance[ 'one_category' ] ),
					'show_option_all'	 => esc_html__( 'All Categories', 'envo-magazine' ),
				);
				wp_dropdown_categories( $cat_args );
				?>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'view_all_text' ) ); ?>"><strong><?php esc_html_e( 'View all text:', 'envo-magazine' ); ?></strong></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'view_all_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'view_all_text' ) ); ?>" type="text" value="<?php echo esc_attr( $instance[ 'view_all_text' ] ); ?>" />
				<small>
					<?php esc_html_e( 'To hide it, leave this field empty.', 'envo-magazine' ); ?>   
				</small>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_name( 'excerpt_length' ) ); ?>">
					<?php esc_html_e( 'Excerpt length:', 'envo-magazine' ); ?>
				</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'excerpt_length' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt_length' ) ); ?>" type="number" value="<?php echo absint( $instance[ 'excerpt_length' ] ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'post_number' ) ); ?>"><strong><?php esc_html_e( 'Number of posts:', 'envo-magazine' ); ?></strong></label>
				<?php
				$this->dropdown_post_number( array(
					'id'		 => $this->get_field_id( 'post_number' ),
					'name'		 => $this->get_field_name( 'post_number' ),
					'selected'	 => absint( $instance[ 'post_number' ] ),
				)
				);
				?>
			</p>

			<?php
		}

		function dropdown_post_number( $args ) {
			$defaults = array(
				'id'		 => '',
				'name'		 => '',
				'selected'	 => 0,
			);

			$r		 = wp_parse_args( $args, $defaults );
			$output	 = '';

			$choices = array(
				'1'	 => 1,
				'2'	 => 2,
				'3'	 => 3,
				'4'	 => 4,
				'5'	 => 5,
				'6'	 => 6,
				'7'	 => 7,
				'8'	 => 8,
				'9'	 => 9,
				'10' => 10,
			);

			if ( !empty( $choices ) ) {

				$output = "<select name='" . esc_attr( $r[ 'name' ] ) . "' id='" . esc_attr( $r[ 'id' ] ) . "'>\n";
				foreach ( $choices as $key => $choice ) {
					$output .= '<option value="' . esc_attr( $key ) . '" ';
					$output .= selected( $r[ 'selected' ], $key, false );
					$output .= '>' . esc_html( $choice ) . '</option>\n';
				}
				$output .= "</select>\n";
			}

			echo $output;
		}

	}

	

	

	

	

	

endif;

