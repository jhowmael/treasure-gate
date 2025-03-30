<?php

namespace App\View\Components\Buttons;

use Illuminate\View\Component;

class Submit extends Component
{
    public $label;
    public $id;

    public function __construct($label = 'Submit', $id = '')
    {
        $this->label = $label;
        $this->id = $id; 
    }

    public function render()
    {
        return view('components.buttons.submit');
    }
}
