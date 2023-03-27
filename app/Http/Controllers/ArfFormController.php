<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArfFormRequest;
use App\Http\Requests\ArfFormUpdateRequest;
use App\Models\ArfForm;
use App\Models\Department;
use App\Models\Verification;
use Illuminate\Http\Request;
use App\Jobs\ArfJob;
use App\Models\LogActivity;
use App\Models\OfficeLocation;
use App\Services\ArfFormService;
use App\Services\Helper;

class ArfFormController extends Controller
{
    public function index()
    {
        return view('arf_form.create', [
            'departments'       =>      Department::all(),
            'laptopBrands'      =>      ArfForm::getLaptopBrands(),
            'desktopBrands'     =>      ArfForm::getDesktopBrands(),
            'monitorBrands'     =>      ArfForm::getMonitorBrands(),
            'tabletBrands'      =>      ArfForm::getTabletBrands(),
            'simNetworks'       =>      ArfForm::getSimNetworks(),
            'officeLocations'   =>      OfficeLocation::all()
        ]);
    }

    public function create(ArfFormRequest $arfFormRequest)
    {
        try {
            $arfData = $arfFormRequest->validated();
            
            $token = Verification::getToken();
            
            $body = [
                'name'      =>      $arfData['arf_name'],
                'email'     =>      $arfData['arf_email'],
                'url'       =>      Verification::getUrl($token),
                'items'     =>      ArfFormService::getItems($arfData)
            ];
            
            dispatch(new ArfJob($body, $arfData, $token));
            
            return back()->with('success', 'ARF Saved Successfully');
            
        } catch (\Exception $exception) {
            LogActivity::add('Exception', json_encode(Helper::getErrorDetails($exception)), 0, 'NULL_User');
            
            return back()->withErrors([$exception->getMessage()]);
        }
    }
    
    public function edit(Request $request, int $id)
    {
        $arf = ArfForm::findOrFail($id);
        $departments = Department::all();

        return view('arf_form.edit', [
            'arf'           =>      $arf,
            'departments'   =>      $departments
        ]);
    }

    public function update(ArfFormUpdateRequest $arfFormUpdateRequest)
    {
        return back()->with('success', 'ARF has been updated successfully');
    }
}
