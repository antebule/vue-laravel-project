<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThesisReservation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'status', 'user_id', 'teacher_id'
    ];

    protected $guarded = [];
}
