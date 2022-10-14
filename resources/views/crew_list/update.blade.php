@extends('layouts.app')

@section('template_title')
    Crew List
@endsection

@section('template_linked_css')
    {{-- Bootstrap
    ======================== --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">


    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">


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
<div class="container p-5">
    <div class="card p-md-5 shadow mx-md-5  mt-5">
        <h2 class="font-weight-light text-center">Add Crew</h2>



        <!-- Html
        ================== -->
        {{-- div for centering the form --}}
            <div class="mx-md-5 " style="">
                <form class="p-md-3 mx-md-5" method="PUT" action="{{ url('crew_list/update/'.$data->id) }}" id="crew_list">
                    @csrf

                    {{--  Name
                    ========================  --}}
                    <div class="tab form-group">
                        <label for="Name">Name <span class="h3 text-danger">*</span> </label>
                        <input value="{{$data->name}}" type="text"   class="form-control" id="Name" name="Name" placeholder="Name..." autocomplete="off">
                    </div>

                    {{--  Rank
                    ========================  --}}
                    <div class="tab form-group">
                        <label for="Rank">Rank <span class="h3 text-danger">*</span> </label>
                        <select class="form-control" name="Rank" id="Rank">
                            @foreach ( $dropdown as $d )
                                <option {{ ($d->name == $data->rank )?'selected':'' }} value="{{$d->name}}"> {{$d->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    {{--  Nationality
                    ========================  --}}
                    <div class="tab form-group">
                        <label for="Nationality">Nationality</label>
                        <input value="{{$data->nationality}}" type="text"   class="form-control" id="Nationality" name="Nationality" placeholder="Nationality..." autocomplete="off">
                    </div>

                    {{--  Sex
                    ========================  --}}
                    <div class="tab form-group">
                        <label for="Sex">Sex</label>
                        <select name="Sex" id="Sex" class="form-control">
                            <option {{ ($data->sex == 'M')?'selected':'' }} value="M">M</option>
                            <option {{ ($data->sex == 'F')?'selected':'' }} value="F">F</option>
                            <option {{ ($data->sex == 'Other')?'selected':'' }} value="Other">Other</option>
                        </select>
                    </div>

                    {{--  Date and Place Of Birth
                    ==========================================  --}}
                    <div class="tab form-row w-100">
                        <h5>Date and Place Of Birth</h5>
                        {{-- Date Of Borth --}}
                        <div class="col-6 mb-3">
                            <label for="Date_of_birth">Date</label>
                            <input value="{{$data->dob}}" type="text" class="form-control" id="Date_of_birth" name="Date_of_birth" placeholder="Date..." autocomplete="off">
                        </div>
                        {{-- Place Of Borth --}}
                        <div class="col-6 mb-3">
                            <label for="Place_of_birth">Place</label>
                            <input value="{{$data->pob}}" type="text" class="form-control" id="Place_of_birth" name="Place_of_birth" placeholder="Place..." autocomplete="off">
                        </div>
                    </div>

                    {{--  Seaman Passport PP No. / EXPIRY
                    ==========================================  --}}
                    <div class="tab form-row w-100">
                        <h5>Seaman Passport PP No. / EXPIRY</h5>
                        {{-- PP No. --}}
                        <div class="col-6 mb-3">
                            <label for="Seaman_Passport_PP_No">PP No.</label>
                            <input value="{{$data->seaman_passpoert_pp_no}}" type="text" class="form-control" id="Seaman_Passport_PP_No" name="Seaman_Passport_PP_No" placeholder="PP No...." autocomplete="off">
                        </div>
                        {{-- EXPIRY --}}
                        <div class="col-6 mb-3">
                            <label for="Seaman_Passport_EXPIRY">EXPIRY</label>
                            <input value="{{$data->seaman_passpoert_exp}}" type="text" class="form-control" id="Seaman_Passport_EXPIRY" name="Seaman_Passport_EXPIRY" placeholder="EXPIRY..." autocomplete="off">
                        </div>
                    </div>

                    {{--  Seaman Book CDC No. / EXPIRY
                    ==========================================  --}}
                    <div class="tab form-row w-100">
                        <h5>Seaman Book CDC No. / EXPIRY</h5>
                        {{-- CDC No. --}}
                        <div class="col-6 mb-3">
                            <label for="Seaman_Book_CDC_No">CDC No.</label>
                            <input value="{{$data->seaman_book_cdc_no}}" type="text" class="form-control" id="Seaman_Book_CDC_No" name="Seaman_Book_CDC_No" placeholder="CDC No...." autocomplete="off">
                        </div>
                        {{-- EXPIRY --}}
                        <div class="col-6 mb-3">
                            <label for="Seaman_Book_EXPIRY">EXPIRY</label>
                            <input value="{{$data->seaman_book_exp}}" type="text" class="form-control" id="Seaman_Book_EXPIRY" name="Seaman_Book_EXPIRY" placeholder="EXPIRY..." autocomplete="off">
                        </div>
                    </div>

                    {{--  Date And Port Of Embarkation
                    ===========================================  --}}
                    <div class="tab form-row w-100">
                        <h5>Date And Port Of Embarkation</h5>
                        {{-- Date Of Embarkation --}}
                        <div class="col-6 mb-3">
                            <label for="Date_Of_Embarkation">Date</label>
                            <input value="{{$data->date_and_port_of_embarkation_date}}" type="text" class="form-control" id="Date_Of_Embarkation" name="Date_Of_Embarkation" placeholder="Date Of Embarkation..." autocomplete="off">
                        </div>
                        {{-- Port Of Embarkation --}}
                        <div class="col-6 mb-3">
                            <label for="Port_Of_Embarkation">Port</label>
                            <input value="{{$data->date_and_port_of_embarkation_port}}" type="text" class="form-control" id="Port_Of_Embarkation" name="Port_Of_Embarkation" placeholder="Port Of Embarkation..." autocomplete="off">
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

{{-- date-picker script for date field
    ===============================--}}
    <script>
        $( function() {
            $( "#Date_of_birth" ).datepicker();
            $( "#Seaman_Passport_EXPIRY" ).datepicker();
            $( "#Seaman_Book_EXPIRY" ).datepicker();
            $( "#Date_Of_Embarkation" ).datepicker();

            $("#Date_of_birth").change(function(){
                let dateinput = $(this).val();
                let date = moment(dateinput).format('DD-MMM-YYYY');
                $(this).val(date)  ;
            })
            $("#Seaman_Passport_EXPIRY").change(function(){
                let dateinput = $(this).val();
                let date = moment(dateinput).format('DD-MMM-YYYY');
                $(this).val(date)  ;
            })
            $("#Seaman_Book_EXPIRY").change(function(){
                let dateinput = $(this).val();
                let date = moment(dateinput).format('DD-MMM-YYYY');
                $(this).val(date)  ;
            })
            $("#Date_Of_Embarkation").change(function(){
                let dateinput = $(this).val();
                let date = moment(dateinput).format('DD-MMM-YYYY');
                $(this).val(date)  ;
            })
        } );


    </script>

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
            if (n == 1 && !validateForm() || !validateFormSelect() ) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form... :



                if (currentTab >= x.length) {
                    //...the form gets submitted:
                    document.getElementById("crew_list").submit();
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
                // If Name and Rank field is empty...
                if (y[i].value == "") {
                    if(y[i].getAttribute('id') == "Name"){

                        // add an "invalid" class to the field:
                        y[i].className += " invalid";
                        // and set the current valid status to false:
                        valid = false;
                    }
                    if(y[i].getAttribute('id') == "Rank"){

                        // add an "invalid" class to the field:
                        y[i].className += " invalid";
                        // and set the current valid status to false:
                        valid = false;
                    }
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
                           console.log(y[0].getAttribute('id'))
                            if(y[0].getAttribute('id') == "Rank")
                            {
                                // add an "invalid" class to the field:
                                y[0].className += " invalid";
                                // and set the current valid status to false:
                                valid = false;
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
