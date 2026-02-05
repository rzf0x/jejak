<?php

namespace App\Livewire;

use App\Models\DailyProgress;
use App\Models\Target;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class DailyProgressForm extends Component
{
    public ?Target $activeTarget = null;
    public ?DailyProgress $existingProgress = null;
    public bool $isEditMode = false;

    public string $date = '';

    public string $income = '';

    #[Validate('nullable|string|max:1000')]
    public string $achievement = '';

    #[Validate('nullable|string|max:1000')]
    public string $lesson_learned = '';

    #[Validate('nullable|string|max:1000')]
    public string $improvement_plan = '';

    public function mount(): void
    {
        // ... (lines 33-61 unchanged)
        // Get active target
        $this->activeTarget = Auth::user()
            ->targets()
            ->where('status', 'active')
            ->first();

        if (!$this->activeTarget) {
            session()->flash('error', 'Tidak ada target aktif. Buat target terlebih dahulu.');
            $this->redirect(route('targets.create'), navigate: true);
            return;
        }

        // Set today's date
        $this->date = now()->format('Y-m-d');

        // Check if progress for today already exists
        $this->existingProgress = $this->activeTarget
            ->dailyProgress()
            ->where('date', $this->date)
            ->first();

        if ($this->existingProgress) {
            $this->isEditMode = true;
            $this->income = (string) $this->existingProgress->income;
            $this->achievement = $this->existingProgress->achievement ?? '';
            $this->lesson_learned = $this->existingProgress->lesson_learned ?? '';
            $this->improvement_plan = $this->existingProgress->improvement_plan ?? '';
        }
    }

    public function save(): void
    {
        if (!$this->activeTarget) {
            session()->flash('error', 'Tidak ada target aktif.');
            return;
        }

        // Clean income first
        $this->income = str_replace(['.', ','], '', $this->income);

        $this->validate([
            'income' => 'required|integer|min:0',
            'achievement' => 'nullable|string|max:1000',
            'lesson_learned' => 'nullable|string|max:1000',
            'improvement_plan' => 'nullable|string|max:1000',
        ]);

        $data = [
            'income' => (int) $this->income,
            'achievement' => $this->achievement ?: null,
            'lesson_learned' => $this->lesson_learned ?: null,
            'improvement_plan' => $this->improvement_plan ?: null,
        ];

        if ($this->isEditMode && $this->existingProgress) {
            // Update existing progress
            $this->existingProgress->update($data);
            $message = 'Progress hari ini berhasil diperbarui!';
        } else {
            // Create new progress
            $this->activeTarget->dailyProgress()->create([
                'date' => $this->date,
                ...$data,
            ]);
            $message = 'Progress hari ini berhasil disimpan!';
        }

        session()->flash('success', $message);
        $this->redirect(route('dashboard'), navigate: true);
    }

    public function render()
    {
        return view('livewire.daily-progress-form')
            ->layout('components.layouts.app', ['title' => ($this->isEditMode ? 'Edit' : 'Tambah') . ' Progress - Jejak']);
    }
}
