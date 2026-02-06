<?php

namespace App\Livewire;

use App\Models\Target;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public ?Target $activeTarget = null;
    
    // Computed values
    public int $totalIncome = 0;
    public int $remainingTarget = 0;
    public int $totalDays = 0;
    public int $remainingDays = 0;
    public float $progressPercentage = 0;
    public array $chartData = [];
    public int $currentStreak = 0;

    public function mount(): void
    {
        $this->loadActiveTarget();
    }

    public function loadActiveTarget(): void
    {
        $this->activeTarget = Auth::user()
            ->targets()
            ->where('status', 'active')
            ->with('dailyProgress')
            ->latest()
            ->first();

        if ($this->activeTarget) {
            $this->calculateStats();
        }
    }

    protected function calculateStats(): void
    {
        // Total income from all daily progress
        $this->totalIncome = $this->activeTarget->dailyProgress->sum('income');

        // Remaining target
        $this->remainingTarget = max(0, $this->activeTarget->target_amount - $this->totalIncome);

        // Total days between start and end date
        $this->totalDays = $this->activeTarget->start_date->diffInDays($this->activeTarget->end_date) + 1;

        // Remaining days from today to end date
        $today = now()->startOfDay();
        $endDate = $this->activeTarget->end_date->startOfDay();
        
        if ($today->lte($endDate)) {
            $this->remainingDays = $today->diffInDays($endDate) + 1;
        } else {
            $this->remainingDays = 0;
        }

        if ($this->activeTarget->target_amount > 0) {
            $this->progressPercentage = min(100, round(($this->totalIncome / $this->activeTarget->target_amount) * 100, 1));
        }

        // Calculate Streak
        $dates = $this->activeTarget->dailyProgress
            ->pluck('date')
            ->map(fn($d) => $d->format('Y-m-d'))
            ->unique()
            ->values()
            ->toArray();

        $streak = 0;
        $checkDate = now();
        
        // Check if today is filled
        if (in_array($checkDate->format('Y-m-d'), $dates)) {
            $streak++;
            $checkDate->subDay();
        } else {
            // Check yesterday
             $checkDate->subDay();
             if (!in_array($checkDate->format('Y-m-d'), $dates)) {
                 $streak = 0;
             }
        }

        // Count consecutive days backwards
        if ($streak > 0 || in_array($checkDate->format('Y-m-d'), $dates)) {
             while (in_array($checkDate->format('Y-m-d'), $dates)) {
                 $streak++;
                 $checkDate->subDay();
             }
        }
        
        $this->currentStreak = $streak;

        $this->generateChartData();
    }

    protected function generateChartData(): void
    {
        $this->chartData = [
            'dates' => [],
            'incomes' => []
        ];

        // Start from target start date
        $currentDate = $this->activeTarget->start_date->copy();
        // End at today or target end date (whichever is earlier/relevant)
        // But for visualization, it's good to see up to today.
        $endDate = now()->startOfDay();
        
        // If target ended in the past, stop at target end date
        if ($this->activeTarget->end_date->isPast()) {
            $endDate = $this->activeTarget->end_date;
        }

        // Map existing progress by date string for easy lookup
        $progressMap = $this->activeTarget->dailyProgress
            ->groupBy(fn($item) => $item->date->format('Y-m-d'))
            ->map(fn($items) => $items->sum('income'));

        while ($currentDate->lte($endDate)) {
            $dateStr = $currentDate->format('Y-m-d');
            
            // Add date label (e.g., "06 Feb")
            $this->chartData['dates'][] = $currentDate->format('d M');
            
            // Add income or 0
            $this->chartData['incomes'][] = $progressMap->get($dateStr, 0);

            $currentDate->addDay();
        }
    }

    public function render()
    {
        return view('livewire.dashboard')
            ->layout('components.layouts.app', ['title' => 'Dashboard - Jejak']);
    }
}
