@extends('layouts.app')

@section('content')

<style>
    .height {
        height: 100vh;
    }

    .form {
        position: relative;
    }

    .form .fa-search {
        position: absolute;
        top: 20px;
        left: 20px;
        color: #9ca3af;
    }

    .form span {
        position: absolute;
        right: 17px;
        top: 13px;
        padding: 2px;
        border-left: 1px solid #d1d5db;
    }

    .left-pan {
        padding-left: 7px;
    }

    .left-pan i {
        padding-left: 10px;
    }

    .form-input {
        height: 55px;
        text-indent: 33px;
        border-radius: 10px;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{ route('arfform.search') }}" method="POST">
                @csrf

                <div class="form">
                    <i class="fa fa-search"></i>
                    <input required type="text" name="search_main" class="form-control form-input" placeholder="Enter Employee ID">
                    <span class="left-pan"><i class="fa fa-microphone"></i></span>
                </div>

                <div class="text-end mt-3">
                    <button type="clear" class="btn btn-outline-secondary">Clear</button>
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>

            <div id="search-results" class="mt-5">
                @if( isset($results) && count($results) > 0 )
                @foreach($results as $result)
                <div class="card">
                    <div class="card-header">Search Results</div>
                    <div class="card-body">
                        <h5 class="search-heading-md">Overview</h5>
                        <div class="mb-3">
                            The User "{{ $result->name }}" is using following items:
                        </div>

                        <table class="table table-primary table-responsive table-bordered table-sm">
                            <thead>
                                <th>Laptop</th>
                                <th>Desktop</th>
                                <th>Monitor</th>
                                <th>Sim</th>
                                <th>Tablet</th>
                                <th>Mobile</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ count($result->laptops) }}</td>
                                    <td>{{ count($result->desktops) }}</td>
                                    <td>{{ count($result->monitors) }}</td>
                                    <td>{{ count($result->sims) }}</td>
                                    <td>{{ count($result->tablets) }}</td>
                                    <td>{{ count($result->mobiles) }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5 class="search-heading-md">User Information</h5>
                        <table class="table table-secondary table-responsive table-bordered table-sm">
                            <thead>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Office Location</th>
                                <th>Dept</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $result->name }}</td>
                                    <td>{{ $result->email }}</td>
                                    <td>{{ $result->office_location_id }}</td>
                                    <td>{{ $result->department_id }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5 class="search-heading-md">Laptops</h5>
                        <table class="table table-success table-responsive table-bordered table-sm">
                            <thead>
                                <th>Asset Code</th>
                                <th>Asset Brand</th>
                                <th>Date Issued</th>
                                <th>Remarks</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                @forelse( $result->laptops as $result_laptop )
                                <tr>
                                    <td>{{ $result_laptop->asset_code }}</td>
                                    <td>{{ $result_laptop->asset_brand }}</td>
                                    <td>{{ $result_laptop->date_issued }}</td>
                                    <td>{{ $result_laptop->remarks }}</td>
                                    <td>{{ $result_laptop->status }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10">No Laptops</td>
                                </tr>
                                @endforelse 
                            </tbody>
                        </table>
                        
                        <h5 class="search-heading-md">Desktops</h5>
                        <table class="table table-success table-responsive table-bordered table-sm">
                            <thead>
                                <th>Asset Code</th>
                                <th>Asset Brand</th>
                                <th>Date Issued</th>
                                <th>Remarks</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                @forelse( $result->desktops as $result_desktop )
                                <tr>
                                    <td>{{ $result_desktop->asset_code }}</td>
                                    <td>{{ $result_desktop->asset_brand }}</td>
                                    <td>{{ $result_desktop->date_issued }}</td>
                                    <td>{{ $result_desktop->remarks }}</td>
                                    <td>{{ $result_desktop->status }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10">No Desktops</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        <h5 class="search-heading-md">Monitors</h5>
                        <table class="table table-success table-responsive table-bordered table-sm">
                            <thead>
                                <th>Asset Code</th>
                                <th>Asset Brand</th>
                                <th>Date Issued</th>
                                <th>Remarks</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                @forelse( $result->monitors as $result_monitor )
                                <tr>
                                    <td>{{ $result_monitor->asset_code }}</td>
                                    <td>{{ $result_monitor->asset_brand }}</td>
                                    <td>{{ $result_monitor->date_issued }}</td>
                                    <td>{{ $result_monitor->remarks }}</td>
                                    <td>{{ $result_monitor->status }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10">No Monitors</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        <h5 class="search-heading-md">Tablets</h5>
                        <table class="table table-success table-responsive table-bordered table-sm">
                            <thead>
                                <th>Asset Code</th>
                                <th>Asset Brand</th>
                                <th>Date Issued</th>
                                <th>Remarks</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                @forelse( $result->tablets as $result_tablet )
                                <tr>
                                    <td>{{ $result_tablet->asset_code }}</td>
                                    <td>{{ $result_tablet->asset_brand }}</td>
                                    <td>{{ $result_tablet->date_issued }}</td>
                                    <td>{{ $result_tablet->remarks }}</td>
                                    <td>{{ $result_tablet->status }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10">No Tablets</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        <h5 class="search-heading-md">Sims</h5>
                        <table class="table table-success table-responsive table-bordered table-sm">
                            <thead>
                                <th>Asset Code</th>
                                <th>Asset Brand</th>
                                <th>Date Issued</th>
                                <th>Remarks</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                @forelse( $result->sims as $result_sim )
                                <tr>
                                    <td>{{ $result_sim->asset_code }}</td>
                                    <td>{{ $result_sim->asset_brand }}</td>
                                    <td>{{ $result_sim->date_issued }}</td>
                                    <td>{{ $result_sim->remarks }}</td>
                                    <td>{{ $result_sim->status }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10">No Sim</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        <h5 class="search-heading-md">Mobile</h5>
                        <table class="table table-success table-responsive table-bordered table-sm">
                            <thead>
                                <th>Asset Code</th>
                                <th>Asset Brand</th>
                                <th>Date Issued</th>
                                <th>Remarks</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                @forelse( $result->mobiles as $result_mobile )
                                <tr>
                                    <td>{{ $result_mobile->asset_code }}</td>
                                    <td>{{ $result_mobile->asset_brand }}</td>
                                    <td>{{ $result_mobile->date_issued }}</td>
                                    <td>{{ $result_mobile->remarks }}</td>
                                    <td>{{ $result_mobile->status }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10">No Mobiles</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection