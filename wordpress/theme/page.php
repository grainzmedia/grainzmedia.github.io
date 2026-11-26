<?php
/**
 * Pages. A page whose slug matches a design built into the theme shows that design;
 * any other page (or press / privacy / cookies once they have content) shows what was written in the editor.
 */
get_header();

$gm_slug = get_post_field( 'post_name', get_queried_object_id() );

if ( gm_uses_builtin( $gm_slug, get_queried_object_id() ) ) {
	require get_template_directory() . "/pages/{$gm_slug}.php";
} else {
	while ( have_posts() ) {
		the_post();
		?>
<main id="main">
  <div class="page-body">
    <section class="container plain-hero reveal">
      <h1><?php the_title(); ?></h1>
    </section>
    <article class="container entry">
      <div class="entry-content"><?php the_content(); ?></div>
    </article>
  </div>
</main>
		<?php
	}
}

get_footer();
