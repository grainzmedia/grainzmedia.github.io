<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="theme-color" content="#172c3f">
  <meta name="color-scheme" content="dark">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main">Skip to content</a>
<header class="site-header" data-header>
  <div class="container">
    <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="GrainzMedia — home"><img src="<?php echo gm_assets(); ?>/img/logo.png" alt="GrainzMedia" width="320" height="158"></a>
    <button class="nav-toggle" type="button" aria-label="Menu" aria-expanded="false" aria-controls="nav"><span></span></button>
    <nav class="nav" id="nav" aria-label="Main">
      <a href="<?php echo esc_url( gm_url( 'retail-media' ) ); ?>"<?php echo gm_nav_attr( 'retail' ); ?>>Retail Media</a>
      <a href="<?php echo esc_url( gm_url( 'performance-marketing' ) ); ?>"<?php echo gm_nav_attr( 'performance' ); ?> class="nav-wrap">Performance Marketing</a>
      <a href="<?php echo esc_url( gm_url( 'insights' ) ); ?>"<?php echo gm_nav_attr( 'insights' ); ?>>Insights</a>
      <a href="<?php echo esc_url( gm_url( 'about' ) ); ?>"<?php echo gm_nav_attr( 'about' ); ?>>About</a>
      <a href="<?php echo esc_url( gm_url( 'contact' ) ); ?>"<?php echo gm_nav_attr( 'contact' ); ?> class="btn">Contact Us</a>
    </nav>
  </div>
</header>
