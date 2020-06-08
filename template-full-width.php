<?php
/**
 * Template Name: Full Width
 *
 * Description: A custom template for displaying a fullwidth layout with no sidebar.
 */

get_header(); ?>

<div class="wrap">
<div id="primary" class="content-area">
<main id="main" class="site-main" role="main">

<?php
while ( have_posts() ) {the_post();
		get_template_part( 'template-parts/page/content', 'page' );
		if ( comments_open() || get_comments_number() ) comments_template();
}
?>

</main><!-- #main -->
</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();
