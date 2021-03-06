<?php
/**
 * This is a built-in template file. If you need to customize it, please,
 * DO NOT modify this file directly. Instead, copy it to your theme's directory
 * and then modify the code. If you modify this file directly, your changes
 * will be overwritten during next update of the plugin.
 */

/**
 * Make the post data and the pre-form message global
 */
global $post, $wpas_notification;

$submit        = get_permalink( wpas_get_option( 'ticket_list' ) );
$registration  = wpas_get_option( 'allow_registrations', 'allow' ); // Make sure registrations are open
$redirect_to   = get_permalink( $post->ID );
$wrapper_class = true !== $registration ? 'wpas-login-only' : 'wpas-login-register';
?>

<div class="wpas <?php echo $wrapper_class; ?>">
	<?php do_action('wpas_before_login_form'); ?>

	<form class="wpas-form" method="post" role="form" action="<?php echo wpas_get_login_url(); ?>">
		<h3><?php _e( 'Log in' ); ?></h3>

		<?php
		/* Registrations are not allowed. */
		if ( 'disallow' === $registration ) {
			wpas_notification( 'failure', __( 'Registrations are currently not allowed.', 'wpas' ) );
		}
		?>

		<div class="wpas-form-group">
			<label><?php _e( 'E-mail or username', 'wpas' ); ?></label>
			<input type="text" name="log" class="wpas-form-control" placeholder="<?php _e( 'E-mail or username', 'wpas' ); ?>" required>
		</div>
		<div class="wpas-form-group">
			<label><?php _e( 'Password' ); ?></label>
			<input type="password" name="pwd" class="wpas-form-control" placeholder="<?php _e( 'Password' ); ?>" required>
		</div>

		<?php
		/**
		 * wpas_after_login_fields hook
		 */
		do_action( 'wpas_after_login_fields' );
		?>

		<div class="wpas-checkbox">
			<label><input type="checkbox" name="rememberme" class="wpas-form-control-checkbox"> <?php _e( 'Remember Me' ); ?></label>
		</div>

		<input type="hidden" name="redirect_to" value="<?php echo $redirect_to; ?>">
		<input type="hidden" name="wpas_login" value="1">
		<?php wpas_make_button( __( 'Log in' ), array( 'onsubmit' => __( 'Logging In...', 'wpas' ) ) ); ?>
	</form>
	<?php
	if ( 'allow' === $registration ): ?>

		<form class="wpas-form" method="post" action="<?php echo get_permalink( $post->ID ); ?>">
			<h3><?php _e( 'Register' ); ?></h3>
			<div class="wpas-form-group">
				<label><?php _e( 'First Name', 'wpas' ); ?></label>
				<input class="wpas-form-control" type="text" placeholder="<?php _e( 'First Name', 'wpas' ); ?>" name="first_name" value="<?php echo wpas_get_registration_field_value( 'first_name' ); ?>" required>
			</div>
			<div class="wpas-form-group">
				<label><?php _e( 'Last Name', 'wpas' ); ?></label>
				<input class="wpas-form-control" type="text" placeholder="<?php _e( 'Last Name', 'wpas' ); ?>" name="last_name" value="<?php echo wpas_get_registration_field_value( 'last_name' ); ?>" required>
			</div>
			<div class="wpas-form-group">
				<label><?php _e( 'Email' ); ?></label>
				<input class="wpas-form-control" type="email" placeholder="<?php _e( 'Email' ); ?>" name="email" value="<?php echo wpas_get_registration_field_value( 'email' ); ?>" required>
				<small class="wpas-help-block" id="email-validation" style="display: none;"></small>
			</div>
			<div class="wpas-form-group">
				<label><?php _e( 'Enter a password', 'wpas' ); ?></label>
				<input class="wpas-form-control" type="password" placeholder="<?php _e( 'Password' ); ?>" id="password" name="pwd" required>
			</div>
			<div class="wpas-checkbox">
				<label><input type="checkbox" name="pwdshow" id="pwdshow" class="wpas-form-control-checkbox"> <?php echo _x( 'Show Password', 'Login form', 'wpas' ); ?></label>
			</div>

			<?php
			/**
			 * wpas_after_registration_fields hook
			 * 
			 * @Awesome_Support::terms_and_conditions_checkbox()
			 */
			do_action( 'wpas_after_registration_fields' );
			?>
			<input type="hidden" name="wpas_registration" value="true">
			<?php
			wp_nonce_field( 'register', 'user_registration', false, true );
			wpas_make_button( __( 'Create Account', 'wpas' ), array( 'onsubmit' => __( 'Creating Account...', 'wpas' ) ) );
			?>
		</form>
	<?php endif; ?>
</div>
