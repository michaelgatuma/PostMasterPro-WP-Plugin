<?php
// includes/class-postmasterpro-api.php

class PostMasterPro_API {
	private string $api_base = 'https://api.upworkstation.com/api';

	public function fetch_posts( $token ) {
		$url      = $this->api_base . '/questions';
		$response = wp_remote_get( $url, array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $token,
				'Content-Type'  => 'application/json; charset=utf-8',
				'Accept'        => 'application/json'
			)
		) );
		if ( is_wp_error( $response ) ) {
			return false;
		}

		return json_decode( wp_remote_retrieve_body( $response ) );
	}

	public function fetch_post( $token ) {
		$url = $this->api_base . '/question';

		$response = wp_remote_get( $url, array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $token,
				'Content-Type'  => 'application/json; charset=utf-8',
				'Accept'        => 'application/json'
			)
		) );

		if ( is_wp_error( $response ) ) {
			return false;
		}

		$decoded_response = json_decode( wp_remote_retrieve_body( $response ) );

		return $decoded_response->data->question; // Extract the 'data.question' object from the API response
	}

	public function register( $email, $password ) {
		$url      = $this->api_base . '/register';
		$response = wp_remote_post( $url, array(
			'body' => array(
				'email'    => $email,
				'password' => $password
			)
		) );
		if ( is_wp_error( $response ) ) {
			return false;
		}

		return json_decode( wp_remote_retrieve_body( $response ) );
	}

	public function login( $email, $password ) {
		$url      = $this->api_base . 'login';
		$response = wp_remote_post( $url, array(
			'body' => array(
				'email'    => $email,
				'password' => $password
			)
		) );
		if ( is_wp_error( $response ) ) {
			return false;
		}

		return json_decode( wp_remote_retrieve_body( $response ) );
	}

	public function get_user( $token ) {
		$url      = $this->api_base . 'user';
		$response = wp_remote_get( $url, array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $token,
				'Content-Type'  => 'application/json; charset=utf-8',
			)
		) );
		if ( is_wp_error( $response ) ) {
			return false;
		}

		return json_decode( wp_remote_retrieve_body( $response ) );
	}

	public function acknowledge_post_published( $question_id, $post_id ): void {
		$url   = $this->api_base . '/question-transaction';
		$token = get_option( 'postmasterpro_auth_token' );
		if ( ! $token ) {
			return;
		}
		$headers     = array(
			'Authorization' => 'Bearer ' . $token,
			'Content-Type'  => 'application/json; charset=utf-8',
			'Accept'        => 'application/json'
		);
		$site_url    = get_site_url();
		$parsed_url  = parse_url( $site_url );
		$domain_name = $parsed_url['host'];
		$response    = wp_remote_post( $url, array(
			'headers' => $headers,
			'body'    => json_encode( array(
				'question_id' => $question_id,
				'client_host' => $domain_name,
				'post_id'     => $post_id
			) )
		) );

// Check if the request was successful and handle accordingly
		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			echo "Something went wrong: $error_message";
		} else {
			echo 'Response received: ' . wp_remote_retrieve_body( $response );
		}
	}
}
