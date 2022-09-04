;(function($){
	$(document).ready(function(){
		$('.mgad-dismiss').on('click',function(){
			var url = new URL(location.href);
			url.searchParams.append('mgpdismissed',1);
			location.href= url;
		});
		$('.tinfo-hide').on('click',function(){
			var url = new URL(location.href);
			url.searchParams.append('tinfohide',1);
			location.href= url;
		});
	});
})(jQuery);