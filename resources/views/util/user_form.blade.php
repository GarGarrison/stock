<?php
    $imgclass = "adduser";
    $imgsrc = "img/adduser.png";
    $id = "";
    $url = "/util/adduser";
    if ($current) {
        $imgclass = "adduser save";
        $imgsrc = "img/save.png";
        $id = $current->id;
        $url = "/util/saveuser";
    }
?>
<form action="{{ $url }}" method="post">
    <table class="form" id="{{ $id }}">
        {{ csrf_field() }}
        @if($current)
        <input type="hidden" name="id" value="{{ $id }}">
        @endif
        <tr>
            <td>Имя:</td>
            <td><input type="text" class="long input" name="name" value="{{ $current->name or '' }}" /></td>
            <td>Тип пользователя:</td>
            <td>
                <select class="select" name="type">
                    @foreach(array("Клиент", "Администратор", "Склад") as $type)
                        @if($current && $current->type == $type)
                            <option value="{{ $type }}" selected="selected">{{ $type }}</option>
                        @else
                            <option value="{{ $type }}">{{ $type }}</option>
                        @endif
                    @endforeach
                </select>
            </td>
            <td><img src="img/userplus.png" /></td>
        </tr>
        <tr>
            <td>Логин:</td>
            <td><input type="text" class="long input"  name="login" value="{{ $current->login or '' }}"/></td>
            <td><div class="hide-select">Валюта клиента:</div></td>                     
            <td>
                <select class="hide-select select" name="money">
                    @foreach(array("$", "руб") as $money)
                        @if($current && $current->money == $money)
                            <option value="{{ $money }}" selected="selected">{{ $money }}</option>
                        @else
                            <option value="{{ $money }}">{{ $money }}</option>
                        @endif
                    @endforeach
                </select>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>Пароль:</td>
            <td>
                <input type="password" class="short input" name="passwd" id="passwd" />
                <img class="genpasswd" src="img/genpasswd.png" />
            </td>
            <td><div class="hide-select">Уровень цен:</div></td>
            <td>
                <select class="hide-select select" name="price_level">
                    @foreach(array("Розничные", "Мелкооптовые", "Оптовые") as $price_level)
                        @if($current && $current->price_level == $price_level)
                            <option value="{{ $price_level }}" selected="selected">{{ $price_level }}</option>
                        @else
                            <option value="{{ $price_level }}">{{ $price_level }}</option>
                        @endif
                    @endforeach
                </select>
            </td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td><div class="hide-select">Скидка:</div></td>
            <td><input type="text" class="hide-select short input" name="discount" value="{{ $current->discount or '' }}" /></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td><div class="hide-storage">Склад:</div></td>
            <td>
                <select class="hide-storage select" name="storage">
                    <option value="onlinecount">Москва</option>
                    <option value="offlinecount">Мытищи</option>
                </select>
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5">
                <div class="blue-stripe"></div>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td><img onclick="$(this).closest('form').submit();" class="{{ $imgclass }}" src="{{ $imgsrc }}"></td>
        </tr>
    </table>
</form>