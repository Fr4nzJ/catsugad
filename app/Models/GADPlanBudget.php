<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GADPlanBudget extends Model
{
    protected $table = 'gad_plan_budgets';
    protected $fillable = [
        'title',
        'college_id',
        'program_project',
        'description',
        'target_beneficiaries',
        'budget_amount',
        'timeline',
        'status',
    ];

    protected $casts = [
        'budget_amount' => 'decimal:2',
    ];

    /**
     * Get the college that this plan belongs to
     */
    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    /**
     * Format budget for display
     */
    public function getFormattedBudget(): string
    {
        return '₱' . number_format($this->budget_amount, 2);
    }

    /**
     * Get status badge color
     */
    public function getStatusColor(): string
    {
        return match($this->status) {
            'draft' => 'warning',
            'submitted' => 'info',
            'approved' => 'success',
            'rejected' => 'danger',
            default => 'secondary',
        };
    }

    /**
     * Scope to filter by college
     */
    public function scopeByCollege($query, $collegeId)
    {
        return $query->where('college_id', $collegeId);
    }

    /**
     * Scope to filter by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to get approved plans only
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}
