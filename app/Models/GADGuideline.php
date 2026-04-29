<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GADGuideline extends Model
{
    protected $table = 'gad_guidelines';

    protected $fillable = [
        'title',
        'description',
        'category',
        'release_date',
        'file_path',
        'file_original_name',
        'release_year',
    ];

    protected $casts = [
        'release_date' => 'date',
        'release_year' => 'integer',
    ];
}
