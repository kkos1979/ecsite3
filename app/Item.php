<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// ソフトデリートの追加
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    // ソフトデリートの追加
    use SoftDeletes;

    protected $fillable = [
        'name', 'image', 'comment', 'price', 'stock',
    ];

    public function purchasedetail()
    {
      return $this->hasMany('\App\Purchasedetail');
    }
}
