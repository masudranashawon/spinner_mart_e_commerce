<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public string $label = "",
        public string $type = "text",
        public string $value = "",
        public string $placeholder = "",
        public bool $required = false,
        public bool $readonly = false,
        public bool $disabled = false,
        public ?string $class = null,
        public ?string $id = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input');
    }
}
