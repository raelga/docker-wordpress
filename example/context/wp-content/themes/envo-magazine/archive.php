<?php get_header(); ?> 

<?php get_template_part( 'template-parts/template-part', 'head' ); ?>

<!-- start content container -->
<div class="row">

	<div class="col-md-<?php envo_magazine_main_content_width_columns(); ?>">
		<?php if ( have_posts() ) : ?>
			<header class="archive-page-header text-center">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->
		<?php endif; ?>
		<?php
		if ( have_posts() ) :

			while ( have_posts() ) : the_post();

				get_template_part( 'content', get_post_format() );

			endwhile;

			the_posts_pagination();

		else :

			get_template_part( 'content', 'none' );

		endif;
		?>

	</div>

	<?php get_sidebar( 'right' ); ?>

</div>
<!-- end content container -->

<?php get_footer(); ?>
