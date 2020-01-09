$(document).ready(function(){
	$('img.truck').attr('src', 'img/truck-clicked.png');
	if ( $('.item').length > 1) $('.right-button').attr('src','img/arrow-right.png');
	$('.sum-value').width($('.shipped th:last').width() + 2);
	$('.item').hide();
	$('.item:first').show();
	$('.pic.q').hover(
		function(){
			$(this).attr('src', 'img/q-clicked.png');
			$('.q-hint').css('top', $(this).offset().top + 50);
			$('.q-hint').css('left', $(this).offset().left - 265);
			$('.q-hint').toggle();
		},
		function(){
			$(this).attr('src', 'img/q.png');
			$('.q-hint').toggle();
		}
	);
	$('.pic.search').hover(
		function(){
			$(this).attr('src', 'img/search-clicked.png');
		},
		function(){
			$(this).attr('src', 'img/search.png');
		}
	);
	$('.pic.logoff').hover(
		function(){
			$(this).attr('src', 'img/arrow-hover.png');
		},
		function(){
			$(this).attr('src', 'img/arrow.png');
		}
	);
	$('.right-button').click(function(){
		$('.left-button').attr('src','img/arrow-left.png').removeClass('grey');
		if ($('.item:visible').next('.item').length > 0){
			active = $('.item:visible');
			next = active.next('.item');
			active.hide()
			next.show();
			if (next.next('.item').length == 0) $('.right-button').attr('src','img/arrow-right-grey.png').addClass('grey')			
		}		
	});
	$('.left-button').click(function(){
		$('.right-button').attr('src','img/arrow-right.png').removeClass('grey');
		if ($('.item:visible').prev('.item').length > 0){
			active = $('.item:visible');
			prev = active.prev('.item');
			active.hide();
			prev.show();
			if (prev.prev('.item').length == 0) $('.left-button').attr('src','img/arrow-left-grey.png').addClass('grey');			
		}		
	});
})