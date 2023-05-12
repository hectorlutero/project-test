<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class ImportModal extends Component
{
    /**
     * Create the component instance.
     */
    public function __construct(
        public string $companies
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.import-spreadsheet-modal');
    }
}