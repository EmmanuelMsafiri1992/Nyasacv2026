<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class ResumeCategories extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'thumb', // like type template
        'color',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->hasMany('App\User\Models\ResumeTemplate');
    }
   
 
}
