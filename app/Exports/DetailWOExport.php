<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DetailWOExport implements FromView
{
    public function __construct(string $keyword)
    {
        $this->nama = $keyword;
    }

    public function view(): View
    {
        // dd($this->nama);
        return view('report.wodet', ['data' => $this->nama ]);
    }
}
