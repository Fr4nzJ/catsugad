<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GADAgenda extends Model
{
    protected $table = 'gad_agendas';

    protected $fillable = [
        'agenda_title',
        'organization',
        'start_year',
        'end_year',
        'objectives',
        'strategies',
        'status',
    ];

    protected $casts = [
        'start_year' => 'integer',
        'end_year' => 'integer',
    ];
}
