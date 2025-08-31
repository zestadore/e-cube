<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputBox extends Component
{
    
    public $title = "";
    public $name = "";
    public $required = "";
    public $id = "";
    public $type = "";
    public $class= "";
    public $value="";

    public function __construct($title,$name,$required,$id,$type,$class,$value=0)
    {
        $this->title = $title;
        $this->name = $name;
        $this->required = $required;
        $this->id = $id;
        $this->type = $type;
        $this->class = $class;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input-box');
    }
}
