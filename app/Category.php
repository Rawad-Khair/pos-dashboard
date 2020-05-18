<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Category extends Model
{
    protected $table="categories";
    protected $guarded=[];
    
    use Translatable;
    public $translatedAttributes = ['title', 'desc'];

    public function products()
    {
        return $this->hasMany('App\Product');
    }
    
}
