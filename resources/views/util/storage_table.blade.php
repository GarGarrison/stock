@if ($order)
<?php 
    $ordercount = 0;
    $countdone = "";
    if ($order->countdone) $countdone = $order->countdone;
    if ($user->storage == 'offlinecount') $ordercount = $order->offlinecount;
    else $ordercount = $order->onlinecount;
?>
<table class="table storage" id = '{{ $order->orderid }}'>
    <tr>
        <td colspan="3" class="thead">
            <span class="client">{{ $client->name }}</span>
        </td>
        <td class="thead">
            <input class='count-in-answer place' value="{{ $order->takeplace }}">
        </td>
    </tr>
    <tr>
        <td class="cell">{{ $order->address }}</td>
        <td class="goodsname">
            <b>{{ $order->goodsname }}</b> {{ $order->mark  }}<br />
            {{ $order->case }} {{ $order->producer }}
        </td>
        <td class="storage_count">{{ $ordercount }}</td>
        <td class="count_in_order">
            {{ $order->countorder }}
            <input class='count-in-answer count' value='{{ $countdone }}'>
        </td>
    </tr>
</table>
@else
<table class='table storage' id='noid'></table>
@endif