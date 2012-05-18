jQuery(document).ready(function(){  
	//Remove bottom margin of last field
	jQuery('.optionsSection .optionsField:last-child').css('margin-bottom', '0');
	//Tabs
	jQuery('.optionsMenu a').first().addClass('active');
	jQuery('.optionsSection').hide();
	jQuery('.optionsSection').first().addClass('active').show();
	equalColumns();
	jQuery('.optionsMenu a').click( function() {
		jQuery('.optionsMenu a').removeClass('active');
		var sectionID = jQuery(this).attr('class');
		jQuery(this).addClass('active');
		jQuery('.optionsSection').hide().removeClass('active');
		jQuery('.optionsSection#' + sectionID).fadeIn().addClass('active');
		equalColumns();
		return false;
	});
	//ColorPicker
	jQuery('.color').ColorPicker({
		onSubmit: function(hsb, hex, rgb, el) {
			jQuery(el).val(hex);
			jQuery(el).ColorPickerHide();
		},
		onBeforeShow: function () {
			jQuery(this).ColorPickerSetColor(this.value);
		}
	}).bind('keyup', function(){
		jQuery(this).ColorPickerSetColor(this.value);
	});
	//Media Upload Lightbox
	jQuery('.optionsUploadButton').click(function() {
		formfield = jQuery(this).prev('.optionsUpload').attr('name');
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		return false;
	});
});
	
function equalColumns() {
	//Set equal height for menu and content
	var highestCol = Math.max(jQuery('.optionsSection.active').height(),jQuery('.optionsMenu').height());
	jQuery('.optionsSection.active, .optionsMenu').height(highestCol);
}