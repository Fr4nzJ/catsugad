<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'college_id',
        'program_name',
        'description',
        'target_beneficiaries',
        'category',
        'image_path',
    ];

    /**
     * A Program belongs to a College
     */
    public function college()
    {
        return $this->belongsTo(College::class);
    }

    /**
     * A Program has many Accomplishment Reports
     */
    public function accomplishmentReports()
    {
        return $this->hasMany(AccomplishmentReport::class);
    }

    /**
     * A Program has many Student Statistics
     */
    public function studentStatistics()
    {
        return $this->hasMany(StudentStatistic::class);
    }

    /**
     * A Program has many Enrollments
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Scope: Get programs by college
     */
    public function scopeByCollege($query, $collegeId)
    {
        return $query->where('college_id', $collegeId);
    }
}
