<?php
	
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

		$request_parameters = aa_get_parameters(false, $instance, $this->widget_tool);
		echo aa_output_html($request_parameters, $this->widget_tool);

		echo '</aside>' . "\n";
	}

	public function form($instance) {
		global $aa_settings;
		
		$count = 0;		

		echo '<div class="aa-widget-container">' . "\n";	
		aa_build_widget_title_input($instance, $count, $this->get_field_name('aa_widget_title'));
		$count++;

		$current_group = false;
		$count = 0;
		foreach($aa_settings['custom_field_inputs'] as $field) {
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
		global $aa_settings;

		$instance = array();

		$instance['aa_widget_title'] = aa_get_widget_title($new_instance);

		foreach($aa_settings['custom_field_inputs'] as $field) {
			$prefixed_field_name = aa_prefix($field['name'], $this->widget_tool);
			
			//Param is valid for the tool
			if($field[$this->widget_tool . '_param'] == true) {
				$param_value = trim($new_instance[$prefixed_field_name]);
				
				if($param_value !== '' || in_array($prefixed_field_name, $aa_settings['param_store_empty_string'])) {
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
		$this->widget_desc = 'Use this widget to...';
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
		$this->widget_desc = 'Use this widget to...';
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