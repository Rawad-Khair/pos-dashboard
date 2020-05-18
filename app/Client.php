<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table="clients";
    protected $guarded=[];
    protected $fillable =['name','phone','address'];
    protected $casts=[
        'phone' => 'array'
    ];

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

}
