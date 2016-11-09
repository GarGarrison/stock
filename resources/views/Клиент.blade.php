@extends('app')

@section('special_links')
<link rel="stylesheet" href="css/style.css" type="text/css" />
<script language="javascript" src="js/script.js"></script>
@endsection

@section('content')
<div class="q-hint">
    <div class="hint-head">Статусы заказа</div>
    <table class="hint-table" cellspacing="0">
        <tr>
            <td class="hint-icon-td"><img src="img/wait.png"></td><td>Ожидание</td>
        </tr>
        <tr>
            <td class="hint-icon-td"><img src="img/building.png"></td><td>В наборе</td>
        </tr>
        <tr>
            <td class="hint-icon-td"><img src="img/built.png"></td><td>Набрано</td>
        </tr>
        <tr>
            <td class="hint-icon-td"><img src="img/unavail.png"></td><td>Нет на складе</td>
        </tr>
        <tr>
            <td class="hint-icon-td"><img src="img/canceled.png"></td><td>Отменено</td>
        </tr>
        <tr>
            <td class="hint-icon-td"><img src="img/shipped.png"></td><td>Отгружено</td>
        </tr>
    </table>
</div><!-- q-hint -->
<div class="search">
    <div class="inner">
        <!-- <div class="search-input" contenteditable="true"></div> -->
        <input type="text" class="search-input" />
        <img class="search-mini" src="img/search-mini.png" />
        <span class="header-text">Поиск</span>
        <div class="table_container">
            <table class="table goods">
                <tr>
                    <th class="goods-goods-th">Товар</th>
                    <th class="goods-price-th">Цены, {{ Auth::user()->money }}</th>
                    <th class="goods-avail-th">Наличие</th>
                    <th class="goods-count-th">Кол-во</th>
                    <th class="goods-order-th">Заказать</th>
                </tr>
            </table>
        </div>
        <div class="blue-stripe"></div>
    </div><!-- inner -->
</div><!-- search -->
<div class="order-block">
    <div class="order-head"></div>
    <div class="inner">
        <div style="width: 100%;display:inline-block;">
            <img class="check" src="img/check-yes.png" />
            <div class="auto-set">Отправлять в набор автоматически</div>
            <div class="header-text">Заказано</div>
        </div>
        <img class="to-set pointer" src="img/to-set.png" />
        <table class="table order">
            @include('util.orders_table')
        </table>
        <div class="blue-stripe"></div>
        <img class="to-set pointer" src="img/to-set.png" />
    </div><!-- inner -->
    <div class="order-footer"></div>
</div><!-- order-block -->
@endsection