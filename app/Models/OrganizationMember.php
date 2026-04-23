<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationMember extends Model
{
    protected $fillable = [
        'name',
        'position',
        'role_group',
        'bio',
        'image_path',
        'sort_order',
    ];
}
