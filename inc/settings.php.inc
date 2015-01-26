<?php

/**
 * ======================================================== 
 * ==================== SETTINGS  =========================
 * ========================================================
 */
$aa_settings = array(
	'plugin_name' => 'Auction Affiliate',
	'plugin_version' => '3.0.1',
	'request_endpoint_lister' => 'http://www.auctionaffiliate.co/client/js',
	'request_endpoint_banner' => 'http://www.auctionaffiliate.co/items/get/',
	'shortcode' => 'auction-affiliate',
	'plugin_prefix' => 'aa',
	'param_lister_prefix' => 'aa',
	'param_banner_prefix' => 'aa_b',
	'param_store_empty_string' => array(
		'aa_aColourP',
		'aa_aColourS',
		'aa_aColourB'
	),
	'html_output_id_prefix' => 'auction-affiliate-',
	'html_output_prefix' => 'aa-',
	'stylesheet_url' => 'http://assets-auctionaffiliate.s3.amazonaws.com/theme/css/themes-1.0.gz.css',
	'username_bad' => array('.', "\$", '!'),
	'username_good' => array('__dot__', '__dollar__', '__bang__'),				
	'custom_field_groups' => array(
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
	'custom_field_inputs' => 	array(		
			'eKeyword'  => array(
			'name' => 'eKeyword',
			'id' => 'eKeyword',
			'tip' => 'The keywords which determine which items to display, similar to a search on the actual eBay site. Accepts some advanced operators / punctuation. See documentation for more details.',
			'group' => 'keyword',
			'title' => 'Keyword Query',
			'lister_param' => '1',
			'banner_param' => '1'
		),
		'eCampID'  => array(
			'name' => 'eCampID',
			'id' => 'eCampID',
			'tip' => 'A campaign identifier linked to your eBay Partner Network account.',
			'group' => 'keyword',
			'title' => 'ePN Campaign ID',
			'lister_param' => '1',
			'banner_param' => '1'
		),
		'eSite'  => array(
			'name' => 'eSite',
			'id' => 'eSite',
			'tip' => 'The eBay site from which items will be displayed. This also determines which site item links will point to.',
			'type' => 'select',
			'options' => array(
				'1' => 'eBay United States',
				'2' => 'eBay Ireland',
				'3' => 'eBay Austria',
				'4' => 'eBay Australia',
				'5' => 'eBay Belgium',
				'7' => 'eBay Canada',
				'10' => 'eBay France',
				'11' => 'eBay Germany',
				'12' => 'eBay Italy',
				'13' => 'eBay Spain',
				'14' => 'eBay Switzerland',
				'15' => 'eBay United Kingdom',
				'16' => 'eBay Netherlands'
			),
			'default' => '1',
			'group' => 'affiliate',
			'title' => 'eBay Site',
			'lister_param' => '1',
			'banner_param' => '1'
		),
		'eCustomID'  => array(
			'name' => 'eCustomID',
			'id' => 'eCustomID',
			'tip' => 'A textual identifier used for reporting in your EPN account.',
			'group' => 'affiliate',
			'title' => 'ePN Custom ID',
			'lister_param' => '1',
			'banner_param' => '1'
		),
		'aGeo'  => array(
			'name' => 'aGeo',
			'id' => 'aGeo',
			'tip' => 'When enabled, this option detects the visitor\'s location using their IP address and automatically sets the appropriate eBay Site, overriding the eBay Site option. If the visitor\'s location can not be determined then the eBay Site option will be used.',
			'type' => 'checkbox',
			'value' => 'true',
			'group' => 'affiliate',
			'title' => 'Geographical IP Targeting',
			'lister_param' => '1',
			'banner_param' => '1'
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
			'title' => 'Search Title and Description',
			'lister_param' => '1',
			'banner_param' => '1'
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
			'title' => 'Listing Type',
			'lister_param' => '1',
			'banner_param' => '1'
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
			'group' => 'items',
			'title' => 'Order Items By',
			'lister_param' => '1',
			'banner_param' => '1'
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
			'title' => 'Condition Filter',
			'lister_param' => '1',
			'banner_param' => '1'
		),
		'eMinPrice'  => array(
			'name' => 'eMinPrice',
			'id' => 'eMinPrice',
			'tip' => 'Only display items above this price. The currency of the chosen eBay site will be used. Numbers only - no currency symbols required.',
			'group' => 'items',
			'title' => 'Minimum Price',
			'lister_param' => '1',
			'banner_param' => '1'
		),
		'eMaxPrice'  => array(
			'name' => 'eMaxPrice',
			'id' => 'eMaxPrice',
			'tip' => 'Only display items below this price.  The currency of the chosen eBay site will be used. Numbers only - no currency symbols required.',
			'group' => 'items',
			'title' => 'Maximum Price',
			'lister_param' => '1',
			'banner_param' => '1'
		),
		'aBannerSize'  => array(
			'name' => 'aBannerSize',
			'id' => 'aBannerSize',
			'tip' => 'Banner size',
			'type' => 'select',
			'options' => array(
				'300x250' => 'Medium rectangle (300px x 250px)',
				'336x280' => 'Large rectangle (336px x 280px)',
				'250x250' => 'Square (250px x 250px)',
				'120x600' => 'Skyscraper (120px x 600px)',
				'728x90' => 'Leaderboard (728px x 90px)',
				'160x600' => 'Wide skyscraper (160px x 600px)'
			),
			'group' => 'display',
			'title' => 'Banner Size',
			'lister_param' => '0',
			'banner_param' => '1'
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
			'title' => 'Theme',
			'lister_param' => '1',
			'banner_param' => '0'
		),
		'aColourT'  => array(
			'name' => 'aColourT',
			'id' => 'aColourT',
			'tip' => 'Specifying a colour will change how the ad appears in order to better integrate with your site.',
			'type' => 'select',
			'options' => array(
				'orange' => 'Orange',
				'blue' => 'Blue',
				'green' => 'Green',
				'red' => 'Red',
				'grey' => 'Grey',
				'pink' => 'Pink'
			),
			'group' => 'display',
			'title' => 'Banner Colour',
			'lister_param' => '0',
			'banner_param' => '1'
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
			'title' => 'Display eBay Logo',
			'lister_param' => '1',
			'banner_param' => '0'
		),
		'eCount'  => array(
			'name' => 'eCount',
			'id' => 'eCount',
			'tip' => 'How many items to display on each page.',
			'default' => '9',
			'value' => '9',
			'group' => 'display',
			'title' => 'Items Per Page',
			'lister_param' => '1',
			'banner_param' => '1'
		),
		'aColumns'  => array(
			'name' => 'aColumns',
			'id' => 'aColumns',
			'tip' => 'Used to determine how many columns of items are displayed.',
			'default' => '3',
			'group' => 'display',
			'title' => 'Number Of Columns',
			'lister_param' => '1',
			'banner_param' => '0'
		),
		'aWidth'  => array(
			'name' => 'aWidth',
			'id' => 'aWidth',
			'tip' => 'If specified, any output will not exceed this width on your page. Can be expressed in pixels (e.g. 600px) or as a percentage (e.g. 90%)',
			'group' => 'display',
			'title' => 'Maximum Output Width',
			'lister_param' => '1',
			'banner_param' => '0'
		),
		'aColourP'  => array(
			'name' => 'aColourP',
			'id' => 'aColourP',
			'tip' => 'Specify the primary theme colour for better integration on your site. This should be a hexadecimal colour (do not include leading # e.g. 11FF33)',
			'group' => 'display',
			'title' => 'Theme Primary Colour',
			'lister_param' => '1',
			'banner_param' => '0'
		),
		'aAuto'  => array(
			'name' => 'aAuto',
			'id' => 'aAuto',
			'tip' => 'This option specifies how often, in seconds the ad should auto scroll. If set to 0 auto scroll is disabled.',
			'default' => '5',
			'value' => '5',
			'group' => 'display',
			'title' => 'Banner Auto Advance',
			'lister_param' => '0',
			'banner_param' => '1'
		),
		'aColourS'  => array(
			'name' => 'aColourS',
			'id' => 'aColourS',
			'tip' => 'Specify the secondary theme colour for better integration on your site. This should be a hexadecimal colour (do not include leading # e.g. 11FF33)',
			'group' => 'display',
			'title' => 'Theme Secondary Colour',
			'lister_param' => '1',
			'banner_param' => '0'
		),
		'aColourB'  => array(
			'name' => 'aColourB',
			'id' => 'aColourB',
			'tip' => 'Specify the background theme colour for better integration on your site. This should be a hexadecimal colour (do not include leading # e.g. 11FF33)',
			'group' => 'display',
			'title' => 'Theme Background Colour',
			'lister_param' => '1',
			'banner_param' => '0'
		),
		'aNoItems'  => array(
			'name' => 'aNoItems',
			'id' => 'aNoItems',
			'tip' => 'This option enables you to show nothing in the ad space if you there are no matching items to display.',
			'type' => 'checkbox',
			'value' => 'true',
			'group' => 'display',
			'title' => 'Hide Banner If No Items',
			'lister_param' => '0',
			'banner_param' => '1'
		),
		'eCategoryInc'  => array(
			'name' => 'eCategoryInc',
			'id' => 'eCategoryInc',
			'tip' => 'A comma separated list of eBay categories to include items from. See documentation for details of how to obtain category IDs.',
			'group' => 'advanced',
			'title' => 'Category Include',
			'lister_param' => '1',
			'banner_param' => '1'
		),
		'eCategoryExcl'  => array(
			'name' => 'eCategoryExcl',
			'id' => 'eCategoryExcl',
			'tip' => 'A comma separated list of eBay categories to exclude items from. See documentation for details of how to obtain category IDs.',
			'group' => 'advanced',
			'title' => 'Category Exclude',
			'lister_param' => '1',
			'banner_param' => '1'
		),
		'eSellerId'  => array(
			'name' => 'eSellerId',
			'id' => 'eSellerId',
			'tip' => 'Only display items from a specific seller.',
			'group' => 'advanced',
			'title' => 'Seller ID',
			'lister_param' => '1',
			'banner_param' => '1'
		),
		'eTopRated'  => array(
			'name' => 'eTopRated',
			'id' => 'eTopRated',
			'tip' => 'Only display items listed by a seller with Top-rated seller status.',
			'type' => 'checkbox',
			'value' => 'true',
			'group' => 'advanced',
			'title' => 'Top Rated Sellers Only',
			'lister_param' => '1',
			'banner_param' => '1'
		),
		'eFreeShip'  => array(
			'name' => 'eFreeShip',
			'id' => 'eFreeShip',
			'tip' => 'Only display items with a free shipping option.',
			'type' => 'checkbox',
			'value' => 'true',
			'group' => 'advanced',
			'title' => 'Free Shipping Only',
			'lister_param' => '1',
			'banner_param' => '1'
		),
		'ePaypal'  => array(
			'name' => 'ePaypal',
			'id' => 'ePaypal',
			'tip' => 'Only display items which accept Paypal as a payment method.',
			'type' => 'checkbox',
			'value' => 'PayPal',
			'group' => 'advanced',
			'title' => 'Paypal Accepted Only',
			'lister_param' => '1',
			'banner_param' => '1'
		)
	)		
);
