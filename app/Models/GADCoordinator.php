<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GADCoordinator extends Model
{
    protected $table = 'gad_coordinators';

    protected $fillable = [
        'college_id',
        'name',
        'email',
        'contact_number',
        'photo',
    ];

    /**
     * A GAD Coordinator belongs to a College
     */
    public function college()
    {
        return $this->belongsTo(College::class);
    }

    /**
     * Get photo URL for display
     */
    public function getPhotoUrl()
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }

        return asset('images/default-avatar.png'); // Fallback to default avatar
    }

    /**
     * Get formatted contact number
     */
    public function getFormattedContactNumber()
    {
        if (!$this->contact_number) {
            return null;
        }

        return $this->contact_number;
    }
}
