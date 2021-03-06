<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    
    protected $fillable = [     
        'name',
        'customer_id',
        'active',
        'created_at',
        'description'
    ];
    
    protected $dates = ['created_at'];
}
