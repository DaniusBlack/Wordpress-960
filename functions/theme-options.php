<?php

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
	register_setting( '960gs_options', '960gs_theme_options', 'theme_options_validate' );
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_theme_page( __( 'Theme Options', '960gs' ), __( 'Theme Options', '960gs' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}

/**
 * Create the options page
 */
function theme_options_do_page() {

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>
	<div class="wrap">
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Theme Options', '960gs' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved', '960gs' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( '960gs_options' ); ?>
			<?php $options = get_option( '960gs_theme_options' ); ?>
			
			<h3>Appearance</h3>
			<table class="form-table">
				
				<!-- Navigation -->
				<tr valign="top"><th scope="row"><?php _e( 'Navigation', '960gs' ); ?></th>
					<td>
						<input id="960gs_theme_options[footer_navigation]" name="960gs_theme_options[footer_navigation]" type="checkbox" value="1" <?php checked( '1', $options['footer_navigation'] ); ?> />
						<label class="description" for="960gs_theme_options[footer_navigation]"><?php _e( 'Show footer navigation', '960gs' ); ?></label>
					</td>
				</tr>
				
			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options', '960gs' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate( $input ) {

	// Checkbox value is either 0 or 1
	if ( ! isset( $input['footer_navigation'] ) )
		$input['footer_navigation'] = null;
	$input['footer_navigation'] = ( $input['footer_navigation'] == 1 ? 1 : 0 );

	return $input;
}

// adapted from http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/