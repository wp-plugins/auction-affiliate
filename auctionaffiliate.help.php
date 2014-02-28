<div id="<?php echo $plugin_settings['custom_field_prefix']; ?>-help-popup">
	<h1><?php echo $plugin_settings['plugin_name']; ?> Help</h1>

	<p>Refer to the Auction Affiliate <a target="_blank" href="http://www.auctionaffiliate.co/docs/clients/wordpress">WordPress plugin page</a> for full documentation and help.</p>
		
	<h2 id="<?php echo $plugin_settings['custom_field_prefix']; ?>-help-adding">Adding <?php echo $plugin_settings['plugin_name']; ?> to pages / posts</h2>
	
	<p>Once <?php echo $plugin_settings['plugin_name']; ?> has been enabled, a new box will appear in admin when adding or editing a page or post.</p>
	
	<p>This box gives you sets of options which are used to specify what items are pulled in from eBay, how it is tied to your eBay Partner Network (ePN) account and how they are displayed on your page.</p>
	
	<p>Once you have specified these options, you can place the marker <code>[<?php echo $plugin_settings['shortcode'];?>]</code> (known as a 'shortcode') in to your post content editor to specify where the listings will appear. Continue reading for more information about shortcodes.</p>
	
	<h2 id="<?php echo $plugin_settings['custom_field_prefix']; ?>-help-defaults">Specifying defaults</h2>
	
	<p>Default settings for some <?php echo $plugin_settings['plugin_name']; ?> options can be specified on the Admin &gt; Settings &gt; <?php echo $plugin_settings['plugin_name']; ?> page.</p>
	
	<p>If specified, these defaults save you from repeatedly entering the same option each time you add <?php echo $plugin_settings['plugin_name']; ?> to your pages or posts. Defaults can easily be overridden on a page-by-page basis.</p>

	<h2 id="<?php echo $plugin_settings['custom_field_prefix']; ?>-help-shortcodes">Using shortcodes</h2>

	<p>As well as specifying where listings should appear on your page, shortcodes can be manually passed options to specify what items appear on the page. This can be useful when you wish to add multiple listings to the same page, or add them to your theme instead of within the post content editor.</p>

	<p>Any options passed through a shortcode override any options specified on that page / post and any default options set through the Auction Affiliate settings page.

	<p>Passing options to shortcodes can be achieved like so:</p>

	<pre class="prettyprint">
[auction-affiliate eKeyword="iPad mini case" eSite="0" eCount="4"]
	</pre>

	<p>Refer to the <a target="_blank" href="http://www.auctionaffiliate.co/docs/parameters">parameters</a> page for an explanation of each parameter and allowed values.</p>

	<h2 id="<?php echo $plugin_settings['custom_field_prefix']; ?>-help-theme">Adding Auction Affiliate within your theme</h2>

	<p>To add Auction Affiliate items within your theme files, you must use the shortcode format described above and pass it to the WordPress <code>do_shortcode()</code> function like so:</p>

	<pre>
&lt;?php echo do_shortcode('[auction-affiliate eKeyword="iPad mini case" eSite="0" eCount="4"]'); ?&gt;
	</pre>
</div>