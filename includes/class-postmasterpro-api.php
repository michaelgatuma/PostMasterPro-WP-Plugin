<?php
// includes/class-postmasterpro-api.php

class PostMasterPro_API {
	private string $api_base = 'http://academic.test/api';

	public function fetch_posts( $token ) {
		$url      = $this->api_base . '/questions';
		$response = wp_remote_get( $url, array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $token
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
				'Authorization' => 'Bearer ' . $token
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
				'Authorization' => 'Bearer ' . $token
			)
		) );
		if ( is_wp_error( $response ) ) {
			return false;
		}

		return json_decode( wp_remote_retrieve_body( $response ) );
	}
}
