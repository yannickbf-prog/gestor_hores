<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BagHour extends Model
{
    use HasFactory;
    
    public $timestamps = true;
    
    protected $fillable = [
        'project_id',
        'contracted_hours',
       
    ];
    
    
}
