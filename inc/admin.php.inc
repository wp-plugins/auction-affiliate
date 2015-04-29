<?php
	
/**
 * ======================================================== 
 * ================== ADMIN ONLY ==========================
 * ========================================================
 */

function aa_admin_init() {
	global $aa_settings;
	
	//Permissions
	if(current_user_can('manage_options')) {
		//Get settings
		foreach($aa_settings['custom_field_inputs'] as $input_key => $input_value) {	
			if($default = aa_get_option('aa_default_' . $input_key)) {
				$aa_settings['custom_field_inputs'][$input_key]['default'] = $default;
			}
		}
	
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
	global $aa_settings;

	foreach(array('post', 'page') as $post_type) {
		add_meta_box('aa-custom-fields', $aa_settings['plugin_name'], 'aa_create_custom_field_form', $post_type, 'normal', 'high');
	}
}

/**
 * Create the custom field form
 */
function aa_create_custom_field_form() {
	global $post, $aa_settings;
	
	echo '<div id="aa-custom-field-container">' . "\n";
	
	//Tab links
	echo '<ul id="aa-tab-links">' . "\n";
	echo '	<li><a class="aa-tab-link active" data-tab="lister-tab" href="#">Item Lister</a></li>' . "\n";
	echo '	<li><a class="aa-tab-link" data-tab="banner-tab" href="#">Item Banner</a></li>' . "\n";
	echo '</ul>' . "\n";
	
	//Lister tool
	echo '	<div id="lister-tab" class="aa-custom-field-tab">' . "\n";			

	echo '	<div id="aa-custom-field-help">' . "\n";
	echo '		<p>Use these options to specify which eBay items to display within your page/post. Add the following shortcode within your content editor to specify where the items will appear:<br /><br />[' . $aa_settings['shortcode'] . ' tool="lister"]<br /><br /></p>' . "\n";
	echo '		<p>Multiple shortcodes can be added, see the plugin help section for more information:<br /><br /></p>' . "\n";
	echo '		<a class="button thickbox" href="#TB_inline?width=600&height=550&inlineId=aa-help-popup">Plugin Help</a>' . "\n";
	echo '	</div>' . "\n";

	$current_group = false;
	$count = 0;
	foreach($aa_settings['custom_field_inputs'] as $field) {
		if($field['lister_param']) {
			//Prefix for this tool
			$field['name'] = aa_prefix($field['name'], 'lister', '_');
			$field['id'] = aa_prefix($field['id'], 'lister', '-');
						
			$group = $aa_settings['custom_field_groups'][$field['group']];
			
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
	echo '		<p>Use these options to specify which eBay items to display within your page/post. Add the following shortcode within your content editor to specify where the items will appear:<br /><br />[' . $aa_settings['shortcode'] . ' tool="banner"]<br /><br /></p>' . "\n";
	echo '		<p>Multiple shortcodes can be added, see the plugin help section for more information:<br /><br /></p>' . "\n";
	echo '		<a class="button thickbox" href="#TB_inline?width=600&height=550&inlineId=aa-help-popup">Plugin Help</a>' . "\n";
	echo '	</div>' . "\n";

	$current_group = false;
	$count = 0;
	foreach($aa_settings['custom_field_inputs'] as $field) {
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

			$group = $aa_settings['custom_field_groups'][$field['group']];

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
	require 'help.php.inc';
	ob_end_flush();	
 	echo '	</div>'	. "\n";
	echo '</div>' . "\n";
}

/**
 * Create the custom fields inputs
 */
function aa_create_param_input($field, $count = false, $set_value = false) {
	$out = '';
	
	//Do we have a default?
	if(! array_key_exists('default', $field)) {
		$field['default'] = false;
	}

	//Container
	$alt = ($count !== false && $count % 2) ? ' alt' : '';
	$out .= '<div class="control-group ' . aa_unprefix($field['id'], '-') . '-container' . $alt . '">' . "\n";

/*
	//Required
	$required = '';
	if($field['parameter_required']) {
		$required = ' <span class="required">*</span>';
	}
*/

	//Tip
	$tip = '';
	if($field['tip']) {
		$tip = ' <a class="tip" title="' . $field['tip'] . '" href="#" onclick="return false;">?</a>';
	}
	//Label
	$out .= '	<label class="control-label" for="' . $field['name'] . '">' . $field['title'] . $tip .  '</label>' . "\n";
	$out .= '	<div class="controls">' . "\n";				
	
	//Default type
	if(! array_key_exists('type', $field)) {
		$field['type'] = 'text';
	}
	
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
	global $aa_settings;
	
	foreach($aa_settings['custom_field_inputs'] as $field) {
		//Lister
		$lister_field_name = aa_prefix($field['name'], 'lister');
		if(isset($_POST[$lister_field_name]) && (trim($_POST[$lister_field_name]) !== false)) {
			$value = $_POST[$lister_field_name];
			update_post_meta($post_id, $lister_field_name, $value);
		//Is allowed to be emptry string
		} elseif(isset($_POST[$lister_field_name]) && in_array($lister_field_name, $aa_settings['param_store_empty_string']))  {
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
		global $aa_settings;
		add_options_page($aa_settings['plugin_name'] . ' Options', $aa_settings['plugin_name'], 'manage_options', 'aa_options_page', 'aa_options_page');
	}
}
add_action('admin_menu', 'aa_admin_page');

/**
 * Display the admin options page
 */
function aa_options_page() {
	global $aa_settings, $wpdb;
	
	echo '<div id="aa-options-container">' . "\n";
	echo '<a class="button right thickbox" href="#TB_inline?width=600&height=550&inlineId=aa-help-popup">Plugin Help</a>' . "\n";
	echo '	<h2>' . $aa_settings['plugin_name'] . '</h2>' . "\n";
	echo '	<form action="options.php" method="post">' . "\n";
	settings_fields('aa_options');
	do_settings_sections('aa');
	echo '	<input class="button button-primary" name="Submit" type="submit" value="Save Settings" />' . "\n";
	echo '	</form>' . "\n";
	echo '	<div id="aa-help-popup" style="display:none;">'. "\n";
	ob_start();
	require 'help.php.inc';
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
		global $aa_settings;

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
	echo '<p>The settings below enable you to specify default preferences, saving you from entering them each time when adding ' . $aa_settings['plugin_name'] . ' to your pages or posts. Defaults can easily be overridden on a page-by-page basis.</p>' . "\n";
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
	global $aa_settings;
	$options = get_option('aa_options');

	echo '<select name="aa_options[aa_default_eSite]">' . "\n";
	foreach($aa_settings['custom_field_inputs']['eSite']['options'] as $option_key => $option_value) {
		$selected = ($options['aa_default_eSite'] == $option_key) ? ' selected="selected"' : ''; 
		echo '	<option value="' . $option_key . '"' . $selected . '>' . $option_value . '</option>' . "\n";		
	}
	echo '</select>' . "\n";
	echo '<a href="#" class="tip" title="' . $aa_settings['custom_field_inputs']['eSite']['tip'] . '" onclick="return false">?</a>' . "\n";
}

/**
 * Output default campaign setting
 */
function aa_default_eCampID_setting() {
	global $aa_settings;
	$options = get_option('aa_options');
	
	echo '<input type="text" name="aa_options[aa_default_eCampID]" value="' . $options['aa_default_eCampID'] . '" />' . "\n";
	echo '<a href="#" class="tip" title="' . $aa_settings['custom_field_inputs']['eCampID']['tip'] . '" onclick="return false">?</a>' . "\n";
}

/**
 * Output default custom ID setting
 */
function aa_default_eCustomID_setting() {
	global $aa_settings;
	$options = get_option('aa_options');
	
	echo '<input type="text" name="aa_options[aa_default_eCustomID]" value="' . $options['aa_default_eCustomID'] . '" />' . "\n";
	echo '<a href="#" class="tip" title="' . $aa_settings['custom_field_inputs']['eCustomID']['tip'] . '" onclick="return false">?</a>' . "\n";
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
	global $aa_settings;
	$options = get_option('aa_options');
	
	echo '<select name="aa_options[aa_default_aTheme]">' . "\n";
	foreach($aa_settings['custom_field_inputs']['aTheme']['options'] as $option_key => $option_value) {
		$selected = ($options['aa_default_aTheme'] == $option_key) ? ' selected="selected"' : ''; 
		echo '	<option value="' . $option_key . '"' . $selected . '>' . $option_value . '</option>' . "\n";		
	}
	echo '</select>' . "\n";
	echo '<a href="#" class="tip" title="' . $aa_settings['custom_field_inputs']['aTheme']['tip'] . '" onclick="return false">?</a>' . "\n";	
}

/**
 * Output default campaign setting
 */
function aa_default_aColourP_setting() {
	global $aa_settings;
	$options = get_option('aa_options');
	
	echo '<input type="text" name="aa_options[aa_default_aColourP]" value="' . $options['aa_default_aColourP'] . '" />' . "\n";
	echo '<a href="#" class="tip" title="' . $aa_settings['custom_field_inputs']['aColourP']['tip'] . ' Must be a hexidecimal colour with no leading hash (e.g. F5F5F5)" onclick="return false">?</a>' . "\n";
}

/**
 * Output default campaign setting
 */
function aa_default_aColourS_setting() {
	global $aa_settings;
	$options = get_option('aa_options');
	
	echo '<input type="text" name="aa_options[aa_default_aColourS]" value="' . $options['aa_default_aColourS'] . '" />' . "\n";
	echo '<a href="#" class="tip" title="' . $aa_settings['custom_field_inputs']['aColourS']['tip'] . ' Must be a hexidecimal colour with no leading hash (e.g. F5F5F5)" onclick="return false">?</a>' . "\n";
}

/**
 * Output default campaign setting
 */
function aa_default_aColourB_setting() {
	global $aa_settings;
	$options = get_option('aa_options');
	
	echo '<input type="text" name="aa_options[aa_default_aColourB]" value="' . $options['aa_default_aColourB'] . '" />' . "\n";
	echo '<a href="#" class="tip" title="' . $aa_settings['custom_field_inputs']['aColourB']['tip'] . ' Must be a hexidecimal colour with no leading hash (e.g. F5F5F5)" onclick="return false">?</a>' . "\n";
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

function an_admin_notice() {
  echo '<div class="update-nag">The <b>Auction Affiliate</b> service is being shut down on the <b>20<sup>th</sup> May 2015</b>. Please migrate away from this plugin before then to avoid disruption (<a target="_blank" href="http://www.auctionaffiliate.co">more information here</a>)</div>'; 
}
add_action('admin_notices', 'an_admin_notice'); 