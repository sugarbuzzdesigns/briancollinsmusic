<?php
/*
Plugin Name: FanBridge Signup
Plugin URI: http://www.fanbridge.com/?src=wordpress_plugin_settings
Description: The FanBridge Signup plugin allows you to setup an email signup form for your FanBridge fan list.
Version: 0.5
Author: FanBridge Inc.
Author URI: http://www.fanbridge.com/?src=wordpress_plugin_settings
License: GPLv2 or later.
*/

// constants
require_once dirname(__FILE__) . "/fanbridge-signup.constants.php";

// here goes all widget functions
require_once dirname(__FILE__) . "/fanbridge-signup.widget.php";

/**
 * some globals
 * yeah...ugly
 */
$fb_errors = array();

function fbridge_plugin_init () {
	fbridge_plugin_load_assets();
	load_plugin_textdomain('fanbridge-signup', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}

add_action('init', 'fbridge_plugin_init');


function fbridge_register_options_menu(){
	add_options_page('FanBridge Signup', 'FanBridge Signup', FBSG_PLUGIN_GRANTS, 'fbridge_plugin_settings', 'fbridge_plugin_admin_settings');  
}
add_action('admin_menu', 'fbridge_register_options_menu');


function fbridge_plugin_first_req_handler() {
	if (isset($_GET['_fbridge_action'])) {
		switch ($_GET['_fbridge_action']) {
			case 'widget-css':
				header("Content-type: text/css");

				if (get_option(FBSG_FORM_PREFIX . FBSG_CUSTOM_COLORS) == 'on') {
					fbridge_sw_custom_css(get_option(FBSG_FORM_PREFIX . FBSG_HIGHLIGHT_COLOR, '#CCCCCC'));
				}
				else {
					fbridge_sw_inherit_css();
				}
				
				exit;
		}
	}
}
add_action('init', 'fbridge_plugin_first_req_handler', 0);
wp_enqueue_style('fanbridge_main_css', home_url('?_fbridge_action=widget-css&cb=' . FBSG_PLUGIN_VERSION));


function fbridge_plugin_load_assets() {
		wp_enqueue_script('jquery.validate', FBSG_PLUGIN_URL . 'js/jquery.validate.min.js', array('jquery'), FBSG_PLUGIN_VERSION);
		wp_enqueue_script('css_browser_selector', FBSG_PLUGIN_URL . 'js/css_browser_selector.js', false, FBSG_PLUGIN_VERSION);
}

function fbridge_plugin_action_links($links) {
	$settings_page = add_query_arg(array('page' => 'fbridge_plugin_settings'), admin_url('options-general.php'));
	$settings_link = '<a href="'.esc_url($settings_page).'">' . __('Settings', 'fanbridge-signup') . '</a>';
	array_unshift($links, $settings_link);
	return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'fbridge_plugin_action_links', 10, 1);


/**
 * registers the plugin to the blog
 *
 * @param void
 * @return void
 */
function fbridge_register_widget() {
	register_widget('FanBridge_SignUp_Widget');
}
add_action('widgets_init', 'fbridge_register_widget');


/**
 * manages the request inside the admin site
 *
 */
function fbridge_plugin_request_handler() {
	global $fb_errors;

	if (isset($_POST['_fbridge_action'])) {
		switch ($_POST['_fbridge_action']) {

			case 'save-settings':
			
				$user_id = filter_var($_POST[FBSG_SN_USER_ID], FILTER_SANITIZE_NUMBER_INT);
				$fb_form_title = stripslashes($_POST[FBSG_SN_FORM_TITLE]);
				$fb_form_highlight_color = stripslashes($_POST[FBSG_HIGHLIGHT_COLOR]);

				if (!$user_id) {
					$fb_errors['basic'][] = __('Invalid FanBridge User ID', 'fanbridge-signup');
				}
				if (!strlen(trim($fb_form_title))) {
					$fb_errors['basic'][] = __('Invalid form title', 'fanbridge-signup');
				}
				if (($_POST[FBSG_CUSTOM_COLORS] == 'custom') && (strlen(trim($fb_form_highlight_color)) != 7)) {
					$fb_errors['appearance'][] = __('Invalid highlight color', 'fanbridge-signup');
				}

				if (!count($fb_errors)) {

					// required
					update_option(FBSG_FORM_PREFIX . FBSG_SN_USER_ID, $_POST[FBSG_SN_USER_ID]);

					// fields
					update_option(FBSG_FORM_PREFIX . FBSG_SN_FIRST_NAME . '_show', $_POST[FBSG_SN_FIRST_NAME . '_show'] == 'on' ? 'on' : 'off');
					update_option(FBSG_FORM_PREFIX . FBSG_SN_FIRST_NAME . '_required', $_POST[FBSG_SN_FIRST_NAME . '_required'] == 'on' ? 'on' : 'off');
					update_option(FBSG_FORM_PREFIX . FBSG_SN_LAST_NAME . '_show', $_POST[FBSG_SN_LAST_NAME . '_show'] == 'on' ? 'on' : 'off');
					update_option(FBSG_FORM_PREFIX . FBSG_SN_LAST_NAME . '_required', $_POST[FBSG_SN_LAST_NAME . '_required'] == 'on' ? 'on' : 'off');
					update_option(FBSG_FORM_PREFIX . FBSG_SN_ZIP_CODE . '_show', $_POST[FBSG_SN_ZIP_CODE . '_show'] == 'on' ? 'on' : 'off');
					update_option(FBSG_FORM_PREFIX . FBSG_SN_ZIP_CODE . '_required', $_POST[FBSG_SN_ZIP_CODE . '_required'] == 'on' ? 'on' : 'off');

					update_option(FBSG_FORM_PREFIX . FBSG_SN_CITY . '_show', $_POST[FBSG_SN_CITY . '_show'] == 'on' ? 'on' : 'off');
					update_option(FBSG_FORM_PREFIX . FBSG_SN_CITY . '_required', $_POST[FBSG_SN_CITY . '_required'] == 'on' ? 'on' : 'off');

					update_option(FBSG_FORM_PREFIX . FBSG_SN_STATE . '_show', $_POST[FBSG_SN_STATE . '_show'] == 'on' ? 'on' : 'off');
					update_option(FBSG_FORM_PREFIX . FBSG_SN_STATE . '_required', $_POST[FBSG_SN_STATE . '_required'] == 'on' ? 'on' : 'off');

					update_option(FBSG_FORM_PREFIX . FBSG_SN_COUNTRY . '_show', $_POST[FBSG_SN_COUNTRY . '_show'] == 'on' ? 'on' : 'off');
					update_option(FBSG_FORM_PREFIX . FBSG_SN_COUNTRY . '_required', $_POST[FBSG_SN_COUNTRY . '_required'] == 'on' ? 'on' : 'off');
					update_option(FBSG_FORM_PREFIX . FBSG_SN_BIRTHDATE . '_show', $_POST[FBSG_SN_BIRTHDATE . '_show'] == 'on' ? 'on' : 'off');
	               	update_option(FBSG_FORM_PREFIX . FBSG_SN_BIRTHDATE . '_required', $_POST[FBSG_SN_BIRTHDATE . '_required'] == 'on' ? 'on' : 'off');




					// additional
					update_option(FBSG_FORM_PREFIX . FBSG_SN_FORM_TITLE, $fb_form_title);
					update_option(FBSG_FORM_PREFIX . FBSG_GEOIP, $_POST[FBSG_GEOIP] == 'on' ? 'on' : 'off');

					// styling
					update_option(FBSG_FORM_PREFIX . FBSG_CUSTOM_COLORS, $_POST[FBSG_CUSTOM_COLORS] == 'custom' ? 'on' : 'off');
					update_option(FBSG_FORM_PREFIX . FBSG_HIGHLIGHT_COLOR, $fb_form_highlight_color);
					update_option(FBSG_FORM_PREFIX . FBSG_SN_COPPA_COMPLIANT, $_POST[FBSG_SN_COPPA_COMPLIANT] == 'on' ? 'on' : 'off');
				}
				else {
					// we found errors;
				}

			break;
		}
	}
}
add_action('init', 'fbridge_plugin_request_handler');


function fbridge_plugin_admin_head() {
	$out = '';
	$out .= "\n" . '<link type="text/css" rel="stylesheet" href="' . FBSG_PLUGIN_URL . "css/admin.css?cb=" . FBSG_PLUGIN_VERSION . '">';
	$out .= "\n" . '<link type="text/css" rel="stylesheet" href="' . FBSG_PLUGIN_URL . "css/jquery.miniColors.css?cb=" . FBSG_PLUGIN_VERSION . '">';
	$out .= "\n" . '<script type="text/javascript" src="' . FBSG_PLUGIN_URL . "js/jquery.miniColors.min.js?cb=" . FBSG_PLUGIN_VERSION . '"></script>';
	$out .= "\n";

	echo $out;
}
add_action('admin_head', 'fbridge_plugin_admin_head');


function fbridge_plugin_admin_settings() {
	global $fb_errors;

	?>	
	<div id="fanbridgeConfig">
		<form method="post" action="options-general.php?page=fbridge_plugin_settings">
		<h1><?php _e('FanBridge Signup Form', 'fanbridge-signup') ?></h1>
		
		<div class="section">
			<h2><?php _e('Basic Settings', 'fanbridge-signup') ?></h2>
			<?php fbridge_plugin_admin_show_errors($fb_errors['basic']) ?>	
				<label><?php _e('User ID', 'fanbridge-signup') ?></label>
				<input class="textInput" maxlength="12" name="<?php echo FBSG_SN_USER_ID ?>" type="text" value="<?php echo get_option(FBSG_FORM_PREFIX . FBSG_SN_USER_ID); ?>"/>
				<label><?php _e('Signup Form Title', 'fanbridge-signup') ?></label>
				<input class="textInput" name="<?php echo FBSG_SN_FORM_TITLE ?>" type="text" value="<?php echo get_option(FBSG_FORM_PREFIX . FBSG_SN_FORM_TITLE, __('Join my list', 'fanbridge-signup')); ?>"/>
			<p class="callout"><?php _e('Don\'t know your FanBridge user ID? Don\'t worry! Go to your <a target="_blank" href="https://www.fanbridge.com/account">FanBridge Account</a> to find out.', 'fanbridge-signup'); ?></p>
		</div>
		<div class="section">
			<h2><?php _e('Appearance Settings', 'fanbridge-signup'); ?></h2>
			<?php fbridge_plugin_admin_show_errors($fb_errors['appearance']) ?>	
				<table>
					<tbody>
						<tr>
							<td><input type="radio" name="<?php echo FBSG_CUSTOM_COLORS ?>" id="<?php echo FBSG_CUSTOM_COLORS ?>-inherit" value="inherit" <?php checked(get_option(FBSG_FORM_PREFIX . FBSG_CUSTOM_COLORS), 'off'); ?> /> <?php _e('Match Current Wordpress Theme', 'fanbridge-signup'); ?></td>
						</tr>
						<tr>
							<td>
								<input type="radio" name="<?php echo FBSG_CUSTOM_COLORS ?>" id="<?php echo FBSG_CUSTOM_COLORS ?>-custom"  value="custom" <?php checked(get_option(FBSG_FORM_PREFIX . FBSG_CUSTOM_COLORS), 'on'); ?> />
								<?php _e('or, Custom Color', 'fanbridge-signup'); ?> <input size="7" autocomplete="on" maxlength="7" value="<?php echo get_option(FBSG_FORM_PREFIX . FBSG_HIGHLIGHT_COLOR, '#CCCCCC'); ?>" name="<?php echo FBSG_HIGHLIGHT_COLOR ?>" type="text" class="color-picker"/>
							</td>
						</tr>
					</tbody>
				</table>
		</div>
		<div class="section">
			<h2><?php _e('Choose what data you want to collect', 'fanbridge-signup'); ?></h2>
			<table class="largeTable">
				<tbody>
					<tr>
						<th><?php _e('Type', 'fanbridge-signup'); ?></th>
						<th><?php _e('Display?', 'fanbridge-signup'); ?></th>
						<th><?php _e('Make Required?', 'fanbridge-signup'); ?></th>
					</tr>
					<tr>
						<td><?php _e('Email', 'fanbridge-signup'); ?></td>
						<td><input checked="checked" disabled="disabled" type="checkbox" name="email">&nbsp;<?php _e('yes', 'fanbridge-signup'); ?></td>
						<td><input checked="checked" disabled="disabled" type="checkbox">&nbsp;<?php _e('yes', 'fanbridge-signup'); ?></td>
					</tr>
					<tr>
						<td><?php _e('First Name', 'fanbridge-signup'); ?></td>
						<td><input id="<?php echo FBSG_SN_FIRST_NAME ?>-show" onchange="javascript:if(jQuery(this).is(':checked')) { jQuery('#<?php echo FBSG_SN_FIRST_NAME ?>-required').attr('disabled', false); } else{ jQuery('#<?php echo FBSG_SN_FIRST_NAME ?>-required').attr('disabled', true); jQuery('#<?php echo FBSG_SN_FIRST_NAME ?>-required').attr('checked', false); }" name="<?php echo FBSG_SN_FIRST_NAME ?>_show" type="checkbox" <?php checked(get_option(FBSG_FORM_PREFIX . FBSG_SN_FIRST_NAME . '_show'), 'on'); ?>/>&nbsp;<?php _e('yes', 'fanbridge-signup'); ?></td>
						<td><input id="<?php echo FBSG_SN_FIRST_NAME ?>-required" name="<?php echo FBSG_SN_FIRST_NAME ?>_required" type="checkbox" <?php checked(get_option(FBSG_FORM_PREFIX . FBSG_SN_FIRST_NAME . '_required'), 'on'); ?>/>&nbsp;<?php _e('yes', 'fanbridge-signup') ?></td>
					</tr>
					<tr>
						<td><?php _e('Last Name', 'fanbridge-signup'); ?></td>
						<td><input id="<?php echo FBSG_SN_LAST_NAME ?>-show" onchange="javascript:if(jQuery(this).is(':checked')) { jQuery('#<?php echo FBSG_SN_LAST_NAME ?>-required').attr('disabled', false); } else{ jQuery('#<?php echo FBSG_SN_LAST_NAME ?>-required').attr('disabled', true); jQuery('#<?php echo FBSG_SN_LAST_NAME ?>-required').attr('checked', false); }" name="<?php echo FBSG_SN_LAST_NAME ?>_show" type="checkbox" <?php checked(get_option(FBSG_FORM_PREFIX . FBSG_SN_LAST_NAME . '_show'), 'on'); ?>/>&nbsp;<?php _e('yes', 'fanbridge-signup'); ?></td>
						<td><input id="<?php echo FBSG_SN_LAST_NAME ?>-required" name="<?php echo FBSG_SN_LAST_NAME ?>_required" type="checkbox" <?php checked(get_option(FBSG_FORM_PREFIX . FBSG_SN_LAST_NAME . '_required'), 'on'); ?>/>&nbsp;<?php _e('yes', 'fanbridge-signup') ?></td>
					</tr>
					<tr>
						<td><?php _e('Zip Code', 'fanbridge-signup'); ?></td>
						<td><input id="<?php echo FBSG_SN_ZIP_CODE ?>-show" onchange="javascript:if(jQuery(this).is(':checked')) { jQuery('#<?php echo FBSG_SN_ZIP_CODE ?>-required').attr('disabled', false); } else{ jQuery('#<?php echo FBSG_SN_ZIP_CODE ?>-required').attr('disabled', true); jQuery('#<?php echo FBSG_SN_ZIP_CODE ?>-required').attr('checked', false); }" name="<?php echo FBSG_SN_ZIP_CODE ?>_show" type="checkbox" <?php checked(get_option(FBSG_FORM_PREFIX . FBSG_SN_ZIP_CODE . '_show'), 'on'); ?>/>&nbsp;<?php _e('yes', 'fanbridge-signup'); ?></td>
						<td><input id="<?php echo FBSG_SN_ZIP_CODE ?>-required" name="<?php echo FBSG_SN_ZIP_CODE ?>_required" type="checkbox" <?php checked(get_option(FBSG_FORM_PREFIX . FBSG_SN_ZIP_CODE . '_required'), 'on'); ?>/>&nbsp;<?php _e('yes', 'fanbridge-signup') ?></td>
					</tr>
					<tr>
						<td><?php _e('City', 'fanbridge-signup'); ?></td>
						<td><input id="<?php echo FBSG_SN_CITY ?>-show" onchange="javascript:if(jQuery(this).is(':checked')) { jQuery('#<?php echo FBSG_SN_CITY ?>-required').attr('disabled', false); } else{ jQuery('#<?php echo FBSG_SN_CITY ?>-required').attr('disabled', true); jQuery('#<?php echo FBSG_SN_CITY ?>-required').attr('checked', false); }" name="<?php echo FBSG_SN_CITY ?>_show" type="checkbox" <?php checked(get_option(FBSG_FORM_PREFIX . FBSG_SN_CITY . '_show'), 'on'); ?>/>&nbsp;<?php _e('yes', 'fanbridge-signup'); ?></td>
						<td><input id="<?php echo FBSG_SN_CITY ?>-required" name="<?php echo FBSG_SN_CITY ?>_required" type="checkbox" <?php checked(get_option(FBSG_FORM_PREFIX . FBSG_SN_CITY . '_required'), 'on'); ?>/>&nbsp;<?php _e('yes', 'fanbridge-signup') ?></td>
					</tr>
					<tr>
						<td><?php _e('State/Region', 'fanbridge-signup'); ?></td>
						<td><input id="<?php echo FBSG_SN_STATE ?>-show" onchange="javascript:if(jQuery(this).is(':checked')) { jQuery('#<?php echo FBSG_SN_STATE ?>-required').attr('disabled', false); } else{ jQuery('#<?php echo FBSG_SN_STATE ?>-required').attr('disabled', true); jQuery('#<?php echo FBSG_SN_STATE ?>-required').attr('checked', false); }" name="<?php echo FBSG_SN_STATE ?>_show" type="checkbox" <?php checked(get_option(FBSG_FORM_PREFIX . FBSG_SN_STATE . '_show'), 'on'); ?>/>&nbsp;<?php _e('yes', 'fanbridge-signup'); ?></td>
						<td><input id="<?php echo FBSG_SN_STATE ?>-required" name="<?php echo FBSG_SN_STATE ?>_required" type="checkbox" <?php checked(get_option(FBSG_FORM_PREFIX . FBSG_SN_STATE . '_required'), 'on'); ?>/>&nbsp;<?php _e('yes', 'fanbridge-signup') ?></td>
					</tr>
					<tr>
						<td><?php _e('Country', 'fanbridge-signup'); ?></td>
						<td><input id="<?php echo FBSG_SN_COUNTRY ?>-show" onchange="javascript:if(jQuery(this).is(':checked')) { jQuery('#<?php echo FBSG_SN_COUNTRY ?>-required').attr('disabled', false); } else{ jQuery('#<?php echo FBSG_SN_COUNTRY ?>-required').attr('disabled', true); jQuery('#<?php echo FBSG_SN_COUNTRY ?>-required').attr('checked', false); }" name="<?php echo FBSG_SN_COUNTRY ?>_show" type="checkbox" <?php checked(get_option(FBSG_FORM_PREFIX . FBSG_SN_COUNTRY . '_show'), 'on'); ?>/>&nbsp;<?php _e('yes', 'fanbridge-signup'); ?></td>
						<td><input id="<?php echo FBSG_SN_COUNTRY ?>-required" name="<?php echo FBSG_SN_COUNTRY ?>_required" type="checkbox" <?php checked(get_option(FBSG_FORM_PREFIX . FBSG_SN_COUNTRY . '_required'), 'on'); ?>/>&nbsp;<?php _e('yes', 'fanbridge-signup') ?></td>
					</tr>
					<tr>
						<td><?php _e('Birthdate', 'fanbridge-signup'); ?></td>
						<td><input id="<?php echo FBSG_SN_BIRTHDATE ?>-show" onchange="javascript:if(jQuery(this).is(':checked')) { jQuery('#<?php echo FBSG_SN_BIRTHDATE ?>-required').attr('disabled', false); } else{ jQuery('#<?php echo FBSG_SN_BIRTHDATE ?>-required').attr('disabled', true); jQuery('#<?php echo FBSG_SN_BIRTHDATE ?>-required').attr('checked', false); }" name="<?php echo FBSG_SN_BIRTHDATE ?>_show" type="checkbox" <?php checked(get_option(FBSG_FORM_PREFIX . FBSG_SN_BIRTHDATE . '_show'), 'on'); ?>/>&nbsp;<?php _e('yes', 'fanbridge-signup'); ?></td>
						<td><input id="<?php echo FBSG_SN_BIRTHDATE ?>-required" name="<?php echo FBSG_SN_BIRTHDATE ?>_required" type="checkbox" <?php checked(get_option(FBSG_FORM_PREFIX . FBSG_SN_BIRTHDATE . '_required'), 'on'); ?>/>&nbsp;<?php _e('yes', 'fanbridge-signup') ?></td>
					</tr>

				</tbody>	
			</table>
		</div>
		<div class="section">
			<h2><?php _e('Additional Settings', 'fanbridge-signup'); ?></h2>
			<table>
				<tbody>
					<tr>
						<td><input name="<?php echo FBSG_GEOIP ?>" type="checkbox" <?php checked(get_option(FBSG_FORM_PREFIX . FBSG_GEOIP), 'on'); ?>/></td>
						<td><?php _e('Guess Geolocation <i>(This will autofill the form with a fan\'s <a target="_blank" href="http://en.wikipedia.org/wiki/Geolocation"> location based on IP</a>)</i>', 'fanbridge-signup'); ?></td>
					</tr>
					<tr>
						<td><input name="<?php echo FBSG_SN_COPPA_COMPLIANT ?>" id="<?php echo FBSG_SN_COPPA_COMPLIANT ?>" type="checkbox" <?php checked(get_option(FBSG_FORM_PREFIX . FBSG_SN_COPPA_COMPLIANT), 'on'); ?>/></td>
						<td><?php _e('COPPA Compliant', 'fanbridge-signup'); ?></i></td>
					</tr>
				</tbody>
			</table>
		</div>
		<input class="configButton" name="_submit" value="Save settings" type="submit">
		<input name="_fbridge_action" value="save-settings" type="hidden"/>
		</form>
	</div> <!-- End fanbridgeConfig -->

	<script type="text/javascript">
			jQuery(document).ready( function() {
				jQuery(".color-picker").miniColors({
 					letterCase: 'uppercase',
 					open: function() {
 						jQuery('#<?php echo FBSG_CUSTOM_COLORS ?>-custom').attr('checked', true);
 					}
 				});

				jQuery.each(['<?php echo FBSG_SN_FIRST_NAME ?>', '<?php echo FBSG_SN_LAST_NAME ?>', '<?php echo FBSG_SN_ZIP_CODE ?>', '<?php echo FBSG_SN_CITY ?>', '<?php echo FBSG_SN_STATE ?>', '<?php echo FBSG_SN_COUNTRY ?>', '<?php echo FBSG_SN_BIRTHDATE ?>'], function(i, value) {
					if (jQuery('#' + value + '-show').is(':checked')) {
							jQuery('#' + value + '-required')
							.attr('disabled', false);
					}
					else {
							jQuery('#' + value + '-required')
							.attr('disabled', true)
							.attr('checked', false);
					}
				});

				jQuery("#<?php echo FBSG_SN_COPPA_COMPLIANT ?>").click(function(){
					var is_checked = jQuery(this).is(':checked');
					if(is_checked)
					{
						jQuery('#<?php echo FBSG_SN_BIRTHDATE ?>-show').attr('checked', 'checked');
						jQuery('#<?php echo FBSG_SN_BIRTHDATE ?>-required').attr('checked', 'checked');
						jQuery('#<?php echo FBSG_SN_BIRTHDATE ?>-required').attr('disabled', false);
					}
				})

				jQuery('#<?php echo FBSG_SN_BIRTHDATE ?>-show, #<?php echo FBSG_SN_BIRTHDATE ?>-required').click(function(){
					if(jQuery("#<?php echo FBSG_SN_COPPA_COMPLIANT ?>").is(':checked'))
					{
						<?php _e('alert("Because you have COPPA Compliance activated, collecting full date of birth is required. To disable this field, you will need to deactivate the COPPA Compliance Setting.");', 'fanbridge-signup'); ?>
						return false;
					}
				});
			});				
	</script>
	<?php
}

/**
 * UTILITY FUNCTIONS
 */

/**
 * Indicates the schema on how should we call the jsonp service
 * 
 * @param void
 * @return string; the string of the schema to use
 */

if (!function_exists('get_schema'))
{
	function get_schema() {
		if (!isset($_SERVER['HTTPS']) || (strtolower($_SERVER['HTTPS']) != 'on'))
		{
			return 'http:';
		}
		return 'https:';
	}
}

/**
 * Display errors in the admin settings forms
 *
 * @param $errors; array of errors to be displayed
 * @return string; the rendered errors ready to be shown
 */
function fbridge_plugin_admin_show_errors($errors) {
	if (count($errors)) {
		echo '<div id="configError"><ul><li>' . implode('</li><li>', $errors) . '</li></ul></div>';
	}
}

// Gabriel Sosa and Magali Ickowicz for FanBridge Inc.
// @pendexgabo
// @maguitai
// 2012
