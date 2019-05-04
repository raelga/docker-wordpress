<article>
	<div <?php post_class(); ?>>                    
		<div class="news-item row">
			<?php envo_magazine_thumb_img( 'envo-magazine-med', 'col-md-6' ); ?>
			<div class="news-text-wrap col-md-6">
				<?php envo_magazine_widget_date_comments(); ?>
				<?php envo_magazine_the_title(); ?>
				<?php envo_magazine_author_meta(); ?>

				<div class="post-excerpt">
					<?php the_excerpt(); ?>
				</div><!-- .post-excerpt -->

			</div><!-- .news-text-wrap -->

		</div><!-- .news-item -->
	</div>
</article>
