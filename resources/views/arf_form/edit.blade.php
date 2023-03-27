@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('arfform.update') }}" method="POST">
        <input type="hidden" name="arf_id" value="<?php echo $arf->id ?>" />
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-8">

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/" class="text-dark">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit ARF Form</li>
                    </ol>
                </nav>

                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible">
                    {{ Session::get('success') }}
                    @php
                    Session::forget('success');
                    @endphp
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div id="arf-form-container">
                    <!-- Section 1 -->
                    <div id="arf-form-header">
                        <table class="table table-sm table-bordered m-0 p-0">
                            <tbody>
                                <tr class="d-flex align-items-center p-0">
                                    <td class="col-3">
                                        <img src="{{ asset('images/Azizi_Logo.png') }}" height="136" width="180" alt="">
                                    </td>
                                    <td class="col-5 text-center border-0">
                                        <div class="arf-heading-lg">it asset release form [arf]</div>
                                    </td>
                                    <td class="col-4">
                                        <table class="table table-bordered table-sm m-0 table-striped" id="arf-header-table">
                                            <tbody>
                                                <tr>
                                                    <td class="arf-heading-md col-1">Date: </td>
                                                    <td>
                                                        <input class="form-control arf-form-control" type="date" name="arf_date" value="<?php echo date('Y-m-d', strtotime($arf->arf_date)) ?>" required>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="arf-heading-md col-1">Dept: </td>
                                                    <td>
                                                        <select name="dept" id="dept" required style="height: 28px; line-height: 1" class="form-select">
                                                            @foreach($departments as $d)
                                                                <option value="{{ $d->name }}">{{ $d->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="arf-heading-md col-1">Office_Loc:</td>
                                                    <td>
                                                        <input class="form-control arf-form-control" type="text" name="arf_office_location" value="{{ $arf->office_location }}" required>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="arf-heading-md col-1">Emp ID: </td>
                                                    <td>
                                                        <input class="form-control arf-form-control" value="{{ $arf->emp_id }}" type="text" name="arf_emp_id" required>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Section 2 -->
                    <div id="arf-section-2">
                        <table class="table table-bordered table-sm m-0">
                            <tbody>
                                <table class="table table-bordered table-sm">
                                    <tbody>
                                        <tr>
                                            <td colspan="2" id="arf-section-2-heading">Staff Details</td>
                                        </tr>
                                        <tr>
                                            <td class="col-3 arf-heading-md">Name</td>
                                            <td>
                                                <input value="{{ $arf->name }}" class="form-control arf-form-control arf-form-control-section-2" type="text" name="arf_name" required />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-3 arf-heading-md">Contact Details</td>
                                            <td>
                                                <input value="{{ $arf->contact_details }}" class="form-control arf-form-control arf-form-control-section-2" type="text" name="arf_contact_details" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-3 arf-heading-md">Email ID</td>
                                            <td>
                                                <input value="{{ $arf->email }}" class="form-control arf-form-control arf-form-control-section-2" type="text" name="arf_email" required />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </tbody>
                        </table>
                    </div>

                    <!-- Section 3 -->
                    <div id="arf-section-3">
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="text-uppercase text-center">
                                <th>s/n</th>
                                <th>items</th>
                                <th style="width: 100px">asset_code</th>
                                <th style="width: 100px">sno/brand</th>
                                <th style="width: 100px">date_issued</th>
                                <th>remarks</th>
                                <th>Status</th>
                                <th style="width: 40px;"></th>
                            </thead>
                            <tbody>
                                @if( count($arf->laptops) > 0 )
                                @foreach( $arf->laptops as $k=>$laptop )
                                <tr>
                                    <td>1x{{ ++$k }}</td>
                                    <td class="arf-heading-md">laptop</td>
                                    <td>
                                        <input disabled value="{{ $laptop->asset_code }}" class="form-control arf-form-control arf-form-control-section-2" type="text" />
                                    </td>
                                    <td>
                                        <input disabled value="{{ $laptop->asset_brand }}" class="form-control arf-form-control arf-form-control-section-2" type="text" />
                                    </td>
                                    <td>
                                        <input disabled value="{{ $laptop->date_issued }}" class="form-control arf-form-control arf-form-control-section-2" type="date" />
                                    </td>
                                    <td>
                                        <input disabled value="{{ $laptop->remarks }}" class="form-control arf-form-control arf-form-control-section-2" type="text" />
                                    </td>
                                    <td>
                                        <span class="text-truncate">{{ $laptop->status }}</span>
                                    </td>
                                    <td class="remove-asset">
                                        <i class="fa fa-close"></i>
                                    </td>
                                </tr>
                                @endforeach
                                @endif

                                @if( count($arf->tablets) > 0 )
                                @foreach($arf->tablets as $k=>$tablet)
                                <tr>
                                    <td>2x{{ ++$k }}</td>
                                    <td class="arf-heading-md">tablet</td>
                                    <td>
                                        <input disabled value="{{ $tablet->asset_code ?? '' }}" class="form-control arf-form-control arf-form-control-section-2" type="text" />
                                    </td>
                                    <td>
                                        <input disabled value="{{ $tablet->asset_brand }}" class="form-control arf-form-control arf-form-control-section-2" type="text" />
                                    </td>
                                    <td>
                                        <input disabled value="{{ $tablet->date_issued }}" class="form-control arf-form-control arf-form-control-section-2" type="text" />
                                    </td>
                                    <td>
                                        <input disabled value="{{ $tablet->remarks }}" class="form-control arf-form-control arf-form-control-section-2" type="text" />
                                    </td>
                                    <td class="text-truncate">{{ $tablet->status }}</td>
                                    <td class="remove-asset">
                                        <i class="fa fa-close"></i>
                                    </td>
                                </tr>
                                @endforeach
                                @endif

                                @if( count($arf->sims) > 0 )
                                @foreach( $arf->sims as $k=>$sim )
                                <tr>
                                    <td>3x{{ ++$k }}</td>
                                    <td class="arf-heading-md">sim</td>
                                    <td>
                                        <input disabled value="{{ $sim->asset_code }}" class="form-control arf-form-control arf-form-control-section-2" type="text" />
                                    </td>
                                    <td>
                                        <input disabled value="{{ $sim->asset_brand }}" class="form-control arf-form-control arf-form-control-section-2" type="text" />
                                    </td>
                                    <td>
                                        <input disabled value="{{ $sim->date_issued }}" class="form-control arf-form-control arf-form-control-section-2" type="date" />
                                    </td>
                                    <td>
                                        <input disabled value="{{ $sim->remarks }}" class="form-control arf-form-control arf-form-control-section-2" type="text" />
                                    </td>
                                    <td>{{ $sim->status }}</td>
                                    <td class="remove-asset">
                                        <i class="fa fa-close"></i>
                                    </td>
                                </tr>
                                @endforeach
                                @endif

                                @if( isset($arf->desktops) && count($arf->desktops) > 0 )
                                @foreach($arf->desktops as $k=>$desktop)
                                <tr>
                                    <td>4x{{ ++$k }}</td>
                                    <td class="arf-heading-md">desktop</td>
                                    <td>
                                        <input disabled value="{{ $desktop->asset_code }}" class="form-control arf-form-control arf-form-control-section-2" type="text" />
                                    </td>
                                    <td>
                                        <input disabled value="{{ $desktop->asset_brand }}" class="form-control arf-form-control arf-form-control-section-2" type="text" />
                                    </td>
                                    <td>
                                        <input disabled value="{{ $desktop->date_issued }}" class="form-control arf-form-control arf-form-control-section-2" type="date" />
                                    </td>
                                    <td>
                                        <input disabled value="{{ $desktop->remarks }}" class="form-control arf-form-control arf-form-control-section-2" type="text" />
                                    </td>
                                    <td>
                                        {{ $desktop->status }}
                                    </td>
                                    <td class="remove-asset">
                                        <i class="fa fa-close"></i>
                                    </td>
                                </tr>
                                @endforeach
                                @endif

                                @if( count($arf->monitors) > 0 )
                                @foreach($arf->monitors as $k=>$monitor)
                                <tr>
                                    <td>5x{{ ++$k }}</td>
                                    <td class="arf-heading-md">monitor</td>
                                    <td>
                                        <input disabled value="{{ $monitor->asset_code }}" class="form-control arf-form-control arf-form-control-section-2" type="text" />
                                    </td>
                                    <td>
                                        <input disabled value="{{ $monitor->asset_brand }}" class="form-control arf-form-control arf-form-control-section-2" type="text" />
                                    </td>
                                    <td>
                                        <input disabled value="{{ $monitor->date_issued  }}" class="form-control arf-form-control arf-form-control-section-2" type="date" />
                                    </td>
                                    <td>
                                        <input disabled value="{{ $monitor->remarks }}" class="form-control arf-form-control arf-form-control-section-2" type="text" />
                                    </td>
                                    <td>
                                        {{ $monitor->status }}
                                    </td>
                                    <td class="remove-asset">
                                        <i class="fa fa-close"></i>
                                    </td>
                                </tr>
                                @endforeach
                                @endif

                                @if( isset($arf->mobiles) && count($arf->mobiles) > 0 )
                                @foreach($arf->mobiles as $k=>$mobile)
                                <tr>
                                    <td>6x{{ ++$k }}</td>
                                    <td class="arf-heading-md">mobile</td>
                                    <td>
                                        <input disabled value="{{ $mobile->asset_code }}" class="form-control arf-form-control arf-form-control-section-2" type="text" name="arf_mobile_asset_code" />
                                    </td>
                                    <td>
                                        <input disabled value="{{ $mobile->asset_bramd }}" class="form-control arf-form-control arf-form-control-section-2" type="text" name="arf_mobile_brand" />
                                    </td>
                                    <td>
                                        <input disabled value="{{ $mobile->date_issued }}" class="form-control arf-form-control arf-form-control-section-2" type="date" name="arf_mobile_date_issued" />
                                    </td>
                                    <td>
                                        <input disabled value="{{ $mobile->remarks }}" class="form-control arf-form-control arf-form-control-section-2" type="text" name="arf_mobile_remarks" />
                                    </td>
                                    <td>
                                        {{ $mobile->status }}
                                    </td>
                                    <td class="text-center text-danger cursor-pointer">
                                        <i class="fa fa-close"></i>
                                    </td>
                                </tr>
                                @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>

                    <!-- Section 4 -->
                    <div id="arf-section-4" class="text-center">
                        <div>
                            I <span id="signature-name"><strong><u>{{ $arf->name }}</u></strong></span> hereby acknowledge that I have received the above mentioned Asset / Assets.
                            I understand that these assets belong to AZIZI Developments and it's under my possession for carrying out my office work. I hereby assure you that I will take care of above Assets of the company to my best possible extent.
                        </div>
                        <div class="text-right d-flex align-items-center justify-content-end mt-3">
                            <div class="arf-heading-md">Employee Response</div>
                            <div class="mx-2">
                                <h2><span class="badge bg-primary badge-lg">{{ $arf->status }}</span></h2>
                            </div>
                        </div>
                    </div>

                    <!-- Section 5 -->
                    <div id="arf-section-5" class="text-center">
                        <strong>For HR Purpose:</strong> Any above Asset / Assets Lost or Damaged or Not Return to AZIZI at the time of end of service,
                        <strong>HR DEPARTMENT</strong> will deduct the value of above assets from final salary.
                    </div>

                    <div class="text-center mt-4">
                        <span>Registered Office: </span> PO Box 121385 Conrad, Dubai, United Arab Emirates
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" tabindex="-1" id="asset-remove-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Remove an Asset</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div>
            <p>Remove the Selected Asset from User name?</p>
          </div>
          <div class="mt-4 d-flex justify-content-end">
            <button type="button" class="btn btn-primary mx-1" id="btnSearch">Search <i class="fa fa-search"></i></button>
            <button disabled type="button" class="btn btn-success" id="btnInsert">Insert <i class="fa fa-check"></i></button>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection