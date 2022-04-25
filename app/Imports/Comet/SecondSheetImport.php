<?php

namespace App\Imports\Comet;

use App\Models\ExternalCourseView;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SecondSheetImport implements ToCollection, WithStartRow, WithChunkReading, ShouldQueue
{

    use Importable;

    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            if ($row[11] === 'English' || 'French'){

                $publishDate = $this->transformDate($row[15]);

                ExternalCourseView::firstOrCreate([

                    'lesson' => $row[10],
                    'language' => $row[11],
                    'session' => $row[12],
                    'date' => $publishDate,
                ]);
            }

        }
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    public function transformDate($date)
    {
        $publishDate = Carbon::parse(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date));
        return $publishDate;
    }
    public function chunkSize(): int
    {
        return 1000;
    }
}
