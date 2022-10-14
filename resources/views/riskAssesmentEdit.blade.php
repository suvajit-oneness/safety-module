@extends('layouts.app')

@section('template_title')
    Risk Assessment Edit
@endsection
@section('template_linked_css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="/js/custom/toastr/toastr.min.css" rel="stylesheet">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/css/dataTables/dataTables.bootstrap.min.css">
  <link href="/css/summernote/summernote.css" rel="stylesheet">
  <link href="/css/custom/riskAssessment/riskAssessmentCreate.css" rel="stylesheet">

@endsection
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form action="" method = 'POST' id = 'RiskForm' enctype="multipart/form-data">
                @csrf
                <input type = "hidden" name = "section_2_array" id="section_2_array" value = "">
                <input type = "hidden" name = "additional_control" id="additional_control" value = "">
                <div class="row">
                    <div class="col-6">
                        <label for="">Creator_id</label>
                        <input readonly type="text" class="form-control" id="creator"  name="creator" value="{{$template[0]->creator_id}}">
                    </div>
                    <div class="col-6">
                        <label for="">Creator_email</label>
                        <input readonly type="text" class="form-control" id="creator_email"  name="creator_email" value="{{$template[0]->creator_email}}">
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <label>Enter template name<font style="color: red;font-size: 25px">*</font></label>
                        <input readonly type="text" class="form-control" id="template_name" placeholder="Enter Template Name" name="template_name" value="{{$template[0]->name}}">
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col" >
                        <label for="dept-id" class="mr-sm-2 mt-1">Dept:</label>
                        <select class="form-control mr-sm-2" id="dept-id" name="dept-id">
                            <option hidden value="{{$dept_name->id}}" selected>{{$dept_name->name}}</option>
                            @foreach($department as $dept)
                            <option value="{{$dept->id}}">{{$dept->name}}</option>
                            @endforeach

                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    {{--<div class="col" >
                        <label for="vessel-id" class="">Vessel Name:</label>
                            <select class="form-control mr-sm-2" id="vessel_id" name="vessel_id" required>
                            <option hidden value="{{$vessel_name->id}}" selected>{{$vessel_name->name}}</option>
                            @foreach($vessels as $vessel)
                                <option value="{{$vessel->id}}">{{$vessel->name}}</option>
                            @endforeach
                            </select>

                    </div>
                    <div class="col">
                        <label for="review-date" class="mr-sm-2 mt-1">Date:</label>

                            <input type="text" class="datepicker form-control mr-sm-2" id="review-date" min=""
                        placeholder="Select Review Date" name="review-date" value = "{{$template[0]->review_date}}">

                    </div>
                    <div class="col">
                        <label for="weather" class="mr-sm-2 mt-1">Wind/Weather:</label>
                        <input type="text" class="form-control mr-sm-2" id="weather" placeholder="Enter Weather" name="weather" value = "{{$template[0]->weather}}">

                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <label for="voyage" class="mr-sm-2 mt-1">Voyage#:</label>

                            <input type="text" class="form-control mr-sm-2" id="voyage" value="{{$template[0]->voyage}}" name="voyage" >

                    </div>
                    <div class="col">
                        <label for="location" class="mr-sm-2 mt-1">Port/Location:</label>

                            <input type="text" class="form-control mr-sm-2" id="location" placeholder="Enter Location" value="{{$template[0]->location}}" name="location" >

                    </div>
                    <div class="col">
                        <label for="tide" class="mr-sm-2 mt-1">Tide:</label>
                        <input type="text" class="form-control mr-sm-2" id="tide" value = "{{$template[0]->tide}}" placeholder="Enter Tide" name="tide" >

                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <label for="work_activity" class="mr-sm-2 mt-1">Work activity being assessed:</label>
                        <input type="text" class="form-control mr-sm-2" id="work_activity" value = "{{$template[0]->work_activity}}" placeholder="Enter Work Activity" name="work_activity">

                    </div>
                    <div class="col">
                        <label for="work_area" class="mr-sm-2 mt-1">Work Area:</label>

                            <input type="text" class="form-control mr-sm-2" id="work_area" placeholder="Enter Work Area" name="work_area"  value = "{{$template[0]->work_area}}">

                    </div>
                    <div class="col">
                        <label for="visibility" class="mr-sm-2 mt-1">Visibilty:</label>

                            <input type="text" class="form-control mr-sm-2" id="visibility" value= "{{$template[0]->visibility}}" placeholder="Enter Visibility" name="visibility">

                    </div>--}}
                </div>
                <div id="editt" class = "mt-2"> </div>
                <input hidden type="text" id='form_temp' value= 'null' name = 'form_temp'>
                <hr>
                @include('partials.B18.hazard-table-section2-b18')
                <hr>

                <!-- Section 2 -->
                <div class="row mt-3">
                    <div class="col-6">
                        <h2>Section 2-Additional Control</h2>
                        <table class="table table-bordered datatable mt-2">
                            <thead>
                                <th title="No">No</th>
                                <th colspan="4">To be completed by Office</th>
                            </thead>
                            <tbody id="section2Body">
                                @php
                                    $row_count = 0;
                                @endphp
                                @if(isset($templateData))
                                    @foreach($templateData as $data)
                                        @php
                                            $row_count++;
                                        @endphp
                                        <tr id="row_{{$row_count}}">
                                        <td>{{$row_count}}</td>
                                        <td colspan="3">
                                                @if(isset($data->additional_control) && $data->additional_control)
                                                <input type="text" class="form-control mr-sm-2" id="additional_control_{{$row_count}}" placeholder="Enter additional control" name="additional_control_{{$row_count}}" value="{{$data->additional_control}}" onchange="add_value({{$row_count}})">
                                                @else
                                                    <input type="text" class="form-control mr-sm-2" id="additional_control_{{$row_count}}" name="additional_control_{{$row_count}}" onchange="add_value({{$row_count}})">
                                                @endif
                                            </td>
                                        <td>
                                                <select class="form-control" id="additional_control_type_{{$row_count}}" name="additional_control_type_{{$row_count}}" onchange="add_value({{$row_count}})">
                                                    <option value="">Select Control Type</option>
                                                    @if(isset($data->additional_control_type) && $data->additional_control_type && $data->additional_control_type == "Acceptable")
                                                        <option value="Acceptable" selected>Acceptable</option>
                                                        <option value="Intolerable">Intolerable</option>
                                                    @elseif(isset($data->additional_control_type) && $data->additional_control_type && $data->additional_control_type == "Intolerable")
                                                        <option value="Acceptable">Acceptable</option>
                                                        <option value="Intolerable" selected>Intolerable</option>
                                                    @else
                                                        <option value="Acceptable">Acceptable</option>
                                                        <option value="Intolerable">Intolerable</option>
                                                    @endif
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <h3 class="pull-right" id="ACTableFooter">
                        </h3>
                    </div>
                    <div class="col-6">
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label for="alternate_method" style="padding-right:20px;">Alternate method of work considered and found not applicable</label>
                                @if(isset($template[0]->alternate_method) && $template[0]->alternate_method=='Yes')
                                    <input type="radio" name="alternate_method" value="Yes" checked> Yes
                                    <input type="radio" name="alternate_method" value="No"> No
                                @elseif(isset($template[0]->alternate_method) && $template[0]->alternate_method=='No')
                                    <input type="radio" name="alternate_method" value="Yes"> Yes
                                    <input type="radio" name="alternate_method" value="No" checked> No
                                @else
                                    <input type="radio" name="alternate_method" value="Yes"> Yes
                                    <input type="radio" name="alternate_method" value="No"> No
                                @endif
                            </div>
                            <div class="col-md-12">
                                <label for="hazard_discussed" style="padding-right:20px;">Discussed hazards and controls with team</label>
                                @if(isset($template[0]->hazard_discussed) && $template[0]->hazard_discussed=='Yes')
                                    <input type="radio" name="hazard_discussed" value="Yes" checked> Yes
                                    <input type="radio" name="hazard_discussed" value="No"> No
                                @elseif(isset($template[0]->hazard_discussed) && $template[0]->hazard_discussed=='No')
                                    <input type="radio" name="hazard_discussed" value="Yes"> Yes
                                    <input type="radio" name="hazard_discussed" value="No" checked> No
                                @else
                                    <input type="radio" name="hazard_discussed" value="Yes"> Yes
                                    <input type="radio" name="hazard_discussed" value="No"> No
                                @endif
                            </div>
                            <div class="col-md-5">
                                <label for="jha-start">Shut down period for this JHA (For work on critical equipment only)</label>
                            </div>
                            <div class="col-md-3">
                                <label>From</label>
                                @if(isset($template[0]->jha_start) && $template[0]->jha_start)
                                    <input type="text" class="datepicker form-control mr-sm-2" id="jha_start" placeholder="Select JHA Start Date" name="jha_start" value="{{date('d-M-Y',strtotime($template[0]->jha_start))}}">
                                @else
                                <input type="text" class="datepicker form-control mr-sm-2" id="jha_start" min="" placeholder="Select JHA Start Date" name="jha_start">
                                @endif
                            </div>
                            <div class="col-md-3">
                                <label>To</label>
                                @if(isset($template[0]->jha_end) && $template[0]->jha_end)
                                    <input type="text" class="datepicker form-control mr-sm-2" id="jha_end" placeholder="Select JHA End Date" name="jha_end" value="{{date('d-M-Y',strtotime($template[0]->jha_end))}}">
                                @else
                                <input type="text" class="datepicker form-control mr-sm-2" id="jha_end" min="" placeholder="Select JHA End Date" name="jha_end">
                                @endif

                            </div>
                            <div class="col-md-12">
                                <label for="unassessed_hazards" style="padding-right:20px;">Any new or unassessed hazards recognised<br>(If so, it must be mentioned under comments and noted for assessments in the next JHA for this job)</label>
                                @if(isset($template[0]->unassessed_hazards) && $template[0]->unassessed_hazards=='Yes')
                                    <input type="radio" name="unassessed_hazards" value="Yes" checked> Yes
                                    <input type="radio" name="unassessed_hazards" value="No"> No
                                @elseif(isset($template[0]->unassessed_hazards) && $template[0]->unassessed_hazards=='No')
                                    <input type="radio" name="unassessed_hazards" value="Yes"> Yes
                                    <input type="radio" name="unassessed_hazards" value="No" checked> No
                                @else
                                    <input type="radio" name="unassessed_hazards" value="Yes"> Yes
                                    <input type="radio" name="unassessed_hazards" value="No"> No
                                @endif
                            </div>
                            <div class="col-md-12">
                                <label for="comments" style="padding-right:20px;">Comments:</label>
                                @if(isset($template[0]->comments) && $template[0]->comments)
                                <textarea type="text" class="form-control mr-sm-2" id="comments" placeholder="Enter comments" name="comments" value="{{$template[0]->comments}}">{{$template[0]->comments}}</textarea>
                                @else
                                    <input type="text" class="form-control mr-sm-2" id="comments" placeholder="Enter comments" name="comments">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-8">
                                <label for="port_authorities" class="mr-sm-2 mt-1">Where required, have relevant port authorities been notified (Liaise with Office/Agents, if necessary):</label>
                                <select class="form-control mr-sm-2" id="port_authorities" name="port_authorities">
                                    <option value="">Select Activity Type</option>
                                    @if(isset($template[0]->port_authorities) && $template[0]->port_authorities == "Yes")
                                        <option value="Yes" selected>Yes</option>
                                        <option value="Not Required">Not Required</option>
                                        <option value="N/A (Outside port limits)">N/A (Outside port limits)</option>
                                    @elseif(isset($template[0]->port_authorities) && $template[0]->port_authorities == "Not Required")
                                        <option value="Yes">Yes</option>
                                        <option value="Not Required" selected>Not Required</option>
                                        <option value="N/A (Outside port limits)">N/A (Outside port limits)</option>
                                    @elseif(isset($template[0]->port_authorities) && $template[0]->port_authorities == "N/A (Outside port limits)")
                                        <option value="Yes">Yes</option>
                                        <option value="Not Required">Not Required</option>
                                        <option value="N/A (Outside port limits)" selected>N/A (Outside port limits)</option>
                                    @else
                                        <option value="Yes">Yes</option>
                                        <option value="Not Required">Not Required</option>
                                        <option value="N/A (Outside port limits)">N/A (Outside port limits)</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="tools_available" class="mr-sm-2 mt-1">Required Spares & Tools are Available:</label>
                                @if(isset($template[0]->tools_available) && $template[0]->tools_available=='Yes')
                                    <input type="radio" name="tools_available" value="Yes" checked> Yes
                                    <input type="radio" name="tools_available" value="No"> No
                                @elseif(isset($template[0]->tools_available) && $template[0]->tools_available=='No')
                                    <input type="radio" name="tools_available" value="Yes"> Yes
                                    <input type="radio" name="tools_available" value="No" checked> No
                                @else
                                    <input type="radio" name="tools_available" value="Yes"> Yes
                                    <input type="radio" name="tools_available" value="No"> No
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label for="lcd_notified" class="mr-sm-2 mt-1">LCD Notified:</label>
                                <select class="form-control mr-sm-2" id="lcd_notified" name="lcd_notified">
                                    <option value="">Select Activity Type</option>
                                    @if(isset($template[0]->lcd_notified) && $template[0]->lcd_notified && $template[0]->lcd_notified == "Yes")
                                        <option value="Yes" selected>Yes</option>
                                        <option value="N/A">N/A</option>
                                    @elseif(isset($template[0]->lcd_notified) && $template[0]->lcd_notified && $template[0]->lcd_notified == "N/A")
                                        <option value="Yes">Yes</option>
                                        <option value="N/A" selected>N/A</option>
                                    @else
                                        <option value="Yes">Yes</option>
                                        <option value="N/A">N/A</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="remarks" class="mr-sm-2 mt-1">Remarks:</label>
                            @if(isset($template[0]->remarks) && $template[0]->remarks)
                                <input type="text" class="form-control mr-sm-2" id="remarks" placeholder="Enter Remarks" name="remarks"value="{{$template[0]->remarks}}">
                                @else
                                    <input type="text" class="form-control mr-sm-2" id="remarks" placeholder="Enter Remarks" name="remarks">
                                @endif
                            </div>
                </div>

                <div class="row mt-1">
                    <div class="col-md-6">
                        <label><b>Master</b></label>
                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label for="master_name">Name:</label>
                                @if(isset($template[0]->master_name) && $template[0]->master_name)
                                <input type="text" class="form-control mr-sm-2" id="master_name" placeholder="Enter Name" name="master_name" value="{{$template[0]->master_name}}">
                                @else
                                    <input type="text" class="form-control mr-sm-2" id="master_name" placeholder="Enter Name" name="master_name">
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label for="master_date">Date:</label>
                                @if(isset($template[0]->master_date) && $template[0]->master_date)
                                    <input type="text" class="datepicker form-control mr-sm-2" id="master_date" min=""
                                placeholder="Select Review Date" name="master_date" value="{{date('d-M-Y',strtotime($template[0]->master_date))}}">
                                @else
                                    <input type="text" class="datepicker form-control mr-sm-2" id="master_date" min="" placeholder="Date" name="master_date">
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label for="Signature">Signature:</label>
                                <input type="file" class="form-control mr-sm-2" id="master_sign" name="master_sign"  accept="image/*">
                                @if(isset($signature['Master']))
                                {{--<label for="Signature">{{$signature['Master']}}</label>--}}
                                <img height = "200" width = "200" src="{{$Image['Master']}}" alt="">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label><b>Chief Officer</b></label>
                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label for="Name">Name:</label>
                                @if(isset($template[0]->ch_off_name) && $template[0]->ch_off_name)
                                <input type="text" class="form-control mr-sm-2" id="ch_off_name" placeholder="Enter Name" name="ch_off_name" value="{{$template[0]->ch_off_name}}">
                                @else
                                    <input type="text" class="form-control mr-sm-2" id="ch_off_name" placeholder="Enter Name" name="ch_off_name">


                                @endif

                            </div>
                            <div class="col-md-4">
                                <label for="Date">Date:</label>
                                @if(isset($template[0]->ch_off_date) && $template[0]->ch_off_date)
                                    <input type="text" class="datepicker form-control mr-sm-2" id="ch_off_date" min=""
                                placeholder="Select Review Date" name="ch_off_date" value="{{date('d-M-Y',strtotime($template[0]->ch_off_date))}}">
                                @else
                                    <input type="text" class="datepicker form-control mr-sm-2" id="ch_off_date" min="" placeholder="Date" name="ch_off_date">
                                @endif

                            </div>
                            <div class="col-md-4">
                                <label for="Signature">Signature:</label>
                                <input type="file" class="form-control mr-sm-2" id="ch_off_sign" name="ch_off_sign"  accept="image/*">
                                @if(isset($signature['ChiefOff']))
                                {{--<label for="Signature">{{$signature['ChiefOff']}}</label>--}}
                                <img height = "200" width = "200" src="{{$Image['ChiefOff']}}" alt="">
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-md-6">
                        <label><b>Chief Engineer</b></label>
                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label for="Name">Name:</label>
                                @if(isset($template[0]))
                                @if(isset($template[0]->ch_eng_name) && $template[0]->ch_eng_name)
                                <input type="text" class="form-control mr-sm-2" id="ch_eng" placeholder="Enter Name" name="ch_eng_name" value="{{$template[0]->ch_eng_name}}">
                                @else
                                    <input type="text" class="form-control mr-sm-2" id="ch_eng_name" placeholder="Enter Name" name="ch_eng_name">
                                @endif
                                @endif

                            </div>
                            <div class="col-md-4">
                                <label for="Date">Date:</label>
                                @if(isset($template[0]))
                                @if(isset($template[0]->ch_eng_date) && $template[0]->ch_eng_date)
                                    <input type="text" class="datepicker form-control mr-sm-2" id="ch_eng_date" min=""
                                placeholder="Select Review Date" name="ch_eng_date" value="{{date('d-M-Y',strtotime($template[0]->ch_eng_date))}}">
                                @else
                                    <input type="text" class="datepicker form-control mr-sm-2" id="ch_eng_date" min="" placeholder="Date" name="ch_eng_date">
                                @endif
                                @endif

                            </div>
                            <div class="col-md-4">
                                <label for="Signature">Signature:</label>
                                <input type="file" class="form-control mr-sm-2" id="ch_eng_sign" name="ch_eng_sign"  accept="image/*">
                                @if(isset($signature['ChiefEngg']))
                                    {{--<label for="Signature">{{$signature['ChiefEngg']}}</label>--}}
                                    <img height = "200" width = "200" src="{{$Image['ChiefEngg']}}" alt="">
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label><b>2nd Engineer</b></label>
                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label for="Name">Name:</label>
                                @if(isset($template[0]))
                                @if(isset($template[0]->eng2_name) && $template[0]->eng2_name)
                                <input type="text" class="form-control mr-sm-2" id="eng2_name" placeholder="Enter Name" name="eng2_name" value="{{$template[0]->eng2_name}}">
                                @else
                                    <input type="text" class="form-control mr-sm-2" id="eng2_name" placeholder="Enter Name" name="eng2_name">
                                @endif
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label for="Date">Date:</label>
                                @if(isset($template[0]))
                                @if(isset($template[0]->eng2_date) && $template[0]->eng2_date)
                                    <input type="text" class="datepicker form-control mr-sm-2" id="eng2_date" min=""
                                placeholder="Select Review Date" name="eng2_date" value="{{date('d-M-Y',strtotime($template[0]->eng2_date))}}">
                                @else
                                    <input type="text" class="datepicker form-control mr-sm-2" id="eng2_date" min="" placeholder="Date" name="eng2_date">
                                @endif
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label for="Signature">Signature:</label>
                                <input type="file" class="form-control mr-sm-2" id="eng2_sign" name="eng2_sign"  accept="image/*">
                                @if(isset($signature['SecondEngg']))
                                {{--<label for="Signature">{{$signature['SecondEngg']}}</label>--}}
                                <img height = "200" width = "200" src="{{$Image['SecondEngg']}}" alt="">
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <label style="color:red;font-weight:bold;">Joint JHA is essential by C/O and 2/E when overlapping responsibilities and hazards are involved, approved by Chief Engineer and Authorized by Master</label>
                    <div class="col-md-6">
                        <label><b>Reviewed By: SM/FM</b></label>
                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label for="Name">Name:</label>
                                @if(isset($template[0]->sm_name) && $template[0]->sm_name)
                                <input type="text" class="form-control mr-sm-2" id="sm_name" placeholder="Enter Name" name="sm_name" value="{{$template[0]->sm_name}}">
                                @else
                                    <input type="text" class="form-control mr-sm-2" id="sm_name" placeholder="Enter Name" name="sm_name">
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label for="Date">Date:</label>
                                @if(isset($template[0]->sm_date) && $template[0]->sm_date)
                                    <input type="text" class="datepicker form-control mr-sm-2" id="sm_date" min=""
                                placeholder="Select Review Date" name="sm_date" value="{{date('d-M-Y',strtotime($template[0]->sm_date))}}">
                                @else
                                    <input type="text" class="datepicker form-control mr-sm-2" id="sm_date" min="" placeholder="Date" name="sm_date">
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label for="Signature">Signature:</label>
                                <input type="file" class="form-control mr-sm-2" id="sm_sign" name="sm_sign"  accept="image/*">
                                @if(isset($signature['SM']))
                                {{--<label for="Signature">{{$signature['SM']}}</label>--}}
                                <img height = "200" width = "200" src="{{$Image['SM']}}" alt="">
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <select id="dgm_activity_type" name="dgm_activity_type">
                            <option value="">Select Activity Type</option>
                            @if(isset($template[0]->dgm_activity_type) && $template[0]->dgm_activity_type && $template[0]->dgm_activity_type == "Reviewed By")
                                <option value="Reviewed By" selected>Reviewed By</option>
                                <option value="Approved By">Approved By</option>
                                <option value="Reviewed & Approved By">Reviewed & Approved By</option>
                            @elseif(isset($template[0]->dgm_activity_type) && $template[0]->dgm_activity_type && $template[0]->dgm_activity_type == "Approved By")
                                <option value="Reviewed By">Reviewed By</option>
                                <option value="Approved By" selected>Approved By</option>
                                <option value="Reviewed & Approved By">Reviewed & Approved By</option>
                            @elseif(isset($template[0]->dgm_activity_type) && $template[0]->dgm_activity_type && $template[0]->dgm_activity_type == "Reviewed & Approved By")
                                <option value="Reviewed By">Reviewed By</option>
                                <option value="Approved By">Approved By</option>
                                <option value="Reviewed & Approved By" selected>Reviewed & Approved By</option>
                            @else
                                <option value="Reviewed By">Reviewed By</option>
                                <option value="Approved By">Approved By</option>
                                <option value="Reviewed & Approved By">Reviewed & Approved By</option>
                            @endif
                        </select>
                        <label style="padding-left: 10px;"><b>D/GM: </b></label>
                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label for="Name">Name:</label>
                                @if(isset($template[0]->dgm_name) && $template[0]->dgm_name)
                                <input type="text" class="form-control mr-sm-2" id="dgm_name" placeholder="Enter Name" name="dgm_name" value="{{$template[0]->dgm_name}}">
                                @else
                                    <input type="text" class="form-control mr-sm-2" id="dgm_name" placeholder="Enter Name" name="dgm_name">
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label for="Date">Date:</label>
                                @if(isset($template[0]->dgm_date) && $template[0]->dgm_date)
                                    <input type="text" class="datepicker form-control mr-sm-2" id="dgm_date" min=""
                                placeholder="Select Review Date" name="dgm_date" value="{{date('d-M-Y',strtotime($template[0]->dgm_date))}}">
                                @else
                                    <input type="text" class="datepicker form-control mr-sm-2" id="dgm_date" min="" placeholder="Date" name="dgm_date">
                                @endif

                            </div>
                            <div class="col-md-4">
                                <label for="Signature">Signature:</label>
                                <input type="file" class="form-control mr-sm-2" id="dgm_sign" name="dgm_sign"  accept="image/*">
                                @if(isset($signature['DGM']))
                                {{--<label for="Signature">{{$signature['DGM']}}</label>--}}
                                <img height = "200" width = "200" src="{{$Image['DGM']}}" alt="">
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <label class="col-md-12" style="color:red;font-weight:bold;">Identify Team Leader (Name & Rank):</label>
                    <div class="col-md-6">
                        <label>Personnel Assigned (Name & Rank):</label>
                        @if(isset($template[0]->name_rank) && $template[0]->name_rank)
                        <textarea class="form-control mr-sm-2" id="name_rank" placeholder="Enter name & Rank" name="name_rank">{{$template[0]->name_rank}}</textarea>
                        @else
                            <textarea class="form-control mr-sm-2" id="name_rank" placeholder="Enter name & Rank" name="name_rank">{{$template[0]->name_rank}}</textarea>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <select id="dgm_activity_type" name="gm_activity_type">
                            <option value="">Select Activity Type</option>
                            @if(isset($template[0]->gm_activity_type) && $template[0]->gm_activity_type && $template[0]->gm_activity_type == "Reviewed By")
                                <option value="Reviewed By" selected>Reviewed By</option>
                                <option value="Approved By">Approved By</option>
                                <option value="Reviewed & Approved By">Reviewed & Approved By</option>
                            @elseif(isset($template[0]->gm_activity_type) && $template[0]->gm_activity_type && $template[0]->gm_activity_type == "Approved By")
                                <option value="Reviewed By">Reviewed By</option>
                                <option value="Approved By" selected>Approved By</option>
                                <option value="Reviewed & Approved By">Reviewed & Approved By</option>
                            @elseif(isset($template[0]->gm_activity_type) && $template[0]->gm_activity_type && $template[0]->gm_activity_type == "Reviewed & Approved By")
                                <option value="Reviewed By">Reviewed By</option>
                                <option value="Approved By">Approved By</option>
                                <option value="Reviewed & Approved By" selected>Reviewed & Approved By</option>
                            @else
                                <option value="Reviewed By">Reviewed By</option>
                                <option value="Approved By">Approved By</option>
                                <option value="Reviewed & Approved By">Reviewed & Approved By</option>
                            @endif
                        </select>
                        <label style="padding-left: 10px;"><b>GM: </b></label>
                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label for="Name">Name:</label>
                                @if(isset($template[0]->gm_name) && $template[0]->gm_name)
                                <input type="text" class="form-control mr-sm-2" id="gm_name" placeholder="Enter Name" name="gm_name" value="{{$template[0]->gm_name}}">
                                @else
                                    <input type="text" class="form-control mr-sm-2" id="gm_name" placeholder="Enter Name" name="gm_name">
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label for="Date">Date:</label>
                                @if(isset($template[0]->gm_date) && $template[0]->gm_date)
                                    <input type="text" class="datepicker form-control mr-sm-2" id="gm_date" min=""
                                placeholder="Select Review Date" name="gm_date" value="{{date('d-M-Y',strtotime($template[0]->gm_date))}}">
                                @else
                                    <input type="text" class="datepicker form-control mr-sm-2" id="gm_date" min="" placeholder="Date" name="gm_date">
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label for="Signature">Signature:</label>
                                <input type="file" class="form-control mr-sm-2" id="gm_sign" name="gm_sign"  accept="image/*">
                                @if(isset($signature['GM']))
                                {{--<label for="Signature">{{$signature['GM']}}</label>--}}
                                <img height = "200" width = "200" src="{{$Image['GM']}}" alt="">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
        			<div class="col-md-12" style="text-align:center;">
        				<button id="RAfrmSubmit" class="btn btn-primary" type="submit"  >
                            Submit
                        </button>
        			</div>
        	   </div>
            </form>
        </div>
    </div>
</div>
@include('modals.custom.risk-matrix-modal')
@include('modals.custom.riskAssessment.modal-add-second-risk-section')
@endsection
@section('footer_scripts')
    <!-- dynamic form building -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
    <!-- summernote -->
    <script type="text/javascript" src="/js/summernote/summernote.js"></script>
    <!-- ajax form -->
    <script src="/js/jquery/jquery.form.js"></script>
    <script>
        var riskMatriceColor = {!! json_encode($riskMatriceColor) !!};
        var riskFactor = {!! json_encode($riskFactor) !!};
        var templateData = {!! json_encode($templateData) !!};
        var isAdmin = {!! json_encode(Auth::user()->isAdmin()) !!};
        var redirectAddress = '/userRiskAssesment';
    </script>
    <script>

        $(document).ready(function(){

            var form_json = {!! json_encode($template[0]->form_json) !!};
            var formRenderOptions = {
                formData: form_json
		    }
            var formRenderInstance = $('#editt').formRender(formRenderOptions);

            $('#RiskForm').submit(function() {

                $('#form_temp').val(JSON.stringify(formRenderInstance.userData));
                if($('#form_temp').val()=='null'){
                    return false;
                }
                else if(isAdmin && !$('#template_name').val()){
                    toastr.error('Please Enter a Template Name');
                    return false;
                }
                else if(section2Rows.length==0){
                    toastr.error('Add Atleast 1 Risk Assessment');
                    return false;
                }
                else if($('#dept-id').val() == ''){
                    toastr.error('Enter Department');
                    return false;
                }
                else{
                    // console.log($('#form_temp').val());
                    return true;
                }
            });
        });
</script>
<script type="text/javascript" src="\js\custom\RiskAssessment\second_section.js"></script>
<script type="text/javascript" src="\js\custom\RiskAssessment\risk_assessment_create.js"></script>

@endsection
