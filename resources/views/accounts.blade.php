@extends('header')
@section('title', 'Список аккаунтов')
@section('content')
    
    <?php 
        $account_num = 0;
    ?>
    @for ($i = 0; $i < count($data['result']); $i++)
        <div class="account_item">
            <?php $account_num += 1 ?>
            <p>Порядковый номер аккаунта: {{ $account_num }}</p>
            <p>id аккаунта: {{ $data['result'][$i]['id'] }}</p>
            <p>Наименование аккаунта: {{ $data['result'][$i]['name'] }}</p>
            <form class="edit_account" action="{{ route('store_account') }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="введите наименование">
                <input type="hidden" name="id_account" value="{{ $data['result'][0]['id'] }}">
                
                <button type="submit">Обновить</button>        
            </form>
        </div>
    @endfor
    <div class="domens">
        <h2>Управления доменами</h2>
        {{-- {{ dd($domains) }} --}}
        @foreach ($domains['result'] as $item)
            <div class="account_item">
                <p>id домена: {{ $item['id'] }}</p>
                <p>Наименование домена: {{ $item['name'] }}</p>
                <p>Статус домена: {{ $item['status'] }}</p>
                <form class="edit_account" action="{{ route('add_domains') }}" method="POST">
                    @csrf
                    <input type="text" name="name" placeholder="введите наименование">
                    <input type="hidden" name="zone_id" value="{{ $item['id'] }}">
                    
                    <button type="submit">Добавить</button>        
                </form>
            </div>
        @endforeach
    </div>
@endsection