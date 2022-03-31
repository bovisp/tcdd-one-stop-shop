<?php

namespace App\Imports;

use App\Models\MoodleCourseCatalogue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;


class SecondSheetImport implements ToCollection, WithStartRow
{

    use Importable;

    /**
     * @param Collection $rows
     */

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if ($row[0] === 'English' || $row[0] === "French") {

                $Cat = MoodleCourseCatalogue::where('title', '=', $row[2])->first();
                if ($Cat) {
                   $Cat->objective = $row[3];
                   $Cat->save();
                    continue;
                } else {

                    $publishDate = $this->transformDate($row[1]);

                    MoodleCourseCatalogue::firstOrCreate([

                        'language' => $row[0],
                        'publish_date' => $publishDate,
                        'title' => $row[2],
                        'objective' => $row[3]
                    ]);
                }
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
        $reg1= '/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{2}$/';
        $cleanDate = str_replace('\'', '', $date);

        $publishDate = preg_match($reg1, $cleanDate)
            ? Carbon::createFromFormat('m/d/y', $cleanDate)
            : Carbon::parse(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($cleanDate));
        return $publishDate;
    }
}
