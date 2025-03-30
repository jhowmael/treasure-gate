<?php

namespace App\View\Components\Alerts;

use Illuminate\View\Component;

class Success extends Component
{
    public $label;

    public function __construct($label = 'Success')
    {
        $this->label = $label;
    }

    public function render()
    {
        return view('components.alerts.success');
    }
}
