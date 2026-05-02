(function ($) {
	"use strict";
	
	$('.collapse.show').parent().addClass('mgac-close');
	$('.mgc-header').on('click', function(){
    $('.collapse').parent().removeClass('mgac-close');
    
});
	//$('.collapse.show').parent().addClass('mgac-open');

}(jQuery));	