<?php

/**
 * ======================================================== 
 * =================== FRONT END ==========================
 * ========================================================
 */

/**
 * Output version #
 */
function aa_output_head() {
	global $aa_settings;
	echo '<!-- AA v' . $aa_settings['plugin_version'] . ' -->' . "\n";
	echo '<link href="' . $aa_settings['stylesheet_url'] . '" type="text/css" rel="stylesheet">' . "\n";
}
add_action('wp_head','aa_output_head');

function aa_output_footer() {
	global $aa_settings;
	echo '<script async="true" type="text/javascript" src="' . $aa_settings['request_endpoint_lister'] . '"></script>' . "\n";	
}
add_action('wp_footer','aa_output_footer');

function aa_get_parameters($shortcode_params = false, $widget_params = false, $tool_key) {
	global $post, $aa_settings;
	
	$request_parameters = array();

	//Set client type
	if($tool_key == 'lister') {
		$request_parameters['aClientType'] = 'WPJS';	
	} elseif($tool_key == 'banner') {
		$request_parameters['aClientType'] = 'WPIF';		
	}
	
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
	foreach($aa_settings['custom_field_inputs'] as $field) {
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

	return $request_parameters;	
}

function aa_output_html($request_parameters = false, $tool_key = false){
	global $aa_settings;

	//Lister
	if($tool_key == 'lister') {
		$aHash = md5(serialize($request_parameters));
		$request_parameters['aHash'] = $aHash;
		
		$output_html = '';
		
		//Width?
		$width = '';
		if(array_key_exists('aWidth', $request_parameters)) {
			$width = $request_parameters['aWidth'];
			if(is_numeric($width)) {
				$width .= '%';
			}
			$width = ' style="width:' . $width . ';margin:auto"';
		}
	
		$output_html .= '<div class="aa-client" id="aa-' . $aHash . '"' . $width;
	
		foreach($request_parameters as $param_key => $param_value) {
			//Make lowercase
			$output_html .= ' data-' . strtolower($param_key) . '="' . $param_value . '"';
		}
	
		$output_html .= '>';
		$output_html .= '</div>' . "\n\n";
	//Banner
	} else {
		//Request endpoint
		$url = $aa_settings['request_endpoint_banner'];
		$url = trim($url, '/');
		
		//User parameters	
		foreach($request_parameters as $data_key => $data_value) {
			switch($data_key) {
			case 'eSellerId':
				$data_value = str_replace($aa_settings['username_bad'], $aa_settings['username_good'], $data_value);
				break;
			case 'eKeyword':
				//Make URL safe
				$data_value = urlencode($data_value);
				break;
			}
			$url .= '/' . $data_key . '/' . $data_value;	
		}

		$banner_dimensions = explode('x', $request_parameters['aBannerSize']);
		$output_html = '<iframe src="' . $url . '" width="' . $banner_dimensions[0] . '" height="' . $banner_dimensions[1] . '" frameborder="0"></iframe>' . "\n";				
	}
	
	return $output_html;						
}

/**
 * Shortcode
 */
function aa_process_shortcode($shortcode_params = false, $widget_params = false) {
	global $post, $aa_settings;
	
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
	
	//Get the parameters for request
	$request_parameters = aa_get_parameters($shortcode_params, $widget_params, $tool_key);
	
	return aa_output_html($request_parameters, $tool_key);
}
add_shortcode($aa_settings['shortcode'], 'aa_process_shortcode');