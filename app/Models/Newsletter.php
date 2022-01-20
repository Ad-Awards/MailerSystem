<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'last_send_data',
        'active',
        'first_name',
        'last_name',
        'email',
        'description',
    ];
}
