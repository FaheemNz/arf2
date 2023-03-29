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
        if( ! auth()->user()->hasRole('admin') ){
            return redirect('/');
        }

        return view('arf_form.upload');
    }

    public function create(Request $request)
    {
        if( ! auth()->user()->hasRole('admin') ){
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to perform this action'
            ]);
        }

        Log::info('### Asset Upload Start ###', [
            'Request' => json_encode( $request->all() )
        ]);

        try {
            $from = $request->input('asset_from');
            $number_of_assets   = $request->input('number_of_assets');
            $table = $request->input('asset_type');
            $brand = $request->input('asset_brand');
            
            $asset_type = [
                'Laptop' => 'AZLAP',
                'Desktop' => 'AZDTC',
                'Tablet' => 'AZTAB',
                'Monitor' => 'AZDTC',
                'Mobile' => 'AZMOB',
                'Sim' => ''// 0501231231
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
            LogActivity::add('Asset_Upload_Failure', json_encode(Helper::getErrorDetails($exception)), 0, 'Admin');

            return back()->withErrors([$exception->getMessage()]);
        }
    }

}
