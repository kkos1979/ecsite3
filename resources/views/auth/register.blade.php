@extends('layouts.app')

@section('title', '新規登録 | ECサイト')

@section('content')
<div class="container">
  @if(isset($message))
    <div class="base">
      <p>
        {{ $message }}
      </p>
      <button class="btn btn-primary" type="button" onclick="location.href='login.php'">ログイン</button>
    </div>
  @else
  <h1>新規登録</h1>
  <div class="base">
    @if ($errors->any())
      @foreach ($errors->all() as $error)
        <p><span class="error">{{ $error }}</span></p>
      @endforeach
    @endif
    <form action="/auth/register" method="post">
      @csrf
      <p>
        お名前：<br>
        <input type="text" name="name" value="{{ old('name') }}">
      </p>
      <p>
        ご住所：<br>
        <input type="text" name="address" value="{{ old('address') }}">
      </p>
      <p>
        電話番号<br>
        <input type="text" name="tel" value="{{ old('tel' )}}">
      </p>
      <p>
        メールアドレス：<br>
        <input type="text" name="email" value="{{ old('email') }}">
      </p>
      <p>
        パスワード：<br>
        <input type="password" name="password">
      </p>
      <p>
        パスワード(確認)：<br>
        <input type="password" name="password_confirmation">
      </p>
      <p>
        <input class="btn btn-primary" type="submit" value="新規登録">
        <button class="btn btn-primary btn-hf" type="button" onclick="location.href='/auth/login'">ログイン</button>
      </p>
    </form>
  </div>
  @endif
  <div class="base">
    <a class="btn btn-primary" href="/">お買い物に戻る</a>
    <a class="btn btn-primary" href="/cart">カートに戻る</a>
  </div>
</div>
@endsection
