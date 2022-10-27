<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GenerateWOExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $datatemp;

    public function __construct($datatemp){
        $this->datatemp = $datatemp;
    }

    public function headings(): array
    {
        return ["WO Number","Asset Site","Asset Location","Asset Code","Asset Desc","Schedule Date","Due Date","Generate At"];
    }

    public function collection()
    {
        //
        // dd($this->datatemp);
        return $this->datatemp;
    }
}
