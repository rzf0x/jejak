<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Target extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'start_date',
        'end_date',
        'target_amount',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'target_amount' => 'integer',
        ];
    }

    /**
     * Get the user that owns the target.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all daily progress for the target.
     */
    public function dailyProgress(): HasMany
    {
        return $this->hasMany(DailyProgress::class);
    }

    /**
     * Calculate total income from all daily progress.
     */
    public function getTotalIncomeAttribute(): int
    {
        return $this->dailyProgress()->sum('income');
    }

    /**
     * Calculate progress percentage.
     */
    public function getProgressPercentageAttribute(): float
    {
        if ($this->target_amount <= 0) {
            return 0;
        }

        return min(100, round(($this->total_income / $this->target_amount) * 100, 2));
    }

    /**
     * Check if target is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Scope for active targets.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for completed targets.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
