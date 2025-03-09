<?php
namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public $message;
    public $icon;

    public function __construct($message,$icon)
    {
        $this->message = $message;
        $this->icon = $icon;
    }

    public function render()
    {
        return view('components.alert');
    }
}
