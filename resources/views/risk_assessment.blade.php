@extends('layouts.app')
@section('template_title')
    Risk Assessment
@endsection
@section('template_linked_css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="/css/dataTables/dataTables.bootstrap.min.css">
<link href="/css/custom/b18/index.css" rel="stylesheet"> 
@endsection
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
        
            <div class="row mb-3 ml-2">
            @if(! Auth::user()->isAdmin())
                <a href="risk_assessment_create">
                    <button class="btn btn-danger"><i class="fa fa-plus-circle"></i> Add New RA</button>
                </a>
                <div class="ml-3">                     
                    <button class="btn btn-primary" id="btnExport"><span><i class="fa fa-file-text-o"></i></span> Export To Excel</button>                    
                </div>
            @else
                <a href="risk_assessment_create">
                    <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Add New Template">
                        <i class="fa fa-plus-circle"></i> Add New Template
                    </button>
                </a>
                
            @endif
                
            </div>
            @if(! Auth::user()->isAdmin())
            <div class="tab">
              <button class="tablinks active" onclick="openTab(event, 'Templates')">Templates</button>
              <button class="tablinks" onclick="openTab(event, 'Registered')">User</button>
            </div>
            @endif
            
            <div id="Templates" class="tabcontent tabShown"> 
                <div class="row">
                    <div class="col-lg-12 table-responsive">
                        <table class="table table-bordered" id="templates_table">
                            <thead>
                                <tr>
                                    {{--<!-- <th class="text-center">Template ID</th> -->--}}
                                    <th class="text-center">Template name</th>
                                    {{--<!-- <th class="text-center">Department Name</th> -->--}}
                                    <th class="text-center">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($templates as $template)
                                    <tr>
                                        {{--<!-- <td class="text-center">{{$template->template_code}}-{{$template->ref}}</td> -->--}}
                                        <td class="text-center">{{$template->name}}</td>
                                        {{--<!-- <td class="text-center">{{$template->department_name}}</td> -->--}}
                                        <td class="text-center">
                                            @if(Auth::user()->isAdmin())
                                                <a class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" 
                                                onclick="return confirm('Are you sure you want to delete this item?');" href="template-delete/{{$template->id}}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                                <a class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"
                                                href="template-edit/{{$template->id}}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @else
                                                <a href="template-use/{{$template->id}}" class="btn btn-primary">Use</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
            
            <div id="Registered" class="tabcontent"> 
                @if($saved)
                    <div class="row">
                        <div class="col-lg-12 table-responsive">
                            <table class="table table-bordered" id="saved_table">
                                <thead>
                                    <tr>
                                        <!-- <th>ID</th> -->
                                        <th>status</th>
                                        <th>Vessel Name</th>
                                        <th>Weather</th>
                                        <th>Voyage</th>
                                        <th>Location</th>
                                        <th>Tide</th>                                
                                        <th>Work Activity</th>
                                        <th>Work Area</th>
                                        <th>Visibility</th>
                                        <th>Master</th>
                                        <th>Chief Officer</th>
                                        <th>Chief Engineer</th>
                                        <th>Second Engineer</th>
                                        <th>SM/FM</th>
                                        <th>DGM</th>
                                        <th>GM</th>                                        
                                        <th>Remarks</th>
                                        <th>Comments</th>
                                        <th class="text-center">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($saved as $items)
                                     
                                        <tr>
                                            <!-- <td>RA-{{$items->code}}-{{$items->ref}}</td> -->
                                            <td>
                                                @php
                                                    if($items->status == 'Not Approved') { $stat_color = 'primary'; }
                                                    if($items->status == 'Approved') { $stat_color = 'success'; }
                                                    if($items->status == 'Draft') { $stat_color = 'warning'; }
                                                    if($items->status == 'Correction Required') { $stat_color = 'danger'; }
                                                @endphp
                                                <div class='w-100 h-100 btn btn-danger' style=' writing-mode:vertical-lr;text-orientation:upright; height:300px !important;'>
                                                    {{isset($items->status)?$item->status:null}}
                                                </div>
                                            </td>
                                            <td>{{$items->v_name}}</td>
                                            <td>{{$items->weather}}</td>
                                            <td>{{$items->voyage}}</td>
                                            <td>{{$items->location}}</td>
                                            <td>{{$items->tide}}</td>
                                            <td>{{$items->work_activity}}</td>
                                            <td>{{$items->work_area}}</td>
                                            <td>{{$items->visibility}}</td>
                                            <td>
                                                <b>Assessed on : </b>{{$items->master_date}}<br>
                                                <b>Assessed by : </b>{{$items->master_name}}<br>
                                            </td>
                                            <td>
                                                <b>Assessed on : </b>{{$items->ch_off_date}}<br>
                                                <b>Assessed by : </b>{{$items->ch_off_name}}<br>
                                            </td>
                                            <td>
                                                <b>Assessed on : </b>{{$items->ch_eng_date}}<br>
                                                <b>Assessed by : </b>{{$items->ch_eng_name}}<br>
                                            </td>
                                            <td>
                                                <b>Assessed on : </b>{{$items->eng2_date}}<br>
                                                <b>Assessed by : </b>{{$items->eng2_name}}<br>
                                            </td>
                                            <td>
                                                <b>Assessed on : </b>{{$items->sm_date}}<br>
                                                <b>Assessed by : </b>{{$items->sm_name}}<br>
                                            </td>
                                            <td>
                                                <b>Assessed on : </b>{{$items->dgm_date}}<br>
                                                <b>Assessed by : </b>{{$items->dgm_name}}<br>
                                            </td>
                                            <td>
                                                <b>Assessed on : </b>{{$items->gm_date}}<br>
                                                <b>Assessed by : </b>{{$items->gm_name}}<br>
                                            </td>
                                            <td>{{$items->remarks}}</td>
                                            <td>{{$items->comments}}</td>
                                            <td class="text-center">
                                            <a href="risk_assessment_delete/{{$items->id}}" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger mb-2">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            <a href="risk_assessment_edit/{{$items->id}}">
                                            <button class="btn btn-primary"><i class="fa fa-edit"></i></button>
                                            </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div> 
        </div>
    </div>
</div>
@endsection
@section('footer_scripts') 
    <script type="text/javascript" src="\js\dataTables\dataTables.min.js"></script>
    <script type="text/javascript" src="\js\custom\RiskAssessment\index.js"></script> 
    <script type="text/javascript" src="\js\custom\RiskAssessment\table2excel.js"></script>
    <script type="text/javascript">
        $(function () {
          $("#btnExport").click(function () {
            // $("#hazard_master_table").table2excel({
            //   exclude: ".noExport",
            //   filename: "Table.xls"
            // });
            // $('#hazard_master_table .showMore a').remove();
            $("#saved_table").table2excel({
              exclude: ".noExport",
              filename: "RiskAssessmentTable.xls"
            });
            
          });
        });
        </script>
@endsection