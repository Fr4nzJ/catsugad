<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccomplishmentReport extends Model
{
    protected $table = 'accomplishment_reports';
    protected $fillable = [
        'title',
        'content',
        'year',
        'college_id',
        'program_id',
        'activity_description',
        'male_count',
        'female_count',
        'date_conducted',
        'college',
        'gender',
        'participants_count',
    ];

    protected $casts = [
        'male_count' => 'integer',
        'female_count' => 'integer',
        'participants_count' => 'integer',
        'date_conducted' => 'date',
    ];

    /**
     * Get the college that this report belongs to
     */
    public function collegeRelation(): BelongsTo
    {
        return $this->belongsTo(College::class, 'college_id');
    }

    /**
     * Get the program that this report belongs to
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get total participants
     */
    public function getTotalParticipants(): int
    {
        return $this->male_count + $this->female_count;
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
     * Scope to filter by year
     */
    public function scopeByYear($query, $year)
    {
        return $query->where('year', $year);
    }
}
