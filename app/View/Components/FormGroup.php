<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormGroup extends Component
{
    public $label;
    public $name;
    public $slot;

    public function __construct($label, $name)
    {
        $this->label = $label;
        $this->name = $name;
    }

    public function render(): View|Closure|string
    {
        return view('components.form-group');
    }
}
