@extends('app')

@section('special_links')
<link rel="stylesheet" href="css/shipped.css" type="text/css" />
<script language="javascript" src="js/shipped.js"></script>
@endsection

@section('content')
    <div class="shipped">
        <div class="inner">
            <div class="header-text">Отгружено</div>
        <div class="buttons">
            <img class="left-button grey" src="img/arrow-left-grey.png" />
            <img class="right-button" src="img/arrow-right-grey.png" />
        </div>
            @foreach (array_keys($bill_list) as $bill)
                <div class='item'>
                    <?php $tmp = array_first($bill_list[$bill]);
                          $time = $tmp->datetime;
                    ?>
                    <span class='number'>Накладная №{{ $bill }} от {{ date("d.m.Y",strtotime($time)) }}</span>
                    <div class='table-padding'>
                        <table class='table shipped'>
                            <tr>
                                <th>Товар</th>
                                <th>Количество</th>
                                <th>Цены, руб</th>
                                <th>Сумма, руб</th>
                            </tr>
                        @foreach ($bill_list[$bill] as $goods)
                            <tr>
                                <td>
                                    <b>{{ $goods->goodsname }}</b>
                                    @if ($goods->mark) ({{ $goods->mark }})
                                    @endif
                                    <br />
                                    {{ $goods->case }}<br />
                                    {{ $goods->producer }}
                                </td>
                                <td valign='middle'>
                                    <div class='order-special-bold'>Заказано: {{ $goods->countorder }}</div>
                                    @if ($goods->countdone == $goods->countorder)
                                        <div class='order-special-bold green'>Набрано: {{ $goods->countdone }}</div>
                                    @else
                                        <div class='order-special-bold red'>Набрано: {{ $goods->countdone }}</div>
                                    @endif
                                </td>
                                    <td valign='middle' align='center'><b>{{ $goods->price }}</b></td>
                                    <td valign='middle' align='center'><b>{{ $goods->price * $goods->countorder }}</b></td>
                            </tr>
                        @endforeach
                        </table>
                    </div>
                </div>
            @endforeach
        </div><!-- inner -->
        <div class="buttons">
            <img class="left-button grey" src="img/arrow-left-grey.png" />
            <img class="right-button" src="img/arrow-right-grey.png" />
        </div>
    </div><!-- shipped -->
@endsection