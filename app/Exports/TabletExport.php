<?php 

namespace App\Exports;

use Tu6ge\VoyagerExcel\Exports\BaseExport;
use App\Models\Tablet;

class TabletExport extends BaseExport
{
    protected $dataType;
    protected $model;

    public function __construct($dataType, array $ids)
    {
        $this->dataType = $dataType;
        $this->model = new $dataType->model_name();
    }

    public function collection()
    {
        $tablets = Tablet::with('arfForm')->get();
        
        $tablets->transform(function($tablet) {
            $tabletArray = $tablet->toArray();
            unset($tabletArray['arf_form']);
            $tabletArray['Emp_ID'] = $tablet->arfForm->emp_id;
            $tabletArray['Emp_Name'] = $tablet->arfForm->name;
            return $tabletArray;
        });
        
        $tablets->prepend($this->headings());
        
        return $tablets;
    }
    
    public function headings(): array
    {
        return [
            '#',
            'Asset_Code',
            'Asset_Brand',
            'Date_Issued',
            'Remarks',
            'History',
            'Status',
            'Arf_Form_ID',
            'Created_Date',
            'Updated_Date',
            'Emp_ID',
            'Emp_Name'
        ];
    }
}
