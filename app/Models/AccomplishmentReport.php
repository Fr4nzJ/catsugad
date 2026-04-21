<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccomplishmentReport extends Model
{
    protected $table = 'accomplishment_reports';
    protected $fillable = [
        'title',
        'content',
        'year',
        'college',
        'gender',
        'participants_count',
    ];

    protected $casts = [
        'participants_count' => 'integer',
    ];
}
