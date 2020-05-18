<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Product extends Model
{
    protected $table = "products";
    protected $guarded = [];
    
    use Translatable;
    public $translatedAttributes = ['title', 'desc'];

    public function getImagePathAttribute () {
        return asset('uploads/products/images').'/'.$this->image;
    }

    public function getProfitAttribute () {
        return number_format($this->sale_price - $this->cost_price, 2);
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Order');
    }

}
