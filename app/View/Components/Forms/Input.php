<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $name;
    public $type;
    public $value;
    public $label;
    public $class;
    public function __construct($name , $type, $value, $label, $class)
    {
        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
        $this->label = $label;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.input');
    }
}
