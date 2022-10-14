@extends('layouts.app')

@section('template_title')
    Vessel Report
@endsection

@section('template_linked_css')
    {{-- Bootstrap
    ======================== --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    {{-- Clock Picker
    ============================= --}}
    <link rel="stylesheet" href="{{ asset('css/ClockPicker/bootstrap-clockpicker.min.css') }}">
    {{-- Custom Css
    ======================= --}}
    <!-- old -->
    <!-- <style>
        .navbar{
            background-color: #e1e1e1 !important;
            margin-bottom:20px !important;
            background: #e1e1e1;
            box-shadow:  5px 5px 10px #a7a7a7,
                        -5px -5px 10px #ffffff;
        }
        body{
            background-color: #e1e1e1;
        }
        .form-control.custom{
            border-radius: 8px !important;
            background: #ffffff;
            box-shadow: 5px 5px 5px #b1b1b1, -5px -5px 5px #ffffff;
        }
        .clockpicker-button, .popover-title
        {
            background-color: black !important;
            color: #ffdddd !important;
            border-radius: 14px !important;
        }
        .clockpicker-popover
        {
            border-radius : 14px !important;
        }
        .custom-select,
        .form-control{
            border-radius: 15px !important;
            outline: none !important;
        }
        .custom-select,
        .form-control:focus{
            outline: none !important;
            box-shadow: none;
        }

        /* numorphispm */
        /* .numo{
            border-radius: 10px !important;
            background: #e1e1e1 !important;
            box-shadow:  5px 5px 10px #6e6e6e,
             -5px -5px 10px #ffffff !important;
        }
        .numo-btn,
        #add_supporting_member,
        #add_event_log,
        #add_more_actions_five_why,
        #first_why_for_five_why_display_btn,
        #second_why_for_five_why_display_btn,
        #third_why_for_five_why_display_btn,
        #fourth_why_for_five_why_display_btn,
        #Add_more_event_investigation_btn{
            color:black !important;
            border-radius: 10px !important;
            background: #e0e0e0 !important;
            box-shadow:  -5px 5px 5px #868686,
                        5px -5px 5px #ffffff !important;
        }
        .numo-btn,
        #add_supporting_member,
        #add_event_log,
        #add_more_actions_five_why,
        #first_why_for_five_why_display_btn,
        #second_why_for_five_why_display_btn,
        #third_why_for_five_why_display_btn,
        #fourth_why_for_five_why_display_btn,
        #Add_more_event_investigation_btn:hover{
            color:black !important;
            border-radius: 10px !important;
            background: linear-gradient(225deg, #cacaca, #f0f0f0) !important;
            box-shadow:  -6px 6px 11px #8f8f8f,
                        6px -6px 11px #ffffff !important;
                }
        .custom-select,
        .form-control{
            border-radius: 8px !important;
            background: #e1e1e1;
            box-shadow:  5px 5px 14px #b1b1b1,
                        -5px -5px 14px #ffffff;
        }
        .custom-select,
        .form-control:focus{
            border-radius: 8px !important;
            background: #ececec;
            box-shadow:  5px 5px 14px #b1b1b1,
                        -5px -5px 14px #ffffff;
        } */
        /* numorphispm end */



        .file_upload{
            margin-top: 3%;
            border-radius: 8px !important;
            background: #e0e0e0;
            box-shadow:  5px 5px 14px #b1b1b1,
                        -5px -5px 14px #ffffff;
        }
    </style> -->
    <!-- Multi-step Style
    =================== -->
    <style>
        /* multi-select css edit */
        .multiselect-container
        {
            height: 200px !important;
            overflow-y:scroll !important;
        }
        /* Mark input boxes that gets an error on validation: */
        input.invalid {
            background-color: #ffdddd;
        }

        /* Hide all steps by default: */
        .tab {
            display: none;
        }

        /* Make circles that indicate the steps of the form: */
        .step {
            height: 15px;
            width: 20px;
            margin: 0 0px;
            background-color: #004cff;
            border: 1px solid #002986;
            display: inline-block;
            opacity: 0.5;
            margin-left: 20px;

            border-radius: 10px !important;
            box-shadow:  5px 5px 10px #6e6e6e,
             -5px -5px 10px #ffffff !important;
        }

        /* Mark the active step: */
        .step.active {
            opacity: 1;
        }

        /* Mark the steps that are finished and valid: */
        .step.finish {
            background-color: #ffffff;
            border: 5px solid #004cff;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

    </style>
    <!-- =================
    Multi-step Style End -->
<!-- new -->
<style>
        .degree_btn{
            margin-top: 10px;
            width: 100%;
            background: black;
            color: white;
            border-radius: 20px;
        }
        #preview img {
            margin: 10px;
            border: 1px solid;
            padding: 10px;
            width: 200px!important;
        }
        .associated_cost_err_msg{
            font-size: 12px;
            color: red;
            display: none;
        }
        .local_cost_err_msg{
            font-size: 12px;
            color: red;
            display: none;
        }
        .degree_picker{
            display: none;
            justify-content: center;
            position: relative;
            background: #ffffff;
            margin-top: 10px;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        /* .full .rs-tooltip {
            top: 36%;
            left: 36%;
            } */
        .navbar{
            background-color: #ffffff !important;
            margin-bottom:20px !important;
            background: #ffffff;
            box-shadow:  5px 5px 10px #a7a7a7,
                        -5px -5px 10px #ffffff;
        }
        body{
            background-color: #ffffff;
        }
        .form-control.custom{
            border-radius: 8px !important;
            background: #ffffff;
            /* box-shadow: 5px 5px 5px #b1b1b1, -5px -5px 5px #ffffff; */
        }
        .clockpicker-button, .popover-title
        {
            background-color: black !important;
            color: #ffdddd !important;
            border-radius: 14px !important;
        }
        .clockpicker-popover
        {
            border-radius : 14px !important;
        }

        .custom-select,
        .form-control{
            border-radius: 15px !important;
            outline: none !important;
        }
        .custom-select,
        .form-control:focus{
            outline: none !important;
            box-shadow: none;
        }

        /* numorphispm */
        .numo{
            border-radius: 10px !important;
            background: #ffffff !important;
            border: 1px solid #007bff; !important;
        }
        /* .numo-btn,
        #add_supporting_member,
        #add_event_log,
        #add_more_actions_five_why,
        #first_why_for_five_why_display_btn,
        #second_why_for_five_why_display_btn,
        #third_why_for_five_why_display_btn,
        #fourth_why_for_five_why_display_btn,
        #Add_more_event_investigation_btn{

            color:black !important;
            border-radius: 10px !important;
            background: #e0e0e0 !important;
            border:1px solid #696969;

        } */

        .custom-select,
        .form-control{
            border-radius: 8px !important;
            background: #ffffff;

            border:1px solid #696969;
        }

        /* numorphispm end */

        .file_upload{
            margin-top: 3%;
            border-radius: 8px !important;
            background: #e0e0e0;
            /* box-shadow:  5px 5px 14px #b1b1b1,
                        -5px -5px 14px #ffffff; */
            color: #000000;
            font-weight: 500;
            padding: 10px;
        }
        .form-group label{
            font-weight: 700;
        }
        #canvas-editor {
                margin-top: 50px;
                margin-left: 50px;
            }
    </style>

@endsection

@section('content')
    <div class="container mb-3">
        <div class="row">
        <div class="col-12">
            <a href="/incident-reporting">
            <button type="button" class="btn btn-dark"><i class="fa fa-long-arrow-left" aria-hidden="true" style="color:white;"></i></button>
            </a>
        </div>
        </div>
    </div>
    <div class="container">
        <div class=" p-3 py-5" id="slide_div">
            <!-- Html
            ================== -->
            {{-- div for centering the form --}}
                <div class="numo mx-md-5 ">
                    <form class="p-md-3 mx-md-5" enctype="multipart/form-data" files="true" method="POST" action="{{ url('/incident-reporting/update/'.$data_id) }}" id="near_miss_form">
                        @csrf

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
                            <span class="step"></span>
                            <span class="step"></span>
                        </div>

                        <h2 class="my-3 font-weight-light text-center">Incident Reporting</h2>

                        {{--  Investigation matrix
                        ================================  --}}
                        <div class="tab form-group">
                            <h5 class="text-center my-3">Investigation matrix</h5>
                            <div class="form-row">
                                {{-- select first parameter  --}}
                                <div class="form-group col-md-5 col-lg-5">
                                    <label for="First_Parameter">First Parameter</label>
                                    <select class="form-control" id="First_Parameter" name="investigation_matrix_fst">

                                        @if ($incident_report->investigation_matrix_fst && $incident_report->investigation_matrix_fst == '1')
                                        <option selected value="1">Slight</option>
                                        @elseif(($incident_report->investigation_matrix_fst && $incident_report->investigation_matrix_fst == '2'))
                                        <option selected value="2">Minor</option>
                                        @elseif(($incident_report->investigation_matrix_fst && $incident_report->investigation_matrix_fst == '3'))
                                        <option value="3"> Medium</option>
                                        @elseif(($incident_report->investigation_matrix_fst && $incident_report->investigation_matrix_fst == '4'))
                                        <option value="4">Major</option>
                                        @elseif(($incident_report->investigation_matrix_fst && $incident_report->investigation_matrix_fst == '5'))
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
                                    <label for="Second_Parameter">Second Parameter</label>
                                    <select class="form-control" id="Second_Parameter" name="investigation_matrix_scnd">
                                        @if ($incident_report->investigation_matrix_scnd && $incident_report->investigation_matrix_scnd == '1')
                                        <option value="1">Safety</option>
                                        @elseif(($incident_report->investigation_matrix_scnd && $incident_report->investigation_matrix_scnd == '2'))
                                        <option value="2">Health</option>
                                        @elseif(($incident_report->investigation_matrix_scnd && $incident_report->investigation_matrix_scnd == '3'))
                                        <option value="3">Environment</option>
                                        @elseif(($incident_report->investigation_matrix_scnd && $incident_report->investigation_matrix_scnd == '4'))
                                        <option value="4">Process Loss / Failure</option>
                                        @elseif(($incident_report->investigation_matrix_scnd && $incident_report->investigation_matrix_scnd == '5'))
                                        <option value="5">Asset / Property Damage</option>
                                        @elseif(($incident_report->investigation_matrix_scnd && $incident_report->investigation_matrix_scnd == '6'))
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
                                    <button type="button" id="matrixBtn" class="btn btn-primary w-100 ml-auto " data-toggle="modal" data-target="#view_matrix">View Matrix</button>
                                    <div class="modal fade" id="view_matrix" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                {{-- <div class="modal-header">
                                                    <h2 class="modal-title font-weight-bold" id="exampleModalLongTitle">Incident Details</h2> <h5>Report Id : 3 </h5>
                                                </div> --}}
                                                <div class="modal-body text-left">
                                                    <img src="{{asset('images/investigation-matrix.png')}}" alt="investigation-matrix" width="100%" height="auto"/>
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
                                <p class="err-text-msg" id="no-text-msg" style="display: none; color:red;">No parameter is selected</p>
                                <div id="investigation_result" class="form-group col-12 p-5" style="background: #ffff;border-radius: 10px; display:none;">
                                    <h5 style="text-align:center">Investigation Lavel</h5>
                                    <p id="data_investigation_level" style="text-align:center"></p>
                                    <h5 style="text-align:center">Close-Out Authority</h5>
                                    <p id="data_authority" style="text-align:center"></p>
                                </div>
                            </div>
                        </div>
                        {{--  Investigation matrix End
                        ================================  --}}




                        {{--  Enter Heading
                        ========================  --}}
                        <div class="tab form-group">
                            <label for="Class_Society">Incident header </label>
                            <input type="text" class="form-control" id="Incident_header" name="Incident_header" placeholder="Incident header..." autocomplete="off"
                            @if(@isset($incident_report->incident_header) && $incident_report->incident_header) value="{{$incident_report->incident_header}}" @else value="" @endif>
                        </div>



                        {{--  (Incident Header) first step of form
                        ============================================================================  --}}
                        <div class="tab form-group">
                                <h5 class="text-center my-3" id="header_Txt"></h5>

                            {{-- Vessel Name And Confidential --}}
                            <div class="form-row">
                                {{-- name --}}
                                <div class="form-group col-md-6">
                                    <label for="Vessel_Name">Vessel Name</label>
                                    <input @if (isset($vessel_details->name) && $vessel_details->name)
                                    value="{{$vessel_details->name}}"
                                    @else
                                    value=""
                                    @endif
                                    type="text" class="form-control" id="Vessel_Name" name="Vessel_Name" placeholder="Vessel Name...">
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
                                <div class="form-group col-md-6">
                                    <label for="Report_number">Report Number</label>
                                    <input style="pointer-events: none;"
                                    @if (isset($incident_report->report_no) && $incident_report->report_no)
                                    value="{{$incident_report->report_no}}"
                                    @else
                                    value=""
                                    @endif

                                    type="text" class="form-control" id="Report_number" name="Report_number" placeholder="Report Number..." >
                                </div>
                                {{-- media involved --}}
                                <div class="form-group col-md-6">
                                    <label for="Confidential">Media Involved</label>
                                    <select class="form-control" id="media_involved" name="media_involved">

                                        @if (isset($incident_report->media_involved) && $incident_report->media_involved)
                                        <option selected  hidden value="{{$incident_report->media_involved}}"  >{{$incident_report->media_involved}}</option>
                                        @else
                                        <option selected  hidden value="" >{{$incident_report->media_involved}}</option>
                                        @endif

                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Created_By --}}
                            {{-- <div class="form-group">
                                <label for="Created_By">Created By</label>
                                <select class="form-control" id="Created_By" name="Created_By">
                                    @foreach ( $crew_list as $cby )
                                        @if ($cby->id == $incident_report->created_by )

                                            @if (isset($incident_report->created_by) && $incident_report->created_by)
                                            <option selected  hidden value="{{$incident_report->created_by}}" >{{ $cby->name }}</option>
                                            @else
                                            <option selected  hidden value=""></option>
                                            @endif

                                        @endif

                                        @if (isset($cby->id) && $cby->id)
                                        <option value="{{$cby->id}}" >{{ $cby->name }}</option>
                                        @else
                                        <option value=""   ></option>
                                        @endif

                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="form-row">
                                <div class="form-group col-md-6">

                                    <label for="Created_By_Name">Created By (Name)</label>
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

                                        @if (isset($incident_report->time_of_incident_gmt) && $incident_report->time_of_incident_gmt)
                                        <option selected  hidden value="{{$incident_report->time_of_incident_gmt }}">{{$incident_report->time_of_incident_gmt }}</option>
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

                            {{-- Voy_No --}}
                            <div class="form-group">
                                <label for="Voy_No">Voy No</label>
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

                                        @foreach ( $crew_list as $c )
                                            @if ($c->id == $incident_report->master)

                                            @if (isset($incident_report->master) && $incident_report->master)
                                            <option selected  hidden value="{{$incident_report->master}}">{{ $c->name }}</option>
                                            @else
                                            <option selected  hidden value=""></option>
                                            @endif

                                            @endif
                                            <option value="{{$c->id}}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="Confidential">Chief officer</label>
                                    <select class="form-control" id="Chief_officer" name="Chief_officer">

                                        @foreach ( $crew_list as $c )
                                            @if ($c->id == $incident_report->chief_officer)

                                            @if (isset($incident_report->chief_officer) && $incident_report->chief_officer)
                                            <option selected  hidden value="{{$incident_report->chief_officer}}" >{{ $c->name }}</option>
                                            @else
                                            <option selected  hidden value="" ></option>
                                            @endif

                                            @endif

                                            @if (isset($c->id) && $c->id)
                                            <option value="{{$c->id}}" >{{ $c->name }}</option>
                                            @else
                                            <option value="">{{ $c->name }}</option>
                                            @endif

                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Chief_Engineer And 1st Eng. --}}
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="Confidential">Chief Engineer</label>
                                    <select class="form-control" id="Chief_Engineer" name="Chief_Engineer">

                                        @foreach ( $crew_list as $c )
                                            @if ($c->id == $incident_report->chief_engineer)

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
                                    <select class="form-control" id="fstEng" name="fstEng">

                                        @foreach ( $crew_list as $c )
                                            @if ($c->id == $incident_report->first_engineer)

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
                                @if ($incident_report->charterer)
                                <textarea type="text" class="form-control" name="Charterer" id="Charterer" placeholder="Charterer..."> {{$incident_report->charterer}}</textarea>
                                @else
                                <textarea type="text" class="form-control" name="Charterer" id="Charterer" placeholder="Charterer..."> </textarea>
                                @endif
                            </div>

                            {{-- Agent (if any) --}}
                            <div class="form-group">
                                <label for="Voy_No">Agent (if any)</label>
                                @if ($incident_report->agent)
                                <textarea type="text" class="form-control" name="Agent" id="Agent" placeholder="Agent (if any)...">{{$incident_report->agent}} </textarea>
                                @else
                                <textarea type="text" class="form-control" name="Agent" id="Agent" placeholder="Agent (if any)..."> </textarea>
                                @endif

                            </div>



                            {{-- Vessel_Damage , Cargo_damage And Third_Party_Liability --}}
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="Vessel Damage">Vessel_Damage</label>
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
                                    <label for="Cargo_damage">Cargo damage</label>
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




                        </div>




                        {{-- If Crew  Injured
                        =============================== --}}
                        <div class="tab form-group">
                            <h5 class="text-center my-3">CREW INJURY</h5>

                            {{-- Crew_Injury And Other_Personnel_Injury --}}
                            <div class="form-row">
                                <div class="form-row col-md-6">
                                    <label class="" for="Crew_Injury">Crew Injury</label>
                                    <select class="form-control" id="Crew_Injury" name="Crew_Injury">

                                        @if (isset($incident_report->crew_injury) && $incident_report->crew_injury)
                                        <option selected  hidden value="{{$incident_report->crew_injury}}"  >{{$incident_report->crew_injury}}</option>
                                        @else
                                        <option selected  hidden value=""  ></option>
                                        @endif

                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="pb-3" for="Other_Personnel_Injury">Third Party Personnel Injury</label>
                                    <select class="form-control" id="Other_Personnel_Injury" name="Other_Personnel_Injury">

                                        @if (isset($incident_report->other_personnel_injury) && $incident_report->other_personnel_injury)
                                        <option selected  hidden value="{{$incident_report->other_personnel_injury}}" >{{$incident_report->other_personnel_injury}}</option>
                                        @else
                                        <option selected  hidden value=""  ></option>
                                        @endif

                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>

                            {{-- ----------------------------------------------- Show if Crew injured ---------------------------------------------- --}}
                            <div class="m-5" id="if_crew_injured" @if($incident_report->crew_injury == 'Yes')style="display: block;" @else style="display: none;" @endif >

                                {{-- Fatality And Lost_Workday_Case --}}
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="Fatality">Fatality
                                            <i class="fa fa-info" aria-hidden="true" data-toggle="tooltip" title="A death directly resulting from a work
                                                injury regardless of the
                                                length of time between the injury and death." data-placement="top"></i>
                                        </label>
                                        <select class="form-control" id="Fatality" name="Fatality">

                                            @if (isset($incident_reports_crew_injury->fatality) && $incident_reports_crew_injury->fatality)
                                            <option selected  hidden value="{{$incident_reports_crew_injury->fatality}}">{{$incident_reports_crew_injury->fatality}}</option>
                                            @else
                                            <option selected  hidden value=""></option>
                                            @endif

                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Lost_Workday_Case">Lost Workday Case
                                            <i class="fa fa-info" aria-hidden="true" data-toggle="tooltip" title="This is an injury which results in an individual being unable to
                                                Case (LWC) carry out any of his duties or to return to work on a scheduled
                                                work shift on the day following the injury unless caused by
                                                delays in getting medical treatment ashore."></i>
                                        </label>
                                        <select class="form-control" id="Lost_Workday_Case" name="Lost_Workday_Case">

                                            @if (isset($incident_reports_crew_injury->lost_workday_case) && $incident_reports_crew_injury->lost_workday_case)
                                            <option selected  hidden value="{{$incident_reports_crew_injury->lost_workday_case}}"  >{{$incident_reports_crew_injury->lost_workday_case}}</option>
                                            @else
                                            <option selected  hidden value="" ></option>
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
                                            <i class="fa fa-info" aria-hidden="true" data-toggle="tooltip" title="This is an injury which results in an individual being unable to
                                                Case (RWC) perform all normally assigned work functions during a scheduled
                                                work shift or being assigned to another job on a temporary or
                                                permanent basis on the day following the injury."></i>
                                        </label>
                                        <select class="form-control" id="Restricted_Work_Case" name="Restricted_Work_Case">

                                            @if (isset($incident_reports_crew_injury->restricted_work_case) && $incident_reports_crew_injury->restricted_work_case)
                                            <option selected  hidden value="{{$incident_reports_crew_injury->restricted_work_case}}" >{{$incident_reports_crew_injury->restricted_work_case}}</option>
                                            @else
                                            <option selected  hidden value="" ></option>
                                            @endif

                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Commercial_Service">Medical Treatment Case
                                            <i class="fa fa-info" aria-hidden="true" data-toggle="tooltip" title="This is any work-related loss of consciousness (unless due
                                                to ill health), injury or illness requiring more than first aid
                                                treatment by a physician, dentist, surgeon or registered medical
                                                personnel, e.g. nurse or paramedic under the standing orders of
                                                a physician, or under the specific order of a physician or if at sea
                                                with no physician onboard could be considered as being in the
                                                province of a physician."></i>
                                        </label>
                                        <select class="form-control" id="Medical_Treatment_Case" name="Medical_Treatment_Case">

                                            @if (isset($incident_reports_crew_injury->medical_treatment_case) && $incident_reports_crew_injury->medical_treatment_case)
                                            <option selected  hidden value="{{$incident_reports_crew_injury->medical_treatment_case}}"  >{{$incident_reports_crew_injury->medical_treatment_case}}</option>
                                            @else
                                            <option selected  hidden value="" ></option>
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
                                            <i class="fa fa-info" aria-hidden="true" data-toggle="tooltip" title="Lost Time Injuries are the sum of Fatalities, Permanent Total
                                                Disabilities, Permanent Partial Disabilities and Lost Workday
                                                Cases.
                                                "></i>
                                        </label>
                                        <input type="text"
                                        @if (isset($incident_reports_crew_injury->lost_time_injuries) && $incident_reports_crew_injury->lost_time_injuries)
                                        value="{{$incident_reports_crew_injury->lost_time_injuries}}"
                                        @else
                                        value=""
                                        @endif
                                        class="form-control" id="Lost_Time_Injuries" name="Lost_Time_Injuries" placeholder="Lost Time Injuries...">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Commercial_Service">First Aid Case
                                            <i class="fa fa-info" aria-hidden="true" data-toggle="tooltip" title="This is any one-time treatment and subsequent observation or
                                                minor injuries such as bruises, scratches, cuts, burns, splinters,
                                                etc. The first aid may or may not be administered by a physician
                                                or registered professional."></i>
                                        </label>
                                        <select class="form-control" id="First_Aid_Case" name="First_Aid_Case">

                                            @if (isset($incident_reports_crew_injury->first_aid_case) && $incident_reports_crew_injury->first_aid_case)
                                            <option selected  hidden value="{{$incident_reports_crew_injury->first_aid_case}}" >{{$incident_reports_crew_injury->first_aid_case}}</option>
                                            @else
                                            <option selected  hidden value=""  ></option>
                                            @endif

                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Lead Investigator And  Supporting Team Members --}}
                                <div>
                                    <label for="Lead_Investigator">Lead Investigator</label>
                                    @if (isset($incident_report->lead_investigator) && $incident_report->lead_investigator)
                                    <textarea type="text"  class="form-control" id="Lead_Investigator" name="Lead_Investigator" placeholder="Lead Investigator..." autocomplete="off">{{$incident_report->lead_investigator}} </textarea>
                                    @else
                                    <textarea type="text"  class="form-control" id="Lead_Investigator" name="Lead_Investigator" placeholder="Lead Investigator..." autocomplete="off">{{$incident_report->lead_investigator}} </textarea>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-right mt-5">
                                        <a href="javascript:void(0)" class="btn btn-primary ml-auto" id="add_supporting_member" >Add More Member</a>
                                    </div>
                                    <label for="STM1">Supporting Team Members</label>
                                    @foreach ($incident_reports_supporting_team_members as $item)
                                    @if(isset($item->member_name) && isset($loop->iteration) && $loop->iteration && $item->member_name)
                                    <div id="add_supporting_member_content">
                                    <input type="text" value="{{$item->member_name}}"  class="form-control mb-3" id="STM_{{$loop->iteration}}" name="STM[]" placeholder="Supporting Team Members..." autocomplete="off">
                                    </div>
                                    @else
                                    <div id="add_supporting_member_content">
                                        <input type="text"   class="form-control mb-3" id="STM_1" name="STM[]" placeholder="Supporting Team Members..." autocomplete="off">
                                    </div>
                                    @endif
                                    @endforeach

                                </div>

                            </div>
                            {{-- ----------------------------------------------- Show if Crew injured End ---------------------------------------------- --}}
                        </div>





                        {{--  Vessel Details
                        ========================  --}}
                        <div class="tab form-group">
                            <h5 class="text-center my-3">VESSEL DETAILS</h5>

                            {{--  Name
                            ========================  --}}
                            <div class="form-group">
                                <label for="Name">Name</label>
                                <input
                                @if (isset($vessel_details->name) && $vessel_details->name)
                                value="{{$vessel_details->name}}"
                                @else
                                value=""
                                @endif
                                type="text"   class="form-control" id="Name" name="Name" placeholder="Name..." autocomplete="off">
                            </div>

                            {{--  Class Society
                            ========================  --}}
                            <div class="form-group">
                                <label for="Class_Society">Class Society</label>
                                <input
                                @if (isset($vessel_details->class_society) && $vessel_details->class_society)
                                value="{{$vessel_details->class_society}}"
                                @else
                                value=""
                                @endif

                                type="text"   class="form-control" id="Class_Society" name="Class_Society" placeholder="Class Society..." autocomplete="off">
                            </div>
                            <div class="form-row w-100">
                                {{--  IMO No
                            ========================  --}}
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="IMO_No">IMO No</label>
                                        <input
                                        @if (isset($vessel_details->imo_no) && $vessel_details->imo_no)
                                        value="{{$vessel_details->imo_no}}"
                                        @else
                                        value=""
                                        @endif type="text" class="form-control" id="IMO_No" name="IMO_No" placeholder="IMO No..." autocomplete="off">
                                    </div>
                                </div>
                                {{--  Year Built
                            ========================  --}}
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="Year_Built">Year Built</label>
                                        <input
                                        @if (isset($vessel_details->year_built) && $vessel_details->year_built)
                                        value="{{$vessel_details->year_built}}"
                                        @else
                                        value=""
                                        @endif type="text" class="form-control" id="Year_Built" name="Year_Built" placeholder="Year Built..." autocomplete="off">
                                    </div>
                                </div>
                                {{--  Type
                            ========================  --}}
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="Type">Type</label>
                                        <input
                                        @if (isset($vessel_details->type) && $vessel_details->type)
                                        value="{{$vessel_details->type}}"
                                        @else
                                        value=""
                                        @endif type="text" class="form-control" id="Type" name="Type" placeholder="Type..." autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            {{--  IMO No
                            ========================  --}}
                            {{-- <div class="form-group">
                                <label for="IMO_No">IMO No</label>
                                <input
                                @if (isset($vessel_details->imo_no) && $vessel_details->imo_no)
                                value="{{$vessel_details->imo_no}}"
                                @else
                                value=""
                                @endif

                                type="text" class="form-control" id="IMO_No" name="IMO_No" placeholder="IMO No..." autocomplete="off">
                            </div> --}}

                            {{--  Year Built
                            ========================  --}}
                            {{-- <div class="form-group">
                                <label for="Year_Built">Year Built</label>
                                <input
                                @if (isset($vessel_details->year_built) && $vessel_details->year_built)
                                value="{{$vessel_details->year_built}}"
                                @else
                                value=""
                                @endif

                                type="text" class="form-control" id="Year_Built" name="Year_Built" placeholder="Year Built..." autocomplete="off">
                            </div> --}}

                            {{--  Type
                            ========================  --}}
                            {{-- <div class="form-group">
                                <label for="Type">Type</label>
                                <input
                                @if (isset($vessel_details->type) && $vessel_details->type)
                                value="{{$vessel_details->type}}"
                                @else
                                value=""
                                @endif

                                type="text" class="form-control" id="Type" name="Type" placeholder="Type..." autocomplete="off">
                            </div> --}}

                            {{--  Owner
                            ========================  --}}
                            <div class="form-group">
                                <label for="Owner">Owner</label>
                                <input
                                @if (isset($vessel_details->owner) && $vessel_details->owner)
                                value="{{$vessel_details->owner}}"
                                @else
                                value=""
                                @endif

                                type="text" class="form-control" id="Owner" name="Owner" placeholder="Owner..." autocomplete="off">
                            </div>

                            {{--  Hull No and GRT
                            ========================  --}}
                            <div class="form-row w-100">
                                {{-- Hull No --}}
                                <div class="col-6 mb-3">
                                    <label for="Hull_No">Hull No</label>
                                    <input
                                    @if (isset($vessel_details->hull_no) && $vessel_details->hull_no)
                                    value="{{$vessel_details->hull_no}}"
                                    @else
                                    value=""
                                    @endif

                                    type="text" class="form-control" id="Hull_No" name="Hull_No" placeholder="Hull No..." autocomplete="off">
                                </div>
                                {{-- GRT --}}
                                <div class="col-6 mb-3">
                                    <label for="GRT">GRT</label>
                                    <input
                                    @if (isset($vessel_details->grt) && $vessel_details->grt)
                                    value="{{$vessel_details->grt}}"
                                    @else
                                    value=""
                                    @endif

                                    type="text" class="form-control" id="GRT" name="GRT" placeholder="GRT..." autocomplete="off">
                                </div>
                            </div>

                            {{--  Call Sign  And  Flag
                            ========================  --}}
                            <div class="form-row w-100">
                                {{-- Call Sign --}}
                                <div class="col-6 mb-3">
                                    <label for="Call_Sign">Call Sign</label>
                                    <input
                                    @if (isset($vessel_details->call_sign) && $vessel_details->call_sign)
                                    value="{{$vessel_details->call_sign}}"
                                    @else
                                    value=""
                                    @endif

                                    type="text" class="form-control" id="Call_Sign" name="Call_Sign" placeholder="Call Sign..." autocomplete="off">
                                </div>
                                {{-- Flag --}}
                                <div class="col-6 mb-3">
                                    <label for="Flag">Flag</label>
                                    <input
                                    @if (isset($vessel_details->flag) && $vessel_details->flag)
                                    value="{{$vessel_details->flag}}"
                                    @else
                                    value=""
                                    @endif

                                    type="text" class="form-control" id="Flag" name="Flag" placeholder="Flag..." autocomplete="off">
                                </div>
                            </div>

                            {{--  NRT And  Length (m)
                            ========================  --}}
                            <div class="form-row w-100">
                                {{-- NRT --}}
                                <div class="col-6 mb-3">
                                    <label for="NRT">NRT</label>
                                    <input
                                    @if (isset($vessel_details->nrt) && $vessel_details->nrt)
                                    value="{{$vessel_details->nrt}}"
                                    @else
                                    value=""
                                    @endif

                                    type="text" class="form-control" id="NRT" name="NRT" placeholder="NRT..." autocomplete="off">
                                </div>
                                {{-- Length (m) --}}
                                <div class="col-6 mb-3">
                                    <label for="Length">Length (m)</label>
                                    <input
                                    @if (isset($vessel_details->length) && $vessel_details->length)
                                    value="{{$vessel_details->length}}"
                                    @else
                                    value=""
                                    @endif

                                    type="text" class="form-control" id="Length" name="Length" placeholder="Length(m)..." autocomplete="off">
                                </div>
                            </div>
                            <div class="form-row w-100">
                                {{-- breadth (m) --}}
                                <div class="col-6 mb-3">
                                    <label for="breadth">Breadth (m)</label>
                                    <input
                                    @if (isset($vessel_details->breadth) && $vessel_details->breadth)
                                    value="{{$vessel_details->breadth}}"
                                    @else
                                    value=""
                                    @endif

                                    type="text" class="form-control" id="breadth" name="breadth" placeholder="Breadth (m)..." autocomplete="off">
                                </div>
                                {{-- depth (m) --}}
                                <div class="col-6 mb-3">
                                    <label for="depth">Depth (m)</label>
                                    <input
                                    @if (isset($vessel_details->moulded_depth) && $vessel_details->moulded_depth)
                                    value="{{$vessel_details->moulded_depth}}"
                                    @else
                                    value=""
                                    @endif

                                    type="text" class="form-control" id="depth" name="depth" placeholder="Depth(m)..." autocomplete="off">
                                </div>
                            </div>
                            {{--  Port of Registry
                            ===============================  --}}
                            <div class="form-group">
                                <label for="Port_of_Registry">Port of Registry</label>
                                <input
                                @if (isset($vessel_details->port_of_registry) && $vessel_details->port_of_registry)
                                value="{{$vessel_details->port_of_registry}}"
                                @else
                                value=""
                                @endif

                                type="text" class="form-control" id="Port_of_Registry" name="Port_of_Registry" placeholder="Port of Registry..." autocomplete="off">
                            </div>
                        </div>




                        {{--  EVENT INFORMATION
                        ========================  --}}
                        <div class="tab form-group">

                            <h5 class="text-center my-3">EVENT INFORMATION</h5>

                            {{--  Place of the incident
                            ========================  --}}
                            <div class="form-row ">
                                <div class="col-6 mb-3">
                                    <label for="NRT">Place of the incident</label>
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
                                @if (isset($incident_reports_event_information->place_of_incident) && $incident_reports_event_information->place_of_incident)
                                <div class="col-6 mb-3" @if($incident_reports_event_information->place_of_incident == 'At Sea') style="display: block;" @else style="display: none;" @endif  id="poi2">
                                    <label for="NRT" class="pb-3"></label>
                                    <input type="text" value="{{$incident_reports_event_information->place_of_incident_position}}" class="form-control" id="Place_of_the_incident_2nd" name="Place_of_the_incident_2nd" placeholder="Position in Lat / Long">
                                </div>
                                @else
                                <div></div>
                                @endif

                            </div>


                            {{--  date time and lmt gmt of incident
                            =========================================  --}}
                            <div class="form-row">
                                {{-- Date of incident --}}
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="NRT">Date of incident</label>
                                    <input  type="text"
                                    @if (isset($incident_reports_event_information->date_of_incident) && $incident_reports_event_information->date_of_incident)
                                    value="{{$incident_reports_event_information->date_of_incident}}"
                                    @else
                                    value=""
                                    @endif

                                    class="form-control date" id="Date_of_incident_event_information" name="Date_of_incident_event_information" placeholder="Date of incident..." autocomplete="off">
                                </div>
                                {{-- lmt --}}
                                <div class="col-12 col-md-4 mb-3 clockpicker">
                                    <label for="Length">Time of incident</label>
                                    <input
                                    @if (isset($incident_reports_event_information->time_of_incident_lt) && $incident_reports_event_information->time_of_incident_lt)
                                    value="{{$incident_reports_event_information->time_of_incident_lt}}"
                                    @else
                                    value=""
                                    @endif

                                    type="text" class="form-control" id="Time_of_incident_event_information_LMT" name="Time_of_incident_event_information_LMT" placeholder="LMT..." autocomplete="off">
                                </div>

                                {{-- GMT --}}
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="Length"></label>
                                    <select class="form-control" id="Time_of_incident_event_information_GMT" name="Time_of_incident_event_information_GMT">

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
                                <input  type="text"
                                @if (isset($incident_reports_event_information->location_of_incident) && $incident_reports_event_information->location_of_incident)
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
                                        <option value="others">others (If others pls specify)</option>
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
                                    <label for="Length">Direction(Degree)</label>
                                    <input type="number"
                                    @if (isset($incident_reports_weather->wind_direction) && $incident_reports_weather->wind_direction)
                                    value="{{$incident_reports_weather->wind_direction}}"
                                    @else
                                    value=""
                                    @endif

                                    class="form-control degree" id="Direction" name="Direction" placeholder="Direction..." autocomplete="off">
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
                                                <td><1</td>
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
                            <div class="form-row w-100">
                                {{-- sea force --}}
                                {{-- <div class="col-6 mb-3">
                                    <label for="Sea">Sea</label>
                                    <input
                                    @if (isset($incident_reports_weather->sea_wave) && $incident_reports_weather->sea_wave)
                                    value="{{$incident_reports_weather->sea_wave}}"
                                    @else
                                    value=""
                                    @endif

                                    type="number" class="form-control" id="Sea" name="Sea" placeholder="Sea..." autocomplete="off">
                                </div> --}}
                                {{-- sea Direction --}}
                                {{-- <div class="col-6 mb-3">
                                    <label for="sea_Direction">Direction(Degree)</label>
                                    <input type="number"
                                    @if (isset($incident_reports_weather->sea_direction) && $incident_reports_weather->sea_direction)
                                    value="{{$incident_reports_weather->sea_direction}}"
                                    @else
                                    value=""
                                    @endif

                                    class="form-control degree" id="sea_Direction" name="sea_Direction" placeholder="Direction..." autocomplete="off">
                                </div> --}}
                            </div>


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
                                    <input  type="number"
                                    data-target-picker="#degree_picker_2"
                                    @if (isset($incident_reports_weather->swell_direction) && $incident_reports_weather->swell_direction)
                                    value="{{$incident_reports_weather->swell_direction}}"
                                    @else
                                    value=""
                                    @endif

                                    class="form-control degree" id="Swell_direction" name="Swell_direction" placeholder="Direction(Degree)..." autocomplete="off">
                                </div>
                            </div>


                            {{--  Sky
                            ==================================  --}}
                            <div class="form-group">
                                <label for="Class_Society">Sky</label>
                                {{-- <input  type="text"   class="form-control" id="Sky" name="Sky" placeholder="Sky..." autocomplete="off"> --}}
                                <select class="form-control" id="Sky" name="Sky">
                                    <option selected  hidden
                                    @if (isset($incident_reports_weather->sky) && $incident_reports_weather->sky)
                                    value="{{$incident_reports_weather->sky}}"
                                    @else
                                    value=""
                                    @endif
                                >{{$incident_reports_weather->sky}}</option>
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
                                <div class="col-4 mb-3">
                                    <label for="Rolling">Rolling(Degree)</label>
                                    <input type="number"
                                    data-target-picker="#degree_picker_3"
                                    @if (isset($incident_reports_weather->rolling) && $incident_reports_weather->rolling)
                                    value="{{$incident_reports_weather->rolling}}"
                                    @else
                                    value=""
                                    @endif

                                    class="form-control degree" id="Rolling" name="Rolling" placeholder="Rolling..." autocomplete="off">
                                </div>
                                {{-- Pitcing --}}
                                <div class="col-4 mb-3">
                                    <label for="Pitcing">Pitcing(Degree)</label>
                                    <input type="number"
                                    data-target-picker="#degree_picker_4"
                                    @if (isset($incident_reports_weather->pitching) && $incident_reports_weather->pitching)
                                    value="{{$incident_reports_weather->pitching}}"
                                    @else
                                    value=""
                                    @endif

                                    class="form-control degree" id="Pitcing" name="Pitcing" placeholder="Pitcing..." autocomplete="off">
                                </div>
                            </div>


                            {{--  Illumination
                            ==================================  --}}
                            <div class="form-group">
                                <label for="Class_Society">Illumination</label>
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
                                        <select  class="form-control" name="pi_club_information" id="pi_club_information">
                                            @if (isset($incident_report->p_n_i_club_informed) && $incident_report->p_n_i_club_informed)
                                            <option disabled selected value="{{$incident_report->p_n_i_club_informed}}">{{$incident_report->p_n_i_club_informed}}</option>
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
                                        <select  class="form-control" name="hm_informed" id="hm_informed">
                                            @if (isset($incident_report->h_n_m_informed) && $incident_report->h_n_m_informed)
                                            <option disabled selected value="{{$incident_report->h_n_m_informed}}">{{$incident_report->h_n_m_informed}}</option>
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
                                        @if (isset($incident_report->type_of_loss_remarks) && $incident_report->type_of_loss_remarks)
                                        <textarea type="text" name="remarks_tol" id="remarks_tol" placeholder="Remarks..." class="form-control" spellcheck="false">{{$incident_report->type_of_loss_remarks}}</textarea>
                                @else
                                <textarea type="text" name="remarks_tol" id="remarks_tol" placeholder="Remarks..." class="form-control" spellcheck="false"></textarea>
                                @endif
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
                                @if (isset($incident_report->incident_brief) && $incident_report->incident_brief)
                                <textarea type="text" class="form-control" id="Incident_in_brief" name="Incident_in_brief" placeholder="Incident in brief..." autocomplete="off">{{$incident_report->incident_brief}} </textarea>
                                @else
                                <textarea type="text" class="form-control" id="Incident_in_brief" name="Incident_in_brief" placeholder="Incident in brief..." autocomplete="off"> </textarea>
                                @endif
                            </div>


                        </div>
                        {{--  Incident in Brief End
                        ================================  --}}




                        {{--  Event Log
                        ========================  --}}
                        <div class="tab form-group">

                            <h5 class="text-center my-3">EVENT LOG</h5>


                            {{--  Event log
                            ==================================  --}}
                            <div class="form-group">
                                <label for="Class_Society">Class Society</label>

                                <div class="text-right my-3">
                                    <a style="text-decoration: none;" class="btn btn-primary text-light" id="add_event_log">Add More Event Log</a>
                                </div>
                                <table class="table">
                                <thead class="bg-primary text-light" style="border-radious:14px;">
                                    <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody id="event_body">

                                    @foreach ( $incident_reports_event_logs as $log )
                                    @if ($log->date && $log->time)
                                    <tr>
                                        <td><input type="text" value="{{$log->date}}" class="form-control date" id="event_date_{{$loop->iteration}}" name="event_date[]" placeholder="Date..." autocomplete="off"></td>
                                        <td class="clockpicker"><input type="text" value="{{$log->time}}" class="form-control" id="event_time_{{$loop->iteration}}" name="event_time[]" placeholder="Time..." autocomplete="off"></td>
                                        <td><textarea type="text" class="form-control" id="event_remarks_{{$loop->iteration}}" name="event_remarks[]" placeholder="Remarks..." autocomplete="off">{{$log->remarks}}</textarea></td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                                </table>



                            </div>


                        </div>
                        {{--  Event Log End
                        ========================  --}}





                        {{--  INCIDENT INVESTIGATION AND ROOT CAUSE FINDINGS
                        ==============================================================  --}}
                        <div class="tab form-group">

                            <h5 class="text-center my-3">INCIDENT INVESTIGATION AND ROOT CAUSE FINDINGS</h5>


                            {{--  Event Details
                            ==================================  --}}
                            <div class="form-group ">
                                <a style="text-decoration:none;" id="Add_more_event_investigation_btn" class="btn btn-primary text-light float-right my-3">+</a>
                                <label for="Event_Details_IIARCF">Event Details</label>
                                <div id="Add_more_event_investigation">
                                    @foreach ( $incident_reports_event_details as $dt )
                                    @if (isset($dt->details) && $dt->details)
                                    <textarea type="text"   class="form-control my-2" id="Event_Details_IIARCF_{{$loop->iteration}}" name="Event_Details_IIARCF[]" placeholder="Event Details..." autocomplete="off">{{$dt->details}}</textarea>
                                    @endif
                                    @endforeach
                                </div>
                            </div>

                            {{-- Risk Category
                            =================== --}}
                            <div class="form-group ">
                                <label for="Risk_category_IIARCF">Risk Category</label>
                                <select class="form-control" id="Risk_category_IIARCF" name="Risk_category_IIARCF">
                                    @if($incident_report->risk_category)
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
                            <div class="card p-5 shadow" id="SAFETY_display_control" @if($incident_report->risk_category == 'SAFETY') style="display: block;" @else style="display: none;" @endif >
                                <h3 class="text-center mt-5">SAFETY</h3>

                                {{-- first dropdown --}}
                                <div class="form-group w-100">
                                    <label for=""></label>
                                    <select class="form-control custom px-5" name="IIARCF_safety_first_dropdown" id="IIARCF_safety_first_dropdown">
                                        @if($incident_reports_risk_details->risk)
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
                                        <select class="form-control custom" name="IIARCF_safety_Severity" id="IIARCF_safety_Severity">
                                            @if($incident_reports_risk_details->severity)
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
                                        <select class="form-control custom" name="IIARCF_safety_Likelihood" id="IIARCF_safety_Likelihood">
                                            @if($incident_reports_risk_details->likelihood)
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
                                    @if($incident_reports_risk_details->result)
                                        <textarea class="form-control custom" name="IIARCF_safety_Result" id="IIARCF_safety_Result">{{$incident_reports_risk_details->result}}</textarea>
                                    @else
                                        <textarea class="form-control custom" name="IIARCF_safety_Result" id="IIARCF_safety_Result"></textarea>
                                    @endif
                                </div>

                                {{-- Name of the person --}}
                                <div class="form-group">
                                    <label for="">Name of the person</label>
                                    @if($incident_reports_risk_details->name_of_person)
                                        <input class="form-control custom" type="text" name="IIARCF_safety_NameOfThePerson" id="IIARCF_safety_NameOfThePerson" value="{{$incident_reports_risk_details->name_of_person}}">
                                    @else
                                        <input value="" class="form-control custom" type="text" name="IIARCF_safety_NameOfThePerson" id="IIARCF_safety_NameOfThePerson" >
                                    @endif
                                </div>

                                {{-- Type of injury --}}
                                <div class="form-group">
                                    <label for="">Type of injury</label>
                                    @if($incident_reports_risk_details->type_of_injury)
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
                                        <input
                                        @if ($incident_reports_risk_details->associated_cost_usd && isset($incident_reports_risk_details->associated_cost_usd))
                                        value="{{$incident_reports_risk_details->associated_cost_usd}}"
                                        @else
                                        value=""
                                        @endif
                                        class="form-control custom" type="number" name="IIARCF_safety_AssociatedCost" id="IIARCF_safety_AssociatedCost" placeholder="USD...">
                                    </div>
                                    {{-- country list --}}
                                    <div class="form-group col-4">
                                        <label for="selected_currency_safety">Select Currency</label>
                                        <select class="form-control custom" id="selected_currency_safety" name="selected_currency_safety">
                                            @if ($incident_reports_risk_details->currency_code)
                                            <option selected disabled value="{{$incident_reports_risk_details->currency_code}}" >{{$incident_reports_risk_details->currency_code}}</option>
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
                                        <input
                                        @if ($incident_reports_risk_details->associated_cost_loca)
                                        value="{{$incident_reports_risk_details->associated_cost_loca}}"
                                        @else
                                        value=""
                                        @endif
                                        class="form-control custom" type="number" name="IIARCF_safety_localCurrency" id="IIARCF_HEALTH_localCurrency" placeholder="Amount...">
                                    </div>
                                </div>

                            </div>

                            {{-- HEALTH --}}
                            <div class="card p-5 shadow" id="HEALTH_display_control" @if($incident_report->risk_category == 'HEALTH') style="display: block;" @else style="display: none;" @endif >
                                <h3 class="text-center mt-5">HEALTH</h3>

                                {{-- first dropdown --}}
                                <div class="form-group w-100">
                                    <label for=""></label>
                                    <select class="form-control custom px-5" name="IIARCF_HEALTH_first_dropdown" id="IIARCF_HEALTH_first_dropdown">
                                        @if($incident_reports_risk_details->risk)
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
                                        <select class="form-control custom" name="IIARCF_HEALTH_Severity" id="IIARCF_HEALTH_Severity">
                                            @if($incident_reports_risk_details->severity)
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
                                        <select class="form-control custom" name="IIARCF_HEALTH_Likelihood" id="IIARCF_HEALTH_Likelihood">
                                            @if($incident_reports_risk_details->likelihood)
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
                                    @if($incident_reports_risk_details->result)
                                        <textarea class="form-control custom" name="IIARCF_HEALTH_Result" id="IIARCF_HEALTH_Result">{{$incident_reports_risk_details->result}}</textarea>
                                    @else
                                        <textarea class="form-control custom" name="IIARCF_HEALTH_Result" id="IIARCF_HEALTH_Result"></textarea>
                                    @endif
                                </div>

                                {{-- Name of the person --}}
                                <div class="form-group">
                                    <label for="">Name of the person</label>
                                    @if($incident_reports_risk_details->name_of_person)
                                        <input class="form-control custom" type="text" name="IIARCF_HEALTH_NameOfThePerson" id="IIARCF_HEALTH_NameOfThePerson" value="{{$incident_reports_risk_details->name_of_person}}">
                                    @else
                                        <input value="" class="form-control custom" type="text" name="IIARCF_HEALTH_NameOfThePerson" id="IIARCF_HEALTH_NameOfThePerson" >
                                    @endif
                                </div>

                                {{-- Type of injury --}}
                                <div class="form-group">
                                    <label for="">Type of injury</label>
                                    @if($incident_reports_risk_details->type_of_injury)
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
                                        <input
                                        @if ($incident_reports_risk_details->associated_cost_usd)
                                            value="{{$incident_reports_risk_details->associated_cost_usd}}"
                                        @else
                                            value=""
                                        @endif
                                        class="form-control custom" type="number" name="IIARCF_safety_AssociatedCost" id="IIARCF_safety_AssociatedCost" placeholder="USD...">
                                    </div>
                                    {{-- country list --}}
                                    <div class="form-group col-4">
                                        <label for="selected_currency_safety">Select Currency</label>
                                        <select class="form-control custom" id="selected_currency_safety" name="selected_currency_safety">
                                            @if ($incident_reports_risk_details->currency_code)
                                            <option selected disabled value="{{$incident_reports_risk_details->currency_code}}" >{{$incident_reports_risk_details->currency_code}}</option>
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
                                        <input
                                        @if ($incident_reports_risk_details->associated_cost_loca)
                                            value="{{$incident_reports_risk_details->associated_cost_loca}}"
                                        @else
                                            value=""
                                        @endif
                                        class="form-control custom" type="number" name="IIARCF_safety_localCurrency" id="IIARCF_HEALTH_localCurrency" placeholder="Amount...">
                                    </div>
                                </div>

                            </div>

                            {{-- ENVIRONMENT --}}
                            <div class="card p-5 shadow" id="ENVIRONMENT_display_control" @if($incident_report->risk_category == 'ENVIRONMENT') style="display: block;" @else style="display: none;" @endif>
                                <h3 class="text-center mt-5">ENVIRONMENT</h3>

                                {{-- first dropdown --}}
                                <div class="form-group w-100">
                                    <label for=""></label>
                                    <select class="form-control custom px-5" name="IIARCF_ENVIRONMENT_first_dropdown" id="IIARCF_ENVIRONMENT_first_dropdown">
                                        @if($incident_reports_risk_details->risk)
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
                                        <select class="form-control custom" name="IIARCF_ENVIRONMENT_Severity" id="IIARCF_ENVIRONMENT_Severity">
                                            @if($incident_reports_risk_details->severity)
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
                                        <select class="form-control custom" name="IIARCF_ENVIRONMENT_Likelihood" id="IIARCF_ENVIRONMENT_Likelihood">
                                            @if($incident_reports_risk_details->likelihood)
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
                                    <label for="IIARCF_ENVIRONMENT_Result"> Result</label>
                                    @if($incident_reports_risk_details->result)
                                        <textarea class="form-control custom" name="IIARCF_ENVIRONMENT_Result" id="IIARCF_ENVIRONMENT_Result">{{$incident_reports_risk_details->result}}</textarea>
                                    @else
                                        <textarea class="form-control custom" name="IIARCF_ENVIRONMENT_Result" id="IIARCF_ENVIRONMENT_Result"></textarea>
                                    @endif
                                </div>

                                {{-- Type of pollution --}}
                                <div class="form-group">
                                    <label for="">Type of pollution</label>
                                    @if($incident_reports_risk_details->type_of_pollution)
                                        <input class="form-control custom" type="text" name="IIARCF_ENVIRONMENT_TypeOfPollution" id="IIARCF_ENVIRONMENT_TypeOfPollution" value="{{$incident_reports_risk_details->type_of_pollution}}">
                                    @else
                                        <input value="" class="form-control custom" type="text" name="IIARCF_ENVIRONMENT_TypeOfPollution" id="IIARCF_ENVIRONMENT_TypeOfPollution" >
                                    @endif
                                </div>

                                {{-- Quantity of pollutant --}}
                                <div class="form-group">
                                    <label for="">Quantity of pollutant</label>
                                    @if($incident_reports_risk_details->quantity_of_pollutant)
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
                                        <input
                                        @if ($incident_reports_risk_details->associated_cost_usd)
                                            value="{{$incident_reports_risk_details->associated_cost_usd}}"
                                        @else
                                            value=""
                                        @endif
                                        class="form-control custom" type="number" name="IIARCF_safety_AssociatedCost" id="IIARCF_safety_AssociatedCost" placeholder="USD...">
                                    </div>
                                    {{-- country list --}}
                                    <div class="form-group col-4">
                                        <label for="selected_currency_safety">Select Currency</label>
                                        <select class="form-control custom" id="selected_currency_safety" name="selected_currency_safety">
                                            @if ($incident_reports_risk_details->currency_code)
                                            <option selected disabled value="{{$incident_reports_risk_details->currency_code}}" >{{$incident_reports_risk_details->currency_code}}</option>
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
                                        <input
                                        @if ($incident_reports_risk_details->associated_cost_loca)
                                            value="{{$incident_reports_risk_details->associated_cost_loca}}"
                                        @else
                                            value=""
                                        @endif
                                        class="form-control custom" type="number" name="IIARCF_safety_localCurrency" id="IIARCF_HEALTH_localCurrency" placeholder="Amount...">
                                    </div>
                                </div>

                                {{-- Contained spill and Total Spilled quantity  --}}
                                <div class="form-row my-3">
                                    <div class="col-6">
                                        <label for="">Contained spill</label>
                                        @if($incident_reports_risk_details->contained_spill)
                                            <input type="number" placeholder="Contained spill ..." name="IIARCF_ENVIRONMENT_ContainedSpill" class="form-control custom" id="IIARCF_ENVIRONMENT_ContainedSpill" value="{{$incident_reports_risk_details->contained_spill}}">
                                        @else
                                            <input type="number" placeholder="Contained spill ..." name="IIARCF_ENVIRONMENT_ContainedSpill" class="form-control custom" id="IIARCF_ENVIRONMENT_ContainedSpill" value="">
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <label for="">Total Spilled quantity</label>
                                        @if($incident_reports_risk_details->total_spilled_quantity)
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
                                        @if($incident_reports_risk_details->spilled_in_water)
                                            <input type="number" name="IIARCF_ENVIRONMENT_SpilledInWater" class="form-control custom" id="IIARCF_ENVIRONMENT_SpilledInWater" placeholder="Spilled in Water ..." value="{{$incident_reports_risk_details->spilled_in_water}}">
                                        @else
                                            <input type="number" name="IIARCF_ENVIRONMENT_SpilledInWater" class="form-control custom" id="IIARCF_ENVIRONMENT_SpilledInWater" placeholder="Spilled in Water ..." value="">
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <label for="">Spilled Ashore</label>
                                        @if($incident_reports_risk_details->spilled_ashore)
                                            <input type="number" class="form-control custom" placeholder="Spilled Ashore ..." name="IIARCF_ENVIRONMENT_SpilledAshore" id="IIARCF_ENVIRONMENT_SpilledAshore" value="{{$incident_reports_risk_details->spilled_ashore}}">
                                        @else
                                            <input type="number" class="form-control custom" placeholder="Spilled Ashore ..." name="IIARCF_ENVIRONMENT_SpilledAshore" id="IIARCF_ENVIRONMENT_SpilledAshore" value="">
                                        @endif
                                    </div>
                                </div>

                            </div>

                            {{-- OPERATIONAL IMPACT --}}
                            <div class="card p-5 shadow" id="OPERATIONAL_IMPACT_display_control" @if($incident_report->risk_category == 'OPERATIONAL IMPACT') style="display: block;" @else style="display: none;" @endif>
                                <h3 class="text-center mt-5">OPERATIONAL IMPACT</h3>

                                {{-- vessel cargo third party --}}
                                <div class="form-row">
                                    <div class="col-4">
                                        <label for="">Vessel</label>
                                        @if($incident_reports_risk_details->vessel)
                                            <input type="text" value="{{$incident_reports_risk_details->vessel}}" name="IIARCF_OPERATIONAL_IMPACT_Vessel" id="IIARCF_OPERATIONAL_IMPACT_Vessel" class="form-control custom">
                                        @else
                                            <input value="" type="text" name="IIARCF_OPERATIONAL_IMPACT_Vessel" id="IIARCF_OPERATIONAL_IMPACT_Vessel" class="form-control custom">
                                        @endif
                                    </div>
                                    <div class="col-4">
                                        <label for="">Cargo</label>
                                        @if($incident_reports_risk_details->cargo)
                                            <input type="text" value="{{$incident_reports_risk_details->cargo}}" name="IIARCF_OPERATIONAL_IMPACT_Cargo" id="IIARCF_OPERATIONAL_IMPACT_Cargo" class="form-control custom">
                                        @else
                                            <input value="" type="text" name="IIARCF_OPERATIONAL_IMPACT_Cargo" id="IIARCF_OPERATIONAL_IMPACT_Cargo" class="form-control custom">
                                        @endif
                                    </div>
                                    <div class="col-4">
                                        <label for="">Third Party</label>
                                        @if($incident_reports_risk_details->third_party)
                                            <input type="text" value="{{$incident_reports_risk_details->third_party}}" name="IIARCF_OPERATIONAL_IMPACT_Third_Party" id="IIARCF_OPERATIONAL_IMPACT_Third_Party" class="form-control custom">
                                        @else
                                            <input value="" type="text"  name="IIARCF_OPERATIONAL_IMPACT_Third_Party" id="IIARCF_OPERATIONAL_IMPACT_Third_Party" class="form-control custom">
                                        @endif
                                    </div>
                                </div>

                                {{-- first dropdown --}}
                                <div class="form-group mx-5">
                                    <label for=""></label>
                                    <select class="form-control custom px-5" name="IIARCF_OPERATIONAL_IMPACT_first_dropdown" id="IIARCF_OPERATIONAL_IMPACT_first_dropdown">
                                        @if($incident_reports_risk_details->risk)
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

                                {{-- Severity and  likelihood --}}
                                <div class="form-row">
                                    {{-- Severity --}}
                                    <div class="col-6">
                                        <label for="IIARCF_OPERATIONAL_IMPACT_Severity">Severity</label>
                                        <select class="form-control custom" name="IIARCF_OPERATIONAL_IMPACT_Severity" id="IIARCF_OPERATIONAL_IMPACT_Severity">
                                            @if($incident_reports_risk_details->severity)
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
                                        <select class="form-control custom" name="IIARCF_OPERATIONAL_IMPACT_Likelihood" id="IIARCF_OPERATIONAL_IMPACT_Likelihood">
                                            @if($incident_reports_risk_details->likelihood)
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
                                        @if ($incident_reports_risk_details->result)
                                        <textarea class="form-control custom" name="IIARCF_OPERATIONAL_IMPACT_Result" id="IIARCF_OPERATIONAL_IMPACT_Result" disabled="disabled">{{$incident_reports_risk_details->result}}</textarea>
                                        @else
                                        <textarea class="form-control custom" name="IIARCF_OPERATIONAL_IMPACT_Result" id="IIARCF_OPERATIONAL_IMPACT_Result" disabled="disabled"></textarea>
                                        @endif
                                    </div>
                                </div>
                                {{-- Damage description --}}
                                <div class="form-group">
                                    <label for="IIARCF_OPERATIONAL_IMPACT_Damage_description">Damage description</label>
                                    @if($incident_reports_risk_details->damage_description)
                                        <textarea class="form-control custom" placeholder="Damage description ..." name="IIARCF_OPERATIONAL_IMPACT_Damage_description" id="IIARCF_OPERATIONAL_IMPACT_Damage_description">{{$incident_reports_risk_details->damage_description}}</textarea>
                                    @else
                                        <textarea class="form-control custom" placeholder="Damage description ..." name="IIARCF_OPERATIONAL_IMPACT_Damage_description" id="IIARCF_OPERATIONAL_IMPACT_Damage_description"></textarea>
                                    @endif
                                </div>

                                {{-- Off hire if any --}}
                                <div class="form-group">
                                    <label for="">Off hire if any</label>
                                    @if($incident_reports_risk_details->off_hire)
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
                                        <input
                                        @if ($incident_reports_risk_details->associated_cost_usd)
                                            value="{{$incident_reports_risk_details->associated_cost_usd}}"
                                        @else
                                            value=""
                                        @endif
                                        class="form-control custom" type="number" name="IIARCF_safety_AssociatedCost" id="IIARCF_safety_AssociatedCost" placeholder="USD...">
                                    </div>
                                    {{-- country list --}}
                                    <div class="form-group col-4">
                                        <label for="selected_currency_safety">Select Currency</label>
                                        <select class="form-control custom" id="selected_currency_safety" name="selected_currency_safety">
                                            @if ($incident_reports_risk_details->currency_code)
                                            <option selected disabled value="{{$incident_reports_risk_details->currency_code}}" >{{$incident_reports_risk_details->currency_code}}</option>
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
                                        <input
                                        @if ($incident_reports_risk_details->associated_cost_loca)
                                            value="{{$incident_reports_risk_details->associated_cost_loca}}"
                                        @else
                                            value=""
                                        @endif
                                        class="form-control custom" type="number" name="IIARCF_safety_localCurrency" id="IIARCF_HEALTH_localCurrency" placeholder="Amount...">
                                    </div>
                                </div>

                            </div>

                            {{-- MEDIA --}}
                            <div class="card p-5 shadow" id="MEDIA_display_control" @if($incident_report->risk_category == 'MEDIA') style="display: block;" @else style="display: none;" @endif>
                                <h3 class="text-center mt-5">MEDIA</h3>

                                {{-- first dropdown --}}
                                <div class="form-group w-100">
                                    <label for=""></label>
                                    <select class="form-control custom px-5" name="IIARCF_MEDIA_first_dropdown" id="IIARCF_MEDIA_first_dropdown">
                                        @if($incident_reports_risk_details->risk)
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
                                        <select class="form-control custom" name="IIARCF_MEDIA_Severity" id="IIARCF_MEDIA_Severity">
                                            @if($incident_reports_risk_details->severity)
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
                                        <select class="form-control custom" name="IIARCF_MEDIA_Likelihood" id="IIARCF_MEDIA_Likelihood">
                                            @if($incident_reports_risk_details->likelihood)
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
                                    @if($incident_reports_risk_details->result)
                                        <textarea class="form-control custom" name="IIARCF_MEDIA_Result" id="IIARCF_MEDIA_Result">{{$incident_reports_risk_details->result}}</textarea>
                                    @else
                                        <textarea class="form-control custom" name="IIARCF_MEDIA_Result" id="IIARCF_MEDIA_Result"></textarea>
                                    @endif
                                </div>

                                {{-- describtion --}}
                                <div class="form-group">
                                    <label for="">Description</label>
                                    @if($incident_reports_risk_details->description)
                                        <textarea class="form-control custom" type="text" name="IIARCF_MEDIA_describtion" id="IIARCF_MEDIA_describtion"> {{$incident_reports_risk_details->description}}</textarea>
                                    @else
                                        <textarea class="form-control custom" type="text" name="IIARCF_MEDIA_describtion" id="IIARCF_MEDIA_describtion"></textarea>
                                    @endif
                                </div>


                                {{-- Associated Cost --}}
                                <div class="form-row">
                                    {{-- USD --}}
                                    <div class="col-4">
                                        <label for="">Associated cost</label>
                                        <input
                                        @if ($incident_reports_risk_details->associated_cost_usd)
                                            value="{{$incident_reports_risk_details->associated_cost_usd}}"
                                        @else
                                            value=""
                                        @endif
                                        class="form-control custom" type="number" name="IIARCF_safety_AssociatedCost" id="IIARCF_safety_AssociatedCost" placeholder="USD...">
                                    </div>
                                    {{-- country list --}}
                                    <div class="form-group col-4">
                                        <label for="selected_currency_safety">Select Currency</label>
                                        <select class="form-control custom" id="selected_currency_safety" name="selected_currency_safety">
                                            @if ($incident_reports_risk_details->currency_code)
                                            <option selected disabled value="{{$incident_reports_risk_details->currency_code}}" >{{$incident_reports_risk_details->currency_code}}</option>
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
                                        <input
                                        @if ($incident_reports_risk_details->associated_cost_loca)
                                            value="{{$incident_reports_risk_details->associated_cost_loca}}"
                                        @else
                                            value=""
                                        @endif
                                        class="form-control custom" type="number" name="IIARCF_safety_localCurrency" id="IIARCF_HEALTH_localCurrency" placeholder="Amount...">
                                    </div>
                                </div>

                                {{-- type and  text --}}
                                <div class="form-row">
                                    {{-- type --}}
                                    <div class="col-12">
                                        <label for="IIARCF_MEDIA_Severity">Type</label>
                                        <select class="form-control custom" name="IIARCF_MEDIA_type" id="IIARCF_MEDIA_type">
                                            @if($incident_reports_risk_details->type == 'VERY LOW 1')
                                                <option selected value="{{$incident_reports_risk_details->type}}">Operational</option>
                                            @elseif($incident_reports_risk_details->type == 'LOW 2')
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
                                                        <option value=0  selected>None Selected</option>
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
                                        <div class="form-group col-12 my-3" id="display_dd{{ $dd->id }}" style="display: none;">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="inputGroupSelect01">Options</label>
                                                </div>
                                                <select @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" ) multiple @endif class="custom-select droptwo"   @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" )  name="{{Str::lower($name)}}_second[]" @else name="{{Str::lower($name)}}_second"  @endif myidtwo="ddd{{ $dd->id }}" id="dd{{ $dd->id }}">
                                                    @if(Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause' )
                                                        <option value=0  selected>None Selected</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        {{-- Dropdown 3 --}}
                                        <div class="form-group col-12 my-3" id="display_ddd{{ $dd->id }}" style="display: none;">
                                            <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect01">Options</label>
                                            </div>
                                            <select @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" ) multiple @endif class="custom-select"  @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" )  name="{{Str::lower($name)}}_third[]" @else name="{{Str::lower($name)}}_third"  @endif id="ddd{{ $dd->id }}">
                                                    @if(Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause' )
                                                        <option value=0  selected>None Selected</option>
                                                    @endif
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach



                        </div>
                        {{--  INCIDENT INVESTIGATION AND ROOT CAUSE FINDINGS End
                        ==============================================================  --}}


                        {{-- SEE 5 WHY
                        ================================================================ --}}
                        <div class="tab form-group">
                            <h5 class="text-center my-3"> SEE 5 WHY </h5>


                            {{-- Incident for 5 why --}}
                            <div class="form-group">

                                <label for="incident_for_five_why">Incident</label>
                                <input
                                @if (isset($incident_reports_five_why->incident) && $incident_reports_five_why->incident)
                                value="{{$incident_reports_five_why->incident}}"
                                @else
                                value=""
                                @endif

                                type="text" name="incident_for_five_why" id="incident_for_five_why" class="form-control" placeholder="Incident ...">
                            </div>

                            {{-- first why for 5 why --}}
                            <div class="form-group" style="display:  @if ( $incident_reports_five_why->first_why != '' || $incident_reports_five_why->first_why != null ) block @else block @endif;" id="first_why_for_five_why_display">
                                <label for="first_why_for_five_why">First why</label>
                                <input
                                @if (isset($incident_reports_five_why->first_why) && $incident_reports_five_why->first_why)
                                value="{{ $incident_reports_five_why->first_why }}"
                                @else
                                value=""
                                @endif

                                type="text" name="first_why_for_five_why" id="first_why_for_five_why" class=" ml-1 form-control" placeholder="First why ...">
                                <div class="text-right my-1">
                                    <a class="btn btn-primary text-light" id="first_why_for_five_why_display_btn">Why ?</a>
                                </div>
                            </div>

                            {{-- second why for 5 why --}}
                            <div class="form-group" style="display: @if ( $incident_reports_five_why->second_why != '' || $incident_reports_five_why->second_why != null ) block @else none @endif;" id="second_why_for_five_why_display">
                                <label for="second_why_for_five_why">Second why</label>
                                <input
                                @if (isset($incident_reports_five_why->second_why) && $incident_reports_five_why->second_why)
                                value="{{ $incident_reports_five_why->second_why }}"
                                @else
                                value=""
                                @endif

                                type="text" name="second_why_for_five_why" id="second_why_for_five_why" class="ml-2 form-control" placeholder="Second why ...">
                                <div class="text-right my-1">
                                    <a class="btn btn-primary text-light" id="second_why_for_five_why_display_btn"> Why ?</a>
                                </div>
                            </div>

                            {{-- third why for 5 why --}}
                            <div class="form-group" style="display: @if ( $incident_reports_five_why->third_why != '' || $incident_reports_five_why->third_why != null ) block @else none @endif;" id="third_why_for_five_why_display">
                                <label for="third_why_for_five_why">Third why</label>
                                <input
                                @if (isset($incident_reports_five_why->third_why) && $incident_reports_five_why->third_why)
                                value="{{$incident_reports_five_why->third_why}}"
                                @else
                                value=""
                                @endif

                                type="text" name="third_why_for_five_why" id="third_why_for_five_why" class="ml-3 form-control" placeholder="Third why ...">
                                <div class="text-right my-1">
                                    <a class="btn btn-primary text-light" id="third_why_for_five_why_display_btn"> Why ?</a>
                                </div>
                            </div>

                            {{-- fourth why for 5 why --}}
                            <div class="form-group" style="display: @if ( $incident_reports_five_why->fourth_why != '' || $incident_reports_five_why->fourth_why != null ) block @else none @endif;" id="fourth_why_for_five_why_display">
                                <label for="fourth_why_for_five_why">Fourth why</label>
                                <input
                                @if (isset($incident_reports_five_why->fourth_why) && $incident_reports_five_why->fourth_why)
                                    value="{{$incident_reports_five_why->fourth_why}}"
                                @else
                                    value=""
                                @endif

                                type="text" name="fourth_why_for_five_why" id="fourth_why_for_five_why" class="ml-4 form-control" placeholder="Fourth why ...">
                                <div class="text-right my-1">
                                    <a class="btn btn-primary text-light" id="fourth_why_for_five_why_display_btn"> Why ?</a>
                                </div>
                            </div>

                            {{-- fifth why for 5 why --}}
                            <div class="form-group" style="display: @if ( $incident_reports_five_why->fifth_why != '' || $incident_reports_five_why->fifth_why != null ) block @else none @endif;" id="fifth_why_for_five_why_display">
                                <label for="fifth_why_for_five_why">Fifth why</label>
                                <input
                                @if (isset($incident_reports_five_why->fifth_why) && $incident_reports_five_why->fifth_why)
                                value="{{$incident_reports_five_why->fifth_why}}"
                                @else
                                value=""
                                @endif

                                type="text" name="fifth_why_for_five_why" id="fifth_why_for_five_why" class="ml-5 form-control" placeholder="Fifth why ...">
                            </div>

                            {{-- RootCause for 5 why --}}
                            <div class="form-group">
                                <label for="rootcause_for_five_why">RootCause</label>
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


                                @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions")
                                    <div class="form-row">
                                        {{-- Dropdown 1 --}}
                                        <div class="form-group col-12 my-3">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="inputGroupSelect01"> {{$dd->dropdown_name}} <span class="text-danger   font-weight-bold">*</span> </label>
                                                </div>

                                                <select id="{{Str::lower($name)}}" required @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" ) multiple @endif class="custom-select drop" myid="dd{{ $dd->id }}" @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" )  name="{{Str::lower($name)}}_first[]" @else name="{{Str::lower($name)}}_first"  @endif required >
                                                    @if(Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause' )
                                                        <option value=0  selected>None Selected</option>
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
                                        <div class="form-group col-12 my-3" id="display_dd{{ $dd->id }}" style="display: none;">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="inputGroupSelect01">Options</label>
                                                </div>
                                                <select @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" ) multiple @endif class="custom-select droptwo"   @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" )  name="{{Str::lower($name)}}_second[]" @else name="{{Str::lower($name)}}_second"  @endif myidtwo="ddd{{ $dd->id }}" id="dd{{ $dd->id }}">
                                                    @if(Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause' )
                                                        <option value=0  selected>None Selected</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        {{-- Dropdown 3 --}}
                                        <div class="form-group col-12 my-3" id="display_ddd{{ $dd->id }}" style="display: none;">
                                            <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect01">Options</label>
                                            </div>
                                            <select @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" ) multiple @endif class="custom-select"  @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" )  name="{{Str::lower($name)}}_third[]" @else name="{{Str::lower($name)}}_third"  @endif id="ddd{{ $dd->id }}">
                                                    @if(Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause' )
                                                        <option value=0  selected>None Selected</option>
                                                    @endif
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            {{-- Comment --}}
                            <div class="form-group">
                                <label for="">Comments</label>
                                <textarea name="five_why_comments" id="five_why_comments" class="form-control" placeholder="Comments ..."></textarea>
                            </div>

                            {{-- Follow up actions --}}
                            <div class="from-group">
                                @php $counter = 1;  @endphp
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">Sr No</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">PIC</th>
                                        <th scope="col">Department</th>
                                        <th scope="col">Target Date</th>
                                        <th scope="col">Completed Date</th>
                                        <th scope="col">Evidence Uploaded</th>
                                        <th scope="col">Cost</th>
                                        <th scope="col">Comments</th>
                                    </tr>
                                    </thead>
                                    <tbody id="add_more_actions_five_why_content">
                                        @foreach ($incident_reports_follow_up_actions as $item)
                                        @if ($item)
                                        <tr>
                                            <th scope="row">{{$counter}} <input type="hidden" name="sr_num_folowup[]" value="{{$counter}}"></th>
                                            <td><textarea                                                id="five_why_followup_action_describtion_{{$counter}}"        name="five_why_followup_action_describtion[]"          class="form-control">{{$item->description}}</textarea></td>
                                            <td><input value="{{$item->pic}}"               type="text"  id="five_why_followup_action_pic_{{$counter}}"                name="five_why_followup_action_pic[]"                  class="form-control"></td>
                                            <td><input value="{{$item->department}}"        type="text"  id="five_why_followup_action_department_{{$counter}}"         name="five_why_followup_action_department[]"           class="form-control"></td>
                                            <td><input value="{{$item->target_date}}"       type="text"  id="five_why_followup_action_target_date_{{$counter}}"        name="five_why_followup_action_target_date[]"          class="date form-control"></td>
                                            <td><input value="{{$item->completed_date}}"    type="text"  id="five_why_followup_action_completed_date_{{$counter}}"     name="five_why_followup_action_completed_date[]"       class="date form-control"></td>
                                            <td>
                                                <select id="five_why_followup_action_evidence_uploaded_{{$counter}}"
                                                onchange="is_evedence_uploaded('five_why_followup_action_evidence_uploaded_{{$counter}}')"
                                                name="five_why_followup_action_evidence_uploaded[]" class="form-control">
                                                    <option selected value="{{$item->evidence_uploaded}}" hidden>{{$item->evidence_uploaded}}</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                                <div class="file_upload p-2 my-3 text-center" id="five_why_followup_action_evidence_uploaded_{{$counter}}_evidence_display" @if($item->evidence_uploaded == 'No') style="display: none;" @else style="display: block;" @endif>
                                                    <input hidden  type="file" id="evdnc_file_{{$counter}}" name="evidence_file[]" value="{{ base_path('public/Incdent_Report_evidence_file/'.$item->evidence_file )  }}">
                                                    {{-- <input  type="text" id="evdnc_file_{{$counter}}" value="{{$item->evidence_file}}"> --}}
                                                    <textarea id="evdnc_text_{{$counter}}">{{$item->evidence_file}}</textarea>
                                                    <button class="btn btn-primary numo-btn " type="button" onclick="changeInput('evdnc_file_{{$counter}}','evdnc_text_{{$counter}}')">Change</button>

                                                </div>
                                            </td>
                                            <td><input value="{{$item->cost}}"              type="text"  id="five_why_followup_action_cost_{{$counter}}"               name="five_why_followup_action_cost[]"                 class="form-control"></td>
                                            <td><input value="{{$item->comments}}"          type="text"  id="five_why_followup_action_comments_{{$counter}}"           name="five_why_followup_action_comments[]"             class="form-control"></td>
                                        </tr>
                                        @php
                                            $counter++;
                                        @endphp
                                        @endif

                                        @endforeach

                                    </tbody>
                                </table>
                                <div class="text-center">
                                    <a id="add_more_actions_five_why" count={{$counter}} class="btn btn-primary text-light ml-auto mr-auto my-3">Add More Actions</a>
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
                            </div>


                        </div>
                        {{-- SEE 5 WHY end
                        ================================================================ --}}


                        {{-- Buttons(next/prev) --}}
                        <div class="mr-auto ml-auto" >
                            <div class="d-flex">
                                <button class="btn btn-primary my-5 w-25 mr-auto  " type="button" id="prevBtn" onclick="nextPrev(-1)">Previous </button>
                                <button class="btn btn-primary my-5 w-25 ml-auto  " type="button" id="nextBtn" onclick="nextPrev(1)">Next </button>
                            </div>
                        </div>



                    </form>
                </div>
            <!--==============
            Html End -->
        </div>
    </div>
@endsection


@section('footer_scripts')

    {{-- jquery
    =====================--}}
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function () {
            $(".nc-trick").click(function (e) {
                e.preventDefault();
                $("#nc_verification").prop('checked', false);
            });
            $('#nc_verification').change(function (e) {
                e.preventDefault();
                $("#nc_verification").val('yes');

            });
        });
    </script>

    {{-- ClockPicker
    ============================--}}
    <script src="{{ asset('js/ClockPicker/bootstrap-clockpicker.min.js') }}"></script>

    {{-- my scripts
    ============================= --}}
    <script>
        // function for showing gile upload
        function is_evedence_uploaded(id){
            let myval = $(`#${id}`).val();
            if(myval == 'Yes'){
                $(`#${id}_evidence_display`).css({'display':'block'});
            }
            else{
                $(`#${id}_evidence_display`).css({'display':'none'});
            }
        }
        function changeInput(id_one,id_two){
            // console.log('id_one',id_one);
            // console.log('id_two',id_two);
            $(`#${id_one}`).removeAttr('hidden');
            $(`#${id_two}`).attr('hidden',true);
        }
        $(()=>{
            // global variable
            var event_date_count = 1;
            var event_investigation_count = 1;
            var add_more_five_why_id = {{$counter - 1}};
            var STM_count = 1;

            // time picker
            $('.clockpicker').clockpicker({
                placement: 'top',
                align: 'left',
                donetext: 'OK'
            });




            // date formating and date picker initialize

            // initialize
            $("#Date_of_incident").datepicker({maxDate: new Date()});
            $( "#event_date_1" ).datepicker({maxDate: new Date()});
            $('#Date_report_created').datepicker({maxDate: new Date()});
            $('#Date_of_incident_event_information').datepicker({maxDate: new Date()});
            $('#five_why_followup_action_target_date_1').datepicker({maxDate: new Date()});
            $('#five_why_followup_action_completed_date_1').datepicker({maxDate: new Date()});

            // formating
            $('body').on('change' , '.date' , function(){
                let dateinput = $(this).val();
                let date = moment(dateinput).format('DD-MMM-YYYY');
                $(this).val(date);
            })


            // code for adding more event log inputs in Event log
            $('#add_event_log').click(function(){
                event_date_count++;
                let add = `<tr><td><input class="form-control date" type="text" id="event_date_${event_date_count}" name="event_date[]" placeholder="Date..." autocomplete="off"></td> <td class='clockpicker'><input type="text" id="event_time" name="event_time[]" placeholder="Time..." autocomplete="off" class="form-control"></td> <td><textarea type="text" id="event_remarks" name="event_remarks[]" placeholder="Remarks..." autocomplete="off" class="form-control"></textarea></td></tr>`;
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
                if($('#Place_of_the_incident_1st').val() == 'At Sea'){
                    $('#poi2').css('display','block');
                }
                if($('#Place_of_the_incident_1st').val() == 'Port'){
                    $('#poi2').css('display','none');
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
                add_more_five_why_id++;
                let content = `
                                <tr>
                                    <th scope="row">${add_more_five_why_id} <input type="hidden" name="sr_num_folowup[]" value="${add_more_five_why_id}"></th>
                                    <td><textarea           id="five_why_followup_action_describtion_${add_more_five_why_id}"         name="five_why_followup_action_describtion[]"          class="form-control"></textarea></td>
                                    <td><input type="text"  id="five_why_followup_action_pic_${add_more_five_why_id}"                 name="five_why_followup_action_pic[]"                  class="form-control"></td>
                                    <td><input type="text"  id="five_why_followup_action_department_${add_more_five_why_id}"          name="five_why_followup_action_department[]"           class="form-control"></td>
                                    <td><input type="text"  id="five_why_followup_action_target_date_${add_more_five_why_id}"         name="five_why_followup_action_target_date[]"          class="date form-control"></td>
                                    <td><input type="text"  id="five_why_followup_action_completed_date_${add_more_five_why_id}"      name="five_why_followup_action_completed_date[]"       class="form-control date"></td>
                                    <td>
                                        <select id="five_why_followup_action_evidence_uploaded_${add_more_five_why_id}"
                                        onchange="is_evedence_uploaded('five_why_followup_action_evidence_uploaded_${add_more_five_why_id}')"
                                        name="five_why_followup_action_evidence_uploaded[]" class="form-control">
                                            <option selected disabled hidden>Select...</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                        <div class="file_upload p-2" id="five_why_followup_action_evidence_uploaded_${add_more_five_why_id}_evidence_display" style="display: none;">
                                            <input type="file" id="evdnc_file_${add_more_five_why_id}" name="evidence_file[]" >
                                        </div>
                                    </td>
                                    <td><input type="text"  id="five_why_followup_action_cost_${add_more_five_why_id}"                name="five_why_followup_action_cost[]"                 class="form-control"></td>
                                    <td><input type="text"  id="five_why_followup_action_comments_${add_more_five_why_id}"            name="five_why_followup_action_comments[]"             class=" form-control"></td>
                                </tr>
                                `;
                $('#add_more_actions_five_why_content').append(content);
                $('#five_why_followup_action_target_date_'+add_more_five_why_id).datepicker({maxDate: new Date()});
                $('#five_why_followup_action_completed_date_'+ add_more_five_why_id).datepicker({maxDate: new Date()});
            });




            /*// sliding aNIMATION ON NEXT CLICK
            $('#nextBtn , #prevBtn').click(function(){
                document.getElementById("slide_div").animate([
                    // keyframes
                    { transform: 'translateX(0px)' },
                    { transform: 'translateX(200px)' },
                    { transform: 'translateX(0px)' }
                    ], {
                    // timing options
                    duration: 81,
                    iterations: 1
                });
            })*/



            // Add Supporting Team Member
            $('#add_supporting_member').click(function(){
                STM_count++;
                let cont = `
                    <input type="text"   class="form-control mb-3" id="STM_${STM_count}" name="STM[]" placeholder="Supporting Team Members..." autocomplete="off">
                `;
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
            })



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



        })
    </script>


    <!-- Multi-step form Script
    ================================= -->
        <script>
            var currentTab = 0; // Current tab is set to be the first tab (0)
            showTab(currentTab); // Display the current tab
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
            function showTab(n) {
                // This function will display the specified tab of the form ...
                var x = document.getElementsByClassName("tab");
                x[n].style.display = "block";
                // ... and fix the Previous/Next buttons:
                if (n == 0) {
                    document.getElementById("prevBtn").style.display = "none";
                } else {
                    document.getElementById("prevBtn").style.display = "inline";
                }
                if (n == (x.length - 1)) {
                    document.getElementById("nextBtn").innerHTML = "Submit Report";
                } else {
                    document.getElementById("nextBtn").innerHTML = "Next";
                }
                // ... and run a function that displays the correct step indicator:
                // fixStepIndicator(n)
            }
            function nextPrev(n) {
                // This function will figure out which tab to display
                var x = document.getElementsByClassName("tab");
                // Exit the function if any field in the current tab is invalid:
                if (n == 1 && !validateForm() || !validateFormTextarea() || !validateFormSelect()) return false;
                // Hide the current tab:
                x[currentTab].style.display = "none";
                // Increase or decrease the current tab by 1:
                currentTab = currentTab + n;
                // if you have reached the end of the form... :
                    if (currentTab >= x.length ) {
                        //...the form gets submitted:
                        document.getElementById("near_miss_form").submit();
                        return false;
                    }
                // Otherwise, display the correct tab:
                showTab(currentTab);
            }
            function validateForm() {
                // This function deals with validation of the form fields
                var x, y, i, valid = true;
                x = document.getElementsByClassName("tab");
                y = x[currentTab].getElementsByTagName("input");
                // A loop that checks every input field in the current tab:
                for (i = 0; i < y.length; i++) {
                    // If a field is empty...
                    if(y[i].getAttribute('id') == 'Incident_header')
                    {
                        if (y[i].value == "") {
                        // add an "invalid" class to the field:
                        y[i].className += " invalid";
                        // and set the current valid status to false:
                        valid = false; //changed by rohan for development actual value is false
                        }
                    }
                    else
                    {
                        valid = true;
                    }
                }
                // If the valid status is true, mark the step as finished and valid:
                if (valid) {
                    document.getElementsByClassName("step")[currentTab].className += " finish";
                }
                return valid; // return the valid status
            }
            function validateFormTextarea() {
                // This function deals with validation of the form fields
                var x, y, i, valid = true;
                x = document.getElementsByClassName("tab");
                y = x[currentTab].getElementsByTagName("textarea");
                // A loop that checks every input field in the current tab:
                for (i = 0; i < y.length; i++) {
                    // If a field is empty...
                    if (y[i].value == "") {
                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // and set the current valid status to false:
                    valid = true; //changed by rohan for development actual value is false
                    }
                }
                // If the valid status is true, mark the step as finished and valid:
                if (valid) {
                    document.getElementsByClassName("step")[currentTab].className += " finish";
                }
                return valid; // return the valid status
            }
            function validateFormSelect() {
                // This function deals with validation of the form fields
                var x, y, i, valid = true;
                x = document.getElementsByClassName("tab");
                y = x[currentTab].getElementsByTagName("select");
                if(y[0] != undefined)
                {
                    // A loop that checks every input field in the current tab:
                        // If a field is empty...
                        if (y[0].value == 0) {
                            // add an "invalid" class to the field:
                            y[0].className += " invalid";
                            // and set the current valid status to false:
                            valid = true;//changed by rohan for development actual value is false
                        }
                    // If the valid status is true, mark the step as finished and valid:
                    if (valid) {
                        document.getElementsByClassName("step")[currentTab].className += " finish";
                    }
                }
                return valid; // return the valid status
            }
            function fixStepIndicator(n) {
                // This function removes the "active" class of all steps...
                var i, x = document.getElementsByClassName("step");
                for (i = 0; i < x.length; i++) {
                    x[i].className = x[i].className.replace(" active", "");
                }
                //... and adds the "active" class to the current step:
                x[n].className += " active";
            }
        </script>
    <!--=============================
    Multi-step Script End -->




    {{-- multi-select
    ============================= --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap_multi_select/bootstrap-multiselect.css') }}">
    <script src="{{ asset('js/bootstrap_multi_select/bootstrap-multiselect.js') }}"></script>


    {{-- Automatic Dropdown Value Fetching Script --}}
    <script type="text/javascript">
        {{-- incidenttype first dropdown
        =========================== --}}
            // for 1st drop down
            var ffdd = document.getElementById("incidenttype")
            var ffdd_value = 'shipi';
            // setSelectedValue(ffdd, ffdd_value);



        {{-- immediatecause first dropdown
        =========================== --}}
            // for 1st drop down
            var ffdd = document.getElementById("immediatecause")
            var ffdd_value = '{{ $incident_reports_immediate_causes->primary }}'
            if(ffdd_value == null){ ffdd_value = 'shipi' }
            setSelectedValue(ffdd, ffdd_value);



        {{-- rootcauses first drop
        =========================== --}}
            // for 1st drop down
            var ffdd = document.getElementById("rootcauses")
            var ffdd_value = '{{ $incident_reports_root_causes->primary }}'
            let ffdd_arr = ffdd_value.split(',')
            for(i=0; i< ffdd_arr.length; i++)
            {
                setSelectedValue(ffdd, ffdd_arr[i]);
            }


        {{-- preventiveactions first dropdown
        =========================== --}}
            // for 1st drop down
            var ffdd = document.getElementById("preventiveactions")
            var ffdd_value = '{{ $incident_reports_preventive_actions->primary }}'

            ffdd_arr = ffdd_value.split(',')
            for(i=0; i< ffdd_arr.length; i++)
            {
                setSelectedValue(ffdd, ffdd_arr[i]);
            }






        {{-- Seconod drop --}}

            {{-- incidenttype Second dropdown
            ========================================= --}}
                var e_dda = $("#incidenttype").val();
                var e_dd_myida = $("#incidenttype").attr("myid");
                var e_dd_vala = 'shipi';
                // subajaxtwo(e_dda, e_dd_myida , e_dd_vala );

            {{-- immediatecause Second dropdown
            ============================================ --}}
                var e_ddb = $("#immediatecause").val()
                var e_dd_myidb = $("#immediatecause").attr("myid");
                var e_dd_valb = '{{ $incident_reports_immediate_causes->secondary }}';
                subajaxtwo(e_ddb, e_dd_myidb , e_dd_valb );


            {{-- rootcauses Second dropdown
            ============================================ --}}
                var e_ddc = $("#rootcauses").val()
                var e_dd_myidc = $("#rootcauses").attr("myid");
                var e_dd_valc = '{{ $incident_reports_root_causes->secondary }}';
                if(e_ddc != null){
                    for(j=0; j< e_ddc.length; j++)
                    {
                        if(e_ddc[j] != null || e_ddc[j] != undefined)
                        {
                            subajaxtwomulti(e_ddc[j], e_dd_myidc , e_dd_valc );
                            setInterval(function(){ $('#dd3').multiselect('rebuild');}, 2000);

                        }
                    }
                }





            {{-- preventiveactions Second dropdown
            ============================================ --}}
                var e_ddd = $("#preventiveactions").val()
                var e_dd_myidd = $("#preventiveactions").attr("myid");
                var e_dd_vald = '{{ $incident_reports_preventive_actions->secondary }}';

                for(k = 0; k < e_ddd.length ; k++ )
                {
                    if(e_ddd[k] != null || e_ddd[k] != undefined)
                    {
                        subajaxtwomulti(e_ddd[k], e_dd_myidd , e_dd_vald);
                        setInterval(function(){ $('#dd4').multiselect('rebuild');}, 2000);
                    }
                }

        // for 2nd drop down end
        $(() => {

            // Multi-Select Initialize
            $('#rootcauses').multiselect({includeSelectAllOption: false});
            $('#dd3').multiselect({includeSelectAllOption: false});
            $('#ddd3').multiselect({includeSelectAllOption: false});

            $('#preventiveactions').multiselect({includeSelectAllOption: false});
            $('#dd4').multiselect({includeSelectAllOption: false});


                    // for 3rd drop down
                    let onemy =   setTimeout(function(){
                            var ee_dda = $('select[name="incidenttype_second"]').val();
                            var ee_dd_myida = $('select[name="incidenttype_second"]').attr("myidtwo");
                            var ee_dd_vala = 'shipi';
                            // terajaxtwo(ee_dda,ee_dd_myida,ee_dd_vala)

                            var ee_dddb_id = $('select[name="immediatecause_second"]').attr("id");
                            var ee_ddb = $('#'+ee_dddb_id).val();
                            var ee_dd_myidb = $('select[name="immediatecause_second"]').attr("myidtwo");
                            var ee_dd_valb = '{{ $incident_reports_immediate_causes->tertiary }}';
                            terajaxtwo(ee_ddb,ee_dd_myidb,ee_dd_valb)


                            {{--  Root causes 3rd drop  --}}
                                var ee_ddc = $('select[name="rootcauses_second[]"]').val();
                                var ee_dd_myidc = $('select[name="rootcauses_second[]"]').attr("myidtwo");
                                var ee_dd_valc = '{{ $incident_reports_root_causes->tertiary }}';
                                if(ee_ddc != null){
                                    for(let r = 0; r < ee_ddc.length ; r++)
                                    {
                                        if(ee_ddc[r] != null || ee_ddc[r] != undefined)
                                        {
                                            terajaxtwomulti(ee_ddc[r],ee_dd_myidc , ee_dd_valc)
                                            setInterval(function(){ $('#ddd3').multiselect('rebuild');}, 2000);
                                        }
                                    }
                                }

                            {{--  preventive 3rd drop  --}}
                                var ee_ddd = $('select[name="preventiveactions_second[]"]').val();
                                var ee_dd_myidd = $('select[name="preventiveactions_second[]"]').attr("myidtwo");
                                var ee_dd_vald = '{{ $incident_reports_preventive_actions->tertiary }}';

                                if(ee_ddd != null)
                                {
                                    for(m = 0; m < ee_ddd.length; m++)
                                    {
                                        if(ee_ddd[m] != null || ee_ddd[m] != undefined)
                                        {
                                            terajaxtwomulti(ee_ddd[m],ee_dd_myidd,ee_dd_vald)
                                        }
                                    }
                                }

                            // clearInterval(onemy);
                    }, 7000);
                    // for 3rd drop down end



            {{-- For fetching Sub dropdown on change of input
            ============================================ --}}
            $(".drop").change(function(){
                let e = $(".drop:focus").val();
                let atr = $(".drop:focus").attr("myid");


                if(Array.isArray(e))
                {
                    for(i=0; i < e.length ; i++)
                    {
                        subajaxmulti( e[i] , atr , i);
                    }
                }
                else
                {
                    subajax(e, atr)
                }


            })

            $("#preventiveactions").change(function(){
                var e = $("#preventiveactions").val();
                var atr = $("#preventiveactions").attr("myid");


                if(  Array.isArray(e))
                {
                    for(i=0;i < e.length ; i++){

                        subajaxmulti( e[i] , atr , i);
                    }
                }
                else
                {
                    subajax(e , atr)
                }
                setInterval(function(){ $('#dd4').multiselect('rebuild');}, 2000);

            })

            $("#rootcauses").change(function(){
                var e = $("#rootcauses").val();
                var atr = $("#rootcauses").attr("myid");


                if(  Array.isArray(e))
                {
                    for(i=0;i < e.length ; i++){

                        subajaxmulti( e[i] , atr , i);
                    }
                }
                else
                {
                    subajax(e , atr)
                }
                setInterval(function(){ $('#dd3').multiselect('rebuild');}, 2000);

            })



            {{-- For fetching Ter dropdown on change of input
            ============================================== --}}
            $(".droptwo").change(function(){
                let e = $(".droptwo:focus").val();
                let atr = $(".droptwo:focus").attr("myidtwo");

                if(  Array.isArray(e))
                {
                    for(i=0;i < e.length ; i++){

                        terajaxmulti( e[i] , atr , i);
                    }
                }
                else
                {
                    terajax(e , atr)
                }

            })


            $("#dd3").change(function(){
                    var e = $("#dd3").val();
                    var atr = $("#dd3").attr("myidtwo");

                    if(  Array.isArray(e))
                    {
                        for(i=0;i < e.length ; i++){

                            terajaxmulti( e[i] , atr , i);
                        }
                    }
                    else
                    {
                        terajax(e , atr)
                    }
                    setInterval(function(){ $('#ddd3').multiselect('rebuild');}, 2000);
            })


        });





        {{-- helper functions start from here --}}



        // sub ajax are the function for fetching all second dropdowns value acording to first dropdown
        {{-- ---------------------------  -------- ------------------------------------ --}}
        {{-- ---------------------------  Sub ajax ------------------------------------ --}}
        {{-- ---------------------------  -------- ------------------------------------ --}}
            function subajax(d , atr)
            {
            $.ajax({
                                        type: 'POST',
                                        url: "/api/subtype",
                                        data: {'id': d},
                                        success: function(result)
                                        {


                                                    output = ""
                                                    if(result.length < 1)
                                                    {
                                                        $("#display_"+atr).css("cssText", "display: none !important;");
                                                        $("#display_d"+atr).css("cssText", "display: none !important;");
                                                        $("#"+atr).html("");
                                                        $("#d"+atr).html("");
                                                    }
                                                    else
                                                    {
                                                        for(let i = 0; i < result.length; i++)
                                                        {
                                                            output += "<option value="+ result[i].id +">"+ result[i].type_sub_name +"</option>";
                                                        }
                                                        $("#display_"+atr).css("cssText", "display: block !important;");;
                                                    }

                                                    $("#"+atr).html(output);
                                                    let sdd = document.getElementById(atr)
                                                    let sdd_value_one = 'shipi';
                                                    let sdd_value_two = '{{ $incident_reports_immediate_causes->secondary }}'
                                                    let sdd_value_three = '{{ $incident_reports_root_causes->secondary }}'
                                                    let sdd_value_four = '{{ $incident_reports_preventive_actions->secondary }}'
                                                    // setSelectedValue(sdd, sdd_value_one )
                                                    setSelectedValue(sdd, sdd_value_two )
                                                    setSelectedValue(sdd, sdd_value_three )
                                                    setSelectedValue(sdd, sdd_value_four )

                                        }
                            });
            }

            function subajaxmulti( d , atr , c)
                {
                    $.ajax({
                                            type: 'POST',
                                            url: "/api/subtype",
                                            data: {'id': d},
                                            success: function(result)
                                            {

                                                        output = ""
                                                        if(result.length < 1)
                                                        {
                                                            $("#display_"+atr).css("cssText", "display: none !important;");
                                                            $("#display_d"+atr).css("cssText", "display: none !important;");
                                                            $("#"+atr).html("");
                                                            $("#d"+atr).html("");
                                                        }
                                                        else
                                                        {
                                                            for(let i = 0; i < result.length; i++)
                                                            {
                                                                output += "<option value="+ result[i].id +">"+ result[i].type_sub_name +"</option>";
                                                            }
                                                            $("#display_"+atr).css("cssText", "display: block !important;");
                                                        }

                                                        if(c == 0)
                                                        {
                                                            document.getElementById(atr).innerHTML =output ;
                                                        }
                                                        else
                                                        {
                                                            document.getElementById(atr).innerHTML +=output ;
                                                        }

                                            }
                                });
                }

            function subajaxtwo(d , atr , val)
            {

            if(val != '-----'){
            $.ajax({
                                        type: 'POST',
                                        url: "/api/subtype",
                                        data: {'id': d},
                                        success: function(result)
                                        {


                                                    output = ""
                                                    if(result.length < 1)
                                                    {
                                                        $("#display_"+atr).css("cssText", "display: none !important;");
                                                        $("#display_d"+atr).css("cssText", "display: none !important;");
                                                        $("#"+atr).html("");
                                                        $("#d"+atr).html("");
                                                    }
                                                    else
                                                    {
                                                        for(let i = 0; i < result.length; i++)
                                                        {
                                                            output += "<option value="+ result[i].id +">"+ result[i].type_sub_name +"</option>";
                                                        }
                                                        $("#display_"+atr).css("cssText", "display: block !important;");;
                                                    }

                                                    $("#"+atr).html(output);
                                                    let sdd = document.getElementById(atr)


                                                    setSelectedValue(sdd, val )

                                        }
                    });
            }

            }

            function subajaxtwomulti(d , atr , val )
            {



                    $.ajax({
                                                type: 'POST',
                                                url: "/api/subtype",
                                                data: {'id': d},
                                                success: function(result)
                                                {
                                                    val = val.split(',');

                                                    output = ""
                                                            if(result.length < 1)
                                                            {
                                                                $("#display_"+atr).css("cssText", "display: none !important;");
                                                                $("#display_d"+atr).css("cssText", "display: none !important;");
                                                                $("#"+atr).html("");
                                                                $("#d"+atr).html("");
                                                            }
                                                            else
                                                            {
                                                                for(let i = 0; i < result.length; i++)
                                                                {
                                                                        if($.inArray(result[i].type_sub_name, val)  < 0 )
                                                                        {
                                                                            output += "<option  value="+ result[i].id +">"+ result[i].type_sub_name +"</option>";
                                                                        }
                                                                        else
                                                                        {
                                                                            output += "<option selected value="+ result[i].id +">"+ result[i].type_sub_name +"</option>";
                                                                        }

                                                                }
                                                                $("#display_"+atr).css("cssText", "display: block !important;");;
                                                            }

                                                            document.getElementById(atr).innerHTML += output;
                                                }
                    });



            }

        // ter ajax are the dunction for fetching all third dropdowns data acording to the second dropdown
        {{--  ---------------------------------------- -------- --------------------------------------  --}}
        {{--  ---------------------------------------- ter ajax --------------------------------------  --}}
        {{--  ---------------------------------------- -------- --------------------------------------  --}}
            function terajax(d , atr)
            {
            $.ajax({
                                        type: 'POST',
                                        url: "/api/tertype",
                                        data: {'id': d},
                                        success: function(result)
                                        {

                                            output = ""
                                                    if(result.length < 1)
                                                    {
                                                        $("#display_"+atr).css("cssText", "display: none !important;");
                                                        $("#"+atr).html("");
                                                    }
                                                    else
                                                    {
                                                        for(let i = 0; i < result.length; i++)
                                                        {
                                                            output += "<option value="+ result[i].id +">"+ result[i].type_ter_name +"</option>";
                                                        }
                                                        $("#display_"+atr).css("cssText", "display: block !important;");;
                                                    }

                                                    $("#"+atr).html(output);
                                                    let sdd = document.getElementById(atr)
                                                    let sdd_value_on = 'shipi';
                                                    let sdd_value_tw = '{{ $incident_reports_immediate_causes->tertiary }}'
                                                    let sdd_value_thre = '{{ $incident_reports_root_causes->tertiary }}'
                                                    let sdd_value_fou = '{{ $incident_reports_preventive_actions->tertiary }}'
                                                    // setSelectedValue(sdd, sdd_value_on )
                                                    setSelectedValue(sdd, sdd_value_tw )
                                                    setSelectedValue(sdd, sdd_value_thre )
                                                    setSelectedValue(sdd, sdd_value_fou )

                                        }
                            });
            }

            function terajaxmulti(f , atr , c)
            {
            $.ajax({
                                type: 'POST',
                                url: "/api/tertype",
                                data: {'id': f},
                                success: function(result)
                                {

                                    output = ""
                                            if(result.length < 1)
                                            {
                                                $("#display_"+atr).css("cssText", "display: none !important;");
                                                $("#"+atr).html("");
                                            }
                                            else
                                            {
                                                for(let i = 0; i < result.length; i++)
                                                {
                                                    output += "<option value="+ result[i].id +">"+ result[i].type_ter_name +"</option>";
                                                }
                                                $("#display_"+atr).css("cssText", "display: block !important;");;
                                            }

                                            if(c == 0)
                                            {
                                                document.getElementById(atr).innerHTML = output;
                                            }
                                            else
                                            {
                                                document.getElementById(atr).innerHTML += output;
                                            }

                                }
                    });
            }


            function terajaxtwo(d , atr , val)
            {

            if(val != '-----'){
                $.ajax({
                                            type: 'POST',
                                            url: "/api/tertype",
                                            data: {'id': d},
                                            success: function(result)
                                            {

                                                output = ""
                                                        if(result.length < 1)
                                                        {
                                                            $("#display_"+atr).css("cssText", "display: none !important;");
                                                            $("#"+atr).html("");
                                                        }
                                                        else
                                                        {
                                                            for(let i = 0; i < result.length; i++)
                                                            {
                                                                output += "<option value="+ result[i].id +">"+ result[i].type_ter_name +"</option>";
                                                            }
                                                            $("#display_"+atr).css("cssText", "display: block !important;");;
                                                        }

                                                        $("#"+atr).html(output);
                                                        let sdd = document.getElementById(atr)
                                                        setSelectedValue(sdd, val )
                                            }
                                });

            }
            }

            function terajaxtwomulti(d , atr , val )
            {


                    $.ajax({
                                                type: 'POST',
                                                url: "/api/tertype",
                                                data: {'id': d},
                                                success: function(result)
                                                {
                                                    val = val.split(',');

                                                    output = ""
                                                                if(result.length < 1)
                                                                {
                                                                    $("#display_"+atr).css("cssText", "display: none !important;");
                                                                    $("#"+atr).html("");
                                                                }
                                                                else
                                                                {
                                                                    for(let i = 0; i < result.length; i++)
                                                                    {
                                                                        if($.inArray(result[i].type_ter_name, val)  < 0)
                                                                        {
                                                                            output += "<option  value="+ result[i].id +">"+ result[i].type_ter_name +"</option>";
                                                                        }
                                                                        else
                                                                        {
                                                                            output += "<option selected value="+ result[i].id +">"+ result[i].type_ter_name +"</option>";
                                                                        }
                                                                    }
                                                                    $("#display_"+atr).css("cssText", "display: block !important;");
                                                                }

                                                                document.getElementById(atr).innerHTML += output;
                                                }
                                    });



            }


            // function for select previously selected fields
            function setSelectedValue(selectObj, valueToSet) {
            for (var i = 0; i < selectObj.options.length; i++) {
                if (selectObj.options[i].text== valueToSet) {
                    //val = selectObj.options[i].value ;

                    selectObj.options[i].selected = true;
                        //selectObj.options[0].text = valueToSet;
                        //.options[0].value = val;
                        return;
                }
            }


            }




    </script>
    {{-- Automatic Dropdown Value Fetching Script --}}
    <script>
        $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
            let risk_matrix = [
                {
                    index:'1,1',
                    value:'VERY LOW RISK'
                },
                {
                    index:'1,2',
                    value:'VERY LOW RISK'
                },
                {
                    index:'2,1',
                    value:'VERY LOW RISK'
                },
                {
                    index:'1,3',
                    value:'LOW RISK'
                },
                {
                    index:'1,4',
                    value:'LOW RISK'
                },
                {
                    index:'2,2',
                    value:'LOW RISK'
                },
                {
                    index:'3,1',
                    value:'LOW RISK'
                },
                {
                    index:'4,1',
                    value:'LOW RISK'
                },
                {
                    index:'1,5',
                    value:'MODERATE RISK'
                },
                {
                    index:'2,3',
                    value:'MODERATE RISK'
                },
                {
                    index:'2,4',
                    value:'MODERATE RISK'
                },
                {
                    index:'3,2',
                    value:'MODERATE RISK'
                },
                {
                    index:'3,3',
                    value:'MODERATE RISK'
                },
                {
                    index:'4,2',
                    value:'MODERATE RISK'
                },
                {
                    index:'5,1',
                    value:'MODERATE RISK'
                },
                {
                    index:'2,5',
                    value:'HIGH RISK'
                },
                {
                    index:'3,4',
                    value:'HIGH RISK'
                },
                {
                    index:'4,3',
                    value:'HIGH RISK'
                },
                {
                    index:'5,2',
                    value:'HIGH RISK'
                },
                {
                    index:'3,5',
                    value:'VERY HIGH RISK'
                },
                {
                    index:'4,4',
                    value:'VERY HIGH RISK'
                },
                {
                    index:'4,5',
                    value:'VERY HIGH RISK'
                },
                {
                    index:'5,3',
                    value:'VERY HIGH RISK'
                },
                {
                    index:'5,4',
                    value:'VERY HIGH RISK'
                },
                {
                    index:'5,5',
                    value:'VERY HIGH RISK'
                }
                ]
                let option1 = '1';
                let option2 = '1';
                let find_index = option1 +','+ option2;
                let risk_value = risk_matrix.filter(item => item.index == find_index);
                $('#IIARCF_safety_Result')[0].value = '{{$incident_reports_risk_details->result}}';
                $('#IIARCF_HEALTH_Result')[0].value = '{{$incident_reports_risk_details->result}}';
                $('#IIARCF_ENVIRONMENT_Result')[0].value = '{{$incident_reports_risk_details->result}}';
                $('#IIARCF_OPERATIONAL_IMPACT_Result')[0].value = '{{$incident_reports_risk_details->result}}';
                $('#IIARCF_MEDIA_Result')[0].value = '{{$incident_reports_risk_details->result}}';

                $('[data-toggle="tooltip"]').tooltip();
                // SAFETY
                $('#IIARCF_safety_Severity').on('change', function() {
                let tmp = this.value;
                tmp = tmp.split(' ');
                tmp = tmp[tmp.length - 1];
                option1 = tmp;
                find_index = option1 +','+ option2;
                risk_value = risk_matrix.filter(item => item.index == find_index);
                $('#IIARCF_safety_Result')[0].value = risk_value[0].value;
                });

                $('#IIARCF_safety_Likelihood').on('change', function() {
                let tmp2 = this.value;
                tmp2 = tmp2.split(' ');
                tmp2 = tmp2[tmp2.length - 1];
                option2 = tmp2;
                find_index = option1 +','+ option2;
                risk_value = risk_matrix.filter(item => item.index == find_index);
                $('#IIARCF_safety_Result')[0].value = risk_value[0].value;
                });

                // HEALTH
                $('#IIARCF_HEALTH_Severity').on('change', function() {
                let tmp = this.value;
                tmp = tmp.split(' ');
                tmp = tmp[tmp.length - 1];
                option1 = tmp;
                find_index = option1 +','+ option2;
                risk_value = risk_matrix.filter(item => item.index == find_index);
                $('#IIARCF_HEALTH_Result')[0].value = risk_value[0].value;
                });

                $('#IIARCF_HEALTH_Likelihood').on('change', function() {
                let tmp2 = this.value;
                tmp2 = tmp2.split(' ');
                tmp2 = tmp2[tmp2.length - 1];
                option2 = tmp2;
                find_index = option1 +','+ option2;
                risk_value = risk_matrix.filter(item => item.index == find_index);
                $('#IIARCF_HEALTH_Result')[0].value = risk_value[0].value;
                });

                // ENVIRONMENT
                $('#IIARCF_ENVIRONMENT_Severity').on('change', function() {
                let tmp = this.value;
                tmp = tmp.split(' ');
                tmp = tmp[tmp.length - 1];
                option1 = tmp;
                find_index = option1 +','+ option2;
                risk_value = risk_matrix.filter(item => item.index == find_index);
                $('#IIARCF_ENVIRONMENT_Result')[0].value = risk_value[0].value;
                });

                $('#IIARCF_ENVIRONMENT_Likelihood').on('change', function() {
                let tmp2 = this.value;
                tmp2 = tmp2.split(' ');
                tmp2 = tmp2[tmp2.length - 1];
                option2 = tmp2;
                find_index = option1 +','+ option2;
                risk_value = risk_matrix.filter(item => item.index == find_index);
                $('#IIARCF_ENVIRONMENT_Result')[0].value = risk_value[0].value;
                });


                // OPERATIONAL
                $('#IIARCF_OPERATIONAL_IMPACT_Severity').on('change', function() {
                let tmp = this.value;
                tmp = tmp.split(' ');
                tmp = tmp[tmp.length - 1];
                option1 = tmp;
                find_index = option1 +','+ option2;
                risk_value = risk_matrix.filter(item => item.index == find_index);
                $('#IIARCF_OPERATIONAL_IMPACT_Result')[0].value = risk_value[0].value;
                });

                $('#IIARCF_OPERATIONAL_IMPACT_Likelihood').on('change', function() {
                let tmp2 = this.value;
                tmp2 = tmp2.split(' ');
                tmp2 = tmp2[tmp2.length - 1];
                option2 = tmp2;
                find_index = option1 +','+ option2;
                risk_value = risk_matrix.filter(item => item.index == find_index);
                $('#IIARCF_OPERATIONAL_IMPACT_Result')[0].value = risk_value[0].value;
                });

                // MEDIA
                $('#IIARCF_MEDIA_Severity').on('change', function() {
                let tmp = this.value;
                tmp = tmp.split(' ');
                tmp = tmp[tmp.length - 1];
                option1 = tmp;
                find_index = option1 +','+ option2;
                risk_value = risk_matrix.filter(item => item.index == find_index);
                $('#IIARCF_MEDIA_Result')[0].value = risk_value[0].value;
                });

                $('#IIARCF_MEDIA_Likelihood').on('change', function() {
                let tmp2 = this.value;
                tmp2 = tmp2.split(' ');
                tmp2 = tmp2[tmp2.length - 1];
                option2 = tmp2;
                find_index = option1 +','+ option2;
                risk_value = risk_matrix.filter(item => item.index == find_index);
                $('#IIARCF_MEDIA_Result')[0].value = risk_value[0].value;
                });

        });
    </script>
    {{-- investigation matrix  --}}
    <script>

        $(document).ready(function(){
            let flag1 = false;
            let flag2 = false;
            let value1 = '';
            let value2 = '';
            let append_str = '';
            let fst_value = '{{$incident_report->investigation_matrix_fst}}';
            let scnd_value = '{{$incident_report->investigation_matrix_scnd}}';
            append_str = fst_value + ',' + scnd_value;
            console.log('append_str..',append_str);

            let investigation_matrix = [
                {
                    index:'1,1',
                    data_investigation_level:'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
                    data_authority:'S/M or F/M as applicable'
                },
                {
                    index:'1,2',
                    data_investigation_level:'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
                    data_authority:'S/M or F/M as applicable'
                },
                {
                    index:'1,3',
                    data_investigation_level:'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
                    data_authority:'S/M or F/M as applicable'
                },
                {
                    index:'1,4',
                    data_investigation_level:'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
                    data_authority:'S/M or F/M as applicable'
                },
                {
                    index:'1,5',
                    data_investigation_level:'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
                    data_authority:'S/M or F/M as applicable'
                },
                {
                    index:'1,6',
                    data_investigation_level:'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
                    data_authority:'S/M or F/M as applicable'
                },
                {
                    index:'2,1',
                    data_investigation_level:'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
                    data_authority:'D/GM'
                },
                {
                    index:'2,2',
                    data_investigation_level:'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
                    data_authority:'D/GM'
                },
                {
                    index:'2,3',
                    data_investigation_level:'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
                    data_authority:'D/GM'
                },
                {
                    index:'2,4',
                    data_investigation_level:'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
                    data_authority:'D/GM'
                },
                {
                    index:'2,5',
                    data_investigation_level:'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
                    data_authority:'D/GM'
                },
                {
                    index:'2,6',
                    data_investigation_level:'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
                    data_authority:'D/GM'
                },
                {
                    index:'3,1',
                    data_investigation_level:'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
                    data_authority:'D/GM'
                },
                {
                    index:'3,2',
                    data_investigation_level:'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
                    data_authority:'D/GM'
                },
                {
                    index:'3,3',
                    data_investigation_level:'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
                    data_authority:'D/GM'
                },
                {
                    index:'3,4',
                    data_investigation_level:'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
                    data_authority:'D/GM'
                },
                {
                    index:'3,5',
                    data_investigation_level:'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
                    data_authority:'D/GM'
                },
                {
                    index:'3,6',
                    data_investigation_level:'Detailed investigation by relevant ship team with assistance from shore team or third party Services as necessary. GM may decide to assign a shore investigation team when deemed necessery.',
                    data_authority:'D/GM'
                },
                {
                    index:'4,1',
                    data_investigation_level:'Full Investigation by shore team or person(s) who are independent to the ship team.',
                    data_authority:'GM'
                },
                {
                    index:'4,2',
                    data_investigation_level:'Full Investigation by shore team or person(s) who are independent to the ship team.',
                    data_authority:'GM'
                },
                {
                    index:'4,3',
                    data_investigation_level:'Full Investigation by shore team or person(s) who are independent to the ship team.',
                    data_authority:'GM'
                },
                {
                    index:'4,4',
                    data_investigation_level:'Full Investigation by shore team or person(s) who are independent to the ship team.',
                    data_authority:'GM'
                },
                {
                    index:'4,5',
                    data_investigation_level:'Full Investigation by shore team or person(s) who are independent to the ship team.',
                    data_authority:'GM'
                },
                {
                    index:'4,6',
                    data_investigation_level:'Full Investigation by shore team or person(s) who are independent to the ship team.',
                    data_authority:'GM'
                },
                {
                    index:'5,1',
                    data_investigation_level:'Full Investigation by shore team or person(s) who are independent to the ship team.',
                    data_authority:'GM'
                },
                {
                    index:'5,2',
                    data_investigation_level:'Full Investigation by shore team or person(s) who are independent to the ship team.',
                    data_authority:'GM'
                },
                {
                    index:'5,3',
                    data_investigation_level:'Full Investigation by shore team or person(s) who are independent to the ship team.',
                    data_authority:'GM'
                },
                {
                    index:'5,4',
                    data_investigation_level:'Full Investigation by shore team or person(s) who are independent to the ship team.',
                    data_authority:'GM'
                },
                {
                    index:'5,5',
                    data_investigation_level:'Full Investigation by shore team or person(s) who are independent to the ship team.',
                    data_authority:'GM'
                },
                {
                    index:'5,6',
                    data_investigation_level:'Full Investigation by shore team or person(s) who are independent to the ship team.',
                    data_authority:'GM'
                }
            ];

            // pre-fill the investigation matrix
            let investigation_matrix_data_1 = investigation_matrix.filter(item=> item.index === append_str );

            investigation_matrix_data_1 = investigation_matrix_data_1[0];
            console.log('investigation_matrix_data_1',investigation_matrix_data_1);
            if(investigation_matrix_data_1 == undefined){
                // console.log('true');

                $('#no-text-msg').css({'display':'block'});
            }
            else{
                $('#data_investigation_level').html(investigation_matrix_data_1.data_investigation_level);
                $('#data_authority').html(investigation_matrix_data_1.data_authority);
                $('#investigation_result').css({'display':'block'});
                $('#no-text-msg').css({'display':'none'});
            }


            // on change functions
            $('#First_Parameter').change(function(){
                value1 = this.value;
                flag1 = true;
                if(flag1 && flag2){
                    $('#err-text-msg').css({'display':'none'});
                    append_str = value1 + ',' + value2;
                    let investigation_matrix_data = investigation_matrix.filter(item=> item.index === append_str );
                    investigation_matrix_data = investigation_matrix_data[0];
                    $('#data_investigation_level').html(investigation_matrix_data.data_investigation_level);
                    $('#data_authority').html(investigation_matrix_data.data_authority);
                    $('#investigation_result').css({'display':'block'});
                    $('#no-text-msg').css({'display':'none'});
                }else{
                    $('#err-text-msg').css({'display':'block'});
                }
            });

            $('#Second_Parameter').change(function(){
                value2 = this.value;
                flag2 = true;
                if(flag1 && flag2){
                    $('#err-text-msg').css({'display':'none'});
                    append_str = value1 + ',' + value2;
                    let investigation_matrix_data = investigation_matrix.filter(item=> item.index === append_str );
                    investigation_matrix_data = investigation_matrix_data[0];
                    $('#data_investigation_level').html(investigation_matrix_data.data_investigation_level);
                    $('#data_authority').html(investigation_matrix_data.data_authority);
                    $('#investigation_result').css({'display':'block'});
                    $('#no-text-msg').css({'display':'none'});

                }else{
                    $('#err-text-msg').css({'display':'block'});
                }
            });

        });


    </script>
    <script>
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

    document.querySelector('#incident_images').addEventListener("change", previewImages);
    </script>
@endsection
