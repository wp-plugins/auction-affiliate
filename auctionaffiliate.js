jQuery(document).ready(function() {
  jQuery('#aa-custom-field-container .parameter-group:not(#parameter-group-keyword) .parameter-group-content').hide();
  jQuery('#aa-custom-field-container .parameter-group legend').each(function() {
  	jQuery(this).text(jQuery(this).text() + ' [+]');
  });
  jQuery('#aa-custom-field-container .parameter-group legend').click(function() { 	
	  if(! jQuery('.parameter-group-content', jQuery(this).parent('.parameter-group')).is(':visible')) {
		  //Hide all
		  jQuery('#aa-custom-field-container .parameter-group .parameter-group-content').slideUp();
		  //Show this
		  jQuery('.parameter-group-content', jQuery(this).parent('.parameter-group')).slideDown();		  
	  }
  });

//
function aa_show_theme_options(theme) {
	jQuery('#aa_aColumns-container').hide();
	jQuery('#aa_aWidth-container').hide();
	jQuery('#aa_aColourP-container').hide();
	jQuery('#aa_aColourS-container').hide();
	jQuery('#aa_aColourB-container').hide();
	switch(theme) {
		case 'grid' : 
			jQuery('#aa_aColumns-container').show();
			jQuery('#aa_aWidth-container').show();
			jQuery('#aa_aColourP-container').show();
			jQuery('#aa_aColourS-container').show();
			jQuery('#aa_aColourB-container').show();
			break; 
		case 'default' : 
			jQuery('#aa_aWidth-container').show();
			jQuery('#aa_aColourP-container').show();
			jQuery('#aa_aColourS-container').show();
			jQuery('#aa_aColourB-container').show();
			break; 
		case 'fancy' : 
			jQuery('#aa_aWidth-container').show();
			jQuery('#aa_aColourP-container').show();
			jQuery('#aa_aColourS-container').show();
			jQuery('#aa_aColourB-container').show();
			break; 
		case 'universal' : 
			jQuery('#aa_aWidth-container').show();
			jQuery('#aa_aColourP-container').show();
			jQuery('#aa_aColourS-container').show();
			jQuery('#aa_aColourB-container').show();
			break; 
		case 'column' : 
			jQuery('#aa_aWidth-container').show();
			jQuery('#aa_aColourP-container').show();
			jQuery('#aa_aColourB-container').show();
			break; 
	}
}
aa_show_theme_options(jQuery('#aa_aTheme').val());
jQuery('#aa_aTheme').change(function() {
	aa_show_theme_options(jQuery(this).val());
});
//
});