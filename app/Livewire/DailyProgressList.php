<?php

namespace App\Livewire;

use App\Models\DailyProgress;
use App\Models\Target;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DailyProgressList extends Component
{
    use WithPagination;

    public ?Target $activeTarget = null;
    public ?DailyProgress $selectedProgress = null;
    public bool $showModal = false;

    public function mount(): void
    {
        $this->activeTarget = Auth::user()
            ->targets()
            ->where('status', 'active')
            ->first();
    }

    public function showDetail(int $progressId): void
    {
        $progress = DailyProgress::find($progressId);
        
        // Security check: ensure progress belongs to current user's active target
        if ($progress && $this->activeTarget && $progress->target_id === $this->activeTarget->id) {
            $this->selectedProgress = $progress;
            $this->showModal = true;
        }
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->selectedProgress = null;
    }

    public function editProgress(int $progressId): void
    {
        // Redirect to edit page
        $this->redirect(route('progress.create'), navigate: true);
    }

    public function deleteProgress(int $progressId): void
    {
        $progress = DailyProgress::find($progressId);

        // Security check: ensure progress belongs to current user's active target
        if ($progress && $progress->target_id === $this->activeTarget->id) {
            $progress->delete();
            
            // Close modal if deleting the currently viewed item
            if ($this->selectedProgress && $this->selectedProgress->id === $progressId) {
                $this->closeModal();
            }

            session()->flash('success', 'Progress berhasil dihapus.');
        }
    }

    public function render()
    {
        $progressList = collect();

        if ($this->activeTarget) {
            $progressList = $this->activeTarget
                ->dailyProgress()
                ->orderBy('date', 'desc')
                ->paginate(10);
        }

        return view('livewire.daily-progress-list', [
            'progressList' => $progressList,
        ])->layout('components.layouts.app', ['title' => 'Riwayat Progress - Jejak']);
    }
}
