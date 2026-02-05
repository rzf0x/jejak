<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Login extends Component
{
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required')]
    public string $password = '';

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();
            return $this->redirectIntended(route('dashboard'), navigate: true);
        }

        $this->addError('email', 'Email atau password salah.');
    }

    #[Layout('components.layouts.app', ['title' => 'Masuk - Jejak'])]
    public function render()
    {
        return view('livewire.auth.login');
    }
}
