<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 */

get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php _e( 'That page can&rsquo;t be found.', 'croquet' ); ?></h1>
				</header><!-- .page-header -->
				<div class="page-content">
					<p><?php _e( 'The page you requested may be restricted to members so if you are a member please log in and try again.', 'croquet' ); ?></

				</div><!-- .page-content -->
			</section><!-- .error-404 -->
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php
get_footer();
