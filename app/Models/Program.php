<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'program_name',
        'description',
        'target_beneficiaries',
        'category',
        'image_path',
    ];
}
