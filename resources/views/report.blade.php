@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Asset Report</h1>
    <div class="d-flex justify-content-end mb-4">
        <form method="GET" action="{{ route('report') }}">
            <div class="d-flex align-items-center">
                <i class="fa fa-refresh" style="margin-right: 4px; cursor: pointer; " onclick="refreshPage()"></i>
                <div class="form-floating">
                    <select onchange="this.form.submit()" class="form-select" id="filter_status" name="filter_status">
                        <option value="With User" {{ $status == 'With User' ? 'selected' : '' }}>With Users</option>
                        <option value="Active" {{ $status == 'Active' ? 'selected' : '' }}>With IT</option>
                        <option value="Damaged" {{ $status == 'Damaged' ? 'selected' : '' }}>Damaged</option>
                    </select>
                    <label for="floatingSelect">Status</label>
                </div>
            </div>
        </form>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">

                    <h1>{{ $tabletChart->options['chart_title'] }}</h1>
                    {!! $tabletChart->renderHtml() !!}
              
                </div>

            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">

                    <h1>{{ $laptopChart->options['chart_title'] }}</h1>
                    {!! $laptopChart->renderHtml() !!}

                </div>

            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">

                    <h1>{{ $desktopChart->options['chart_title'] }}</h1>
                    {!! $desktopChart->renderHtml() !!}

                </div>

            </div>
        </div>
    </div>
    
    <br />
    
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">

                    <h1>{{ $simChart->options['chart_title'] }}</h1>
                    {!! $simChart->renderHtml() !!}
              
                </div>

            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">

                    <h1>{{ $monitorChart->options['chart_title'] }}</h1>
                    {!! $monitorChart->renderHtml() !!}

                </div>

            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">

                    <h1>{{ $mobileChart->options['chart_title'] }}</h1>
                    {!! $mobileChart->renderHtml() !!}

                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
{!! $tabletChart->renderChartJsLibrary() !!}
{!! $tabletChart->renderJs() !!}
{!! $laptopChart->renderJs() !!}
{!! $desktopChart->renderJs() !!}
{!! $monitorChart->renderJs() !!}
{!! $simChart->renderJs() !!}
{!! $mobileChart->renderJs() !!}

<script>
    function refreshPage(){
        window.location.href = '/report';
    }
</script>
@endsection
