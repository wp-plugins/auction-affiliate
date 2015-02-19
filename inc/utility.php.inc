<?php
	
/**
 * ======================================================== 
 * =============== UTILITY FUNCTIONS  =====================
 * ========================================================
 */

/**
 * Remove parameter prefix
 */
function aa_unprefix($name, $prefix_seperator = '_') {
	global $aa_settings;
	
	$bad = array(
		$aa_settings['param_banner_prefix'] . $prefix_seperator,
		$aa_settings['param_lister_prefix'] . $prefix_seperator
	);
	$good = array('', '');
		
	return str_replace($bad, $good, $name);
}


/**
 * Add parameter prefix
 */
function aa_prefix($name, $tool_key = 'lister', $prefix_seperator = '_') {
	global $aa_settings;
	
	return $aa_settings['param_' . $tool_key . '_prefix'] . $prefix_seperator . $name;
}

/**
 * Get names of inputs
 */
function aa_get_input_names() {
	global $aa_settings;
	
	$input_names = array();
	
	foreach($aa_settings['custom_field_inputs'] as $input) {
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