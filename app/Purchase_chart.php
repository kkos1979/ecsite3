<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// ソフトデリートの追加
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase_chart extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'sales', 'date',
    ];
}
