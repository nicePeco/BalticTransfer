<?php

namespace App\Livewire;

use Livewire\Component;

class DynamicContent extends Component
{
    public $view = 'home';

    protected $listeners = ['navigate'];

    public function navigate($view)
    {
        $this->view = $view;
    }

    public function render()
    {
        return view('livewire.dynamic-content', ['view' => $this->view]);
    }
}
