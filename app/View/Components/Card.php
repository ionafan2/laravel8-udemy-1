<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public $title;
    public $subtitle;
    public $items;

    /**
     * @param $title
     * @param $subtitle
     * @param $items
     */
    public function __construct($title, $subtitle, $items = [])
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->items = $items;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.card');
    }
}
