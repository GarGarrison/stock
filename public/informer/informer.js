function Inform(text) {
	$.ajax({
		'url': 'informer/informer.html',
		'success': function(response) {
			$('body').prepend(response)
			$('.informer_browser_container').append(text);
			$('.informer_browser').fadeIn(400, function(){ 
				$('.informer_browser').fadeOut(1200, function (){
					$('.informer_browser').remove();
				});
			})
		}
	})
}