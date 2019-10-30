@extends('layouts.app')

@section('title', '新規登録 | ECサイト')

@section('content')
<!--<div class="container">-->
<!--  @if(isset($message))-->
<!--    <div class="base">-->
<!--      <p>-->
<!--        {{ $message }}-->
<!--      </p>-->
<!--      <button class="btn btn-primary" type="button" onclick="location.href='./login'">ログイン</button>-->
<!--    </div>-->
<!--  @else-->
<!--  <h1>新規登録</h1>-->
  <div class="container mt-5">
    @if ($errors->any())
      @foreach ($errors->all() as $error)
        <p><span class="error">{{ $error }}</span></p>
      @endforeach
    @endif
    <div class="card mx-auto" style="width: 40rem;">
      <div class="card-header">新規登録</div>
      <div class="card-body">
        <form action="./register" method="post">
          @csrf
          <div class="form-group">
            <div class="row">
            <label for="InputName" class="col-md-4">お名前</label>
              <div class="col-md-6">
                <input type="text" name="name" class="form-control form-control-sm" id="InputName" value="{{ old('name') }}">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label for="InputAddress" class="col-md-4">ご住所</label>
              <div class="col-md-6">
                <input type="text" name="address" class="form-control form-control-sm" id="InputAddress" value="{{ old('address') }}">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label for="InputTel" class="col-md-4">電話番号</label>
              <div class="col-md-6">
                <input type="text" name="tel" class="form-control form-control-sm" id="InputTel" value="{{ old('tel') }}">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label for="InputEmail" class="col-md-4">メールアドレス</label>
              <div class="col-md-6">
                <input type="text" name="email" class="form-control form-control-sm" id="InputEmail" value="{{ old('email') }}">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label for="InputPassword" class="col-md-4">パスワード</label>
              <div class="col-md-6">
                <input type="text" name="password" class="form-control form-control-sm" id="InputPassword">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label for="InputPasswordConfirmation" class="col-md-4">パスワード（確認）</label>
              <div class="col-md-6">
                <input type="text" name="password_confirmation" class="form-control form-control-sm" id="InputPasswordConfirmation">
              </div>
            </div>
          </div>
          <div class="row mx-auto" style="width: 300px;">
            <input class="btn btn-primary col-md-5" type="submit" style="margin-right:2rem;" value="新規登録">
            <a class="btn btn-link col-md-5" href="./login" >ログイン</a>
          </div>
        </form>  
      </div><!--card-body-->
      <div class="card-footer">
        <div class="row mx-auto" style="width: 400px;">
          <a class="btn btn-primary col-md-5" href="../" style="margin-right:2rem;">お買い物に戻る</a>
          <a class="btn btn-primary col-md-5" href="../cart">カートに戻る</a>
        </div>
      </div>
    </div><!--card-->
  </div><!--container-->
  <!--@endif-->
@endsection
