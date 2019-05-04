<div class="homepage-main-content-page">
	<div class="homepage-area"> 
		<?php
		if ( is_active_sidebar( 'envo-magazine-homepage-area' ) ) :
			dynamic_sidebar( 'envo-magazine-homepage-area' );
		endif;
		?>
	</div>
	<div class="row">
		<div class="homepage-area-2 col-md-8">
			<?php
			if ( is_active_sidebar( 'envo-magazine-homepage-area-2' ) ) :
				dynamic_sidebar( 'envo-magazine-homepage-area-2' );
			endif;
			?>
		</div>	
		<div class="homepage-area-2-sidebar col-md-4">	
			<?php
			if ( is_active_sidebar( 'envo-magazine-homepage-area-2-sidebar' ) ) :
				dynamic_sidebar( 'envo-magazine-homepage-area-2-sidebar' );
			endif;
			?>
		</div>
	</div>
	<div class="homepage-area-3">
		<?php
		if ( is_active_sidebar( 'envo-magazine-homepage-area-3' ) ) :
			dynamic_sidebar( 'envo-magazine-homepage-area-3' );
		endif;
		?>
	</div>
	<div class="row">
		<div class="homepage-area-area-4 col-md-8">
			<?php
			if ( is_active_sidebar( 'envo-magazine-homepage-area-4' ) ) :
				dynamic_sidebar( 'envo-magazine-homepage-area-4' );
			endif;
			?>
		</div>	
		<div class="homepage-area-area-4-sidebar col-md-4">
			<?php
			if ( is_active_sidebar( 'envo-magazine-homepage-area-4-sidebar' ) ) :
				dynamic_sidebar( 'envo-magazine-homepage-area-4-sidebar' );
			endif;
			?>
		</div>
	</div>
	<div class="homepage-area-5">
		<?php
		if ( is_active_sidebar( 'envo-magazine-homepage-area-5' ) ) :
			dynamic_sidebar( 'envo-magazine-homepage-area-5' );
		endif;
		?>
	</div>
</div>
