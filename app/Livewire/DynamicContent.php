<?php

namespace App\Livewire;

use Livewire\Component;

class DynamicContent extends Component
{
    public $view = 'home'; // Default view to load

    protected $listeners = ['navigate']; // Listen for navigation events

    public function navigate($view)
    {
        $this->view = $view;
    }

    public function render()
    {
        return view('livewire.dynamic-content', ['view' => $this->view]);
    }
}
