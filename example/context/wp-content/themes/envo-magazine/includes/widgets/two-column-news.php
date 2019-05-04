<?php
/**
 * Custom widgets.
 *
 */
if ( !class_exists( 'envo_magazine_Two_Column_News' ) ) :

	/**
	 * Two Column News widget class.
	 *
	 */
	class envo_magazine_Two_Column_News extends WP_Widget {

		function __construct() {
			$opts = array(
				'classname'		 => 'two-col-section row',
				'description'	 => esc_html__( 'Widget to display news in two columns.', 'envo-magazine' ),
			);

			parent::__construct( 'envo-magazine-two-column-news', esc_html__( 'Envo Magazine: Two-columns news', 'envo-magazine' ), $opts );
		}

		function widget( $args, $instance ) {

			$first_title = !empty( $instance[ 'first_title' ] ) ? $instance[ 'first_title' ] : '';

			$first_category = !empty( $instance[ 'first_category' ] ) ? $instance[ 'first_category' ] : 0;

			$second_title = !empty( $instance[ 'second_title' ] ) ? $instance[ 'second_title' ] : '';

			$second_category = !empty( $instance[ 'second_category' ] ) ? $instance[ 'second_category' ] : 0;

			$view_all_text = !empty( $instance[ 'view_all_text' ] ) ? $instance[ 'view_all_text' ] : '';

			$excerpt_length = !empty( $instance[ 'excerpt_length' ] ) ? $instance[ 'excerpt_length' ] : 30;

			$post_number = !empty( $instance[ 'post_number' ] ) ? $instance[ 'post_number' ] : 3;


			echo $args[ 'before_widget' ];
			?>

			<div class="two-column-news two-column-news-left col-md-6">

				<div class="section-title">

					<?php
					if ( !empty( $first_title ) ) {
						echo $args[ 'before_title' ] . esc_html( $first_title ) . $args[ 'after_title' ];
					}
					$first_category = envo_magazine_check_cat( $first_category );
					if ( !empty( $view_all_text ) ) {
						$page_for_posts = get_option( 'page_for_posts' );
						if ( absint( $first_category ) > 0 ) {

							$cat_link = get_category_link( $first_category );
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
					$first_col_args = array(
						'posts_per_page'		 => absint( $post_number ),
						'no_found_rows'			 => true,
						'post__not_in'			 => get_option( 'sticky_posts' ),
						'ignore_sticky_posts'	 => true,
					);

					if ( absint( $first_category ) > 0 ) {

						$first_col_args[ 'cat' ] = absint( $first_category );
					}


					$first_col_posts = new WP_Query( $first_col_args );

					if ( $first_col_posts->have_posts() ) :

						$first_col_count = 1;

						while ( $first_col_posts->have_posts() ) :

							$first_col_posts->the_post();

							if ( 1 === $first_col_count ) {
								?>

								<div class="news-item">
									<?php envo_magazine_thumb_img( 'envo-magazine-med' ); ?>
									<?php envo_magazine_widget_date_comments(); ?>
									<div class="news-text-wrap first-wrap">
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

							<?php } else {
								?>

								<div class="news-item layout-two row">
									<?php envo_magazine_thumb_img( 'envo-magazine-thumbnail', 'col-xs-3' ); ?>
									<div class="news-text-wrap col-xs-9">
										<?php envo_magazine_the_title(); ?>
										<?php envo_magazine_widget_date_comments(); ?>
									</div><!-- .news-text-wrap -->
								</div><!-- .news-item -->

								<?php
							}

							$first_col_count++;

						endwhile;

						wp_reset_postdata();
						?>

					<?php endif; ?>
				</div><!-- .inner-wrapper -->

			</div><!-- .two-column-news-left -->

			<div class="two-column-news two-column-news-right col-md-6">

				<div class="section-title">

					<?php
					if ( !empty( $second_title ) ) {
						echo $args[ 'before_title' ] . esc_html( $second_title ) . $args[ 'after_title' ];
					}
					$second_category = envo_magazine_check_cat( $second_category );
					if ( !empty( $view_all_text ) ) {
						$page_for_posts = get_option( 'page_for_posts' );
						if ( absint( $second_category ) > 0 ) {

							$cat_link = get_category_link( $second_category );
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
					$second_col_args = array(
						'posts_per_page'		 => absint( $post_number ),
						'no_found_rows'			 => true,
						'post__not_in'			 => get_option( 'sticky_posts' ),
						'ignore_sticky_posts'	 => true,
					);

					if ( absint( $second_category ) > 0 ) {

						$second_col_args[ 'cat' ] = absint( $second_category );
					}


					$second_col_posts = new WP_Query( $second_col_args );

					if ( $second_col_posts->have_posts() ) :

						$second_col_count = 1;

						while ( $second_col_posts->have_posts() ) :

							$second_col_posts->the_post();

							if ( 1 === $second_col_count ) {
								?>

								<div class="news-item">
									<?php envo_magazine_thumb_img( 'envo-magazine-med' ); ?>
									<?php envo_magazine_widget_date_comments(); ?>
									<div class="news-text-wrap first-wrap">
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

							<?php } else {
								?>

								<div class="news-item layout-two row">
									<?php envo_magazine_thumb_img( 'envo-magazine-thumbnail', 'col-xs-3' ); ?>
									<div class="news-text-wrap col-xs-9">
										<?php envo_magazine_the_title(); ?>
										<?php envo_magazine_widget_date_comments(); ?>
									</div><!-- .news-text-wrap -->
								</div><!-- .news-item -->

								<?php
							}

							$second_col_count++;

						endwhile;

						wp_reset_postdata();
						?>

					<?php endif; ?>
				</div><!-- .inner-wrapper -->

			</div><!-- .two-column-news-right -->

			<?php
			echo $args[ 'after_widget' ];
		}

		function update( $new_instance, $old_instance ) {
			$instance						 = $old_instance;
			$instance[ 'first_title' ]		 = sanitize_text_field( $new_instance[ 'first_title' ] );
			$instance[ 'first_category' ]	 = absint( $new_instance[ 'first_category' ] );
			$instance[ 'second_title' ]		 = sanitize_text_field( $new_instance[ 'second_title' ] );
			$instance[ 'second_category' ]	 = absint( $new_instance[ 'second_category' ] );
			$instance[ 'view_all_text' ]	 = sanitize_text_field( $new_instance[ 'view_all_text' ] );
			$instance[ 'excerpt_length' ]	 = absint( $new_instance[ 'excerpt_length' ] );
			$instance[ 'post_number' ]		 = absint( $new_instance[ 'post_number' ] );

			return $instance;
		}

		function form( $instance ) {

			$instance	 = wp_parse_args( (array) $instance, array(
				'first_title'		 => '',
				'first_category'	 => '',
				'second_title'		 => '',
				'second_category'	 => '',
				'view_all_text'		 => esc_html__( 'View All', 'envo-magazine' ),
				'excerpt_length'	 => 30,
				'post_number'		 => 3,
			) );
			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'first_title' ) ); ?>"><strong><?php esc_html_e( 'First column title:', 'envo-magazine' ); ?></strong></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'first_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'first_title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance[ 'first_title' ] ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'first_category' ) ); ?>"><strong><?php esc_html_e( 'First column category:', 'envo-magazine' ); ?></strong></label>
				<?php
				$cat_args	 = array(
					'orderby'			 => 'name',
					'hide_empty'		 => 0,
					'class'				 => 'widefat',
					'taxonomy'			 => 'category',
					'name'				 => $this->get_field_name( 'first_category' ),
					'id'				 => $this->get_field_id( 'first_category' ),
					'selected'			 => absint( $instance[ 'first_category' ] ),
					'show_option_all'	 => esc_html__( 'All Categories', 'envo-magazine' ),
				);
				wp_dropdown_categories( $cat_args );
				?>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'second_title' ) ); ?>"><strong><?php esc_html_e( 'Second column title:', 'envo-magazine' ); ?></strong></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'second_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'second_title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance[ 'second_title' ] ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'second_category' ) ); ?>"><strong><?php esc_html_e( 'Second column category:', 'envo-magazine' ); ?></strong></label>
				<?php
				$cat_args	 = array(
					'orderby'			 => 'name',
					'hide_empty'		 => 0,
					'class'				 => 'widefat',
					'taxonomy'			 => 'category',
					'name'				 => $this->get_field_name( 'second_category' ),
					'id'				 => $this->get_field_id( 'second_category' ),
					'selected'			 => absint( $instance[ 'second_category' ] ),
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
