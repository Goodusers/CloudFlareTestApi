@extends('header')
@section('title', 'Параметры аккаунта')
@section('content')

    <h4>Общая иныформация</h4>
    <p>id аккаунта: {{ $member }}</p> 

    <h2 class="member"> участники</h2>
    <div class="info_member">
        @foreach ($list['result'] as $item)
            <div class="item">
                    <p>email: {{ $item['user']['email']}}</p>
                    <p>id участника: {{ $item['id']}}</p>
                    <p>Роль: {{ $item['roles'][0]['name']}}</p>
                {{-- {{dd($list['result'] )}} --}}
                <div class="buttons">
                    <form action="{{route('delete_member')}}" method="post">
                        @csrf
                        <input type="hidden" name="delete" value="{{ $item['id'] }}">
                        <button class="delete" type="submit"> Удалить </button>
                    </form>
                    <form action="{{route('delete_member')}}" method="post">
                        @csrf
                        <input type="hidden" name="delete" value="{{ $item['id'] }}">
                        <button class="edit" type="submit"> изменить </button>
                    </form>
                </div>
            </div>
        @endforeach

    </div>
    <div class="form_member">
        <p>Добавить участника</p>
        <form action="{{route('add_member')}}" method="POST">
            @csrf
            <input type="text" name="account_id" placeholder="account_id">
            <input type="email" name="email" placeholder="email">
            <input type="hidden" name="role" placeholder="role" value="{{ $list['result'][0]['roles'][0]['id']}}">
            <button type="submit">добавить</button>
        </form>
    </div>

    @endsection
