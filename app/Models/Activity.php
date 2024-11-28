<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    // Allowing mass assignment on these attributes
    protected $fillable = [
        'name',
        'date',
        'status',
        'comments',
    ];

    // protected $casts = [
    //     'date' => 'date', // Ensure the date field is cast to a Carbon instance
    // ];
}
