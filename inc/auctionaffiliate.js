function aa_setup_parameter_groups() {
 //Param groups
  jQuery('.parameter-group:not(#parameter-group-keyword) .parameter-group-content').hide();
  jQuery('.parameter-group legend').each(function() {
  	var legend_text = jQuery(this).text();
		if(legend_text.indexOf('[+]') == -1) {
	  	jQuery(this).text(legend_text + ' [+]');			
		}
  });
  jQuery('.parameter-group legend').click(function() { 	
	  if(! jQuery('.parameter-group-content', jQuery(this).parent('.parameter-group')).is(':visible')) {
		  //Hide all
		  jQuery('.parameter-group-content', jQuery(this).parents('.aa-custom-field-tab')).slideUp();
		  jQuery('.parameter-group-content', jQuery(this).parents('.aa-widget-container')).slideUp();
		  //Show this
		  jQuery('.parameter-group-content', jQuery(this).parent('.parameter-group')).slideDown();		  
	  }
  });
}

function aa_show_theme_options(theme, context) {
	jQuery('.aColumns-container', context).hide();
	jQuery('.aWidth-container', context).hide();
	jQuery('.aColourP-container', context).hide();
	jQuery('.aColourS-container', context).hide();
	jQuery('.aColourB-container', context).hide();
	switch(theme) {
		case 'grid' : 
			jQuery('.aColumns-container', context).show();
			jQuery('.aWidth-container', context).show();
			jQuery('.aColourP-container', context).show();
			jQuery('.aColourS-container', context).show();
			jQuery('.aColourB-container', context).show();
			break; 
		case 'default' : 
			jQuery('.aWidth-container', context).show();
			jQuery('.aColourP-container', context).show();
			jQuery('.aColourS-container', context).show();
			jQuery('.aColourB-container', context).show();
			break; 
		case 'fancy' : 
			jQuery('.aWidth-container', context).show();
			jQuery('.aColourP-container', context).show();
			jQuery('.aColourS-container', context).show();
			jQuery('.aColourB-container', context).show();
			break; 
		case 'universal' : 
			jQuery('.aWidth-container', context).show();
			jQuery('.aColourP-container', context).show();
			jQuery('.aColourS-container', context).show();
			jQuery('.aColourB-container', context).show();
			break; 
		case 'column' : 
			jQuery('.aWidth-container', context).show();
			jQuery('.aColourP-container', context).show();
			jQuery('.aColourB-container', context).show();
			break; 
	}
}

function aa_setup_widget_theme_dropdown() {
	jQuery('.aTheme-container select').each(function() {
		var widget_parent = jQuery(this).parents('.parameter-group-content');
		aa_show_theme_options(jQuery(this).val(), widget_parent);
		jQuery(this).change(function() {
			aa_show_theme_options(jQuery(this).val(), widget_parent);							
		});
	});
}

jQuery(document).ready(function() {
	aa_setup_parameter_groups();
	aa_setup_widget_theme_dropdown();
	
	//Tabs
	jQuery('ul#aa-tab-links li a').on('click', function(e) {
		e.preventDefault();

		jQuery('ul#aa-tab-links li a').removeClass('active');
		jQuery(this).addClass('active');
		
		var tab_show = jQuery(this).data('tab');
		
		//Hide all
		jQuery('.aa-custom-field-tab').hide();		
		//Show this
		jQuery('.aa-custom-field-tab#' + tab_show).show();
		
		return false;
	});
});

jQuery(document).ajaxSuccess(function(e, xhr, settings) {
	var widget_ids = ['aa_lister_widget', 'aa_banner_widget'];
	if(typeof settings.data !== 'undefined') {
		for(i in widget_ids) {
			if(settings.data.search('action=save-widget') != -1 && settings.data.search('id_base=' + widget_ids[i]) != -1) {
				aa_setup_parameter_groups();
				aa_setup_widget_theme_dropdown();			
			}		
		}
	}
});