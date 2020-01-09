@extends('app')

@section('special_links')
<link rel="stylesheet" href="css/style.css" type="text/css" />
@endsection

@section('content')
<style type='text/css'>
            table {
                font-size: 20px;
                font-family: Arial;
            }
            div{
                width:450px;
                height:150px;
                margin-left:100px;
            }
            input{
                height:30px;
                width:400px;
                font-size: 20px;
            }
            .error-block {
                font-size: 12px;
                color: red;
                margin-top: 5px;
                display: block;
            }
            .button{
                width:170px;
                font-size:20px;
            }
        </style>
<div>
    <form method='post'>
        {{ csrf_field() }}
        <table cellpadding='7'><tr>
            <td align='right'>Пользователь:</td>
            <td>
                <input name='name'/ value="{{ old('name') }}">
                @if ($errors->has('name'))
                    <span class="error-block">{{ $errors->first('name') }}</span>
                @endif
            </td>
        </tr>
        <tr>
            <td align='right'>Пароль:</td>
            <td>
                <input name='passwd' type='password'/>
                @if ($errors->has('passwd'))
                    <span class="error-block">{{ $errors->first('passwd') }}</span>
                @endif
                @if ( !empty($errors->all()['passwd']) )
                    ololo
                    <span class="error-block">{{ $errors->all()['passwd'] }}</span>
                @endif
            </td>
        </tr>
        <tr>
            <td></td>
            <td><input class='button' type='submit' value='Войти'></td>
        </tr></table>
    </form>
</div>
@endsection
