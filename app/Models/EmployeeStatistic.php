<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeStatistic extends Model
{
    protected $table = 'employee_statistics';
    protected $fillable = [
        'department',
        'college_id',
        'male_count',
        'female_count',
    ];

    protected $casts = [
        'male_count' => 'integer',
        'female_count' => 'integer',
    ];

    /**
     * Get the college
     */
    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    /**
     * Get total employees
     */
    public function getTotalEmployees(): int
    {
        return $this->male_count + $this->female_count;
    }

    /**
     * Get male percentage
     */
    public function getMalePercentage(): float
    {
        $total = $this->getTotalEmployees();
        return $total > 0 ? round(($this->male_count / $total) * 100, 2) : 0;
    }

    /**
     * Get female percentage
     */
    public function getFemalePercentage(): float
    {
        $total = $this->getTotalEmployees();
        return $total > 0 ? round(($this->female_count / $total) * 100, 2) : 0;
    }

    /**
     * Scope to filter by college
     */
    public function scopeByCollege($query, $collegeId)
    {
        return $query->where('college_id', $collegeId);
    }

    /**
     * Scope to get university-wide stats
     */
    public function scopeUniversityWide($query)
    {
        return $query->whereNull('college_id');
    }
}
