<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;

class FilterResultsExport implements FromCollection
{
    protected $showFilterResult;

    /**
     * FilterResultsExport constructor.
     * @param $data
     */
    public function __construct($data) {
        $this->showFilterResult = $data;
    }

    /**
     * @return Collection
     */
    public function collection() {
        return $this->showFilterResult;
    }
}
