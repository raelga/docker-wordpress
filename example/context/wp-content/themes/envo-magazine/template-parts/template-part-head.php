<div class="container main-container" role="main">
	<div class="page-area">
		<?php
		if ( function_exists( 'yoast_breadcrumb' ) && ( ! is_page_template( 'template-parts/template-homepage.php' ) && ! is_home() && ! is_front_page() )) {
			yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
		}
			