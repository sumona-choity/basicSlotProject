<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clubslot extends Model
{
    protected $fillable = ['club_id', 'dayName', 'slot', 'isBooked'];
    protected $casts = [
        'created_at'  => 'date:Y-m-d',
        'updated_at'  => 'date:Y-m-d',
     ];
}