<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $status = '';

        if($request->has('filter_status')){
            $status = "status = '{$request->filter_status}'";
        }

        $tabletChart = new LaravelChart([
            'chart_title' => 'Tablets',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Tablet',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'bar',
            'where_raw' => $status
        ]);
        
        $laptopChart = new LaravelChart([
            'chart_title' => 'Laptops',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Laptop',
            'group_by_field' => 'created_at',
            'group_by_period' => 'week',
            'chart_type' => 'bar',
            'where_raw' => $status
        ]);
        
        $desktopChart = new LaravelChart([
            'chart_title' => 'Desktops',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Desktop',
            'group_by_field' => 'created_at',
            'group_by_period' => 'week',
            'chart_type' => 'bar',
            'where_raw' => $status
        ]);
        
        $simChart = new LaravelChart([
            'chart_title' => 'Sims',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Sim',
            'group_by_field' => 'created_at',
            'group_by_period' => 'week',
            'chart_type' => 'bar',
            'where_raw' => $status
        ]);
        
        $monitorChart = new LaravelChart([
            'chart_title' => 'Monitors',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Sim',
            'group_by_field' => 'created_at',
            'group_by_period' => 'week',
            'chart_type' => 'bar',
            'where_raw' => $status
        ]);
        
        $mobileChart = new LaravelChart([
            'chart_title' => 'Mobiles',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Mobile',
            'group_by_field' => 'created_at',
            'group_by_period' => 'week',
            'chart_type' => 'bar',
            'where_raw' => $status
        ]);
        
        return view('report', [
            'tabletChart'   => $tabletChart,
            'laptopChart'   => $laptopChart,
            'desktopChart'  => $desktopChart,
            'simChart'      => $simChart,
            'monitorChart'  => $monitorChart,
            'mobileChart'   => $mobileChart,
            'status'        => $request->filter_status
        ]);
    }
}
