@extends('layouts.app')

@section('title', '販売内容詳細')

@section('content')
<div class="container">
  <h1>販売内容詳細</h1>

  <div class="header">
    <p>
      <a class="btn btn-primary" href="/admin">HOME</a>
      <a class="btn btn-primary" href="/admin/purchase">販売履歴管理</a>
    </p>
  </div>
  <div class="main">
    @if ($details->isNotEmpty())
      <table>
        <tr>
          <th>販売ID</th><th>販売日</th><th>購入商品</th><th>商品単価</th>
          <th>購入数量</th>
          <th>合計金額</th>
        </tr>
        @foreach ($details as $detail)
        <tr>
          <td>
            <p>{{ $detail->purchase_id }}</p>
          </td>
          <td>
            <p>{{ $detail->purchase->created_at }}</p>
          </td>
          <td>
            <p>{{ $items->find($detail->item_id)->name }}</p>
          </td>
          <td>
            <p>{{ $items->find($detail->item_id)->price }} 円</p>
          </td>
          <td>
            <p>{{ $detail->price }} 円</p>
          </td>
          <td>
            <p>{{ $detail->quantity }} 個</p>
          </td>
        </tr>
        @endforeach
        <tr>
          <td>
            <td colspan="3"> </td><td><strong>合計</strong></td><td>{{ $sum }}円</td>
          </td>
        </tr>
      </table>
    @endif
  </div>
</div>
@endsection
