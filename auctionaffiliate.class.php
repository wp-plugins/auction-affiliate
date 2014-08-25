<?php
/**
 * Auction Affiliate v1.1
 * http://www.auctionaffiliate.co
 *
 * By Joseph Hawes
 * http://www.josephhawes.co.uk
 */
class AuctionAffiliate {
	private $settings;
	private $request_parameters;
	private $request;
	private $response;
	private $output_html;
	private $aHash;
	private $hostname;
		
	function __construct() {
		$this->settings = array(
			'html_output_id_prefix' => 'auction-affiliate-',
			'html_output_prefix' => 'aa-',
			'stylesheet_url' => 'http://assets-auctionaffiliate.s3.amazonaws.com/theme/css/themes-1.0.gz.css',			
			'request_endpoint' => 'http://www.auctionaffiliate.co/items/get/',
			'username_bad' => array('.', "\$", '!'),
			'username_good' => array('__dot__', '__dollar__', '__bang__'),			
			'request_parameter_groups' => array(
				'keyword'  => array(
	'name' => 'Your Query',
	'description' => 'Start by entering your keyword query and your ePN campaign ID. This determines which items are pulled from eBay and ensures links to eBay are credited to you.'
),
'affiliate'  => array(
	'name' => 'Affiliate Options',
	'description' => 'Additional eBay Partner Network details. You can also choose which eBay site your items are pulled from and which site you link to.'
),
'items'  => array(
	'name' => 'Item Options',
	'description' => 'Use these options to specify item filters based on listing type, condition and price range.'
),
'display'  => array(
	'name' => 'Display Options',
	'description' => 'How many items to display on your page, in which order and how they are styled.'
),
'advanced'  => array(
	'name' => 'Advanced Options',
	'description' => 'Advanced item options such as category and specific seller filters. '
)
						
			),
			'request_parameter_definitions' => 	array(		
				'eKeyword'  => array(
	'name' => 'eKeyword',
	'id' => 'eKeyword',
	'tip' => 'The keywords which determine which items to display, similar to a search on the actual eBay site. Accepts some advanced operators / punctuation. See documentation for more details.',
	'group' => 'keyword',
	'title' => 'Keyword Query'
),
'eCampID'  => array(
	'name' => 'eCampID',
	'id' => 'eCampID',
	'tip' => 'A campaign identifier linked to your eBay Partner Network account.',
	'group' => 'keyword',
	'title' => 'ePN Campaign ID'
),
'eSite'  => array(
	'name' => 'eSite',
	'id' => 'eSite',
	'tip' => 'The eBay site from which items will be displayed. This also determines which site item links will point to.',
	'type' => 'select',
	'options' => array(
		'1' => 'eBay US',
		'2' => 'eBay IE',
		'3' => 'eBay AT',
		'4' => 'eBay AU',
		'5' => 'eBay BE',
		'7' => 'eBay CA',
		'10' => 'eBay FR',
		'11' => 'eBay DE',
		'12' => 'eBay IT',
		'13' => 'eBay ES',
		'14' => 'eBay CH',
		'15' => 'eBay UK',
		'16' => 'eBay NL'
	),
	'default' => '1',
	'group' => 'affiliate',
	'title' => 'eBay Site'
),
'eCustomID'  => array(
	'name' => 'eCustomID',
	'id' => 'eCustomID',
	'tip' => 'A textual identifier used for reporting in your EPN account.',
	'group' => 'affiliate',
	'title' => 'ePN Custom ID'
),
'aGeo'  => array(
	'name' => 'aGeo',
	'id' => 'aGeo',
	'tip' => 'When enabled, this option detects the visitor\'s location using their IP address and automatically sets the appropriate eBay Site, overriding the eBay Site option. If the visitor\'s location can not be determined then the eBay Site option will be used.',
	'type' => 'checkbox',
	'value' => 'true',
	'group' => 'affiliate',
	'title' => 'Geographical IP Targeting'
),
'eSearchDesc'  => array(
	'name' => 'eSearchDesc',
	'id' => 'eSearchDesc',
	'tip' => 'Perform item search query on the item\'s title and description text.',
	'type' => 'radio',
	'options' => array(
		'false' => 'No',
		'true' => 'Yes'
	),
	'default' => 'false',
	'group' => 'items',
	'title' => 'Search Title and Description'
),
'eListingType'  => array(
	'name' => 'eListingType',
	'id' => 'eListingType',
	'tip' => 'Display only a certain listing type.',
	'type' => 'select',
	'options' => array(
		'All' => 'All Listings',
		'Auction' => 'Auction Only',
		'AuctionWithBIN' => 'Auction With BIN',
		'FixedPrice' => 'BIN Only'
	),
	'default' => 'All',
	'group' => 'items',
	'title' => 'Listing Type'
),
'eCondition'  => array(
	'name' => 'eCondition',
	'id' => 'eCondition',
	'tip' => 'Only display items which are of a certain condition.',
	'type' => 'select',
	'options' => array(
		'' => 'Any',
		'New' => 'New',
		'Used' => 'Used'
	),
	'group' => 'items',
	'title' => 'Condition Filter'
),
'eMinPrice'  => array(
	'name' => 'eMinPrice',
	'id' => 'eMinPrice',
	'tip' => 'Only display items above this price. The currency of the chosen eBay site will be used. Numbers only - no currency symbols required.',
	'group' => 'items',
	'title' => 'Minimum Price'
),
'eMaxPrice'  => array(
	'name' => 'eMaxPrice',
	'id' => 'eMaxPrice',
	'tip' => 'Only display items below this price.  The currency of the chosen eBay site will be used. Numbers only - no currency symbols required.',
	'group' => 'items',
	'title' => 'Maximum Price'
),
'aTheme'  => array(
	'name' => 'aTheme',
	'id' => 'aTheme',
	'tip' => 'Determines how the items will be displayed on the page. There are a variety of themes to choose from.',
	'type' => 'select',
	'options' => array(
		'default' => 'Default',
		'fancy' => 'Fancy',
		'column' => 'Column',
		'grid' => 'Grid',
		'universal' => 'Universal',
		'unstyled' => 'Unstyled'
	),
	'default' => 'default',
	'group' => 'display',
	'title' => 'Theme'
),
'eSortOrder'  => array(
	'name' => 'eSortOrder',
	'id' => 'eSortOrder',
	'tip' => 'The order in which items will be displayed.',
	'type' => 'select',
	'options' => array(
		'BestMatch' => 'Best Match',
		'EndTimeSoonest' => 'Items Ending First',
		'StartTimeNewest' => 'Newly-Listed Items First',
		'PricePlusShippingLowest' => 'Lowest First',
		'PricePlusShippingHighest' => 'Highest First'
	),
	'default' => 'EndTimeSoonest',
	'group' => 'display',
	'title' => 'Order Items By'
),
'aDispLogo'  => array(
	'name' => 'aDispLogo',
	'id' => 'aDispLogo',
	'tip' => 'Determines if the Right Now On eBay logo will be displayed above items.',
	'type' => 'radio',
	'options' => array(
		'true' => 'Yes',
		'false' => 'No'
	),
	'default' => 'true',
	'value' => 'true',
	'group' => 'display',
	'title' => 'Display eBay Logo'
),
'eCount'  => array(
	'name' => 'eCount',
	'id' => 'eCount',
	'tip' => 'How many items to display on each page.',
	'default' => '9',
	'group' => 'display',
	'title' => 'Items Per Page'
),
'aColumns'  => array(
	'name' => 'aColumns',
	'id' => 'aColumns',
	'tip' => 'Used to determine how many columns of items are displayed.',
	'default' => '3',
	'group' => 'display',
	'title' => 'Number Of Columns'
),
'aWidth'  => array(
	'name' => 'aWidth',
	'id' => 'aWidth',
	'tip' => 'If specified, any output will not exceed this width on your page. Can be expressed in pixels (e.g. 600px) or as a percentage (e.g. 90%)',
	'group' => 'display',
	'title' => 'Maximum Output Width'
),
'aColourP'  => array(
	'name' => 'aColourP',
	'id' => 'aColourP',
	'tip' => 'Specify the primary theme colour for better integration on your site. This should be a hexadecimal colour (do not include leading # e.g. 11FF33)',
	'group' => 'display',
	'title' => 'Theme Primary Colour'
),
'aColourS'  => array(
	'name' => 'aColourS',
	'id' => 'aColourS',
	'tip' => 'Specify the secondary theme colour for better integration on your site. This should be a hexadecimal colour (do not include leading # e.g. 11FF33)',
	'group' => 'display',
	'title' => 'Theme Secondary Colour'
),
'aColourB'  => array(
	'name' => 'aColourB',
	'id' => 'aColourB',
	'tip' => 'Specify the background theme colour for better integration on your site. This should be a hexadecimal colour (do not include leading # e.g. 11FF33)',
	'group' => 'display',
	'title' => 'Theme Background Colour'
),
'eCategoryInc'  => array(
	'name' => 'eCategoryInc',
	'id' => 'eCategoryInc',
	'tip' => 'A comma separated list of eBay categories to include items from. See documentation for details of how to obtain category IDs.',
	'group' => 'advanced',
	'title' => 'Category Include'
),
'eCategoryExcl'  => array(
	'name' => 'eCategoryExcl',
	'id' => 'eCategoryExcl',
	'tip' => 'A comma separated list of eBay categories to exclude items from. See documentation for details of how to obtain category IDs.',
	'group' => 'advanced',
	'title' => 'Category Exclude'
),
'eSellerId'  => array(
	'name' => 'eSellerId',
	'id' => 'eSellerId',
	'tip' => 'Only display items from a specific seller.',
	'group' => 'advanced',
	'title' => 'Seller ID'
),
'eTopRated'  => array(
	'name' => 'eTopRated',
	'id' => 'eTopRated',
	'tip' => 'Only display items listed by a seller with Top-rated seller status.',
	'type' => 'checkbox',
	'value' => 'true',
	'group' => 'advanced',
	'title' => 'Top Rated Sellers Only'
),
'eFreeShip'  => array(
	'name' => 'eFreeShip',
	'id' => 'eFreeShip',
	'tip' => 'Only display items with a free shipping option.',
	'type' => 'checkbox',
	'value' => 'true',
	'group' => 'advanced',
	'title' => 'Free Shipping Only'
),
'ePaypal'  => array(
	'name' => 'ePaypal',
	'id' => 'ePaypal',
	'tip' => 'Only display items which accept Paypal as a payment method.',
	'type' => 'checkbox',
	'value' => 'PayPal',
	'group' => 'advanced',
	'title' => 'Paypal Accepted Only'
)
						
			)
		);
		$this->set_hostname();		
		$this->check_hostname_allowed();
	}

	/**
	 * Return the settings
	 */	
	function get_settings() {
		return $this->settings;
	}
	
	/**
	 * Get the current URL
	 */
	function get_current_url() {
	  $url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
	  $url .= ( $_SERVER["SERVER_PORT"] !== 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
	  $url .= $_SERVER["REQUEST_URI"];
	  return $url;
	}

	/**
	 * Add data to the current URL
	 */
	function add_query_arg($url = false, $args = array()) {
	  if(! $url) {
		  $url  = $this->get_current_url();		  
	  }
		
		$url_parsed = parse_url($url);
		if(array_key_exists('query', $url_parsed)) {
			parse_str($url_parsed['query'], $query_args);			
		} else {
			$query_args = array();
		}

		//Update or add parameters
		foreach($args as $arg_key => $arg_value) {
			$query_args[$arg_key] = $arg_value;
		}
		
		//Build new query string
		$new_query_string = http_build_query($query_args);
		$url_parsed['query'] = $new_query_string;
		
		$url = http_build_url($url_parsed, array(), HTTP_URL_STRIP_PORT);
		
	  return $url;
	}
	
	/**
	 * Set request parameters
	 */
	function set_request_parameters($params_in) {
		$params_out = array();
		
		foreach($this->settings['request_parameter_definitions'] as $p) {
			//Do we have a value?
			if(array_key_exists($p['name'], $params_in) && $params_in[$p['name']]) {
				//Use It!
				$params_out[$p['name']] = $params_in[$p['name']];
			//No value - default?
			} elseif(array_key_exists('default', $p)) {
				//Use that
				$params_out[$p['name']] = $p['default'];
			}
		}
		
		//Client type
		if(array_key_exists('aClientType', $params_in)) {
			$params_out['aClientType'] = $params_in['aClientType'];			
		} else {
			$params_out['aClientType'] = 'PHP';			
		}
		$params_out['aClientHost'] = $this->hostname;

		//Client IP - used for Geographical IP Targeting 
		$params_out['aClientIP'] = $_SERVER['REMOTE_ADDR'];

		$this->request_parameters = $params_out;
		//Hash URL data to get aHash
		$this->aHash = md5(serialize($this->request_parameters));
		if($page = $this->get_pagination_page()) {
			$this->request_parameters['ePage'] = $page;			
		}
	}

	/**
	 * Build request URL
	 */
	function build_request() {	
		//Request endpoint
		$url = $this->settings['request_endpoint'];
		$url = trim($url, '/');
		
		if(! array_key_exists('ePage', $this->request_parameters)) {
			$this->request_parameters['ePage'] = 1;
		}
		
		//User parameters	
		foreach($this->request_parameters as $data_key => $data_value) {
			switch($data_key) {
			case 'eSellerId':
				$data_value = str_replace($this->settings['username_bad'], $this->settings['username_good'], $data_value);
				break;
			case 'eKeyword':
				//Make URL safe
				$data_value = urlencode($data_value);
				break;
			}
			$url .= '/' . $data_key . '/' . $data_value;	
		}

		$this->request = $url;
	}

	/**
	 * Return request
	 */
	function get_request() {
		return $this->request;
	}

	/**
	 * Run the request
	 */
	function do_request() {		
		if(! $this->response = @file_get_contents($this->request)) {
			die('<b>ERROR</b> Request error');
		}
	}
	
	function get_pagination_page() {
		//Pagination for this aHash?
		if(isset($_REQUEST['cPage']) && isset($_REQUEST['aHash']) && ($_REQUEST['aHash'] == $this->aHash)) {
			return $_REQUEST['cPage'];
		} else {
			return false;
		}
	}
	
	/**
	 * Run the request
	 */
	function build_html_output() {	
		//If we are paging
		if($this->get_pagination_page()) {
			$prev_page = $this->request_parameters['ePage'] - 1;
			$next_page = $this->request_parameters['ePage'] + 1;					
		} else {
			$prev_page = false;
			$next_page = 2;
		}

		//Pagination
		if($prev_page) {
			$page_prev_url = $this->add_query_arg(false, array('cPage' => $prev_page, 'aHash' => $this->aHash));		
			$page_prev_url .= '#' . $this->settings['html_output_id_prefix'] . $this->aHash;
		} else {
			$page_prev_url = '#" style="display:none';
		}
		$page_next_url = $this->add_query_arg(false, array('cPage' => $next_page, 'aHash' => $this->aHash));
		
		//Add hash hash
		$page_next_url .= '#' . $this->settings['html_output_id_prefix'] . $this->aHash;
		
		//Width?
		$width = '';
		if(array_key_exists('aWidth', $this->request_parameters)) {
			$width = ' style="width:' . $this->request_parameters['aWidth'] . ';margin:auto"';
		}
		
		//Build HTML output
		$out = '<div id="' . $this->settings['html_output_id_prefix'] . $this->aHash  . '"' . $width . '>';

		//Edit Response
		//Pagination
		$resp = str_replace($this->settings['html_output_prefix'] . 'prev" href="#"', $this->settings['html_output_prefix'] . 'prev" href="' . $page_prev_url . '"', $this->response);
		$resp = str_replace($this->settings['html_output_prefix'] . 'next" href="#"', $this->settings['html_output_prefix'] . 'next" href="' . $page_next_url . '"', $resp);		
		$out .= $resp;

		$out .= '</div>';
		
		$this->output_html = $out;
	}	

	/**
	 * Output HTML
	 */
	function output_html() {
		echo $this->output_html;
	}

	/**
	 * Return HTML
	 */
	function get_html() {
		return $this->output_html;
	}

	/**
	 * Let's not mess around and get embedding!!!!
	 */
	function embed($request_params, $echo = true) {
		$this->set_request_parameters($request_params);
		$this->build_request();
		$this->do_request();
		$this->build_html_output();
		if($echo) {
			echo $this->output_html();			
		} else {
			return $this->get_html();						
		}
	}

	/**
	 * Determine hostname and store as a variable
	 */	
	function set_hostname() {
		$current_url = $this->get_current_url();
		$url_parsed = parse_url($current_url);
		
		$this->hostname = $url_parsed['host'];
	}

	/**
	 * Check for disallowed keywords in current URL
	 */	
	function check_hostname_allowed() {
		//Check for "ebay" and "paypal"
		if(strpos($this->hostname, 'ebay') !== false || strpos($this->hostname, 'paypal') !== false) {
			die('<b>ERROR</b> Hostname contains a disallowed keyword.');			
		}
	}
}

if(! function_exists('http_build_url')) {
	define('HTTP_URL_REPLACE', 1);          // Replace every part of the first URL when there's one of the second URL
	define('HTTP_URL_JOIN_PATH', 2);        // Join relative paths
	define('HTTP_URL_JOIN_QUERY', 4);       // Join query strings
	define('HTTP_URL_STRIP_USER', 8);       // Strip any user authentication information
	define('HTTP_URL_STRIP_PASS', 16);      // Strip any password authentication information
	define('HTTP_URL_STRIP_AUTH', 32);      // Strip any authentication information
	define('HTTP_URL_STRIP_PORT', 64);      // Strip explicit port numbers
	define('HTTP_URL_STRIP_PATH', 128);     // Strip complete path
	define('HTTP_URL_STRIP_QUERY', 256);    // Strip query string
	define('HTTP_URL_STRIP_FRAGMENT', 512); // Strip any fragments (#identifier)
	define('HTTP_URL_STRIP_ALL', 1024);     // Strip anything but scheme and host
	
	// Build an URL
	// The parts of the second URL will be merged into the first according to the flags argument.
	//
	// @param mixed     (Part(s) of) an URL in form of a string or associative array like parse_url() returns
	// @param mixed     Same as the first argument
	// @param int       A bitmask of binary or'ed HTTP_URL constants (Optional)HTTP_URL_REPLACE is the default
	// @param array     If set, it will be filled with the parts of the composed url like parse_url() would return
	function http_build_url($url, $parts = array (), $flags = HTTP_URL_REPLACE, &$new_url = false) {
	  $keys = array (
	    'user',
	    'pass',
	    'port',
	    'path',
	    'query',
	    'fragment'
	  );
	
	  // HTTP_URL_STRIP_ALL becomes all the HTTP_URL_STRIP_Xs
	  if ($flags & HTTP_URL_STRIP_ALL) {
	    $flags |= HTTP_URL_STRIP_USER;
	    $flags |= HTTP_URL_STRIP_PASS;
	    $flags |= HTTP_URL_STRIP_PORT;
	    $flags |= HTTP_URL_STRIP_PATH;
	    $flags |= HTTP_URL_STRIP_QUERY;
	    $flags |= HTTP_URL_STRIP_FRAGMENT;
	  }
	  // HTTP_URL_STRIP_AUTH becomes HTTP_URL_STRIP_USER and HTTP_URL_STRIP_PASS
	  else if ($flags & HTTP_URL_STRIP_AUTH) {
	    $flags |= HTTP_URL_STRIP_USER;
	    $flags |= HTTP_URL_STRIP_PASS;
	  }
	
	  // Parse the original URL if not already
	  if(! is_array($url)) {
		  $parse_url = parse_url($url);		  
	  } else {
		  $parse_url = $url;
	  }
	
	  // Scheme and Host are always replaced
	  if (isset($parts['scheme']))
	    $parse_url['scheme'] = $parts['scheme'];
	
	  if (isset($parts['host']))
	    $parse_url['host'] = $parts['host'];
	
	  // (If applicable) Replace the original URL with it's new parts
	  if ($flags & HTTP_URL_REPLACE) {
	    foreach ($keys as $key) {
	      if (isset($parts[$key]))
	        $parse_url[$key] = $parts[$key];
	    }
	  } else {
	    // Join the original URL path with the new path
	    if (isset($parts['path']) && ($flags & HTTP_URL_JOIN_PATH)) {
	      if (isset($parse_url['path']))
	        $parse_url['path'] = rtrim(str_replace(basename($parse_url['path']), '', $parse_url['path']), '/') . '/' . ltrim($parts['path'], '/');
	      else
	        $parse_url['path'] = $parts['path'];
	    }
	
	    // Join the original query string with the new query string
	    if (isset($parts['query']) && ($flags & HTTP_URL_JOIN_QUERY)) {
	      if (isset($parse_url['query']))
	        $parse_url['query'] .= '&' . $parts['query'];
	      else
	        $parse_url['query'] = $parts['query'];
	    }
	  }
	
	  // Strips all the applicable sections of the URL
	  // Note: Scheme and Host are never stripped
	  foreach ($keys as $key) {
	    if ($flags & (int)constant('HTTP_URL_STRIP_' . strtoupper($key)))
	      unset($parse_url[$key]);
	  }
	
	  $new_url = $parse_url;
	
	  return ((isset($parse_url['scheme'])) ? $parse_url['scheme'] . '://' : '') . ((isset($parse_url['user'])) ? $parse_url['user'] . ((isset($parse_url['pass'])) ? ':' . $parse_url['pass'] : '') . '@' : '')
	    . ((isset($parse_url['host'])) ? $parse_url['host'] : '') . ((isset($parse_url['port'])) ? ':' . $parse_url['port'] : '') . ((isset($parse_url['path'])) ? $parse_url['path'] : '')
	    . ((isset($parse_url['query'])) ? '?' . $parse_url['query'] : '') . ((isset($parse_url['fragment'])) ? '#' . $parse_url['fragment'] : '');
	}	
}