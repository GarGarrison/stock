function HideOrShow(type) {
    if (type == 'Клиент') {
        $('.hide-select').addClass('edit-client');
        $('.edit-storage').removeClass('edit-storage');
    }
    else if (type == 'Склад') {
        $('.hide-storage').addClass('edit-storage');
        $('.edit-client').removeClass('edit-client');
    }
    else {
        $('.edit-storage').removeClass('edit-storage');
        $('.edit-client').removeClass('edit-client');
    }
}
$(document).on('click', '.close-edit',function(){
     $('.edit-container').html("").fadeOut('fast');
});
$(document).on('click', '.delete-user',function(){
    id = $(this).attr('name');
    $.ajax({
        'url': '/util/deleteuser',
        'type': 'post',
        'data':  {'uid': id},
        'success': function (response){
            location.reload();
        }
    });
});
$(document).on('click', '.edit-user',function(){
    id = $(this).closest('tr').attr('id');
    $.ajax({
        'url': '/util/finduser',
        'type': 'post',
        'data':  {'id': id},
        'success': function (response){
            html = "<span class='header-edit'>Редактирование</span><span class='close-edit'>Отменить</span>" + response;
            $('.edit-container').fadeIn('fast');
            $('.edit-container').html(html);
            scroll = $(document).scrollTop();
            wwidth = $(window).width();
            ewidth = $('.edit-container').width();
            $('.edit-container').css("top", scroll + 100);
            $('.edit-container').css('left', (wwidth-ewidth)/2);
            type = $('.edit-container').find('select[name="type"]').val();
            HideOrShow(type);
        },
        'error': function(resp){
            $('body').prepend(resp.responseText);
        } 
    });

});
$(document).on('change', 'select[name="type"]',function(){
    type = $(this).val();
    HideOrShow(type);
});
$(document).on('mouseover', '.save',function(){
    $(this).attr('src', 'img/save-hover.png');
});
$(document).on('mouseout', '.save',function(){
    $(this).attr('src', 'img/save.png');
});
$(document).ready(function(){
    HideOrShow('Клиент');
    function str_rand() {
        var result       = '';
        var words        = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
        var max_position = words.length - 1;
            for( i = 0; i < 10; ++i ) {
                position = Math.floor ( Math.random() * max_position );
                result = result + words.substring(position, position + 1);
            }
        return result;
    }
    $('.adduser').hover(
        function(){
            $(this).attr('src', 'img/adduser-hover.png');
        },
        function(){
            $(this).attr('src', 'img/adduser.png');
        }
    );
    $('.todownload').hover(
        function(){
            $(this).attr('src', 'img/todownload-hover.png');
        },
        function(){
            $(this).attr('src', 'img/todownload.png');
        }
    );
    $('.logoff').hover(
        function(){
            $(this).attr('src', 'img/arrow-hover.png');
        },
        function(){
            $(this).attr('src', 'img/arrow.png');
        }
    );
    $('.genpasswd').pGenerator({
        'bind': 'click',
        'passwordElement': '.inner #passwd',
        'displayElement': '#my-display-element',
        'passwordLength': 12,
        'uppercase': true,
        'lowercase': true,
        'numbers':   true,
        'specialChars': false,
        'onPasswordGenerated': function(generatedPassword) {
            alert('Сгенерирован новый пароль ' + generatedPassword);
        }
    });
    /*$('#genpasswd').click(function() {
        document.getElementById('passwd').setAttribute('type', 'text');
        $('#passwd').attr('value', str_rand());
    });*/
})
