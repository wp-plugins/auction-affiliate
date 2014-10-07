<?php
/*
Plugin Name: Auction Affiliate
Plugin URI: http://www.auctionaffiliate.co
Description: This plugin enables you to embed eBay items on your WordPress site and earn commissions through the your eBay Partner Network account.
Version: 2.2
Author: Joseph Hawes
Author URI: http://www.josephhawes.co.uk/
License: GPL2
*/

//Settings
$plugin_settings = array(
	'plugin_name' => 'Auction Affiliate',
	'plugin_version' => '2.2',
	'shortcode' => 'auction-affiliate',
	'plugin_prefix' => 'aa',
	'param_lister_prefix' => 'aa',
	'param_banner_prefix' => 'aa_b',
	'param_store_empty_string' => array(
		'aa_aColourP',
		'aa_aColourS',
		'aa_aColourB'
	)
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
	
	$bad = array(
		$plugin_settings['param_banner_prefix'] . $prefix_seperator,
		$plugin_settings['param_lister_prefix'] . $prefix_seperator
	);
	$good = array('', '');
		
	return str_replace($bad, $good, $name);
}


/**
 * Add parameter prefix
 */
function aa_prefix($name, $tool_key = 'lister', $prefix_seperator = '_') {
	global $plugin_settings;
	
	return $plugin_settings['param_' . $tool_key . '_prefix'] . $prefix_seperator . $name;
}

/**
 * Get names of inputs
 */
function aa_get_input_names() {
	global $plugin_settings;
	
	$input_names = array();
	
	foreach($plugin_settings['custom_field_inputs'] as $input) {
		$input_name = aa_unprefix($input['name']);
		
		$input_names[strtolower($input_name)] = $input_name;
	}
	
	return $input_names;
}

/**
 * Wrapper for get_post_meta
 */
function aa_get_post_meta_single($post_id, $field_name) {
	$post_meta_array = get_post_meta($post_id, $field_name);

	//We have a value
	if(sizeof($post_meta_array) > 0) {
		//Can be anything - including an string
		$set_value = $post_meta_array[0];			
	//No post meta
	} else {
		$set_value = false;
	}
	
	return $set_value;
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
/*
			switch($param_key) {
				case 'name':
					$param_value = $plugin_settings['param_lister_prefix'] . '_' . $param_value;
					break;
				case 'id':
					$param_value = $plugin_settings['param_lister_prefix'] . '-' . $param_value;
					break;
			}
*/
			
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
	global $plugin_settings;
	
	//Build Stylesheet URL
	$stylesheet_url = $plugin_settings['stylesheet_url'];
	
	//Output stylesheet link
	echo '<link type="text/css" rel="stylesheet" href="' . $stylesheet_url . '" media="screen" />' . "\n";
}
add_action('wp_head', 'aa_load_stylesheet');

/**
 * Output version #
 */
function aa_output_version() {
	global $plugin_settings;
	echo '<!-- AA v' . $plugin_settings['plugin_version'] . ' -->' . "\n";	
}
add_action('wp_head','aa_output_version');


/**
 * Shortcode
 */
function aa_output_html($shortcode_params = false, $widget_params = false){
	global $post, $plugin_settings, $AA;
	
	//Get tool key
	if($shortcode_params && array_key_exists('tool', $shortcode_params) && in_array($shortcode_params['tool'], array('lister', 'banner'))) {
		//Passes in shortcode
		$tool_key = $shortcode_params['tool'];
	} elseif($widget_params && array_key_exists('tool', $widget_params) && in_array($widget_params['tool'], array('lister', 'banner'))) {
		//Passes in shortcode
		$tool_key = $widget_params['tool'];
	} else {
		//Default
		$tool_key = 'lister';
	}
	$AA->set_tool_key($tool_key);
	
	//If shortcode data
	if(is_array($shortcode_params)) {
		//Validate and re-camel case shortcode attributes	
		$input_names = aa_get_input_names();
		$allowable_shortcode_params = array();
		
		foreach($shortcode_params as $attr_key => $attr_value) {
			//If allowable
			if(array_key_exists($attr_key, $input_names)) {
				$allowable_shortcode_params[$input_names[$attr_key]] = $attr_value;
			}
		}
	//If widget data
	} elseif(is_array($widget_params)) {
		$widget_params_unprefixed = array();
		foreach($widget_params as $attr_key => $attr_value) {
			$attr_key = aa_unprefix($attr_key);
			
			$widget_params_unprefixed[$attr_key] = $attr_value;
		}	
	}
	
	//Build request URL from user options
	foreach($plugin_settings['custom_field_inputs'] as $field) {
		$prefixed_field_name = aa_prefix($field['name'], $tool_key);

		//Don't add client options to URL, also check this param is valid for the tool
		if(($field['name'][0] == 'e' || $field['name'][0] == 'a') && $field[$tool_key . '_param'] == true) {
			//WIDGET
			//There are widget params and this one is a non-empty string value
			if(isset($widget_params_unprefixed) && array_key_exists($field['name'], $widget_params_unprefixed) && $widget_params_unprefixed[$field['name']] !== '') {
				$request_parameters[$field['name']] = $widget_params_unprefixed[$field['name']];

			//SHORTCODE
			//There are shortcode params and this one is allowed
			} elseif(isset($allowable_shortcode_params) && array_key_exists($field['name'], $allowable_shortcode_params)) {
				//Add to URL
				$request_parameters[$field['name']] = $allowable_shortcode_params[$field['name']];

			//CUSTOM FIELD
			//The value for this param is not an empty string and we aren't dealing with a wiget
			} elseif(($field_value = get_post_meta($post->ID, $prefixed_field_name, true)) !== '' && ! isset($widget_params_unprefixed)) {
				//Add to URL
				$request_parameters[$field['name']] = $field_value;
			}
		}
	}

	//Client type
	$request_parameters['aClientType'] = 'WP';

	$AA->set_request_parameters($request_parameters, $tool_key);
	$AA->build_request();
	
	$request = $AA->get_request();
	$cache_id =  $plugin_settings['plugin_prefix'] . '_' . md5($request);

	//Do we have a copy in the cache?
	//FWIW, incase you're curious, eliminating or lowering
	//the transient duration won't affect how often the feed 
	//is updated. It will just cause the same data to be 
	//re-downloaded more often. So now you know!	
	if(false === ($output_html = get_transient($cache_id))) {
		//Run the request
		$AA->do_request();

		//Build HTML
		$AA->build_html_output();		
		
		//Add HTML to cache
		$output_html = $AA->get_html();

		set_transient($cache_id, $output_html, HOUR_IN_SECONDS);		
	}
	
	return $output_html;						
}
add_shortcode($plugin_settings['shortcode'], 'aa_output_html');

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
	global $post, $plugin_settings;
	
	echo '<div id="aa-custom-field-container">' . "\n";
	
	//Tab links
	echo '<ul id="aa-tab-links">' . "\n";
	echo '	<li><a class="aa-tab-link active" data-tab="lister-tab" href="#">Item Lister</a></li>' . "\n";
	echo '	<li><a class="aa-tab-link" data-tab="banner-tab" href="#">Item Banner</a></li>' . "\n";
	echo '</ul>' . "\n";
	
	//Lister tool
	echo '	<div id="lister-tab" class="aa-custom-field-tab">' . "\n";			

	echo '	<div id="aa-custom-field-help">' . "\n";
	echo '		<p>Use these options to specify which eBay items to display within your page/post. Add the following shortcode within your content editor to specify where the items will appear:<br /><br />[' . $plugin_settings['shortcode'] . ' tool="lister"]<br /><br /></p>' . "\n";
	echo '		<p>Multiple shortcodes can be added, see the plugin help section for more information:<br /><br /></p>' . "\n";
	echo '		<a class="button thickbox" href="#TB_inline?width=600&height=550&inlineId=aa-help-popup">Plugin Help</a>' . "\n";
	echo '	</div>' . "\n";

	$current_group = false;
	$count = 0;
	foreach($plugin_settings['custom_field_inputs'] as $field) {
		if($field['lister_param']) {
			//Prefix for this tool
			$field['name'] = aa_prefix($field['name'], 'lister', '_');
			$field['id'] = aa_prefix($field['id'], 'lister', '-');
						
			$group = $plugin_settings['request_parameter_groups'][$field['group']];
			
			//Output group?
			if($current_group != $group) {
				//Close previous fieldset?
				if($current_group !== false) {			
					echo '		</div>' . "\n";
					echo '	</fieldset>' . "\n";					
				}
				echo '		<fieldset class="parameter-group" id="parameter-group-' . $field['group'] . '">' . "\n";					
				echo '			<legend title="Click to expand">' . $group['name'] . '</legend>' . "\n";
				echo '			<div class="parameter-group-content">' . "\n";
				echo '				<p>' . $group['description'] . '</p>' . "\n";
				$current_group = $group;
			}

			//Post meta?
			$set_value = aa_get_post_meta_single($post->ID, $field['name']);
						
			aa_create_param_input($field, $count, $set_value);
			$count++;			
		}
	}
	echo '			</div>' . "\n";
	echo '		</fieldset>' . "\n";				
	echo '	</div>' . "\n";
		
	//Banner tool
	echo '	<div id="banner-tab" class="aa-custom-field-tab" style="display:none">' . "\n";			

	echo '	<div id="aa-custom-field-help">' . "\n";
	echo '		<p>Use these options to specify which eBay items to display within your page/post. Add the following shortcode within your content editor to specify where the items will appear:<br /><br />[' . $plugin_settings['shortcode'] . ' tool="banner"]<br /><br /></p>' . "\n";
	echo '		<p>Multiple shortcodes can be added, see the plugin help section for more information:<br /><br /></p>' . "\n";
	echo '		<a class="button thickbox" href="#TB_inline?width=600&height=550&inlineId=aa-help-popup">Plugin Help</a>' . "\n";
	echo '	</div>' . "\n";

	$current_group = false;
	$count = 0;
	foreach($plugin_settings['custom_field_inputs'] as $field) {
		if($field['banner_param']) {
			//Make some tweaks
			switch($field['name']) {
				case 'eCount' :
					$field['default'] = 8;
					$field['title'] = str_replace('Page', 'Banner', $field['title']);
					$field['tip'] = str_replace('on each page.', 'in each banner (in total)', $field['tip']);
					
					break;
			}
			
			//Prefix for this tool
			$field['name'] = aa_prefix($field['name'], 'banner', '_');
			$field['id'] = aa_prefix($field['id'], 'banner', '-');

			$group = $plugin_settings['request_parameter_groups'][$field['group']];

			//Output group?
			if($current_group != $group) {
				//Close previous fieldset?
				if($current_group !== false) {			
					echo '		</div>' . "\n";
					echo '	</fieldset>' . "\n";					
				}
				echo '		<fieldset class="parameter-group" id="parameter-group-' . $field['group'] . '">' . "\n";					
				echo '			<legend title="Click to expand">' . $group['name'] . '</legend>' . "\n";
				echo '			<div class="parameter-group-content">' . "\n";
				echo '				<p>' . $group['description'] . '</p>' . "\n";
				$current_group = $group;
			}

			//Post meta?
			$set_value = aa_get_post_meta_single($post->ID, $field['name']);
						
			aa_create_param_input($field, $count, $set_value);
			$count++;			
		}
	}
	echo '			</div>' . "\n";
	echo '		</fieldset>' . "\n";				
	echo '	</div>' . "\n";
	
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
function aa_create_param_input($field, $count = false, $set_value = false) {
	
	//Do we have a default?
	if(! array_key_exists('default', $field)) {
		$field['default'] = false;
	}

	//Container
	$alt = ($count !== false && $count % 2) ? ' alt' : '';
	$out .= '<div class="control-group ' . aa_unprefix($field['id'], '-') . '-container' . $alt . '">' . "\n";
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
			//We have a value
			if($set_value !== false) {
				$set_value = htmlspecialchars($set_value);
				$out .= ' value="' . $set_value . '"';
			//We aren't being passed anything, but there is a default
			} elseif($set_value = $field['default']) {
				$out .= ' value="' . $set_value . '"';			
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
		//Lister
		$lister_field_name = aa_prefix($field['name'], 'lister');
		if(isset($_POST[$lister_field_name]) && (trim($_POST[$lister_field_name]) !== false)) {
			$value = $_POST[$lister_field_name];
			update_post_meta($post_id, $lister_field_name, $value);
		//Is allowed to be emptry string
		} elseif(isset($_POST[$lister_field_name]) && in_array($lister_field_name, $plugin_settings['param_store_empty_string']))  {
			$value = $_POST[$lister_field_name];
			update_post_meta($post_id, $lister_field_name, $value);		
		} else {
			delete_post_meta($post_id, $lister_field_name);
		}
		
		//Banner
		$banner_field_name = aa_prefix($field['name'], 'banner');
		if(isset($_POST[$banner_field_name]) && (trim($_POST[$banner_field_name]) !== false)) {
			$value = $_POST[$banner_field_name];
			update_post_meta($post_id, $banner_field_name, $value);
		//Is allowed to be emptry string
		} elseif(isset($_POST[$banner_field_name]) && in_array($banner_field_name, $store_empty_string))  {
			$value = $_POST[$banner_field_name];
			update_post_meta($post_id, $banner_field_name, $value);		
		} else {
			delete_post_meta($post_id, $banner_field_name);
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
	global $plugin_settings, $wpdb;
	
	//Are we clearing the cache?
	if($_GET['aa_clear_cache'] === 'true' && ! array_key_exists('settings-updated', $_GET)) {
		$wpdb->query($wpdb->prepare("
				DELETE FROM $wpdb->options
				WHERE option_name LIKE '%s'
				OR option_name LIKE '%s'
			", 
			array(
				'_transient_' . $plugin_settings['plugin_prefix'] . '_%', 
				'_transient_timeout_' . $plugin_settings['plugin_prefix'] . '_%' 
			) 
		));
		echo '<div id="aa_cache" class="updated settings-error">' . "\n";
		echo '	<p><strong>Plugin cache cleared.</strong></p>' . "\n";
		echo '</div>' . "\n";
	}

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
/*
 	echo '<h3>Clear Cache</h3>';
 	echo '<p>This will delete the entire cache for the plugin!</p>';
 	echo '<a href="options-general.php?page=aa_options_page&aa_clear_cache=true" class="button">Clear cache!</a>';
*/
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
		
		//Affiliate
		add_settings_section('aa_defaults_affiliate', 'Affiliate Defaults', 'aa_defaults_affiliate_text', 'aa');
		add_settings_field('aa_default_eSite', 'Default eBay Site', 'aa_default_eSite_setting', 'aa', 'aa_defaults_affiliate');
		add_settings_field('aa_default_eCampID', 'Default EPN Campaign ID', 'aa_default_eCampID_setting', 'aa', 'aa_defaults_affiliate');
		add_settings_field('aa_default_eCustomID', 'Default EPN Custom ID', 'aa_default_eCustomID_setting', 'aa', 'aa_defaults_affiliate');
		
		//Lister
		add_settings_section('aa_defaults_lister', 'Item Lister Defaults', 'aa_defaults_lister_text', 'aa');
		add_settings_field('aa_default_aTheme', 'Default Theme', 'aa_default_aTheme_setting', 'aa', 'aa_defaults_lister');
		add_settings_field('aa_default_aColourP', 'Default Primary Colour', 'aa_default_aColourP_setting', 'aa', 'aa_defaults_lister');
		add_settings_field('aa_default_aColourS', 'Default Secondary Colour', 'aa_default_aColourS_setting', 'aa', 'aa_defaults_lister');
		add_settings_field('aa_default_aColourB', 'Default Background Colour', 'aa_default_aColourB_setting', 'aa', 'aa_defaults_lister');
	}
}
add_action('admin_init', 'aa_admin_settings');

/**
 * Text to accompany default settings section
 */
function aa_defaults_text() {
	echo '<p>The settings below enable you to specify default preferences, saving you from entering them each time when adding ' . $plugin_settings['plugin_name'] . ' to your pages or posts. Defaults can easily be overridden on a page-by-page basis.</p>' . "\n";
	echo '<p><small>Hover over the question marks for an explanation of each setting, or click the <a class="thickbox" href="#TB_inline?width=600&height=550&inlineId=aa-help-popup">Plugin Help</a> link for further information.</small></p>' . "\n";
}

/**
 * Text to accompany affiliate defaults section
 */
function aa_defaults_affiliate_text() {
	echo '<p></p>' . "\n";
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
 * Output default campaign setting
 */
function aa_default_eCampID_setting() {
	global $plugin_settings;
	$options = get_option('aa_options');
	
	echo '<input type="text" name="aa_options[aa_default_eCampID]" value="' . $options['aa_default_eCampID'] . '" />' . "\n";
	echo '<a href="#" class="tip" title="' . $plugin_settings['custom_field_inputs']['eCampID']['tip'] . '" onclick="return false">?</a>' . "\n";
}

/**
 * Output default custom ID setting
 */
function aa_default_eCustomID_setting() {
	global $plugin_settings;
	$options = get_option('aa_options');
	
	echo '<input type="text" name="aa_options[aa_default_eCustomID]" value="' . $options['aa_default_eCustomID'] . '" />' . "\n";
	echo '<a href="#" class="tip" title="' . $plugin_settings['custom_field_inputs']['eCustomID']['tip'] . '" onclick="return false">?</a>' . "\n";
}

/**
 * Text to accompany affiliate defaults section
 */
function aa_defaults_lister_text() {
	echo '<p></p>' . "\n";
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


/**
 * ======================================================== 
 * ==================== WIDGETS ===========================
 * ========================================================
 */

function aa_display_widget_title($instance) {
	if(array_key_exists('aa_widget_title', $instance) && $instance['aa_widget_title']) {
		return '<h1 class="widget-title">' . $instance['aa_widget_title'] . '</h1>' . "\n";
	}	else {
		return '';
	}
}

function aa_get_widget_title($instance) {
	return (! empty($instance['aa_widget_title'])) ? strip_tags($instance['aa_widget_title']) : false;
}

function aa_build_widget_title_input($instance, $count, $widget_field_name) {
	$field = array(
		'name' => 'aa_widget_title',
		'id' => 'aa_widget_title',
		'tip' => 'A title to appear above the widget (optional)',
		'title' => 'Widget Title'
	);
	
	//If title already set then use that, otherwise use empty string
	$set_value = (isset($instance[$field['name']])) ? $instance[$field['name']] : '';

	//Widgetized field name
	$field['name'] = $widget_field_name;

	aa_create_param_input($field, $count, $set_value);
}

class Auction_Affiliate_Widget extends WP_Widget {
	protected $widget_id;
	protected $widget_name;
	protected $widget_desc;
	protected $widget_tool;
			
	public function widget($args, $instance) {
		echo '<aside class="widget aa-' . $this->widget_tool . '-widget">' . "\n";
		echo aa_display_widget_title($instance);
		unset($instance['aa_widget_title']);

		$instance['tool'] = $this->widget_tool;		
		echo aa_output_html(false, $instance);
		
		echo '</aside>' . "\n";
	}

	public function form($instance) {
		global $plugin_settings;
		
		$count = 0;		

		echo '<div class="aa-widget-container">' . "\n";	
		aa_build_widget_title_input($instance, $count, $this->get_field_name('aa_widget_title'));
		$count++;

		$current_group = false;
		$count = 0;
		foreach($plugin_settings['custom_field_inputs'] as $field) {
			//Param for this tool?
			if($field[$this->widget_tool . '_param']) {
				//Make some tweaks
				if($this->widget_tool == 'banner') {
					switch($field['name']) {
						case 'eCount' :
							$field['default'] = 8;
							$field['title'] = str_replace('Page', 'Banner', $field['title']);
							$field['tip'] = str_replace('on each page.', 'in each banner (in total)', $field['tip']);
							
							break;
					}
				}
				
				//Prefix for this tool
				$field['name'] = aa_prefix($field['name'], $this->widget_tool, '_');
				$field['id'] = aa_prefix($field['id'], $this->widget_tool, '-');
							
				$group = $plugin_settings['request_parameter_groups'][$field['group']];
				
				//Output group?
				if($current_group != $group) {
					//Close previous fieldset?
					if($current_group !== false) {			
						echo '		</div>' . "\n";
						echo '	</fieldset>' . "\n";					
					}
					echo '		<fieldset class="parameter-group" id="parameter-group-' . $field['group'] . '">' . "\n";					
					echo '			<legend title="Click to expand">' . $group['name'] . '</legend>' . "\n";
					echo '			<div class="parameter-group-content">' . "\n";
					echo '				<p>' . $group['description'] . '</p>' . "\n";
					$current_group = $group;
				}

				//If value already set then use that, otherwise send false
				$set_value = (isset($instance[$field['name']])) ? $instance[$field['name']] : false;

				//Widgetized field name				
				$field['name'] = $this->get_field_name($field['name']);
				
				aa_create_param_input($field, $count, $set_value);
				$count++;			
			}
		}
		echo '		</div>' . "\n";
		echo '	</fieldset>' . "\n";				
		echo '</div>' . "\n";
	}

	public function update($new_instance, $old_instance) {
		global $plugin_settings;

		$instance = array();

		$instance['aa_widget_title'] = aa_get_widget_title($new_instance);

		foreach($plugin_settings['custom_field_inputs'] as $field) {
			$prefixed_field_name = aa_prefix($field['name'], $this->widget_tool);
			
			//Param is valid for the tool
			if($field[$this->widget_tool . '_param'] == true) {
				$param_value = trim($new_instance[$prefixed_field_name]);
				
				if($param_value !== '' || in_array($prefixed_field_name, $plugin_settings['param_store_empty_string'])) {
					$instance[$prefixed_field_name] = strip_tags($param_value);
				} else {
					$instance[$prefixed_field_name] = '';					
				}
			}
		}
		
		return $instance;
	}
}

class Auction_Affiliate_Lister_Widget extends Auction_Affiliate_Widget {

	public function __construct() {
		$this->widget_id = 'aa_lister_widget';
		$this->widget_name = 'Auction Affiliate Lister';
		$this->widget_desc = 'Add the Item Lister tool to your page.';
		$this->widget_tool = 'lister';
			
		parent::__construct($this->widget_id, $this->widget_name, array(
				'description' => $this->widget_desc
			)
		);		
	}
}

class Auction_Affiliate_Banner_Widget extends Auction_Affiliate_Widget {

	public function __construct() {
		$this->widget_id = 'aa_banner_widget';
		$this->widget_name = 'Auction Affiliate Banner';
		$this->widget_desc = 'Add the Item Banner tool to your page.';
		$this->widget_tool = 'banner';
			
		parent::__construct($this->widget_id, $this->widget_name, array(
				'description' => $this->widget_desc
			)
		);		
	}
}

function aa_widgets_init() {
	register_widget('Auction_Affiliate_Lister_Widget');	
	register_widget('Auction_Affiliate_Banner_Widget');	
}
add_action('widgets_init', 'aa_widgets_init');