@extends('app')

@section('special_links')
<link rel="stylesheet" href="css/admin.css" type="text/css" />
<script language="javascript" src="js/pGenerator.jquery.js"></script>
<script language="javascript" src="js/admin.js"></script>
@endsection

@section('content')
<div class="admin-body">
    <div class="edit-container"></div>
    
    <div>
        <div class="inner">
            @include('util.user_form')
        </div><!-- inner -->
    </div><!-- search -->
    <div class="user-block">
        <div class="user-head"></div>
        <div class="inner">
            <span class="header-text">Пользователи</span>
            <img src="img/usersblue.png"  style="float: right;margin-right: 20px;"/>
            <table class="table users">
                <tr>
                    <th>Id <img class="sort id" src="img/sort.png" /></th>
                    <th>Название <img class="sort username" src="img/sort.png" /></th>
                    <th>Тип пользователя <img class="sort usertype" src="img/sort.png" /></th>
                    <th>Редактировать</th>
                    <th>Удалить</th>
                </tr>
                @foreach ($user_list as $user)
                <tr id="{{ $user->id }}">
                    <td align="center">{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->type }}</td>
                    <td align='center'><img class='edit-user' src='img/edit.png' /></td>
                    <td align='center'><img class='delete-user' name="{{ $user->id }}" src='img/delete.png' /></td>
                </tr>
                @endforeach
            </table>
        </div><!-- inner -->
        
    </div><!-- order-block -->
</div><!-- admin-body -->
@endsection