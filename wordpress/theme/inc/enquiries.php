<?php
/**
 * Contact form → WordPress.
 *
 * The enquiry form posts to a REST endpoint; each submission is saved as a private "Enquiry"
 * (WordPress admin → Enquiries) and emailed to the site's admin address.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const GM_ENQUIRY_FIELDS = array(
	'topic'   => 'I’m interested in',
	'name'    => 'Name',
	'company' => 'Company',
	'email'   => 'Email',
);

add_action(
	'init',
	function () {
		register_post_type(
			'gm_enquiry',
			array(
				'labels'              => array(
					'name'               => 'Enquiries',
					'singular_name'      => 'Enquiry',
					'menu_name'          => 'Enquiries',
					'edit_item'          => 'Enquiry',
					'search_items'       => 'Search enquiries',
					'not_found'          => 'No enquiries yet.',
					'not_found_in_trash' => 'No enquiries in the bin.',
				),
				'public'              => false,
				'show_ui'             => true,
				'show_in_rest'        => false,
				'exclude_from_search' => true,
				'menu_icon'           => 'dashicons-email-alt',
				'menu_position'       => 26,
				'supports'            => array( 'title' ),
				'map_meta_cap'        => true,
				'capabilities'        => array( 'create_posts' => 'do_not_allow' ), // only the form creates enquiries
			)
		);
	}
);

/* ---------- Receiving a submission ---------- */

add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'grainzmedia/v1',
			'/enquiry',
			array(
				'methods'             => 'POST',
				'permission_callback' => '__return_true', // public form
				'callback'            => 'gm_handle_enquiry',
			)
		);
	}
);

function gm_enquiry_text( $value, $max ) {
	return mb_substr( sanitize_text_field( is_scalar( $value ) ? (string) $value : '' ), 0, $max );
}

function gm_handle_enquiry( WP_REST_Request $request ) {
	// Honeypot: bots fill the hidden "website" field. Pretend it worked.
	if ( '' !== trim( (string) $request->get_param( 'website' ) ) ) {
		return new WP_REST_Response( array( 'ok' => true ), 200 );
	}

	// At most 5 enquiries per 10 minutes from one address.
	$ip       = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$rate_key = 'gm_enq_' . md5( $ip . wp_salt() );
	$count    = (int) get_transient( $rate_key );
	if ( $count >= 5 ) {
		return new WP_Error( 'gm_rate_limited', 'Too many enquiries. Please try again later or email hello@grainzmedia.com.', array( 'status' => 429 ) );
	}

	$topic   = gm_enquiry_text( $request->get_param( 'topic' ), 80 );
	$name    = gm_enquiry_text( $request->get_param( 'name' ), 120 );
	$company = gm_enquiry_text( $request->get_param( 'company' ), 160 );
	$email   = sanitize_email( is_scalar( $request->get_param( 'email' ) ) ? (string) $request->get_param( 'email' ) : '' );
	$raw     = $request->get_param( 'message' );
	$message = mb_substr( sanitize_textarea_field( is_scalar( $raw ) ? (string) $raw : '' ), 0, 5000 );

	if ( '' === $name || '' === $message || ! is_email( $email ) ) {
		return new WP_Error( 'gm_invalid', 'Please check your name, email and message.', array( 'status' => 400 ) );
	}

	set_transient( $rate_key, $count + 1, 10 * MINUTE_IN_SECONDS );

	// REST params arrive unslashed; wp_insert_post() expects slashed data (otherwise backslashes are stripped).
	$post_id = wp_insert_post(
		wp_slash(
		array(
			'post_type'    => 'gm_enquiry',
			'post_status'  => 'private',
			'post_title'   => $name . ( $topic ? ' — ' . $topic : '' ),
			'post_content' => $message,
			'meta_input'   => array(
				'_gm_topic'   => $topic,
				'_gm_name'    => $name,
				'_gm_company' => $company,
				'_gm_email'   => $email,
			),
		)
		),
		true
	);
	if ( is_wp_error( $post_id ) ) {
		return new WP_Error( 'gm_not_saved', 'Sorry, we couldn’t send that. Please email hello@grainzmedia.com instead.', array( 'status' => 500 ) );
	}

	// Notification email. The saved enquiry is the record, so a mail failure does not fail the request.
	$to        = apply_filters( 'gm_enquiry_recipient', get_option( 'admin_email' ) );
	$from_name = trim( str_replace( array( '"', '<', '>', ',', ';', ':' ), '', $name ) );
	wp_mail(
		$to,
		sprintf( '[GrainzMedia] %s enquiry — %s', $topic ? $topic : 'Website', $name ),
		"Topic: {$topic}\nName: {$name}\nCompany: " . ( $company ? $company : '-' ) . "\nEmail: {$email}\n\n{$message}\n\n— \n" . admin_url( 'post.php?post=' . $post_id . '&action=edit' ),
		array( "Reply-To: \"{$from_name}\" <{$email}>" )
	);

	return new WP_REST_Response( array( 'ok' => true ), 200 );
}

/** Tell main.js where to send the form (only on the page that has it). */
add_action(
	'wp_enqueue_scripts',
	function () {
		if ( is_page( 'contact' ) ) {
			wp_add_inline_script( 'gm-main', 'window.gmEnquiry = ' . wp_json_encode( array( 'url' => esc_url_raw( rest_url( 'grainzmedia/v1/enquiry' ) ) ) ) . ';', 'before' );
		}
	},
	20
);

/* ---------- Reading enquiries in the admin ---------- */

add_filter(
	'manage_gm_enquiry_posts_columns',
	function () {
		return array(
			'cb'         => '<input type="checkbox">',
			'title'      => 'Enquiry',
			'gm_email'   => 'Email',
			'gm_company' => 'Company',
			'gm_message' => 'Message',
			'date'       => 'Received',
		);
	}
);

add_action(
	'manage_gm_enquiry_posts_custom_column',
	function ( $column, $post_id ) {
		if ( 'gm_email' === $column ) {
			$email = get_post_meta( $post_id, '_gm_email', true );
			printf( '<a href="mailto:%1$s">%1$s</a>', esc_attr( $email ) );
		} elseif ( 'gm_company' === $column ) {
			echo esc_html( get_post_meta( $post_id, '_gm_company', true ) );
		} elseif ( 'gm_message' === $column ) {
			echo esc_html( wp_trim_words( get_post_field( 'post_content', $post_id ), 24, '…' ) );
		}
	},
	10,
	2
);

add_action(
	'add_meta_boxes_gm_enquiry',
	function () {
		add_meta_box(
			'gm_enquiry_details',
			'Enquiry',
			function ( $post ) {
				echo '<table class="form-table" role="presentation"><tbody>';
				foreach ( GM_ENQUIRY_FIELDS as $key => $label ) {
					$value = get_post_meta( $post->ID, '_gm_' . $key, true );
					$cell  = 'email' === $key ? sprintf( '<a href="mailto:%1$s">%1$s</a>', esc_attr( $value ) ) : esc_html( $value ? $value : '—' );
					printf( '<tr><th scope="row">%s</th><td>%s</td></tr>', esc_html( $label ), $cell ); // phpcs:ignore WordPress.Security.EscapeOutput
				}
				printf( '<tr><th scope="row">Message</th><td>%s</td></tr>', nl2br( esc_html( $post->post_content ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput
				printf( '<tr><th scope="row">Received</th><td>%s</td></tr>', esc_html( get_the_date( 'j F Y, g:i a', $post ) ) );
				echo '</tbody></table>';
			},
			'gm_enquiry',
			'normal',
			'high'
		);
	}
);
