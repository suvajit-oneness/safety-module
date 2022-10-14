@extends('layouts.app')

@section('template_title')
    Vessel Report
@endsection

@section('template_linked_css')
  <link rel="stylesheet" href="/css/dataTables/dataTables.bootstrap.min.css">

  <!-- Multi-step Style
    =================== -->
    <style>

        /* multi-select css edit */
        .multiselect-container
        {
            height: 200px !important;
            overflow-y:scroll !important;
        }



        /* Style the form */




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
            height: 0px;
            width: 0px;
            margin: 0 0px;
            background-color: transparent;
            border: none;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
        }

        /* Mark the active step: */
        .step.active {
            opacity: 1;
        }

        /* Mark the steps that are finished and valid: */
        .step.finish {
            background-color: #04AA6D;
        }
    </style>
<!-- =================
Multi-step Style End -->

@endsection

@section('content')
@if(session('is_ship'))
<div class="container">
    <div class="card shadow p-3 py-5" style="width:60vw;position: absolute; top:50%; left:50%; transform:translate(-50%,-50%)">
        <h2 class="my-3 font-weight-light text-center">Update Vessel Details</h2>
        <!-- Html
        ================== -->
        {{-- div for centering the form --}}
            <div class="mx-md-5 " style="">
                <form class="p-md-3 mx-md-5" method="post" action="{{ url('/vessel_details/update/'.$data->id) }}" id="vessel_details_form">
                    @csrf


                    {{--  Name
                    ========================  --}}
                    <div class="tab form-group">
                        <label for="Name">Name</label>
                        <input value="{{$data->name}}" type="text"   class="form-control" id="Name" name="Name" placeholder="Name..." autocomplete="off">
                    </div>

                    {{-- vessel_code
                    ================================= --}}
                    <div class="tab form-group">
                        <label for="">Vessel Code</label>
                        <select name="vessel_code" id="vessel_code" class="form-control">
                            {{-- <option value="{{$v->code}}"   selected > {{$v->code}} </option> --}}
                            @foreach ( $ves as $v )
                                <option value="{{$v->code}}"  {{ ($v->code == $data->vessel_code)?'selected':' '}} > {{$v->code}} </option>
                            @endforeach

                        </select>
                    </div>

                    {{--  Class Society
                    ========================  --}}
                    <div class="tab form-group">
                        <label for="Class_Society">Class Society</label>
                        <input value="{{$data->class_society}}" type="text"   class="form-control" id="Class_Society" name="Class_Society" placeholder="Class Society..." autocomplete="off">
                    </div>

                    {{--  IMO No
                    ========================  --}}
                    <div class="tab form-group">
                        <label for="IMO_No">IMO No</label>
                        <input value="{{$data->imo_no}}" type="text" class="form-control" id="IMO_No" name="IMO_No" placeholder="IMO No..." autocomplete="off">
                    </div>

                    {{--  Year Built
                    ========================  --}}
                    <div class="tab form-group">
                        <label for="Year_Built">Year Built</label>
                        <input value="{{$data->year_built}}" type="text" class="form-control" id="Year_Built" name="Year_Built" placeholder="Year Built..." autocomplete="off">
                    </div>

                    {{--  Type
                    ========================  --}}
                    <div class="tab form-group">
                        <label for="Type">Type</label>
                        <input value="{{$data->type}}" type="text" class="form-control" id="Type" name="Type" placeholder="Type..." autocomplete="off">
                    </div>

                    {{--  Owner
                    ========================  --}}
                    <div class="tab form-group">
                        <label for="Owner">Owner</label>
                        <input value="{{$data->owner}}" type="text" class="form-control" id="Owner" name="Owner" placeholder="Owner..." autocomplete="off">
                    </div>

                    {{--  Hull No and GRT
                    ========================  --}}
                    <div class="tab form-row w-100">
                        {{-- Hull No --}}
                        <div class="col-6 mb-3">
                            <label for="Hull_No">Hull No</label>
                            <input value="{{$data->hull_no}}" type="text" class="form-control" id="Hull_No" name="Hull_No" placeholder="Hull No..." autocomplete="off">
                        </div>
                        {{-- GRT --}}
                        <div class="col-6 mb-3">
                            <label for="GRT">GRT</label>
                            <input value="{{$data->grt}}" type="text" class="form-control" id="GRT" name="GRT" placeholder="GRT..." autocomplete="off">
                        </div>
                    </div>

                    {{--  Call Sign  And  Flag
                    ========================  --}}
                    <div class="tab form-row w-100">
                        {{-- Call Sign --}}
                        <div class="col-6 mb-3">
                            <label for="Call_Sign">Call Sign</label>
                            <input value="{{$data->call_sign}}" type="text" class="form-control" id="Call_Sign" name="Call_Sign" placeholder="Call Sign..." autocomplete="off">
                        </div>
                        {{-- Flag --}}
                        <div class="col-6 mb-3">
                            <label for="Flag">Flag</label>
                            <input value="{{$data->flag}}" type="text" class="form-control" id="Flag" name="Flag" placeholder="Flag..." autocomplete="off">
                        </div>
                    </div>

                    {{--  NRT And  Length (m)
                    ========================  --}}
                    <div class="tab form-row w-100">
                        {{-- NRT --}}
                        <div class="col-6 mb-3">
                            <label for="NRT">NRT</label>
                            <input value="{{$data->nrt}}" type="text" class="form-control" id="NRT" name="NRT" placeholder="NRT..." autocomplete="off">
                        </div>
                        {{-- Length (m) --}}
                        <div class="col-6 mb-3">
                            <label for="Length">Length (m)</label>
                            <input value="{{$data->length}}" type="text" class="form-control" id="Length" name="Length" placeholder="Length(m)..." autocomplete="off">
                        </div>
                    </div>


                    {{--  Port of Registry
                    ===============================  --}}
                    <div class="tab form-group">
                        <label for="Port_of_Registry">Port of Registry</label>
                        <input value="{{$data->port_of_registry}}" type="text" class="form-control" id="Port_of_Registry" name="Port_of_Registry" placeholder="Port of Registry..." autocomplete="off">
                    </div>

                    {{--  Breadth(m) And Moulded Depth(m)
                    =============================================  --}}
                    <div class="tab form-row w-100">
                        {{-- Breadth(m) --}}
                        <div class="col-6 mb-3">
                            <label for="Breadth">Breadth(m)</label>
                            <input value="{{$data->breadth}}" type="number" class="form-control" id="Breadth" name="Breadth" placeholder="Breadth..." autocomplete="off">
                        </div>
                        {{-- Moulded Depth(m) --}}
                        <div class="col-6 mb-3">
                            <label for="Moulded_Depth">Moulded Depth(m)</label>
                            <input value="{{$data->moulded_depth}}" type="number" class="form-control" id="Moulded_Depth" name="Moulded_Depth" placeholder="Moulded Depth..." autocomplete="off">
                        </div>
                    </div>



                    {{-- Buttons(next/prev) --}}
                    <div class="mr-auto ml-auto" style="overflow:auto;">
                        <div class="d-flex">
                            <button class="btn btn-primary mt-3 mr-auto" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                            <button class="btn btn-primary mt-3 ml-auto" type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                        </div>
                    </div>

                    <!-- Circles which indicates the steps of the form: -->
                    {{-- these portion are not require to visible but if input fields are increased then have to increse the span  --}}

                    <div style="text-align:center;margin-top:40px; display: none;">
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
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>
                    </div>

                </form>
            </div>
        <!--==============
        Html End -->
    </div>
</div>
@else
<div class="container">
    <div class="card shadow p-3 py-5" style="width:60vw;position: absolute; top:50%; left:50%; transform:translate(-50%,-50%)">
        <h2 class="my-3 font-weight-light text-center">Update Vessel Details</h2>
        <!-- Html
        ================== -->
        {{-- div for centering the form --}}
            <div class="mx-md-5 " style="">
                <form class="p-md-3 mx-md-5" method="post" action="{{ url('/vessel_details/update/'.$vessel->unique_id) }}" id="vessel_details_form">
                    @csrf


                    {{--  Name
                    ========================  --}}
                    <div class="tab form-group">
                        <label for="Name">Name</label>
                        <input value="{{$vessel->name}}" type="text"   class="form-control" id="Name" name="Name" placeholder="Name..." autocomplete="off">
                    </div>

                      {{--  Company ID
                    ========================  --}}
                    <div class="tab form-group">
                        <label for="company_id">Company ID</label>
                        <select name="company_id" id="company_id" class="form-control">
                            @foreach ( $companies as $company )
                                @if ($vessel->company_id == $company->id)
                                    <option value="{{$company->id}}" hidden selected > {{ $company->name }} </option>
                                @endif
                                <option value="{{$company->id}}"> {{ $company->name }} </option>
                            @endforeach
                        </select>
                    </div>

                    {{--  Type
                    ========================  --}}
                    <div class="tab form-group">
                        <label for="Type">Type</label>
                        <select name="Type" id="Type" class="form-control">
                                <option value="Bulk" {{($vessel->type == 'Bulk')?'selected':''}} > Bulk </option>
                                <option value="Tanker" {{($vessel->type == 'Tanker')?'selected':''}}> Tanker </option>
                        </select>
                    </div>

                    {{-- vessel_code
                    ================================= --}}
                    <div class="tab form-group">
                        <label for="">Vessel Code</label>
                        <input type="text" value='{{$vessel_details->vessel_code}}'  class="form-control" id="vessel_code" name="vessel_code" placeholder="Name..." autocomplete="off">
                    </div>


                    {{--  Class Society
                    ========================  --}}
                    <div class="tab form-group">
                        <label for="Class_Society">Class Society</label>
                        <input value="{{$vessel_details->class_society}}" type="text"   class="form-control" id="Class_Society" name="Class_Society" placeholder="Class Society..." autocomplete="off">
                    </div>

                    {{--  IMO No
                    ========================  --}}
                    <div class="tab form-group">
                        <label for="IMO_No">IMO No</label>
                        <input value="{{$vessel_details->imo_no}}" type="text" class="form-control" id="IMO_No" name="IMO_No" placeholder="IMO No..." autocomplete="off">
                    </div>

                    {{--  Year Built
                    ========================  --}}
                    <div class="tab form-group">
                        <label for="Year_Built">Year Built</label>
                        <input value="{{$vessel_details->year_built}}" type="text" class="form-control" id="Year_Built" name="Year_Built" placeholder="Year Built..." autocomplete="off">
                    </div>


                    {{--  Owner
                    ========================  --}}
                    <div class="tab form-group">
                        <label for="Owner">Owner</label>
                        <input value="{{$vessel_details->owner}}" type="text" class="form-control" id="Owner" name="Owner" placeholder="Owner..." autocomplete="off">
                    </div>

                    {{--  Hull No and GRT
                    ========================  --}}
                    <div class="tab form-row w-100">
                        {{-- Hull No --}}
                        <div class="col-6 mb-3">
                            <label for="Hull_No">Hull No</label>
                            <input value="{{$vessel_details->hull_no}}" type="text" class="form-control" id="Hull_No" name="Hull_No" placeholder="Hull No..." autocomplete="off">
                        </div>
                        {{-- GRT --}}
                        <div class="col-6 mb-3">
                            <label for="GRT">GRT</label>
                            <input value="{{$vessel_details->grt}}" type="text" class="form-control" id="GRT" name="GRT" placeholder="GRT..." autocomplete="off">
                        </div>
                    </div>

                    {{--  Call Sign  And  Flag
                    ========================  --}}
                    <div class="tab form-row w-100">
                        {{-- Call Sign --}}
                        <div class="col-6 mb-3">
                            <label for="Call_Sign">Call Sign</label>
                            <input value="{{$vessel_details->call_sign}}" type="text" class="form-control" id="Call_Sign" name="Call_Sign" placeholder="Call Sign..." autocomplete="off">
                        </div>
                        {{-- Flag --}}
                        <div class="col-6 mb-3">
                            <label for="Flag">Flag</label>
                            <input value="{{$vessel_details->flag}}" type="text" class="form-control" id="Flag" name="Flag" placeholder="Flag..." autocomplete="off">
                        </div>
                    </div>

                    {{--  NRT And  Length (m)
                    ========================  --}}
                    <div class="tab form-row w-100">
                        {{-- NRT --}}
                        <div class="col-6 mb-3">
                            <label for="NRT">NRT</label>
                            <input value="{{$vessel_details->nrt}}" type="text" class="form-control" id="NRT" name="NRT" placeholder="NRT..." autocomplete="off">
                        </div>
                        {{-- Length (m) --}}
                        <div class="col-6 mb-3">
                            <label for="Length">Length (m)</label>
                            <input value="{{$vessel_details->length}}" type="text" class="form-control" id="Length" name="Length" placeholder="Length(m)..." autocomplete="off">
                        </div>
                    </div>


                    {{--  Port of Registry
                    ===============================  --}}
                    <div class="tab form-group">
                        <label for="Port_of_Registry">Port of Registry</label>
                        <input value="{{$vessel_details->port_of_registry}}" type="text" class="form-control" id="Port_of_Registry" name="Port_of_Registry" placeholder="Port of Registry..." autocomplete="off">
                    </div>

                    {{--  Breadth(m) And Moulded Depth(m)
                    =============================================  --}}
                    <div class="tab form-row w-100">
                        {{-- Breadth(m) --}}
                        <div class="col-6 mb-3">
                            <label for="Breadth">Breadth(m)</label>
                            <input value="{{$vessel_details->breadth}}" type="number" class="form-control" id="Breadth" name="Breadth" placeholder="Breadth..." autocomplete="off">
                        </div>
                        {{-- Moulded Depth(m) --}}
                        <div class="col-6 mb-3">
                            <label for="Moulded_Depth">Moulded Depth(m)</label>
                            <input value="{{$vessel_details->moulded_depth}}" type="number" class="form-control" id="Moulded_Depth" name="Moulded_Depth" placeholder="Moulded Depth..." autocomplete="off">
                        </div>
                    </div>

                    {{--  Fleets
                    ========================  --}}
                    <div class="tab form-group">
                        <label for="fleet">Fleet</label>
                        <select name="fleet" id="fleet" class="form-control">
                            <option value="" disabled hidden selected > Select Fleet ... </option>
                            @foreach ( $fleets as $f )
                                <option value="{{$f->id}}" {{($f->id == $vessel->fleet_id)?'selected':''}}> {{ $f->name }} </option>
                            @endforeach
                        </select>
                    </div>



                    {{-- Buttons(next/prev) --}}
                    <div class="mr-auto ml-auto" style="overflow:auto;">
                        <div class="d-flex">
                            <button class="btn btn-primary mt-3 mr-auto" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                            <button class="btn btn-primary mt-3 ml-auto" type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                        </div>
                    </div>

                    <!-- Circles which indicates the steps of the form: -->
                    {{-- these portion are not require to visible but if input fields are increased then have to increse the span  --}}

                    <div style="text-align:center;margin-top:40px; display: none;">
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
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>
                    </div>

                </form>
            </div>
        <!--==============
        Html End -->
    </div>
</div>
@endif
@endsection


@section('footer_scripts')

    <!-- Multi-step form Script
    ================================ -->
        <script>
            var currentTab = 0; // Current tab is set to be the first tab (0)
            showTab(currentTab); // Display the current tab


            // fire next on presing enter
            $(document).on("keypress", function (e) {
                //all the action
                var key = e.which;
                if(key == 13)
                {
                    nextPrev(1)
                }
            });

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



                    if (currentTab >= x.length) {
                        //...the form gets submitted:
                        document.getElementById("vessel_details_form").submit();
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
                    if (y[i].value == "") {
                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // and set the current valid status to false:
                    valid = false;
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
                    valid = false;
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
                    console.log(y[0])
                    // A loop that checks every input field in the current tab:

                        // If a field is empty...
                        if (y[0].value == 0) {
                            // add an "invalid" class to the field:
                            y[0].className += " invalid";
                            // and set the current valid status to false:
                            valid = false;
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

@endsection
