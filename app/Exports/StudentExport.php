<?php

namespace App\Exports;

use App\Models\Student;
// use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class StudentExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return Student::all();
    // }

    public function view(): View
    {
        return view('admin.students.export_csv', [
            'students' => Student::all()
        ]);
    }
}
