<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    protected $table = 'colleges';

    protected $fillable = [
        'name',
        'abbreviation',
        'campus',
        'category',
    ];

    /**
     * A College has one GAD Coordinator
     */
    public function gadCoordinator()
    {
        return $this->hasOne(GADCoordinator::class);
    }

    /**
     * A College has many Accomplishment Reports
     */
    public function accomplishmentReports()
    {
        return $this->hasMany(AccomplishmentReport::class, 'college_id');
    }

    /**
     * A College has many GAD Plan & Budgets
     */
    public function gadPlanBudgets()
    {
        return $this->hasMany(GADPlanBudget::class);
    }

    /**
     * A College has many Student Statistics
     */
    public function studentStatistics()
    {
        return $this->hasMany(StudentStatistic::class);
    }

    /**
     * A College has many Employee Statistics
     */
    public function employeeStatistics()
    {
        return $this->hasMany(EmployeeStatistic::class);
    }

    /**
     * A College has many Enrollments
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * A College has many Programs
     */
    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    /**
     * Get college by name (case-insensitive)
     */
    public static function findByName(string $name)
    {
        return static::where('name', 'COLLATE utf8mb4_general_ci', $name)->first();
    }

    /**
     * Get or create college by name
     */
    public static function findOrCreateByName(string $name)
    {
        $college = static::findByName($name);

        if (!$college) {
            $college = static::create([
                'name' => $name,
                'abbreviation' => static::generateAbbreviation($name),
            ]);
        }

        return $college;
    }

    /**
     * Generate abbreviation from college name
     * E.g., "College of Arts and Sciences" -> "CAS"
     */
    protected static function generateAbbreviation(string $name): string
    {
        $words = explode(' ', $name);
        $abbrev = '';

        foreach ($words as $word) {
            if (strlen($word) > 0 && strtoupper($word[0]) !== 'O' && strtoupper($word[0]) !== 'A' && strtoupper($word[0]) !== 'THE') {
                $abbrev .= strtoupper($word[0]);
            }
        }

        return $abbrev ?: substr(str_replace(' ', '', $name), 0, 3);
    }
}
