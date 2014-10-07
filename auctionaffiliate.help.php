<div id="<?php echo $plugin_settings['plugin_prefix']; ?>-help-popup">
<h1><?php echo $plugin_settings['plugin_name']; ?> Help</h1>

<p>Refer to the Auction Affiliate <a target="_blank" href="http://www.auctionaffiliate.co/docs/clients/wordpress">WordPress plugin page</a> for much more documentation and help.</p>

<h2 id="adding">Adding <?php echo $plugin_settings['plugin_name']; ?> to pages / posts</h2>

<p>Once <?php echo $plugin_settings['plugin_name']; ?> has been enabled, a new box will appear in the admin area when adding or editing a page / post. This box gives you sets of options which are used to specify what items are pulled in from eBay, how it is tied to your eBay Partner Network (ePN) account and how they are displayed on your page.</p>

<p>Once you have specified these options, you can place the following marker (known as a <em>shortcode</em>) in to your post content editor to specify where the listings will appear:</p>

<pre class="prettyprint">
[<?php echo $plugin_settings['shortcode']; ?>]
</pre>

<p>You can have as many shortcodes as you like on your pages (see below for more information)</p>

<h2 id="shortcodes">Multiple shortcodes</h2>

<p>As well as specifying where listings should appear on your page, shortcodes can be manually passed options to specify what items appear on the page. This can be useful when you wish to add multiple listings to the same page, or add them to your theme instead of within the post content editor.</p>

<p>Any options passed through a shortcode override any options specified on that page / post, as well as any default options set through the <?php echo $plugin_settings['plugin_name']; ?> settings page.

<p>Passing options to shortcodes can be achieved like so:</p>

<pre class="prettyprint">
[<?php echo $plugin_settings['shortcode']; ?> eKeyword="iPad mini case" eSite="0" eCount="4"]
</pre>

<p>As an example, say you want to display two sets of items – one showing six iPhones and one showing three iPads. If you want all other settings to be the same (i.e. the eBay site, your ePN custom ID, the theme etc) then you can set up the common options in the Auction Affiliate options box and then specifying two different shortcodes like so:</p>

<pre class="prettyprint">
[<?php echo $plugin_settings['shortcode']; ?> eKeyword="iPhone" eCount="6"]

[<?php echo $plugin_settings['shortcode']; ?> eKeyword="iPad" eCount="3"]
</pre>

<p>Refer to the <a target="_blank" href="http://www.auctionaffiliate.co/docs/parameters">parameters</a> page for an explanation of each parameter and allowed values.</p>

<h2 id="theme">Adding <?php echo $plugin_settings['plugin_name']; ?> within your theme</h2>

<p>To add <?php echo $plugin_settings['plugin_name']; ?> items within your theme files, you must use the shortcode format described above and pass it to the WordPress <code>do_shortcode()</code> function like so:</p>

<pre class="prettyprint">
&lt;?php echo do_shortcode('[<?php echo $plugin_settings['shortcode']; ?> eKeyword="iPad mini case" eSite="0" eCount="4"]'); ?&gt;
</pre>		

<h2 id="<?php echo $plugin_settings['plugin_prefix']; ?>-help-defaults">Specifying defaults</h2>

<p>Default settings for some <?php echo $plugin_settings['plugin_name']; ?> options can be specified on the Admin &gt; Settings &gt; <?php echo $plugin_settings['plugin_name']; ?> page.</p>

<p>If specified, these defaults save you from repeatedly entering the same option each time you add <?php echo $plugin_settings['plugin_name']; ?> to your pages or posts. Defaults can easily be overridden on a page-by-page basis.</p>

<h2 id="<?php echo $plugin_settings['plugin_prefix']; ?>-help-contact">I have a question / suggestion / bug report</h2>

<p>I would like to hear from you &ndash; please feel free to <a target="_blank" href="http://www.auctionaffiliate.co/contact">get in touch</a>!</p>

</div>