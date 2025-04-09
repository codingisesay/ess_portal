<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Pagination extends Component
{
    public $currentPage;
    public $totalPages;
    public $onPageChange;
    public $style;

    public function __construct($currentPage = 1, $totalPages = 1, $onPageChange = 'changePage', $style = 'default')
    {
        $this->currentPage = $currentPage;
        $this->totalPages = $totalPages;
        $this->onPageChange = $onPageChange;
        $this->style = $style;
    }

    public function render()
    {
        return view('components.pagination');
    }
}