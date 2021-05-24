<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersProject extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'project_id'
    ];
    
    public function scopeValidated($query)
    {
        return $query->where('hours_entry.validate', '=', 0);
    }
}
