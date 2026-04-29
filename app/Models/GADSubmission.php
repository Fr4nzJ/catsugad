<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GADSubmission extends Model
{
    protected $table = 'gad_submissions';

    protected $fillable = [
        'title',
        'lgu_name',
        'fiscal_year',
        'status',
        'remarks',
        'document_path',
        'document_original_name',
    ];

    protected $casts = [
        'fiscal_year' => 'integer',
    ];
}
