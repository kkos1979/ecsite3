@extends('layouts.app')

@section('title', 'ログイン | ECサイト')

@section('content')
<div class="container">
  <h1>ログイン</h1>
  <div class="base">
    @if ($errors->any())
      @foreach ($errors->all() as $error)
        <p><span class="error">{{ $error }}</span></p>
      @endforeach
    @endif
    <form action="/auth/login" method="post">
      @csrf
      <p>
        メールアドレス：<br>
        <input type="text" name="email" value="{{ old('email') }}">
      </p>
      <p>
        パスワード：<br>
        <input type="password" name="password">
      </p>
      <p>
        <input class="btn btn-primary" type="submit" value="ログイン">
        <button class="btn btn-primary" type="button" onclick="location.href='/auth/register'">新規登録</button>
      </p>
    </form>
  </div>
  <div class="base">
    <a class="btn btn-primary" href="/">お買い物に戻る</a>
    <a class="btn btn-primary" href="/cart">カートに戻る</a>
  </div>
</div>
@endsection
