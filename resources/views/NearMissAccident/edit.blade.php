@extends('layouts.app')


@section('template_linked_css')

    {{-- Bootstrap
    ======================== --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous"> --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

    <!-- Multi-step Style
    =================== -->
        <style>

            /* multi-select css edit */
            .multiselect-container
            {
                width:100% !important;
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
    <div class="container">
        <div class="row">
        <div class="col-12">
            <a href="/Near_Miss">
            <button type="button" class="btn btn-dark"><i class="fa fa-long-arrow-left" aria-hidden="true" style="color:white;"></i></button>
            </a>
        </div>
        </div>
    </div>
    {{-- div for centering the form --}}
    <div class="card shadow" style="width:51rem; position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);">

        <form class="p-5"  action="" method="POST"  id="near_miss_form">
            @csrf
            @method('PUT')
            <h1 class="text-center pb-5">Near Miss Report Edit</h1>

            {{--  Date
            ========================  --}}
            <div class="tab form-group">
                <label for="inputAddress">Date</label>
                <input type="text"   class="form-control" id="date" name="date" value={{ $data->date }}>
            </div>

            {{--  Describtion
            ========================  --}}
            <div class="tab form-group">
                <label for="inputAddress"> Description </label>
                <textarea   class="form-control" id="desc" name="desc" placeholder="Description....."> {{ $data->describtion }} </textarea>
            </div>


            {{-- Dropdowns
            ================================ --}}
            @foreach ($dropdown as $dd)
                @php
                    $name = str_replace(' ', '', $dd->dropdown_name)
                @endphp
                <div class="tab form-row">
                    {{-- Dropdown 1 --}}
                    <div class="form-group col-12" >
                        <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01"> {{$dd->dropdown_name}} </label>
                        </div>

                        <select @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" ) multiple @endif class="custom-select drop" myid="dd{{ $dd->id }}" @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" )  name="{{Str::lower($name)}}_first[]" @else name="{{Str::lower($name)}}_first"  @endif    id="{{ Str::lower($name) }}"  required >

                            @foreach ($dropdownmain as $ddmain)

                                @if ($ddmain->dropdown_id == $dd->id)
                                    <option value="{{ $ddmain->id }}" id="dropdowns_blank">{{ $ddmain->type_main_name }}</option>
                                @endif

                            @endforeach
                        </select>
                        </div>
                    </div>
                    {{-- Dropdown 2 --}}
                    <div class="form-group col-12" myname="{{ Str::lower($name) }}" id="display_dd{{ $dd->id }}" style="display: none;">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Options</label>
                            </div>
                            <select @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" ) multiple @endif class="custom-select droptwo"   @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" )  name="{{Str::lower($name)}}_second[]" @else name="{{Str::lower($name)}}_second"  @endif myidtwo="ddd{{ $dd->id }}" id="dd{{ $dd->id }}">
                                <option selected disabled hidden> -- Select --</option>
                            </select>
                        </div>
                    </div>
                    {{-- Dropdown 3 --}}
                    <div class="form-group col-12" myname="{{ Str::lower($name) }}" id="display_ddd{{ $dd->id }}" style="display: none;">
                        <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Options</label>
                        </div>
                        <select @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" ) multiple @endif class="custom-select"  @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" )  name="{{Str::lower($name)}}_third[]" @else name="{{Str::lower($name)}}_third"  @endif id="ddd{{ $dd->id }}">
                            <option selected disabled hidden> -- Select --</option>
                        </select>
                        </div>
                    </div>


                     @if (Str::lower($name) == 'preventiveactions')
                        {{--  Note for preventive Actions  --}}
                        <div class="form-group col-12 my-3">
                            <label for="" class="font-weight-bold">Note</label>
                            <textarea class="form-control" name="preventive_note" id="" cols="5" placeholder="Note....." rows="5">{{ $data->preventive_actions_note }} </textarea>
                        </div>
                    @endif
                </div>

                @if ( Str::lower($name) == "incidenttype")
                    {{--  Corrective Action
                    ========================  --}}
                    <div class="tab form-group">
                        <label for="inputAddress"> Corrective Action </label>
                        <textarea required   class="form-control" id="corrective_action" name="corrective_action" placeholder="Corrective Action....."> {{ $data->corrective_action }} </textarea>
                    </div>
                @endif

            @endforeach

            {{-- chekpoint (if user is admin then these fields are showing) --}}
            @if(Auth::user()->isAdmin())
                {{--  Closed
                ==========================  --}}
                <div class="tab input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Closed</label>
                            <select class="custom-select w-100" name="close" id="close">
                                <option selected hidden>{{ $data->status }}</option>
                                <option value="Approved">Approved</option>
                                <option value="Correction Required">Correction Required</option>
                            </select>
                        </div>

                </div>


                {{--  Office Comments
                ========================  --}}
                <div class="tab form-group">
                    <label for="inputAddress"> Office Comments </label>
                    <textarea   class="form-control" id="ofc_comments" name="ofc_comments" placeholder="Office Comments.....">  {{ $data->office_comments }} </textarea>
                </div>


                {{--  Lesson Learnt
                ========================  --}}
                <div class="tab form-group">
                    <label for="inputAddress"> Lesson Learnt </label>
                    <textarea   class="form-control" id="lession_learn" name="lession_learn" placeholder="Lesson Learnt.....">  {{ $data->lession_learnt }} </textarea>
                </div>
            @endif

            {{-- Buttons(next/prev) --}}
            <div class="mr-auto ml-auto" style="overflow:auto;">
                <div class="d-flex">
                    <button class="btn btn-primary mt-5 w-25 mr-auto" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                    <button class="btn btn-primary mt-5 w-25 ml-auto" type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
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
            </div>

        </form>
    </div>

@endsection



@section('footer_scripts')

    {{-- jquery link
    =====================--}}
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    {{-- multi-select link
    ============================= --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap_multi_select/bootstrap-multiselect.css') }}">
    <script src="{{ asset('js/bootstrap_multi_select/bootstrap-multiselect.js') }}"></script>


    {{-- date-picker script for date field
    ===============================--}}
    <script>
        $( function() {
            $( "#date" ).datepicker({maxDate: new Date()});
        } );
    </script>
    {{-- dropdown tracker on-change --}}
    {{-- <script>
         $("#immediatecause").change(function (e) {
             e.preventDefault();
             $('#dropdowns_blank').val(" ");

         });
   </script> --}}

    <!-- Multi-step form Script
    ================================= -->
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
    <!--=================================
     Multi-step form Script End -->
     {{-- --}}

    {{-- Automatic Dropdown Value Fetching Script --}}
    <script type="text/javascript">
                {{-- incidenttype first dropdown
                =========================== --}}
                    // for 1st drop down
                    var ffdd = document.getElementById("incidenttype");
                    // $("#incidenttype").change(function (e) {
                    //     console.log("changing");
                    //     e.preventDefault();
                    //     $('input[name="incidenttype_second"]').val("please select");

                    // });
                    var ffdd_value = '{{ $data->incident_type_one }}'
                    setSelectedValue(ffdd, ffdd_value);



                {{-- immediatecause first dropdown
                =========================== --}}
                    // for 1st drop down
                    var ffdd = document.getElementById("immediatecause")
                    var ffdd_value = '{{ $data->immediate_cause_one }}'
                    setSelectedValue(ffdd, ffdd_value);



                {{-- rootcauses first drop
                =========================== --}}
                    // for 1st drop down
                    var ffdd = document.getElementById("rootcauses")
                    var ffdd_value = '{{ $data->root_causes_one }}'
                    let ffdd_arr = ffdd_value.split(',')
                    for(i=0; i< ffdd_arr.length; i++)
                    {
                        setSelectedValue(ffdd, ffdd_arr[i]);
                    }


                {{-- preventiveactions first dropdown
                =========================== --}}
                    // for 1st drop down
                    var ffdd = document.getElementById("preventiveactions")
                    var ffdd_value = '{{ $data->preventive_actions_one }}'

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
                    var e_dd_vala = '{{ $data->incident_type_two }}';
                    subajaxtwo(e_dda, e_dd_myida , e_dd_vala );

                    {{-- immediatecause Second dropdown
                    ============================================ --}}
                    var e_ddb = $("#immediatecause").val()
                    var e_dd_myidb = $("#immediatecause").attr("myid");
                    var e_dd_valb = '{{ $data->immediate_cause_two }}';
                    subajaxtwo(e_ddb, e_dd_myidb , e_dd_valb );


                    {{-- rootcauses Second dropdown
                    ============================================ --}}
                    var e_ddc = $("#rootcauses").val()
                    var e_dd_myidc = $("#rootcauses").attr("myid");
                    var e_dd_valc = '{{ $data->root_causes_two }}';

                    for(j=0; j< e_ddc.length; j++)
                    {
                        if(e_ddc[j] != null || e_ddc[j] != undefined)
                        {
                            subajaxtwomulti(e_ddc[j], e_dd_myidc , e_dd_valc );
                            setInterval(function(){ $('#dd3').multiselect('rebuild');}, 2000);

                        }
                    }





                    {{-- preventiveactions Second dropdown
                    ============================================ --}}
                    var e_ddd = $("#preventiveactions").val()
                    var e_dd_myidd = $("#preventiveactions").attr("myid");
                    var e_dd_vald = '{{ $data->preventive_actions_two }}';

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
            $('#incidenttype').multiselect({includeSelectAllOption: false});








            // jQuery methods go here...
                $("#date").change(function(){
                    let dateinput = $("#date").val();
                    let date = moment(dateinput).format('DD-MMM-YYYY');
                    $("#date").val(date)  ;
                })



                    // for 3rd drop down
                    let onemy =  setInterval(function(){
                            var ee_dda = $('select[name="incidenttype_second"]').val();
                            var ee_dd_myida = $('select[name="incidenttype_second"]').attr("myidtwo");
                            var ee_dd_vala = '{{ $data->incident_type_three }}';
                            terajaxtwo(ee_dda,ee_dd_myida,ee_dd_vala)

                            var ee_dddb_id = $('select[name="immediatecause_second"]').attr("id");
                            var ee_ddb = $('#'+ee_dddb_id).val();
                            var ee_dd_myidb = $('select[name="immediatecause_second"]').attr("myidtwo");
                            var ee_dd_valb = '{{ $data->immediate_cause_three }}';
                            terajaxtwo(ee_ddb,ee_dd_myidb,ee_dd_valb)


                            {{--  Root causes 3rd drop  --}}
                                var ee_ddc = $('select[name="rootcauses_second[]"]').val();
                                var ee_dd_myidc = $('select[name="rootcauses_second[]"]').attr("myidtwo");
                                var ee_dd_valc = '{{ $data->root_causes_three }}';

                                for(let r = 0; r < ee_ddc.length ; r++)
                                {
                                    if(ee_ddc[r] != null || ee_ddc[r] != undefined)
                                    {
                                        terajaxtwomulti(ee_ddc[r],ee_dd_myidc , ee_dd_valc)
                                        setInterval(function(){ $('#ddd3').multiselect('rebuild');}, 2000);

                                    }
                                }

                            {{--  preventive 3rd drop  --}}
                                var ee_ddd = $('select[name="preventiveactions_second[]"]').val();
                                var ee_dd_myidd = $('select[name="preventiveactions_second[]"]').attr("myidtwo");
                                var ee_dd_vald = '{{ $data->preventive_actions_three }}';


                                for(m = 0; m < ee_ddd.length; m++)
                                {
                                    if(ee_ddd[m] != null || ee_ddd[m] != undefined)
                                    {
                                        terajaxtwomulti(ee_ddd[m],ee_dd_myidd,ee_dd_vald)
                                    }
                                }

                            clearInterval(onemy);
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
                                                    let sdd_value_one = '{{ $data->incident_type_two }}'
                                                    let sdd_value_two = '{{ $data->immediate_cause_two }}'
                                                    let sdd_value_three = '{{ $data->root_causes_two }}'
                                                    let sdd_value_four = '{{ $data->preventive_actions_two }}'
                                                    setSelectedValue(sdd, sdd_value_one )
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
                                                    let sdd_value_on = '{{ $data->incident_type_three }}'
                                                    let sdd_value_tw = '{{ $data->immediate_cause_three }}'
                                                    let sdd_value_thre = '{{ $data->root_causes_three }}'
                                                    let sdd_value_fou = '{{ $data->preventive_actions_three }}'
                                                    setSelectedValue(sdd, sdd_value_on )
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

@endsection

