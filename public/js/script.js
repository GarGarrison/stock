status_text = {
	"img/wait.png": "Ожидание",
	"img/building.png": "В наборе",
	"img/built.png": "Набрано",
	"img/unavail.png": "Нет на складе",
	"img/canceled.png": "Отменено",
	"img/shipped.png": "Отгружено",
	"img/not_ordered.png": "Еще не заказано",
}
function InterHint(obj) {
	src = obj.attr('src');
	x = obj.offset().left;
	y = obj.offset().top;
	styles = {
		'position': 'absolute',
		'background': 'white',
		'width': '200px',
		'padding': '5px',
		'border': '2px solid #0a6cce',
		'text-align': 'center',
		'top': y - 40,
		'left': x - 100,
		'display': 'none'
	}
	imgstyles = {
		'padding-right': '20px'
	}
	hint_body = "<div class='interhint'></div>";
	hint_inner = "<div><img src = '" + src + "'>"  + status_text[src] + "</div>";
	$('body').prepend(hint_body);
	$('.interhint').append(hint_inner);
	$('.interhint').css(styles);
	$('.interhint').fadeIn(500);
	$('.interhint img').css(imgstyles);
}
function SendSearch(text) {
	if (text == '') {
		alert("Введите запрос");
		return false;
	}
	if (text.length < 3) return false;
	$('.goods .search-item').remove();
	$.ajax({
		'url': 'util/search',
		'type': 'get',
		'data': {'search': text},
		'success': function (response){
			$('.goods.table').append(response);
			$('.search .blue-stripe').css('margin-top', '0px');
		},
		'error': function(resp){
            $('body').prepend(resp.responseText);
        } 
	});
}
function ReloadOrder() {
	$.ajax({
		'url': 'util/reloadorder',
		'type': 'get',
		'success': function (response){
			//$('.order.table').append(response);
			$('.order.table').html(response);
			$('.order .blue-stripe').css('margin-top', '0px');
			$('.order .count-in-answer').on('input',
    		function() {
    		    if (!$('.check').hasClass('no-check')){
                id = $(this).closest('tr').attr('id');
    			count = $(this).val();
    			if (parseInt(count)) 
    			    ChangeCount(id, count);
    			else alert('Введите число');
    			}
    		}
    	)
		}
	})
}

function AddToOrder(id, count, auto) {
	// auto = true если нажата галка на "Отправлять в набор автоматически"
	status = 0;
	if (!auto) status = 7;
	data = {'id': id, 'count': count, 'status': status};
	$.ajax({
		'url': 'util/addorder',
		'type': 'post',
		'data': data,
		'success': function (response){
			$('.order.table').html(response);
			$('.order .blue-stripe').css('margin-top', '0px');
			Inform('Добавлено');
		},
		'error': function(resp){
            $('body').prepend(resp.responseText);
        } 
	})
}
function OrderNotOrdered (){
	$.ajax({
		'url': 'util/ordernotordered',
		'type': 'post',
		'success': function (response){
			//alert(response);
            /*$('.order.table').html(response);
			$('.order .blue-stripe').css('margin-top', '0px');*/
		},
		'error': function(resp){
            $('body').prepend(resp.responseText);
        } 
	});
}
function ChangeCount (id, count) {
	$.ajax({
		'url': 'util/changeorder',
		'type': 'post',
		'data': {'id': id, 'count': count},
		'success': function (response){
			//alert(response);
		}
	});
}
function Cancel (id) {
	$.ajax({
		'url': 'util/changeorder',
		'type': 'post',
		'data': {'id': id, 'status': 1},
		'success': function (response){
			//alert(response);
		},
		'error': function(resp){
            $('body').prepend(resp.responseText);
        } 
	});
}
function StopCancel (id, count) {
	$.ajax({
		'url': 'util/changeorder',
		'type': 'post',
		'data':  {'id': id, 'count': count, 'status': 0},
		'success': function (response){
			//alert(response);
		}
	});
}
// Отправить в набор
$(document).on('click', '.to-order',function(){
	id = $(this).closest('tr').attr('id');
	storage_count = parseInt($(this).closest('tr').find('.search-avail').text());
	count = $(this).closest('tr').find('.count-in-answer').val()
	if (count > storage_count) {
		alert('Требуемого количества нет на складе');
		return false;
	}
	if (!parseInt(count)) {
		alert('Введите число');
		return false;
	}
	if ($('.check').hasClass('no-check')) AddToOrder(id, count, false);
	else AddToOrder(id, count, true);
});
// Отменить позицию
$(document).on('click', '.delete-position',function(){
	par = $(this).closest('tr');
	par.find('.order-special-bold').hide();
	par.find('.count-in-answer').hide();
	par.find('.status').attr('src','img/canceled.png');
	$(this).removeClass('delete-position').addClass('change-canceled');
	$(this).attr('src','img/order.png');
	//if ($('.check').hasClass('no-check')){
	id = par.attr('id');
	Cancel(id);
	//}
});
// Вернуть позицию назад в набор
$(document).on('click', '.change-canceled',function(){
	par = $(this).closest('tr');
	par.find('.order-special-bold').show();
	par.find('.count-in-answer').show();
	//par.find('.status').attr('src', 'img/wait.png');
	$(this).removeClass('change-canceled').addClass('delete-position');
	$(this).attr('src','img/delete.png');
	//if ($('.check').hasClass('no-check')){
	id = par.attr('id');
	count = par.find('.count-in-answer-ro').text();
	StopCancel(id, count);
	//}
});

$(document).on('focusout', '.order .count-in-answer',function(){
	id = $(this).closest('tr').attr('id');
	count = $(this).val();
	if (parseInt(count)) ChangeCount(id, count);
	else alert('Введите число');
})
$(document).on('mouseover', '.status', function(){InterHint($(this))})
$(document).on('mouseout', '.status', function(){$('.interhint').remove();})

$(document).ready(function(){
	$('img.search').attr('src', 'img/search-clicked.png');
	$("#play").click(function(){
		$("#audio")[0].play();
	})

	// отправка запроса на поиск товара по нажатию Enter
	$('.search-input').keypress(function(event){
		if (event.keyCode == 13) {
			SendSearch($(this).val())
			return false;
		}
	});
	$('.search-mini').click(function(){
	    SendSearch($(this).prev('.search-input').val())
	})
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
	$('.pic.truck').hover(
		function(){
			$(this).attr('src', 'img/truck-clicked.png');
		},
		function(){
			$(this).attr('src', 'img/truck.png');
		}
	);
	$('.to-set').hover(
		function(){
			$(this).attr('src', 'img/to-set-hover.png');
		},
		function(){
			$(this).attr('src', 'img/to-set.png');
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

	// скрывает / показывает кнопку "В набор"
	$('.check').click(function(){
		if ($(this).hasClass('no-check')) {
			$(this).attr('src', 'img/check-yes.png');
			$(this).removeClass('no-check');
			OrderNotOrdered();
			$('.to-set').hide();
		}
		else{
			$(this).attr('src', 'img/check-no.png');
			$(this).addClass('no-check');
			$('.to-set').show();
		}
	});
	$('.to-set').click(function(){
		//positions = $('.no-autoorder-position');
		positions = $('.order-item');
		if (positions.length == 0) {
			alert('Добавьте товар');
			return false;
		}
		OrderNotOrdered();
	});
	setInterval(function() {
	    if (!$('.order .count-in-answer').is(':focus')) {
            ReloadOrder();
	    }
    }, 2500);
})
