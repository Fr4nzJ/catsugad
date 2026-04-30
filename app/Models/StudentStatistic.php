<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentStatistic extends Model
{
    protected $table = 'student_statistics';
    protected $fillable = [
        'college_id',
        'program_id',
        'male_count',
        'female_count',
        'academic_year',
    ];

    protected $casts = [
        'male_count' => 'integer',
        'female_count' => 'integer',
        'academic_year' => 'integer',
    ];

    /**
     * Get the college
     */
    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    /**
     * Get the program
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get total students
     */
    public function getTotalStudents(): int
    {
        return $this->male_count + $this->female_count;
    }

    /**
     * Get male percentage
     */
    public function getMalePercentage(): float
    {
        $total = $this->getTotalStudents();
        return $total > 0 ? round(($this->male_count / $total) * 100, 2) : 0;
    }

    /**
     * Get female percentage
     */
    public function getFemalePercentage(): float
    {
        $total = $this->getTotalStudents();
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
     * Scope to filter by program
     */
    public function scopeByProgram($query, $programId)
    {
        return $query->where('program_id', $programId);
    }

    /**
     * Scope to filter by academic year
     */
    public function scopeByAcademicYear($query, $year)
    {
        return $query->where('academic_year', $year);
    }
}
