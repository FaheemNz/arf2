<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArfFormRequest;
use App\Http\Requests\ArfFormUpdateRequest;
use App\Models\ArfForm;
use App\Models\Department;
use App\Models\Verification;
use Illuminate\Http\Request;
use App\Jobs\ArfJob;
use App\Jobs\ArfUpdateJob;
use App\Models\LogActivity;
use App\Models\OfficeLocation;
use App\Services\ArfFormService;
use App\Services\Helper;
use Illuminate\Support\Facades\Log;

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

    public function create(ArfFormRequest $arfFormRequest, ArfForm $arfForm)
    {
        if( ! auth()->user()->can('add', $arfForm) ){
            return redirect()
                    ->back()
                    ->withErrors(['You are not authorized to create ARF Form']);
        }

        Log::info('### ARF Form Created ###', [
            'Username' => auth()->user()->name,
            'Time'     => now()
        ]);

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

        if($arf->status == 'In Active'){
            return view('arferror', [
                'title' => 'ARF Form In Active',
                'message' => 'This ARF Form has been offboarded and is now In-Active'
            ]);
        }

        return view('arf_form.edit', [
            'arf'               =>      $arf,
            'laptopBrands'      =>      ArfForm::getLaptopBrands(),
            'desktopBrands'     =>      ArfForm::getDesktopBrands(),
            'monitorBrands'     =>      ArfForm::getMonitorBrands(),
            'tabletBrands'      =>      ArfForm::getTabletBrands(),
            'simNetworks'       =>      ArfForm::getSimNetworks()
        ]);
    }

    public function update(ArfFormUpdateRequest $arfFormUpdateRequest)
    {
        try {
            $arfData = $arfFormUpdateRequest->validated();
            
            $token = Verification::getToken();
            
            $body = [
                'name'      =>      $arfData['arf_name'],
                'email'     =>      $arfData['arf_email'],
                'url'       =>      Verification::getUrl($token),
                'items'     =>      ArfFormService::getItems($arfData)
            ];
            
            dispatch(new ArfUpdateJob($body, $arfData, $token, $arfData['arf_id']));
            
            return back()->with('success', 'ARF Updated Successfully');
            
        } catch (\Exception $exception) {
            LogActivity::add('Exception_Asset_Update', json_encode(Helper::getErrorDetails($exception)), $arfFormUpdateRequest['arf_id'], 'NULL_User');
            
            return back()->withErrors([$exception->getMessage()]);
        }
    }
}
