<?php

namespace App\Livewire;

use App\Models\Target;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class TargetForm extends Component
{
    #[Validate('nullable|string|max:255')]
    public string $title = '';

    #[Validate('required|date')]
    public string $start_date = '';

    #[Validate('required|date|after:start_date')]
    public string $end_date = '';

    public string $target_amount = '';

    public bool $hasActiveTarget = false;

    public function mount(): void
    {
        // Check if user already has an active target
        $this->hasActiveTarget = Auth::user()
            ->targets()
            ->where('status', 'active')
            ->exists();

        // Set default dates
        $this->start_date = now()->format('Y-m-d');
        $this->end_date = now()->addMonth()->format('Y-m-d');
    }

    public function save(): void
    {
        // Double check - user cannot create if already has active target (DB check)
        if (Auth::user()->targets()->where('status', 'active')->exists()) {
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

        Auth::user()->targets()->create([
            'title' => $this->title ?: null,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'target_amount' => (int) $this->target_amount,
            'status' => 'active',
        ]);

        session()->flash('success', 'Target berhasil dibuat!');
        
        $this->redirect(route('dashboard'), navigate: true);
    }

    public function render()
    {
        return view('livewire.target-form')
            ->layout('components.layouts.app', ['title' => 'Buat Target - Jejak']);
    }
}
