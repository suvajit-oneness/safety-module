@extends('layouts.app')

@section('template_title')
    Incident report
@endsection

@section('partials_css')
	<link href="/css/custom/riskMatrixModal.css" rel="stylesheet">
@endsection

@section('template_linked_css')
    {{-- Bootstrap
    ======================== --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   {{-- <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous"> -->--}}


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/roundSlider/1.3.2/roundslider.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    {{-- Degree Picker css
    ============================= --}}
    <link rel="stylesheet" href="{{ asset('css/degreePicker/degree_picker.css') }}">

    {{-- Clock Picker
    ============================= --}}
    <link rel="stylesheet" href="{{ asset('css/ClockPicker/bootstrap-clockpicker.min.css') }}">

    {{-- Custom Css
    ======================= --}}
    <link rel="stylesheet" type="text/css" href="/css/custom/incidentReporting/create.css">


    {{-- Multi-step Style
    ======================= --}}
    <link rel="stylesheet" type="text/css" href="/css/multiStep/style.css">

    <link rel="stylesheet" href="/css/jquery/jquery.lcnCircleRangeSelect.css">

    {{-- DrawerJs
    ======================= --}}
        <link rel="stylesheet" href="/js/custom/incidentReporting/font-awesome.min.css" />
        <link rel="stylesheet" href="/js/custom/incidentReporting/drawerJs.min.css" />


    <style>
        .delete{
            display: none !important;
        }
    </style>
@endsection

@section('partial_scripts')

	<script src="{{ asset('js/jquery/jquery-ui.js') }}"></script>
	<script type="text/javascript" src="\js\custom\riskMatrixModal.js"></script>
@endsection


@section('content')
    <div class="container mb-3 ">
        <div class="row">
        <div class="col-12">
            <a href="/incident-reporting">
             <button type="button" class="btn btn-dark"><i class="fa fa-long-arrow-left" aria-hidden="true" style="color:white;"></i></button>
            </a>
        </div>
        </div>
    </div>
    <div class="container">
        @if(isset($report_details) && $report_details != '')
            @if ($report_details->saved_status == 'temporary')
                {{-- <h4 style="color:red;display:block;">Please fill the form completely</h4> --}}
                <input hidden id="report_id" value="{{$report_details->id}}">
                <input hidden id="user_id" value="{{Auth::user()->id}}">
                <input hidden id="saved_status" value="{{$report_details->saved_status}}">
            @else
                {{-- <h4 style="color:red;display:none;">Please fill the form completely</h4> --}}
                <input hidden id="report_id" value="{{$report_details->id}}">
                <input hidden id="user_id" value="{{Auth::user()->id}}">
                <input hidden id="saved_status" value="">
            @endif
        @else
            <input hidden id="report_id" value="">
            <input hidden id="user_id" value="{{Auth::user()->id}}">
            <input hidden id="saved_status" value="">
        @endif
        <div class=" ">
            <div class="card shadow  p-3 py-5" id="slide_div">
                <!-- Html
                ================== -->
                {{-- div for centering the form --}}
                    <div class="mx-md-5 ">
                        <form class="p-md-3 mx-md-5 " method="POST"  @if(@isset($data_id)) action="{{ url('/incident-reporting/update/'.$data_id) }}" @else action="{{ url('/incident-reporting/store') }}" @endif id="near_miss_form" enctype="multipart/form-data" files="true">
                            @csrf
                            <input type="hidden" id = "id" name = "id" value = {{ $incident_report->id }}>
                            <!-- Circles which indicates the steps of the form: -->
                            {{--  if input fields are increased then have to increse the span  --}}

                            <div style="text-align:center;margin-top:40px; display: block;">
                                <span class="step"></span>
                                <span class="step"></span>
                                <span class="step"></span>
                                <span class="step"></span>
                                <span class="step"></span>
                                <span class="step"></span>
                                <span class="step"></span>
                                <span class="step"></span>
                                @if($is_edit) <span class="step"></span>   @endif
                                 {{--  <span class="step"></span>  --}}
                                <!--<span class="step"></span> -->
                                {{-- <span class="step"></span>
                                <span class="step"></span> --}}
                            </div>

                            <h2 class="my-3 font-weight-light text-center">Incident Reporting</h2>

                            {{--  Investigation matrix
                            ========================  --}}
                            <div class="tab form-group">
                                <h5 class="text-center my-3 ">Investigation matrix</h5>
                                <div class="form-row mb-3">
                                    {{-- select first parameter  --}}
                                    <div class="form-group col-md-5 col-lg-5">
                                        <label for="First_Parameter">First Parameter</label>
                                        <!-- <select class="form-control" id="First_Parameter" name="investigation_matrix_fst">
                                            <option selected disabled hidden>Select First Parameter</option>
                                            <option value="1">Slight</option>
                                            <option value="2">Minor</option>
                                            <option value="3"> Medium</option>
                                            <option value="4">Major</option>
                                            <option value="5">Extreme</option>

                                        </select> -->
                                        <select class="form-control" id="First_Parameter" name="investigation_matrix_fst">

                                            @if (@isset($incident_report) && $incident_report->investigation_matrix_fst && $incident_report->investigation_matrix_fst == '1')
                                            <option selected value="1">Slight</option>
                                            @elseif(@isset($incident_report) && ($incident_report->investigation_matrix_fst && $incident_report->investigation_matrix_fst == '2'))
                                            <option selected value="2">Minor</option>
                                            @elseif(@isset($incident_report) && ($incident_report->investigation_matrix_fst && $incident_report->investigation_matrix_fst == '3'))
                                            <option value="3"> Medium</option>
                                            @elseif(@isset($incident_report) && ($incident_report->investigation_matrix_fst && $incident_report->investigation_matrix_fst == '4'))
                                            <option value="4">Major</option>
                                            @elseif(@isset($incident_report) &&($incident_report->investigation_matrix_fst && $incident_report->investigation_matrix_fst == '5'))
                                            <option value="5">Extreme</option>
                                            @else
                                            <option selected disabled hidden>Select First Parameter</option>
                                            @endif
                                            <option value="1">Slight</option>
                                            <option value="2">Minor</option>
                                            <option value="3"> Medium</option>
                                            <option value="4">Major</option>
                                            <option value="5">Extreme</option>
                                        </select>
                                    </div>
                                    {{-- select second parameter  --}}
                                    <div class="form-group col-md-5 col-lg-5">
                                        <!-- <label for="Second_Parameter">Second Parameter</label>
                                        <select class="form-control" id="Second_Parameter" name="investigation_matrix_scnd">
                                            <option selected disabled hidden>Select Second Parameter</option>
                                            <option value="1">Safety</option>
                                            <option value="2">Health</option>
                                            <option value="3">Environment</option>
                                            <option value="4">Process Loss / Failure</option>
                                            <option value="5">Asset / Property Damage</option>
                                            <option value="6">Media Coverage / Public Attention</option>
                                        </select> -->
                                        <label for="Second_Parameter">Second Parameter</label>
                                        <select class="form-control" id="Second_Parameter" name="investigation_matrix_scnd">
                                            @if (@isset($incident_report->investigation_matrix_scnd) && $incident_report->investigation_matrix_scnd == '1')
                                            <option value="1">Safety</option>
                                            @elseif(@isset($incident_report) && ($incident_report->investigation_matrix_scnd && $incident_report->investigation_matrix_scnd == '2'))
                                            <option value="2">Health</option>
                                            @elseif(@isset($incident_report->investigation_matrix_scnd) && ($incident_report->investigation_matrix_scnd && $incident_report->investigation_matrix_scnd == '3'))
                                            <option value="3">Environment</option>
                                            @elseif(@isset($incident_report) && ($incident_report->investigation_matrix_scnd && $incident_report->investigation_matrix_scnd == '4'))
                                            <option value="4">Process Loss / Failure</option>
                                            @elseif(@isset($incident_report) && ($incident_report->investigation_matrix_scnd && $incident_report->investigation_matrix_scnd == '5'))
                                            <option value="5">Asset / Property Damage</option>
                                            @elseif(@isset($incident_report) && ($incident_report->investigation_matrix_scnd && $incident_report->investigation_matrix_scnd == '6'))
                                            <option value="6">Media Coverage / Public Attention</option>
                                            @else
                                            <option selected disabled hidden>Select Second Parameter</option>
                                            @endif

                                            <option value="1">Safety</option>
                                            <option value="2">Health</option>
                                            <option value="3">Environment</option>
                                            <option value="4">Process Loss / Failure</option>
                                            <option value="5">Asset / Property Damage</option>
                                            <option value="6">Media Coverage / Public Attention</option>
                                        </select>
                                    </div>
                                    {{-- view whole matrix table  --}}
                                    <div class="form-group col-md-2 col-lg-2">
                                        <label for="matrixBtn"></label>
                                        <button type="button" id="matrixBtn" class="btn btn-primary w-100 ml-auto" data-toggle="modal" data-target="#view_matrix">View Matrix</button>
                                        <div class="modal fade" style="scroll:auto" id="view_matrix" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-xl"  role="document">
                                                <div class="modal-content">
                                                    {{-- <div class="modal-header">
                                                        <h2 class="modal-title font-weight-bold" id="exampleModalLongTitle">Incident Details</h2> <h5>Report Id : 3 </h5>
                                                    </div> --}}
                                                    <div class="modal-body text-left">
                                                        {{-- <img src="{{asset('images/risk_investigation.svg')}}" alt="investigation-matrix" width="100%" height="auto"/> --}}
                                                        <table border="1" class='table-responsive'>
                                                            <tbody >
                                                               <tr>
                                                                  <td colspan="7">INCIDENT CLASSIFICATION MATRIX</td>
                                                                  {{-- <td></td>
                                                                  <td></td>
                                                                  <td></td>
                                                                  <td></td>
                                                                  <td></td>
                                                                  <td></td> --}}
                                                                  <td colspan="2">Investigation Standards</td>
                                                                  {{-- <td></td> --}}
                                                               </tr>
                                                                <tr>
                                                                    <td>&nbsp;</td>
                                                                    <td>&nbsp;Safety</td>
                                                                    <td>&nbsp;Health</td>
                                                                    <td>&nbsp;Environment</td>
                                                                    <td>&nbsp;Process Loss/Failure</td>
                                                                    <td>Asset/Property Damage</td>
                                                                    <td>&nbsp;Media Coverage / Public Attention</td>
                                                                    <td>&nbsp;Investigation Level</td>
                                                                    <td>Close-Out Authority</td>
                                                                </tr>


                                                                <tr>
                                                                  <td style="padding:10px; color:white; background-color: #cc0202da">5 {{$extreme[0]->classification}}</td>
                                                                  <td style="padding:10px; color:white; background-color: #cc0202da">&nbsp;{{$extreme[0]->Safety}}</td>
                                                                  <td style="padding:10px; color:white; background-color: #cc0202da">&nbsp;{{$extreme[0]->Health}}</td>
                                                                  <td style="padding:10px; color:white; background-color: #cc0202da">
                                                                     <p>&nbsp;{{$extreme[0]->Environment}}<br /><br /></p>

                                                                  </td>
                                                                  <td style="padding:10px; color:white; background-color: #cc0202da">&nbsp;{{$extreme[0]->Process_Loss}}</td>
                                                                  <td style="padding:10px; color:white; background-color: #cc0202da">&nbsp;{{$extreme[0]->Property_Damage}}</td>
                                                                  <td style="padding:10px; color:white; background-color: #cc0202da">&nbsp;{{$extreme[0]->Media_Coverage}}</td>
                                                                  <td style="padding:10px; color:black; background-color: #afaaaada" rowspan="2">&nbsp;{{$extreme[0]->Investigation_Level}}</td>
                                                                  <td style="padding:10px; color:black; background-color: #afaaaada" rowspan="2">&nbsp;{{$extreme[0]->Authority}}</td>
                                                               </tr>

                                                               <tr>
                                                                  <td style="padding:10px; color:white; background-color: #d87d05">&nbsp;4 {{$major[0]->classification}}</td>
                                                                  <td style="padding:10px; color:white; background-color: #d87d05">&nbsp; {{$major[0]->Safety}}</td>
                                                                  <td style="padding:10px; color:white; background-color: #d87d05">&nbsp; {{$major[0]->Health}}</td>
                                                                  <td style="padding:10px; color:white; background-color: #d87d05">
                                                                     <p>&nbsp;{{$major[0]->Environment}}</p>

                                                                  </td>
                                                                  <td style="padding:10px; color:white; background-color: #d87d05">
                                                                     <p>&nbsp;{{$major[0]->Process_Loss}}</p>

                                                                  </td>
                                                                  <td style="padding:10px; color:white; background-color: #d87d05">&nbsp;{{$major[0]->Property_Damage}}</td>
                                                                  <td style="padding:10px; color:white; background-color: #d87d05">&nbsp;{{$major[0]->Media_Coverage}}</td>
                                                               </tr>

                                                               <tr>
                                                                  <td style="padding:10px; color:black; background-color: orange">&nbsp;3{{$medium[0]->classification}}</td>
                                                                  <td style="padding:10px; color:black; background-color: orange">&nbsp;{{$medium[0]->Safety}}</td>
                                                                  <td style="padding:10px; color:black; background-color: orange">&nbsp;{{$medium[0]->Health}}</td>
                                                                  <td style="padding:10px; color:black; background-color: orange">
                                                                     <p>&nbsp;{{$medium[0]->Environment}}</p>

                                                                  </td>
                                                                  <td style="padding:10px; color:black; background-color: orange">
                                                                     <p>&nbsp;{{$medium[0]->Process_Loss}}</p>

                                                                  </td>
                                                                  <td style="padding:10px; color:black; background-color: orange">&nbsp;{{$medium[0]->Property_Damage}} </td>
                                                                  <td style="padding:10px; color:black; background-color: orange">&nbsp;{{$medium[0]->Media_Coverage}}</td>
                                                                  <td rowspan="3" style="padding:10px; color:black; background-color: #afaaaada">&nbsp;{{$medium[0]->Investigation_Level}}</td>
                                                                  <td rowspan="2" style="padding:10px; color:black; background-color: #afaaaada">&nbsp;{{$medium[0]->Authority}}</td>
                                                               </tr>

                                                               <tr>
                                                                  <td style="padding:10px; color:black; background-color: #e0ca05">&nbsp;2{{$minor[0]->classification}}</td>
                                                                  <td style="padding:10px; color:black; background-color: #e0ca05">&nbsp;{{$minor[0]->Safety}}</td>
                                                                  <td style="padding:10px; color:black; background-color: #e0ca05">&nbsp;{{$minor[0]->Health}}</td>
                                                                  <td style="padding:10px; color:black; background-color: #e0ca05">
                                                                     <p>&nbsp;{{$slight[0]->Environment}}</p>

                                                                  </td>
                                                                  <td style="padding:10px; color:black; background-color: #e0ca05">&nbsp;{{$minor[0]->Process_Loss}}</td>
                                                                  <td style="padding:10px; color:black; background-color: #e0ca05">&nbsp;{{$minor[0]->Property_Damage}}</td>
                                                                  <td style="padding:10px; color:black; background-color: #e0ca05">&nbsp;{{$minor[0]->Media_Coverage}}</td>
                                                               </tr>
                                                               <tr>
                                                                  <td style="padding:10px; color:black; background-color: #e0ca05">&nbsp;1 {{$slight[0]->classification}}</td>
                                                                  <td style="padding:10px; color:black; background-color: #e0ca05">&nbsp;{{$slight[0]->Safety}}</td>
                                                                  <td style="padding:10px; color:black; background-color: #e0ca05">&nbsp;{{$slight[0]->Health}}</td>
                                                                  <td style="padding:10px; color:black; background-color: #e0ca05">
                                                                     <p>&nbsp;{{$slight[0]->Environment}} </p>


                                                                  </td>
                                                                  <td style="padding:10px; color:black; background-color: #e0ca05">&nbsp;{{$slight[0]->Process_Loss}}</td>
                                                                  <td style="padding:10px; color:black; background-color: #e0ca05">&nbsp;{{$slight[0]->Property_Damage}}</td>
                                                                  <td style="padding:10px; color:black; background-color: #e0ca05">&nbsp;{{$slight[0]->Media_Coverage}}</td>
                                                                  <td style="padding:10px; color:black; background-color: #afaaaada">&nbsp;{{$slight[0]->Authority}}</td>
                                                               </tr>
                                                            </tbody>
                                                        </table>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-times-circle mr-1"></i>Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                {{-- text area  --}}
                                <div class="form-row">
                                    <p class="err-text-msg" id="err-text-msg" style="display: none; color:red;">Please select another parameter</p>
                                    <div id="investigation_result" class="form-group col-12 p-5" style="background: #ffff;border-radius: 10px; display:none;
                                    border: 1px solid #696969;">
                                        <h5 style="text-align:center">Investigation Level</h5>
                                        <p id="data_investigation_level" style="text-align:center"></p>
                                        <h5 style="text-align:center">Close-Out Authority</h5>
                                        <p id="data_authority" style="text-align:center"></p>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label for="Class_Society">Incident header </label>
                                    <input type="text" class="form-control" id="Incident_header" name="Incident_header" placeholder="Incident header..." autocomplete="off"
                                @if(@isset($incident_report->incident_header) && $incident_report->incident_header) value="{{$incident_report->incident_header}}" @else value="" @endif>
                                </div>
                                {{-- Buttons(next/prev) --}}
                                <div class="mr-auto ml-auto" >
                                    <div class="d-flex">
                                        <button class="btn btn-info mt-5 w-25 mr-auto" type="button" id="prevBtn"  onclick="nextPrev(-1)">Previous </button>
                                        <button class="btn btn-info mt-5 w-25 ml-auto investigation_tab" type="button" style="display:none;" id="nextBtn" name = "step1" onclick="nextPrev(1)">Next </button>
                                    </div>
                                </div>
                            </div>



                            {{--  Enter Heading
                            ========================  --}}
                            {{-- <div class="tab form-group">
                                <label for="Class_Society">Incident header </label>
                                <input type="text"   class="form-control" id="Incident_header" name="Incident_header" placeholder="Incident header..." autocomplete="off"> --}}
                                {{-- Buttons(next/prev) --}}
                                {{-- <div class="mr-auto ml-auto" >
                                    <div class="d-flex">
                                        <button class="btn btn-info mt-5 w-25 mr-auto" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous </button>
                                        <button class="btn btn-info mt-5 w-25 ml-auto incident_header" type="button" id="nextBtn"  onclick="nextPrev(1)">Next </button>
                                    </div>
                                </div> --}}
                            {{-- </div> --}}



                            {{--  (Incident Header) first step of form
                            ============================================================================  --}}
                            <div class="tab form-group">
                                    <h5 class="text-center my-3" id="header_Txt"></h5>

                                    {{-- Vessel Name And Confidential --}}
                                    <div class="form-row">
                                        {{-- name --}}
                                        <div class="form-group col-md-6">

                                            @if(session('is_ship'))
                                                <label for="Vessel_Name">Vessel Name</label>
                                                {{--  <input @if (@isset($vessel_name))
                                                value="{{$vessel_name}}"
                                                @else
                                                value=""
                                                @endif
                                                type="text" class="form-control" id="Vessel_Name" name="Vessel_Name" placeholder="Vessel Name...">
                                              --}}

                                                <input value="{{$ship_name}}" type="text" readonly class="form-control" id="Vessel_Name" name="Vessel_Name" placeholder="Vessel Name...">

                                            @else
                                                <input type="hidden" name="Vessel_Name" value="NULL" >
                                            @endif
                                        </div>
                                        {{-- confidential --}}
                                        <div class="form-group col-md-6">
                                            <label for="Confidential">Confidential</label>
                                            <select class="form-control" id="Confidential" name="Confidential">

                                            @if (isset($incident_report->confidential) && $incident_report->confidential)
                                            <option selected hidden value="{{$incident_report->confidential}}" >{{$incident_report->confidential}}</option>
                                            @else
                                            <option selected hidden value="" > </option>
                                            @endif


                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                        </div>
                                    </div>

                                    {{-- Report_number And Media_involved --}}
                                    <div class="form-row">
                                        {{-- report number --}}
                                        @if(isset($incident_report))
                                        <div class="form-group col-md-6" style="display: none">
                                            <label for="Report_number">Report Number</label>
                                            <input style="pointer-events: none;"
                                        @if (isset($incident_report->report_no) && $incident_report->report_no)
                                        value="{{$incident_report->report_no}}"
                                        @else
                                        value=""
                                        @endif

                                        type="text" class="form-control" hidden id="Report_number" name="Report_number" placeholder="Report Number..." >
                                        </div>
                                        @endif
                                        {{-- media involved --}}
                                        <div class="form-group col-md-6">
                                            <label for="Confidential">Media Involved</label>
                                            <!-- <select class="form-control" id="media_involved" name="media_involved">
                                                <option selected disabled hidden>Media Involved</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select> -->
                                            <select class="form-control" id="media_involved" name="media_involved">

                                            @if (isset($incident_report->media_involved) && $incident_report->media_involved)
                                            <option selected  hidden value="{{$incident_report->media_involved}}"  >{{$incident_report->media_involved}}</option>
                                            @else
                                            <option selected  hidden value="" >@if(isset($incident_report)){{$incident_report->media_involved}}@endif</option>
                                            @endif

                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                        </div>
                                    </div>

                                    {{-- Created_By --}}

                                    <div class="form-row">
                                    <div class="form-group col-md-6">

                                        <label for="Created_By_Name">Created By (Name)</label>
                                        <!-- <input type="text" class="form-control" id="Created_By_Name" name="Created_By_Name" placeholder="Name..."> -->
                                        <input type="text"
                                        @if (isset($incident_report->created_by_name) && $incident_report->created_by_name)
                                        value="{{$incident_report->created_by_name}}"
                                        @else
                                        value=""
                                        @endif
                                        class="form-control" id="Created_By_Name" name="Created_By_Name" placeholder="Name...">
                                        <input type="text" id="Created_By" name="Created_By" value="1" hidden>

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Created_By_Rank">Created By (Rank)</label>
                                        <!-- <input type="text" class="form-control" id="Created_By_Rank" name="Created_By_Rank" placeholder="Rank..."> -->
                                        <input type="text"
                                        @if (isset($incident_report->created_by_rank) && $incident_report->created_by_rank)
                                        value="{{$incident_report->created_by_rank}}"
                                        @else
                                        value=""
                                        @endif
                                        class="form-control" id="Created_By_Rank" name="Created_By_Rank" placeholder="Rank...">

                                    </div>
                                    </div>

                                    {{-- Date_of_incident And Time_of_incident --}}
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="Report_number">Date of incident</label>
                                            <!-- <input type="text" class="form-control date" id="Date_of_incident" name="Date_of_incident" placeholder="Date of incident..."> -->
                                            <input type="text"
                                                @if (isset($incident_report->date_of_incident) && $incident_report->date_of_incident)
                                                value="{{$incident_report->date_of_incident}}"
                                                @else
                                                value=""
                                                @endif

                                                class="form-control date" id="Date_of_incident" name="Date_of_incident" placeholder="Date of incident...">
                                        </div>

                                        <div class="form-group col-md-6 clockpicker">
                                            <label for="Confidential">Time of incident</label>
                                            <!-- <input type="text" class="form-control" id="Time_of_incident" name="Time_of_incident" placeholder="Time of incident..."> -->
                                            <input type="text"
                                            @if (isset($incident_report->time_of_incident_lt) && $incident_report->time_of_incident_lt)
                                             value="{{$incident_report->time_of_incident_lt}}"
                                             @else
                                             value=""
                                            @endif

                                            class="form-control" id="Time_of_incident" name="Time_of_incident" placeholder="Time of incident...">
                                        </div>
                                    </div>

                                    {{-- Date_report_created And GMT --}}
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="Report_number">Date report created</label>
                                            <!-- <input type="text" class="form-control date" id="Date_report_created" name="Date_report_created" placeholder="Date report created..."> -->
                                            <input type="text"
                                        @if (isset($incident_report->date_report_created) && $incident_report->date_report_created)
                                        value="{{$incident_report->date_report_created}}"
                                        @else
                                        value=""
                                        @endif

                                        class="form-control date" id="Date_report_created" name="Date_report_created" placeholder="Date report created...">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Confidential">GMT</label>
                                            <select class="form-control" id="GMT" name="GMT">
                                                <option value = "">Select GMT</option>
                                                
                                                @foreach(config('constants.GMT_VALUES') as  $gmtvalue)
                                                    @if (isset($incident_report->time_of_incident_gmt) && $incident_report->time_of_incident_gmt && $incident_report->time_of_incident_gmt== $gmtvalue )
                                                        <option value="{{$gmtvalue}}" selected>
                                                            {{$gmtvalue}}
                                                        </option>                                               
                                                    @else
                                                        <option value="{{$gmtvalue}}">
                                                            {{$gmtvalue}}
                                                        </option>
                                                    @endif                                                    
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>

                                    {{-- Voy_No --}}
                                    <div class="form-group">
                                        <label for="Voy_No">Voy No</label>
                                        <!-- <input type="text" class="form-control" name="Voy_No" id="Voy_No" placeholder="Voy No..."> -->
                                        <input type="text" class="form-control" name="Voy_No" id="Voy_No" placeholder="Voy No..."
                                    @if (isset($incident_report->voy_no) && $incident_report->voy_no)
                                    value="{{$incident_report->voy_no}}"
                                    @else
                                    value=""
                                    @endif
                                    >
                                    </div>

                                    {{-- Master And Chief officer --}}
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="Report_number">Master</label>
                                            <select class="form-control" id="Master" name="Master">
                                                <option disabled selected hidden>--Select--</option>
                                                @foreach ( $crew_list as $c )
                                                    <option @if(isset($incident_report->master) &&  $c->id == $incident_report->master) selected  @endif value="{{$c->id}}">{{$c->name}}</option>
                                                @endforeach
                                        </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Confidential">Chief officer</label>
                                            <!-- <select class="form-control" id="Chief_officer" name="Chief_officer">
                                                <option selected disabled hidden>Chief officer</option>
                                                @foreach ( $crew_list as $c )
                                                    <option value="{{$c->id}}">{{ $c->name }}</option>
                                                @endforeach
                                            </select> -->

                                            <select class="form-control" id="Chief_officer" name="Chief_officer">
                                                <option disabled selected hidden>--Select--</option>
                                            @foreach ( $crew_list as $c )
                                                <option @if(isset($incident_report->chief_officer) &&  $c->id == $incident_report->chief_officer) selected  @endif value="{{$c->id}}">{{$c->name}}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>

                                    {{-- Chief_Engineer And 1st Eng. --}}
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="Confidential">Chief Engineer</label>
                                            <!-- <select class="form-control" id="Chief_Engineer" name="Chief_Engineer">
                                                <option selected disabled hidden>Chief Engineer</option>
                                                @foreach ( $crew_list as $c )
                                                    <option value="{{$c->id}}">{{ $c->name }}</option>
                                                @endforeach
                                            </select> -->
                                            <select class="form-control" id="Chief_Engineer" name="Chief_Engineer">
                                            <option selected disabled hidden>Chief Engineer</option>
                                            @foreach ( $crew_list as $c )
                                                @if (isset($incident_report) && $c->id == $incident_report->chief_engineer)

                                                    @if (isset($incident_report->chief_engineer) && $incident_report->chief_engineer)
                                                    <option selected  hidden value="{{$incident_report->chief_engineer}}">{{$c->name}}</option>
                                                    @else
                                                    <option selected  hidden value=""></option>
                                                    @endif

                                                @endif

                                                @if (isset($c->id) && $c->id)
                                                <option value="{{$c->id}}" >{{ $c->name }}</option>
                                                @else
                                                <option value="" >{{ $c->name }}</option>
                                                @endif

                                            @endforeach
                                        </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="fstEng">1st Eng.</label>
                                            <!-- <select class="form-control" id="fstEng" name="fstEng">
                                                <option selected disabled hidden>1st Eng</option>
                                                @foreach ( $crew_list as $c )
                                                    <option value="{{$c->id}}">{{ $c->name }}</option>
                                                @endforeach
                                            </select> -->
                                            <select class="form-control" id="fstEng" name="fstEng">
                                            <option selected disabled hidden>1st Eng</option>
                                            @foreach ( $crew_list as $c )
                                                @if (@isset($incident_report) && $c->id == $incident_report->first_engineer)

                                                    @if (isset($incident_report->first_engineer) && $incident_report->first_engineer)
                                                    <option selected  hidden value="{{$incident_report->first_engineer}}">{{$c->name}}</option>
                                                    @else
                                                    <option selected  hidden value="" ></option>
                                                    @endif

                                                @endif

                                                @if (isset($c->id) && $c->id)
                                                <option value="{{$c->id}}" >{{ $c->name }}</option>
                                                @else
                                                <option value="" ></option>
                                                @endif

                                            @endforeach
                                        </select>
                                        </div>
                                    </div>

                                    {{-- Charterer --}}
                                    <div class="form-group">
                                        <label for="Voy_No">Charterer</label>
                                        <!-- <textarea type="text" class="form-control" name="Charterer" id="Charterer" placeholder="Charterer..."> </textarea> -->
                                        @if (@isset($incident_report) && $incident_report->charterer)
                                            <textarea type="text" class="form-control" name="Charterer" id="Charterer" placeholder="Charterer..."> {{$incident_report->charterer}}</textarea>
                                        @else
                                            <textarea type="text" class="form-control" name="Charterer" id="Charterer" placeholder="Charterer..."> </textarea>
                                        @endif
                                    </div>

                                    {{-- Agent (if any) --}}
                                    <div class="form-group">
                                        <label for="Voy_No">Agent (if any)</label>
                                        <!-- <textarea type="text" class="form-control" name="Agent" id="Agent" placeholder="Agent (if any)..."> </textarea> -->
                                        @if (@isset($incident_report) && $incident_report->agent)
                                            <textarea type="text" class="form-control" name="Agent" id="Agent" placeholder="Agent (if any)...">{{$incident_report->agent}} </textarea>
                                        @else
                                            <textarea type="text" class="form-control" name="Agent" id="Agent" placeholder="Agent (if any)..."> </textarea>
                                        @endif
                                    </div>



                                    {{-- Vessel_Damage , Cargo_damage And Third_Party_Liability --}}
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="Vessel Damage">Vessel Damage</label>
                                            <!-- <select class="form-control" id="Vessel_Damage" name="Vessel_Damage">
                                                <option selected disabled hidden>Vessel Damage</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select> -->
                                            <select class="form-control" id="Vessel_Damage" name="Vessel_Damage">

                                                @if (isset($incident_report->vessel_damage) && $incident_report->vessel_damage)
                                                    <option selected  hidden value="{{$incident_report->vessel_damage}}" >{{$incident_report->vessel_damage}}</option>
                                                @else
                                                    <option selected  hidden value=""  ></option>
                                                @endif

                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="Cargo_damage">Cargo Damage</label>
                                            <!-- <select class="form-control" id="Cargo_damage" name="Cargo_damage">
                                                <option selected disabled hidden>Cargo damage</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select> -->
                                            <select class="form-control" id="Cargo_damage" name="Cargo_damage">

                                            @if (isset($incident_report->cargo_damage) && $incident_report->cargo_damage)
                                                <option selected  hidden value="{{$incident_report->cargo_damage}}" >{{$incident_report->cargo_damage}}</option>
                                            @else
                                                <option selected  hidden value="" ></option>
                                            @endif

                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="Third_Party_Liability">Third Party Liability</label>
                                            <!-- <select class="form-control" id="Third_Party_Liability" name="Third_Party_Liability">
                                                <option selected disabled hidden>Third Party Liability</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select> -->
                                            <select class="form-control" id="Third_Party_Liability" name="Third_Party_Liability">

                                            @if (isset($incident_report->third_party_liability) && $incident_report->third_party_liability)
                                            <option selected  hidden value="{{$incident_report->third_party_liability}}">{{$incident_report->third_party_liability}}</option>
                                            @else
                                            <option selected  hidden value="" ></option>
                                            @endif

                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                        </div>
                                    </div>

                                    {{-- Environmental And Commercial/Service --}}
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="Confidential">Environmental</label>
                                            <!-- <select class="form-control" id="Environmental" name="Environmental">
                                                <option selected disabled hidden>Environmental</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select> -->
                                            <select class="form-control" id="Environmental" name="Environmental">

                                            @if (isset($incident_report->environmental) && $incident_report->environmental)
                                            <option selected  hidden value="{{$incident_report->environmental}}" >{{$incident_report->environmental}}</option>
                                            @else
                                            <option selected  hidden value=""  ></option>
                                            @endif

                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Commercial_Service">Commercial/Service affected</label>
                                            <!-- <select class="form-control" id="Commercial_Service" name="Commercial_Service">
                                                <option selected disabled hidden>Commercial/Service affected</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select> -->
                                            <select class="form-control" id="Commercial_Service" name="Commercial_Service">

                                            @if (isset($incident_report->commercial) && $incident_report->commercial)
                                            <option selected  hidden value="{{$incident_report->commercial}}">{{$incident_report->commercial}}</option>
                                            @else
                                            <option selected  hidden value="" ></option>
                                            @endif

                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                        </div>
                                    </div>

                                    {{-- Buttons(next/prev) --}}
                                    <div class="mr-auto ml-auto" >
                                        <div class="d-flex">
                                            <button class="btn btn-info mt-5 w-25 mr-auto" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous </button>
                                            <button class="btn btn-info mt-5 w-25 ml-auto first_step" type="button" id="nextBtn" name = "step2" onclick="nextPrev(1)">Next </button>
                                        </div>
                                    </div>
                                </div>







                            {{-- CREW INJURY
                            =============================== --}}
                            <div class="tab form-group">
                                <h5 class="text-center my-3">CREW INJURY</h5>

                                {{-- Crew_Injury And Other_Personnel_Injury --}}
                                <div class="form-row">
                                    <div class="form-row col-md-6">
                                        <label class="" for="Crew_Injury">Crew Injury</label>
                                        <!-- <select class="form-control" id="Crew_Injury" name="Crew_Injury">
                                            <option selected disabled hidden>Crew Injury</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select> -->
                                        <select class="form-control" id="Crew_Injury" name="Crew_Injury">

                                            @if (isset($incident_report->crew_injury) && $incident_report->crew_injury)
                                            <option selected  hidden value="{{$incident_report->crew_injury}}"  >{{$incident_report->crew_injury}}</option>
                                            @else
                                            <!-- <option selected  hidden value=""  ></option> -->
                                            <option selected disabled hidden>Crew Injury</option>

                                            @endif

                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="pb-3" for="Other_Personnel_Injury">Third Party Personnel Injury</label>
                                        <!-- <select class="form-control" id="Other_Personnel_Injury" name="Other_Personnel_Injury">
                                            <option selected disabled hidden>Third Party Personnel Injury</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select> -->
                                        <select class="form-control" id="Other_Personnel_Injury" name="Other_Personnel_Injury">

                                            @if (isset($incident_report->other_personnel_injury) && $incident_report->other_personnel_injury)
                                            <option selected  hidden value="{{$incident_report->other_personnel_injury}}" >{{$incident_report->other_personnel_injury}}</option>
                                            @else
                                            <!-- <option selected  hidden value=""  ></option> -->
                                            <option selected disabled hidden>Third Party Personnel Injury</option>
                                            @endif

                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- ----------------------------------------------- Show if Crew injured ---------------------------------------------- --}}
                                <!-- <div class="m-5" id="if_crew_injured" style="display: none;"> -->
                                <div class="m-5" id="if_crew_injured" @if(@isset($incident_report) && $incident_report->crew_injury == 'Yes')style="display: block;" @else style="display: none;" @endif >

                                    {{-- Fatality And Lost_Workday_Case --}}
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="Fatality">Fatality
                                                <i class="fa fa-info-circle ml-1" aria-hidden="true" data-toggle="tooltip" title="A death directly resulting from a work
                                                injury regardless of the
                                                length of time between the injury and death." data-placement="top"></i>
                                            </label>

                                            <select class="form-control" id="Fatality" name="Fatality">

                                                @if (isset($incident_reports_crew_injury->fatality) && $incident_reports_crew_injury->fatality)
                                                    <option selected  hidden value="{{$incident_reports_crew_injury->fatality}}">{{$incident_reports_crew_injury->fatality}}</option>
                                                @else
                                                    <!-- <option selected  hidden value=""></option> -->
                                                    <option selected disabled hidden>Fatality</option>
                                                @endif

                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Lost_Workday_Case">Lost Workday Case
                                                <i class="fa fa-info-circle ml-1" aria-hidden="true" data-toggle="tooltip" title="This is an injury which results in an individual being unable to
                                                Case (LWC) carry out any of his duties or to return to work on a scheduled
                                                work shift on the day following the injury unless caused by
                                                delays in getting medical treatment ashore."></i>
                                            </label>
                                            <!-- <select class="form-control" id="Lost_Workday_Case" name="Lost_Workday_Case">
                                                <option selected disabled hidden>Lost Workday Case</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select> -->
                                            <select class="form-control" id="Lost_Workday_Case" name="Lost_Workday_Case">

                                                @if (isset($incident_reports_crew_injury->lost_workday_case) && $incident_reports_crew_injury->lost_workday_case)
                                                    <option selected  hidden value="{{$incident_reports_crew_injury->lost_workday_case}}"  >{{$incident_reports_crew_injury->lost_workday_case}}</option>
                                                @else
                                                <!-- <option selected  hidden value="" ></option> -->
                                                <option selected disabled hidden>Lost Workday Case</option>
                                                @endif

                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Restricted_Work_Case And Medical_Treatment_Case --}}
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="Restricted_Work_Case">Restricted Work Case
                                                <i class="fa fa-info-circle ml-1" aria-hidden="true" data-toggle="tooltip" title="This is an injury which results in an individual being unable to
                                                Case (RWC) perform all normally assigned work functions during a scheduled
                                                work shift or being assigned to another job on a temporary or
                                                permanent basis on the day following the injury."></i>
                                            </label>

                                             <select class="form-control" id="Restricted_Work_Case" name="Restricted_Work_Case">

                                                @if (isset($incident_reports_crew_injury->restricted_work_case) && $incident_reports_crew_injury->restricted_work_case)
                                                    <option selected  hidden value="{{$incident_reports_crew_injury->restricted_work_case}}" >{{$incident_reports_crew_injury->restricted_work_case}}</option>
                                                @else
                                                    <!-- <option selected  hidden value="" ></option> -->
                                                    <option selected disabled hidden>Restricted Work Case</option>

                                                @endif

                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Commercial_Service">Medical Treatment Case
                                                <i class="fa fa-info-circle ml-1" aria-hidden="true" data-toggle="tooltip" title="This is any work-related loss of consciousness (unless due
                                                to ill health), injury or illness requiring more than first aid
                                                treatment by a physician, dentist, surgeon or registered medical
                                                personnel, e.g. nurse or paramedic under the standing orders of
                                                a physician, or under the specific order of a physician or if at sea
                                                with no physician onboard could be considered as being in the
                                                province of a physician."></i>
                                            </label>
                                            <!-- <select class="form-control" id="Medical_Treatment_Case" name="Medical_Treatment_Case">
                                                <option selected disabled hidden>Medical Treatment Case</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select> -->
                                            <select class="form-control" id="Medical_Treatment_Case" name="Medical_Treatment_Case">

                                                @if (isset($incident_reports_crew_injury->medical_treatment_case) && $incident_reports_crew_injury->medical_treatment_case)
                                                <option selected  hidden value="{{$incident_reports_crew_injury->medical_treatment_case}}"  >{{$incident_reports_crew_injury->medical_treatment_case}}</option>
                                                @else
                                                <!-- <option selected  hidden value="" ></option> -->
                                                <option selected disabled hidden>Medical Treatment Case</option>

                                                @endif

                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>


                                    {{-- Lost_Time_Injuries And First_Aid_Case --}}
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="Confidential">Lost Time Injuries
                                                <i class="fa fa-info-circle ml-1" aria-hidden="true" data-toggle="tooltip" title="Lost Time Injuries are the sum of Fatalities, Permanent Total
                                                Disabilities, Permanent Partial Disabilities and Lost Workday
                                                Cases.
                                                "></i>
                                            </label>
                                            <select class="form-control" id="Lost_Time_Injuries" name="Lost_Time_Injuries">
                                                @if(@isset($incident_reports_crew_injury) && $incident_reports_crew_injury->lost_time_injuries))
                                                <option selected disabled hidden value="{{$incident_reports_crew_injury->lost_time_injuries}}">{{$incident_reports_crew_injury->lost_time_injuries}}</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                                @else
                                                <option selected disabled hidden>Lost Time Injuries</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                                @endif
                                            </select>
                                            {{-- <input type="text" class="form-control" id="Lost_Time_Injuries" name="Lost_Time_Injuries" placeholder="Lost Time Injuries..."> --}}
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Commercial_Service">First Aid Case
                                                <i class="fa fa-info-circle ml-1" aria-hidden="true" data-toggle="tooltip" title="This is any one-time treatment and subsequent observation or
                                                minor injuries such as bruises, scratches, cuts, burns, splinters,
                                                etc. The first aid may or may not be administered by a physician
                                                or registered professional."></i>
                                            </label>
                                            <!-- <select class="form-control" id="First_Aid_Case" name="First_Aid_Case">
                                                <option selected disabled hidden>First Aid Case</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select> -->
                                            <select class="form-control" id="First_Aid_Case" name="First_Aid_Case">

                                                @if (isset($incident_reports_crew_injury->first_aid_case) && $incident_reports_crew_injury->first_aid_case)
                                                <option selected  hidden value="{{$incident_reports_crew_injury->first_aid_case}}" >{{$incident_reports_crew_injury->first_aid_case}}</option>
                                                @else
                                                <!-- <option selected  hidden value=""  ></option> -->
                                                <option selected disabled hidden>First Aid Case</option>
                                                @endif

                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Lead Investigator And  Supporting Team Members --}}
                                    <div>
                                        <label for="Lead_Investigator">Lead Investigator</label>
                                        <!-- <textarea type="text"   class="form-control" id="Lead_Investigator" name="Lead_Investigator" placeholder="Lead Investigator..." autocomplete="off"> </textarea> -->
                                        @if (isset($incident_report->lead_investigator) && $incident_report->lead_investigator)
                                            <textarea type="text"  class="form-control" id="Lead_Investigator" name="Lead_Investigator" placeholder="Lead Investigator..." autocomplete="off">{{$incident_report->lead_investigator}} </textarea>
                                        @else
                                            <textarea type="text"  class="form-control" id="Lead_Investigator" name="Lead_Investigator" placeholder="Lead Investigator..." autocomplete="off"></textarea>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-right mt-5">
                                            <button class="btn btn-primary ml-auto" id="add_supporting_member" type="button">Add More Member</button>
                                        </div>
                                        <label for="STM1">Supporting Team Members</label>
                                        <div id="add_supporting_member_content">
                                        @if(@isset($incident_reports_supporting_team_members))
                                            @foreach ($incident_reports_supporting_team_members as $item)
                                                @if(isset($item->member_name) && isset($loop->iteration) && $loop->iteration && $item->member_name)
                                                    
                                                        <input type="text" value="{{$item->member_name}}"  class="form-control mb-3" id="STM_{{$loop->iteration}}" name="STM[]" placeholder="Supporting Team Members..." autocomplete="off">
                                                    
                                                @else
                                                
                                                    <input type="text"   class="form-control mb-3" id="STM_1" name="STM[]" placeholder="Supporting Team Members..." autocomplete="off">
                                                
                                                @endif
                                            @endforeach
                                        @else
                                                <input type="text"   class="form-control mb-3" id="STM_1" name="STM[]" placeholder="Supporting Team Members..." autocomplete="off">
                                            
                                        @endif
                                        </div>
                                    </div>

                                </div>
                                {{-- ----------------------------------------------- Show if Crew injured End ---------------------------------------------- --}}

                                {{-- Buttons(next/prev) --}}
                                <div class="mr-auto ml-auto" >
                                    <div class="d-flex">
                                        <button class="btn btn-info mt-5 w-25 mr-auto" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous </button>
                                        <button class="btn btn-info mt-5 w-25 ml-auto crew_injury" type="button" id="nextBtn" name = "step3" onclick="nextPrev(1)">Next </button>
                                    </div>
                                </div>

                            </div>





                            {{--  Vessel Details
                            ========================  --}}





                            {{--  EVENT INFORMATION
                            ========================  --}}
                            <div class="tab form-group">

                                <h5 class="text-center my-3">EVENT INFORMATION</h5>

                                {{--  Place of the incident
                                ========================  --}}
                                <div class="form-row ">
                                    <div class="col-6 mb-3">
                                        <label for="NRT">Place of the incident</label>
                                        <!-- <select class="form-control" id="Place_of_the_incident_1st" name="Place_of_the_incident_1st">
                                            <option selected disabled hidden>Place of the incident</option>
                                            <option value="Port">Port</option>
                                            <option value="At Sea">At Sea</option>
                                        </select> -->
                                        <select class="form-control" id="Place_of_the_incident_1st" name="Place_of_the_incident_1st">

                                            @if (isset($incident_reports_event_information->place_of_incident) && $incident_reports_event_information->place_of_incident)
                                            <option selected  hidden value="{{$incident_reports_event_information->place_of_incident}}"  >{{$incident_reports_event_information->place_of_incident}}</option>
                                            @else
                                            <option selected  hidden value="" ></option>
                                            @endif

                                            <option value="Port">Port</option>
                                            <option value="At Sea">At Sea</option>
                                        </select>
                                    </div>
                                    <div class="col-6 mb-3" @if(isset($incident_reports_event_information->place_of_incident_position)) style="display: block;" @else style="display: none;" @endif   id="poi2">
                                        <label for="NRT" class="pb-3"></label>
                                        <input @if(isset($incident_reports_event_information->place_of_incident_position)) value="{{$incident_reports_event_information->place_of_incident_position}}"  @endif type="text" class="form-control" id="Place_of_the_incident_2nd" name="Place_of_the_incident_2nd" placeholder="Name of the port">
                                    </div>
                                    <div class="col-6 mb-3" @if (isset($incident_reports_event_information->lat_1) || isset($incident_reports_event_information->lat_2) || isset($incident_reports_event_information->lat_3) || isset($incident_reports_event_information->long_1) || isset($incident_reports_event_information->long_2) || isset($incident_reports_event_information->long_3) )
                                        style="display: block;"
                                    @else
                                        style="display: none;"
                                    @endif   id="poisea">
                                            <div class="col-12 my-2 d-flex">
                                                    <label for="place_of_incident_sea">Latitude:</label>
                                                    <br>
                                                    <input  @if(isset($incident_reports_event_information->lat_1))  value="{{ $incident_reports_event_information->lat_1 }}"  @endif  class='form-control' type="number" name="lat_1" id="lat_1" step="1" min = "0" max = "90"  onchange = "mouseLeave('lat_1')">
                                                    <input  @if(isset($incident_reports_event_information->lat_2)) value="{{ $incident_reports_event_information->lat_2 }}" @endif class='form-control' type="text" name="lat_2" id="lat_2" step=".1" onchange = "mouseLeave('lat_2')">
                                                    <select name="lat_3" id="" class="form-control">
                                                        <option selected disabled hidden>  @if(isset($incident_reports_event_information->lat_3)) {{ $incident_reports_event_information->lat_3 }} @else Select N/S @endif </option>
                                                        <option value="N">N</option>
                                                        <option value="S">S</option>
                                                    </select>
                                            </div>
                                            <div class="col-12 d-flex">
                                                    <label for="place_of_incident_sea">Longitude:</label>
                                                    <br>
                                                    <input @if(isset($incident_reports_event_information->long_1)) value="{{ $incident_reports_event_information->long_1 }}" @endif class='form-control' type="number" name="long_1" id="long_1" step="1" min="0" max = "180" onchange = "mouseLeave('long_1')">
                                                    <input @if(isset($incident_reports_event_information->long_2)) value="{{ $incident_reports_event_information->long_2 }}" @endif class='form-control' type="text" name="long_2" id="long_2" step=".1" onchange = "mouseLeave('long_2')">
                                                    <select name="long_3" id="" class="form-control">
                                                        <option selected disabled hidden> @if(isset($incident_reports_event_information->long_3)) {{ $incident_reports_event_information->long_3 }} @else Select E/W @endif </option>
                                                        <option value="E">E</option>
                                                        <option value="W">W</option>
                                                    </select>
                                            </div>
                                    </div>

                                </div>


                                {{--  date time and lmt gmt of incident
                                =========================================  --}}
                                <div class="form-row">
                                    {{-- Date of incident --}}
                                    <div class="col-12 col-md-4 mb-3">
                                        <label for="NRT">Date of incident</label>
                                        <input @if(isset($incident_reports_event_information->date_of_incident)) value="{{$incident_reports_event_information->date_of_incident}}" @endif  type="text" class="form-control date" id="Date_of_incident_event_information" name="Date_of_incident_event_information" placeholder="Date of incident..." autocomplete="off">
                                    </div>
                                    {{-- lmt --}}
                                    <div class="col-12 col-md-4 mb-3 clockpicker">
                                        <label for="Length">Time of incident</label>

                                        <input  type="text"
                                        @if (isset($incident_reports_event_information->time_of_incident_lt) )
                                        value="{{$incident_reports_event_information->time_of_incident_lt}}"
                                        @else
                                        value=""
                                        @endif

                                        class="form-control" id="Time_of_incident_event_information_LMT" name="Time_of_incident_event_information_LMT" placeholder="Date of incident..." autocomplete="off">
                                    </div>

                                    {{-- GMT --}}
                                    <div class="col-12 col-md-4 mb-3">
                                        <label for="Length"></label>
                                        <select class="form-control" id="Time_of_incident_event_information_GMT" name="Time_of_incident_event_information_GMT">
                                            <!-- <option selected disabled hidden>GMT</option> -->
                                            @if (isset($incident_reports_event_information->time_of_incident_gmt) && $incident_reports_event_information->time_of_incident_gmt)
                                            <option selected  hidden value="{{$incident_reports_event_information->time_of_incident_gmt}}" >{{$incident_reports_event_information->time_of_incident_gmt}}</option>
                                            @else
                                            <option selected  hidden value="" ></option>
                                            @endif
                                                <option value="GMT+ 00:00 hours">GMT+ 00:00 hours</option>
                                                <option value="GMT+ 00:30 hours">GMT+ 00:30 hours</option>
                                                <option value="GMT+ 01:00 hours">GMT+ 01:00 hours</option>
                                                <option value="GMT+ 01:30 hours">GMT+ 01:30 hours</option>
                                                <option value="GMT+ 02:00 hours">GMT+ 02:00 hours</option>
                                                <option value="GMT+ 02:30 hours">GMT+ 02:30 hours</option>
                                                <option value="GMT+ 03:00 hours">GMT+ 03:00 hours</option>
                                                <option value="GMT+ 03:30 hours">GMT+ 03:30 hours</option>
                                                <option value="GMT+ 04:00 hours">GMT+ 04:00 hours</option>
                                                <option value="GMT+ 04:30 hours">GMT+ 04:30 hours</option>
                                                <option value="GMT+ 05:00 hours">GMT+ 05:00 hours</option>
                                                <option value="GMT+ 05:30 hours">GMT+ 05:30 hours</option>
                                                <option value="GMT+ 06:00 hours">GMT+ 06:00 hours</option>
                                                <option value="GMT+ 06:30 hours">GMT+ 06:30 hours</option>
                                                <option value="GMT+ 07:00 hours">GMT+ 07:00 hours</option>
                                                <option value="GMT+ 07:30 hours">GMT+ 07:30 hours</option>
                                                <option value="GMT+ 08:00 hours">GMT+ 08:00 hours</option>
                                                <option value="GMT+ 08:30 hours">GMT+ 08:30 hours</option>
                                                <option value="GMT+ 09:00 hours">GMT+ 09:00 hours</option>
                                                <option value="GMT+ 09:30 hours">GMT+ 09:30 hours</option>
                                                <option value="GMT+ 10:00 hours">GMT+ 10:00 hours</option>
                                                <option value="GMT+ 10:30 hours">GMT+ 10:30 hours</option>
                                                <option value="GMT+ 11:00 hours">GMT+ 11:00 hours</option>
                                                <option value="GMT+ 11:30 hours">GMT+ 11:30 hours</option>

                                                <option value="GMT- 00:00 hours">GMT- 00:00 hours</option>
                                                <option value="GMT- 00:30 hours">GMT- 00:30 hours</option>
                                                <option value="GMT- 01:00 hours">GMT- 01:00 hours</option>
                                                <option value="GMT- 01:30 hours">GMT- 01:30 hours</option>
                                                <option value="GMT- 02:00 hours">GMT- 02:00 hours</option>
                                                <option value="GMT- 02:30 hours">GMT- 02:30 hours</option>
                                                <option value="GMT- 03:00 hours">GMT- 03:00 hours</option>
                                                <option value="GMT- 03:30 hours">GMT- 03:30 hours</option>
                                                <option value="GMT- 04:00 hours">GMT- 04:00 hours</option>
                                                <option value="GMT- 04:30 hours">GMT- 04:30 hours</option>
                                                <option value="GMT- 05:00 hours">GMT- 05:00 hours</option>
                                                <option value="GMT- 05:30 hours">GMT- 05:30 hours</option>
                                                <option value="GMT- 06:00 hours">GMT- 06:00 hours</option>
                                                <option value="GMT- 06:30 hours">GMT- 06:30 hours</option>
                                                <option value="GMT- 07:00 hours">GMT- 07:00 hours</option>
                                                <option value="GMT- 07:30 hours">GMT- 07:30 hours</option>
                                                <option value="GMT- 08:00 hours">GMT- 08:00 hours</option>
                                                <option value="GMT- 08:30 hours">GMT- 08:30 hours</option>
                                                <option value="GMT- 09:00 hours">GMT- 09:00 hours</option>
                                                <option value="GMT- 09:30 hours">GMT- 09:30 hours</option>
                                                <option value="GMT- 10:00 hours">GMT- 10:00 hours</option>
                                                <option value="GMT- 10:30 hours">GMT- 10:30 hours</option>
                                                <option value="GMT- 11:00 hours">GMT- 11:00 hours</option>
                                                <option value="GMT- 11:30 hours">GMT- 11:30 hours</option>

                                        </select>
                                    </div>
                                </div>


                                {{--  Location of incident
                                =============================  --}}
                                <div class="form-group">
                                    <label for="Name">Location of incident</label>
                                    <!-- <input  type="text"   class="form-control" id="Location_of_incident" name="Location_of_incident" placeholder="Location of incident..." autocomplete="off"> -->
                                    <input  type="text"
                                    @if (isset($incident_reports_event_information->location_of_incident) )
                                    value="{{$incident_reports_event_information->location_of_incident}}"
                                    @else
                                    value=""
                                    @endif

                                    class="form-control" id="Location_of_incident" name="Location_of_incident" placeholder="Location of incident..." autocomplete="off">
                                </div>

                                {{--  Operation
                                ========================  --}}
                                <div class="form-row ">
                                    <div class="col-6 mb-3">
                                        <label for="Class_Society">Operation</label>
                                        <select class="form-control" id="Operation" name="Operation">
                                            <!-- <option selected disabled hidden>Operation</option> -->
                                            @if (isset($incident_reports_event_information->operation) && $incident_reports_event_information->operation)
                                            <option selected  hidden value="{{$incident_reports_event_information->operation}}"  >{{$incident_reports_event_information->operation}}</option>
                                            @else
                                            <option selected  hidden value=""  ></option>
                                            @endif
                                            <option value="Loading">Loading</option>
                                            <option value="Discharging">Discharging</option>
                                            <option value="Anchorage">Anchorage</option>
                                            <option value="At sea">At sea</option>
                                            <option value="Yard">Yard</option>
                                            <option value="Gas freeing">Gas freeing</option>
                                            {{-- <option value="others">others (If others pls specify)</option> --}}
                                        </select>
                                    </div>
                                    <div class="col-6 mb-3" id="operation_other_EI" style="display: none;">
                                        <label for="Others_operation_EI">Others</label>
                                        <textarea class="form-control" name="Others_operation_EI" id="Others_operation_EI"></textarea>
                                    </div>
                                </div>


                                {{--  Vessel Condition
                                ========================  --}}
                                <div class="form-group">
                                    <label for="Class_Society">Vessel Condition</label>
                                    <select class="form-control" id="Vessel_Condition" name="Vessel_Condition">
                                        <!-- <option selected disabled hidden>Vessel Condition</option> -->
                                        @if (isset($incident_reports_event_information->vessel_condition) && $incident_reports_event_information->vessel_condition)
                                        <option selected  hidden value="{{$incident_reports_event_information->vessel_condition}}"  >{{$incident_reports_event_information->vessel_condition}}</option>
                                        @else
                                        <option selected  hidden value=""  ></option>
                                        @endif
                                        <option value="Ballast">Ballast</option>
                                        <option value="Fully Loaded">Fully Loaded</option>
                                        <option value="Partially loaded">Partially loaded</option>
                                    </select>
                                </div>


                                {{--  cargo type and quantity
                                ==================================  --}}
                                <div class="form-group">
                                    <label for="Class_Society">Cargo type and quantity</label>
                                    <!-- <input  type="text"   class="form-control" id="cargo_type_and_quantity" name="cargo_type_and_quantity" placeholder="Cargo type and quantity..." autocomplete="off"> -->
                                    <input  type="text"
                                    @if (isset($incident_reports_event_information->cargo_type_and_quantity) && $incident_reports_event_information->cargo_type_and_quantity)
                                    value="{{$incident_reports_event_information->cargo_type_and_quantity}}"
                                    @else
                                    value=""
                                    @endif

                                    class="form-control" id="cargo_type_and_quantity" name="cargo_type_and_quantity" placeholder="Cargo type and quantity..." autocomplete="off">
                                </div>

                                {{-- -------------------- Weather -------------------------- --}}

                                {{--  wind force and direction
                                =========================================  --}}
                                <div class="form-row w-100">
                                    {{-- wind force --}}
                                    <div class="col-6 mb-3">
                                        <label for="NRT">Wind force</label>
                                        <select class="form-control" id="Wind_force" name="Wind_force">
                                            <!-- <option selected >Wind force</option> -->
                                            @if (isset($incident_reports_weather->wind_force) && $incident_reports_weather->wind_force)
                                            <option selected value="{{$incident_reports_weather->wind_force}}" >{{$incident_reports_weather->wind_force}}</option>
                                            @else
                                            <option selected value="" ></option>
                                            @endif
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                    </div>
                                    {{-- Direction --}}
                                    <div class="col-6 mb-3">
                                        <label for="Length">Direction (Degree)</label>
                                        <input type="number" data-target-picker="#degree_picker_1" class="form-control degree" id="Direction" name="Direction" placeholder="Direction..." autocomplete="off"  @if (isset($incident_reports_weather->wind_direction) && $incident_reports_weather->wind_direction)
                                        value="{{$incident_reports_weather->wind_direction}}" @endif>
                                        <!-- <input type="number"
                                        @if (isset($incident_reports_weather->wind_direction) && $incident_reports_weather->wind_direction)
                                        value="{{$incident_reports_weather->wind_direction}}"
                                        @else
                                        value=""
                                        @endif

                                        class="form-control degree" id="Direction" name="Direction" placeholder="Direction..." autocomplete="off"> -->
                                        <div id="degree_picker_1" class="degree_picker">
                                            <input type="range" value="0" data-min="0" id="Direction_degree" >
                                            <button type="button" class="degree_btn" onclick="closeDegreePicker(`degree_picker_1`)">OK</button>
                                        </div>

                                    </div>
                                    {{-- Beaut force Wind force table --}}
                                    <div class="alert col-12 alert-primary" id="wf_chart" style="display: none" role="alert">
                                        <table border="1" class="text-dark w-100">
                                            <thead>
                                                <tr>
                                                    <th>Beaufort Number</th>
                                                    <th>Descriptive Term</th>
                                                    <th colspan="2">Mean wind speed equivalent</th>
                                                    <th>Deep Sea Criterion</th>
                                                    <th>Probable mean wave height *in metres</th>
                                                </tr>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th>Knots</th>
                                                    <th>m/sec</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id="wf_0" style="display: none;">
                                                    <td>0</td>
                                                    <td>Calm</td>
                                                    <td>1</td>
                                                    <td>0-0.2</td>
                                                    <td>Sea like a miror</td>
                                                    <td>---</td>
                                                </tr>

                                                <tr id="wf_1" style="display: none;">
                                                    <td>1</td>
                                                    <td>Light air</td>
                                                    <td>1-3</td>
                                                    <td>0.3-1.5</td>
                                                    <td width="300px">Ripples with the appearance of scales are formed,but without foam crests</td>
                                                    <td>0.1(0.1)</td>
                                                </tr>

                                                <tr id="wf_2" style="display: none;">
                                                    <td>2</td>
                                                    <td>Light breeze</td>
                                                    <td>4-6</td>
                                                    <td>1.6-3.3</td>
                                                    <td>Small wavelets, still short but more pronounced; crests have a glassy appearance and do not break</td>
                                                    <td>0.2(0.3)</td>
                                                </tr>

                                                <tr id="wf_3" style="display: none;">
                                                    <td>3</td>
                                                    <td>Gentle breeze</td>
                                                    <td>7-10</td>
                                                    <td>3.4-5.4</td>
                                                    <td>Large wavelets; crests begin to break; foam of glassy appearance; perhaps scattered white horses</td>
                                                    <td>0.6(1)</td>
                                                </tr>

                                                <tr id="wf_4" style="display: none;">
                                                    <td>4</td>
                                                    <td>Moderate breeze</td>
                                                    <td>11-16</td>
                                                    <td>5.5-7.9</td>
                                                    <td>Small waves, becoming longer; fairly frequent white horses</td>
                                                    <td>1(1.5)</td>
                                                </tr>

                                                <tr id="wf_5" style="display: none;">
                                                    <td>5</td>
                                                    <td>Fresh breeze</td>
                                                    <td>17-21</td>
                                                    <td>8.0-10.7</td>
                                                    <td>Moderate waves, taking a more pronounced long form; many white horses are formed (chance of some spray)</td>
                                                    <td>2(2.5)</td>
                                                </tr>

                                                <tr id="wf_6" style="display: none;">
                                                    <td>6</td>
                                                    <td>Strong breeze</td>
                                                    <td>22-27</td>
                                                    <td>10.8-13.8</td>
                                                    <td>Large waves begin to form; the white foam crests are extensive everywhere (probably spray)</td>
                                                    <td>3(4)</td>
                                                </tr>

                                                <tr id="wf_7" style="display: none;">
                                                    <td>7</td>
                                                    <td>Near gale</td>
                                                    <td>28-33</td>
                                                    <td>13.9-17.1</td>
                                                    <td>Sea heaps up and white foam froom breaking waves begins to blown in streaks along the direction of the wind</td>
                                                    <td>4(5.5)</td>
                                                </tr>

                                                <tr id="wf_8" style="display: none;">
                                                    <td>8</td>
                                                    <td>Gale</td>
                                                    <td>34-40</td>
                                                    <td>17.2-20.7</td>
                                                    <td>Moderately high waves of greater length; edges of crests begin to break into spindrift; foam is blown in well-marked streaks along the direction of the wind</td>
                                                    <td>5.5(7.5)</td>
                                                </tr>

                                                <tr id="wf_9" style="display: none;">
                                                    <td>9</td>
                                                    <td>Strong Gale</td>
                                                    <td>41-47</td>
                                                    <td>20.8-24.4</td>
                                                    <td>High waves; dense streaks of foam along the direction of the wind; crests of waves begin to topple, tumble and roll over; spray may affect visibility </td>
                                                    <td>7(10)</td>
                                                </tr>

                                                <tr id="wf_10" style="display: none;">
                                                    <td>10</td>
                                                    <td>Storm</td>
                                                    <td>48-55</td>
                                                    <td>24.5-28.4</td>
                                                    <td>Very high waves with long overhanging crests; the resulting foam, in great patches,is blown in dense white streaks along the direction of the wind; on the whole, the surface of the sea takes a white appearance; the tumbling of the sea becomes heavy and shock-like; visibility affected</td>
                                                    <td>9(12.5)</td>
                                                </tr>

                                                <tr id="wf_11" style="display: none;">
                                                    <td>11</td>
                                                    <td>Violent storm</td>
                                                    <td>56-63</td>
                                                    <td>28.5-32.6</td>
                                                    <td>Exceptionally high waves (small and medium size ships might be for a time lost of view behind the waves);
                                                        the sea is completely covered with long white patches of foam lying along the direction of the wind;
                                                        everywhere the edges of the wave crests are blown into forth; visibility affected</td>
                                                    <td>11.5(16)</td>
                                                </tr>

                                                <tr id="wf_12" style="display: none;">
                                                    <td>12</td>
                                                    <td>Hurricane</td>
                                                    <td>64 and over</td>
                                                    <td>32.7 and over</td>
                                                    <td>The air is filled with foam and spray; sea completely white with driving spray; visibility seriously affected</td>
                                                    <td>14(-)</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{--  sea and direction
                                =========================================  --}}
                                {{-- <div class="form-row w-100">
                                    sea force
                                    <div class="col-6 mb-3">
                                        <label for="Sea">Sea</label>
                                        <!-- <input  type="number" class="form-control" id="Sea" name="Sea" placeholder="Sea..." autocomplete="off"> -->
                                        <input
                                        @if (isset($incident_reports_weather->sea_wave) && $incident_reports_weather->sea_wave)
                                        value="{{$incident_reports_weather->sea_wave}}"
                                        @else
                                        value=""
                                        @endif

                                        type="number" class="form-control" id="Sea" name="Sea" placeholder="Sea..." autocomplete="off">
                                    </div>
                                    sea Direction
                                    <div class="col-6 mb-3">
                                        <label for="sea_Direction">Direction (Degree)</label>
                                        <!-- <input type="number" class="form-control degree" id="sea_Direction" name="sea_Direction" placeholder="Direction..." autocomplete="off"> -->
                                        <input type="number"
                                        @if (isset($incident_reports_weather->sea_direction) && $incident_reports_weather->sea_direction)
                                        value="{{$incident_reports_weather->sea_direction}}"
                                        @else
                                        value=""
                                        @endif

                                        class="form-control degree" id="sea_Direction" name="sea_Direction" placeholder="Direction..." autocomplete="off">
                                    </div>
                                </div> --}}


                                {{--  Swell
                                ==================================  --}}
                                <div class="form-row">
                                    {{-- swell --}}
                                    <div class="col-4">
                                        <label for="Class_Society">Swell</label>
                                        <select class="form-control" name="Swell_height" id="Swell_height">
                                        @if (isset($incident_reports_weather->swell_height) && $incident_reports_weather->swell_height)
                                            <option selected  hidden value="{{$incident_reports_weather->swell_height}}" >{{$incident_reports_weather->swell_height}}</option>
                                            @else
                                            <option selected  hidden value="" ></option>
                                            @endif

                                            <option value="Low (0 - 2)">Low (0 - 2)</option>
                                            <option value="Moderate (2 - 4)">Moderate (2 - 4)</option>
                                            <option value="Heavy (over 4)">Heavy (over 4)</option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <label for="Class_Society"></label>
                                        <!-- <select class="form-control" name="Swell_length" id="Swell_length">
                                            <option selected disabled hidden>Length</option>
                                            <option value="Low (0 - 2)">Short (0 - 100)</option>
                                            <option value="Moderate (2 - 4)">Average (100 - 200)</option>
                                            <option value="Heavy (over 4)">Long (over 200)</option>
                                        </select> -->
                                        <select class="form-control" name="Swell_length" id="Swell_length">

                                            @if (isset($incident_reports_weather->swell_length) && $incident_reports_weather->swell_length)
                                            <option selected  hidden value="{{$incident_reports_weather->swell_length}}">{{$incident_reports_weather->swell_length}}</option>
                                            @else
                                            <option selected  hidden value=""></option>
                                            @endif

                                            <option value="Low (0 - 2)">Short (0 - 100)</option>
                                            <option value="Moderate (2 - 4)">Average (100 - 200)</option>
                                            <option value="Heavy (over 4)">Long (over 200)</option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <label for="Class_Society"></label>
                                        <!-- <input  type="number" data-target-picker="#degree_picker_2"  class="form-control degree" id="Swell_direction" name="Swell_direction" placeholder="Direction(Degree)..." autocomplete="off"> -->
                                        <input  type="number"
                                        data-target-picker="#degree_picker_2"
                                        @if (isset($incident_reports_weather->swell_direction) && $incident_reports_weather->swell_direction)
                                        value="{{$incident_reports_weather->swell_direction}}"
                                        @else
                                        value=""
                                        @endif

                                        class="form-control degree" id="Swell_direction" name="Swell_direction" placeholder="Direction(Degree)..." autocomplete="off">
                                        <div id="degree_picker_2" class="degree_picker">
                                            <input type="range" id="Swell_direction_degree" value="0">
                                            <button type="button" class="degree_btn" onclick="closeDegreePicker(`degree_picker_2`)">OK</button>
                                        </div>
                                    </div>
                                </div>


                                {{--  Sky
                                ==================================  --}}
                                <div class="form-group">
                                    <label for="Class_Society">Sky</label>
                                    {{-- <input  type="text"   class="form-control" id="Sky" name="Sky" placeholder="Sky..." autocomplete="off"> --}}
                                    <!-- <select class="form-control" id="Sky" name="Sky">
                                        <option selected disabled hidden>Sky</option>
                                        <option value="No Clouds">No Clouds</option>
                                        <option value="One tenth or less, but not zero">One tenth or less, but not zero</option>
                                        <option value="Two tenths to three-tenths">Two tenths to three-tenths</option>
                                        <option value="Four-tenths">Four-tenths</option>
                                        <option value="Five-tenths">Five-tenths</option>
                                        <option value="Six-tenths">Six-tenths</option>
                                        <option value="Seven-tenths to eight-tenths">Seven-tenths to eight-tenths</option>
                                        <option value="Nine-tenths or overcast with openings">Nine-tenths or overcast with openings</option>
                                        <option value="Sky obscured">Sky obscured</option>
                                    </select> -->
                                    <select class="form-control" id="Sky" name="Sky">
                                        <option selected  hidden
                                        @if (isset($incident_reports_weather->sky) && $incident_reports_weather->sky)
                                        value="{{$incident_reports_weather->sky}}"
                                        @else
                                        value=""
                                        @endif
                                    >@if(isset($incident_reports_weather)){{$incident_reports_weather->sky}}@else "" @endif</option>
                                        <option value="No Clouds">No Clouds</option>
                                        <option value="One tenth or less, but not zero">One tenth or less, but not zero</option>
                                        <option value="Two tenths to three-tenths">Two tenths to three-tenths</option>
                                        <option value="Four-tenths">Four-tenths</option>
                                        <option value="Five-tenths">Five-tenths</option>
                                        <option value="Six-tenths">Six-tenths</option>
                                        <option value="Seven-tenths to eight-tenths">Seven-tenths to eight-tenths</option>
                                        <option value="Nine-tenths or overcast with openings">Nine-tenths or overcast with openings</option>
                                        <option value="Sky obscured">Sky obscured</option>
                                    </select>
                                </div>


                                {{--  Visibility
                                ==================================  --}}
                                <div class="form-group">
                                    <label for="Class_Society">Visibility</label>
                                    <!-- <select class="form-control" id="Visibility" name="Visibility">
                                        <option selected disabled hidden>Visibility</option>
                                        <option value="Very poor for fog (Visibility less than 1,000 meters)">Very poor for fog (Visibility less than 1,000 meters)</option>
                                        <option value="Poor (Visibility between 1,000 meters and 2 nautical miles)">Poor (Visibility between 1,000 meters and 2 nautical miles)</option>
                                        <option value="Moderate (Visibility between 2 and 5 nautical miles)">Moderate (Visibility between 2 and 5 nautical miles)</option>
                                        <option value="Good (Visibility more than 5 nautical miles)">Good (Visibility more than 5 nautical miles)</option>
                                    </select> -->
                                    <select class="form-control" id="Visibility" name="Visibility">

                                        @if (isset($incident_reports_weather->visibility) && $incident_reports_weather->visibility)
                                        <option selected  hidden value="{{$incident_reports_weather->visibility}}">{{$incident_reports_weather->visibility}}</option>
                                        @else
                                        <option selected  hidden ></option>
                                        @endif

                                        <option value="Very poor for fog (Visibility less than 1,000 meters)">Very poor for fog (Visibility less than 1,000 meters)</option>
                                        <option value="Poor (Visibility between 1,000 meters and 2 nautical miles)">Poor (Visibility between 1,000 meters and 2 nautical miles)</option>
                                        <option value="Moderate (Visibility between 2 and 5 nautical miles)">Moderate (Visibility between 2 and 5 nautical miles)</option>
                                        <option value="Good (Visibility more than 5 nautical miles)">Good (Visibility more than 5 nautical miles)</option>
                                    </select>
                                </div>

                                {{--  Rolling and Pitcing
                                =========================================  --}}
                                <div class="form-row w-100">
                                    {{-- Rolling --}}
                                    <div class="col-6 mb-3">
                                        <label for="Rolling">Rolling (Degree)</label>
                                        <!-- <input type="number" class="form-control degree" data-target-picker="#degree_picker_3" id="Rolling" name="Rolling" placeholder="Rolling..." autocomplete="off" max="60"> -->
                                        <input type="number"
                                        data-target-picker="#degree_picker_3"
                                        @if (isset($incident_reports_weather->rolling) && $incident_reports_weather->rolling)
                                        value="{{$incident_reports_weather->rolling}}"
                                        @else
                                        value=""
                                        @endif

                                        class="form-control degree" id="Rolling" name="Rolling" placeholder="Rolling..." autocomplete="off">
                                        <div id="degree_picker_3" class="degree_picker">
                                            <input type="range" id="Rolling_degree" value="0">
                                            <button type="button" class="degree_btn" onclick="closeDegreePicker(`degree_picker_3`)">OK</button>
                                        </div>
                                    </div>
                                    {{-- Pitcing --}}
                                    <div class="col-6 mb-3">
                                        <label for="Pitcing">Pitching (Degree)</label>
                                        <!-- <input type="number" class="form-control degree" data-target-picker="#degree_picker_4" id="Pitcing" name="Pitcing" placeholder="Pitching..." autocomplete="off" max="25"> -->
                                        <input type="number"
                                        data-target-picker="#degree_picker_4"
                                        @if (isset($incident_reports_weather->pitching) && $incident_reports_weather->pitching)
                                        value="{{$incident_reports_weather->pitching}}"
                                        @else
                                        value=""
                                        @endif

                                        class="form-control degree" id="Pitcing" name="Pitcing" placeholder="Pitching..." autocomplete="off">
                                        <div id="degree_picker_4" class="degree_picker">
                                            <input type="range" id="Pitcing_degree" value="0">
                                            <button type="button" class="degree_btn" onclick="closeDegreePicker(`degree_picker_4`)">OK</button>
                                        </div>
                                    </div>
                                </div>


                                {{--  Illumination
                                ==================================  --}}
                                <div class="form-group">
                                    <label for="Class_Society">Illumination</label>
                                    <!-- <select  class="form-control" name="Illumination" id="Illumination">
                                        <option disabled selected hidden>Illumination</option>
                                        <option value="Adequate">Adequate</option>
                                        <option value="Inadequate">Inadequate</option>
                                    </select> -->
                                    <select  class="form-control" name="Illumination" id="Illumination">

                                        @if (isset($incident_reports_weather->illumination) && $incident_reports_weather->illumination)
                                        <option  selected hidden value="{{$incident_reports_weather->illumination}}" >{{$incident_reports_weather->illumination}}</option>
                                        @else
                                        <option  selected hidden value="" ></option>
                                        @endif

                                        <option value="Adequate">Adequate</option>
                                        <option value="Inadequate">Inadequate</option>
                                    </select>
                                </div>

                                <h5 class="text-center my-3">TYPE OF LOSS</h5>
                                {{--  P&I Club informed AND H&M Informed
                                =========================================  --}}
                                <div class="form-row w-100">
                                    {{-- P&I Club informed --}}
                                    <div class="col-6 mb-3">
                                        <label for="NRT">P&I Club informed</label>
                                        {{-- <input  type="text" class="form-control" id="pi_club_information" name="pi_club_information" placeholder="P&I Club informed..." autocomplete="off"> --}}
                                        <!-- <select  class="form-control" name="pi_club_information" id="pi_club_information">
                                            <option disabled selected hidden>P&I Club informed</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select> -->
                                        <select  class="form-control" name="pi_club_information" id="pi_club_information">
                                                @if (isset($incident_report->p_n_i_club_informed)  )
                                                <option selected value="{{$incident_report->p_n_i_club_informed}}">{{$incident_report->p_n_i_club_informed}}</option>
                                                @else
                                                <option disabled selected value=""></option>
                                                @endif

                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                    </div>
                                    {{-- H&M Informed --}}
                                    <div class="col-6 mb-3">
                                        <label for="Length">H&M Informed</label>
                                        {{-- <input  type="text" class="form-control" id="hm_informed" name="hm_informed" placeholder="H&M Informed..." autocomplete="off"> --}}
                                        <!-- <select  class="form-control" name="hm_informed" id="hm_informed">
                                            <option disabled selected hidden>H&M Informed</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select> -->
                                        <select  class="form-control" name="hm_informed" id="hm_informed">
                                                @if (isset($incident_report->h_n_m_informed)  )
                                                <option selected value="{{$incident_report->h_n_m_informed}}">{{$incident_report->h_n_m_informed}}</option>
                                                @else
                                                <option disabled selected value=""></option>
                                                @endif

                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                        </select>
                                    </div>
                                    {{--  Remarks
                                ==================================  --}}
                                    <div class="form-group w-100">
                                        <label for="Class_Society">Remarks</label>
                                        {{-- <input  type="text"   class="form-control" id="remarks_tol" name="remarks_tol" placeholder="Remarks..." autocomplete="off"> --}}

                                        <!-- <textarea type="text" name="remarks_tol" id="remarks_tol" placeholder="Remarks..." class="form-control" spellcheck="false"></textarea> -->
                                        @if (isset($incident_report->type_of_loss_remarks) && $incident_report->type_of_loss_remarks)
                                            <textarea type="text" name="remarks_tol" id="remarks_tol" placeholder="Remarks..." class="form-control" spellcheck="false">{{$incident_report->type_of_loss_remarks}}</textarea>
                                        @else
                                            <textarea type="text" name="remarks_tol" id="remarks_tol" placeholder="Remarks..." class="form-control" spellcheck="false"></textarea>
                                        @endif
                                    </div>
                                </div>

                                {{-- Buttons(next/prev) --}}
                                <div class="mr-auto ml-auto" >
                                    <div class="d-flex">
                                        <button class="btn btn-info mt-5 w-25 mr-auto" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous </button>
                                        <button class="btn btn-info mt-5 w-25 ml-auto event_information" type="button" name = 'check' step="4" id="nextBtn" name = "step4" onclick="nextPrev(1)">Next </button>
                                    </div>
                                </div>
                            </div>




                            {{--  Incident in Brief
                            ========================  --}}
                            <div class="tab form-group">

                                <h5 class="text-center my-3">INCIDENT IN BRIEF</h5>


                                {{--  Free Text
                                ==================================  --}}
                                <div class="form-group">
                                    <label for="Class_Society">Incident in brief</label>
                                    <!-- <textarea type="text"   class="form-control" id="Incident_in_brief" name="Incident_in_brief" placeholder="Incident in brief..." autocomplete="off"> </textarea> -->
                                    @if (isset($incident_report->incident_brief) && $incident_report->incident_brief)
                                        <textarea type="text" class="form-control" id="Incident_in_brief" name="Incident_in_brief" placeholder="Incident in brief..." autocomplete="off">{{$incident_report->incident_brief}} </textarea>
                                    @else
                                        <textarea type="text" class="form-control" id="Incident_in_brief" name="Incident_in_brief" placeholder="Incident in brief..." autocomplete="off"> </textarea>
                                    @endif
                                </div>
                                <h5 class="text-center my-3">EVENT LOG</h5>


                                {{--  Event log
                                ==================================  --}}
                                <div class="form-group">
                                    {{-- <label for="Class_Society">Class Society</label> --}}

                                    <div class="text-right my-3">
                                        <a style="text-decoration: none;" class="btn btn-primary text-light add_event_log">Add More Event Log</a>
                                    </div>
                                    {{-- <table class="table">
                                      <thead class="bg-primary text-light" style="border-radious:14px;">
                                        <tr>
                                          <th scope="col">Date</th>
                                          <th scope="col">Time</th>
                                          <th scope="col">Remarks</th>
                                        </tr>
                                      </thead>
                                      <tbody id="event_body">


                                        <tr>
                                            <td><input type="text" class="form-control date" id="event_date_1" name="event_date[]" placeholder="Date..." autocomplete="off"></td>
                                            <td class="clockpicker"><input type="text" class="form-control" id="event_time_1" name="event_time[]" placeholder="Time..." autocomplete="off"></td>
                                            <td><textarea type="text" class="form-control" id="event_remarks_1" name="event_remarks[]" placeholder="Remarks..." autocomplete="off"></textarea></td>
                                          </tr>

                                      </tbody>
                                    </table> --}}
                                    <div id="event_body">



                                        @if(isset($incident_reports_event_logs))
                                            @foreach ( $incident_reports_event_logs as $log )
                                                @if ($log->date && $log->time)
                                                    <div class="form-row w-100">
                                                        <div class="col-6 col-md-2">
                                                            <label for="Class_Society">Date</label>
                                                            <input type="text" value="{{$log->date}}" class="form-control date" id="event_date_prefill_{{$loop->iteration}}" name="event_date[]" placeholder="Date..." autocomplete="off">
                                                            <script> $(()=>{ $("#event_date_prefill_{{$loop->iteration}}").datepicker() })</script>
                                                        </div>
                                                        <div class="col-6 col-md-2">
                                                            <label for="Class_Society">Time</label>
                                                            <div class="clockpicker">
                                                                <input value="{{$log->time}}" type="text" class="form-control" id="event_time_prefill_{{$loop->iteration}}" name="event_time[]" placeholder="Time..." autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-8">
                                                            <label for="Class_Society">Remarks</label>
                                                            <textarea type="text" class="form-control" id="event_remarks_prefill_{{$loop->iteration}}" name="event_remarks[]" placeholder="Remarks..." autocomplete="off">{{$log->remarks}}</textarea>
                                                        </div>
                                                    </div> <hr>

                                                @endif
                                            @endforeach
                                        @else
                                            <div class="form-row w-100 mx-auto">
                                                <div class="col-12 col-md-2">
                                                    <label for="Class_Society">Date</label>
                                                    <input type="text" class="form-control date" id="event_date_1" name="event_date[]" placeholder="Date..." autocomplete="off">
                                                </div>
                                                <div class="col-12 col-md-2">
                                                    <label for="Class_Society">Time</label>
                                                    <div class="clockpicker">
                                                        <input type="text" class="form-control" id="event_time_1" name="event_time[]" placeholder="Time..." autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-8">
                                                    <label for="Class_Society">Remarks</label>
                                                    <textarea type="text" class="form-control" id="event_remarks_1" name="event_remarks[]" placeholder="Remarks..." autocomplete="off"></textarea>
                                                </div>
                                            </div>
                                        @endif
                                        <hr>
                                    </div>
                                </div>
                                {{-- Buttons(next/prev) --}}
                                <div class="mr-auto ml-auto" >
                                    <div class="d-flex">
                                        <button class="btn btn-info mt-5 w-25 mr-auto" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous </button>
                                        <button class="btn btn-info mt-5 w-25 ml-auto incident_brief" type="button" id="nextBtn" name = "step5" onclick="nextPrev(1)">Next </button>
                                    </div>
                                </div>

                            </div>
                            {{--  Incident in Brief End
                            ========================  --}}




                            {{--  Event Log
                            ========================  --}}
                            {{-- <div class="tab form-group"> --}}



                                {{-- Buttons(next/prev) --}}
                                {{-- <div class="mr-auto ml-auto" >
                                    <div class="d-flex">
                                        <button class="btn btn-info mt-5 w-25 mr-auto" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous </button>
                                        <button class="btn btn-info mt-5 w-25 ml-auto event_log" type="button" id="nextBtn"  onclick="nextPrev(1)">Next </button>
                                        <div class="text-right my-3 ml-2 ">
                                           <a style="text-decoration: none;" class="btn btn-primary text-light add_event_log">Add     More   Event Log</a>
                                         </div>
                                    </div>
                                </div> --}}

                            {{-- </div> --}}
                            {{--  Event Log End
                            ========================  --}}





                            {{--  Event Image Upload
                            ========================  --}}
                            <div class="tab form-group">
                                <h5 class="text-center my-3">Incident Pics</h5>
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <h3>Draw here</h3>
                                        <p>(Click to edit, click outside to stop)</p>
                                    </div>
                                    <div class="col-6  text-center">
                                        @if(isset($incident_image) && $incident_image != '')
                                            <img height = "200" width = "200" src="{{$incident_image}}" alt="">
                                            <p>Click below to edit </p>
                                        @endif
                                    </div>
                                </div>
                                
                                <div id="canvas-editor"></div>
                                <input class="form-control hidden" hidden id="imageEncodedInput" name="imageEncodedInput">

                                {{-- Buttons(next/prev) --}}
                                <div class="mr-auto ml-auto" >
                                    <div class="d-flex">
                                        <button class="btn btn-primary mt-5 w-25 mr-auto " type="button" id="prevBtn" onclick="nextPrev(-1)">Previous </button>
                                        <button class="btn btn-primary mt-5 w-25 ml-auto  event_log" type="button" name = "encode" step = "6" id="nextBtn" onclick="nextPrev(1)">Next </button>
                                    </div>
                                </div>
                            </div>
                            {{--  Event Image Upload
                            ========================  --}}






                            @if(0)
                            {{-- Immediate incident notification And interim update (this step is only visible on shore edit side)
                            ===========================================================  --}}
                            <div class="tab form-group">
                                <h5 class="text-center my-3">Immediate incident notification And interim update</h5>

                                <div class="form-group">
                                    <label for="">Immediate actions to be taken </label>
                                    <textarea class="form-control" name="immediate_actions_to_be_taken" id="" cols="30" rows="10">@if(isset($incident_report->Immediate_actions_to_be_taken) && $incident_report->Immediate_actions_to_be_taken) {{$incident_report->Immediate_actions_to_be_taken}}  @endif</textarea>
                                </div>

                                {{--  'Immediate incident notification And interim update' pdf generation button   --}}
                                <div class="text-center"><a href="/incident-pdf-immediate-incident-notification-and-interim-update/{{$data_id}}" class="btn btn-primary">Generate PDF !</a></div>


                                {{-- Buttons(next/prev) --}}
                                <div class="mr-auto ml-auto" >
                                    <div class="d-flex">
                                        <button class="btn btn-primary mt-5 w-25 mr-auto " type="button" id="prevBtn" onclick="nextPrev(-1)">Previous </button>
                                        <button class="btn btn-primary mt-5 w-25 ml-auto  event_log" type="button" name = "encode" id="nextBtn" onclick="nextPrev(1)">Next </button>
                                    </div>
                                </div>
                            </div>
                            {{-- Immediate incident notification And interim update End
                            ================================================================  --}}
                            @endif


                            {{--  INCIDENT INVESTIGATION AND ROOT CAUSE FINDINGS
                            ==============================================================  --}}
                            <div class="tab form-group">

                                <h5 class="text-center my-3">INCIDENT INVESTIGATION AND ROOT CAUSE FINDINGS</h5>


                                {{--  Event Details
                                ==================================  --}}
                                <div class="form-group ">
                                    <a style="text-decoration:none;" id="Add_more_event_investigation_btn" class="btn btn-primary text-light float-right my-3">+</a>
                                    {{-- <label for="Event_Details_IIARCF">Event Details</label> --}}
                                    <div id="Add_more_event_investigation">
                                    @if (isset($incident_reports_event_details))
                                        @foreach ( $incident_reports_event_details as $dt )

                                            <textarea type="text"   class="form-control my-2" id="Event_Details_IIARCF_{{$loop->iteration}}" name="Event_Details_IIARCF[]" placeholder="Event Details..." autocomplete="off">{{$dt->details}}</textarea>
                                        @endforeach
                                    @else

                                        <textarea type="text"   class="form-control my-2" id="Event_Details_IIARCF_1" name="Event_Details_IIARCF[]" placeholder="Event Details..." autocomplete="off"> </textarea>
                                    @endif
                                    </div>
                                </div>

                                {{-- Risk Category
                                =================== --}}
                                <div class="form-group ">
                                    <label for="Risk_category_IIARCF">Risk Category</label>
                                    <!-- <select class="form-control" id="Risk_category_IIARCF" name="Risk_category_IIARCF">
                                        <option selected disabled hidden >Select Risk Category....</option>
                                        <option value="SAFETY">SAFETY</option>
                                        <option value="HEALTH">HEALTH</option>
                                        <option value="ENVIRONMENT">ENVIRONMENT</option>
                                        <option value="OPERATIONAL IMPACT">OPERATIONAL IMPACT</option>
                                        <option value="MEDIA">MEDIA</option>
                                    </select> -->
                                    <select class="form-control" id="Risk_category_IIARCF" name="Risk_category_IIARCF">
                                        @if(isset($incident_report->risk_category) && $incident_report->risk_category)
                                            <option selected  hidden value="{{$incident_report->risk_category}}">{{$incident_report->risk_category}}</option>
                                        @else
                                            <option selected  hidden value=""></option>
                                        @endif
                                        <option value="SAFETY">SAFETY</option>
                                        <option value="HEALTH">HEALTH</option>
                                        <option value="ENVIRONMENT">ENVIRONMENT</option>
                                        <option value="OPERATIONAL IMPACT">OPERATIONAL IMPACT</option>
                                        <option value="MEDIA">MEDIA</option>
                                    </select>
                                </div>

                                {{-- ----------------------- inputs that are shown if Risk Category selected -------------------- --}}

                                {{-- SAFETY --}}
                                <div class="card p-5 shadow" id="SAFETY_display_control" @if(isset($incident_report->risk_category) &&  $incident_report->risk_category == 'SAFETY') style="display: block;" @else style="display: none;" @endif >
                                    <h3 class="text-center mt-5">SAFETY</h3>

                                    {{-- first dropdown --}}
                                    <div class="form-group">
                                        <label for=""></label>
                                        <!-- <select class="form-control custom px-5" name="IIARCF_safety_first_dropdown" id="IIARCF_safety_first_dropdown">
                                            <option disabled selected hidden>Select</option>
                                            <option value="Multiple Fatalities">Multiple Fatalities</option>
                                            <option value="Single Fatality/Severe permanent partial disability">Single Fatality/Severe permanent partial disability</option>
                                            <option value="Lost Time Injury / Moderate permanent partial disability">Lost Time Injury / Moderate permanent partial disability</option>
                                            <option value="Restricted work case">Restricted work case</option>
                                            <option value="Multiple Fatalities">First aid case/Medical treatment case</option>
                                        </select> -->
                                        <select class="form-control custom px-5" name="IIARCF_safety_first_dropdown" id="IIARCF_safety_first_dropdown">
                                            @if(isset($incident_reports_risk_details->risk) && $incident_reports_risk_details->risk)
                                                <option  selected hidden value="{{$incident_reports_risk_details->risk}}" >  {{$incident_reports_risk_details->risk}}</option>
                                            @else
                                                <option  selected hidden disabled >Select ...</option>
                                            @endif
                                            <option value="Multiple Fatalities">Multiple Fatalities</option>
                                            <option value="Single Fatality/Severe permanent partial disability">Single Fatality/Severe permanent partial disability</option>
                                            <option value="Lost Time Injury / Moderate permanent partial disability">Lost Time Injury / Moderate permanent partial disability</option>
                                            <option value="Restricted work case">Restricted work case</option>
                                            <option value="Multiple Fatalities">First aid case/Medical treatment case</option>
                                        </select>
                                    </div>

                                    {{-- swvwarty and  likelihood --}}
                                    <div class="form-row">
                                        {{-- Severity --}}
                                        <div class="col-6">
                                            <label for="IIARCF_safety_Severity">Severity</label>
                                            <!-- <select class="form-control custom" name="IIARCF_safety_Severity" id="IIARCF_safety_Severity">
                                                <option disabled selected hidden>Select Severity...</option>
                                                <option value="VERY LOW 1">VERY LOW 1</option>
                                                <option value="LOW 2">LOW 2</option>
                                                <option value="MODERATE 3">MODERATE 3</option>
                                                <option value="HIGH 4">HIGH 4</option>
                                                <option value="VERY HIGH 5">VERY HIGH 5</option>
                                            </select> -->
                                            <select class="form-control custom" name="IIARCF_safety_Severity" id="IIARCF_safety_Severity">
                                                @if(isset($incident_reports_risk_details->severity) && $incident_reports_risk_details->severity)
                                                    <option  selected hidden  value="{{$incident_reports_risk_details->severity}}" > {{$incident_reports_risk_details->severity}}</option>
                                                @else
                                                    <option  selected hidden disabled >Select ...</option>
                                                @endif
                                                <option value="VERY LOW 1">VERY LOW 1</option>
                                                <option value="LOW 2">LOW 2</option>
                                                <option value="MODERATE 3">MODERATE 3</option>
                                                <option value="HIGH 4">HIGH 4</option>
                                                <option value="VERY HIGH 5">VERY HIGH 5</option>
                                            </select>
                                        </div>
                                        {{-- Likelihod --}}
                                        <div class="col-6">
                                            <label for="IIARCF_safety_Severity">Likelihood</label>
                                            <!-- <select class="form-control custom" name="IIARCF_safety_Likelihood" id="IIARCF_safety_Likelihood">
                                                <option disabled selected hidden>Select Likelihood...</option>
                                                <option value="RARE 1">RARE 1</option>
                                                <option value="UNLIKELY 2">UNLIKELY 2</option>
                                                <option value="POSSIBLE 3">POSSIBLE 3</option>
                                                <option value="LIKELY 4">LIKELY 4</option>
                                                <option value="ALMOST CERTAIN 5">ALMOST CERTAIN 5</option>
                                            </select> -->
                                            <select class="form-control custom" name="IIARCF_safety_Likelihood" id="IIARCF_safety_Likelihood">
                                                @if(isset($incident_reports_risk_details->likelihood) && $incident_reports_risk_details->likelihood)
                                                    <option  selected hidden value="{{$incident_reports_risk_details->likelihood}}">{{$incident_reports_risk_details->likelihood}}</option>
                                                @else
                                                    <option  selected hidden disabled >Select ...</option>
                                                @endif
                                                <option value="RARE 1">RARE 1</option>
                                                <option value="UNLIKELY 2">UNLIKELY 2</option>
                                                <option value="POSSIBLE 3">POSSIBLE 3</option>
                                                <option value="LIKELY 4">LIKELY 4</option>
                                                <option value="ALMOST CERTAIN 5">ALMOST CERTAIN 5</option>
                                            </select>
                                        </div>

                                    </div>

                                    {{-- Result --}}
                                    <div class="form-group">
                                        <label for="IIARCF_safety_Result"> Result</label>
                                        
                                        @if(isset($incident_reports_risk_details->result) && $incident_reports_risk_details->result)
                                            <textarea readonly type="text" class="form-control custom" name="IIARCF_safety_Result" id="IIARCF_safety_Result">{{$incident_reports_risk_details->result}}</textarea>
                                        @else
                                            <textarea readonly type="text" class="form-control custom" name="IIARCF_safety_Result" id="IIARCF_safety_Result"></textarea>
                                        @endif
                                    </div>

                                    {{-- Name of the person --}}
                                    <div class="form-group">
                                        <label for="">Name of the person</label>
                                        <!-- <input class="form-control custom" type="text" name="IIARCF_safety_NameOfThePerson" id="IIARCF_safety_NameOfThePerson"> -->
                                        @if(isset($incident_reports_risk_details->name_of_person) && $incident_reports_risk_details->name_of_person)
                                            <input class="form-control custom" type="text" name="IIARCF_safety_NameOfThePerson" id="IIARCF_safety_NameOfThePerson" value="{{$incident_reports_risk_details->name_of_person}}">
                                        @else
                                            <input value="" class="form-control custom" type="text" name="IIARCF_safety_NameOfThePerson" id="IIARCF_safety_NameOfThePerson" >
                                        @endif
                                    </div>

                                    {{-- Type of injury --}}
                                    <div class="form-group">
                                        <label for="">Type of injury</label>
                                        <!-- <input class="form-control custom" type="text" name="IIARCF_safety_TypeOfInjury" id="IIARCF_safety_TypeOfInjury"> -->
                                        @if(isset($incident_reports_risk_details->type_of_injury) && $incident_reports_risk_details->type_of_injury)
                                            <input class="form-control custom" type="text" name="IIARCF_safety_TypeOfInjury" id="IIARCF_safety_TypeOfInjury" value="{{$incident_reports_risk_details->type_of_injury}}">
                                        @else
                                            <input value="" class="form-control custom" type="text" name="IIARCF_safety_TypeOfInjury" id="IIARCF_safety_TypeOfInjury" >
                                        @endif
                                    </div>

                                    {{-- Associated Cost --}}
                                    <div class="form-row">
                                        {{-- USD --}}
                                        <div class="col-4">
                                            <label for="">Associated cost</label>
                                            <!-- <input class="form-control custom" min="0" type="number" name="IIARCF_safety_AssociatedCost" id="IIARCF_safety_AssociatedCost" placeholder="USD..."> -->
                                            <input
                                            @if (isset($incident_reports_risk_details->associated_cost_usd) )
                                            value="{{$incident_reports_risk_details->associated_cost_usd}}"
                                            @else
                                            value=""
                                            @endif
                                            class="form-control custom" type="number" name="IIARCF_safety_AssociatedCost" id="IIARCF_safety_AssociatedCost" placeholder="USD...">
                                            <p class="associated_cost_err_msg">Please enter valid cost ( minimum cost is 0 )</p>
                                        </div>
                                        {{-- country list --}}
                                        <div class="form-group col-4">
                                            <label for="selected_currency_safety">Select Currency</label>
                                            <select class="form-control custom" id="selected_currency_safety" name="selected_currency_safety">
                                                @if (isset($incident_reports_risk_details->currency_code))
                                                <option selected value="{{$incident_reports_risk_details->currency_code}}" >{{$incident_reports_risk_details->currency_code}}</option>
                                                @else
                                                <option selected disabled value="" >Select Currency....</option>
                                                @endif

                                                @foreach ($country_list as $country)
                                                <option value="{{$country->currency_code}}">{{$country->currency_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{-- local Currency --}}
                                        <div class="col-4">
                                            <label for="" class="mb-3">Local Amount</label>
                                            <!-- <input class="form-control custom" type="number" name="IIARCF_safety_localCurrency" id="IIARCF_safety_localCurrency" placeholder="Amount..." min="0"> -->
                                            <input
                                            @if (isset($incident_reports_risk_details->associated_cost_loca))
                                            value="{{$incident_reports_risk_details->associated_cost_loca}}"
                                            @else
                                            value=""
                                            @endif
                                            class="form-control custom" type="number" name="IIARCF_safety_localCurrency" id="IIARCF_safety_localCurrency" placeholder="Amount...">
                                            <p class="local_cost_err_msg">Please enter valid cost ( minimum cost is 0 )</p>
                                        </div>
                                    </div>

                                </div>

                                {{-- HEALTH --}}
                                <!-- <div class="card p-5 shadow" id="HEALTH_display_control" style="display: none;" > -->
                                <div class="card p-5 shadow" id="HEALTH_display_control" @if(isset($incident_report->risk_category) && $incident_report->risk_category == 'HEALTH') style="display: block;" @else style="display: none;" @endif >
                                    <h3 class="text-center mt-5">HEALTH</h3>

                                    {{-- first dropdown --}}
                                    <div class="form-group">
                                        <label for=""></label>
                                        <!-- <select class="form-control custom px-5" name="IIARCF_HEALTH_first_dropdown" id="IIARCF_HEALTH_first_dropdown">
                                            <option disabled selected hidden>Select</option>
                                            <option value="Multiple health related fatalities">Multiple health related fatalities</option>
                                            <option value="Single health related fatality">Single health related fatality</option>
                                            <option value="Health Repatriation Case">Health Repatriation Case</option>
                                            <option value="Health Medical Treatment Case">Health Medical Treatment Case</option>
                                            <option value="Health Treatment  Onboard Case / Potential  Occupational Health Incident"> Health Treatment  Onboard Case / Potential  Occupational Health Incident </option>
                                        </select> -->
                                        <select class="form-control custom px-5" name="IIARCF_HEALTH_first_dropdown" id="IIARCF_HEALTH_first_dropdown">
                                            @if(isset($incident_reports_risk_details->risk) && $incident_reports_risk_details->risk)
                                                <option  selected hidden value="{{$incident_reports_risk_details->risk}}">{{$incident_reports_risk_details->risk}}</option>
                                            @else
                                                <option  selected hidden disabled>Select ...</option>
                                            @endif
                                            <option value="Multiple health related fatalities">Multiple health related fatalities</option>
                                            <option value="Single health related fatality">Single health related fatality</option>
                                            <option value="Health Repatriation Case">Health Repatriation Case</option>
                                            <option value="Health Medical Treatment Case">Health Medical Treatment Case</option>
                                            <option value="Health Treatment  Onboard Case / Potential  Occupational Health Incident"> Health Treatment  Onboard Case / Potential  Occupational Health Incident </option>
                                        </select>
                                    </div>

                                    {{-- swvwarty and  likelihood --}}
                                    <div class="form-row">
                                        {{-- Severity --}}
                                        <div class="col-6">
                                            <label for="IIARCF_HEALTH_Severity">Severity</label>
                                            <!-- <select class="form-control custom" name="IIARCF_HEALTH_Severity" id="IIARCF_HEALTH_Severity">
                                                <option disabled selected hidden>Select Severity...</option>
                                                <option value="VERY LOW 1">VERY LOW 1</option>
                                                <option value="LOW 2">LOW 2</option>
                                                <option value="MODERATE 3">MODERATE 3</option>
                                                <option value="HIGH 4">HIGH 4</option>
                                                <option value="VERY HIGH 5">VERY HIGH 5</option>
                                            </select> -->
                                            <select class="form-control custom" name="IIARCF_HEALTH_Severity" id="IIARCF_HEALTH_Severity">
                                                @if(isset($incident_reports_risk_details->severity) && $incident_reports_risk_details->severity)
                                                    <option  selected hidden value="{{$incident_reports_risk_details->severity}}">{{$incident_reports_risk_details->severity}}</option>
                                                @else
                                                    <option  selected hidden disabled>Select ...</option>
                                                @endif
                                                <option value="VERY LOW 1">VERY LOW 1</option>
                                                <option value="LOW 2">LOW 2</option>
                                                <option value="MODERATE 3">MODERATE 3</option>
                                                <option value="HIGH 4">HIGH 4</option>
                                                <option value="VERY HIGH 5">VERY HIGH 5</option>
                                            </select>
                                        </div>
                                        {{-- Likelihod --}}
                                        <div class="col-6">
                                            <label for="IIARCF_HEALTH_Severity">Likelihood</label>
                                            <!-- <select class="form-control custom" name="IIARCF_HEALTH_Likelihood" id="IIARCF_HEALTH_Likelihood">
                                                <option disabled selected hidden>Select Likelihood...</option>
                                                <option value="RARE 1">RARE 1</option>
                                                <option value="UNLIKELY 2">UNLIKELY 2</option>
                                                <option value="POSSIBLE 3">POSSIBLE 3</option>
                                                <option value="LIKELY 4">LIKELY 4</option>
                                                <option value="ALMOST CERTAIN 5">ALMOST CERTAIN 5</option>
                                            </select> -->
                                            <select class="form-control custom" name="IIARCF_HEALTH_Likelihood" id="IIARCF_HEALTH_Likelihood">
                                                @if(isset($incident_reports_risk_details->likelihood) && $incident_reports_risk_details->likelihood)
                                                    <option  selected hidden value="{{$incident_reports_risk_details->likelihood}}">{{$incident_reports_risk_details->likelihood}}</option>
                                                @else
                                                    <option  selected hidden disabled>Select ...</option>
                                                @endif
                                                <option value="RARE 1">RARE 1</option>
                                                <option value="UNLIKELY 2">UNLIKELY 2</option>
                                                <option value="POSSIBLE 3">POSSIBLE 3</option>
                                                <option value="LIKELY 4">LIKELY 4</option>
                                                <option value="ALMOST CERTAIN 5">ALMOST CERTAIN 5</option>
                                            </select>
                                        </div>

                                    </div>

                                    {{-- Result --}}
                                    <div class="form-group">
                                        <label for="IIARCF_HEALTH_Result"> Result</label>
                                        <!-- <textarea class="form-control custom" name="IIARCF_HEALTH_Result" id="IIARCF_HEALTH_Result" disabled="disabled"></textarea> -->
                                        @if(isset($incident_reports_risk_details->result) && $incident_reports_risk_details->result)
                                            <textarea readonly type="text" class="form-control custom" name="IIARCF_HEALTH_Result" id="IIARCF_HEALTH_Result">{{$incident_reports_risk_details->result}}</textarea>
                                        @else
                                            <textarea readonly type="text" class="form-control custom" name="IIARCF_HEALTH_Result" id="IIARCF_HEALTH_Result"></textarea>
                                        @endif
                                        <button class="btn btn-primary ml-30 mt-5 w-15" type="button" data-toggle="modal" data-target="#view_matrix_risk">View Matrix</button>
                                    </div>

                                    {{-- Name of the person --}}
                                    <div class="form-group">
                                        <label for="">Name of the person</label>
                                        <!-- <input class="form-control custom" type="text" name="IIARCF_HEALTH_NameOfThePerson" id="IIARCF_HEALTH_NameOfThePerson"> -->
                                        @if(isset($incident_reports_risk_details->name_of_person) && $incident_reports_risk_details->name_of_person)
                                            <input class="form-control custom" type="text" name="IIARCF_HEALTH_NameOfThePerson" id="IIARCF_HEALTH_NameOfThePerson" value="{{$incident_reports_risk_details->name_of_person}}">
                                        @else
                                            <input value="" class="form-control custom" type="text" name="IIARCF_HEALTH_NameOfThePerson" id="IIARCF_HEALTH_NameOfThePerson" >
                                        @endif
                                    </div>

                                    {{-- Type of injury --}}
                                    <div class="form-group">
                                        <label for="">Type of injury</label>
                                        <!-- <input class="form-control custom" type="text" name="IIARCF_HEALTH_TypeOfInjury" id="IIARCF_HEALTH_TypeOfInjury"> -->
                                        @if(isset($incident_reports_risk_details->type_of_injury) && $incident_reports_risk_details->type_of_injury)
                                            <input class="form-control custom" type="text" name="IIARCF_HEALTH_TypeOfInjury" id="IIARCF_HEALTH_TypeOfInjury" value="{{$incident_reports_risk_details->type_of_injury}}">
                                        @else
                                            <input value="" class="form-control custom" type="text" name="IIARCF_HEALTH_TypeOfInjury" id="IIARCF_HEALTH_TypeOfInjury" >
                                        @endif
                                    </div>

                                    {{-- Associated Cost --}}
                                    <div class="form-row">
                                        {{-- USD --}}
                                        <div class="col-4">
                                            <label for="">Associated cost</label>
                                            <!-- <input class="form-control custom" min="0" type="number" name="IIARCF_HEALTH_AssociatedCost" id="IIARCF_HEALTH_AssociatedCost" placeholder="USD..."> -->
                                            <input
                                            @if (isset($incident_reports_risk_details->associated_cost_usd))
                                                value="{{$incident_reports_risk_details->associated_cost_usd}}"
                                            @else
                                                value=""
                                            @endif
                                            class="form-control custom" type="number" name="IIARCF_HEALTH_AssociatedCost" id="IIARCF_HEALTH_AssociatedCost" placeholder="USD...">
                                            <p class="associated_cost_err_msg">Please enter valid cost ( minimum cost is 0 )</p>
                                        </div>
                                        {{-- country list --}}
                                        <div class="form-group col-4">
                                            <label for="selected_currency_health">Select Currency</label>
                                            <!-- <select class="form-control custom" id="selected_currency_health" name="selected_currency_health">
                                                <option selected disabled hidden >Select Currency....</option>
                                                @foreach ($country_list as $country)
                                                <option value="{{$country->currency_code}}">{{$country->currency_name}}</option>
                                                @endforeach
                                            </select> -->
                                            <select class="form-control custom" id="selected_currency_health" name="selected_currency_health">
                                                @if (isset($incident_reports_risk_details->currency_code))
                                                <option selected value="{{$incident_reports_risk_details->currency_code}}" >{{$incident_reports_risk_details->currency_code}}</option>
                                                @else
                                                <option selected disabled value="" >Select Currency....</option>
                                                @endif

                                                @foreach ($country_list as $country)
                                                <option value="{{$country->currency_code}}">{{$country->currency_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{-- local Currency --}}
                                        <div class="col-4">
                                            <label for="" class="mb-3">Local Amount</label>
                                            <!-- <input class="form-control custom" type="number" name="IIARCF_HEALTH_localCurrency" id="IIARCF_HEALTH_localCurrency" placeholder="Amount..." min="0"> -->
                                            <input
                                            @if (isset($incident_reports_risk_details->associated_cost_loca))
                                                value="{{$incident_reports_risk_details->associated_cost_loca}}"
                                            @else
                                                value=""
                                            @endif
                                            class="form-control custom" type="number" name="IIARCF_HEALTH_localCurrency" id="IIARCF_HEALTH_localCurrency" placeholder="Amount..." min="0">
                                            <p class="local_cost_err_msg">Please enter valid cost ( minimum cost is 0 )</p>
                                        </div>
                                    </div>

                                </div>

                                {{-- ENVIRONMENT --}}
                                <!-- <div class="card p-5 shadow" id="ENVIRONMENT_display_control" style="display: none;" > -->
                                <div class="card p-5 shadow" id="ENVIRONMENT_display_control" @if(isset($incident_report->risk_category) && $incident_report->risk_category == 'ENVIRONMENT') style="display: block;" @else style="display: none;" @endif>
                                    <h3 class="text-center mt-5">ENVIRONMENT</h3>

                                    {{-- first dropdown --}}
                                    <div class="form-group">
                                        <label for=""></label>
                                        <!-- <select class="form-control custom px-5" name="IIARCF_ENVIRONMENT_first_dropdown" id="IIARCF_ENVIRONMENT_first_dropdown">
                                            <option disabled selected hidden>Select</option>
                                            <option value="Long term impact, severe impact on sensitive area, widespread effect, lasting impairment of ecosystem">Long term impact, severe impact on sensitive area, widespread effect, lasting impairment of ecosystem</option>
                                            <option value="Medium to long term effect / large area affected some impairment of ecosystem">Medium to long term effect / large area affected some impairment of ecosystem</option>
                                            <option value="Short to medium term impact, local area affected, no effect on ecosystem">Short to medium term impact, local area affected, no effect on ecosystem</option>
                                            <option value="Temporary effect / Minor effect to small area">Temporary effect / Minor effect to small area</option>
                                            <option value="Low impact with no lasting effect, minimal area exposed">Low impact with no lasting effect, minimal area exposed </option>
                                        </select> -->
                                        <select class="form-control custom px-5" name="IIARCF_ENVIRONMENT_first_dropdown" id="IIARCF_ENVIRONMENT_first_dropdown">
                                            @if(isset($incident_reports_risk_details->risk) && $incident_reports_risk_details->risk)
                                                <option  selected hidden value="{{$incident_reports_risk_details->risk}}">{{$incident_reports_risk_details->risk}}</option>
                                            @else
                                                <option  selected hidden disabled>Select ...</option>
                                            @endif
                                            <option value="Long term impact, severe impact on sensitive area, widespread effect, lasting impairment of ecosystem">Long term impact, severe impact on sensitive area, widespread effect, lasting impairment of ecosystem</option>
                                            <option value="Medium to long term effect / large area affected some impairment of ecosystem">Medium to long term effect / large area affected some impairment of ecosystem</option>
                                            <option value="Short to medium term impact, local area affected, no effect on ecosystem">Short to medium term impact, local area affected, no effect on ecosystem</option>
                                            <option value="Temporary effect / Minor effect to small area">Temporary effect / Minor effect to small area</option>
                                            <option value="Low impact with no lasting effect, minimal area exposed">Low impact with no lasting effect, minimal area exposed </option>
                                        </select>
                                    </div>

                                    {{-- swvwarty and  likelihood --}}
                                    <div class="form-row">
                                        {{-- Severity --}}
                                        <div class="col-6">
                                            <label for="IIARCF_ENVIRONMENT_Severity">Severity</label>
                                            <!-- <select class="form-control custom" name="IIARCF_ENVIRONMENT_Severity" id="IIARCF_ENVIRONMENT_Severity">
                                                <option disabled selected hidden>Select Severity...</option>
                                                <option value="VERY LOW 1">VERY LOW 1</option>
                                                <option value="LOW 2">LOW 2</option>
                                                <option value="MODERATE 3">MODERATE 3</option>
                                                <option value="HIGH 4">HIGH 4</option>
                                                <option value="VERY HIGH 5">VERY HIGH 5</option>
                                            </select> -->
                                            <select class="form-control custom" name="IIARCF_ENVIRONMENT_Severity" id="IIARCF_ENVIRONMENT_Severity">
                                                @if(isset($incident_reports_risk_details->severity) && $incident_reports_risk_details->severity)
                                                    <option  selected hidden value="{{$incident_reports_risk_details->severity}}">{{$incident_reports_risk_details->severity}}</option>
                                                @else
                                                    <option  selected hidden disabled>Select ...</option>
                                                @endif
                                                <option value="VERY LOW 1">VERY LOW 1</option>
                                                <option value="LOW 2">LOW 2</option>
                                                <option value="MODERATE 3">MODERATE 3</option>
                                                <option value="HIGH 4">HIGH 4</option>
                                                <option value="VERY HIGH 5">VERY HIGH 5</option>
                                            </select>
                                        </div>
                                        {{-- Likelihod --}}
                                        <div class="col-6">
                                            <label for="IIARCF_ENVIRONMENT_Severity">Likelihood</label>
                                            <!-- <select class="form-control custom" name="IIARCF_ENVIRONMENT_Likelihood" id="IIARCF_ENVIRONMENT_Likelihood">
                                                <option disabled selected hidden>Select Likelihood...</option>
                                                <option value="RARE 1">RARE 1</option>
                                                <option value="UNLIKELY 2">UNLIKELY 2</option>
                                                <option value="POSSIBLE 3">POSSIBLE 3</option>
                                                <option value="LIKELY 4">LIKELY 4</option>
                                                <option value="ALMOST CERTAIN 5">ALMOST CERTAIN 5</option>
                                            </select> -->
                                            <select class="form-control custom" name="IIARCF_ENVIRONMENT_Likelihood" id="IIARCF_ENVIRONMENT_Likelihood">
                                                @if(isset($incident_reports_risk_details->likelihood) && $incident_reports_risk_details->likelihood)
                                                    <option  selected hidden value="{{$incident_reports_risk_details->likelihood}}">{{$incident_reports_risk_details->likelihood}}</option>
                                                @else
                                                    <option  selected hidden disabled>Select ...</option>
                                                @endif
                                                <option value="RARE 1">RARE 1</option>
                                                <option value="UNLIKELY 2">UNLIKELY 2</option>
                                                <option value="POSSIBLE 3">POSSIBLE 3</option>
                                                <option value="LIKELY 4">LIKELY 4</option>
                                                <option value="ALMOST CERTAIN 5">ALMOST CERTAIN 5</option>
                                            </select>
                                        </div>

                                    </div>

                                    {{-- Result --}}
                                    <div class="form-group">
                                        <label for="IIARCF_ENVIRONMENT_Result">Result </label>
                                        @if(isset($incident_reports_risk_details->result))
                                            <textarea readonly type="text" autocomplete="off" class="form-control custom" name="IIARCF_ENVIRONMENT_Result" id="IIARCF_ENVIRONMENT_Result">{{$incident_reports_risk_details->result}}</textarea>
                                        @else
                                            <textarea readonly type="text" class="form-control custom" name="IIARCF_ENVIRONMENT_Result" id="IIARCF_ENVIRONMENT_Result"></textarea>
                                        @endif
                                        <button class="btn btn-primary ml-30 mt-5 w-15" type="button" data-toggle="modal" data-target="#view_matrix_risk">View Matrix</button>
                                    </div>

                                    {{-- Type of pollution --}}
                                    <div class="form-group">
                                        <label for="">Type of pollution</label>
                                        <!-- <input class="form-control custom" type="text" name="IIARCF_ENVIRONMENT_TypeOfPollution" id="IIARCF_ENVIRONMENT_TypeOfPollution"> -->
                                        @if(isset($incident_reports_risk_details->type_of_pollution) && $incident_reports_risk_details->type_of_pollution)
                                            <input class="form-control custom" type="text" name="IIARCF_ENVIRONMENT_TypeOfPollution" id="IIARCF_ENVIRONMENT_TypeOfPollution" value="{{$incident_reports_risk_details->type_of_pollution}}">
                                        @else
                                            <input value="" class="form-control custom" type="text" name="IIARCF_ENVIRONMENT_TypeOfPollution" id="IIARCF_ENVIRONMENT_TypeOfPollution" >
                                        @endif
                                    </div>

                                    {{-- Quantity of pollutant --}}
                                    <div class="form-group">
                                        <label for="">Quantity of pollutant</label>
                                        <!-- <input class="form-control custom" type="text" name="IIARCF_ENVIRONMENT_QuantityOfPollutant" id="IIARCF_ENVIRONMENT_QuantityOfPollutantIIARCF_ENVIRONMENT_SpilledInWater"> -->
                                        @if(isset($incident_reports_risk_details->quantity_of_pollutant) && $incident_reports_risk_details->quantity_of_pollutant)
                                            <input class="form-control custom" type="text" name="IIARCF_ENVIRONMENT_QuantityOfPollutant" id="IIARCF_ENVIRONMENT_QuantityOfPollutantIIARCF_ENVIRONMENT_SpilledInWater" value="{{$incident_reports_risk_details->quantity_of_pollutant}}">
                                        @else
                                            <input value="" class="form-control custom" type="text" name="IIARCF_ENVIRONMENT_QuantityOfPollutant" id="IIARCF_ENVIRONMENT_QuantityOfPollutantIIARCF_ENVIRONMENT_SpilledInWater" >
                                        @endif
                                    </div>

                                    {{-- Associated Cost --}}
                                    <div class="form-row">
                                        {{-- USD --}}
                                        <div class="col-4">
                                            <label for="">Associated cost</label>
                                            <!-- <input class="form-control custom" min="0" type="number" name="IIARCF_ENVIRONMENT_AssociatedCost" id="IIARCF_ENVIRONMENT_AssociatedCost" placeholder="USD..."> -->
                                            <input
                                            @if (isset($incident_reports_risk_details->associated_cost_usd))
                                                value="{{$incident_reports_risk_details->associated_cost_usd}}"
                                            @else
                                                value=""
                                            @endif
                                            class="form-control custom" type="number" name="IIARCF_ENVIRONMENT_AssociatedCost" id="IIARCF_ENVIRONMENT_AssociatedCost" placeholder="USD...">
                                            <p class="associated_cost_err_msg">Please enter valid cost ( minimum cost is 0 )</p>
                                        </div>
                                        {{-- country list --}}
                                        <div class="form-group col-4">
                                            <label for="selected_currency_environment">Select Currency</label>
                                            <!-- <select class="form-control custom" id="selected_currency_environment" name="selected_currency_environment">
                                                <option selected disabled hidden >Select Currency....</option>
                                                @foreach ($country_list as $country)
                                                <option value="{{$country->currency_code}}">{{$country->currency_name}}</option>
                                                @endforeach
                                            </select> -->
                                            <select class="form-control custom" id="selected_currency_environment" name="selected_currency_environment">
                                                @if (isset($incident_reports_risk_details->currency_code))
                                                <option selected value="{{$incident_reports_risk_details->currency_code}}" >{{$incident_reports_risk_details->currency_code}}</option>
                                                @else
                                                <option selected disabled value="" >Select Currency....</option>
                                                @endif

                                                @foreach ($country_list as $country)
                                                <option value="{{$country->currency_code}}">{{$country->currency_name}}</option>
                                                @endforeach

                                        </div>
                                        {{-- local Currency --}}
                                        <div class="col-4">
                                            <label for="" class="mb-3">Local Amount</label>
                                            <!-- <input class="form-control custom" type="number" name="IIARCF_ENVIRONMENT_localCurrency" id="IIARCF_ENVIRONMENT_localCurrency" placeholder="Amount..." min="0"> -->
                                            <input
                                            @if (isset($incident_reports_risk_details->associated_cost_loca))
                                                value="{{$incident_reports_risk_details->associated_cost_loca}}"
                                            @else
                                                value=""
                                            @endif
                                            class="form-control custom" type="number" name="IIARCF_ENVIRONMENT_localCurrency" id="IIARCF_ENVIRONMENT_localCurrency" placeholder="Amount..." min="0">
                                            <p class="local_cost_err_msg">Please enter valid cost ( minimum cost is 0 )</p>
                                        </div>
                                    </div>

                                    {{-- Contained spill and Total Spilled quantity  --}}
                                    <div class="form-row my-3">
                                        <div class="col-6">
                                            <label for="">Contained spill</label>
                                            <!-- <input type="number" placeholder="Contained spill ..." name="IIARCF_ENVIRONMENT_ContainedSpill" class="form-control custom" id="IIARCF_ENVIRONMENT_ContainedSpill"> -->
                                            @if(isset($incident_reports_risk_details->contained_spill) && $incident_reports_risk_details->contained_spill)
                                                <input type="number" placeholder="Contained spill ..." name="IIARCF_ENVIRONMENT_ContainedSpill" class="form-control custom" id="IIARCF_ENVIRONMENT_ContainedSpill" value="{{$incident_reports_risk_details->contained_spill}}">
                                            @else
                                                <input type="number" placeholder="Contained spill ..." name="IIARCF_ENVIRONMENT_ContainedSpill" class="form-control custom" id="IIARCF_ENVIRONMENT_ContainedSpill" value="">
                                            @endif
                                        </div>
                                        <div class="col-6">
                                            <label for="">Total Spilled quantity</label>
                                            <!-- <input type="number" class="form-control custom" placeholder="Total Spilled quantity ..." name="IIARCF_ENVIRONMENT_TotalSpilledQuantity" id="IIARCF_ENVIRONMENT_TotalSpilledQuantity"> -->
                                            @if(isset($incident_reports_risk_details->total_spilled_quantity) && $incident_reports_risk_details->total_spilled_quantity)
                                                <input type="number" class="form-control custom" placeholder="Total Spilled quantity ..." name="IIARCF_ENVIRONMENT_TotalSpilledQuantity" id="IIARCF_ENVIRONMENT_TotalSpilledQuantity" value="{{$incident_reports_risk_details->total_spilled_quantity}}">
                                            @else
                                                <input type="number" class="form-control custom" placeholder="Total Spilled quantity ..." name="IIARCF_ENVIRONMENT_TotalSpilledQuantity" id="IIARCF_ENVIRONMENT_TotalSpilledQuantity" value="">
                                            @endif
                                        </div>
                                    </div>

                                    {{--  Spilled in water and Total Spilled ashore  --}}
                                    <div class="form-row my-3">
                                        <div class="col-6">
                                            <label for="">Spilled in Water</label>
                                            <!-- <input type="number" name="IIARCF_ENVIRONMENT_SpilledInWater" class="form-control custom" id="IIARCF_ENVIRONMENT_SpilledInWater" placeholder="Spilled in Water ..."> -->
                                            @if(isset($incident_reports_risk_details->spilled_in_water) && $incident_reports_risk_details->spilled_in_water)
                                                <input type="number" name="IIARCF_ENVIRONMENT_SpilledInWater" class="form-control custom" id="IIARCF_ENVIRONMENT_SpilledInWater" placeholder="Spilled in Water ..." value="{{$incident_reports_risk_details->spilled_in_water}}">
                                            @else
                                                <input type="number" name="IIARCF_ENVIRONMENT_SpilledInWater" class="form-control custom" id="IIARCF_ENVIRONMENT_SpilledInWater" placeholder="Spilled in Water ..." value="">
                                            @endif
                                        </div>
                                        <div class="col-6">
                                            <label for="">Spilled Ashore</label>
                                            <!-- <input type="number" class="form-control custom" placeholder="Spilled Ashore ..." name="IIARCF_ENVIRONMENT_SpilledAshore" id="IIARCF_ENVIRONMENT_SpilledAshore"> -->
                                            @if(isset($incident_reports_risk_details->spilled_ashore) && $incident_reports_risk_details->spilled_ashore)
                                                <input type="number" class="form-control custom" placeholder="Spilled Ashore ..." name="IIARCF_ENVIRONMENT_SpilledAshore" id="IIARCF_ENVIRONMENT_SpilledAshore" value="{{$incident_reports_risk_details->spilled_ashore}}">
                                            @else
                                                <input type="number" class="form-control custom" placeholder="Spilled Ashore ..." name="IIARCF_ENVIRONMENT_SpilledAshore" id="IIARCF_ENVIRONMENT_SpilledAshore">
                                            @endif
                                        </div>
                                    </div>

                                </div>

                                {{-- OPERATIONAL IMPACT --}}
                                <!-- <div class="card p-5 shadow" id="OPERATIONAL_IMPACT_display_control" style="display: none;" > -->
                                <div class="card p-5 shadow" id="OPERATIONAL_IMPACT_display_control" @if(isset($incident_report->risk_category) &&  $incident_report->risk_category == 'OPERATIONAL IMPACT') style="display: block;" @else style="display: none;" @endif>
                                    <h3 class="text-center mt-5">OPERATIONAL IMPACT</h3>

                                    {{-- vessel cargo third party --}}
                                    <div class="form-row">
                                        <div class="col-4">
                                            <label for="">Vessel</label>
                                            <!-- <input type="text" name="IIARCF_OPERATIONAL_IMPACT_Vessel" id="IIARCF_OPERATIONAL_IMPACT_Vessel" class="form-control custom"> -->
                                            @if(isset($incident_reports_risk_details->vessel) && $incident_reports_risk_details->vessel)
                                                <input type="text" value="{{$incident_reports_risk_details->vessel}}" name="IIARCF_OPERATIONAL_IMPACT_Vessel" id="IIARCF_OPERATIONAL_IMPACT_Vessel" class="form-control custom">
                                            @else
                                                <input value="" type="text" name="IIARCF_OPERATIONAL_IMPACT_Vessel" id="IIARCF_OPERATIONAL_IMPACT_Vessel" class="form-control custom">
                                            @endif
                                        </div>
                                        <div class="col-4">
                                            <label for="">Cargo</label>
                                            <!-- <input type="text" name="IIARCF_OPERATIONAL_IMPACT_Cargo" id="IIARCF_OPERATIONAL_IMPACT_Cargo" class="form-control custom"> -->
                                            @if(isset($incident_reports_risk_details->cargo) && $incident_reports_risk_details->cargo)
                                                <input type="text" value="{{$incident_reports_risk_details->cargo}}" name="IIARCF_OPERATIONAL_IMPACT_Cargo" id="IIARCF_OPERATIONAL_IMPACT_Cargo" class="form-control custom">
                                            @else
                                                <input value="" type="text" name="IIARCF_OPERATIONAL_IMPACT_Cargo" id="IIARCF_OPERATIONAL_IMPACT_Cargo" class="form-control custom">
                                            @endif
                                        </div>
                                        <div class="col-4">
                                            <label for="">Third Party</label>
                                            <!-- <input type="text" name="IIARCF_OPERATIONAL_IMPACT_Third_Party" id="IIARCF_OPERATIONAL_IMPACT_Third_Party" class="form-control custom"> -->
                                            @if(isset($incident_reports_risk_details->third_party) && $incident_reports_risk_details->third_party)
                                                <input type="text" value="{{$incident_reports_risk_details->third_party}}" name="IIARCF_OPERATIONAL_IMPACT_Third_Party" id="IIARCF_OPERATIONAL_IMPACT_Third_Party" class="form-control custom">
                                            @else
                                                <input value="" type="text"  name="IIARCF_OPERATIONAL_IMPACT_Third_Party" id="IIARCF_OPERATIONAL_IMPACT_Third_Party" class="form-control custom">
                                            @endif
                                        </div>
                                    </div>

                                    {{-- first dropdown --}}
                                    <div class="form-group">
                                        <label for=""></label>
                                        <!-- <select class="form-control custom px-5" name="IIARCF_OPERATIONAL_IMPACT_first_dropdown" id="IIARCF_OPERATIONAL_IMPACT_first_dropdown">
                                            <option disabled selected hidden>Select</option>
                                            <option value="Very Serious damage or loss to vessel / equipment / cargo resulting in Out of service more than 30 days Direct cost more than 2,000,000 USD">Very Serious damage or loss to vessel / equipment / cargo resulting in Out of service more than 30 days Direct cost more than 2,000,000 USD</option>
                                            <option value="Major damage or loss to vessel / equipment / cargo resulting in Out of service between 15 and 30 days Direct cost between 500,000 and 2,000,000 USD ">Major damage or loss to vessel / equipment / cargo resulting in Out of service between 15 and 30 days Direct cost between 500,000 and 2,000,000 USD </option>
                                            <option value="Mod. Damage or loss to vessel /equipment / cargo resulting in Out of service between 1 and 15 days Direct cost between 200,000 and 500,000 USD">Mod. Damage or loss to vessel /equipment / cargo resulting in Out of service between 1 and 15 days Direct cost between 200,000 and 500,000 USD</option>
                                            <option value="Minor damage or loss to vessel / equipment / cargo resulting in Out of service < 1 day Direct cost between 10,000 and 200,000 USD">Minor damage or loss to vessel / equipment / cargo resulting in Out of service < 1 day Direct cost between 10,000 and 200,000 USD</option>
                                            <option value="Insignificant damage or loss to vessel / equipment / cargo resulting in Direct cost less than 10,000 USD">Insignificant damage or loss to vessel / equipment / cargo resulting in Direct cost less than 10,000 USD</option>
                                        </select> -->
                                        <select class="form-control custom px-5" name="IIARCF_OPERATIONAL_IMPACT_first_dropdown" id="IIARCF_OPERATIONAL_IMPACT_first_dropdown">
                                            @if(isset($incident_reports_risk_details->risk) && $incident_reports_risk_details->risk)
                                                <option  selected hidden value="{{$incident_reports_risk_details->risk}}">{{$incident_reports_risk_details->risk}}</option>
                                            @else
                                                <option  selected hidden disabled >Select ...</option>
                                            @endif
                                            <option value="Very Serious damage or loss to vessel / equipment / cargo resulting in Out of service more than 30 days Direct cost more than 2,000,000 USD">Very Serious damage or loss to vessel / equipment / cargo resulting in Out of service more than 30 days Direct cost more than 2,000,000 USD</option>
                                            <option value="Major damage or loss to vessel / equipment / cargo resulting in Out of service between 15 and 30 days Direct cost between 500,000 and 2,000,000 USD ">Major damage or loss to vessel / equipment / cargo resulting in Out of service between 15 and 30 days Direct cost between 500,000 and 2,000,000 USD </option>
                                            <option value="Mod. Damage or loss to vessel /equipment / cargo resulting in Out of service between 1 and 15 days Direct cost between 200,000 and 500,000 USD">Mod. Damage or loss to vessel /equipment / cargo resulting in Out of service between 1 and 15 days Direct cost between 200,000 and 500,000 USD</option>
                                            <option value="Minor damage or loss to vessel / equipment / cargo resulting in Out of service < 1 day Direct cost between 10,000 and 200,000 USD">Minor damage or loss to vessel / equipment / cargo resulting in Out of service < 1 day Direct cost between 10,000 and 200,000 USD</option>
                                            <option value="Insignificant damage or loss to vessel / equipment / cargo resulting in Direct cost less than 10,000 USD">Insignificant damage or loss to vessel / equipment / cargo resulting in Direct cost less than 10,000 USD</option>
                                        </select>
                                    </div>

                                    {{-- swvwarty and  likelihood --}}
                                    <div class="form-row">
                                        {{-- Severity --}}
                                        <div class="col-6">
                                            <label for="IIARCF_OPERATIONAL_IMPACT_Severity">Severity</label>
                                            <!-- <select class="form-control custom" name="IIARCF_OPERATIONAL_IMPACT_Severity" id="IIARCF_OPERATIONAL_IMPACT_Severity">
                                                <option disabled selected hidden>Select Severity...</option>
                                                <option value="VERY LOW 1">VERY LOW 1</option>
                                                <option value="LOW 2">LOW 2</option>
                                                <option value="MODERATE 3">MODERATE 3</option>
                                                <option value="HIGH 4">HIGH 4</option>
                                                <option value="VERY HIGH 5">VERY HIGH 5</option>
                                            </select> -->
                                            <select class="form-control custom" name="IIARCF_OPERATIONAL_IMPACT_Severity" id="IIARCF_OPERATIONAL_IMPACT_Severity">
                                                @if(isset($incident_reports_risk_details->severity) && $incident_reports_risk_details->severity)
                                                    <option  selected hidden value="{{$incident_reports_risk_details->severity}}">{{$incident_reports_risk_details->severity}}</option>
                                                @else
                                                    <option  selected hidden disabled >Select ...</option>
                                                @endif
                                                <option value="VERY LOW 1">VERY LOW 1</option>
                                                <option value="LOW 2">LOW 2</option>
                                                <option value="MODERATE 3">MODERATE 3</option>
                                                <option value="HIGH 4">HIGH 4</option>
                                                <option value="VERY HIGH 5">VERY HIGH 5</option>
                                            </select>
                                        </div>
                                        {{-- Likelihod --}}
                                        <div class="col-6">
                                            <label for="IIARCF_OPERATIONAL_IMPACT_Severity">Likelihood</label>
                                            <!-- <select class="form-control custom" name="IIARCF_OPERATIONAL_IMPACT_Likelihood" id="IIARCF_OPERATIONAL_IMPACT_Likelihood">
                                                <option disabled selected hidden>Select Likelihood...</option>
                                                <option value="RARE 1">RARE 1</option>
                                                <option value="UNLIKELY 2">UNLIKELY 2</option>
                                                <option value="POSSIBLE 3">POSSIBLE 3</option>
                                                <option value="LIKELY 4">LIKELY 4</option>
                                                <option value="ALMOST CERTAIN 5">ALMOST CERTAIN 5</option>
                                            </select> -->
                                            <select class="form-control custom" name="IIARCF_OPERATIONAL_IMPACT_Likelihood" id="IIARCF_OPERATIONAL_IMPACT_Likelihood">
                                                @if(isset($incident_reports_risk_details->likelihood) && $incident_reports_risk_details->likelihood)
                                                    <option  selected hidden value="{{$incident_reports_risk_details->likelihood}}">{{$incident_reports_risk_details->likelihood}}</option>
                                                @else
                                                    <option  selected hidden disabled >Select ...</option>
                                                @endif
                                                <option value="RARE 1">RARE 1</option>
                                                <option value="UNLIKELY 2">UNLIKELY 2</option>
                                                <option value="POSSIBLE 3">POSSIBLE 3</option>
                                                <option value="LIKELY 4">LIKELY 4</option>
                                                <option value="ALMOST CERTAIN 5">ALMOST CERTAIN 5</option>
                                            </select>
                                        </div>

                                    </div>
                                    {{-- Result --}}
                                    <div class="form-row">
                                    <div class="form-group w-100">
                                        <label for="IIARCF_OPERATIONAL_IMPACT_Result"> Result</label>
                                        @if (isset($incident_reports_risk_details->result) && $incident_reports_risk_details->result)
                                            <textarea readonly type="text" class="form-control custom" name="IIARCF_OPERATIONAL_IMPACT_Result_1" id="IIARCF_OPERATIONAL_IMPACT_Result" disabled="disabled">{{$incident_reports_risk_details->result}}</textarea>
                                                {{-- operational result value fetch in backend ..... --}}
                                                <input type="hidden" name="IIARCF_OPERATIONAL_IMPACT_Result" value="{{$incident_reports_risk_details->result}}"  id="IIARCF_OPERATIONAL_IMPACT_Result_hidden">
                                            @else
                                            <textarea readonly type="text" class="form-control custom" name="IIARCF_OPERATIONAL_IMPACT_Result_1" id="IIARCF_OPERATIONAL_IMPACT_Result" disabled="disabled"></textarea>
                                                {{-- operational result value fetch in backend ..... --}}
                                                <input type="hidden" name="IIARCF_OPERATIONAL_IMPACT_Result" id="IIARCF_OPERATIONAL_IMPACT_Result_hidden" >
                                            @endif
                                        <button class="btn btn-primary ml-30 mt-5 w-15" type="button" data-toggle="modal" data-target="#view_matrix_risk" >View Matrix</button>
                                    </div>
                                    </div>
                                    {{-- Damage description --}}
                                    <div class="form-group">
                                        <label for="IIARCF_OPERATIONAL_IMPACT_Damage_description">Damage description</label>
                                        <!-- <textarea class="form-control custom" placeholder="Damage description ..." name="IIARCF_OPERATIONAL_IMPACT_Damage_description" id="IIARCF_OPERATIONAL_IMPACT_Damage_description"></textarea> -->
                                        @if(isset($incident_reports_risk_details->damage_description) && $incident_reports_risk_details->damage_description)
                                            <textarea type="text" class="form-control custom" placeholder="Damage description ..." name="IIARCF_OPERATIONAL_IMPACT_Damage_description" id="IIARCF_OPERATIONAL_IMPACT_Damage_description">{{$incident_reports_risk_details->damage_description}}</textarea>
                                        @else
                                            <textarea type="text" class="form-control custom" placeholder="Damage description ..." name="IIARCF_OPERATIONAL_IMPACT_Damage_description" id="IIARCF_OPERATIONAL_IMPACT_Damage_description"></textarea>
                                        @endif
                                    </div>

                                    {{-- Off hire if any --}}
                                    <div class="form-group">
                                        <label for="">Off hire if any</label>
                                        <!-- <input class="form-control custom" type="text" name="IIARCF_OPERATIONAL_IMPACT_Off_hire_if_any" id="IIARCF_OPERATIONAL_IMPACT_Off_hire_if_any"> -->
                                        @if(isset($incident_reports_risk_details->off_hire) && $incident_reports_risk_details->off_hire)
                                            <input class="form-control custom" value="{{$incident_reports_risk_details->off_hire}}" type="text" name="IIARCF_OPERATIONAL_IMPACT_Off_hire_if_any" id="IIARCF_OPERATIONAL_IMPACT_Off_hire_if_any">
                                        @else
                                            <input value="" class="form-control custom" type="text" name="IIARCF_OPERATIONAL_IMPACT_Off_hire_if_any" id="IIARCF_OPERATIONAL_IMPACT_Off_hire_if_any">
                                        @endif
                                    </div>


                                    {{-- Associated Cost --}}
                                    <div class="form-row">
                                        {{-- USD --}}
                                        <div class="col-4">
                                            <label for="">Associated cost</label>
                                            <!-- <input class="form-control custom" min="0" type="number" name="IIARCF_OPERATIONAL_IMPACT_AssociatedCost" id="IIARCF_OPERATIONAL_IMPACT_AssociatedCost" placeholder="USD..."> -->
                                            <input
                                            @if (isset($incident_reports_risk_details->associated_cost_usd))
                                                value="{{$incident_reports_risk_details->associated_cost_usd}}"
                                            @else
                                                value=""
                                            @endif
                                            class="form-control custom" type="number" name="IIARCF_OPERATIONAL_IMPACT_AssociatedCost" id="IIARCF_OPERATIONAL_IMPACT_AssociatedCost" placeholder="USD...">
                                            <p class="associated_cost_err_msg">Please enter valid cost ( minimum cost is 0 )</p>
                                        </div>
                                        {{-- country list --}}
                                        <div class="form-group col-4">
                                            <label for="selected_currency_operational_impact">Select Currency</label>
                                            <!-- <select class="form-control custom" id="selected_currency_operational_impact" name="selected_currency_operational_impact">
                                                <option selected disabled hidden >Select Currency....</option>
                                                @foreach ($country_list as $country)
                                                <option value="{{$country->currency_code}}">{{$country->currency_name}}</option>
                                                @endforeach
                                            </select> -->
                                            <select class="form-control custom" id="selected_currency_operational_impact" name="selected_currency_operational_impact">
                                                @if (isset($incident_reports_risk_details->currency_code))
                                                <option selected value="{{$incident_reports_risk_details->currency_code}}" >{{$incident_reports_risk_details->currency_code}}</option>
                                                @else
                                                <option selected disabled value="" >Select Currency....</option>
                                                @endif

                                                @foreach ($country_list as $country)
                                                <option value="{{$country->currency_code}}">{{$country->currency_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{-- local Currency --}}
                                        <div class="col-4">
                                            <label for="" class="mb-3">Local Amount</label>
                                            <!-- <input class="form-control custom" type="number" name="IIARCF_OPERATIONAL_IMPACT_localCurrency" id="IIARCF_OPERATIONAL_IMPACT_localCurrency" placeholder="Amount..." min="0"> -->
                                            <input
                                            @if (isset($incident_reports_risk_details->associated_cost_loca))
                                                value="{{$incident_reports_risk_details->associated_cost_loca}}"
                                            @else
                                                value=""
                                            @endif
                                            class="form-control custom" type="number" name="IIARCF_OPERATIONAL_IMPACT_localCurrency" id="IIARCF_OPERATIONAL_IMPACT_localCurrency" placeholder="Amount..." min="0">
                                            <p class="local_cost_err_msg">Please enter valid cost ( minimum cost is 0 )</p>
                                        </div>
                                    </div>

                                </div>

                                {{-- MEDIA --}}
                                <!-- <div class="card p-5 shadow" id="MEDIA_display_control" style="display: none;" > -->
                                <div class="card p-5 shadow" id="MEDIA_display_control" @if(isset($incident_report->risk_category) && $incident_report->risk_category == 'MEDIA') style="display: block;" @else style="display: none;" @endif>
                                    <h3 class="text-center mt-5">MEDIA</h3>

                                    {{-- first dropdown --}}
                                    <div class="form-group">
                                        <label for=""></label>
                                        <!-- <select class="form-control custom px-5" name="IIARCF_MEDIA_first_dropdown" id="IIARCF_MEDIA_first_dropdown">
                                            <option disabled selected hidden>Select</option>
                                            <option value="International Coverage">International Coverage</option>
                                            <option value="National Coverage">National Coverage</option>
                                            <option value="Regional Coverage">Regional Coverage</option>
                                            <option value="Local Coverage">Local Coverage</option>
                                            <option value="No Coverage">No Coverage</option>
                                        </select> -->
                                        <select class="form-control custom px-5" name="IIARCF_MEDIA_first_dropdown" id="IIARCF_MEDIA_first_dropdown">
                                            @if(isset($incident_reports_risk_details->risk) && $incident_reports_risk_details->risk)
                                                <option  selected hidden value="{{$incident_reports_risk_details->risk}}">{{$incident_reports_risk_details->risk}}</option>
                                            @else
                                                <option  selected hidden disabled >Select ...</option>
                                            @endif
                                            <option value="International Coverage">International Coverage</option>
                                            <option value="National Coverage">National Coverage</option>
                                            <option value="Regional Coverage">Regional Coverage</option>
                                            <option value="Local Coverage">Local Coverage</option>
                                            <option value="No Coverage">No Coverage</option>
                                        </select>
                                    </div>

                                    {{-- Severity and  likelihood --}}
                                    <div class="form-row">
                                        {{-- Severity --}}
                                        <div class="col-6">
                                            <label for="IIARCF_MEDIA_Severity">Severity</label>
                                            <!-- <select class="form-control custom" name="IIARCF_MEDIA_Severity" id="IIARCF_MEDIA_Severity">
                                                <option disabled selected hidden>Select Severity...</option>
                                                <option value="VERY LOW 1">VERY LOW 1</option>
                                                <option value="LOW 2">LOW 2</option>
                                                <option value="MODERATE 3">MODERATE 3</option>
                                                <option value="HIGH 4">HIGH 4</option>
                                                <option value="VERY HIGH 5">VERY HIGH 5</option>
                                            </select> -->
                                            <select class="form-control custom" name="IIARCF_MEDIA_Severity" id="IIARCF_MEDIA_Severity">
                                                @if(isset($incident_reports_risk_details->severity) && $incident_reports_risk_details->severity)
                                                    <option  selected hidden value="{{$incident_reports_risk_details->severity}}">{{$incident_reports_risk_details->severity}}</option>
                                                @else
                                                    <option  selected hidden disabled >Select ...</option>
                                                @endif
                                                <option value="VERY LOW 1">VERY LOW 1</option>
                                                <option value="LOW 2">LOW 2</option>
                                                <option value="MODERATE 3">MODERATE 3</option>
                                                <option value="HIGH 4">HIGH 4</option>
                                                <option value="VERY HIGH 5">VERY HIGH 5</option>
                                            </select>
                                        </div>
                                        {{-- Likelihod --}}
                                        <div class="col-6">
                                            <label for="IIARCF_MEDIA_Severity">Likelihood</label>
                                            <!-- <select class="form-control custom" name="IIARCF_MEDIA_Likelihood" id="IIARCF_MEDIA_Likelihood">
                                                <option disabled selected hidden>Select Likelihood...</option>
                                                <option value="RARE 1">RARE 1</option>
                                                <option value="UNLIKELY 2">UNLIKELY 2</option>
                                                <option value="POSSIBLE 3">POSSIBLE 3</option>
                                                <option value="LIKELY 4">LIKELY 4</option>
                                                <option value="ALMOST CERTAIN 5">ALMOST CERTAIN 5</option>
                                            </select> -->
                                            <select class="form-control custom" name="IIARCF_MEDIA_Likelihood" id="IIARCF_MEDIA_Likelihood">
                                                @if(isset($incident_reports_risk_details->likelihood) && $incident_reports_risk_details->likelihood)
                                                    <option  selected hidden value="{{$incident_reports_risk_details->likelihood}}">{{$incident_reports_risk_details->likelihood}}</option>
                                                @else
                                                    <option  selected hidden disabled >Select ...</option>
                                                @endif
                                                <option value="RARE 1">RARE 1</option>
                                                <option value="UNLIKELY 2">UNLIKELY 2</option>
                                                <option value="POSSIBLE 3">POSSIBLE 3</option>
                                                <option value="LIKELY 4">LIKELY 4</option>
                                                <option value="ALMOST CERTAIN 5">ALMOST CERTAIN 5</option>
                                            </select>
                                        </div>

                                    </div>

                                    {{-- Result --}}
                                    <div class="form-group">
                                        <label for="IIARCF_MEDIA_Result"> Result</label>
                                        @if(isset($incident_reports_risk_details) && $incident_reports_risk_details->result)
                                            <textarea readonly type="text" class="form-control custom" name="IIARCF_MEDIA_Result" id="IIARCF_MEDIA_Result">{{$incident_reports_risk_details->result}}</textarea>
                                        @else
                                            <textarea readonly type="text" class="form-control custom" name="IIARCF_MEDIA_Result" id="IIARCF_MEDIA_Result"></textarea>
                                        @endif
                                        <button class="btn btn-primary ml-30 mt-5 w-15" type="button" data-toggle="modal" data-target="#view_matrix_risk" >View Matrix</button>
                                    </div>

                                    {{-- description --}}
                                    <div class="form-group">
                                        <label for="">Description</label>
                                        @if(isset($incident_reports_risk_details->description) && $incident_reports_risk_details->description)
                                            <textarea  type="text" class="form-control custom" type="text" name="IIARCF_MEDIA_describtion" id="IIARCF_MEDIA_describtion"> {{$incident_reports_risk_details->description}}</textarea>
                                        @else
                                            <textarea type="text" class="form-control custom" type="text" name="IIARCF_MEDIA_describtion" id="IIARCF_MEDIA_describtion"></textarea>
                                        @endif
                                    </div>


                                    {{-- Associated Cost --}}
                                    <div class="form-row">
                                        {{-- USD --}}
                                        <div class="col-4">
                                            <label for="">Associated cost</label>
                                            <!-- <input class="form-control custom" min="0" type="number" name="IIARCF_MEDIA_AssociatedCost" id="IIARCF_MEDIA_AssociatedCost" placeholder="USD..."> -->
                                            <input
                                            @if (isset($incident_reports_risk_details->associated_cost_usd))
                                                value="{{$incident_reports_risk_details->associated_cost_usd}}"
                                            @else
                                                value=""
                                            @endif
                                            class="form-control custom" type="number" name="IIARCF_MEDIA_AssociatedCost" id="IIARCF_MEDIA_AssociatedCost" placeholder="USD...">
                                            <p class="associated_cost_err_msg">Please enter valid cost ( minimum cost is 0 )</p>
                                        </div>
                                        {{-- country list --}}
                                        <div class="form-group col-4">
                                            <label for="selected_currency_media">Select Currency</label>

                                            <select class="form-control custom" id="selected_currency_media" name="selected_currency_media">
                                                @if (isset($incident_reports_risk_details->currency_code))
                                                <option selected value="{{$incident_reports_risk_details->currency_code}}" >{{$incident_reports_risk_details->currency_code}}</option>
                                                @else
                                                <option selected disabled value="" >Select Currency....</option>
                                                @endif

                                                @foreach ($country_list as $country)
                                                <option value="{{$country->currency_code}}">{{$country->currency_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{-- local Currency --}}
                                        <div class="col-4">
                                            <label for="" class="mb-3">Local Amount</label>
                                            <!-- <input class="form-control custom" type="number" name="IIARCF_MEDIA_localCurrency" id="IIARCF_MEDIA_localCurrency" placeholder="Amount..." min="0"> -->
                                            <input
                                            @if (isset($incident_reports_risk_details->associated_cost_loca))
                                                value="{{$incident_reports_risk_details->associated_cost_loca}}"
                                            @else
                                                value=""
                                            @endif
                                            class="form-control custom" type="number" name="IIARCF_MEDIA_localCurrency" id="IIARCF_MEDIA_localCurrency" placeholder="Amount...">
                                            <p class="local_cost_err_msg">Please enter valid cost ( minimum cost is 0 )</p>
                                        </div>
                                    </div>

                                    {{-- type and  text --}}
                                    <div class="form-row">
                                        {{-- type --}}
                                        <div class="col-12">
                                            <label for="IIARCF_MEDIA_Severity">Type</label>
                                            <!-- <select class="form-control custom" name="IIARCF_MEDIA_type" id="IIARCF_MEDIA_type">
                                                <option disabled selected hidden>Select Type...</option>
                                                <option value="VERY LOW 1">Operational</option>
                                                <option value="LOW 2">Personal</option>
                                            </select> -->
                                            <select class="form-control custom" name="IIARCF_MEDIA_type" id="IIARCF_MEDIA_type">
                                                @if(isset($incident_reports_risk_details->type) && $incident_reports_risk_details->type == 'VERY LOW 1')
                                                    <option selected value="{{$incident_reports_risk_details->type}}">Operational</option>
                                                @elseif(isset($incident_reports_risk_details->type)  && $incident_reports_risk_details->type == 'LOW 2')
                                                    <option selected>Personal</option>
                                                @else
                                                    <option selected disabled >Select ...</option>
                                                @endif
                                                <option value="VERY LOW 1">Operational</option>
                                                <option value="LOW 2">Personal</option>
                                            </select>
                                        </div>
                                        {{-- textbox --}}
                                        {{-- <div class="col-6">
                                            <label for="IIARCF_MEDIA_Severity" class="mb-3"></label>
                                            <input type="text" name="IIARCF_MEDIA_type_text" id="IIARCF_MEDIA_type_text" class="form-control">
                                        </div> --}}

                                    </div>


                                </div>
                                    <div class="modal fade" id="view_matrix_risk" style="overflow-X:scroll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-xl"  role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">  Quantitative Risk Matrix</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <img class="img-style" src="/images/RiskMatrix.png" style="width:100%">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                            </div>
                                        </div>
                                   </div>
                                {{-- ----------------------- inputs that are shown if selected end -------------------- --}}

                                 {{-- Dropdown
                                ================================ --}}
                                @foreach ($dropdown as $dd)
                                    @php
                                        $name = str_replace(' ', '', $dd->dropdown_name)
                                    @endphp


                                    @if ( Str::lower($name) == "immediatecause")
                                        <div class="form-row">
                                            {{-- Dropdown 1 --}}
                                            <div class="form-group col-12 my-3">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="inputGroupSelect01"> {{$dd->dropdown_name}} <span class="text-danger   font-weight-bold">*</span> </label>
                                                    </div>

                                                    <select id="{{Str::lower($name)}}" required @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" ) multiple @endif class="custom-select drop" myid="dd{{ $dd->id }}" @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" )  name="{{Str::lower($name)}}_first[]" @else name="{{Str::lower($name)}}_first"  @endif required >
                                                        @if(Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause' )
                                                            <option value=0 disabled selected>Please Select</option>
                                                        @endif
                                                        @foreach ($dropdownmain as $ddmain)

                                                            @if ($ddmain->dropdown_id == $dd->id)
                                                                <option value="{{ $ddmain->id }}">{{ $ddmain->type_main_name }}</option>
                                                            @endif

                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- Dropdown 2 --}}
                                            <div class="form-group col-10 offset-2 my-3" id="display_dd{{ $dd->id }}" style="display: none;">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="inputGroupSelect01">Options</label>
                                                    </div>
                                                    <select @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" ) multiple @endif class="custom-select droptwo"   @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" )  name="{{Str::lower($name)}}_second[]" @else name="{{Str::lower($name)}}_second"  @endif myidtwo="ddd{{ $dd->id }}" id="dd{{ $dd->id }}">
                                                        @if(Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause' )
                                                            <option value=0 disabled selected>Please Select</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- Dropdown 3 --}}
                                            <div class="form-group col-10 offset-2 my-3" id="display_ddd{{ $dd->id }}" style="display: none;">
                                                <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="inputGroupSelect01">Options</label>
                                                </div>
                                                <select @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" ) multiple @endif class="custom-select"  @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" )  name="{{Str::lower($name)}}_third[]" @else name="{{Str::lower($name)}}_third"  @endif id="ddd{{ $dd->id }}">
                                                        @if(Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause' )
                                                            <option value=0 disabled selected>Please Select</option>
                                                        @endif
                                                </select>
                                                </div>
                                            </div>
                                        </div>

                                        @if (isset($incident_reports_immediate_causes->primary))
                                            <div style="color: black">
                                                <h5>Immediate cause First :</h5>
                                                <p style="margin-left: 5%">{{ $incident_reports_immediate_causes->primary }}</p>
                                            </div>
                                        @endif
                                        @if (isset($incident_reports_immediate_causes->secondary))
                                            <div style="color: black">
                                                <h5>Immediate cause Second :</h5>
                                                <p style="margin-left: 5%">{{ $incident_reports_immediate_causes->secondary }}</p>
                                            </div>
                                        @endif
                                        @if (isset($incident_reports_immediate_causes->tertiary))
                                            <div style="color: black">
                                                <h5>Immediate cause Third :</h5>
                                                <p style="margin-left: 5%">{{ $incident_reports_immediate_causes->tertiary }}</p>
                                            </div>
                                        @endif
                                    @endif

                                @endforeach

                                {{-- Buttons(next/prev) --}}
                                <div class="mr-auto ml-auto" >
                                    <div class="d-flex">
                                        <button class="btn btn-info mt-5 w-25 mr-auto" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous </button>
                                        <button class="btn btn-info mt-5 w-25 ml-auto root_cause" type="button" id="nextBtn" name = "step7" onclick="nextPrev(1)">Next </button>
                                    </div>
                                </div>

                            </div>
                            {{--  INCIDENT INVESTIGATION AND ROOT CAUSE FINDINGS End
                            ==============================================================  --}}


                            {{-- SEE 5 WHY
                            ================================================================ --}}
                            <div class="tab form-group">
                                {{-- <h5 class="text-center my-3"> SEE 5 WHY </h5> --}}

                                <h3 class="text-center mt-5">5 Whys</h3>

                                {{-- Incident for 5 why --}}
                                <div class="form-group">
                                    <label for="incident_for_five_why">Incident</label>
                                    <!-- <input type="text" name="incident_for_five_why" id="incident_for_five_why" class="form-control" placeholder="Incident ..."> -->
                                    <input
                                    @if (isset($incident_reports_five_why->incident) && $incident_reports_five_why->incident)
                                    value="{{$incident_reports_five_why->incident}}"
                                    @else
                                    value=""
                                    @endif

                                    type="text" name="incident_for_five_why" id="incident_for_five_why" class="form-control" placeholder="Incident ...">
                                </div>

                                {{-- 1. first why for 5 why --}}
                                <div class="form-group" style="display: block;" id="first_why_for_five_why_display">
                                    <label for="first_why_for_five_why">First why</label>
                                    <input
                                    value=""
                                    type="text" name="first_why_for_five_why" id="first_why_for_five_why" class=" ml-1 form-control" placeholder="First why ...">
                                    <div class="text-right my-1">
                                        <a class="btn btn-primary text-light" id="first_why_for_five_why_display_btn">Why ?</a>
                                    </div>
                                </div>

                                {{-- 2. second why for 5 why --}}
                                <div class="form-group" style="display: none;" id="second_why_for_five_why_display">
                                    <label for="second_why_for_five_why">Second why</label>
                                    <input
                                    value=""
                                    type="text" name="second_why_for_five_why" id="second_why_for_five_why" class="ml-2 form-control" placeholder="Second why ...">
                                    <div class="text-right my-1">
                                        <a class="btn btn-primary text-light" id="second_why_for_five_why_display_btn"> Why ?</a>
                                    </div>
                                </div>

                                {{-- 3. third why for 5 why --}}
                                <div class="form-group" style="display: none;" id="third_why_for_five_why_display">
                                    <label for="third_why_for_five_why">Third why</label>
                                    <input
                                    value=""
                                    type="text" name="third_why_for_five_why" id="third_why_for_five_why" class="ml-3 form-control" placeholder="Third why ...">
                                    <div class="text-right my-1">
                                        <a class="btn btn-primary text-light" id="third_why_for_five_why_display_btn"> Why ?</a>
                                    </div>
                                </div>

                                {{-- 4. fourth why for 5 why --}}
                                <div class="form-group" style="display: none;" id="fourth_why_for_five_why_display">
                                    <label for="fourth_why_for_five_why">Fourth why</label>
                                    <input
                                    value=""
                                    type="text" name="fourth_why_for_five_why" id="fourth_why_for_five_why" class="ml-4 form-control" placeholder="Fourth why ...">
                                    <div class="text-right my-1">
                                        <a class="btn btn-primary text-light" id="fourth_why_for_five_why_display_btn"> Why ?</a>
                                    </div>
                                </div>

                                {{-- 5. fifth why for 5 why --}}
                                <div class="form-group" style="display: none;" id="fifth_why_for_five_why_display">
                                    <label for="fifth_why_for_five_why">Fifth why</label>
                                    <input
                                     value=""
                                    type="text" name="fifth_why_for_five_why" id="fifth_why_for_five_why" class="ml-5 form-control" placeholder="Fifth why ...">
                                </div>

                                {{--  Five Why Preview  --}}
                                @if( isset($incident_reports_five_why->first_why) || isset($incident_reports_five_why->second_why) || isset($incident_reports_five_why->third_why) || isset($incident_reports_five_why->fourth_why) || isset($incident_reports_five_why->fifth_why) )
                                    <h5> Five Why </h5>
                                    <ul>
                                        <li>{{$incident_reports_five_why->first_why}}</li>
                                        <li>{{$incident_reports_five_why->second_why}}</li>
                                        <li>{{$incident_reports_five_why->third_why}}</li>
                                        <li>{{$incident_reports_five_why->fourth_why}}</li>
                                        <li>{{$incident_reports_five_why->fifth_why}}</li>
                                    </ul>
                                @endif


                                {{-- RootCause for 5 why --}}
                                <div class="form-group">
                                    <label for="rootcause_for_five_why">RootCause</label>
                                    <!-- <input type="text" name="rootcause_for_five_why" id="rootcause_for_five_why" class="form-control" placeholder="RootCause ..."> -->
                                    <input
                                    @if (isset($incident_reports_five_why->root_cause) && $incident_reports_five_why->root_cause)
                                    value="{{ $incident_reports_five_why->root_cause }}"
                                    @else
                                    value=""
                                    @endif

                                    type="text" name="rootcause_for_five_why" id="rootcause_for_five_why" class="form-control" placeholder="RootCause ...">
                                </div>



                                {{-- Root causes And Preventive Actions
                                =========================================== --}}
                                @foreach ($dropdown as $dd)
                                    @php
                                        $name = str_replace(' ', '', $dd->dropdown_name)
                                    @endphp
                                    @if ( Str::lower($name) == "rootcauses")
                                        <div class="form-row">
                                            {{-- Dropdown 1 --}}
                                            <div class="form-group col-12 my-3">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="inputGroupSelect01"> {{$dd->dropdown_name}} <span class="text-danger   font-weight-bold">*</span> </label>
                                                    </div>

                                                    <select id="{{Str::lower($name)}}" required

                                                    @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" )

                                                    multiple

                                                    @endif class="custom-select drop"

                                                    myid="dd{{ $dd->id }}"

                                                    @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" )

                                                    name="{{Str::lower($name)}}_first[]"

                                                    @else

                                                    name="{{Str::lower($name)}}_first"

                                                    @endif

                                                    required >
                                                        @if(Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause' )
                                                            <option value=0 disabled selected>Please Select</option>
                                                        @endif
                                                        @foreach ($dropdownmain as $ddmain)

                                                            @if ($ddmain->dropdown_id == $dd->id)
                                                                <option value="{{ $ddmain->id }}">{{ $ddmain->type_main_name }}</option>
                                                            @endif

                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- Dropdown 2 --}}
                                            <div class="form-group col-10 offset-2 my-3" id="display_dd{{ $dd->id }}" style="display: none;">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="inputGroupSelect01">Options</label>
                                                    </div>
                                                    <select @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" ) multiple @endif class="custom-select droptwo"   @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" )  name="{{Str::lower($name)}}_second[]" @else name="{{Str::lower($name)}}_second"  @endif myidtwo="ddd{{ $dd->id }}" id="dd{{ $dd->id }}">
                                                        @if(Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause' )
                                                            <option value=0 disabled selected>Please Select</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- Dropdown 3 --}}
                                            <div class="form-group col-10 offset-2 my-3" id="display_ddd{{ $dd->id }}" style="display: none;">
                                                <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="inputGroupSelect01">Options</label>
                                                </div>
                                                <select @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" ) multiple @endif class="custom-select"  @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" )  name="{{Str::lower($name)}}_third[]" @else name="{{Str::lower($name)}}_third"  @endif id="ddd{{ $dd->id }}">
                                                        @if(Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause' )
                                                            <option value=0 disabled selected>Please Select</option>
                                                        @endif
                                                </select>
                                                </div>
                                            </div>
                                        </div>


                                        @if (isset($incident_reports_root_causes->primary))
                                            <div style="color: black">
                                                <h5>Root Cause's First :</h5>
                                                <p style="margin-left: 5%">{{ $incident_reports_root_causes->primary }}</p>
                                            </div>
                                        @endif
                                        @if (isset($incident_reports_root_causes->secondary))
                                            <div style="color: black">
                                                <h5>Root Cause's Second :</h5>
                                                <p style="margin-left: 5%">{{ $incident_reports_root_causes->secondary }}</p>
                                            </div>
                                        @endif
                                        @if (isset($incident_reports_root_causes->tertiary))
                                            <div style="color: black">
                                                <h5>Root Cause's Third :</h5>
                                                <p style="margin-left: 5%">{{ $incident_reports_root_causes->tertiary }}</p>
                                            </div>
                                        @endif

                                    @endif

                                    @if (Str::lower($name) == "preventiveactions")
                                        <div class="form-row">
                                            {{-- Dropdown 1 --}}
                                            <div class="form-group col-12 my-3">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="inputGroupSelect01"> {{$dd->dropdown_name}} <span class="text-danger   font-weight-bold">*</span> </label>
                                                    </div>

                                                    <select id="{{Str::lower($name)}}" required

                                                    @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" )

                                                    multiple

                                                    @endif class="custom-select drop"

                                                    myid="dd{{ $dd->id }}"

                                                    @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" )

                                                    name="{{Str::lower($name)}}_first[]"

                                                    @else

                                                    name="{{Str::lower($name)}}_first"

                                                    @endif

                                                    required >
                                                        @if(Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause' )
                                                            <option value=0 disabled selected>Please Select</option>
                                                        @endif
                                                        @foreach ($dropdownmain as $ddmain)

                                                            @if ($ddmain->dropdown_id == $dd->id)
                                                                <option value="{{ $ddmain->id }}">{{ $ddmain->type_main_name }}</option>
                                                            @endif

                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- Dropdown 2 --}}
                                            <div class="form-group col-10 offset-2 my-3" id="display_dd{{ $dd->id }}" style="display: none;">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="inputGroupSelect01">Options</label>
                                                    </div>
                                                    <select @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" ) multiple @endif class="custom-select droptwo"   @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" )  name="{{Str::lower($name)}}_second[]" @else name="{{Str::lower($name)}}_second"  @endif myidtwo="ddd{{ $dd->id }}" id="dd{{ $dd->id }}">
                                                        @if(Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause' )
                                                            <option value=0 disabled selected>Please Select</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- Dropdown 3 --}}
                                            <div class="form-group col-10 offset-2 my-3" id="display_ddd{{ $dd->id }}" style="display: none;">
                                                <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="inputGroupSelect01">Options</label>
                                                </div>
                                                <select @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" ) multiple @endif class="custom-select"  @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" )  name="{{Str::lower($name)}}_third[]" @else name="{{Str::lower($name)}}_third"  @endif id="ddd{{ $dd->id }}">
                                                        @if(Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause' )
                                                            <option value=0 disabled selected>Please Select</option>
                                                        @endif
                                                </select>
                                                </div>
                                            </div>
                                        </div>

                                        @if (isset($incident_reports_preventive_actions->primary))
                                            <div style="color: black">
                                                <h5>Preventive Action's First :</h5>
                                                <p style="margin-left: 5%">{{ $incident_reports_preventive_actions->primary }}</p>
                                            </div>
                                        @endif
                                        @if (isset($incident_reports_preventive_actions->secondary))
                                            <div style="color: black">
                                                <h5>Preventive Action's Second :</h5>
                                                <p style="margin-left: 5%">{{ $incident_reports_preventive_actions->secondary }}</p>
                                            </div>
                                        @endif
                                        @if (isset($incident_reports_preventive_actions->tertiary))
                                            <div style="color: black">
                                                <h5>Preventive Action's Third :</h5>
                                                <p style="margin-left: 5%">{{ $incident_reports_preventive_actions->tertiary }}</p>
                                            </div>
                                        @endif
                                    @endif
                                @endforeach

                                {{-- Comment --}}
                                <div class="form-group">
                                    <label for="">Comments</label>
                                    <textarea type="text" name="five_why_comments" id="five_why_comments" class="form-control" placeholder="Comments ...">@if(@isset($incident_report) && isset($incident_report->comments_five_why_section) ){{$incident_report->comments_five_why_section}}@endif</textarea>
                                </div>

                                {{-- Follow up actions --}}
                                <div class="from-group">
                                    <div id="add_more_actions_five_why_content">
                                        {{-- prefill followup actions ..... --}}
                                        @if (isset($incident_reports_follow_up_actions) && $incident_reports_follow_up_actions)
                                            @php
                                                $counter = 1;
                                            @endphp
                                            @foreach ($incident_reports_follow_up_actions as $follow_up_action)
                                                <hr>
                                                <label id="sr_no_five_why">Action  {{$counter}}   </label>
                                                @php $counter++; @endphp
                                                <hr>
                                                    <div class="form-row w-100">
                                                        <div class="col-md-12 col-sm-12">
                                                            <label for="five_why_followup_action_describtion_1">Description</label>
                                                            <textarea type="text" id="five_why_followup_action_describtion_1" name="five_why_followup_action_describtion[]" class="form-control">{{$follow_up_action->description}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-row w-100">
                                                        <div class="col-md-12 col-sm-12">
                                                            <label for="five_why_followup_action_describtion_1">PIC (Person in Charge)</label>
                                                            <input type="text" id="five_why_followup_action_pic_1" name="five_why_followup_action_pic[]" class="form-control" placeholder="Enter PIC name..." value="{{$follow_up_action->pic}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-row w-100">
                                                        <div class="col-md-4 col-sm-12">
                                                            <label for="five_why_followup_action_department_1">Department</label>
                                                            <input value="{{$follow_up_action->department}}" type="text"  id="five_why_followup_action_department_1" name="five_why_followup_action_department[]" class="form-control" placeholder="Department...">
                                                        </div>
                                                        <div class="col-md-4 col-sm-12">
                                                            <label for="five_why_followup_action_target_date_1">Target Date</label>
                                                            <input @if(isset($follow_up_action->target_date)) value="{{$follow_up_action->target_date}}" @endif type="text" id="five_why_followup_action_target_date_{{$counter - 1}}" name="five_why_followup_action_target_date[]" class="date form-control" placeholder="Target Date...">
                                                            <script> $(()=>{ $('#five_why_followup_action_target_date_{{$counter - 1}}').datepicker(); })</script>
                                                        </div>
                                                        <div class="col-md-4 col-sm-12">
                                                            <label for="five_why_followup_action_completed_date_1">Completed Date</label>
                                                            <input @if(isset($follow_up_action->completed_date)) value="{{$follow_up_action->completed_date}}" @endif type="text" id="five_why_followup_action_completed_date_{{$counter - 1}}" name="five_why_followup_action_completed_date[]" class="date form-control" placeholder="Completed Date...">
                                                            <script> $(()=>{ $('#five_why_followup_action_completed_date_{{$counter - 1}}').datepicker(); })</script>
                                                        </div>
                                                    </div>
                                                    <div class="form-row w-100">
                                                        <div class="col-md-6 col-sm-12">
                                                            <label for="five_why_followup_action_evidence_uploaded_{{$counter - 1}}">Evidence Uploaded</label>
                                                            <select id="five_why_followup_action_evidence_uploaded_{{$counter - 1}}"
                                                                onchange="is_evedence_uploaded('five_why_followup_action_evidence_uploaded_{{$counter - 1}}')"
                                                                name="five_why_followup_action_evidence_uploaded[]" class="form-control">
                                                                    <option @if($follow_up_action->evidence_uploaded != 'Yes' && $follow_up_action->evidence_uploaded != 'No') selected @endif   disabled hidden>Select option..</option>
                                                                    <option @if($follow_up_action->evidence_uploaded == 'Yes') selected @endif value="Yes">Yes</option>
                                                                    <option @if($follow_up_action->evidence_uploaded == 'No') selected @endif value="No">No</option>
                                                                </select>
                                                                <div id="five_why_followup_action_evidence_uploaded_{{$counter - 1}}_evidence_display" @if($follow_up_action->evidence_uploaded == 'Yes') style="display: block;" @else style="display: none;" @endif >
                                                                    <input class="file_upload" type="file" id="evdnc_file_{{$counter - 1}}" name="evidence_file[]" >
                                                                </div>
                                                                @if($follow_up_action->evidence_uploaded == 'Yes') <input value="{{ $follow_up_action->evidence_file }}" type="hidden" name="f_u_a_editImage[]"> <br> <img src="/getFile?path={{ $follow_up_action->evidence_file }}" height="100" width="100"> <br> @endif
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <label for="five_why_followup_action_cost_1">Cost</label>
                                                            <input @if(isset($follow_up_action->cost)) value="{{$follow_up_action->cost}}" @endif type="text" id="five_why_followup_action_cost_1" name="five_why_followup_action_cost[]" class="form-control" placeholder="Cost...">                                        </div>
                                                        <div class="col-md-12 col-sm-12">
                                                            <label for="five_why_followup_action_comments_1">Comments</label>
                                                            <textarea type="text" id="five_why_followup_action_comments_1" name="five_why_followup_action_comments[]" class="form-control"> @if(isset($follow_up_action->comments)){{$follow_up_action->comments}} @endif </textarea>
                                                        </div>
                                                    </div>
                                                <hr>
                                            @endforeach
                                            <input hidden type="text" name="five_why_followup_total" id="five_why_followup_total" value="{{$counter - 1}}">
                                        @else
                                            <hr>
                                            <label id="sr_no_five_why">Action 1 <input hidden type="text" name="five_why_followup_total" id="five_why_followup_total" value="1"></label>
                                            <hr>
                                            <div class="form-row w-100">
                                                <div class="col-md-12 col-sm-12">
                                                    <label for="five_why_followup_action_describtion_1">Description</label>
                                                    <textarea type="text" id="five_why_followup_action_describtion_1" name="five_why_followup_action_describtion[]" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-row w-100">
                                                <div class="col-md-12 col-sm-12">
                                                    <label for="five_why_followup_action_describtion_1">PIC (Person in Charge)</label>
                                                    <input type="text" id="five_why_followup_action_pic_1" name="five_why_followup_action_pic[]" class="form-control" placeholder="Enter PIC name...">
                                                </div>
                                            </div>
                                            <div class="form-row w-100">
                                                <div class="col-md-4 col-sm-12">
                                                    <label for="five_why_followup_action_department_1">Department</label>
                                                    <input type="text"  id="five_why_followup_action_department_1" name="five_why_followup_action_department[]" class="form-control" placeholder="Department...">
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <label for="five_why_followup_action_target_date_1">Target Date</label>
                                                    <input type="text" id="five_why_followup_action_target_date_1" name="five_why_followup_action_target_date[]" class="date form-control" placeholder="Target Date...">
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <label for="five_why_followup_action_completed_date_1">Completed Date</label>
                                                    <input type="text" id="five_why_followup_action_completed_date_1" name="five_why_followup_action_completed_date[]" class="date form-control" placeholder="Completed Date...">
                                                </div>
                                            </div>
                                            <div class="form-row w-100">
                                                <div class="col-md-6 col-sm-12">
                                                    <label for="five_why_followup_action_evidence_uploaded_1">Evidence Uploaded</label>
                                                    <select id="five_why_followup_action_evidence_uploaded_1"
                                                        onchange="is_evedence_uploaded('five_why_followup_action_evidence_uploaded_1')"
                                                        name="five_why_followup_action_evidence_uploaded[]" class="form-control">
                                                            <option selected disabled hidden>Select option..</option>
                                                            <option value="Yes">Yes</option>
                                                            <option value="No">No</option>
                                                        </select>
                                                        <div id="five_why_followup_action_evidence_uploaded_1_evidence_display" style="display: none;">
                                                            <input class="file_upload" type="file" id="evdnc_file_1" name="evidence_file[]" >
                                                        </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <label for="five_why_followup_action_cost_1">Cost</label>
                                                    <input type="text" id="five_why_followup_action_cost_1" name="five_why_followup_action_cost[]" class="form-control" placeholder="Cost...">                                        </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <label for="five_why_followup_action_comments_1">Comments</label>
                                                    <textarea type="text" id="five_why_followup_action_comments_1" name="five_why_followup_action_comments[]" class="form-control">  </textarea>
                                                </div>
                                            </div>
                                            <hr>
                                        @endif
                                    </div>
                                    <div class="text-center">
                                        <button id="add_more_actions_five_why" class="btn btn-primary text-light ml-auto mr-auto my-3">Add More Actions</button>
                                    </div>
                                </div>


                                {{-- Risk assesment evaluated --}}
                                <div class="form-group">
                                    <label for="five_why_Risk_assesment_evaluated">Risk assesment evaluated</label>

                                    <select name="five_why_Risk_assesment_evaluated" id="five_why_Risk_assesment_evaluated" class="form-control">
                                        @if (isset($incident_report->is_evalutated) && $incident_report->is_evalutated)
                                        <option  hidden selected value="{{$incident_report->is_evalutated}}" >{{$incident_report->is_evalutated}}</option>
                                        @else
                                        <option  hidden selected value="" ></option>
                                        @endif

                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>

                                    <div class="row" id="is_risk_evaluated" @if (isset($incident_report->is_evalutated) && $incident_report->is_evalutated == 'Yes') style="display: block;" @else style="display: none;" @endif>
                                        @if(isset($incident_report->five_why_risk_assesment_evaluated_file_upload) == false)
                                            <div class="col-4 col-md-4 d-flex">
                                                <input type="file" id="risk_evidence_file_1" name="risk_evidence_file" class="file_upload">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @if (isset($incident_report->is_evalutated) && $incident_report->is_evalutated == 'Yes')
                                     {{--<img id="risk_evidence_file_show"  src="/getFile?path={{ $incident_report->five_why_risk_assesment_evaluated_file_upload}}" width="200" height="200">--}}
                                     <a href="/downloadRaPdfIncident/{{$incident_report->id}}" target="_blank"><button type="button" class = 'btn btn-primary ml-2'>Download</button></a>
                                @endif


                                @if(session('is_ship') == 0 || session('is_ship') == '0')
                                {{--  changes which are added on (10-May-2022) in code it is only shown to shore side  --}}
                                <div class="form-group w-100">
                                    <div class="form-row w-100">
                                            {{--  team_engagement_and_discussion_topic  --}}
                                            <div class="col-6">
                                                <label>Leam Engagement And Discussion Topic</label>
                                                <textarea class="form-control" name="team_engagement_and_discussion_topic" id="" cols="20" rows="2">@if(isset($incident_report->team_engagement_and_discussion_topic) && $incident_report->team_engagement_and_discussion_topic) {{$incident_report->team_engagement_and_discussion_topic}}  @endif</textarea>
                                            </div>
                                            {{--  team_engagement_and_discussion_topic /end.  --}}

                                            {{--  lessons_learned  --}}
                                            <div class="col-6">
                                                <label>Lessons Learned</label>
                                                <textarea class="form-control" name="lessons_learned" id="" cols="20" rows="2">@if(isset($incident_report->lessons_learned) && $incident_report->lessons_learned) {{$incident_report->lessons_learned}}  @endif</textarea>
                                            </div>
                                            {{--  lessons_learned /end.  --}}

                                            {{--  potential_outcome  --}}
                                            <div class="col-6">
                                                <label>Potential Outcome</label>
                                                <textarea class="form-control" name="potential_outcome" id="" cols="20" rows="2">@if(isset($incident_report->potential_outcome) && $incident_report->potential_outcome) {{$incident_report->potential_outcome}}  @endif</textarea>
                                            </div>
                                            {{--  potential_outcome /end.  --}}

                                            {{--  key_message  --}}
                                            <div class="col-6">
                                                <label>Key Message</label>
                                                <textarea class="form-control" name="key_message" id="" cols="20" rows="2">@if(isset($incident_report->key_message) && $incident_report->key_message) {{$incident_report->key_message}}  @endif</textarea>
                                            </div>
                                            {{--  key_message /end. --}}
                                    </div>
                                </div>
                                @endif



                                {{-- Buttons(next/prev) --}}
                                <div class="mr-auto ml-auto" >
                                    <div class="d-flex">
                                        <button class="btn btn-info mt-5 w-25 mr-auto" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous </button>
                                         <button class="btn btn-info mt-5 w-25 ml-auto" type="button" id="nextBtn" onclick="nextPrev(1)">Submit Report</button>
                                    </div>
                                </div>
                            </div>
                            {{-- SEE 5 WHY end
                            ================================================================ --}}



                        </form>
                    </div>
                <!--==============
                Html End -->
                
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')

    {{--  Global Variables .....  --}}
    <script>
        var is_edited = `{{$is_edit}}`;
    </script>

    <script> var incident_image = `{{$incident_image}}`; </script>

    <script src="/js/jquery/jquery.lcnCircleRangeSelect.js"></script>


    <!-- drawer Js -->
        <script src="{{ asset('/js/custom/incidentReporting/drawerJs.standalone.min.js') }}"></script>
        <script src="{{ asset('/js/custom/incidentReporting/drawerLocalization.js') }}"></script>
        <script src="{{ asset('/js/custom/incidentReporting/drawerJsConfig.js') }}"></script>
        <script src="{{ asset('/js/custom/incidentReporting/download.js') }}"></script>
    <!-- drawerjs end  -->

    <script src="{{ asset('/js/custom/incidentReporting/index.js') }}"></script>
    <script src="{{ asset('/js/custom/incidentReporting/create.js') }}"></script>

    {{-- risk matrix and investigation matrix  --}}
    <script src="{{asset('/js/custom/incidentReporting/risk_matrix_and_investigation_matrix.js')}}"></script>


    {{-- jquery
    =====================
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
     <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>  -->--}}
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/roundSlider/1.3.2/roundslider.js"></script>
    {{-- ClockPicker
    ============================--}}
    <script src="{{ asset('js/ClockPicker/bootstrap-clockpicker.min.js') }}" ></script>

    <script>
        var is_user_admin = {!! json_encode(Auth::user()->isAdmin()) !!};

        // global variable
        var event_date_count = 1;
        var event_investigation_count = 1;
        var STM_count = 1;
    </script>




    {{-- my scripts
    ============================= --}}
    <script>
        var f = $('#First_Parameter').val();
        var s = $('#Second_Parameter').val();
        if(f != null && s != null){
            $('#nextBtn').css({'display':'block'})

        }
        // if risk assessment evaluated is 'YES'
        function is_risk_file_uploaded(id){
            var value = $(`#${id}`).val();
            if(value == 'Yes'){
                $('#is_risk_evaluated').css({'display':'block'});
            }else{
                $('#is_risk_evaluated').css({'display':'none'});
            }
        }
        // function for showing file upload in followup .....
        function is_evedence_uploaded(id){
            let myval = $(`#${id}`).val();
            if(myval == 'Yes'){
                $(`#${id}_evidence_display`).css({'display':'block'});
            }
            else{
                $(`#${id}_evidence_display`).css({'display':'none'});
            }
        }

        $(()=>{

            //image
            // $('[name = "encode"]').click(function(){

            //     setToInput();
            // });

            // time picker
            $('.clockpicker').clockpicker({
                placement: 'top',
                align: 'left',
                donetext: 'OK'
            });
            //function for validation check




            // date formating and date picker initialize

            // initialize
            // $( ".date" ).datepicker({maxDate: new Date()});
            $("#Date_of_incident").datepicker({maxDate: new Date()});
            $( "#event_date_1" ).datepicker({maxDate: new Date()});
            $('#Date_report_created').datepicker({maxDate: new Date()});
            $('#Date_of_incident_event_information').datepicker({maxDate: new Date()});
            $('#five_why_followup_action_target_date_1').datepicker();
            $('#five_why_followup_action_completed_date_1').datepicker();

            // formating
            $('body').on('change' , '.date' , function(){
                let dateinput = $(this).val();
                let date = moment(dateinput).format('DD-MMM-YYYY');
                $(this).val(date);
            })


            // code for adding more event log inputs in Event log
            $('.add_event_log').click(function(){
                event_date_count++;
                let add = `<div class="form-row w-100">
                                    <div class="col-6 col-md-2">
                                        <label for="Class_Society">Date</label>
                                        <input type="text" class="form-control date" id="event_date_${event_date_count}" name="event_date[]" placeholder="Date..." autocomplete="off">
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <label for="Class_Society">Time</label>
                                        <div class="clockpicker">
                                            <input type="text" class="form-control" id="event_time_${event_date_count}" name="event_time[]" placeholder="Time..." autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <label for="Class_Society">Remarks</label>
                                        <textarea type="text" class="form-control" id="event_remarks_${event_date_count}" name="event_remarks[]" placeholder="Remarks..." autocomplete="off"></textarea>
                                    </div>
                                </div>

                                <hr>`;
                $('#event_date_'+event_date_count).datepicker({maxDate: new Date()});
                $('#event_body').append(add);
                $( ".date" ).datepicker({maxDate: new Date()});
                $('.clockpicker').clockpicker({
                placement: 'top',
                align: 'left',
                donetext: 'OK'
                });
            });



            // if crew injured
            $('#Crew_Injury').change(function(){
                if($('#Crew_Injury').val() == 'Yes')
                {
                    $('#if_crew_injured').css('display', 'block');
                }
                if($('#Crew_Injury').val() == 'No')
                {
                    $('#if_crew_injured').css('display', 'none');
                }
            });


            // when At sea selected
            $('#Place_of_the_incident_1st').change(function(){
                if($('#Place_of_the_incident_1st').val() == 'Port'){
                    $('#poi2').show();
                    $('#poisea').hide();
                    $('#poisea').removeClass("d-block");
                }
                if($('#Place_of_the_incident_1st').val() == 'At Sea'){
                    $('#poi2').hide();
                    $('#poisea').addClass("d-block");
                }
            });


            // when operation other selected
            $('#Operation').change(function(){
                if($('#Operation').val() == 'others')
                {
                    $('#operation_other_EI').css('display', 'block')
                }
                else
                {
                    $('#operation_other_EI').css('display', 'none')
                }
            })




            // degree validation
            $('.degree').change(function(){
                let val = $(this).val();
                if(val <= 0 || val >= 359 )
                {
                    $(this).val('');
                    toastr.error('Please Enter Between 000 to 359 Degree Value');
                }

            });


            // Incident header
            let val = $('#Incident_header').val();
            document.getElementById('header_Txt').innerText = val.toUpperCase() ;
            $('#Incident_header').change(function(){
                let val = $('#Incident_header').val();
                document.getElementById('header_Txt').innerText = val.toUpperCase() ;
            })

            // add more event details in incident investigation
            $('#Add_more_event_investigation_btn').click(function(){
                event_investigation_count++;
                let inp = `<textarea type="text"   class="form-control my-2" id="Event_Details_IIARCF_${event_investigation_count}" name="Event_Details_IIARCF[]" placeholder="Event Details..." autocomplete="off"> </textarea>`;
                $('#Add_more_event_investigation').append(inp);
            });


            // Risk Category Form displaying
            $('#Risk_category_IIARCF').change(function(){
                let Risk_val = $('#Risk_category_IIARCF').val();
                 console.log(Risk_val);
                if(Risk_val == 'SAFETY'){
                    $('#SAFETY_display_control').show();
                    $('#HEALTH_display_control').hide();
                    $('#ENVIRONMENT_display_control').hide();
                    $('#OPERATIONAL_IMPACT_display_control').hide();
                    $('#MEDIA_display_control').hide();
                }
                else if(Risk_val == 'HEALTH'){
                    $('#SAFETY_display_control').hide();
                    $('#HEALTH_display_control').show();
                    $('#ENVIRONMENT_display_control').hide();
                    $('#OPERATIONAL_IMPACT_display_control').hide();
                    $('#MEDIA_display_control').hide();
                }
                else if(Risk_val == 'ENVIRONMENT'){
                    $('#SAFETY_display_control').hide();
                    $('#HEALTH_display_control').hide();
                    $('#ENVIRONMENT_display_control').show();
                    $('#OPERATIONAL_IMPACT_display_control').hide();
                    $('#MEDIA_display_control').hide();
                }
                else if(Risk_val == 'OPERATIONAL IMPACT'){
                    $('#SAFETY_display_control').hide();
                    $('#HEALTH_display_control').hide();
                    $('#ENVIRONMENT_display_control').hide();
                    $('#OPERATIONAL_IMPACT_display_control').show();
                    $('#MEDIA_display_control').hide();
                }
                else if(Risk_val == 'MEDIA'){
                    $('#SAFETY_display_control').hide();
                    $('#HEALTH_display_control').hide();
                    $('#ENVIRONMENT_display_control').hide();
                    $('#OPERATIONAL_IMPACT_display_control').hide();
                    $('#MEDIA_display_control').show();
                }
                else{
                    $('#SAFETY_display_control').hide();
                    $('#HEALTH_display_control').hide();
                    $('#ENVIRONMENT_display_control').hide();
                    $('#OPERATIONAL_IMPACT_display_control').hide();
                    $('#MEDIA_display_control').hide();
                }

            });



            // Wind force chart showing
            $('#Wind_force').change(function(){
                let wf_value = $('#Wind_force').val();
                console.log(typeof wf_value)
                if ( wf_value == '0' ) {

                    $('#wf_0').show();
                    $('#wf_1').hide();
                    $('#wf_2').hide();
                    $('#wf_3').hide();
                    $('#wf_4').hide();
                    $('#wf_5').hide();
                    $('#wf_6').hide();
                    $('#wf_7').hide();
                    $('#wf_8').hide();
                    $('#wf_9').hide();
                    $('#wf_10').hide();
                    $('#wf_11').hide();
                    $('#wf_12').hide();
                    $('#wf_chart').css('display','block');
                }
                else if ( wf_value == '1' ) {
                    console.log('one')
                    $('#wf_0').hide();
                    $('#wf_1').show();
                    $('#wf_2').hide();
                    $('#wf_3').hide();
                    $('#wf_4').hide();
                    $('#wf_5').hide();
                    $('#wf_6').hide();
                    $('#wf_7').hide();
                    $('#wf_8').hide();
                    $('#wf_9').hide();
                    $('#wf_10').hide();
                    $('#wf_11').hide();
                    $('#wf_12').hide();
                    $('#wf_chart').css('display','block');
                }
                else if ( wf_value == '2' ) {
                    $('#wf_0').hide();
                    $('#wf_1').hide();
                    $('#wf_2').show();
                    $('#wf_3').hide();
                    $('#wf_4').hide();
                    $('#wf_5').hide();
                    $('#wf_6').hide();
                    $('#wf_7').hide();
                    $('#wf_8').hide();
                    $('#wf_9').hide();
                    $('#wf_10').hide();
                    $('#wf_11').hide();
                    $('#wf_12').hide();
                    $('#wf_chart').css('display','block');
                }
                else if ( wf_value == '3' ) {
                    $('#wf_0').hide();
                    $('#wf_1').hide();
                    $('#wf_2').hide();
                    $('#wf_3').show();
                    $('#wf_4').hide();
                    $('#wf_5').hide();
                    $('#wf_6').hide();
                    $('#wf_7').hide();
                    $('#wf_8').hide();
                    $('#wf_9').hide();
                    $('#wf_10').hide();
                    $('#wf_11').hide();
                    $('#wf_12').hide();
                    $('#wf_chart').css('display','block');
                }
                else if ( wf_value == '4' ) {
                    $('#wf_0').hide();
                    $('#wf_1').hide();
                    $('#wf_2').hide();
                    $('#wf_3').hide();
                    $('#wf_4').show();
                    $('#wf_5').hide();
                    $('#wf_6').hide();
                    $('#wf_7').hide();
                    $('#wf_8').hide();
                    $('#wf_9').hide();
                    $('#wf_10').hide();
                    $('#wf_11').hide();
                    $('#wf_12').hide();
                    $('#wf_chart').css('display','block');
                }
                else if ( wf_value == '5' ) {
                    $('#wf_0').hide();
                    $('#wf_1').hide();
                    $('#wf_2').hide();
                    $('#wf_3').hide();
                    $('#wf_4').hide();
                    $('#wf_5').show();
                    $('#wf_6').hide();
                    $('#wf_7').hide();
                    $('#wf_8').hide();
                    $('#wf_9').hide();
                    $('#wf_10').hide();
                    $('#wf_11').hide();
                    $('#wf_12').hide();
                    $('#wf_chart').css('display','block');
                }
                else if ( wf_value == '6' ) {
                    $('#wf_0').hide();
                    $('#wf_1').hide();
                    $('#wf_2').hide();
                    $('#wf_3').hide();
                    $('#wf_4').hide();
                    $('#wf_5').hide();
                    $('#wf_6').show();
                    $('#wf_7').hide();
                    $('#wf_8').hide();
                    $('#wf_9').hide();
                    $('#wf_10').hide();
                    $('#wf_11').hide();
                    $('#wf_12').hide();
                    $('#wf_chart').css('display','block');
                }
                else if ( wf_value == '7' ) {
                    $('#wf_0').hide();
                    $('#wf_1').hide();
                    $('#wf_2').hide();
                    $('#wf_3').hide();
                    $('#wf_4').hide();
                    $('#wf_5').hide();
                    $('#wf_6').hide();
                    $('#wf_7').show();
                    $('#wf_8').hide();
                    $('#wf_9').hide();
                    $('#wf_10').hide();
                    $('#wf_11').hide();
                    $('#wf_12').hide();
                    $('#wf_chart').css('display','block');
                }
                else if ( wf_value == '8' ) {
                    $('#wf_0').hide();
                    $('#wf_1').hide();
                    $('#wf_2').hide();
                    $('#wf_3').hide();
                    $('#wf_4').hide();
                    $('#wf_5').hide();
                    $('#wf_6').hide();
                    $('#wf_7').hide();
                    $('#wf_8').show();
                    $('#wf_9').hide();
                    $('#wf_10').hide();
                    $('#wf_11').hide();
                    $('#wf_12').hide();
                    $('#wf_chart').css('display','block');
                }
                else if ( wf_value == '9' ) {
                    $('#wf_0').hide();
                    $('#wf_1').hide();
                    $('#wf_2').hide();
                    $('#wf_3').hide();
                    $('#wf_4').hide();
                    $('#wf_5').hide();
                    $('#wf_6').hide();
                    $('#wf_7').hide();
                    $('#wf_8').hide();
                    $('#wf_9').show();
                    $('#wf_10').hide();
                    $('#wf_11').hide();
                    $('#wf_12').hide();
                    $('#wf_chart').css('display','block');
                }
                else if ( wf_value == '10' ) {
                    $('#wf_0').hide();
                    $('#wf_1').hide();
                    $('#wf_2').hide();
                    $('#wf_3').hide();
                    $('#wf_4').hide();
                    $('#wf_5').hide();
                    $('#wf_6').hide();
                    $('#wf_7').hide();
                    $('#wf_8').hide();
                    $('#wf_9').hide();
                    $('#wf_10').show();
                    $('#wf_11').hide();
                    $('#wf_12').hide();
                    $('#wf_chart').css('display','block');
                }
                else if ( wf_value == '11' ) {
                    $('#wf_0').hide();
                    $('#wf_1').hide();
                    $('#wf_2').hide();
                    $('#wf_3').hide();
                    $('#wf_4').hide();
                    $('#wf_5').hide();
                    $('#wf_6').hide();
                    $('#wf_7').hide();
                    $('#wf_8').hide();
                    $('#wf_9').hide();
                    $('#wf_10').hide();
                    $('#wf_11').show();
                    $('#wf_12').hide();
                    $('#wf_chart').css('display','block');
                }
                else if ( wf_value == '12' ) {
                    $('#wf_0').hide();
                    $('#wf_1').hide();
                    $('#wf_2').hide();
                    $('#wf_3').hide();
                    $('#wf_4').hide();
                    $('#wf_5').hide();
                    $('#wf_6').hide();
                    $('#wf_7').hide();
                    $('#wf_8').hide();
                    $('#wf_9').hide();
                    $('#wf_10').hide();
                    $('#wf_11').hide();
                    $('#wf_12').show();
                    $('#wf_chart').css('display','block');
                }
                else {
                    $('#wf_0').hide();
                    $('#wf_1').hide();
                    $('#wf_2').hide();
                    $('#wf_3').hide();
                    $('#wf_4').hide();
                    $('#wf_5').hide();
                    $('#wf_6').hide();
                    $('#wf_7').hide();
                    $('#wf_8').hide();
                    $('#wf_9').hide();
                    $('#wf_10').hide();
                    $('#wf_11').hide();
                    $('#wf_12').hide()
                    $('#wf_chart').css('display','none');
                }
            })


            // add more actions in 5 why
            $('#add_more_actions_five_why').click(function(){
                $("form").submit(function(e){
                    e.preventDefault();
                });
                let counter = parseInt($("#five_why_followup_total").val()) + 1;
                $("#five_why_followup_total").val(counter);
                let content = `
                                    <hr>
                                    <label id="sr_no_five_why">Action ${counter} </label>
                                    <hr>
                                    <div class="form-row w-100">
                                        <div class="col-md-12 col-sm-12">
                                            <label for="five_why_followup_action_describtion_${counter}">Description</label>
                                            <textarea type="text" id="five_why_followup_action_describtion_${counter}" name="five_why_followup_action_describtion[]" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-row w-100">
                                        <div class="col-md-12 col-sm-12">
                                            <label for="five_why_followup_action_describtion_${counter}">PIC (Person in Charge)</label>
                                            <input type="text" id="five_why_followup_action_pic_${counter}" name="five_why_followup_action_pic[]" class="form-control" placeholder="Enter PIC name...">
                                        </div>
                                    </div>
                                    <div class="form-row w-100">
                                        <div class="col-md-4 col-sm-12">
                                            <label for="five_why_followup_action_department_${counter}">Department</label>
                                            <input type="text"  id="five_why_followup_action_department_${counter}" name="five_why_followup_action_department[]" class="form-control" placeholder="Department...">
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <label for="five_why_followup_action_target_date_${counter}">Target Date</label>
                                            <input type="text" id="five_why_followup_action_target_date_${counter}" name="five_why_followup_action_target_date[]" class="date form-control" placeholder="Target Date...">
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <label for="five_why_followup_action_completed_date_${counter}">Completed Date</label>
                                            <input type="text" id="five_why_followup_action_completed_date_${counter}" name="five_why_followup_action_completed_date[]" class="date form-control" placeholder="Completed Date...">
                                        </div>
                                    </div>
                                    <div class="form-row w-100">
                                        <div class="col-md-6 col-sm-12">
                                            <label for="five_why_followup_action_evidence_uploaded_${counter}">Evidence Uploaded</label>
                                            <select id="five_why_followup_action_evidence_uploaded_${counter}"
                                                onchange="is_evedence_uploaded('five_why_followup_action_evidence_uploaded_${counter}')"
                                                name="five_why_followup_action_evidence_uploaded[]" class="form-control">
                                                    <option selected disabled hidden>Select option..</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                                <div id="five_why_followup_action_evidence_uploaded_${counter}_evidence_display" style="display: none;">
                                                    <input class="file_upload" type="file" id="evdnc_file_${counter}" name="evidence_file[]" >
                                                </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <label for="five_why_followup_action_cost_${counter}">Cost</label>
                                            <input type="text" id="five_why_followup_action_cost_${counter}" name="five_why_followup_action_cost[]" class="form-control" placeholder="Cost...">                                       </div>
                                        <div class="col-md-12 col-sm-12">
                                            <label for="five_why_followup_action_comments_${counter}">Comments</label>
                                            <textarea type="text" id="five_why_followup_action_comments_${counter}" name="five_why_followup_action_comments[]" class="form-control"> </textarea>
                                        </div>
                                    </div>
                                    <hr>
                                `;
                $('#add_more_actions_five_why_content').append(content);
                $('#five_why_followup_action_target_date_'+counter).datepicker();
                $('#five_why_followup_action_completed_date_'+ counter).datepicker();
            });








            // Add Supporting Team Member
            $('#add_supporting_member').click(function(){
                console.log('in add member click');
                STM_count++;
                console.log('count : ', STM_count);
                let cont = `
                    <input type="text"   class="form-control mb-3" id="STM_${STM_count}" name="STM[]" placeholder="Supporting Team Members..." autocomplete="off">
                `;
                console.log('html : ', cont);
                console.log('div : ', $('#add_supporting_member_content'));

                $('#add_supporting_member_content').append(cont);
            })


            // control five why inputs
            $("#first_why_for_five_why_display_btn").click(function(){
                $("#second_why_for_five_why_display").show();
            })

            $("#second_why_for_five_why_display_btn").click(function(){
                $("#third_why_for_five_why_display").show();
            })

            $("#third_why_for_five_why_display_btn").click(function(){
                $("#fourth_why_for_five_why_display").show();
            })

            $("#fourth_why_for_five_why_display_btn").click(function(){
                $("#fifth_why_for_five_why_display").show();
            });



            // crew injury blank
            $("#Crew_Injury").change(function(){
                if($(this).val() == 'No'){

                        $('[name="STM[]"]').attr('disabled','disabled')

                        $('#Fatality').attr('disabled','disabled')
                        $('#Medical_Treatment_Case').attr('disabled','disabled')
                        $('#Restricted_Work_Case').attr('disabled','disabled')
                        $('#Lost_Workday_Case').attr('disabled','disabled')
                        $('#Lost_Time_Injuries').attr('disabled','disabled')
                        $('#First_Aid_Case').attr('disabled','disabled')

                        $('#Lead_Investigator').attr('disabled','disabled')

                }else{
                        $('[name="STM[]"]').prop('disabled', false);

                        $('#Fatality').prop('disabled', false);
                        $('#Medical_Treatment_Case').prop('disabled', false);
                        $('#Restricted_Work_Case').prop('disabled', false);
                        $('#Lost_Workday_Case').prop('disabled', false);
                        $('#Lost_Time_Injuries').prop('disabled', false);
                        $('#First_Aid_Case').prop('disabled', false);

                        $('#Lead_Investigator').prop('disabled', false);
                }
            });

            // disable other if one is select in crew injury
            $('#Fatality').change(function(){
                if($(this).val() == 'Yes'){

                    $('#Medical_Treatment_Case').attr('disabled','disabled')
                    $('#Restricted_Work_Case').attr('disabled','disabled')
                    $('#Lost_Workday_Case').attr('disabled','disabled')
                    $('#Lost_Time_Injuries').attr('disabled','disabled')
                    $('#First_Aid_Case').attr('disabled','disabled')

                }
                else
                {
                    $('#Medical_Treatment_Case').prop( "disabled", false )
                    $('#Restricted_Work_Case').prop( "disabled", false )
                    $('#Lost_Workday_Case').prop( "disabled", false )
                    $('#Lost_Time_Injuries').prop( "disabled", false )
                    $('#First_Aid_Case').prop( "disabled", false )
                }
            });

            $('#Lost_Workday_Case').change(function(){
                if($(this).val() == 'Yes'){

                    $('#Medical_Treatment_Case').attr('disabled','disabled')
                    $('#Restricted_Work_Case').attr('disabled','disabled')
                    $('#Fatality').attr('disabled','disabled')
                    $('#Lost_Time_Injuries').attr('disabled','disabled')
                    $('#First_Aid_Case').attr('disabled','disabled')

                }
                else
                {
                    $('#Medical_Treatment_Case').prop( "disabled", false )
                    $('#Restricted_Work_Case').prop( "disabled", false )
                    $('#Fatality').prop( "disabled", false )
                    $('#Lost_Time_Injuries').prop( "disabled", false )
                    $('#First_Aid_Case').prop( "disabled", false )
                }
            });

            $('#Medical_Treatment_Case').change(function(){
                if($(this).val() == 'Yes'){

                    $('#Lost_Workday_Case').attr('disabled','disabled')
                    $('#Restricted_Work_Case').attr('disabled','disabled')
                    $('#Fatality').attr('disabled','disabled')
                    $('#Lost_Time_Injuries').attr('disabled','disabled')
                    $('#First_Aid_Case').attr('disabled','disabled')

                }
                else
                {
                    $('#Lost_Workday_Case').prop( "disabled", false )
                    $('#Restricted_Work_Case').prop( "disabled", false )
                    $('#Fatality').prop( "disabled", false )
                    $('#Lost_Time_Injuries').prop( "disabled", false )
                    $('#First_Aid_Case').prop( "disabled", false )
                }
            });

            $('#Restricted_Work_Case').change(function(){
                if($(this).val() == 'Yes'){

                    $('#Lost_Workday_Case').attr('disabled','disabled')
                    $('#Medical_Treatment_Case').attr('disabled','disabled')
                    $('#Fatality').attr('disabled','disabled')
                    $('#Lost_Time_Injuries').attr('disabled','disabled')
                    $('#First_Aid_Case').attr('disabled','disabled')

                }
                else
                {
                    $('#Lost_Workday_Case').prop( "disabled", false )
                    $('#Medical_Treatment_Case').prop( "disabled", false )
                    $('#Fatality').prop( "disabled", false )
                    $('#Lost_Time_Injuries').prop( "disabled", false )
                    $('#First_Aid_Case').prop( "disabled", false )
                }
            });

            $('#Lost_Time_Injuries').change(function(){
                if($(this).val() != ''){

                    $('#Lost_Workday_Case').attr('disabled','disabled')
                    $('#Medical_Treatment_Case').attr('disabled','disabled')
                    $('#Fatality').attr('disabled','disabled')
                    $('#Restricted_Work_Case').attr('disabled','disabled')
                    $('#First_Aid_Case').attr('disabled','disabled')

                }
                else
                {
                    $('#Lost_Workday_Case').prop( "disabled", false )
                    $('#Medical_Treatment_Case').prop( "disabled", false )
                    $('#Fatality').prop( "disabled", false )
                    $('#Restricted_Work_Case').prop( "disabled", false )
                    $('#First_Aid_Case').prop( "disabled", false )
                }
            });

            $('#First_Aid_Case').change(function(){
                if($(this).val() == 'Yes'){

                    $('#Lost_Workday_Case').attr('disabled','disabled')
                    $('#Medical_Treatment_Case').attr('disabled','disabled')
                    $('#Fatality').attr('disabled','disabled')
                    $('#Restricted_Work_Case').attr('disabled','disabled')
                    $('#Lost_Time_Injuries').attr('disabled','disabled')

                }
                else
                {
                    $('#Lost_Workday_Case').prop( "disabled", false )
                    $('#Medical_Treatment_Case').prop( "disabled", false )
                    $('#Fatality').prop( "disabled", false )
                    $('#Restricted_Work_Case').prop( "disabled", false )
                    $('#Lost_Time_Injuries').prop( "disabled", false )
                }
            });





            // Risk assement evaluated unlimited file
            $('.addInputRisk').click(function(){

            })



        })
        var risk_evidence_file = 1;
        function addInputRisk(){
            risk_evidence_file++;
                let con = `<div class="col-12 col-md-4 d-flex">
                                <input type="file" id="risk_evidence_file_${risk_evidence_file}" name="risk_evidence_file[]" class="file_upload">
                                <button onclick='addInputRisk()'  class="btn add_more_input ml-3 numo-btn btn-primary text-light">+</button>
                            </div>`
                $('#is_risk_evaluated').append(con)
        }

        function mouseLeave(name){
            console.log(name)
            if(name === 'lat_1' || name === 'long_1'){
                let value_for_check = $(`#${name}`).val();

                if($.isNumeric($('#'+name).val())){
                    {{--  cheking if value is 90 below or higher than 0 or not  --}}
                    if(name == 'lat_1' && $('#lat_1').val() > 90 || $('#lat_1').val() < 0){
                    $('#lat_1').val("");
                        toastr.error('Values should be in between 0 - 90');
                    }
                    {{--  cheking if value is 180 below or higher than 0 or not  --}}
                    if(name == 'long_1' && $('#long_1').val() > 180 || $('#long_1').val() < 0){
                        $('#long_1').val("");
                        toastr.error('Values should be in between 0 - 180');
                    }
                    {{--  chekinbg its number or decimal  --}}
                    if(value_for_check - Math.floor(value_for_check) != 0){
                        console.log("ha bhhai hocche !!")
                        toastr.error('Please Enter a whole number !! ');
                        $(`#${name}`).val('')
                    }
                }

                if($.isNumeric($('#'+name).val()) === false){ toastr.error('Please Enter a Whole Number !!') }
            }
            else{
                if($.isNumeric($('#'+name).val())){



                    if(name == 'lat_2' && $('#lat_2').val() % 1 == 0 ){
                        $('#lat_2').val("");
                        toastr.error('Values should be in  Decimal ');
                    }
                    if(name == 'long_2' && $('#long_2').val() % 1 == 0 ){
                        $('#long_2').val("");
                        toastr.error('Values should be in  Decimal');
                    }
                }
                else{
                    console.log('else');
                    $('#'+name).val("");
                    toastr.error('Either number or Decimal')
                }
            }
        }
    </script>


    <!-- Multi-step form Script
    ================================= -->
        <script>
            // var currentTab = 0; // Current tab is set to be the first tab (0)
            // showTab(currentTab); // Display the current tab
            // fire next on presing enter
            // $(document).on("keypress", function (e) {
            //     //all the action
            //     var key = e.which;
            //     if(key == 13) {
            //         nextPrev(1)

            //         document.getElementById("slide_div").animate([
            //             // keyframes
            //             { transform: 'translateX(0px)' },
            //             { transform: 'translateX(200px)' },
            //             { transform: 'translateX(0px)' }
            //             ], {
            //             // timing options
            //             duration: 81,
            //             iterations: 1
            //         });
            //     }
            // });

        </script>
    <!--=============================
    Multi-step Script End -->



    {{-- multi-select
    ============================= --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap_multi_select/bootstrap-multiselect.css') }}">
    <script src="{{ asset('js/bootstrap_multi_select/bootstrap-multiselect.js') }}"></script>

    {{-- Root causes and action causes
    ========================================== --}}
    <script type="text/javascript">
        // step:- investigation matrix
        var user_id = {{Auth::user()->id}};


        console.log('user_id',user_id);
        console.log('is_user_admin',is_user_admin);

        //var is_user_admin = false;
        // if(is_user_admin){
        //     var is_user_admin = {{Auth::user()->isAdmin()}};
        // }

        console.log('is_user_admin',is_user_admin);

    </script>

    <script>
        $(document).ready(function(){


            {{--  Degree picker for Direction  --}}
            $("#Direction_degree").roundSlider({
                sliderType: "min-range",
                handleShape: "round",
                width: 15, // width of the roundSlider
                radius: 50, // radius size
                value: 10, // value you want to apply
                max:360,
                startAngle:90,
                change:(e)=>{ $("#Direction").val(e.value); }
            });

            {{--  Degree picker for swell direction .....  --}}
            $("#Swell_direction_degree").roundSlider({
                sliderType: "min-range",
                handleShape: "round",
                width: 15, // width of the roundSlider
                radius: 50, // radius size
                value: 10, // value you want to apply
                max:360,
                startAngle:90,
                change:(e)=>{ $("#Swell_direction").val(e.value); }
            });

            {{--  Degree picker for Rolling  --}}
            $("#Rolling_degree").roundSlider({
                sliderType: "min-range",
                handleShape: "round",
                width: 15, // width of the roundSlider
                radius: 50, // radius size
                value: 10, // value you want to apply
                max:60,
                startAngle:90,
                change:(e)=>{ $("#Rolling").val(e.value); }

            });

            {{--  Degree Picker for Pitcing  --}}
            $("#Pitcing_degree").roundSlider({
                sliderType: "min-range",
                handleShape: "round",
                width: 15, // width of the roundSlider
                radius: 50, // radius size
                value: 10, // value you want to apply
                max:25,
                startAngle:90,
                change:(e)=>{ $("#Pitcing").val(e.value); }
            });


            $('.form-control.degree').on('click',function(){
                // console.log('hello');
                var dataset = $(this)[0].dataset;
                var target = dataset.targetPicker;
                console.log(target);
                $(`${target}`).css({'display':'flex','flex-direction':'column','align-items':'center'});
            });

            // front-end validation for associated cost
            $(document).on('click', function(){
                // var elements = $('.degree_picker');
                // for(var j=0; j<elements.length; j++){
                //     var is_visible = elements[j].style.display;
                //     if(is_visible == 'flex'){
                //         elements[j].style.display = 'none';
                //     }
                // }
                // background-color: #ffdddd;
                var SAFETY_show = $('#SAFETY_display_control')[0].style.display;
                var HEALTH_show = $('#HEALTH_display_control')[0].style.display;
                var ENVIRONMENT_show = $('#ENVIRONMENT_display_control')[0].style.display;
                var OPERATIONAL_IMPACT_show = $('#OPERATIONAL_IMPACT_display_control')[0].style.display;
                var MEDIA_show = $('#MEDIA_display_control')[0].style.display;
                if(SAFETY_show == '')
                {
                    var associated_cost = $('#IIARCF_safety_AssociatedCost').val();
                    associated_cost = parseInt(associated_cost);
                    var localCurrency_cost = $('#IIARCF_safety_localCurrency').val();
                    localCurrency_cost = parseInt(localCurrency_cost);
                    if(associated_cost < 0 )
                    {
                        $('#SAFETY_display_control .associated_cost_err_msg').css({'display':'block'});
                        $('#IIARCF_safety_AssociatedCost').css({'background-color':'#ffdddd'});
                    }
                    if(localCurrency_cost < 0)
                    {
                        $('#SAFETY_display_control .local_cost_err_msg').css({'display':'block'});
                        $('#IIARCF_safety_localCurrency').css({'background-color':'#ffdddd'});
                    }
                }
                else if(HEALTH_show == ''){
                    var associated_cost = $('#IIARCF_MEDIA_AssociatedCost').val();
                    associated_cost = parseInt(associated_cost);
                    var localCurrency_cost = $('#IIARCF_HEALTH_localCurrency').val();
                    localCurrency_cost = parseInt(localCurrency_cost);
                    if(associated_cost < 0 )
                    {
                        $('#HEALTH_display_control .associated_cost_err_msg').css({'display':'block'});
                        $('#IIARCF_HEALTH_AssociatedCost').css({'background-color':'#ffdddd'});
                    }
                    if(localCurrency_cost < 0)
                    {
                        $('#HEALTH_display_control .local_cost_err_msg').css({'display':'block'});
                        $('#IIARCF_HEALTH_localCurrency').css({'background-color':'#ffdddd'});
                    }
                }
                else if(ENVIRONMENT_show == ''){
                    var associated_cost = $('#IIARCF_ENVIRONMENT_AssociatedCost').val();
                    associated_cost = parseInt(associated_cost);
                    var localCurrency_cost = $('#IIARCF_ENVIRONMENT_localCurrency').val();
                    localCurrency_cost = parseInt(localCurrency_cost);
                    if(associated_cost < 0 )
                    {
                        $('#ENVIRONMENT_display_control .associated_cost_err_msg').css({'display':'block'});
                        $('#IIARCF_ENVIRONMENT_AssociatedCost').css({'background-color':'#ffdddd'});
                    }
                    if(localCurrency_cost < 0)
                    {
                        $('#ENVIRONMENT_display_control .local_cost_err_msg').css({'display':'block'});
                        $('#IIARCF_ENVIRONMENT_localCurrency').css({'background-color':'#ffdddd'});
                    }
                }
                else if(OPERATIONAL_IMPACT_show == ''){
                    var associated_cost = $('#IIARCF_OPERATIONAL_IMPACT_AssociatedCost').val();
                    associated_cost = parseInt(associated_cost);
                    var localCurrency_cost = $('#IIARCF_OPERATIONAL_IMPACT_localCurrency').val();
                    localCurrency_cost = parseInt(localCurrency_cost);
                    if(associated_cost < 0 )
                    {
                        $('#OPERATIONAL_IMPACT_display_control .associated_cost_err_msg').css({'display':'block'});
                        $('#IIARCF_OPERATIONAL_IMPACT_AssociatedCost').css({'background-color':'#ffdddd'});
                    }
                    if(localCurrency_cost < 0)
                    {
                        $('#OPERATIONAL_IMPACT_display_control .local_cost_err_msg').css({'display':'block'});
                        $('#IIARCF_OPERATIONAL_IMPACT_localCurrency').css({'background-color':'#ffdddd'});
                    }
                }
                else if(MEDIA_show == ''){
                    var associated_cost = $('#IIARCF_MEDIA_AssociatedCost').val();
                    associated_cost = parseInt(associated_cost);
                    var localCurrency_cost = $('#IIARCF_MEDIA_localCurrency').val();
                    localCurrency_cost = parseInt(localCurrency_cost);
                    if(associated_cost < 0 )
                    {
                        $('#MEDIA_display_control .associated_cost_err_msg').css({'display':'block'});
                        $('#IIARCF_MEDIA_AssociatedCost').css({'background-color':'#ffdddd'});
                    }
                    if(localCurrency_cost < 0)
                    {
                        $('#MEDIA_display_control .local_cost_err_msg').css({'display':'block'});
                        $('#IIARCF_MEDIA_localCurrency').css({'background-color':'#ffdddd'});
                    }
                }
            })
            // hide latitude and longitude if value is port
            if($('#Place_of_the_incident_1st').find(':selected').val() == 'Port'){
                $('#poisea').hide();
            }
            else if($('#Place_of_the_incident_1st').find(':selected').val() == 'At Sea'){
                // $('#Place_of_the_incident_2nd').hide();
                $('#poisea').addClass("d-block");
            }
            //Start value of 'result' step 7 is showing, achived through this change
                $('#IIARCF_safety_Likelihood').change();
                $('#IIARCF_HEALTH_Likelihood').change();
                $('#IIARCF_ENVIRONMENT_Likelihood').change();
                $('#IIARCF_OPERATIONAL_IMPACT_Likelihood').change();
                $('#IIARCF_MEDIA_Likelihood').change();
            // End value of 'result' step 7 is showing, achived through this change
        });
    </script>
    <script>

    // image live render ends ....
    function previewImages() {

    var preview = document.querySelector('#preview');

    if (this.files) {
    [].forEach.call(this.files, readAndPreview);
    }

    function readAndPreview(file) {

        // Make sure `file.name` matches our extensions criteria
        if (!/\.(jpe?g|png|gif)$/i.test(file.name)) {
        return console.log(file.name + " is not an image");
        } // else...

        var reader = new FileReader();

        reader.addEventListener("load", function() {
            var image = new Image();
            image.height = 200;
            // image.width = 'auto';
            image.title  = file.name;
            image.src    = this.result;
            preview.appendChild(image);
        });

        reader.readAsDataURL(file);

    }

    }

    //document.querySelector('#incident_images').addEventListener("change", previewImages);
    // image live render ends .....


    function closeDegreePicker(id){
        // console.log(id);
        // console.log($(`#${vid}`).val());
        $(`#${id}`).css({'display':'none'});
    }
    </script>


    {{-- if five_why_Risk_assesment_evaluated 'yes' then it shows file upload --}}
    <script>
        $(()=>{
            $("#five_why_Risk_assesment_evaluated").change(function(){
                if($("#five_why_Risk_assesment_evaluated").val() === 'Yes')
                {
                    $("#is_risk_evaluated").show()
                }else
                {
                    $("#is_risk_evaluated").hide()
                    $("#risk_evidence_file_1").val(null)
                }

            })
        })
    </script>



    {{--  changing root causes && preventive actions placeholder .....  --}}
    <script>
        $(()=>{
            $("div.form-row:nth-child(11) > div:nth-child(1) > div:nth-child(1) > span:nth-child(2) > div:nth-child(2) > button:nth-child(1) > span:nth-child(1)").html('Please Select')
            $("div.tab:nth-child(11) > div:nth-child(12) > div:nth-child(1) > div:nth-child(1) > span:nth-child(2) > div:nth-child(2) > button:nth-child(1) > span:nth-child(1)").html('Please Select')
            $("#display_dd4 > div:nth-child(1) > span:nth-child(2) > div:nth-child(2) > button:nth-child(1) > span:nth-child(1)").html('Please Select')
            $("#display_dd3 > div:nth-child(1) > span:nth-child(2) > div:nth-child(2) > button:nth-child(1) > span:nth-child(1)").html('Please Select')
            $("#display_ddd3 > div:nth-child(1) > span:nth-child(2) > div:nth-child(2) > button:nth-child(1) > span:nth-child(1)").html('Please Select')
            $("div.tab:nth-child(11) > div:nth-child(15) > div:nth-child(1) > div:nth-child(1) > span:nth-child(2) > div:nth-child(2) > button:nth-child(1) > span:nth-child(1)").text('Please Select')
            $("div.form-row:nth-child(11) > div:nth-child(1) > div:nth-child(1) > span:nth-child(2) > div:nth-child(2) > button:nth-child(1) > span:nth-child(1)").text('Please Select')
            $("div.tab:nth-child(11) > div:nth-child(9) > div:nth-child(1) > div:nth-child(1) > span:nth-child(2) > div:nth-child(2) > button:nth-child(1) > span:nth-child(1)").text('Please Select')
            $("div.tab:nth-child(11) > div:nth-child(10) > div:nth-child(1) > div:nth-child(1) > span:nth-child(2) > div:nth-child(2) > button:nth-child(1) > span:nth-child(1)").text('Please Select')
        })
    </script>
    {{-- will disable date and  time of incident on last step--}}
    <script>
        $(() => {
            $('#Date_of_incident').on('change',() => {
                let date = $('#Date_of_incident').val();
                $('#Date_of_incident_event_information').val(date);
                $('#Date_of_incident_event_information').attr("disabled", true); 
            })
            $('#Time_of_incident').on('change',() => {
                let time = $('#Time_of_incident').val();
                $('#Time_of_incident_event_information_LMT').val(time);
                $('#Time_of_incident_event_information_LMT').attr("disabled", true);
            });
        })    
    </script>

{{-- auto save start --}}
    <script>
        $(()=>{
            $('[name="step1"]').click(() => {
                // alert('Hey i am in step1');
                var Data = new FormData();
                Data.append("id", $("#id").val());
                Data.append("First_Parameter",$('#First_Parameter').find(':selected').val());
                Data.append("Second_Parameter",$('#Second_Parameter').find(':selected').val());
                Data.append("header",$('#Incident_header').val());
                Data.append("step", 1);
                // console.log(Data.id);

                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    url: "/api/incidentAutoSave",
                    method: "POST",
                    contentType: false,
                    processData: false,
                    data: Data,
                    dataType: "JSON",
                    
                });
            });
            
            $('[name = "step2"]').click(()=>{
                // alert('I am in step 2');
                var Data = new FormData();
                Data.append("id", $("#id").val());
                Data.append('Vessel_Name',$('#Vessel_Name').val());
                Data.append('Confidential',$('#Confidential').find(':selected').val());
                Data.append('media_involved',$('#media_involved').find(':selected').val());
                Data.append('Created_By',$('#Created_By_Name').val());
                Data.append('Created_By_Rank',$('#Created_By_Rank').val());
                Data.append('Date_of_incident',$('#Date_of_incident').val());
                Data.append('Time_of_incident',$('#Time_of_incident').val());
                Data.append('Date_report_created',$('#Date_report_created').val());

                Data.append('GMT',$('select#GMT').val());

                Data.append('Voy_No',$('#Voy_No').val());
                Data.append('Master',$('#Master').find(':selected').val());
                Data.append('Chief_officer',$('#Chief_officer').find(':selected').val());
                Data.append('Chief_Engineer',$('#Chief_Engineer').find(':selected').val());
                Data.append('fstEng',$('#fstEng').find(':selected').val());
                Data.append('Charterer',$('#Charterer').val());
                Data.append('Agent',$('#Agent').val());
                Data.append('Vessel_Damage',$('#Vessel_Damage').find(':selected').val());
                Data.append('Cargo_damage',$('#Cargo_damage').find(':selected').val());
                Data.append('Third_Party_Liability',$('#Third_Party_Liability').find(':selected').val());
                Data.append('Environmental',$('#Environmental').find(':selected').val());
                Data.append('Commercial_Service',$('#Commercial_Service').find(':selected').val());
                Data.append('step',2);
                console.log("GTM t : ",$('select#GMT').val());
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    url: "/api/incidentAutoSave",
                    method: "POST",
                    contentType: false,
                    processData: false,
                    data: Data,
                    dataType: "JSON",
                    
                });
                
            });
            $('[name = "step3"]').click(()=>{
                // alert('I am in step 3');
                var Data = new FormData();
                Data.append("id", $("#id").val());
                Data.append("step", 3);
                Data.append("Crew_Injury", $('#Crew_Injury').find(':selected').val());
                Data.append("Other_Personnel_Injury", $('#Other_Personnel_Injury').find(':selected').val());
                Data.append("Fatality",$('#Fatality').find(':selected').val());
                Data.append("Lost_Workday_Case",$('#Lost_Workday_Case').find(':selected').val());
                Data.append("Restricted_Work_Case",$('#Restricted_Work_Case').find(':selected').val());
                Data.append("Medical_Treatment_Case",$('#Medical_Treatment_Case').find(':selected').val());
                Data.append("Lost_Time_Injuries",$('#Lost_Time_Injuries').find(':selected').val());
                Data.append("First_Aid_Case",$('#First_Aid_Case').find(':selected').val());
                Data.append("Lead_Investigator",$('#Lead_Investigator').val());
                
                var smt_count = document.getElementsByName("STM[]").length;
                // var smt_values = document.getElementsByName("STM[]").value();
                // var smt_values = $("input[name=STM[]").val()
                var arr = [];
                var smt_values = $('input[name="STM[]"]').map(function() {
                    arr.push(this.value);
                });
                console.log("Length ",smt_count);
                console.log("Values ",smt_values);
                console.log('arr : ',arr);
                Data.append("STM",arr);
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    url: "/api/incidentAutoSave",
                    method: "POST",
                    contentType: false,
                    processData: false,
                    data: Data,
                    dataType: "JSON",
                    
                });
                // Data.append();
                // Data.append();
                // Data.append();
                // Data.append();
            });
            $('[step = "4"]').click(()=>{
                // alert('I am in step 4');
                var Data = new FormData();
                Data.append("id", $("#id").val());
                Data.append("step", 4);
                Data.append("Place_of_the_incident_1st",$('#Place_of_the_incident_1st').find(':selected').val());
                Data.append("Place_of_the_incident_2nd",$('#Place_of_the_incident_2nd').val());
                Data.append("Date_of_incident_event_information",$('#Date_of_incident_event_information').val());
                Data.append("Time_of_incident_event_information_LMT",$('#Time_of_incident_event_information_LMT').val());
                Data.append("Time_of_incident_event_information_GMT",$('#Time_of_incident_event_information_GMT').val());
                Data.append("Location_of_incident",$('#Location_of_incident').val());
                Data.append("Operation",$('#Operation').find(':selected').val());
                Data.append("Vessel_Condition",$('#Vessel_Condition').find(':selected').val());
                Data.append("cargo_type_and_quantity",$('#cargo_type_and_quantity').val());
                Data.append("Wind_force",$('#Wind_force').find(':selected').val());
                Data.append("Direction",$('#Direction').val());
                Data.append("Swell_height",$('#Swell_height').find(':selected').val());
                Data.append("Swell_length",$('#Swell_length').find(':selected').val());
                Data.append("Swell_direction",$('#Swell_direction').val());
                Data.append("Sky",$('#Sky').find(':selected').val());
                Data.append("Visibility",$('#Visibility').find(':selected').val());
                Data.append("Rolling",$('#Rolling').val());
                Data.append("Pitcing",$('#Pitcing').val());
                Data.append("Illumination",$('#Illumination').find(':selected').val());
                Data.append("pi_club_information",$('#pi_club_information').find(':selected').val());
                Data.append("hm_informed",$('#hm_informed').find(':selected').val());
                Data.append("remarks_tol",$('#remarks_tol').val());
                Data.append("lat_1",$('#lat_1').val());
                Data.append("lat_2",$('#lat_2').val());
                Data.append("lat_3",$('[name="lat_3"]').val());
                Data.append("long_1",$('#long_1').val());
                Data.append("long_2",$('#long_2').val());
                Data.append("long_3",$('[name="long_3"]').val());
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    url: "/api/incidentAutoSave",
                    method: "POST",
                    contentType: false,
                    processData: false,
                    data: Data,
                    dataType: "JSON",
                    
                });
            });
            $('[name = "step5"]').click(()=>{
                // alert('I am in step 5');
                var Data = new FormData();
                Data.append("id", $("#id").val());
                Data.append("step", 5);
                Data.append('Incident_in_brief',$('#Incident_in_brief').val());
                // Data.append();
                var arrDate = [];
                var arrTime = [];
                var arrRemark = [];
                $('input[name="event_date[]"]').map(function() {
                    arrDate.push(this.value);
                });
                $('input[name="event_time[]"]').map(function() {
                    arrTime.push(this.value);
                });
                $('textarea[name="event_remarks[]"]').map(function() {
                    arrRemark.push(this.value);
                });
                Data.append('Date',arrDate);
                Data.append('Time',arrTime);
                Data.append('Remark',arrRemark);
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    url: "/api/incidentAutoSave",
                    method: "POST",
                    contentType: false,
                    processData: false,
                    data: Data,
                    dataType: "JSON",
                    
                });
                // console.log('Date : ',arrDate);
                // console.log('Time : ',arrTime);
                // console.log('Remark : ',arrRemark);
                
            });
            $('[step = "6"]').click(()=>{
                // alert("I am in step 6");
                step6Save();
                // console.log('Image :: ',$('#imageEncodedInput').val());
                var Data = new FormData();
                Data.append("id", $("#id").val());
                Data.append("step", 6);
                Data.append("imageEncodedInput", $('#imageEncodedInput').val());
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    url: "/api/incidentAutoSave",
                    method: "POST",
                    contentType: false,
                    processData: false,
                    data: Data,
                    dataType: "JSON",
                    
                });

            })
            $('[name = "step7"]').click(()=>{
                // alert("I am in step 7");
                var Data = new FormData();
                Data.append("id", $("#id").val());
                Data.append("step", 7);
                // COLLECTING ALL EVENT DETAILS
                var eventDetails = [];
                $('textarea[name="Event_Details_IIARCF[]"]').map(function() {
                    eventDetails.push(this.value);
                });
                console.log("Event details : ",eventDetails);
                Data.append('eventDetails',eventDetails);
                // safety start
                Data.append('Risk_category_IIARCF',$('#Risk_category_IIARCF').val());
                Data.append('IIARCF_safety_first_dropdown',$('#IIARCF_safety_first_dropdown').find(':selected').val());
                Data.append('IIARCF_safety_Severity',$('#IIARCF_safety_Severity').find(':selected').val());
                Data.append('IIARCF_safety_Likelihood',$('#IIARCF_safety_Likelihood').find(':selected').val());
                Data.append('IIARCF_safety_Result',$('#IIARCF_safety_Result').val());
                Data.append('IIARCF_safety_NameOfThePerson',$('#IIARCF_safety_NameOfThePerson').val());
                Data.append('IIARCF_safety_TypeOfInjury',$('#IIARCF_safety_TypeOfInjury').val());

                Data.append('IIARCF_safety_AssociatedCost',$('#IIARCF_safety_AssociatedCost').val());
                Data.append('IIARCF_safety_localCurrency',$('#IIARCF_safety_localCurrency').val());
                Data.append('selected_currency_safety',$('#selected_currency_safety').find(':selected').val());
                // safety end
                // HEALTH start
                Data.append('IIARCF_HEALTH_first_dropdown',$('#IIARCF_HEALTH_first_dropdown').find(':selected').val());
                Data.append('IIARCF_HEALTH_Severity',$('#IIARCF_HEALTH_Severity').find(':selected').val());
                Data.append('IIARCF_HEALTH_Likelihood',$('#IIARCF_HEALTH_Likelihood').find(':selected').val());
                Data.append('IIARCF_HEALTH_Result',$('#IIARCF_HEALTH_Result').val());
                Data.append('IIARCF_HEALTH_NameOfThePerson',$('#IIARCF_HEALTH_NameOfThePerson').val());
                Data.append('IIARCF_HEALTH_TypeOfInjury',$('#IIARCF_HEALTH_TypeOfInjury').val());

                Data.append('IIARCF_HEALTH_AssociatedCost',$('#IIARCF_HEALTH_AssociatedCost').val());
                Data.append('IIARCF_HEALTH_localCurrency',$('#IIARCF_HEALTH_localCurrency').val());
                Data.append('selected_currency_health',$('#selected_currency_health').find(':selected').val());
                // HEALTH end
                // ENVIRONMENT start
                Data.append('IIARCF_ENVIRONMENT_first_dropdown',$('#IIARCF_ENVIRONMENT_first_dropdown').find(':selected').val());
                Data.append('IIARCF_ENVIRONMENT_Severity',$('#IIARCF_ENVIRONMENT_Severity').find(':selected').val());
                Data.append('IIARCF_ENVIRONMENT_Likelihood',$('#IIARCF_ENVIRONMENT_Likelihood').find(':selected').val());
                Data.append('IIARCF_ENVIRONMENT_Result',$('#IIARCF_ENVIRONMENT_Result').val());
                Data.append('IIARCF_ENVIRONMENT_TypeOfPollution',$('#IIARCF_ENVIRONMENT_TypeOfPollution').val());

                Data.append('IIARCF_ENVIRONMENT_AssociatedCost',$('#IIARCF_ENVIRONMENT_AssociatedCost').val());
                Data.append('IIARCF_ENVIRONMENT_localCurrency',$('#IIARCF_ENVIRONMENT_localCurrency').val());
                Data.append('selected_currency_environment',$('#selected_currency_environment').find(':selected').val());

                Data.append('IIARCF_ENVIRONMENT_ContainedSpill',$('#IIARCF_ENVIRONMENT_ContainedSpill').val());
                Data.append('IIARCF_ENVIRONMENT_TotalSpilledQuantity',$('#IIARCF_ENVIRONMENT_TotalSpilledQuantity').val());
                Data.append('IIARCF_ENVIRONMENT_SpilledInWater',$('#IIARCF_ENVIRONMENT_SpilledInWater').val());
                Data.append('IIARCF_ENVIRONMENT_SpilledAshore',$('#IIARCF_ENVIRONMENT_SpilledAshore').val());
                // ENVIRONMENT end
                // OPERATIONAL IMPACT start
                Data.append('IIARCF_OPERATIONAL_IMPACT_Vessel',$('#IIARCF_OPERATIONAL_IMPACT_Vessel').val());
                Data.append('IIARCF_OPERATIONAL_IMPACT_Cargo',$('#IIARCF_OPERATIONAL_IMPACT_Cargo').val());
                Data.append('IIARCF_OPERATIONAL_IMPACT_Third_Party',$('#IIARCF_OPERATIONAL_IMPACT_Third_Party').val());
                Data.append('IIARCF_OPERATIONAL_IMPACT_first_dropdown',$('#IIARCF_OPERATIONAL_IMPACT_first_dropdown').find(':selected').val());
                Data.append('IIARCF_OPERATIONAL_IMPACT_Severity',$('#IIARCF_OPERATIONAL_IMPACT_Severity').find(':selected').val());
                Data.append('IIARCF_OPERATIONAL_IMPACT_Likelihood',$('#IIARCF_OPERATIONAL_IMPACT_Severity').find(':selected').val());
                Data.append('IIARCF_OPERATIONAL_IMPACT_Result',$('#IIARCF_OPERATIONAL_IMPACT_Result').val());
                Data.append('IIARCF_OPERATIONAL_IMPACT_Damage_description',$('#IIARCF_OPERATIONAL_IMPACT_Damage_description').val());
                Data.append('IIARCF_OPERATIONAL_IMPACT_Off_hire_if_any',$('#IIARCF_OPERATIONAL_IMPACT_Off_hire_if_any').val());
                Data.append('IIARCF_OPERATIONAL_IMPACT_AssociatedCost',$('#IIARCF_OPERATIONAL_IMPACT_AssociatedCost').val());
                Data.append('IIARCF_OPERATIONAL_IMPACT_localCurrency',$('#IIARCF_OPERATIONAL_IMPACT_localCurrency').val());
                Data.append('selected_currency_operational_impact',$('#selected_currency_operational_impact').find(':selected').val());
                // OPERATIONAL IMPACT end
                // MEDIA start
                Data.append('IIARCF_MEDIA_first_dropdown',$('#IIARCF_MEDIA_first_dropdown').find(':selected').val());
                Data.append('IIARCF_MEDIA_Severity',$('#IIARCF_MEDIA_Severity').find(':selected').val());
                Data.append('IIARCF_MEDIA_Likelihood',$('#IIARCF_MEDIA_Likelihood').find(':selected').val());
                Data.append('IIARCF_MEDIA_Result',$('#IIARCF_MEDIA_Result').val());
                Data.append('IIARCF_MEDIA_describtion',$('#IIARCF_MEDIA_describtion').val());
                Data.append('IIARCF_MEDIA_AssociatedCost',$('#IIARCF_MEDIA_AssociatedCost').val());
                Data.append('IIARCF_MEDIA_localCurrency',$('#IIARCF_MEDIA_localCurrency').val());
                Data.append('selected_currency_media',$('#selected_currency_media').find(':selected').val());
                Data.append('IIARCF_MEDIA_type',$('#IIARCF_MEDIA_type').find(':selected').val());
                // MEDIA end
                Data.append('immediatecause_first',$('#immediatecause').find(':selected').val());
                Data.append('immediatecause_second',$('#dd2').find(':selected').val());
                Data.append('immediatecause_third',$('#ddd2').find(':selected').val());
                $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        url: "/api/incidentAutoSave",
                        method: "POST",
                        contentType: false,
                        processData: false,
                        data: Data,
                        dataType: "JSON",
                        
                });
                
            });
            
            async function step6Save(){
                await setToInput();
                
            }
        })
    </script>
{{-- auto save end --}}

@endsection



