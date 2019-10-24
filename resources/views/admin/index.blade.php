@extends('layouts.app')

@section('title', '管理画面TOP')

@section('content')
<div class="container">
  <h1>管理画面TOP</h1>
  <div class="base">
    <button class="btn btn-primary" type="button" onclick="location.href='/auth/logout'">ログアウト</button>
  </div>
  <div class="base">
    <p>
      <a class="btn btn-primary" href="/admin/items">商品管理</a>
    </p>
    <hr>
    <h2>販売履歴管理</h2>
    @if ($errors->any())
      <p>
        @foreach ($errors->all() as $error)
        <span class="error">{{ $error }}</span><br>
        @endforeach
      </p>
    @endif
    <p>期間</p>
    <form  action="/admin/purchase" method="post">
      @csrf
      <p>
        <select name="start_year">
          @for ($i = $start_year; $i <= $last_year; $i++)
            <option value="{{ $i }}">{{ $i }}</option>
          @endfor
        </select>
        年
        <select name="start_month">
          @for ($i = 01; $i <= 12; $i++)
            <option value="{{ $i }}">{{ $i }}</option>
          @endfor
        </select>
        月　～　
        <select name="last_year">
          @for ($i = $start_year; $i <= $last_year; $i++)
            <option value="{{ $i }}">{{ $i }}</option>
          @endfor
        </select>
        年
        <select name="last_month">
          @for ($i = 01; $i <= 12; $i++)
            <option value="{{ $i }}">{{ $i }}</option>
          @endfor
        </select>
        月
        <input class="btn btn-primary" type="submit" value="送信">
      </p>
    </form>
    <p>
      <a class="btn btn-primary" href="/admin/purchase">全履歴</a>
    </p>
  </div>
</div>
@endsection
