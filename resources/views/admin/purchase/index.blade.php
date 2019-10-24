@extends('layouts.app')

@section('title', '販売履歴画面TOP')

@section('content')
<div class="container">
  <h1>販売履歴管理TOP</h1>

  <div class="header">
    <p>
      <a class="btn btn-primary" href="/admin">HOME</a>
      <a class="btn btn-primary" href="/admin/items">商品管理</a>
    </p>
  </div>
  <div class="main">
    @if ($sells->isNotEmpty())
      <table>
        <tr>
          <th>販売ID</th><th>販売日</th><th>購入ユーザー</th><th>販売額</th><th>詳細</th>
        </tr>
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
                <a class="btn btn-primary" href="purchase/detail/{{ $sell->id }}">詳細</a>
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
@endsection
