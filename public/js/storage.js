var timer_time = 15 * 60 * 1000;
var timer;
var reloadinterval;
var cur_client;
function WaitTimer(){
	alert("Время бездействия слишком большое!");
	document.location.reload()
}

function DoSetInterval(){
	reloadinterval = setInterval(CheckOrder, 2500);
}
function ResetTimer(){
	clearInterval(timer);
	timer = setInterval(WaitTimer, timer_time);
}
function StopTimer(){
	clearInterval(timer);
}
function CheckOrder(){
	$.ajax({
		'url':'/util/checkneworders',
		'type': 'get',
			'success': function(response) {
				if (response != '0' && !$('.reloadstorage').hasClass('neworder')) {
					$('.reloadstorage').text(response);
					$('.reloadstorage').addClass('neworder');
					$("#audio")[0].play();
				}
				if (response == '0') {
					$('.reloadstorage').removeClass('neworder');
					$('.reloadstorage').text('');
					$("#audio")[0].pause();
				}
		}
	});
}
function ReloadStorage(){
	$.ajax({
		'url':'/util/reloadstorage',
		'type': 'post',
		'success': function(respT){
			$('.inner .storage').remove();
			$('.inner').prepend(respT);
			$('.right-button').attr('src','img/arrow-right-grey.png').addClass('grey');
			$('.left-button').attr('src','img/arrow-left-grey.png').addClass('grey');
			if ($("table[id='noid']").length == 1) StopTimer();
    		else ResetTimer();
			
			if ( $('.storage').length > 1) $('.right-button').attr('src','img/arrow-right.png');
			$('.storage').each(function(i){
				$(this).css('z-index', $('.storage').length-i)
			});
			$('.storage:first').addClass('active');
			$('.reloadstorage').text('');
			clearInterval(reloadinterval);
			$("#audio")[0].pause();
			CompareClient();
		}
	})
}
function Spark(obj) {
	fsize = obj.css('font-size');
	ifsize = parseInt(fsize)
	obj.animate({
		fontSize: ifsize + 15,
	}, 400, function(){
		obj.animate({fontSize: ifsize}, 300)
	})
}
function CompareClient(){
	client = $('.storage.active .client').text()
	if (client != cur_client) {
		Spark($('.client'));
		cur_client = client;
	}
}
$(document).ready(function(){
	if ($("table[id='noid']").length == 1) DoSetInterval();
    else ResetTimer();
    CompareClient();
	$("#play").click(function(){
		$("#audio")[0].play();
	})
	if ( $('.storage').length > 1) $('.right-button').attr('src','img/arrow-right.png');
	$('.storage').each(function(i){
		$(this).css('z-index', $('.storage').length-i)
	});
	$('.storage:first').addClass('active');
	$('.right-button').click(function(){
		if ($('.storage').length > 1){
			$('.left-button').attr('src','img/arrow-left.png').removeClass('grey');
			if ($('.storage.active').next('.storage').length > 0){
				len = $('.storage.active').width();
				active = $('.storage.active');
				next = active.next('.storage');
				//active.css("z-index", "5");
				active.animate({left: '-' + len},500)
				active.removeClass('active')
				next.addClass('active');
				//next.css("z-index", "0");
				if (next.next('.storage').length == 0) $(this).attr('src','img/arrow-right-grey.png').addClass('grey')			
			}
		}		
	});
	$('.left-button').click(function(){
		if ($('.storage').length > 1){
			$('.right-button').attr('src','img/arrow-right.png').removeClass('grey');
			if ($('.storage.active').prev('.storage').length > 0){
				//len = $('.storage.active').width();
				active = $('.storage.active');
				prev = active.prev('.storage');
				prev.animate({left: 0},500);
				active.removeClass('active')
				prev.addClass('active');
				prev.css("z-index", parseInt(active.css("z-index"))+1);
				//prev.css("z-index", "5");
				if (prev.prev('.storage').length == 0) $(this).attr('src','img/arrow-left-grey.png').addClass('grey');			
	            setTimeout(function() {
	                    //    active.remove();
	                //prev.css("z-index", "5");
	                //active.css("z-index", "0");	
	            }, 700);
			}
		}	
	});
	$('.send-status').click(function(){

		//if ($("table[id='noid']").length == 1) return false;
		if ($(".storage.active").attr("id") == "noid") {
			alert("Нечего набирать");
			return false;
		}
		status = $(this).attr('status');
		par = $('.storage.active')
		id = par.attr('id');
		count_in_order = parseInt($('.storage.active .count_in_order').text());
		count_in_storage = parseInt($('.storage.active .storage_count').text());
		count = $('.storage.active .count-in-answer:last').val();
		icount = parseInt(count);
		place = $('.storage.active .count-in-answer:first').val();	
		if 	((count == "") || (icount == 0)) {
			icount = count_in_order;
		}
		if (place.length == 0 && status != '5') {
			alert('Заполните все поля');
			return false;
		}
		if ( status == "3"){
			if (icount > count_in_order) {
				alert("Набрано больше чем нужно");
				return false;
			}
			if (icount < count_in_order) {
				status = "8";
			}
		}
		if ( status == "5" ) par.css({'border': '5px solid red'});
		$.ajax({
			'url':'/util/changestatus',
			'type': 'post',
			'data': {'oid':id,'count': icount, 'status': status, 'place': place},
			'success': function(response){
				//alert(response);
				//return false;

                if (response.length) {
                    $('.storage:last').after(response);
                    if ($("table[id='noid']").length == 1) {
                    	DoSetInterval();
                    	StopTimer();
                    }
                    if ($("table[id='noid']").length > 1) {
                    	$('.storage:last').remove();
                    	$('.right-button').addClass('grey');
                    }
                }
                if ($('.storage.active').next('.storage').length > 0){
                    $('.left-button').attr('src','img/arrow-left.png').removeClass('grey');
			        len = $('.storage.active').width();
			        active = $('.storage.active');
			        next = active.next('.storage');
			        active.animate({left: '-' + len}, 500);
                    active.removeClass('active');
			        next.addClass('active');
                    if (next.next('.storage').length == 0) {
                    	$(this).attr('src','img/arrow-right-grey.png').addClass('grey');
                    }
                    setTimeout(function() {
                    	//    active.remove();
                    	next.css("z-index", parseInt(active.css("z-index")));
                    	active.css("z-index", parseInt(active.css("z-index"))+1);	
                    }, 700);
		        }
		        CompareClient();		
            },
            'error': function(resp) {
	            $('body').prepend(resp.responseText);
	        }
		})
	});
	$('.reloadstorage').click(function(){
		ReloadStorage();
	});
	$('.wait-button').hover(
		function(){
			$(this).attr('src', 'img/wait-button-hover.png');
			$('.q-hint').css('top', $(this).offset().top + 50);
			$('.q-hint').css('left', $(this).offset().left - 265);
			$('.q-hint').toggle();
		},
		function(){
			$(this).attr('src', 'img/wait-button.png');
			$('.q-hint').toggle();
		}
	);
	$('.built-button').hover(
		function(){
			$(this).attr('src', 'img/built-button-big-hover.png');
			$('.q-hint').css('top', $(this).offset().top + 50);
			$('.q-hint').css('left', $(this).offset().left - 265);
			$('.q-hint').toggle();
		},
		function(){
			$(this).attr('src', 'img/built-button-big.png');
			$('.q-hint').toggle();
		}
	);
	$('.unavail-button').hover(
		function(){
			$(this).attr('src', 'img/unavail-button-big-hover.png');
			$('.q-hint').css('top', $(this).offset().top + 50);
			$('.q-hint').css('left', $(this).offset().left - 265);
			$('.q-hint').toggle();
		},
		function(){
			$(this).attr('src', 'img/unavail-button-big.png');
			$('.q-hint').toggle();
		}
	);
});
$(document).on('blur', '.count-in-answer.count',
	function() {
		id = $(this).closest('.table.storage').attr('id');
		count = $(this).val();
		if (count == "") count = "0";
		if (!parseInt(count)) alert("Введите число");
		$.ajax({
			'url':'/util/changedonecount',
			'type': 'post',
			'data': {'oid':id,'count': count},
				'success': function(response) {
				//alert(response);
			}
		})
	}
);
$(document).on('blur', '.count-in-answer.place',
	function() {
		id = $(this).closest('.table.storage').attr('id');
		place = $(this).val();
		$.ajax({
			'url':'/util/changetakeplace',
			'type': 'post',
			'data': {'oid':id,'place': place},
				'success': function(response) {
				//alert(response);
			},
			'error': function(resp) {
	            $('body').prepend(resp.responseText);
	        }
		})
	}
);
$(document).on('click', 'body',	function (){
	if ($("table[id='noid']").length == 0) {
		ResetTimer();
	}
});