<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Application;

class AnnualForeignLeaveExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize{

    protected int $year;

    public function __construct(int $year){
        $this->year = $year;
    }

    public function collection(): Collection{
        return Application::with([
            'applicant',
            'applicant.office',
            'applicant.designation',
            'ministry',
            'institute',
            'goslFunds',
            'workflowHistories.user.office',
        ])
        ->whereYear('created_at', $this->year)
        ->where('status', 'Approved')
        ->orderBy('created_at')
        ->get();
    }

    public function headings(): array{
        return [
            'අනු අංකය',
            'නම',
            'තනතුර',
            'ආයතනය',
            'පාඨමාලාව',
            'රට',
            'දින සිට',
            'දින දක්වා',
            'විදේශ නිවාඩු අනුමත කල දිනය',
            'දීමනාව ලිපිය ලද දිනය',
            'දීමනාව',
            'දීමනාව ලබා දීම අනුමත කල දිනය',
            'උණුසුම් ඇදුම් දීමනාව ලිපියේ දිනය',
            'උණුසුම් ඇදුම් දීමනාව ලිපිය ලද දිනය',
            'ක්‍රියාමාර්ග ගත් දිනය',
            'උණුසුම් ඇඳුම් දීමනාව අනුමත කල දිනය',
            'උණුසුම් ඇඳුම් දීමනාව',
            'අමාත්‍යාංශය වෙත දැන්වූ දිනය',
            'සංයුක්ත දීමානව',
            'සංයුක්ත දීමනාව අනුමත කල දිනය',
            'විදේශ නිවාඩු දින සංශෝධනයට ලිපිය ලද දිනය',
            'ක්‍රියාකල දිනය',
            'විදේශ නිවාඩු දින සංශෝධන අනුමැතිය ලද දිනය',
            'විදේශ නිවාඩු  සංශෝධන දිනය සිට',
            'දක්වා',
            'සංශෝධනය අමාත්‍යාංශය වෙත දැන්වූ දිනය',
            'වෙනත්',
        ];
    }

    public function map($application):array{
        $gosl = $application->goslFunds->first();

        return [
            //1
            null,

            //2
            $application->name,

            //3
            $application->applicant?->designation?->name,

            //4
            $application->institute?->name,

            //5
            // patamilawa
            null,
            
            //6
            $application->country,

            //7
            $application->leave_start_date,

            //8
            $application->leave_end_date,

            //9
            $application->approved_at,

            //10
            //දීමනාව ලිපිය ලද දිනය
            null,

            //11
            //දීමනාව
            null,

            //12
            //දීමනාව ලබා දීම අනුමත කල දිනය
            null,

            //13
            //උණුසුම් ඇදුම් දීමනාව ලිපියේ  දිනය
            null,

            //14
            //උණුසුම් ඇදුම් දීමනාව ලිපිය ලද දිනය
            null,

            //15
            //ක්‍රියාමාර්ග ගත් දිනය
            null,

            //16
            //උණුසුම් ඇඳුම් දීමනාව අනුමත කල දිනය
            null,

            //17
            //උණුසුම් ඇඳුම් දීමනාව
            null,

            //18
            //අමාත්‍යාංශය වෙත දැන්වූ දිනය
            null,

            //19
            //සංයුක්ත දීමානව
            null,

            //20
            //සංයුක්ත දීමනාව අනුමත කල දිනය
            null,

            //21
            //විදේශ නිවාඩු දින සංශෝධනයට ලිපිය ලද දිනය
            null,

            //22
            //ක්‍රියාකල දිනය
            null,

            //23
            //විදේශ නිවාඩු දින සංශෝධන අනුමැතිය ලද දිනය
            null, 

            //24
            //විදේශ නිවාඩු  සංශෝධන දිනය සිට
            null,

            //25
            //දක්වා
            null,

            //26
            //සංශෝධනය අමාත්‍යාංශය වෙත දැන්වූ දිනය
            null,

            //27
            //වෙනත්
            null,
        ];
    }
}
