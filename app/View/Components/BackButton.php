<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BackButton extends Component
{
    public $fallbackRoute;
    public $text;

    public function __construct($fallbackRoute = 'dashboard', $text = 'Back')
    {
        $this->fallbackRoute = $fallbackRoute;
        $this->text = $text;
    }

    public function render()
    {
        return view('components.back-button');
    }

    public function getUrl()
    {
        if (url()->previous() !== url()->current()) {
            return url()->previous();
        }

        return route($this->fallbackRoute);
    }
}
