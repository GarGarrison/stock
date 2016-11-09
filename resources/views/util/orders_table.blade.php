<tr>
    <th class="order-goods-th">Товар</th>
    <th class="order-count-th">Количество</th>
    <th class="order-price-th">Цена, {{ Auth::user()->money }}</th>
    <th class="order-status-th">Статус</th>
    <th class="order-action-th">Действие</th>
</tr>
@foreach ($order_list as $order)
    <tr id='{{ $order->orderid }}' class='order-item @if($order->status==0) no-autoorder-position @endif'>
        <td>
            <b>{{ $order->goodsname }}</b>
            @if ($order->mark) 
                ({{ $order->mark }})
            @endif
            <br />
            Корпус {{ $order->case or "не указан"}}<br />
            Производитель {{ $order->producer or "не указан" }}
        </td>
        <td valign='middle'>

                @if( $order->status==0 || $order->status==7 )
                    <div class='order-special-bold'>Заказано: </div><input type='text' class='count-in-answer' value='{{ $order->countorder }}'>
                @elseif( $order->status==8 )
                    <div class='order-special-bold'>Заказано: </div><span class='count-in-answer-ro'>{{ $order->countorder }}</span>
                    <div class='order-special-bold red'>Набрано: </div><span class='count-in-answer-ro'>{{ $order->countdone }}</span>
                @elseif( $order->status==3 || $order->status==4 )
                    <div class='order-special-bold'>Заказано: </div><span class='count-in-answer-ro'>{{ $order->countorder }}</span>
                    <div class='order-special-bold green'>Набрано: </div><span class='count-in-answer-ro'>{{ $order->countdone }}</span>
                @else
                    <div class='order-special-bold'>Заказано: </div><span class='count-in-answer-ro'>{{ $order->countorder }}</span>
                @endif
        </td>
        <td valign='middle' align='center'><b>{{ $order->price }}</b></td>
        <td valign='middle' align='center'><img class = 'status' src='{{ $status[$order->status]["status"] }}'></td>
        <td valign='middle' align='center'>{!! $status[$order->status]["maydelete"] !!}</td>     
    </tr>
@endforeach