<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use \App\Purchase;

class AdminController extends Controller
{
    //
    public function index() {

      $years = [];
      $models = Purchase::all();
      foreach ($models as $model) {
        $years[] = $model->created_at->format('Y');
      }
      $start_year = min($years);
      $last_year = max($years);

      return view('/admin/index', ['start_year' => $start_year, 'last_year' => $last_year]);
    }
}
