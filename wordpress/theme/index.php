<?php
/**
 * Post lists: the Insights page (posts page), category / tag / date archives and search results.
 */
get_header();

// Insights with nothing published yet: show the static "coming soon" page.
if ( is_home() && ! is_paged() && ! have_posts() ) {
	require get_template_directory() . '/pages/insights.php';
	get_footer();
	return;
}

$gm_insights = gm_url( 'insights' );
$gm_cats     = get_categories( array( 'hide_empty' => true ) );
$gm_current  = is_category() ? get_queried_object_id() : 0;
?>
<main id="main">
  <div class="page-body">
    <section class="container plain-hero reveal">
      <?php if ( is_home() ) : ?>
        <h1>Insights</h1>
        <p>Ideas for a more <span class="hl-mid underline">connected</span> media future.</p>
      <?php elseif ( is_search() ) : ?>
        <p class="eyebrow-s">Search results</p>
        <h1><?php echo esc_html( get_search_query() ); ?></h1>
      <?php else : ?>
        <p class="eyebrow-s">Insights</p>
        <h1><?php echo esc_html( is_category() || is_tag() ? single_term_title( '', false ) : wp_strip_all_tags( get_the_archive_title() ) ); ?></h1>
        <?php if ( ( is_category() || is_tag() ) && term_description() ) : ?>
          <?php echo wp_kses_post( term_description() ); ?>
        <?php endif; ?>
      <?php endif; ?>
    </section>

    <?php if ( count( $gm_cats ) > 1 ) : ?>
    <nav class="container post-filters" aria-label="Insight topics">
      <a href="<?php echo esc_url( $gm_insights ); ?>"<?php echo is_home() ? ' aria-current="page"' : ''; ?>>All</a>
      <?php foreach ( $gm_cats as $gm_cat ) : ?>
        <a href="<?php echo esc_url( get_category_link( $gm_cat ) ); ?>"<?php echo $gm_current === $gm_cat->term_id ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $gm_cat->name ); ?></a>
      <?php endforeach; ?>
    </nav>
    <?php endif; ?>

    <?php if ( have_posts() ) : ?>
    <section class="container post-grid" aria-label="Articles">
      <?php
      while ( have_posts() ) :
        the_post();
        ?>
      <article <?php post_class( 'post-card reveal' ); ?>>
        <?php if ( has_post_thumbnail() ) : ?>
          <div class="post-card-media"><?php the_post_thumbnail( 'gm-card', array( 'alt' => '', 'sizes' => '(min-width: 721px) 45vw, 92vw' ) ); ?></div>
        <?php endif; ?>
        <div class="post-card-body">
          <p class="post-meta"><?php echo gm_post_meta( false ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
          <h2 class="post-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
          <p class="post-card-excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
          <span class="post-card-more" aria-hidden="true">Read article</span>
        </div>
      </article>
      <?php endwhile; ?>
    </section>

    <div class="container post-pagination">
      <?php
      the_posts_pagination(
        array(
          'mid_size'  => 1,
          'prev_text' => '<span aria-hidden="true">←</span><span class="sr-only">Newer articles</span>',
          'next_text' => '<span class="sr-only">Older articles</span><span aria-hidden="true">→</span>',
        )
      );
      ?>
    </div>
    <?php else : ?>
    <section class="container post-empty">
      <p>Nothing here yet. <a class="underline" href="<?php echo esc_url( $gm_insights ); ?>">See all Insights</a>.</p>
    </section>
    <?php endif; ?>
  </div>
</main>
<?php
get_footer();
