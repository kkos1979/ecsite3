@extends('layouts.app')

@section('title', '管理画面TOP')

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <p class="navbar-brand" style="margin-bottom: 0;">ECサイト ｜ 販売履歴期間指定</p>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link btn btn-link" href="{{ route('admin.home') }}">HOME</a>
      </li>
      <li class="nav-item">
        <a class="nav-link btn btn-link ml-3" href="{{ route('items') }}">商品管理</a>
      </li>
      <li class="nav-item">
        <a class="nav-link btn btn-link ml-3" href="{{ route('auth.logout') }}">ログアウト</a>
      </li>
    </ul>
  </div>
</nav>
<div class="container mt-5">
  <div class="row">
    <div class="col-md-6" style="width: 100%; height: 500px;">
      <div class="card mx-auto">
        <div class="card-header">
          販売履歴情報
        </div>
        <div class="card-body">
          <p style="display: inline-block;">期間指定</p>
          <form  action="{{ route('purchase.post') }}" method="post">
            <div class="form-grooup">
              @csrf
              <p style="display: inline-block;">
                <select class="br-4" name="start_year">
                  @for ($i = $start_year; $i <= $last_year; $i++)
                  <option value="{{ $i }}">{{ $i }}</option>
                  @endfor
                </select>
                年
                <select class="br-4" name="start_month">
                  @for ($i = 01; $i <= 12; $i++)
                  <option value="{{ $i }}">{{ $i }}</option>
                  @endfor
                </select>
                月 ～
                <select class="br-4" name="last_year">
                  @for ($i = $start_year; $i <= $last_year; $i++)
                  <option value="{{ $i }}">{{ $i }}</option>
                  @endfor
                </select>
                年
                <select class="br-4" name="last_month">
                  @for ($i = 01; $i <= 12; $i++)
                  <option value="{{ $i }}">{{ $i }}</option>
                  @endfor
                </select>
                月
                <input class="btn btn-primary btn-sm ml-2" type="submit" value="送信">
              </p>
            </div>
          </form>
          <hr>
          <p>選択期間： {{ $start_priod_year }}年 {{ $start_priod_month }} 月 ～ {{ $last_priod_year }} 年 {{ $last_priod_month }} 月</p>
          @if ($sells->isNotEmpty())
          <table class="table table-sm">
            <thead class="thead-light">
              <tr>
                <th class="fs-12">販売ID</th><th class="fs-12">販売日</th><th class="fs-12">購入ユーザー</th><th class="fs-12">販売額</th><th class="fs-12">詳細</th>
              </tr>
            </thead>
            @foreach ($sells as $sell)
            <tr>
              <td>
                <p class="fs-12">{{ $sell->id }}</p>
              </td>
              <td>
                <p class="fs-12">{{ $sell->created_at->format('Y年m月d日') }}</p>
              </td>
              <td>
                <p class="fs-12">{{ $sell->user->name }}</p>
              </td>
              <td>
                <p class="fs-12">{{ $sell->total_price }}円</p>
              </td>
              <td>
                <p>
                  <a class="btn btn-link btn-sm fs-12" href="{{ route('purchase.detail' ,$sell->id) }}">詳細</a>
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
      </div><!--card-->
    </div><!--col-md-->
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-12 mb-4">
          <div class="card">
            <div class="card-header">
              選択期間内月別売上高
            </div>
            <canvas id="canvas" style="height: 500px;"></canvas>
          </div>
        </div>
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              選択期間内商品別販売数
            </div>
            <canvas id="canvas2" style="height: 500px;"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div><!--row-->
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>

<script>
let ctx = document.getElementById("canvas");
let labels = JSON.parse('<?= $labels; ?>');
let salesData = JSON.parse('<?= $salesData; ?>');
let itemsChartData = JSON.parse('<?= $itemsChartData; ?>');
let itemsLabel = [];
let itemsData = [];
let itemsBgColor = [
  "rgba(219,39,91,0.5)",
  "rgba(219,255,0,0.5)",
  "rgba(219,0,0,0.5)",
  "rgba(0,0,91,0.5)",
  "rgba(255,0,60,0.5)",
];

Object.keys(itemsChartData).forEach(key => {
  itemsLabel.push(key);
  itemsData.push(itemsChartData[key]);
});

let datasets = [];
for (let i = 0; i < itemsLabel.length; i++) {
  datasets.push(
    {
      label: itemsLabel[i],
      data: itemsData[i],
      backgroundColor: itemsBgColor[i],
    }
  );
}

let salesBarChart = new Chart(ctx, {
  type: 'bar',
    data: {
      labels: labels,
      datasets: [
        {
          label: '月別売上高',
          data: salesData,
          backgroundColor: "rgba(219,39,91,0.5)"
        },
      ]
    },
    options: {
      title: {
        display: false,
        text: '売上高'
      },
      scales: {
        yAxes: [{
          ticks: {
            suggestedMax: 30000,
            suggestedMin: 0,
            stepSize: 5000,
            callback: function(value, index, values){
              return  value +  '円'
            }
          }
        }]
      },
    }
  });

let ctx2 = document.getElementById("canvas2");

let itemBarChart = new Chart(ctx2, {
  type: 'bar',
    data: {
      labels: labels,
      datasets: datasets,
    },
    options: {
      title: {
        display: false,
        text: '売上高'
      },
      scales: {
        yAxes: [{
          ticks: {
            suggestedMax: 30,
            suggestedMin: 0,
            stepSize: 5,
            callback: function(value, index, values){
              return  value +  '個'
            }
          }
        }]
      },
    }
  });
  </script>
@endsection
