<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class HourEntry extends Model
{
    protected $table = 'hours_entry';
    
    use HasFactory;
    
    protected $dates = ['updated_at', 'days'];
   
    protected $fillable = [
        'days'
    ];
}
