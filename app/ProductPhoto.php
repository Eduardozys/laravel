<?php

namespace App;

use App\Http\Requests\ProductRequest;
use Illuminate\Database\Eloquent\Model;

    class ProductPhoto extends Model
{
    protected $fillable = ['image'];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
