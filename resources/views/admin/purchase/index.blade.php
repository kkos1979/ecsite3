@extends('layouts.app')

@section('title', '販売履歴画面TOP')

@section('content')
<div class="container mt-5">
  <div class="card mx-auto" style="width: 50rem;">
    <div class="card-header">
      <h4 style="display:inline-block;">販売履歴</h4>
      <a class="btn btn-primary float-right" href="../items">商品管理</a>
      <a class="btn btn-primary float-right mr-3" href="../../">HOME</a>
    </div>
    <div class="card-body">
      @if ($sells->isNotEmpty())
        <table class="table">
          <thead class="thead-light">
            <tr>
              <th>販売ID</th><th>販売日</th><th>購入ユーザー</th><th>販売額</th><th>詳細</th>
            </tr>
          </thead>
          @foreach ($sells as $sell)
            <tr>
              <td>
                <p>{{ $sell->id }}</p>
              </td>
              <td>
                <p>{{ $sell->created_at->format('Y年m月d日') }}</p>
              </td>
              <td>
                <p>{{ $sell->user->name }}</p>
              </td>
              <td>
                <p>{{ $sell->total_price }}円</p>
              </td>
              <td>
                <p>
                  <a class="btn btn-primary" href="./detail/{{ $sell->id }}">詳細</a>
                </p>
              </td>
            </tr>
            @endforeach
            <tr>
              <td>
                <td> </td><td><strong>合計</strong></td><td>{{ $sum }}円</td>
              </td>
            </tr>
        </table>
      @else
      <div class="base">
        <p>販売履歴がありません</p>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection
