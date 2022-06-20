<?php

namespace App\Imports\Comet;

use App\Models\ExternalCourseCompletion;
use App\Models\Support\Language;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Carbon;


class FirstSheetImport implements ToCollection, WithStartRow, WithChunkReading, ShouldQueue
{
    use Importable;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (! in_array($row[11], ['English','French'])) {
                continue;
            }

            $language = Language::firstOrCreate([
                'name' => $row['11'],
            ]);

            $publishDate = $this->transformDate($row[13]);

            ExternalCourseCompletion::firstOrCreate([
                'lesson' => $row[10],
                'language_id' => $language->id,
                'date_completed' => $publishDate,
            ]);
        }
    }

    public function startRow() : int
    {
        return 2;
    }

    public function transformDate($date) : Carbon
    {
        return Carbon::parse(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date));
    }

    public function chunkSize() : int
    {
        return 1000;
    }
}
