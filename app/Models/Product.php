<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //same as fillable
    protected $guarded=[];
    public function section()  {
        return $this->belongsTo('App\Models\Section');
    }
    use HasFactory;

}
