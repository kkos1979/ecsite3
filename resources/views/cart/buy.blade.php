@extends('layouts.app')

@section('title', '送付先の入力 | ECサイト')

@section('content')
<div class="container">
  <h1>送付先の入力</h1>
  <div class="base">
    <p>商品のご送付先を入力してください。</p>
    @if (!Auth::check())
      <p>ログインしていただくとご登録いただいている情報が入力されます。</p>
    @endif
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <p><span class="error">{{ $error }}</span></p>
    @endforeach
    @endif
    <form action="/cart/buy" method="post" id="submitform">
      @csrf
      <p>
        お名前(必須)：<br>
        <input type="text" name="name" value="{{ old('name') ?? \Auth::user()->name ?? '' }}">
      </p>
      <p>
        ご住所(必須)：<br>
        <input type="text" name="address" size="60" value="{{ old('address') ?? \Auth::user()->address ?? ''}}">
      </p>
      <p>
        電話番号(必須)：<br>
        <input type="text" name="tel" value="{{ old('tel') ?? \Auth::user()->tel ?? ''}}">
      </p>
      <p>
        メールアドレス：(入力いていただくと確認メールが届きます)<br>
        <input type="text" name="email" value="{{ old('email') ?? \Auth::user()->email ?? ''}}">
      </p>
      <p>
        <a href="#" class="btn btn-primary" onclick="formSubmit()" id="submitBtn">購入</a>
      </p>
    </form>
  </div>
  <div class="base">
    <a class="btn btn-primary" href="/">お買い物に戻る</a>
    <a class="btn btn-primary" href="/cart">カートに戻る</a>
    @if (!Auth::check())
      <button class="btn btn-primary" type="button" onclick="location.href='/auth/login'">ログイン</button>
    @endif
  </div>
</div>
<script type="text/javascript">
  'use strict';
  function formSubmit() {
    let btn = document.getElementById('submitBtn');
    btn.classList.add('disable');
    btn.desabled = true;
    document.getElementById('submitform').submit();
  }
</script>
@endsection
