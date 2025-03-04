<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    protected $fillable=[
        "name" , "desc" , "price" , "image" ,"quantity"
    ];

    public function favorites(){
        return $this->hasMany(Favorite::class);
    }
    public function isfavorites(){
        return $this->favorites()->where("user_id",Auth::user()->id)->exists();
    }
}
