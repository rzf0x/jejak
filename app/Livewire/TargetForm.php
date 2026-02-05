<?php

namespace App\Livewire;

use App\Models\Target;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class TargetForm extends Component
{
    public ?Target $target = null;
    public bool $isEditMode = false;

    #[Validate('nullable|string|max:255')]
    public string $title = '';

    #[Validate('required|date')]
    public string $start_date = '';

    #[Validate('required|date|after:start_date')]
    public string $end_date = '';

    public string $target_amount = '';

    public bool $hasActiveTarget = false;

    public function mount(Target $target = null): void
    {
        if ($target->exists) {
            // Edit Mode
            if ($target->user_id !== Auth::id()) {
                abort(403);
            }
            
            $this->target = $target;
            $this->isEditMode = true;
            
            $this->title = $target->title ?? '';
            $this->start_date = $target->start_date->format('Y-m-d');
            $this->end_date = $target->end_date->format('Y-m-d');
            $this->target_amount = (string) $target->target_amount;
        } else {
            // Create Mode
            // Check if user already has an active target
            $this->hasActiveTarget = Auth::user()
                ->targets()
                ->where('status', 'active')
                ->exists();

            // Set default dates
            $this->start_date = now()->format('Y-m-d');
            $this->end_date = now()->addMonth()->format('Y-m-d');
        }
    }

    public function save(): void
    {
        // Double check - user cannot create if already has active target (DB check), unless editing
        if (!$this->isEditMode && Auth::user()->targets()->where('status', 'active')->exists()) {
            session()->flash('error', 'Anda sudah memiliki target aktif. Selesaikan atau batalkan target tersebut terlebih dahulu.');
            return;
        }

        // Clean target_amount first (remove dots/commas)
        $this->target_amount = str_replace(['.', ','], '', $this->target_amount);

        $this->validate([
            'title' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'target_amount' => 'required|integer|min:1',
        ]);

        $data = [
            'title' => $this->title ?: null,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'target_amount' => (int) $this->target_amount,
            'status' => 'active',
        ];

        if ($this->isEditMode) {
            $this->target->update($data);
            $message = 'Target berhasil diperbarui!';
        } else {
            Auth::user()->targets()->create($data);
            $message = 'Target berhasil dibuat!';
        }

        session()->flash('success', $message);
        
        $this->redirect(route('dashboard'), navigate: true);
    }

    public function render()
    {
        return view('livewire.target-form')
            ->layout('components.layouts.app', ['title' => ($this->isEditMode ? 'Edit' : 'Buat') . ' Target - Jejak']);
    }
}
