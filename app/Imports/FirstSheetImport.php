<?php

namespace App\Imports;

use App\Models\CourseCategory;
use App\Models\MoodleCourseCatalogue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;


class FirstSheetImport implements ToCollection, WithStartRow, WithChunkReading, ShouldQueue
{

    private $category;
    private $titles;

    /**
     * FirstSheetImport constructor.
     */

    public function __construct()
    {
        $this->titles = DB::table('moodle_course_catalogues')->select('title')->get();
    }
    use Importable;

    /**
     * @param Collection $rows
     *
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {

            if ($row[0] === 'English' || $row[0] === "French") {

                $Cat = MoodleCourseCatalogue::where('title', '=', $row[2])->first();
                $Course_category =  DB::table('course_categories')->whereJsonContains('category_name', ['english' =>
                    $row[3]])
                    ->first();
                $publishDate = $this->transformDate($row[1]);

                if ($Cat && !$Course_category)
                {
                    $courseCategory =CourseCategory::firstOrCreate(['category_name' => ['english' => $row[3],'french' =>
                        '']]);
                    $mdlCourseCat = $Cat;
                    $mdlCourseCat->courseCategories()->attach($courseCategory->id);

                    continue;
                }elseif(!$Cat && $Course_category){

                    $newMdlCourseCat = MoodleCourseCatalogue::firstOrCreate([

                        'language' => $row[0],
                        'publish_date' => $publishDate,
                        'title' => $row[2],
                        'completion_time' => $row[4],
                    ]);
                    $newMdlCourseCat->courseCategories()->attach($Course_category->id);
                    continue;
                }elseif(!$Cat && !$Course_category){

                    $newNewMdlCourse = MoodleCourseCatalogue::firstOrCreate([

                        'language' => $row[0],
                        'publish_date' => $publishDate,
                        'title' => $row[2],
                        'completion_time' => $row[4],
                    ]);
                    $newNewCourseCat = $courseCategory =CourseCategory::firstOrCreate(['category_name' => ['english' => $row[3],'french' =>
                        '']]);
                    $newNewMdlCourse->courseCategories()->attach($newNewCourseCat->id);
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
        Log::info($date);

        $publishDate = preg_match($reg1, $cleanDate)
            ? Carbon::createFromFormat('m/d/y', $cleanDate)
            : Carbon::parse(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($cleanDate));
        return $publishDate;
    }
    public function chunkSize(): int
    {
        return 1000;
    }

}
