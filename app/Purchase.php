<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// ソフトデリートの追加
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{

    // ソフトデリートの追加
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'total_price',
    ];
    //
    // public function detail()
    // {
    //   return $this->hasMany('\App\Purchsedetail');
    // }

    public function user()
    {
      return $this->belongsTo('\App\User');
    }

    public function purchasedetail()
    {
      return $this->hasMany('\App\Purchasedetail');
    }
}
