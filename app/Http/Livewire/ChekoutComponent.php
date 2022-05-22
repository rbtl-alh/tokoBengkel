<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ChekoutComponent extends Component
{
    public function render()
    {
        return view('livewire.chekout-component')->layout('layouts.customer');
    }
}
