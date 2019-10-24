<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// ソフトデリートの追加
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchasedetail extends Model
{
    // ソフトデリートの追加
    use SoftDeletes;

    protected $fillable = [
        'purchase_id', 'item_id', 'quantity',
    ];

    public function purchase()
    {
      return $this->belongsTo('\App\Purchase');
    }

    public function item()
    {
      return $this->belongsTo('\App\Item');
    }

}
