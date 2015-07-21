<?php

class social_shortcode {
	private $social_scripts;

	public function __init() {
		add_shortcode( 'social_login', array( $this, '__social_shortcode_output' ) );
		add_action( 'init', array( $this, '__social_scripts' ) );
		add_action( 'wp_footer', array( $this, '_social_print_scripts' ) );
	}

	public function __social_shortcode_output( $atts ) {
		$this->social_scripts = true;
		$atts = shortcode_atts( array(
				'nickname' 			   	 => false,
				'nickname_placeholder' 	 => 'Nickname',
				'first_name' 		   	 => false,
				'first_name_placeholder' => 'First Name',
				'last_name' 			 => false,
				'last_name_placeholder'	 => 'Last Name',
				'submit_prefix'			 => 'Login with',
				'networks' 				 => 'facebook,twitter,github',
				'social_action'			 => 'login',
				'redirect'				 => false
			), $atts, 'social_login' );

		$html = '<form id="social_login_form" data-social-action="' . esc_attr( $atts['social_action'] ) . '">';
			if( $atts['redirect'] ) {
				$html .= '<input type="hidden" name="_social_login_redirect" value="'. esc_attr( $atts['redirect'] ).'" />';
			}
			$html .= $this->__build_form_inputs( $atts );
			$html .= $this->__build_form_submits( $atts );
		$html .= '</form>';

		return $html;
	}

	private function __build_form_inputs( $atts ) {
		$form_fields = '';

		if( $atts['nickname'] ) {
			$form_fields .= '<div class="social_login_input_wrapper">';
				$form_fields .= '<input name="_social_login_nickname" type="text" placeholder="'. esc_attr( $atts['nickname_placeholder'] ).'" />';
			$form_fields .= '</div>';
		}

		if( $atts['first_name'] ) {
			$form_fields .= '<div class="social_login_input_wrapper">';
				$form_fields .= '<input name="_social_login_first_name" type="text" placeholder="'. esc_attr( $atts['first_name_placeholder'] ).'" />';
			$form_fields .= '</div>';
		}

		if( $atts['last_name'] ) {
			$form_fields .= '<div class="social_login_input_wrapper">';
				$form_fields .= '<input name="_social_login_last_name" type="text" placeholder="'. esc_attr( $atts['last_name_placeholder'] ).'" />';
			$form_fields .= '</div>';
		}

		return $form_fields;

	}

	private function __build_form_submits( $atts ) {
		$networks = $atts['networks'];
		$netwworks = str_replace( ' ', '', $networks );
		$networks = explode( ',', $networks );

		$submits = '';
		foreach( $networks as $key => $value ) {
			$submits .= '<input class="social_login_submit '. sanitize_html_class( $value ).'" type="submit" name="_social_login_'. esc_attr( $value ).'" value="'. esc_attr( $atts['submit_prefix'] ).' '. esc_attr( $value ) .'" />';
		}

		return $submits;
	}

	function __social_scripts() {
		wp_register_script( 'social_form_js', API_SOCIAL_URL.'/build/js/social_form.min.js', array( 'social-js' ), API_SOCIAL_LOGIN_VERSION, true );
	}

	function _social_print_scripts() {
		if( !$this->social_scripts ) { return; }
		wp_print_scripts( 'social_form_js' );
	}

}

?>