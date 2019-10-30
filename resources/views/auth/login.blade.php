@extends('layouts.app')

@section('title', 'ログイン | ECサイト')

@section('content')
<div class="container mt-5">
  <div class="card mx-auto" style="width: 40rem;">
    <div class="card-header">ログイン</div>
    <div class="card-body">
      @if ($errors->any())
        @foreach ($errors->all() as $error)
          <p><span class="error">{{ $error }}</span></p>
        @endforeach
      @endif
      <form action="#" method="post">
        @csrf
        <div class="form-group">
          <div class="row">
            <label for="InputEmail" class="col-md-4">メールアドレス</label>
            <div class="col-md-6">
              <input type="text" name="email" id="InputEmail" class="form-control form-control-sm" value="{{ old('email') }}">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <label for="InputPassword" class="col-md-4">パスワード</label>
            <div class="col-md-6">
              <input type="password" name="password" class="form-control form-control-sm">
            </div>
          </div>
        </div>
        <div class="row mx-auto" style="width: 300px;">
          <input class="btn btn-primary col-md-5" type="submit" style="margin-right: 2rem;" value="ログイン">
          <a class="btn btn-link col-md-5" href="./register">新規登録</a>
        </div>
      </form>
    </div><!--card-body-->
    <div class="card-footer">
      <div class="row mx-auto" style="width: 400px;">
        <a class="btn btn-primary col-md-5" href="../" style="margin-right: 2rem;">お買い物に戻る</a>
        <a class="btn btn-primary col-md-5" href="../cart">カートに戻る</a>
      </div>
    </div>
  </div><!--card-->
</div><!--container-->
@endsection
