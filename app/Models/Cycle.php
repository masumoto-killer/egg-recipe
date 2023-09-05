<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cycle extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'cycle_start',
        'period_stop',
        'ovulation',
        'cycle_end',
        'in_calendar',
    ];
}
