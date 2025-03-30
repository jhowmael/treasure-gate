<?php

namespace App\View\Components\Alerts;

use Illuminate\View\Component;

class Error extends Component
{
    public $label;

    public function __construct($label = 'Error')
    {
        $this->label = $label;
    }

    public function render()
    {
        return view('components.alerts.error');
    }
}
