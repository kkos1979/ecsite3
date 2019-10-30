@extends('layouts.app')

@section('title', '商品画像アップロード')

@section('content')
<div class="container mt-5">
  <div class="card mx-auto" style="width: 40rem;">
    <div class="card-header">商品画像アップロード</div>
    <div class="card-body">
      @if ($errors->any())
        @foreach ($errors->all() as $error)
          <span class="error">{{ $error }}</span><br>
        @endforeach
      @endif
      <form action="upload" method="post" enctype="multipart/form-data">
        @csrf
        <p>
          {{ $name }}の商品画像（JPEGのみ）<br>
          <input type="file" name="pic">
        </p>
        <p>
          <input type="hidden" name="MAX_FILE_SIZE" value="1000">
          <input class="btn btn-primary" type="submit" name="submit" value="追加">
        </p>
      </form>
      <from action="" method="patch"></from>
      </form>
    </div>
    <div class="card-footer">
      <a class="btn btn-primary" href="../../">一覧に戻る</a>
    </div>
  </div>
</div>
@endsection
