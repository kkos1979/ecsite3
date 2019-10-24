<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>商品一覧TOP</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/shop.css">
</head>
<body>
  <div class="container">
  <h1>商品一覧TOP</h1>
  <div class="base">
    <a class="btn btn-primary" href="/admin">HOME</a>
    <a class="btn btn-primary" href="/admin/purchase">販売履歴</a>
  </div>
  @if($items->isNotEmpty())
    @foreach ($items as $g)
      <table>
        <tr>
          <td>
            <img src="/images/{{ $g->image }}.jpg" alt="">
          </td>
          <td width="200">
            <p class="items">{{ $g->name }}</p>
            <p>{{ $g->comment }}</p>
          </td>
          <td width="150">
            <p>{{ $g->price }}円</p>
            <p>在庫 {{ $g->stock }} 個</p>
          </td>
          <td>
            <p>
              <a class="btn btn-primary" href="/admin/items/edit/{{ $g->id }}">修正</a>
            </p>
            <p>
              <a class="btn btn-primary" href="/admin/items/upload/{{ $g->id }}/{{ $g->name }}">画像</a>
            </p>
            <p>
              <form action="/admin/items/destroy/{{ $g->id }}" id="form_{{$g->id}}" method="post">
                {{ csrf_field() }}
                {{ method_field('delete') }}
                <a href="#" data-id="{{ $g->id }}" class="btn btn-primary" onclick="deleteItems(this);">削除</a>
              </form>
            </p>
          </td>
        </tr>
      </table>
    @endforeach
  @else
  <div class="base">
    <p>商品が登録されていません。</p>
  </div>
  @endif
  <div class="base">
    <a class="btn btn-primary" href="/admin/items/create">新規追加</a>
    <a class="btn btn-primary" href="/admin/items/admin" target="blank">サイト確認</a>
  </div>
</body>
@if ($items->isNotEmpty())
<script type="text/javascript">
  'use strict';
  function deleteItems(e) {

    if (confirm('{{ $g->name }}を削除してもよろしいですか？')) {
        document.getElementById('form_' + e.dataset.id).submit();
    }
  }
</script>
@endif
</html>
