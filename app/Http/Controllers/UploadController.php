<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogActivity;
use Illuminate\Support\Facades\DB;
use App\Services\Helper;

class UploadController extends Controller
{
    public function index(Request $request)
    {
        return view('arf_form.upload');
    }

    public function create(Request $request)
    {
        try {
            $from = $request->input('asset_from');
            $number_of_assets   = $request->input('number_of_assets');
            $table = $request->input('asset_type');
            $brand = $request->input('asset_brand');
            
            $asset_type = [
                'Laptop' => 'AZLAP',
                'Desktop' => 'AZDTC',
                'Tablet' => 'AD-IE-',
                'Monitor' => 'AZDTC',
                'Mobile' => 'AMOB',
                'Sim' => 'ASIM'
            ][$table];

            $assets = [];

            if(!$from || !$number_of_assets || !$table || !$brand){
                return back()->withErrors(['Please fill all Fields']);
            }

            $to = $from + $number_of_assets;

            foreach( range($from, $to) as $i ){
                $assets[] = [
                    'asset_code'  => $asset_type . $i,
                    'asset_brand' => $brand
                ];
            }

            DB::table(strtolower($table) . 's')->insert($assets);

            LogActivity::add('Asset_Uploaded_Success', json_encode($request->all()), 0, 'Admin');

            return back()->with('success', 'Assets have been uploaded successfully');

        } catch(\Exception $exception){
            LogActivity::add('Asset_Upload_Failre', json_encode(Helper::getErrorDetails($exception)), 0, 'Admin');

            return back()->withErrors([$exception->getMessage()]);
        }
    }

}
