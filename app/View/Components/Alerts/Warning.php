<?php

namespace App\View\Components\Alerts;

use Illuminate\View\Component;

class Warning extends Component
{
    public $label;

    public function __construct($label = 'Warning')
    {
        $this->label = $label;
    }

    public function render()
    {
        return view('components.alerts.warning');
    }
}
