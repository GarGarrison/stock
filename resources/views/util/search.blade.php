@foreach ($goods_list as $goods)
    <?php
        $user = Auth::user();
        $price = 0;
        if ($user->price_level=='Розничные') $price = $user->money=='$' ? $goods->price_retail_usd: $goods->price_retail_rub;
        if ($user->price_level=='Мелкооптовые') $price = $user->money=='$' ? $goods->price_minitrade_usd: $goods->price_minitrade_rub;
        if ($user->price_level=='Оптовые') $price = $user->money=='$' ? $goods->price_trade_usd: $goods->price_trade_rub;
    ?>
    <tr class='search-item search-exist' id='{{ $goods->num }}'>
        <td>
            <span class='search-goods-number'>{{ $goods->goodsname }}</span>{{ $goods->mark }}<br />
            Корпус {{ $goods->case or "не указан" }}<br />
            Производитель {{ $goods->producer or "не указан" }}
        </td>
        <td>
            <span class='search-price'>Цена:</span> <span class='search-price-val'>{{ $price }}</span><br />
            @if ($goods->packcount != 0)
                Кол-во в упаковке: <b>{{ $goods->packcount }} шт</b><br />
            @endif
            @if ($user->money=='$' ? $goods->price_pack_usd: $goods->price_pack_rub != 0)
                Цена при покупке упаковки: <b>{{ $user->money=='$' ? $goods->price_pack_usd: $goods->price_pack_rub }}</b>
            @endif
        </td>
        <td valign='middle' align='center'><span class='search-avail'>{{ $goods->onlinecount + $goods->offlinecount }}</span></td>
        <td valign='middle' align='center'><input type='text' class='count-in-answer' value='1'></td>
        <td valign='middle' align='center'><img class='to-order pointer' src='img/order.png'></td>      
    </tr>
@endforeach