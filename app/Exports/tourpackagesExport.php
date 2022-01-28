<?php

namespace App\Exports;

use App\Services;
use App\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Concerns\WithTitle;

class servicesExport implements WithHeadings,FromCollection,ShouldAutoSize,WithEvents,WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $servicesData = Services::select('id','Category_id','ServiceName','PackageCode','ServicePrice')->where('Status',1)->orderBy('id','DESC')->get();
        foreach($servicesData as $key => $services){
            $categoryName = Category::select('CategoryName')->where('id', $services->Category_id)->first();
            $servicesData[$key]->Category_id = $categoryName->CategoryName;
        }
        return $servicesData;
        //return Services::all();
    }

    public function headings():array{
        return['Id','Category Name','Package Name','Package Code','Price'];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {

            // at row 1, insert 2 rows
            $event->sheet->insertNewRowBefore(1);

            // merge cells for full-width
            $event->sheet->mergeCells('A1:S1');

            // assign cell values
            $event->sheet->setCellValue('A1','TOUR PACKAGES');

            // assign cell styles
            $event->sheet->getStyle('A1:A2');
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
            BeforeExport::class => function(BeforeExport $event){
                $event->writer->getproperties()->setTitle('Tour packages');
            }
        ];
    }
    public function title():string
    {
        return 'Tour packages';
    }

}
