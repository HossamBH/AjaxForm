<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
     protected $fillable = array('name', 'image', 'age', 'gender_id');

     public function gender()
    {
        return $this->belongsTo('App\Models\Gender');
    }
}
