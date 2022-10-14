@extends('layouts.app')

@section('template_title')
    Inspection & Audit
@endsection

@section('template_linked_css')
    {{-- Bootstrap
    ======================== --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/roundSlider/1.3.2/roundslider.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    {{-- Degree Picker css
    ============================= --}}
    <link rel="stylesheet" href="{{ asset('css/degreePicker/degree_picker.css') }}">

    {{-- Clock Picker
    ============================= --}}
    <link rel="stylesheet" href="{{ asset('css/ClockPicker/bootstrap-clockpicker.min.css') }}">




    <!-- Date-picker -->
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
    {{-- <!-- <script src = "https://code.jquery.com/jquery-1.10.2.js"></script> --> --}}
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

    {{-- Custom Css
    ======================= --}}
    <link href="/css/custom/audit/audit_create.css" rel="stylesheet">
@endsection

@section('content')
    <!-- back button
                   ===================== -->
    <div class="container mb-3">
        <div class="row">
            <div class="col-12">
                <a href="/inspection-audit">
                    <button type="button" class="btn btn-dark"><i class="fa fa-long-arrow-left" aria-hidden="true"
                            style="color:white;"></i></button>
                </a>
            </div>
        </div>
    </div>

    <!-- main content
                   ======================= -->
    <div class="container">
        <div class=" ">
            <div class="card shadow p-3 py-5" id="slide_div">
                <!-- Html
                         ================== -->
                <div class="mx-md-5 ">
                    <form class="p-md-3 mx-md-5 " method="post" action="{{ url('/inspection-audit/store') }}"
                        id="audit_Form" enctype="multipart/form-data" files="true">
                        @csrf

                        <!-- Circles which indicates the steps of the form: -->
                        {{-- if input fields are increased then have to increse the span --}}
                        <div style="text-align:center;margin-top:40px; display: block;">
                            <span class="step"></span>
                            <span class="step"></span>
                        </div>

                                <!-- Form Title
                                        ======================== -->
                                <h2 class="my-3 font-weight-light text-center">Inspection & Audits</h2>
                                <hr>



                                {{-- Step 1
                            ======================== --}}
                        <div class="tab form-group">
                            {{--<h5 class="text-center my-3">Non-Confirmance Reports</h5>

                            <hr>--}}

                            <div class="form-row">
                                <div class="form-group col-md-4 col-lg-4 col-sm-12 col-xs-12">
                                    <label for="audit_vessel">Vessel</label>
                                    <input style="background-color: #d1cbcb !important;" value="{{ $name }}"
                                        disabled type="text" placeholder="Vessel name..." id="Vessel_Name_id"
                                        class="form-control" name="audit_vessel">
                                </div>
                                <div class="form-group col-md-4 col-lg-4 col-sm-12 col-xs-12">
                                    <label for="audit_nc_report">NC Report</label>
                                    <input style="background-color: #d1cbcb !important;" value='{{ $id }}'
                                        disabled type="text" placeholder="NC Report..." id="form_id" class="form-control"
                                        name="audit_nc_report">
                                </div>
                                <div class="form-group col-md-4 col-lg-4 col-sm-12 col-xs-12">
                                    <label for="audit_location">Location</label>
                                    {{-- <!-- <input type="text" placeholder="Enter location..." id="audit_location" class="form-control" name="audit_location" value="{{$data->location}}">
                         --> --}}
                                    <input type="text" placeholder="Enter location..." id="audit_location"
                                        class="form-control" name="audit_location" value="">

                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                    <label for="audit_type">Type of Audit</label>
                                    <select id="type_of_audit" class="form-control" name="audit_type">
                                        {{-- <!-- @if ($data->type_of_audit == '')
                                <option selected hidden disabled value = "{{$data->type_of_audit}}"> Select Type Of Audit</option>
                              @else
                                <option selected hidden value = "{{$data->type_of_audit}}">{{ $data->type_of_audit }}</option>
                              @endif --> --}}
                                        <option selected hidden disabled> Select Type Of Audit</option>


                                        <option value="Internal Audit">Internal Audit</option>
                                        <option value="External Audit">External Audit</option>
                                        <option value="PSC">PSC</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                    <label for="audit_date">Date</label>
                                    {{-- <!-- <input  type="text" class="form-control date" id="audit_date" name="audit_date" placeholder="Date of audit..." autocomplete="off" value = "{{$data->report_date}}"> --> --}}
                                    <input type="text" class="form-control date" id="audit_date" name="audit_date"
                                        placeholder="Date of audit..." autocomplete="off">
                                </div>
                                <div class="form-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                    <label for="nc_auditor">Name of the Auditor</label>
                                    {{-- <!-- <input type="text" class="form-control " id="nc_auditor" name='name_of_the_auditor_nc' placeholder="Enter name" value = "{{ $data->name_of_auditorr }}"> --> --}}
                                    <input type="text" class="form-control " id="nc_auditor" name='name_of_the_auditor_nc'
                                        placeholder="Enter name">
                                </div>

                            </div>

                            {{-- Buttons(next/prev) --}}
                            <div class="mr-auto ml-auto">
                                <div class="d-flex">
                                    <button class="btn btn-info mt-5 w-25 mr-auto" type="button" id="prevBtn"
                                        onclick="nextPrev(-1)">Previous </button>
                                    <button class="btn btn-info mt-5 w-25 ml-auto investigation_tab" type="button"
                                        id="nextBtn" onclick="nextPrev(1)" name="first">Next </button>
                                </div>
                            </div>
                        </div>
                        {{-- Step 2
                  ======================== --}}

                        <div class="tab form-group">
                            {{-- <h5 class="text-center my-3">Non-Confirmance Reports</h5>
                            <hr> --}}
                            <div class="form-row">
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6" id="non_confirmity_id">
                                    <button type="button" class="btn btn-outline-success btn-block nc-trick" data-toggle="modal"
                                        data-target="#nomConfirmityModal">
                                        <i class="fa fa-check-square-o" aria-hidden="true"></i> NON-CONFIRMITY
                                    </button>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6" id="observation_id">
                                    <button type="button" class="btn btn-outline-success btn-block nc-trick" data-toggle="modal"
                                        data-target="#observationModal">
                                        <i class="fa fa-check-square-o" aria-hidden="true"></i> OBSERVATION
                                    </button>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6" id="psc_id"
                                    style="display:none">
                                    <button type="button" class="btn btn-outline-success btn-block" data-toggle="modal"
                                        data-target="#pscModal">
                                        <i class="fa fa-check-square-o" aria-hidden="true"></i> PSC
                                    </button>
                                </div>
                            </div>
                            <hr>

                            <!-- nc and observation table
                                     =================================== -->
                            <div class="table-responsive" id="NO_OBS_tab">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="oneliner" scope="col">Type</th>

                                            <th class="oneliner" scope="col">Major N/C </th>
                                            <th class="oneliner" scope="col">N/C </th>
                                            <th class="oneliner" scope="col">Description </th>
                                            {{-- <th class="oneliner" scope="col">ISM Clause or Other Ref </th> --}}
                                            <th class="oneliner" scope="col"> Due Date </th>
                                            <th class="oneliner" scope="col"> Action </th>
                                            {{-- <th class="oneliner" scope="col">Signed by Master/Auditee </th> --}}
                                            {{-- <th class="oneliner" scope="col">Signed by Auditor </th> --}}
                                            {{-- <th class="oneliner" scope="col">Root Cause/s </th> --}}
                                            {{-- <th class="oneliner" scope="col">Corrective Action/s </th> --}}
                                            {{-- <th class="oneliner" scope="col">Corrective Action/s date completed </th> --}}
                                            {{-- <th class="oneliner" scope="col">Corrective Action/s upload evidence </th> --}}
                                            {{-- <th class="oneliner" scope="col">Preventive Action/s</th> --}}
                                            {{-- <th class="oneliner" scope="col">Preventive Action/s date</th> --}}
                                            {{-- <th class="oneliner" scope="col">Preventive Action/s upload evidence</th> --}}
                                            {{-- <th class="oneliner" scope="col">Signature</th> --}}
                                            {{-- <th class="oneliner" scope="col">Signature image</th> --}}
                                            {{-- <th class="oneliner" scope="col">Accepted</th> --}}
                                            {{-- <th class="oneliner" scope="col">Accepted image</th> --}}
                                            {{-- <th class="oneliner" scope="col">Comments</th> --}}
                                            {{-- <th class="oneliner" scope="col">Confirm by DPA</th> --}}
                                            {{-- <th class="oneliner" scope="col">Date</th> --}}
                                            {{-- <th class="oneliner" scope="col">If verification required at the next Audit</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody id='noc-table-id'>
                                    </tbody>
                                </table>
                            </div>
                            <!-- psc table
                                     ===================== -->
                            <div class="table-responsive" id="PSC_tab" style="display: none;">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Type</th>
                                            <th scope="col">Description </th>
                                            <th scope="col"> Ref</th>
                                            <th scope="col">Code </th>
                                            <th scope="col">Action </th>
                                        </tr>
                                    </thead>
                                    <tbody id='psc_table_id'>
                                    </tbody>
                                </table>
                            </div>

                            {{-- Buttons(next/prev) --}}
                            <div class="mr-auto ml-auto">
                                <div class="d-flex">
                                    <button class="btn btn-info mt-5 w-25 mr-auto" type="button" id="prevBtn"
                                        onclick="nextPrev(-1)">Previous </button>
                                    <button class="btn btn-info mt-5 w-25 ml-auto incident_header" type="button"
                                        id="nextBtn" onclick="nextPrev(1)">Next </button>
                                </div>
                            </div>
                        </div>


                        <!-- hidden inputs
                                  ===================================-->
                        <input hidden type="text" id="PSC_hidden_input" name="PSC_hidden_input" id="">





                        <!-- The Modal NON-CONFIRMITY
                                  ============================================-->
                        <div class="modal fade" id="nomConfirmityModal">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content p-5">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title" style="text-align: center!important;">Non Confirmity Form
                                        </h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="modal-body">


                                        <div class="form-group">


                                            <input type="hidden" id="editID_NC" value="null" >
                                            <div class="form-row mt-1">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="type_of_nc"
                                                        id="major_nc_1" value="MAJOR_NC">
                                                    <label class="form-check-label" for="type_of_nc_1">Major N/C</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="type_of_nc"
                                                        id="type_of_nc_2" value="NC">
                                                    <label class="form-check-label" for="type_of_nc_2">N/C</label>
                                                </div>
                                            </div>

                                            <div class="form-row mt-1">
                                                <label for="nc_description">Description</label>
                                                <textarea class="form-control" id="nc_description" name='description_nc'
                                                    rows="3"></textarea>
                                            </div>

                                            <div class="form-row mt-1">
                                                <label for="nc_ism_clause">ISM Clause or Other Ref</label>
                                                <textarea class="form-control" id="nc_ism_clause" name="ism_clause_nc"
                                                    rows="2"></textarea>
                                            </div>

                                            <div class="form-row mt-1">
                                                <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                    <label for="nc_ism_clause">Due Date</label>
                                                    <input type="text" class="form-control date" id="audit_non_confirmity"
                                                        name="audit_non_confirmity" placeholder="Enter date...">
                                                </div>
                                                <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                    <label for="nc_ism_clause">Signed by Master/Auditee</label>
                                                    <input type="text" class="form-control" id="nc_signed_by_master_text"
                                                        named="signed_by_master">
                                                    <input type="file" class="form-control" id="nc_signed_by_master"
                                                        named="signed_by_master">
                                                        <div id="nc_signed_by_master_prefill"></div>
                                                </div>
                                                <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                    <label for="nc_ism_clause">Signed by Auditor</label>
                                                    <input type="text" class="form-control" id="nc_signed_by_auditor_text"
                                                        name="signed_by_auditor">
                                                    <input type="file" class="form-control" id="nc_signed_by_auditor"
                                                        name="signed_by_auditor">
                                                        <div id="nc_signed_by_auditor_prefill"></div>
                                                </div>
                                            </div>

                                            <div class="form-row mt-1" id='root_cause_increase'>
                                                <!-- <label for="nc_root_cause">Root Cause/s</label> -->
                                                <div class="input-group">
                                                    {{-- Dropdown
                                            ================================ --}}
                                                    @foreach ($dropdown as $dd)
                                                        @php
                                                            $name = str_replace(' ', '', $dd->dropdown_name);
                                                        @endphp
                                                        @if (Str::lower($name) == 'rootcauses')
                                                            <div class=" " style="width: 100%;">
                                                                {{-- Dropdown 1 --}}
                                                                <div class="form-group col-12 my-3">
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <label class="input-group-text"
                                                                                for="inputGroupSelect01">
                                                                                {{ $dd->dropdown_name }}
                                                                            </label>
                                                                        </div>

                                                                        <select id="{{ Str::lower($name) }}" required
                                                                            @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') multiple @endif
                                                                            class="custom-select drop"
                                                                            myid="dd{{ $dd->id }}"
                                                                            @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') name="{{ Str::lower($name) }}_first[]" @else name="{{ Str::lower($name) }}_first" @endif
                                                                            required>
                                                                            @if (Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause')
                                                                                <option value=0 disabled selected>None
                                                                                    Selected</option>
                                                                            @endif
                                                                            @foreach ($dropdownmain as $ddmain)

                                                                                @if ($ddmain->dropdown_id == $dd->id)
                                                                                    <option value="{{ $ddmain->id }}">
                                                                                        {{ $ddmain->type_main_name }}
                                                                                    </option>
                                                                                @endif

                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                {{-- Dropdown 2 --}}
                                                                <div class="pl-4 form-group col-12 my-3"
                                                                    id="display_dd{{ $dd->id }}"
                                                                    style="display: none;">
                                                                    <div class="pl-3 input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <label class="input-group-text"
                                                                                for="inputGroupSelect01">Options </label>
                                                                        </div>
                                                                        <select
                                                                            @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') multiple @endif
                                                                            class="custom-select droptwo"
                                                                            @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') name="{{ Str::lower($name) }}_second[]" @else name="{{ Str::lower($name) }}_second" @endif
                                                                            myidtwo="ddd{{ $dd->id }}"
                                                                            id="dd{{ $dd->id }}">
                                                                            @if (Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause')
                                                                                <option value=0 disabled selected>None
                                                                                    Selected</option>
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                {{-- Dropdown 3 --}}
                                                                <div class="pl-5 form-group col-12 my-3"
                                                                    id="display_ddd{{ $dd->id }}"
                                                                    style="display: none;">
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <label class="input-group-text"
                                                                                for="inputGroupSelect01">Options</label>
                                                                        </div>
                                                                        <select
                                                                            @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') multiple @endif
                                                                            class="custom-select"
                                                                            @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') name="{{ Str::lower($name) }}_third[]" @else name="{{ Str::lower($name) }}_third" @endif
                                                                            id="ddd{{ $dd->id }}">
                                                                            @if (Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause')
                                                                                <option value=0 disabled selected>None
                                                                                    Selected</option>
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div class="root_causes_prefill"></div>
                                            </div>

                                            <div class="form-row mt-1" id='corrective_action_increase_NC'>
                                                <label for="nc_corrective_action">Corrective Action/s</label>
                                                <div class="input-group">
                                                    <textarea class="form-control mr-2 mb-2" id="nc_corrective_action_1"
                                                        name="nc_corrective_action[]" rows="2"></textarea>
                                                    <button type="button" class="btn btn-primary ml-1 mb-2"
                                                        id='corrective_increasetext_NC' onclick="addmoreCA()">Add</button>
                                                </div>
                                            </div>
                                            <div class="corrective_actions_prefill"></div>

                                            <div class="form-row mt-1">
                                                <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                    <label for="nc_corrective_action_date">Date Completed</label>
                                                    <input type="text" class="form-control "
                                                        id="nc_corrective_action_complete_date"
                                                        name="nc_corrective_action_complete_date"
                                                        placeholder="Enter date...">
                                                </div>
                                                <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                    <label for="nc_corrective_action_evidence">Upload Evidence</label>
                                                    <input type="file" class="form-control"
                                                        id="nc_corrective_action_evidence"
                                                        name="nc_corrective_action_evidence" multiple>
                                                        <div class="corrective_action_img"></div>
                                                </div>
                                            </div>

                                            <div class="form-row mt-1" id='preventive_action_increase'>
                                            {{-- Dropdown
                                            ================================ --}}
                                                @foreach ($dropdown as $dd)
                                                    @php
                                                        $name = str_replace(' ', '', $dd->dropdown_name);
                                                    @endphp
                                                    @if (Str::lower($name) == 'preventiveactions')
                                                        <div class=" " style="width: 100%;">
                                                            {{-- Dropdown 1 --}}
                                                            <div class="form-group col-12 my-3">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <label class="input-group-text"
                                                                            for="inputGroupSelect01">
                                                                            {{ $dd->dropdown_name }}
                                                                        </label>
                                                                    </div>

                                                                    <select id="{{ Str::lower($name) }}" required
                                                                        @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') multiple @endif
                                                                        class="custom-select drop"
                                                                        myid="dd{{ $dd->id }}"
                                                                        @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') name="{{ Str::lower($name) }}_first[]" @else name="{{ Str::lower($name) }}_first" @endif
                                                                        required>
                                                                        @if (Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause')
                                                                            <option value=0 disabled selected>None Selected
                                                                            </option>
                                                                        @endif
                                                                        @foreach ($dropdownmain as $ddmain)

                                                                            @if ($ddmain->dropdown_id == $dd->id)
                                                                                <option value="{{ $ddmain->id }}">
                                                                                    {{ $ddmain->type_main_name }}
                                                                                </option>
                                                                            @endif

                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            {{-- Dropdown 2 --}}
                                                            <div class="pl-4 form-group col-12 my-3"
                                                                id="display_dd{{ $dd->id }}" style="display: none;">
                                                                <div class="pl-3 input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <label class="input-group-text"
                                                                            for="inputGroupSelect01">Options </label>
                                                                    </div>
                                                                    <select
                                                                        @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') multiple @endif
                                                                        class="custom-select droptwo"
                                                                        @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') name="{{ Str::lower($name) }}_second[]" @else name="{{ Str::lower($name) }}_second" @endif
                                                                        myidtwo="ddd{{ $dd->id }}"
                                                                        id="dd{{ $dd->id }}">
                                                                        @if (Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause')
                                                                            <option value=0 disabled selected>None Selected
                                                                            </option>
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            {{-- Dropdown 3 --}}
                                                            <div class="pl-5 form-group col-12 my-3"
                                                                id="display_ddd{{ $dd->id }}" style="display: none;">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <label class="input-group-text"
                                                                            for="inputGroupSelect01">Options</label>
                                                                    </div>
                                                                    <select
                                                                        @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') multiple @endif
                                                                        class="custom-select"
                                                                        @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') name="{{ Str::lower($name) }}_third[]" @else name="{{ Str::lower($name) }}_third" @endif
                                                                        id="ddd{{ $dd->id }}">
                                                                        @if (Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause')
                                                                            <option value=0 disabled selected>None Selected
                                                                            </option>
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                                <div class="preventive_actions_prefill"></div>
                                            </div>

                                            <div class="form-row mt-1">
                                                <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                    <label for="nc_preventive_action_date">Date Completed</label>
                                                    <input type="text" class="form-control "
                                                        id="nc_preventive_action_complete_date"
                                                        name="nc_preventive_action_complete_date"
                                                        placeholder="Enter date...">
                                                </div>
                                                <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                    <label for="nc_preventive_action_evidence">Upload Evidence</label>
                                                    <input multiple type="file" class="form-control"
                                                        id="nc_preventive_action_evidence"
                                                        name="nc_preventive_action_evidence">
                                                        <div class="preventive_evidence"></div>

                                                </div>
                                            </div>

                                            <div class="form-row mt-1">
                                                <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                    <label for="nc_preventive_action_signed">Signed</label>
                                                    <input type="text" class="form-control "
                                                        id="nc_preventive_action_complete_signed"
                                                        name="nc_preventive_action_complete_signed"
                                                        placeholder="Enter sign">
                                                    <input type="file" class="form-control mt-1"
                                                        id="nc_preventive_action_sign_imagebox"
                                                        name="nc_preventive_action_sign_imagebox">
                                                        <div id="nc_preventive_action_sign_imagebox_prefill"></div>
                                                </div>
                                                <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                    <label for="nc_preventive_action_accepted">Accepted</label>
                                                    <input type="text" class="form-control "
                                                        id="nc_preventive_action_complete_accepted"
                                                        placeholder="Enter sign">
                                                    <input type="file" class="form-control mt-1"
                                                        id="nc_preventive_action_accepted_imagebox"
                                                        name="nc_preventive_action_accepted_imagebox">
                                                        <div id="nc_preventive_action_accepted_imagebox_prefill"></div>
                                                </div>
                                            </div>

                                            <h3>Follow up & close out</h3>
                                            <div class="form-row mt-1 mb-2">
                                                <label for="nc_comments">Comments</label>
                                                <textarea class="form-control" id="nc_comments" name="nc_comments"
                                                    rows="2"></textarea>
                                            </div>

                                            <div class="form-row mt-1 d-flex">
                                                <label for="confirmed_by_dpa ">Confirmed BY DPA</label>
                                                <select
                                                    class="form-control custom col-md-2 col-lg-2 col-sm-2 col-xs-2 ml-1"
                                                    name="confirmed_by_dpa" id="confirmed_by_dpa">
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </div>

                                            <div class="form-group mt-1">
                                                <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                    <label for="nc_confirm_date">Date</label>
                                                    <input type="text" class="form-control " id="nc_confirm_date"
                                                        name="nc_confirm_date" placeholder="Enter date...">
                                                </div>
                                                <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                    <label for="">If verification required at the next Audit</label>
                                                    <input type="checkbox" id="nc_verification_checkbox">
                                                    <input type="text" hidden  id="nc_verification" value="false">
                                                </div>
                                            </div>

                                        </div>


                                    </div>
                                    <!-- Modal footer -->
                                    <div class="modal-footer" style="justify-content: center!important;">
                                        <button type="button" class="btn btn-primary " data-dismiss="modal"
                                            id='increaserow-nc' value='non-confirmity'>Ok</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- The Modal OBSERVATION
                                  =============================================-->
                        <div class="modal fade" id="observationModal">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content p-5">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title" style="text-align: center!important;">OBSERVATION FORM
                                        </h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <div class="form-group">


                                            <div class="form-row mt-1">
                                                <label for="nc_description">Description</label>
                                                <input type="hidden" id="editID_OBS" value="null" >
                                                <textarea class="form-control" id="obs_description" rows="3"></textarea>
                                            </div>
                                            <div class="form-row mt-1">
                                                <label for="nc_ism_clause">ISM Clause or Other Ref</label>
                                                <textarea class="form-control" id="obs_ism_clause" rows="2"></textarea>
                                            </div>
                                            <div class="form-row mt-1">
                                                <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                    <label for="nc_ism_clause">Date</label>
                                                    <input type="text" class="form-control " id="observation_date"
                                                        placeholder="Enter date...">
                                                </div>
                                                <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                    <label for="obs_signed_by_master">Signed by Master/Auditee</label>
                                                    <input type="text" class="form-control"
                                                        id="obs_signed_by_master_text" named="signed_by_master">
                                                    <input type="file" class="form-control" id="obs_signed_by_master">
                                                    <div id="obs_signed_by_master_prefill"></div>
                                                </div>
                                                <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                    <label for="obs_signed_by_auditor">Signed by Auditor</label>
                                                    <input type="text" class="form-control"
                                                        id="obs_signed_by_auditor_text" name="signed_by_auditor">
                                                    <input type="file" class="form-control" id="obs_signed_by_auditor">
                                                    <div id="obs_signed_by_auditor_prefill"></div>
                                                </div>
                                            </div>
                                            <div class="form-row mt-1" id='root_cause_increase_obs'>
                                                {{-- Dropdown
                                       ================================ --}}
                                                @foreach ($dropdown as $dd)
                                                    @php
                                                        $name = str_replace(' ', '', $dd->dropdown_name);
                                                    @endphp
                                                    @if (Str::lower($name) == 'rootcauses')
                                                        <div class=" " style="width: 100%;">
                                                            {{-- Dropdown 1 --}}
                                                            <div class="form-group col-12 my-3">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <label class="input-group-text"
                                                                            for="inputGroupSelect01">
                                                                            {{ $dd->dropdown_name }}
                                                                        </label>
                                                                    </div>

                                                                    <select id="obs_{{ Str::lower($name) }}" required
                                                                        @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') multiple @endif
                                                                        class="custom-select drop"
                                                                        myid="obs_dd{{ $dd->id }}"
                                                                        @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') name="{{ Str::lower($name) }}_first[]" @else name="{{ Str::lower($name) }}_first" @endif
                                                                        required>
                                                                        @if (Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause')
                                                                            <option value=0 disabled selected>None Selected
                                                                            </option>
                                                                        @endif
                                                                        @foreach ($dropdownmain as $ddmain)

                                                                            @if ($ddmain->dropdown_id == $dd->id)
                                                                                <option value="{{ $ddmain->id }}">
                                                                                    {{ $ddmain->type_main_name }}
                                                                                </option>
                                                                            @endif

                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            {{-- Dropdown 2 --}}
                                                            <div class="pl-4 form-group col-12 my-3"
                                                                id="display_obs_dd{{ $dd->id }}"
                                                                style="display: none;">
                                                                <div class="pl-3 input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <label class="input-group-text"
                                                                            for="inputGroupSelect01">Options </label>
                                                                    </div>
                                                                    <select
                                                                        @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') multiple @endif
                                                                        class="custom-select droptwo"
                                                                        @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') name="{{ Str::lower($name) }}_second[]" @else name="{{ Str::lower($name) }}_second" @endif
                                                                        myidtwo="d_obs_dd{{ $dd->id }}"
                                                                        id="obs_dd{{ $dd->id }}">
                                                                        @if (Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause')
                                                                            <option value=0 disabled selected>None Selected
                                                                            </option>
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            {{-- Dropdown 3 --}}
                                                            <div class="pl-5 form-group col-12 my-3"
                                                                id="display_d_obs_dd{{ $dd->id }}"
                                                                style="display: none;">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <label class="input-group-text"
                                                                            for="inputGroupSelect01">Options</label>
                                                                    </div>
                                                                    <select
                                                                        @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') multiple @endif
                                                                        class="custom-select"
                                                                        @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') name="{{ Str::lower($name) }}_third[]" @else name="{{ Str::lower($name) }}_third" @endif
                                                                        id="d_obs_dd{{ $dd->id }}">
                                                                        @if (Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause')
                                                                            <option value=0 disabled selected>None Selected
                                                                            </option>
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div class="root_causes_prefill"></div>
                                            <div class="form-row mt-1" id='corrective_action_increase_OBSERVATION'>
                                                <label for="nc_corrective_action">Corrective Action/s</label>
                                                <div class="input-group">
                                                    <textarea class="form-control mr-2 mb-2" id="nc_OBSERVATION_1"
                                                        name="obs_corrective_action[]" rows="2"></textarea>
                                                    <button type="button" class="btn btn-primary ml-1 mb-2"
                                                        id='corrective_increasetext_OBSERVATION' onclick="addmoreCA()">Add</button>
                                                </div>
                                            </div>
                                            <div class="corrective_actions_prefill"></div>
                                            <div class="form-row mt-1">
                                                <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                    <label for="obs_corrective_action_date">Date Completed</label>
                                                    <input type="text" class="form-control "
                                                        id="obs_corrective_action_complete_date"
                                                        placeholder="Enter date...">
                                                </div>
                                                <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                    <label for="obs_corrective_action_evidence">Upload Evidence</label>
                                                    <input multiple type="file" class="form-control"
                                                        id="obs_corrective_action_evidence">
                                                        <div class="corrective_action_img"></div>
                                                </div>
                                            </div>
                                            <div class="form-row mt-1" id='preventive_action_increase_obs'>
                                                {{-- Dropdown
                                       ================================ --}}
                                                @foreach ($dropdown as $dd)
                                                    @php
                                                        $name = str_replace(' ', '', $dd->dropdown_name);
                                                    @endphp
                                                    @if (Str::lower($name) == 'preventiveactions')
                                                        <div class=" " style="width: 100%;">
                                                            {{-- Dropdown 1 --}}
                                                            <div class="form-group col-12 my-3">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <label class="input-group-text"
                                                                            for="inputGroupSelect01">
                                                                            {{ $dd->dropdown_name }}
                                                                        </label>
                                                                    </div>

                                                                    <select id="obs_{{ Str::lower($name) }}" required
                                                                        @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') multiple @endif
                                                                        class="custom-select drop"
                                                                        myid="obs_dd{{ $dd->id }}"
                                                                        @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') name="{{ Str::lower($name) }}_first[]" @else name="{{ Str::lower($name) }}_first" @endif
                                                                        required>
                                                                        @if (Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause')
                                                                            <option value=0 disabled selected>None Selected
                                                                            </option>
                                                                        @endif
                                                                        @foreach ($dropdownmain as $ddmain)

                                                                            @if ($ddmain->dropdown_id == $dd->id)
                                                                                <option value="{{ $ddmain->id }}">
                                                                                    {{ $ddmain->type_main_name }}
                                                                                </option>
                                                                            @endif

                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            {{-- Dropdown 2 --}}
                                                            <div class="pl-4 form-group col-12 my-3"
                                                                id="display_obs_dd{{ $dd->id }}"
                                                                style="display: none;">
                                                                <div class="pl-3 input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <label class="input-group-text"
                                                                            for="inputGroupSelect01">Options </label>
                                                                    </div>
                                                                    <select
                                                                        @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') multiple @endif
                                                                        class="custom-select droptwo"
                                                                        @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') name="{{ Str::lower($name) }}_second[]" @else name="{{ Str::lower($name) }}_second" @endif
                                                                        myidtwo="d_obs_dd{{ $dd->id }}"
                                                                        id="obs_dd{{ $dd->id }}">
                                                                        @if (Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause')
                                                                            <option value=0 disabled selected>None Selected
                                                                            </option>
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            {{-- Dropdown 3 --}}
                                                            <div class="pl-5 form-group col-12 my-3"
                                                                id="display_d_obs_dd{{ $dd->id }}"
                                                                style="display: none;">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <label class="input-group-text"
                                                                            for="inputGroupSelect01">Options</label>
                                                                    </div>
                                                                    <select
                                                                        @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') multiple @endif
                                                                        class="custom-select"
                                                                        @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') name="{{ Str::lower($name) }}_third[]" @else name="{{ Str::lower($name) }}_third" @endif
                                                                        id="d_obs_dd{{ $dd->id }}">
                                                                        @if (Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause')
                                                                            <option value=0 disabled selected>None Selected
                                                                            </option>
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                                <div class="preventive_actions_prefill"></div>
                                            </div>
                                            <div class="form-row mt-1">
                                                <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                    <label for="obs_preventive_action_date">Date Completed</label>
                                                    <input type="text" class="form-control "
                                                        id="obs_preventive_action_complete_date"
                                                        placeholder="Enter date...">
                                                </div>
                                                <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                    <label for="obs_preventive_action_evidence">Upload Evidence</label>
                                                    <input multiple type="file" class="form-control"
                                                        id="obs_preventive_action_evidence">
                                                        <div class="preventive_evidence"></div>
                                                </div>
                                            </div>
                                            <div class="form-row mt-1">
                                                <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                    <label for="obs_preventive_action_signed">Signed</label>
                                                    <input type="text" class="form-control "
                                                        id="obs_preventive_action_complete_signed" placeholder="Enter sign">
                                                    <input type="file" class="form-control mt-1"
                                                        id="obs_preventive_action_sign_imagebox">
                                                        <div id="obs_preventive_action_sign_imagebox_prefill"></div>
                                                </div>
                                                <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                    <label for="obs_preventive_action_accepted">Accepted</label>
                                                    <input type="text" class="form-control "
                                                        id="obs_preventive_action_complete_accepted"
                                                        placeholder="Enter sign">
                                                    <input type="file" class="form-control mt-1"
                                                        id="obs_preventive_action_accepted_imagebox">
                                                        <div id="obs_preventive_action_accepted_imagebox_prefill"></div>
                                                </div>
                                            </div>
                                            <h3>Follow up & close out</h3>
                                            <div class="form-row mt-1 mb-2">
                                                <label for="obs_comments">Comments</label>
                                                <textarea class="form-control" id="obs_comments" rows="2"></textarea>
                                            </div>
                                            <div class="form-row mt-1 d-flex">
                                                <label for="confirmed_by_dpa_obs ">Confirmed BY DPA</label>
                                                <select
                                                    class="form-control custom col-md-2 col-lg-2 col-sm-2 col-xs-2 ml-1"
                                                    name="" id="confirmed_by_dpa_obs">
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </div>
                                            <div class="form-group mt-1">
                                                <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                    <label for="obs_confirm_date">Date</label>
                                                    <input type="text" class="form-control " id="obs_confirm_date"
                                                        placeholder="Enter date...">
                                                </div>
                                                <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                    <label for="">If verification required at the next Audit</label>
                                                    <input type="checkbox"  id="verification_obs_checkbox" value="yes">
                                                    <input type="text" value="false"  id="verification_obs" hidden>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="modal-footer" style="justify-content: center!important;">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal"
                                            id='obs-increaserow' value='Observation form'>Ok</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- The Modal PSC
                                  ================================================-->
                        <div class="modal fade" id="pscModal">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content p-5">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title" style="text-align: center!important;">PSC FORM</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <div class="form-group">

                                            <input type="hidden" id="editID_PSC" value="null" >

                                            <div class="form-row mt-1">
                                                <label for="psc_description">Description</label>
                                                <textarea class="form-control" id="description_psc" rows="3"></textarea>
                                            </div>
                                            <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                <label for="psc_upload_document">Upload Document</label>
                                                <input multiple type="file" class="form-control" id="upload_document_psc"
                                                    name="upload_document_psc" multiple>
                                            </div>
                                            <div id="upload_document_psc_show"></div>
                                            <div class="form-row mt-1">
                                                <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                    <label for="">Ref</label>
                                                    <select class="form-control custom" name="Ref_psc" id="Ref_psc">
                                                        <option disabled selected hidden>Select Severity...</option>
                                                        @foreach ($ref as $refitem)
                                                            <option value="{{ $refitem->id }}">{{ $refitem->name }}
                                                            </option>
                                                        @endforeach
                                                        <!-- <option value="1">VERY LOW</option> -->
                                                        <!-- <option value="2">LOW</option>
                                                             <option value="3">MODERATE</option>
                                                             <option value="4">HIGH</option>
                                                             <option value="5">VERY HIGH</option> -->
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6 col-lg-6 col-sm-6 col-xs-6g">
                                                    <label for="">Code</label>
                                                    <select class="form-control custom" name="code_psc" id="code_psc">
                                                        <option disabled selected hidden>Code</option>
                                                        @foreach ($code as $item)
                                                            <option value="{{ $item->id }}" id='psc_code'>
                                                                {{ $item->code }}|{{ $item->name }}</option>
                                                        @endforeach
                                                        <!-- <option value="1">VERY LOW</option> -->
                                                        <!-- <option value="2">LOW</option>
                                                             <option value="3">MODERATE</option>
                                                             <option value="4">HIGH</option>
                                                             <option value="5">VERY HIGH</option> -->
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row mt-1">
                                                {{-- Dropdown
                                                ================================ --}}
                                                @foreach ($dropdown as $dd)
                                                    @php
                                                        $name = str_replace(' ', '', $dd->dropdown_name);
                                                    @endphp
                                                    @if (Str::lower($name) == 'rootcauses')
                                                        <div class=" " style="width: 100%;">
                                                            {{-- Dropdown 1 --}}
                                                            <div class="form-group col-12 my-3">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <label class="input-group-text"
                                                                            for="inputGroupSelect01">
                                                                            {{ $dd->dropdown_name }}
                                                                        </label>
                                                                    </div>

                                                                    <select id="psc_{{ Str::lower($name) }}" required
                                                                        @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') multiple @endif
                                                                        class="custom-select drop"
                                                                        myid="psc_dd{{ $dd->id }}"
                                                                        @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') name="{{ Str::lower($name) }}_first[]" @else name="{{ Str::lower($name) }}_first" @endif
                                                                        required>
                                                                        @if (Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause')
                                                                            <option value=0 disabled selected>None Selected
                                                                            </option>
                                                                        @endif
                                                                        @foreach ($dropdownmain as $ddmain)

                                                                            @if ($ddmain->dropdown_id == $dd->id)
                                                                                <option value="{{ $ddmain->id }}">
                                                                                    {{ $ddmain->type_main_name }}
                                                                                </option>
                                                                            @endif

                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            {{-- Dropdown 2 --}}
                                                            <div class="pl-4 form-group col-12 my-3"
                                                                id="display_psc_dd{{ $dd->id }}"
                                                                style="display: none;">
                                                                <div class="pl-3 input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <label class="input-group-text"
                                                                            for="inputGroupSelect01">Options </label>
                                                                    </div>
                                                                    <select
                                                                        @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') multiple @endif
                                                                        class="custom-select droptwo"
                                                                        @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') name="{{ Str::lower($name) }}_second[]" @else name="{{ Str::lower($name) }}_second" @endif
                                                                        myidtwo="d_psc_dd{{ $dd->id }}"
                                                                        id="psc_dd{{ $dd->id }}">
                                                                        @if (Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause')
                                                                            <option value=0 disabled selected>None Selected
                                                                            </option>
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            {{-- Dropdown 3 --}}
                                                            <div class="pl-5 form-group col-12 my-3"
                                                                id="display_d_psc_dd{{ $dd->id }}"
                                                                style="display: none;">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <label class="input-group-text"
                                                                            for="inputGroupSelect01">Options</label>
                                                                    </div>
                                                                    <select
                                                                        @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') multiple @endif
                                                                        class="custom-select"
                                                                        @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') name="{{ Str::lower($name) }}_third[]" @else name="{{ Str::lower($name) }}_third" @endif
                                                                        id="d_psc_dd{{ $dd->id }}">
                                                                        @if (Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause')
                                                                            <option value=0 disabled selected>None Selected
                                                                            </option>
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                                <div class="root_causes_prefill"></div>
                                            </div>
                                            <div class="form-row mt-1" id="corrective_action_increase_PSC">
                                                <label for="nc_corrective_action">Corrective Action/s</label>
                                                <div class="input-group">
                                                    <textarea class="form-control mr-2 mb-2" id="nc_OBSERVATION_1"
                                                        name="psc_corrective_action[]" rows="2"></textarea>
                                                    <button type="button" class="btn btn-primary ml-1 mb-2"
                                                        id='corrective_increasetext_PSC' onclick="addmoreCA()">Add</button>
                                                </div>
                                            </div>
                                            <div class="corrective_actions_prefill"></div>
                                            <div class="form-row mt-1">
                                                <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                    <label for="corrective_action_complete_date_psc">Date</label>
                                                    <input type="text" class="form-control "
                                                        name="corrective_action_complete_date_psc"
                                                        id="corrective_action_complete_date_psc"
                                                        placeholder="Enter date...">
                                                </div>
                                                <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                    <label for="corrective_action_evidence_psc">Upload Evidence</label>
                                                    <input multiple type="file" class="form-control"
                                                        id="corrective_action_evidence_psc"
                                                        name="corrective_action_evidence_psc">
                                                        <div class="corrective_action_img"></div>
                                                </div>
                                            </div>
                                            {{-- Preventive Action Dropdown --}}
                                            <div class="form-row mt-1">
                                                {{-- Dropdown
                                                ================================ --}}
                                                @foreach ($dropdown as $dd)
                                                @php
                                                $name = str_replace(' ', '', $dd->dropdown_name)
                                                @endphp
                                                @if (Str::lower($name) == 'preventiveactions')
                                                <div class=" " style="width: 100%;">
                                                   {{-- Dropdown 1 --}}
                                                   <div class="form-group col-12 my-3">
                                                      <div class="input-group mb-3">
                                                         <div class="input-group-prepend">
                                                            <label class="input-group-text" for="inputGroupSelect01"> {{ $dd->dropdown_name }}   </label>
                                                         </div>
                                                         <select
                                                            id="psc_{{ Str::lower($name) }}"
                                                            required
                                                            class="custom-select drop"
                                                            myid="psc_dd{{ $dd->id }}"
                                                            required multiple>
                                                            @if (Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause')
                                                            <option value=0 disabled selected>None Selected</option>
                                                            @endif
                                                            @foreach ($dropdownmain as $ddmain) @if ($ddmain->dropdown_id == $dd->id)
                                                            <option value="{{ $ddmain->id }}">
                                                               {{ $ddmain->type_main_name }}
                                                            </option>
                                                            @endif
                                                            @endforeach
                                                         </select>
                                                      </div>
                                                   </div>
                                                   {{-- Dropdown 2 --}}
                                                   <div class="pl-4 form-group col-12 my-3" id="display_psc_dd{{ $dd->id }}"
                                                      style="display: none;">
                                                      <div class="pl-3 input-group mb-3">
                                                         <div class="input-group-prepend">
                                                            <label class="input-group-text" for="inputGroupSelect01">Options
                                                            </label>
                                                         </div>
                                                         <select @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') multiple @endif
                                                         class="custom-select droptwo"
                                                         @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') name="{{ Str::lower($name) }}_second[]" @else name="{{ Str::lower($name) }}_second" @endif
                                                         myidtwo="d_psc_dd{{ $dd->id }}" id="psc_dd{{ $dd->id }}">
                                                         @if (Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause')
                                                         <option value=0 disabled selected>None Selected</option>
                                                         @endif
                                                         </select>
                                                      </div>
                                                   </div>
                                                   {{-- Dropdown 3 --}}
                                                   <div class="pl-5 form-group col-12 my-3" id="display_d_psc_dd{{ $dd->id }}"
                                                      style="display: none;">
                                                      <div class="input-group mb-3">
                                                         <div class="input-group-prepend">
                                                            <label class="input-group-text"
                                                               for="inputGroupSelect01">Options</label>
                                                         </div>
                                                         <select @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') multiple @endif
                                                         class="custom-select"
                                                         @if (Str::lower($name) == 'rootcauses' || Str::lower($name) == 'preventiveactions') name="{{ Str::lower($name) }}_third[]" @else name="{{ Str::lower($name) }}_third" @endif
                                                         id="d_psc_dd{{ $dd->id }}">
                                                         @if (Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause')
                                                         <option value=0 disabled selected>None Selected</option>
                                                         @endif
                                                         </select>
                                                      </div>
                                                   </div>
                                                </div>
                                                @endif
                                                @endforeach
                                                <div class="preventive_actions_prefill"></div>
                                             </div>


                                <div class="form-row mt-1">
                                    <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                        <label for="preventive_action_complete_date_psc">Date</label>
                                        <input type="text" class="form-control "
                                            name="preventive_action_complete_date_psc"
                                            id="preventive_action_complete_date_psc" placeholder="Enter date...">
                                    </div>
                                    <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                        <label for="preventive_action_evidence_psc">Upload Evidence</label>
                                        <input multiple type="file" class="form-control"
                                            name="preventive_action_evidence_psc" id="preventive_action_evidence_psc">
                                            <div class="preventive_evidence"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer" style="justify-content: center!important;">
                            <button type="button" class="btn btn-primary" data-dismiss="modal" id='psc-increaserow'
                                value='PSC'>Ok</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                </div>
            </div>
        </div>
        </form>
    </div>


    <!--==============
    Html End -->

    <!-- WANT TO CONTINUE ?
    ============================== -->
    <!-- Button trigger modal -->
    <button hidden type="button" class="btn btn-primary" data-toggle="modal" data-target="#CONTINUE_MODAL"
        id="modal_lunch">
        Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="CONTINUE_MODAL" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <H4 class='font-weight-bold'>Want to continue with the previous draft?</H4>
                    <div class='text-center p-3'>
                        <button type="button" class="btn btn-success shadow mx-3 my-3" data-dismiss="modal">Yes, Continue
                            With Draft </button>
                        <a href="/inspection-audit/Draft" class="btn btn-primary shadow mx-3 my-3">No, Create a New
                            Form</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- WANT TO CONTINUE ? ENDS
    ============================== -->

    </div>
    </div>
    </div>
@endsection


@section('footer_scripts')


    <script>
        $(()=>{

            // change value of non-confirmity is-verification required on change
            $("#nc_verification_checkbox").change(function(){
                // checking non-confirmity checkbox is-checked .....
                if($("#nc_verification_checkbox").prop("checked") == true){
                    $("#nc_verification").val(true);
                }else{
                    $("#nc_verification").val(false);
                }
            })

            // change value of Observation is-verification required on change
            $("#verification_obs_checkbox").change(function(){
                // checking Observation checkbox is-checked .....
                if($("#verification_obs_checkbox").prop("checked") == true){
                    $("#verification_obs").val(true);
                }else{
                    $("#verification_obs").val(false);
                }
            })

        })
    </script>


    <script>
        var master_id = `{{ $id }}`
        var session_email = `{{session('email')}}`
    </script>
    <!-- Auto Save code
    =========================== -->
    <script src="{{ asset('js/custom/audit/AutoSave.js') }}"></script>
    {{-- custom js file --}}
    <script type="text/javascript" src="\js\custom\audit\audit_create.js"></script>
    <script type="text/javascript" src="\js\custom\audit\audit_create_change_handlers.js"></script>
    <script type="text/babel" src="{{ asset('js/custom/audit/inspection_audit.js') }}"></script>
    <!-- dropdowns code
    ====================== -->
    <script type="text/babel" src="{{ asset('js/custom/audit/IIRP_dropdown.min.js') }}"></script>

    <script>
        var data = {!! json_encode($data) !!};
        var date_format = {!! json_encode(config('constants.DATE_FORMAT')) !!};
    </script>

    <!-- Load Babel -->
    <script src="{{ asset('js/babel/babel.js') }}"></script>



    {{-- jquery
    =====================
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --> --}}
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/roundSlider/1.3.2/roundslider.js"></script>

    {{-- ClockPicker
    ============================ --}}
    <script src="{{ asset('js/ClockPicker/bootstrap-clockpicker.min.js') }}"></script>

    {{-- multi-select
    ============================= --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap_multi_select/bootstrap-multiselect.css') }}">
    <script src="{{ asset('js/bootstrap_multi_select/bootstrap-multiselect.js') }}"></script>

    <!-- CONTINUE MODAL SHOWING CODE
    ======================================= -->
    <script>
        $(() => {
            @if (Session::has('New_Draft'))
                // console.log('New Draft Created')
            @else
                $('#modal_lunch').click()
            @endif
        })
    </script>
@endsection

