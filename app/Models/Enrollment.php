<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $table = 'enrollments';

    protected $fillable = [
        'college_id',
        'program_id',
        'academic_year',
        'semester',
        'male_count',
        'female_count',
        'total_count',
    ];

    protected $casts = [
        'male_count' => 'integer',
        'female_count' => 'integer',
        'total_count' => 'integer',
    ];

    /**
     * An Enrollment belongs to a College
     */
    public function college()
    {
        return $this->belongsTo(College::class);
    }

    /**
     * An Enrollment belongs to a Program (optional)
     */
    public function program()
    {
        return $this->belongsTo(Program::class)->whereNotNull('program_id');
    }

    /**
     * Scope: Get enrollments by college
     */
    public function scopeByCollege($query, $collegeId)
    {
        return $query->where('college_id', $collegeId);
    }

    /**
     * Scope: Get enrollments by program
     */
    public function scopeByProgram($query, $programId)
    {
        return $query->where('program_id', $programId);
    }

    /**
     * Scope: Get enrollments by academic year
     */
    public function scopeByAcademicYear($query, $academicYear)
    {
        return $query->where('academic_year', $academicYear);
    }

    /**
     * Scope: Get enrollments by semester
     */
    public function scopeBySemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    /**
     * Scope: Get college-level enrollments (no program)
     */
    public function scopeCollegeLevelOnly($query)
    {
        return $query->whereNull('program_id');
    }

    /**
     * Scope: Get program-level enrollments
     */
    public function scopeProgramLevelOnly($query)
    {
        return $query->whereNotNull('program_id');
    }

    /**
     * Calculate total from male and female counts
     */
    public static function calculateTotal($maleCount, $femaleCount)
    {
        return $maleCount + $femaleCount;
    }

    /**
     * Get percentage of male students
     */
    public function getMalePercentage()
    {
        if ($this->total_count == 0) {
            return 0;
        }
        return round(($this->male_count / $this->total_count) * 100, 2);
    }

    /**
     * Get percentage of female students
     */
    public function getFemalePercentage()
    {
        if ($this->total_count == 0) {
            return 0;
        }
        return round(($this->female_count / $this->total_count) * 100, 2);
    }

    /**
     * Aggregate enrollments by college and academic year
     */
    public static function aggregateByCollege($academicYear, $semester)
    {
        return self::byAcademicYear($academicYear)
            ->bySemester($semester)
            ->collegeLevelOnly()
            ->with('college')
            ->get();
    }

    /**
     * Aggregate enrollments by program and academic year
     */
    public static function aggregateByProgram($academicYear, $semester)
    {
        return self::byAcademicYear($academicYear)
            ->bySemester($semester)
            ->programLevelOnly()
            ->with(['college', 'program'])
            ->get();
    }
}
