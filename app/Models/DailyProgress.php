<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyProgress extends Model
{
    use HasFactory;

    protected $table = 'daily_progress';

    protected $fillable = [
        'target_id',
        'date',
        'income',
        'achievement',
        'lesson_learned',
        'improvement_plan',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'income' => 'integer',
        ];
    }

    /**
     * Get the target that owns the daily progress.
     */
    public function target(): BelongsTo
    {
        return $this->belongsTo(Target::class);
    }

    /**
     * Scope for a specific date.
     */
    public function scopeForDate($query, $date)
    {
        return $query->where('date', $date);
    }

    /**
     * Scope for date range.
     */
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }
}
