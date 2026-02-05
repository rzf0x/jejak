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

        // Progress percentage
        if ($this->activeTarget->target_amount > 0) {
            $this->progressPercentage = min(100, round(($this->totalIncome / $this->activeTarget->target_amount) * 100, 1));
        }
    }

    public function render()
    {
        return view('livewire.dashboard')
            ->layout('components.layouts.app', ['title' => 'Dashboard - Jejak']);
    }
}
