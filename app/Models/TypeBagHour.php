<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeBagHour extends Model {

    use HasFactory;

    protected $fillable = [
        'id', 'name', 'hour_price', 'description', 'created_at', 'updated_at'
    ];

}
