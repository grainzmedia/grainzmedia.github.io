<?php
/**
 * GrainzMedia theme.
 *
 * The designed pages are generated from the static site's src/pages by tools/build-wp.mjs
 * (into pages/*.php and inc/pages-data.php). Do not edit those generated files.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require get_template_directory() . '/inc/setup.php';
require get_template_directory() . '/inc/enquiries.php';

/** Page metadata generated from the static site's front matter, keyed by slug ("index" = front page). */
function gm_pages() {
	static $pages = null;
	if ( null === $pages ) {
		$pages = require get_template_directory() . '/inc/pages-data.php';
	}
	return $pages;
}

/** Pages whose design is fixed in the theme. The others (press, privacy, cookies) show editor content once it exists. */
function gm_designed_slugs() {
	return array( 'retail-media', 'performance-marketing', 'about', 'contact' );
}

/** Key into gm_pages() for the current request, or '' when the request is not a built-in page. */
function gm_current_key() {
	if ( is_404() ) {
		return '404';
	}
	if ( is_front_page() ) {
		return 'index';
	}
	if ( is_home() ) {
		return 'insights';
	}
	if ( is_page() ) {
		$slug  = get_post_field( 'post_name', get_queried_object_id() );
		$pages = gm_pages();
		if ( isset( $pages[ $slug ] ) && gm_uses_builtin( $slug, get_queried_object_id() ) ) {
			return $slug;
		}
	}
	return '';
}

function gm_uses_builtin( $slug, $post_id ) {
	if ( ! file_exists( get_template_directory() . "/pages/{$slug}.php" ) ) {
		return false;
	}
	if ( in_array( $slug, gm_designed_slugs(), true ) ) {
		return true;
	}
	return '' === trim( (string) get_post_field( 'post_content', $post_id ) );
}

/** URL of a built-in page by slug, with an optional "?query" / "#hash" suffix. */
function gm_url( $slug, $suffix = '' ) {
	if ( 'index' === $slug ) {
		$url = home_url( '/' );
	} elseif ( 'insights' === $slug && get_option( 'page_for_posts' ) ) {
		$url = get_permalink( get_option( 'page_for_posts' ) );
	} else {
		$page = get_page_by_path( $slug );
		$url  = $page ? get_permalink( $page ) : home_url( '/' . $slug . '/' );
	}
	if ( '' !== $suffix && '?' === $suffix[0] && false !== strpos( $url, '?' ) ) {
		$suffix = '&' . substr( $suffix, 1 );
	}
	return $url . $suffix;
}

/** URL of the theme's assets folder (already escaped). */
function gm_assets() {
	return esc_url( get_template_directory_uri() . '/assets' );
}

/** Archive URL of an Insights category, falling back to the Insights page. */
function gm_category_url( $slug ) {
	$term = get_category_by_slug( $slug );
	if ( $term ) {
		$link = get_category_link( $term );
		if ( ! is_wp_error( $link ) ) {
			return $link;
		}
	}
	return gm_url( 'insights' );
}

/** Which main-nav item is current. */
function gm_nav_current() {
	if ( is_home() || is_singular( 'post' ) || is_archive() || is_search() ) {
		return 'insights';
	}
	$key   = gm_current_key();
	$pages = gm_pages();
	return ( $key && ! empty( $pages[ $key ]['nav'] ) ) ? $pages[ $key ]['nav'] : '';
}

function gm_nav_attr( $item ) {
	return gm_nav_current() === $item ? ' aria-current="page"' : '';
}

/* ---------- Setup ---------- */

add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
		add_image_size( 'gm-card', 960, 540, true );
		add_image_size( 'gm-feature', 1920, 0 );
	}
);

add_action(
	'wp_enqueue_scripts',
	function () {
		$dir = get_template_directory();
		$uri = get_template_directory_uri();
		wp_enqueue_style( 'gm-fonts', 'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Jost:wght@400;500;700&display=swap', array(), null );
		wp_enqueue_style( 'gm-style', $uri . '/assets/css/style.css', array(), filemtime( $dir . '/assets/css/style.css' ) );
		wp_enqueue_style( 'gm-wp', $uri . '/assets/css/wp.css', array( 'gm-style' ), filemtime( $dir . '/assets/css/wp.css' ) );
		wp_enqueue_script( 'gm-main', $uri . '/assets/js/main.js', array(), filemtime( $dir . '/assets/js/main.js' ), array( 'strategy' => 'defer', 'in_footer' => true ) );
	}
);

add_filter(
	'wp_resource_hints',
	function ( $urls, $relation ) {
		if ( 'preconnect' === $relation ) {
			$urls[] = 'https://fonts.googleapis.com';
			$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
		}
		return $urls;
	},
	10,
	2
);

add_filter(
	'body_class',
	function ( $classes ) {
		$key   = gm_current_key();
		$pages = gm_pages();
		if ( $key && ! empty( $pages[ $key ]['bodyClass'] ) ) {
			$classes[] = $pages[ $key ]['bodyClass'];
		}
		return $classes;
	}
);

/* ---------- <head>: titles, description, Open Graph ---------- */

add_filter(
	'document_title_separator',
	function () {
		return '—';
	}
);

add_filter(
	'pre_get_document_title',
	function ( $title ) {
		$key   = gm_current_key();
		$pages = gm_pages();
		return ( $key && ! is_paged() ) ? $pages[ $key ]['title'] : $title;
	}
);

function gm_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' ) || class_exists( 'The_SEO_Framework\Load' );
}

function gm_meta_description() {
	$key   = gm_current_key();
	$pages = gm_pages();
	if ( $key ) {
		return $pages[ $key ]['description'];
	}
	if ( is_singular() ) {
		return wp_strip_all_tags( get_the_excerpt( get_queried_object_id() ) );
	}
	if ( is_category() || is_tag() ) {
		$description = wp_strip_all_tags( term_description() );
		if ( $description ) {
			return $description;
		}
	}
	return $pages['insights']['description'];
}

add_action(
	'wp_head',
	function () {
		$assets = get_template_directory_uri() . '/assets';
		$key    = gm_current_key();
		$pages  = gm_pages();

		echo "<script>document.documentElement.classList.add('js')</script>\n";

		if ( ! has_site_icon() ) {
			printf( '<link rel="icon" href="%s" type="image/svg+xml">' . "\n", esc_url( $assets . '/img/favicon.svg' ) );
			printf( '<link rel="icon" href="%s" type="image/png" sizes="128x128">' . "\n", esc_url( $assets . '/img/favicon.png' ) );
			printf( '<link rel="apple-touch-icon" href="%s">' . "\n", esc_url( $assets . '/img/apple-touch-icon.png' ) );
		}

		if ( $key && ! empty( $pages[ $key ]['preload'] ) ) {
			$srcset = str_replace( 'assets/', $assets . '/', $pages[ $key ]['preload'] );
			printf( '<link rel="preload" as="image" type="image/webp" fetchpriority="high" imagesrcset="%s" imagesizes="100vw">' . "\n", esc_attr( $srcset ) );
		}

		if ( ! gm_seo_plugin_active() ) {
			$description = gm_meta_description();
			$url         = is_singular() ? get_permalink() : ( is_front_page() ? home_url( '/' ) : '' );
			$image       = ( is_singular() && has_post_thumbnail() ) ? get_the_post_thumbnail_url( null, 'gm-feature' ) : $assets . '/img/og-image.jpg';
			printf( '<meta name="description" content="%s">' . "\n", esc_attr( $description ) );
			printf( '<meta property="og:type" content="%s">' . "\n", is_singular( 'post' ) ? 'article' : 'website' );
			echo '<meta property="og:site_name" content="GrainzMedia">' . "\n";
			echo '<meta property="og:locale" content="en_SG">' . "\n";
			printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( wp_get_document_title() ) );
			printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $description ) );
			if ( $url ) {
				printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $url ) );
			}
			printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $image ) );
			echo '<meta name="twitter:card" content="summary_large_image">' . "\n";

			$org = array(
				'@context'    => 'https://schema.org',
				'@type'       => 'Organization',
				'name'        => 'GrainzMedia',
				'url'         => home_url( '/' ),
				'logo'        => $assets . '/img/logo-large.png',
				'email'       => 'hello@grainzmedia.com',
				'telephone'   => '+65 6645 0498',
				'address'     => array(
					'@type'           => 'PostalAddress',
					'streetAddress'   => '178 Paya Lebar Road, #02-04',
					'addressLocality' => 'Singapore',
					'postalCode'      => '409030',
					'addressCountry'  => 'SG',
				),
				'description' => 'Singapore-based retail media commercialisation, experience and performance marketing company serving Singapore and Asia.',
			);
			echo '<script type="application/ld+json">' . wp_json_encode( $org, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n";
		}
	},
	5
);

/* ---------- Posts ---------- */

add_filter(
	'excerpt_length',
	function () {
		return 30;
	}
);

add_filter(
	'excerpt_more',
	function () {
		return '…';
	}
);

/** "Category · 26 November 2026" line for a post. */
function gm_post_meta( $link = true ) {
	$out  = '';
	$cats = get_the_category();
	if ( $cats && 'uncategorized' !== $cats[0]->slug ) {
		$name = esc_html( $cats[0]->name );
		$out .= ( $link ? '<a href="' . esc_url( get_category_link( $cats[0] ) ) . '">' . $name . '</a>' : $name ) . '<span aria-hidden="true"> · </span>';
	}
	$out .= '<time datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time>';
	return $out;
}

/* ---------- Old static URLs (/about.html) → new pages ---------- */

add_action(
	'template_redirect',
	function () {
		if ( ! is_404() ) {
			return;
		}
		$path = wp_parse_url( isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '', PHP_URL_PATH ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		if ( ! $path || ! preg_match( '#/([a-z0-9-]+)\.html$#', $path, $m ) ) {
			return;
		}
		$pages = gm_pages();
		if ( '404' !== $m[1] && isset( $pages[ $m[1] ] ) ) {
			wp_safe_redirect( gm_url( $m[1] ), 301 );
			exit;
		}
	}
);
