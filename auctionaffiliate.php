<?php
/*
Plugin Name: Auction Affiliate
Plugin URI: http://www.auctionaffiliate.co
Description: This plugin enables you to embed eBay items on your WordPress site and earn commissions through the your eBay Partner Network account.
Version: 1.2
Author: Joseph Hawes
Author URI: http://www.josephhawes.co.uk/
License: GPL2
*/

//Settings
$plugin_settings = array(
	'plugin_name' => 'Auction Affiliate',
	'custom_field_prefix' => 'aa',
	'shortcode' => 'auction-affiliate'
);

//Load PHP client
require_once 'auctionaffiliate.class.php';
$AA = new AuctionAffiliate;

//Get settings from PHP Client
aa_get_plugin_settings($AA);

/**
 * ======================================================== 
 * =============== UTILITY FUNCTIONS  =====================
 * ========================================================
 */

/**
 * Remove parameter prefix
 */
function aa_unprefix($name, $prefix_seperator = '_') {
	global $plugin_settings;
	
	return str_replace($plugin_settings['custom_field_prefix'] . $prefix_seperator, '', $name);
}

/**
 * Add parameter prefix
 */
function aa_prefix($name, $prefix_seperator = '_') {
	global $plugin_settings;
	
	return $plugin_settings['custom_field_prefix'] . $prefix_seperator . $name;
}

/**
 * Get names of inputs
 */
function aa_get_input_names($strip_prefix = false) {
	global $plugin_settings;
	
	$input_names = array();
	
	foreach($plugin_settings['custom_field_inputs'] as $input) {
		$input_name = aa_unprefix($input['name']);
		
		$input_names[strtolower($input_name)] = $input_name;
	}
	
	return $input_names;
}

/**
 * Get some settings from PHP client
 */
function aa_get_plugin_settings($AA) {
	global $plugin_settings;
	
	//Get settings
	$settings = $AA->get_settings();
	
	//Set some plugin settings
	$plugin_settings['html_output_id_prefix'] = $settings['html_output_id_prefix'];
	$plugin_settings['html_output_prefix'] = $settings['html_output_prefix'];
	$plugin_settings['stylesheet_url'] = $settings['stylesheet_url'];
	$plugin_settings['request_parameter_groups'] = $settings['request_parameter_groups'];
	
	//Custom field definitions
	$definitions = $settings['request_parameter_definitions'];
	foreach($definitions as $def_key => &$def_value) {	
		foreach($def_value as $param_key => &$param_value) {
			switch($param_key) {
				case 'name':
					$param_value = $plugin_settings['custom_field_prefix'] . '_' . $param_value;
					break;
				case 'id':
					$param_value = $plugin_settings['custom_field_prefix'] . '-' . $param_value;
					break;
			}
			
			//Do we have a default?
			if($default = aa_get_option('aa_default_' . $def_key)) {
				$def_value['default'] = $default;
			}
		}
		$plugin_settings['custom_field_inputs'][$def_key] = $def_value;
	}
}

/**
 * ======================================================== 
 * =================== FRONT END ==========================
 * ========================================================
 */

/**
 * Load the stylesheet in the head element
 */
function aa_load_stylesheet() {
	global $post, $plugin_settings;
	
	//Get theme
	$theme = get_post_meta($post->ID, 'aa_aTheme', true);
	
	//Build Stylesheet URL
	$stylesheet_url = $plugin_settings['stylesheet_url'];
	
	//Output stylesheet link
	echo '<link type="text/css" rel="stylesheet" href="' . $stylesheet_url . '" media="screen" />' . "\n";
}
add_action('wp_head', 'aa_load_stylesheet');

/**
 * Shortcode
 */
function aa_shortcode($shortcode_attrs){
	global $post, $plugin_settings, $AA;
	
	//If shortcode data
	if(is_array($shortcode_attrs)) {
		//Validate and re-camel case shortcode attributes	
		$input_names = aa_get_input_names();
		$allowable_shortcode_attrs = array();
		foreach($shortcode_attrs as $attr_key => $attr_value) {
			//If allowable
			if(array_key_exists($attr_key, $input_names)) {
				$allowable_shortcode_attrs[$input_names[$attr_key]] = $attr_value;
			}
		}	
	}
	
	//Build request URL from user options
	foreach($plugin_settings['custom_field_inputs'] as $field) {
		$unprefixed_field_name = aa_unprefix($field['name']);
		
		//Don't add client options to URL
		if($unprefixed_field_name[0] == 'e' || $unprefixed_field_name[0] == 'a') {
			//If it is in SHORTCODE attributes use that
			if(isset($allowable_shortcode_attrs) && array_key_exists($unprefixed_field_name, $allowable_shortcode_attrs)) {
				//Add to URL
				$request_parameters[$unprefixed_field_name] = $allowable_shortcode_attrs[$unprefixed_field_name];
			//Get CUSTOM FIELD value
			} elseif($field_value = get_post_meta($post->ID, $field['name'], true)) {
				//Add to URL
				$request_parameters[$unprefixed_field_name] = $field_value;
			}
		}
	}

	//Client type
	$request_parameters['aClientType'] = 'WP';
	
	//Add account key
	$options = get_option('aa_options', array());
	if(array_key_exists('aa_aKey', $options)) {
		$request_parameters['aKey'] = $options['aa_aKey'];
	}

	return $AA->embed($request_parameters, false);
}
add_shortcode($plugin_settings['shortcode'], 'aa_shortcode');

/**
 * ======================================================== 
 * ================== ADMIN ONLY ==========================
 * ========================================================
 */

function aa_admin_init() {
	//Permissions
	if(current_user_can('manage_options')) {
		//Add custom fields
		add_action( 'admin_head-post.php', 'aa_create_custom_fields_box' );
		add_action( 'admin_head-post-new.php', 'aa_create_custom_fields_box' );

		//Save custom fields
		add_action('save_post', 'aa_save_custom_fields', 10, 2);

		//Add CSS
		wp_register_style('aa_css', plugins_url('auctionaffiliate.css', __FILE__));
		wp_enqueue_style('aa_css');	

		//Add JS
		wp_register_script('aa_js', plugins_url('auctionaffiliate.js', __FILE__), array('jquery'));
		wp_enqueue_script('aa_js');
		
		//Thickbox
		add_thickbox();		
	}
}
add_action('admin_init', 'aa_admin_init');

/**
 * ======================================================== 
 * ================= CUSTOM FIELDS ========================
 * ========================================================
 */
 
/**
 * Create the custom fields box
 */
function aa_create_custom_fields_box() {
	global $plugin_settings;
	
	foreach(array('post', 'page') as $post_type) {
		add_meta_box('aa-custom-fields', $plugin_settings['plugin_name'], 'aa_create_custom_field_form', $post_type, 'normal', 'high');
	}
}

/**
 * Create the custom field form
 */
function aa_create_custom_field_form() {
	global $plugin_settings;
	
	echo '<div id="aa-custom-field-container">' . "\n";
	echo '	<div id="aa-custom-field-help">' . "\n";
	echo '		<p>Use these options to specify which eBay items to display within your page/post. Add the following shortcode within your content editor to specify where the items wil appear:<br /><br />[' . $plugin_settings['shortcode'] . ']<br /></p>' . "\n";
	echo '		<br /><a class="button thickbox" href="#TB_inline?width=600&height=550&inlineId=aa-help-popup">Plugin Help</a>' . "\n";
	echo '	</div>' . "\n";
	$current_group = false;
	$count = 0;
	foreach($plugin_settings['custom_field_inputs'] as $field) {
		$group = $plugin_settings['request_parameter_groups'][$field['group']];
		//Output group?
		if($current_group != $group) {
			//Close previous fieldset?
			if($current_group !== false) {			
				echo '	</div>' . "\n";
				echo '</fieldset>' . "\n";					
			}
			echo '	<fieldset class="parameter-group" id="parameter-group-' . $field['group'] . '">' . "\n";					
			echo '		<legend title="Click to expand">' . $group['name'] . '</legend>' . "\n";
			echo '		<div class="parameter-group-content">' . "\n";
			echo '			<p>' . $group['description'] . '</p>' . "\n";
			$current_group = $group;
		}
		aa_create_custom_field_input($field, $count);
		$count++;
	}
	echo '		</div>' . "\n";
	echo '	</fieldset>' . "\n";				
	echo '	<div id="aa-help-popup" style="display:none;">'. "\n";
	ob_start();
	require 'auctionaffiliate.help.php';
	ob_end_flush();	
 	echo '	</div>'	. "\n";
	echo '</div>' . "\n";
}

/**
 * Create the custom fields inputs
 */
function aa_create_custom_field_input($field, $count = false) {
	global $post, $plugin_settings;
	
	//Do we have a default?
	if(! array_key_exists('default', $field)) {
		$field['default'] = false;
	}

	//Container
	$alt = ($count !== false && $count % 2) ? ' alt' : '';
	$out .= '<div class="control-group' . $alt . '" id="' . $field['name'] . '-container">' . "\n";
	//Required
	$required = '';
	if($param['parameter_required']) {
		$required = ' <span class="required">*</span>';
	}
	//Tip
	$tip = '';
	if($field['tip']) {
		$tip = ' <a class="tip" title="' . $field['tip'] . '" href="#" onclick="return false;">?</a>';
	}
	//Label
	$out .= '	<label class="control-label" for="' . $field['name'] . '">' . $field['title'] . $required . $tip .  '</label>' . "\n";
	$out .= '	<div class="controls">' . "\n";				
	
	switch($field['type']) {
		case 'select' :
			$out .= '		<select name="' . $field['name'] . '" id="' . $field['name'] . '">' . "\n";
			foreach($field['options'] as $value => $description) {
				$set_value = get_post_meta($post->ID, $field['name'], true);
				$out .= '			<option value="' . $value . '"';
				//Has this value already been set
				if($set_value == $value) {
					$out .= ' selected="selected"';
				//Do we have a default?
				}	elseif(! $set_value && ($field['default'] && $field['default'] == $value)) {
					$out .= ' selected="selected"';				
				}		
				$out .= '>' . $description . '</option>' . "\n";
			}
			$out .= '		</select>' . "\n";
			break;
		case 'checkbox' :
			//Value submitted?
			$checked = false;
			$set_value = get_post_meta($post->ID, $field['name'], true);
			if($set_value && ($set_value == 'true' || $set_value == $field['value'])) {
				$checked = true;
			} elseif($field['default'] == 'true') {
				$checked = true;								
			}
			$value = ($field['value']) ? $field['value'] : 'true';
			$out .= '		<input type="checkbox" name="' . $field['name'] . '" value="' . $value . '" id="' . $field['name'] . '"';
			if($checked) {
				$out .= ' checked="checked"';			
			}
			$out .= ' />' . "\n";			
			break;
		case 'radio' :
			foreach($field['options'] as $value => $description) {
				$set_value = get_post_meta($post->ID, $field['name'], true);
				//Value submitted?
				if(! $checked = ($set_value == $value)) {
					$checked = $value == $field['default'];
				}
				$out .= '<div class="radio">' . "\n";
				$out .= '	<input type="radio" name="' . $field['name'] . '" value="' . $value . '"';
				if($checked) {
					$out .= ' checked="checked"';			
				}				
				$out .= ' />' . "\n";						
				$out .= $description . '<br />' . "\n";						
				$out .= '</div>' . "\n";
			}
			break;						
		case 'text' :
		default :
			$out .= '		<input type="text" name="' . $field['name'] . '" id="' . $field['name'] . '"';
			if($value = htmlspecialchars(get_post_meta($post->ID, $field['name'], true))) {
				$out .= ' value="' . $value . '"';
			//Do we have a default?
			}	elseif($value = $field['default']) {
				$out .= ' value="' . $value . '"';			
			}
			$out .= ' />' . "\n";
			break;
	}
	$out .= '	</div>' . "\n";								
	$out .= '</div>' . "\n";
	
	echo $out;
}

/**
 * Save the custom field data
 */
function aa_save_custom_fields($post_id, $post) {
	global $plugin_settings;
	
	foreach($plugin_settings['custom_field_inputs'] as $field) {
		if(isset($_POST[$field['name']]) && trim($_POST[$field['name']])) {
			$value = $_POST[$field['name']];
			update_post_meta($post_id, $field['name'], $value);
		} else {
			delete_post_meta($post_id, $field['name']);
		}
	}
}

/**
 * ======================================================== 
 * ================== OPTIONS PAGE ========================
 * ========================================================
 */

/**
 * Create options page
 */
function aa_admin_page() {
	//Permissions
	if(current_user_can('manage_options')) {
		global $plugin_settings;
		add_options_page($plugin_settings['plugin_name'] . ' Options', $plugin_settings['plugin_name'], 'manage_options', 'aa_options_page', 'aa_options_page');
	}
}
add_action('admin_menu', 'aa_admin_page');

/**
 * Display the admin options page
 */
function aa_options_page() {
	global $plugin_settings;

	echo '<div id="aa-options-container">' . "\n";
	echo '<a class="button right thickbox" href="#TB_inline?width=600&height=550&inlineId=aa-help-popup">Plugin Help</a>' . "\n";
	echo '	<h2>' . $plugin_settings['plugin_name'] . '</h2>' . "\n";
	echo '	<form action="options.php" method="post">' . "\n";
	settings_fields('aa_options');
	do_settings_sections('aa');
	echo '	<input class="button button-primary" name="Submit" type="submit" value="Save Settings" />' . "\n";
	echo '	</form>' . "\n";
	echo '	<div id="aa-help-popup" style="display:none;">'. "\n";
	ob_start();
	require 'auctionaffiliate.help.php';
	ob_end_flush();	
 	echo '	</div>'	. "\n";
	echo '</div>' . "\n";
}

/**
 * Define settings
 */
function aa_admin_settings(){
	//Permissions
	if(current_user_can('manage_options')) {
		global $plugin_settings;

		register_setting('aa_options', 'aa_options', 'aa_options_validate');
		add_settings_section('aa_defaults', 'Default Settings', 'aa_defaults_text', 'aa');
		add_settings_field('aa_default_eSite', 'Default eBay Site', 'aa_default_eSite_setting', 'aa', 'aa_defaults');
		add_settings_field('aa_default_eCampID', 'Default EPN Campaign ID', 'aa_default_eCampID_setting', 'aa', 'aa_defaults');
		add_settings_field('aa_default_eCustomID', 'Default EPN Custom ID', 'aa_default_eCustomID_setting', 'aa', 'aa_defaults');
		add_settings_field('aa_default_aTheme', 'Default Theme', 'aa_default_aTheme_setting', 'aa', 'aa_defaults');
		add_settings_field('aa_default_aColourP', 'Default Primary Colour', 'aa_default_aColourP_setting', 'aa', 'aa_defaults');
		add_settings_field('aa_default_aColourS', 'Default Secondary Colour', 'aa_default_aColourS_setting', 'aa', 'aa_defaults');
		add_settings_field('aa_default_aColourB', 'Default Background Colour', 'aa_default_aColourB_setting', 'aa', 'aa_defaults');
	}
}
add_action('admin_init', 'aa_admin_settings');

/**
 * Text to accompany app settings section
 */
function aa_app_text() {
	echo '<p>Some text about app settings...</p>' . "\n";
}

/**
 * Output account key setting
 */
function aa_aKey_setting() {
	$options = get_option('aa_options');
	
	echo '<input type="text" name="aa_options[aa_aKey]" value="' . $options['aa_aKey'] . '" />' . "\n";
	echo '<a href="#" class="tip" title="This is your account key" onclick="return false">?</a>' . "\n";
}

/**
 * Text to accompany default settings section
 */
function aa_defaults_text() {
	echo '<p>The settings below enable you to specify default preferences, saving you from entering them each time when adding ' . $plugin_settings['plugin_name'] . ' to your pages or posts. Defaults can easily be overridden on a page-by-page basis.</p>' . "\n";
	echo '<p><small>Hover over the question marks for an explanation of each setting, or click the <a class="thickbox" href="#TB_inline?width=600&height=550&inlineId=aa-help-popup">Plugin Help</a> link for further information.</small></p>' . "\n";
}

/**
 * Output eBay site setting
 */
function aa_default_eSite_setting() {
	global $plugin_settings;
	$options = get_option('aa_options');
	
	echo '<select name="aa_options[aa_default_eSite]">' . "\n";
	foreach($plugin_settings['custom_field_inputs']['eSite']['options'] as $option_key => $option_value) {
		$selected = ($options['aa_default_eSite'] == $option_key) ? ' selected="selected"' : ''; 
		echo '	<option value="' . $option_key . '"' . $selected . '>' . $option_value . '</option>' . "\n";		
	}
	echo '</select>' . "\n";
	echo '<a href="#" class="tip" title="' . $plugin_settings['custom_field_inputs']['eSite']['tip'] . '" onclick="return false">?</a>' . "\n";
}

/**
 * Output default theme setting
 */
function aa_default_aTheme_setting() {
	global $plugin_settings;
	$options = get_option('aa_options');
	
	echo '<select name="aa_options[aa_default_aTheme]">' . "\n";
	foreach($plugin_settings['custom_field_inputs']['aTheme']['options'] as $option_key => $option_value) {
		$selected = ($options['aa_default_aTheme'] == $option_key) ? ' selected="selected"' : ''; 
		echo '	<option value="' . $option_key . '"' . $selected . '>' . $option_value . '</option>' . "\n";		
	}
	echo '</select>' . "\n";
	echo '<a href="#" class="tip" title="' . $plugin_settings['custom_field_inputs']['aTheme']['tip'] . '" onclick="return false">?</a>' . "\n";	
}

/**
 * Output default campaign setting
 */
function aa_default_eCampID_setting() {
	global $plugin_settings;
	$options = get_option('aa_options');
	
	echo '<input type="text" name="aa_options[aa_default_eCampID]" value="' . $options['aa_default_eCampID'] . '" />' . "\n";
	echo '<a href="#" class="tip" title="' . $plugin_settings['custom_field_inputs']['eCampID']['tip'] . '" onclick="return false">?</a>' . "\n";
}

/**
 * Output default campaign setting
 */
function aa_default_eCustomID_setting() {
	global $plugin_settings;
	$options = get_option('aa_options');
	
	echo '<input type="text" name="aa_options[aa_default_eCustomID]" value="' . $options['aa_default_eCustomID'] . '" />' . "\n";
	echo '<a href="#" class="tip" title="' . $plugin_settings['custom_field_inputs']['eCustomID']['tip'] . '" onclick="return false">?</a>' . "\n";
}

/**
 * Output default campaign setting
 */
function aa_default_aColourP_setting() {
	global $plugin_settings;
	$options = get_option('aa_options');
	
	echo '<input type="text" name="aa_options[aa_default_aColourP]" value="' . $options['aa_default_aColourP'] . '" />' . "\n";
	echo '<a href="#" class="tip" title="' . $plugin_settings['custom_field_inputs']['aColourP']['tip'] . ' Must be a hexidecimal colour with no leading hash (e.g. F5F5F5)" onclick="return false">?</a>' . "\n";
}

/**
 * Output default campaign setting
 */
function aa_default_aColourS_setting() {
	global $plugin_settings;
	$options = get_option('aa_options');
	
	echo '<input type="text" name="aa_options[aa_default_aColourS]" value="' . $options['aa_default_aColourS'] . '" />' . "\n";
	echo '<a href="#" class="tip" title="' . $plugin_settings['custom_field_inputs']['aColourS']['tip'] . ' Must be a hexidecimal colour with no leading hash (e.g. F5F5F5)" onclick="return false">?</a>' . "\n";
}

/**
 * Output default campaign setting
 */
function aa_default_aColourB_setting() {
	global $plugin_settings;
	$options = get_option('aa_options');
	
	echo '<input type="text" name="aa_options[aa_default_aColourB]" value="' . $options['aa_default_aColourB'] . '" />' . "\n";
	echo '<a href="#" class="tip" title="' . $plugin_settings['custom_field_inputs']['aColourB']['tip'] . ' Must be a hexidecimal colour with no leading hash (e.g. F5F5F5)" onclick="return false">?</a>' . "\n";
}

/**
 * Validate our options
 */
function aa_options_validate($input) {
	$output['aa_aKey'] = trim($input['aa_aKey']);
	$output['aa_default_eSite'] = trim($input['aa_default_eSite']);
	$output['aa_default_aTheme'] = trim($input['aa_default_aTheme']);
	$output['aa_default_eCampID'] = trim($input['aa_default_eCampID']);
	$output['aa_default_eCustomID'] = trim($input['aa_default_eCustomID']);
	$output['aa_default_aColourP'] = trim($input['aa_default_aColourP']);
	$output['aa_default_aColourS'] = trim($input['aa_default_aColourS']);
	$output['aa_default_aColourB'] = trim($input['aa_default_aColourB']);
	return $output;
}

/**
 * Get plugin options
 */
function aa_get_option($option_key) {
	$options = get_option('aa_options');
	
	if(is_array($options) && array_key_exists($option_key, $options)) {
		return $options[$option_key];		
	} else {
		return false;		
	}
}