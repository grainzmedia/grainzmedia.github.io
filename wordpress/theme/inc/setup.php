<?php
/**
 * One-time site setup when the theme is activated: creates the pages the theme has designs for,
 * points the front page and the posts page at them, and creates the two Insights categories.
 * Safe to run again — existing pages, categories and settings are left alone.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'after_switch_theme',
	function () {
		$pages = array(
			'home'                  => 'Home',
			'retail-media'          => 'Retail Media',
			'performance-marketing' => 'Performance Marketing',
			'insights'              => 'Insights',
			'about'                 => 'About',
			'contact'               => 'Contact',
			'press'                 => 'Press',
			'privacy'               => 'Privacy Policy',
			'cookies'               => 'Cookie Policy',
		);

		$ids = array();
		foreach ( $pages as $slug => $title ) {
			$existing = get_page_by_path( $slug );
			if ( $existing ) {
				$ids[ $slug ] = $existing->ID;
				continue;
			}
			$id = wp_insert_post(
				array(
					'post_type'    => 'page',
					'post_status'  => 'publish',
					'post_name'    => $slug,
					'post_title'   => $title,
					'post_content' => '',
				)
			);
			if ( $id && ! is_wp_error( $id ) ) {
				$ids[ $slug ] = $id;
			}
		}

		// Static front page + Insights as the posts page, unless a static front page is already configured.
		if ( 'page' !== get_option( 'show_on_front' ) || ! get_option( 'page_on_front' ) ) {
			if ( isset( $ids['home'], $ids['insights'] ) ) {
				update_option( 'show_on_front', 'page' );
				update_option( 'page_on_front', $ids['home'] );
				update_option( 'page_for_posts', $ids['insights'] );
			}
		}

		foreach ( array( 'retail' => 'Retail Media Insights', 'performance' => 'Performance Insights' ) as $slug => $name ) {
			if ( ! get_category_by_slug( $slug ) ) {
				wp_insert_term( $name, 'category', array( 'slug' => $slug ) );
			}
		}

		// Pretty permalinks (/about/ rather than /?page_id=12) when none are set yet.
		if ( ! get_option( 'permalink_structure' ) ) {
			global $wp_rewrite;
			$wp_rewrite->set_permalink_structure( '/%postname%/' );
		}
		// Rebuild rewrite rules on the next request, when the new structure is in effect for every post type and taxonomy.
		update_option( 'gm_flush_rewrite', 1 );
	}
);

add_action(
	'init',
	function () {
		// Not in the request that changed the structure: its taxonomies were registered under the old one.
		if ( ! did_action( 'after_switch_theme' ) && get_option( 'gm_flush_rewrite' ) ) {
			delete_option( 'gm_flush_rewrite' );
			flush_rewrite_rules();
		}
	},
	99
);
