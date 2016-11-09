@extends('app')
 <link rel="stylesheet" type="text/css" href="{{asset('css/newstorage.css')}}">
@section('content')
    <audio id="audio" loop>
        <source src="IncomingMessage.ogg"> 
    </audio>
    <div class="top-wrapper">
        <div class="top">
            <div class="reloadstorage"></div>
        </div>
    </div>
    <div class="inner">
        @include('/util/storage_table')
        <div class="navigation">
            <img class="left-button grey" src="img/arrow-left-grey.png" />
            <img class="right-button grey" src="img/arrow-right-grey.png" />
            <img class="unavail-button send-status" src="img/unavail-button-big.png" status="5" />
            <img class="built-button send-status" src="img/built-button-big.png" status="3" />
        </div>
    </div>
<script language="javascript" src="js/storage.js"></script>
@endsection