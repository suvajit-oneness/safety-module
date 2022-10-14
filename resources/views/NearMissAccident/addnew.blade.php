@extends('layouts.app')


@section('template_linked_css')

    {{-- Bootstrap
    ======================== --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
            height: 20px;
            width: 20px;
            margin: 0 0px;
            background-color: #004cff;
            border: 1px solid #002986;
            display: inline-block;
            opacity: 0.5;
            margin-left: 20px;
            border-radius: 100px !important;

        }

            /* Mark the active step: */
            .step.active {
                opacity: 1;
            }

            /* Mark the steps that are finished and valid: */
            .step.finish {
                background-color: #ffffff;
                border: 5px solid #004cff;
            }
        </style>
    <!-- =================
    Multi-step Style End -->
@endsection




@section('content')

    <!-- Html
    ================== -->
    {{-- div for centering the form --}}
        <div class="container">
            <div class="row">
            <div class="col-12">
                <a href="/Near_Miss">
                 <button type="button" class="btn btn-dark"><i class="fa fa-long-arrow-left" aria-hidden="true" style="color:white;"></i></button>
                </a>
            </div>
            </div>
        </div>
        <div class="card shadow" style="width:51rem; position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);">
            <form class="p-5" method="post" action="{{ route('Near_Miss_store') }}" id="near_miss_form">
                @csrf
                <input type="hidden" id = "id" name = "id" value = {{ $data->id }}>
                <div style="text-align:center;margin-top:40px; ">
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                    <!-- <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span> -->
                </div>
                <h1 class="text-center pb-5">Near Miss Report</h1>




                {{--  Date & Describtion
                ======================== (step1) --}}
                <div class="tab form-group">

                    <div class="row">
                        <div class="col-6">
                            <label for="inputAddress">Date<span class="text-danger  mt-3 font-weight-bold">*</span></label>
                            {{--<input type="text"   class="form-control" id="date" name="date" placeholder="Date" autocomplete="off" >--}}
                            <input type="text"   class="form-control" id="date" name="date" value={{ $data->date }}>
                            
                        </div>
                        <div class="col-6">
                            <label for="inputAddress" class=""> Description<span class="text-danger   font-weight-bold">*</span> </label>
                            {{--<textarea   class="form-control" id="desc" name="desc" placeholder="Description....."> </textarea>--}}
                            <textarea   class="form-control" id="desc" name="desc" placeholder="Description....."> {{ $data->describtion }} </textarea>
                        </div>

                    </div>
                    <!-- <button class="btn btn-primary ml-30 mt-5 w-25" type="button" onclick="openRiskMatrix()">View Matrix</button> -->
                    <div class="form-row mt-3">
                        {{-- Severity --}}
                        <div class="col-4">
                            <label for="IIARCF_safety_Severity">Severity<span class="text-danger   font-weight-bold">*</span></label>
                                <select class="form-control custom" name="IIARCF_safety_Severity" id="IIARCF_safety_Severity">
                                    @if(@isset($data) && $data->severity)
                                        @if($data->severity == 1)
                                            <option disabled selected hidden value="1">VERY LOW</option>
                                        @elseif($data->severity == 2)
                                            <option disabled selected hidden value ="2">LOW</option>
                                        @elseif($data->severity == 3)
                                            <option disabled selected hidden value ="3">MODERATE</option>
                                        @elseif($data->severity == 4)
                                            <option disabled selected hidden value = "4">HIGH</option>
                                        @elseif($data->severity == 5)
                                            <option disabled selected hidden value = "5">VERY HIGH</option>
                                       
                                        @endif
                                    @else
                                        <option disabled selected hidden>Select Severity</option>
                                    @endif
                                    <option value="1">VERY LOW</option>
                                    <option value="2">LOW</option>
                                    <option value="3">MODERATE</option>
                                    <option value="4">HIGH</option>
                                    <option value="5">VERY HIGH</option>
                                </select>
                        </div>
                        {{-- Likelihod --}}
                        <div class="col-4">
                            <label for="IIARCF_safety_Severity">Likelihood<span class="text-danger   font-weight-bold">*</span></label>
                                <select class="form-control custom" name="IIARCF_safety_Likelihood" id="IIARCF_safety_Likelihood">
                                    @if(@isset($data) && $data->likelihood)
                                        @if($data->likelihood == 1)
                                            <option disabled selected hidden value = "1">RARE</option>
                                        @elseif($data->likelihood == 2)
                                            <option disabled selected hidden value = "2">UNLIKELY </option>
                                        @elseif($data->likelihood == 3)
                                            <option disabled selected hidden value = "3">POSSIBLE</option>
                                        @elseif($data->likelihood == 4)
                                            <option disabled selected hidden value = "4">LIKELY</option>
                                        @elseif($data->severity == 5)
                                            <option disabled selected hidden value = "5">ALMOST CERTAIN</option>
                                        @endif
                                    @else
                                        <option disabled selected hidden>Select Severity</option>
                                    @endif
                                    <option value="1">RARE</option>
                                    <option value="2">UNLIKELY </option>
                                    <option value="3">POSSIBLE</option>
                                    <option value="4">LIKELY</option>
                                    <option value="5">ALMOST CERTAIN</option>
                                </select>
                        </div>
                        <div class="col-4 text-center">
                            <button class="btn btn-primary ml-30 mt-4 w-15 "  type="button" onclick="openRiskMatrix()">View Matrix</button>
                        </div>

                    </div>
                    {{-- Result --}}
                    <div class="form-group">
                        <label for="IIARCF_safety_Result"> Result</label>
                        <textarea class="form-control custom" name="IIARCF_safety_Result" id="IIARCF_safety_Result" disabled="disabled">{{$data->result}}</textarea>
                        <!-- <button class="btn btn-primary ml-30 mt-5 w-15" type="button" onclick="openRiskMatrix()">View Matrix</button> -->
                    </div>
                    <div class = "form-group">
                        <div class="mr-auto ml-auto" style="overflow:auto;">
                            <div class="d-flex ">
                                <button class="btn btn-primary mt-5 w-25 mr-auto" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>

                                <button class="btn btn-primary mt-5 w-25 ml-auto" type="button" id="nextBtn" name="step0"  onclick="nextPrev(1)">Next</button>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- Dropdown
                ================================ (step2)--}}
                @foreach ($dropdown as $dd)
                    @php
                        $name = str_replace(' ', '', $dd->dropdown_name)
                    @endphp

                    <div class="tab form-row">
                        {{-- Dropdown 1 --}}
                        <div class="form-group col-12 my-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01"> {{$dd->dropdown_name}} <span class="text-danger   font-weight-bold">*</span> </label>
                                </div>

                                <select id="{{Str::lower($name)}}" required @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" ) multiple @endif class="custom-select drop" myid="dd{{ $dd->id }}" @if ( Str::lower($name) == "rootcauses" || Str::lower($name) == "preventiveactions" )  name="{{Str::lower($name)}}_first[]" @else name="{{Str::lower($name)}}_first"  @endif required >
                                @if(Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause' )
                                        <option value=0 disabled selected>None Selected</option>
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
                                    {{-- @if(Str::lower($name) == 'incidenttype' || Str::lower($name) == 'immediatecause' ) --}}
                                        <option value=0 disabled selected>None Selected</option>
                                    {{-- @endif --}}
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
                                            <option value=0 disabled selected>None Selected</option>
                                        @endif
                                </select>
                            </div>

                        </div>

                        @if ( Str::lower($name) == "incidenttype")
                            {{--  Corrective Action
                            ========================  --}}
                            <!-- <div class="tab form-group"> -->
                                <label for="inputAddress"> Corrective Action <span class="text-danger   font-weight-bold">*</span></label>
                                {{--<textarea required   class="form-control" id="corrective_action" name="corrective_action" placeholder="Corrective Action....."> </textarea>--}}
                                <textarea required   class="form-control" id="corrective_action" name="corrective_action" placeholder="Corrective Action....."> {{ $data->corrective_action }} </textarea>
                            <!-- </div> -->
                        @endif


                        @if (Str::lower($name) == 'preventiveactions')
                            {{--  Note for preventive Actions  --}}
                            <div class="form-group col-12 my-3">
                                <label for="" class="font-weight-bold">Note<span class="text-danger   font-weight-bold">*</span></label>
                                {{--<textarea class="form-control" name="preventive_note" id="" cols="5" placeholder="Note....." rows="5"></textarea>--}}
                                <textarea class="form-control" name="preventive_note" id="preventive_note" cols="5" placeholder="Note....." rows="5">{{ $data->preventive_actions_note }} </textarea>
                            </div>
                        @endif
                        <div class = "form-group">
                            <div class="mr-auto ml-auto" style="overflow:auto;">
                                <div class="d-flex ">
                                    <button class="btn btn-primary mt-5 w-25 mr-auto" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>

                                    <button class="btn btn-primary mt-5 w-25 ml-auto" type="button" id="nextBtn" name="step{{$dd->id}}"  onclick="nextPrev(1)">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>


                @endforeach



                 {{-- chekpoint (if user is admin then these fields are showing) --}}
                @if(Auth::user()->isAdmin())
                    {{--  Closed
                    ========================== (step6) --}}
                    <div class="tab input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="close">Closed</label>
                                {{--<select required class="custom-select w-100" name="close" id="close">
                                    <option disabled selected >None Selected</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>--}}
                                <select class="custom-select w-100" name="close" id="close">
                                <option selected hidden>{{ $data->status }}</option>
                                <option value="Approved">Approved</option>
                                <option value="Correction Required">Correction Required</option>
                            </select>

                            </div>
                            <div class="form-group">
                            <label for="inputAddress" class="mt-3"> Office Comments </label>
                                {{--<textarea   class="form-control" id="ofc_comments" name="ofc_comments" placeholder="Office Comments....."> </textarea>--}}
                                <textarea   class="form-control" id="ofc_comments" name="ofc_comments" placeholder="Office Comments.....">  {{ $data->office_comments }} </textarea>
                                <label for="inputAddress" class="mt-3"> Lesson Learnt </label>
                                {{--<textarea   class="form-control" id="lession_learn" name="lession_learn" placeholder="Lesson Learnt....."> </textarea>--}}
                                <textarea   class="form-control" id="lession_learn" name="lession_learn" placeholder="Lesson Learnt.....">  {{ $data->lession_learnt }} </textarea>

                            </div>
                            <div class = "form-group">
                                <div class="mr-auto ml-auto" style="overflow:auto;">
                                    <div class="d-flex ">
                                        <button class="btn btn-primary mt-5 w-25 mr-auto" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>

                                        <button class="btn btn-primary mt-5 w-25 ml-auto" type="Submit" id="nextBtn" name="step5"  onclick="nextPrev(1)">Submit</button>
                                    </div>
                                </div>
                            </div>

                    </div>


                   
                @endif

                

                <!-- Circles which indicates the steps of the form: -->
                {{-- these portion are not require to visible but if input fields are increased then have to increse the span  --}}



            </form>
        </div>
    <!--==============
    Html End -->
@include('modals.custom.risk-matrix-modal')

@endsection
   
@section('footer_scripts')

    {{-- jquery link--}}
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- summer note -->
    <script type="text/javascript" src="/js/summernote/summernote.js"></script>

    <!-- Custom js -->
    <script type="text/javascript" src="/js/custom/nearMiss/createEdit.js"></script>

    {{-- multi-select link --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap_multi_select/bootstrap-multiselect.css') }}">
    <script src="{{ asset('js/bootstrap_multi_select/bootstrap-multiselect.js') }}"></script>

    <!-- dropdown code -->
    <script src="{{asset('js/near_miss/IIRP_dropdown.min.js')}}" type="text/babel"></script>

    <!-- Load Babel -->
    <script src="{{asset('js/babel/babel.js')}}"></script>

    {{-- Automatic Dropdown Value Fetching Script --}}
   <script type="text/javascript">
                {{-- incidenttype first dropdown --}}
                    // for 1st drop down
                    var ffdd = document.getElementById("incidenttype");
                    var ffdd_value = '{{ $data->incident_type_one }}'
                    setSelectedValue(ffdd, ffdd_value);



                {{-- immediatecause first dropdown --}}
                    // for 1st drop down
                    var ffdd = document.getElementById("immediatecause")
                    var ffdd_value = '{{ $data->immediate_cause_one }}'
                    setSelectedValue(ffdd, ffdd_value);



                {{-- rootcauses first drop --}}
                    // for 1st drop down
                    var ffdd = document.getElementById("rootcauses")
                    var ffdd_value = '{{ $data->root_causes_one }}'
                    let ffdd_arr = ffdd_value.split(',')
                    for(i=0; i< ffdd_arr.length; i++)
                    {
                        setSelectedValue(ffdd, ffdd_arr[i]);
                    }


                {{-- preventiveactions first dropdown --}}
                    // for 1st drop down
                    var ffdd = document.getElementById("preventiveactions")
                    var ffdd_value = '{{ $data->preventive_actions_one }}'

                    ffdd_arr = ffdd_value.split(',')
                    for(i=0; i< ffdd_arr.length; i++)
                    {
                        setSelectedValue(ffdd, ffdd_arr[i]);
                    }






                {{-- Seconod drop --}}

                    {{-- incidenttype Second dropdown --}}
                    var e_dda = $("#incidenttype").val();
                    var e_dd_myida = $("#incidenttype").attr("myid");
                    var e_dd_vala = '{{ $data->incident_type_two }}';
                    // console.log('something selected');
                    subajaxtwo(e_dda, e_dd_myida , e_dd_vala );
                    

                    {{-- immediatecause Second dropdown --}}
                    var e_ddb = $("#immediatecause").val()
                    var e_dd_myidb = $("#immediatecause").attr("myid");
                    var e_dd_valb = '{{ $data->immediate_cause_two }}';
                    subajaxtwo(e_ddb, e_dd_myidb , e_dd_valb );


                    {{-- rootcauses Second dropdown --}}
                    var e_ddc = $("#rootcauses").val()
                    var e_dd_myidc = $("#rootcauses").attr("myid");
                    var e_dd_valc = '{{ $data->root_causes_two }}';
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





                    {{-- preventiveactions Second dropdown --}}
                    var e_ddd = $("#preventiveactions").val()
                    var e_dd_myidd = $("#preventiveactions").attr("myid");
                    var e_dd_vald = '{{ $data->preventive_actions_two }}';
                    if(e_ddd != null){
                        for(k = 0; k < e_ddd.length ; k++ )
                        {
                            if(e_ddd[k] != null || e_ddd[k] != undefined)
                            {
                                subajaxtwomulti(e_ddd[k], e_dd_myidd , e_dd_vald);
                                setInterval(function(){ $('#dd4').multiselect('rebuild');}, 2000);
                            }
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
        {{--  Sub ajax --}}
        function subajax(d , atr)
        {
            $.ajax({
                                        type: 'POST',
                                        url: "/api/subtype",
                                        data: {'id': d},
                                        success: function(result)
                                        {


                                                    output = "<option>None Selected</option>";
                                                    if(result.length < 1)
                                                    {
                                                        $("#display_"+atr).css("cssText", "display: none !important;");
                                                        $("#display_d"+atr).css("cssText", "display: none !important;");
                                                        // $("#"+atr).html("");
                                                        $("#"+atr).append("");
                                                        // $("#d"+atr).html("");
                                                        $("#d"+atr).append("");
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

                                                        output = "<option disabled >None Selected</option>";
                                                        if(result.length < 1)
                                                        {
                                                            $("#display_"+atr).css("cssText", "display: none !important;");
                                                            $("#display_d"+atr).css("cssText", "display: none !important;");
                                                            // $("#"+atr).html("");
                                                            $("#"+atr).append("");
                                                            // $("#d"+atr).html("");
                                                            // $("#d"+atr).html("");
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

                                                    output = "<option>None Selected</option>";
                                                    if(result.length < 1)
                                                    {
                                                        $("#display_"+atr).css("cssText", "display: none !important;");
                                                        $("#display_d"+atr).css("cssText", "display: none !important;");
                                                        // $("#"+atr).html("");
                                                        $("#"+atr).append("");
                                                        // $("#d"+atr).html("");
                                                        $("#d"+atr).append("");
                                                    }
                                                    else
                                                    {
                                                        console.log('Else');
                                                        
                                                        for(let i = 0; i < result.length; i++)
                                                        {
                                                            
                                                            output += "<option value="+ result[i].id +">"+ result[i].type_sub_name +"</option>";
                                                        }
                                                        $("#display_"+atr).css("cssText", "display: block !important;");;
                                                    }

                                                    $("#"+atr).html(output);
                                                    // $("#"+atr).append(output);
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

                                                    output = "<option disabled>None Selected</option>";
                                                            if(result.length < 1)
                                                            {
                                                                $("#display_"+atr).css("cssText", "display: none !important;");
                                                                $("#display_d"+atr).css("cssText", "display: none !important;");
                                                                // $("#"+atr).html("");
                                                                $("#"+atr).append("");
                                                                // $("#d"+atr).html("");
                                                                $("#d"+atr).append("");
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

                                                            document.getElementById(atr).innerHTML = output;
                                                }
                    });



        }

        // ter ajax are the function for fetching all third dropdowns data acording to the second dropdown
        {{-- --}}
        function terajax(d , atr)
        {
            $.ajax({
                                        type: 'POST',
                                        url: "/api/tertype",
                                        data: {'id': d},
                                        success: function(result)
                                        {

                                            output = "<option>None Selected</option>"
                                                    if(result.length < 1)
                                                    {
                                                        $("#display_"+atr).css("cssText", "display: none !important;");
                                                        // $("#"+atr).html("");
                                                        $('#'+atr).append("")
                                                    }
                                                    else
                                                    {

                                                        for(let i = 0; i < result.length; i++)
                                                        {
                                                            output += "<option value="+ result[i].id +">"+ result[i].type_ter_name +"</option>";
                                                        }
                                                        $("#display_"+atr).css("cssText", "display: block !important;");;
                                                    }

                                                    // $("#"+atr).html(output);
                                                    $("#"+atr).append(output);
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


                                    output = "<option disabled>None Selected</option>";
                                
                                            if(result.length < 1)
                                            {
                                                $("#display_"+atr).css("cssText", "display: none !important;");
                                                // $("#"+atr).html("");
                                                $("#"+atr).append("");
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

                                                output = "<option >None Selected</option>";
                                                console.log(output);
                                                        if(result.length < 1)
                                                        {
                                                            $("#display_"+atr).css("cssText", "display: none !important;");
                                                            // $("#"+atr).html("");
                                                            $("#"+atr).append("");
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

                                                    output = "<option disabled >None Selected</option>";
                                                                if(result.length < 1)
                                                                {
                                                                    $("#display_"+atr).css("cssText", "display: none !important;");
                                                                    // $("#"+atr).html("");
                                                                    $("#"+atr).append("");
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

