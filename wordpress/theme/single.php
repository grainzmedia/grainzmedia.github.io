<?php
/**
 * A single Insights article.
 */
get_header();

while ( have_posts() ) :
	the_post();
	$gm_prev = get_previous_post();
	$gm_next = get_next_post();
	?>
<main id="main">
  <div class="page-body">
    <article <?php post_class(); ?>>
      <header class="container post-hero reveal">
        <p class="post-meta"><?php echo gm_post_meta(); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
        <h1><?php the_title(); ?></h1>
      </header>
      <?php if ( has_post_thumbnail() ) : ?>
        <div class="container post-feature reveal"><?php the_post_thumbnail( 'gm-feature', array( 'class' => 'rounded-img', 'sizes' => '(min-width: 1440px) 1376px, 92vw', 'loading' => 'eager', 'fetchpriority' => 'high' ) ); ?></div>
      <?php endif; ?>
      <div class="container entry">
        <div class="entry-content">
          <?php
          the_content();
          wp_link_pages( array( 'before' => '<p class="post-pages">Pages: ', 'after' => '</p>' ) );
          ?>
        </div>
      </div>
    </article>

    <nav class="container post-nav" aria-label="More articles">
      <a class="post-nav-all underline" href="<?php echo esc_url( gm_url( 'insights' ) ); ?>">All Insights</a>
      <?php if ( $gm_prev || $gm_next ) : ?>
      <div class="post-nav-links">
        <?php if ( $gm_next ) : ?>
          <a href="<?php echo esc_url( get_permalink( $gm_next ) ); ?>" rel="next"><small>Newer</small><?php echo esc_html( get_the_title( $gm_next ) ); ?></a>
        <?php else : ?>
          <span></span>
        <?php endif; ?>
        <?php if ( $gm_prev ) : ?>
          <a class="is-prev" href="<?php echo esc_url( get_permalink( $gm_prev ) ); ?>" rel="prev"><small>Older</small><?php echo esc_html( get_the_title( $gm_prev ) ); ?></a>
        <?php endif; ?>
      </div>
      <?php endif; ?>
    </nav>
  </div>
</main>
	<?php
endwhile;

get_footer();
