@extends('layouts.app')


@section('template_linked_css')

    {{-- Bootstrap
    ======================== --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  

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
            height: 15px;
            width: 20px;
            margin: 0 0px;
            background-color: #004cff;
            border: 1px solid #002986;
            display: inline-block;
            opacity: 0.5;
            margin-left: 20px;
            border-radius: 10px !important;

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
                <a href="/moc">
                 <button type="button" class="btn btn-dark"><i class="fa fa-long-arrow-left" aria-hidden="true" style="color:white;"></i></button>
                </a>
            </div>
            </div>
        </div>
        <div class="containerCard" style="width:100%;height:auto;position:relative;display:flex;justify-content:center; align-items:center;">
            <!-- position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); margin-top: 1rem; -->
            <div class="card shadow" style="width:60%; ">
            <form class="p-5" method="post" action="{{ url('/moc/store') }}" id="managementform" enctype="multipart/form-data">
                @csrf
                  <div style="text-align:center;margin-top:40px; ">
                    {{-- <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span> --}}
                  </div>
                  <h1 class="text-center pb-2">Management of Change</h1>

                  {{-- section 1 --}}
                 <div class=" form-group">
                        <h4 class="mb-2 text-center">Submitted by</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="vessel_ofc_dept">Vessel/Office/Department</label>
                                <input type="text" class="form-control" id="vessel_ofc_dept" name="vessel_ofc_dept"  placeholder="Enter...">
                            </div>
                            <div class="col-md-6">
                                <label for="name_rank_pos">Name & Rank/Position</label>
                                <input type="text" class="form-control" id="name_rank_pos" name="name_rank_pos"  placeholder="Enter...">
                            </div>
                        </div>
                       <div class="row">
                           <div class="col-md-6">
                            <label for="toc_req">Type of change Requested</label>
                            <input type="text" class="form-control" id="toc_req" name="toc_req"  placeholder="Enter...">
                            <label for="date_management">Date:</label>
                            <input type="text" class="form-control" id="date_management" name="date_management"  placeholder="Enter...">
                           </div>
                           <div class="col-md-6">
                            <label for="control_no">Control Number(Issued by SafetyCoordinator):</label>
                            <input type="text" class="form-control" id="control_no" name="control_no"  placeholder="Enter...">
                          
                           </div>
                       </div>
                 </div>
                  {{-- section 2 --}}
                 <div class=" form-group">
                        <h3 class="mb-2 text-center">Change Requested</h3>
                        <div class="row "> 
                            {{-- <input type="hidden" id="STM_hidden" name="STM_hidden" value=""> --}}
                            @foreach($changeReqData as $eachData)
                                    <div class="col-md-6">
                                        @if($eachData->status == 1)
                                            <label>{{$eachData->name}}</label>
                                            {{-- <input type="text" hidden value="{{$eachData->id}}" name="STMID[]"> --}}
                                            <input class="change_requested form-control" data-id="{{$eachData->id}}"  id="checklist_{{$eachData->name}}" name="checklist_{{$eachData->id}}"   />
                                        @endif
                                        @if($eachData->status == 2)
                                            <label>{{$eachData->name}}</label>
                                            <select class="change_requested form-control"  data-id="{{$eachData->id}}" name="checklist_{{$eachData->id}}" id="checklist_{{$eachData->name}}" 
                                            data-parent="{{$eachData->id}}">
                                                <option  selected hidden value=" ">Select Yes / No / NA</option>
                                                <option value="Yes">YES</option>
                                                <option value="No">NO</option>      
                                                <option value="Na">NA</option>      
                                            </select> 
                                        @endif
                                        @if($eachData->status == 3)
                                            <label>{{$eachData->name}}</label>
                                            <select class="change_requested form-control"  data-id="{{$eachData->id}}" name="checklist_{{$eachData->id}}" id="checklist_{{$eachData->name}}" 
                                            data-parent="{{$eachData->id}}">
                                            <option  selected hidden value=" ">Select Temporary / Permanent</option>
                                            <option value="Temporary">Temporary</option>
                                            <option value="Permanent">Permanent</option>            
                                            </select> 
                                        @endif
                                    </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label>Select Risk Assesment</label>
                                {{--<select class="form-control col-12"  data-id="" name="RA" id="RA" 
                                            data-parent="">
                                    <option  selected hidden value=" ">Select an RA</option>
                                    @foreach($riskAssesment as $r)
                                        <option value="{{$r->riskAssesment_id}}">{{$r->riskAssesment_id}}</option>
                                    @endforeach    
                                </select> --}}
                                <input type="file" id="RA_pdf" name="RA_pdf" class="form-control">
                            </div>             
                        </div>
                 </div>
                 {{-- section-3 --}}
                  <div class=" form-group">
                      <h3 class="text-center py-1">Checklist to be completed for approval</h3>
                        @foreach ($checklist as $each_check )
                              @if($each_check->value_type==config('constants.MOC_INPUT_TYPES.LIST'))
                                {{-- <p>{{ count($each_check->children) }}</p>  --}}
                                    <div class= "row mx-auto">
                                        <label for="check_{{$each_check->name}}" class="col-8">{{$each_check->name}}</label>
                                        {{-- <input type="text" hidden value="{{$each_check->id}}" id="CHECKPAIRID" name='CHECKPAIRID'> --}}
                                        
                                        <select class="form-control custom col-4 checklist checkliststore change_requested"  data-id="{{$each_check->id}}" name="checklist_{{$each_check->id}}" id="checklist_{{$each_check->name}}" 
                                            data-parent="{{$each_check->id}}">
                                            <option  selected hidden value=" ">Select Yes / No / NA</option>
                                            <option value="Yes">YES</option>
                                            {{-- <option value="Yes">YES</option> --}}
                                            <option value="No">NO</option>      
                                            <option value="Na">NA</option>      
                                        </select> 
                                    </div>
                                    @foreach ($each_check->children as $child )
                                    <div class= "row mx-auto checklist_child d-none"  data-child="{{$each_check->id}}">
                                        {{-- <p>{{$loop->index}}</p> --}}
                                        <label for="check_{{$child->name}}" class="col-8" style="color:green">-{{$child->name}}</label>
                                        {{-- <input type="text" hidden value="{{$each_check->id}}" name="CHECKPAIRID"> --}}
                                        <select class="form-control custom col-4 checkliststore change_requested " value='' data-id="{{$child->id}}" name="checklist_{{$child->id}}" id="check_{{$child->name}}">
                                            <option  selected hidden value=" " >Select Yes / No / NA</option>
                                            <option value="Yes">YES</option>
                                            <option value="No">NO</option>      
                                            <option value="Na">NA</option>      
                                        </select> 
                                    </div>
                                @endforeach
                            @elseif($each_check->value_type==config('constants.MOC_INPUT_TYPES.LABEL'))
                            {{--Label--}}
                            <div class="row mx-auto mt-3">
                                <label for="check_{{$each_check->name}}" class="col-8">{{$each_check->name}}</label>
                            </div>
                            @elseif($each_check->value_type==config('constants.MOC_INPUT_TYPES.TEXT'))
                            {{--Text--}}
                            <div class="row mx-auto my-2">
                                {{-- <input type="text" hidden value="{{$each_check->id}}" name="CHECKPAIRID"> --}}
        
                                <label for="check_{{$each_check->name}}" class="col-8">{{$each_check->name}}</label>
                                <input id="checklist_{{$each_check->name}}" data-id="{{$each_check->id}}" name="checklist_{{$each_check->id}}"  class="form-control checkliststore change_requested" />
                            </div>
                            @endif
                        @endforeach
                        <div class="container">
                            <h5>Note: </h5>
                            <p>
                                1.	The Requester being the Senior Ship Management (SSM) or any Manager ashore is to sign this checklist.
                            </p>
                            <p>
                                2.	The form ADM008 is to be completed and submitted for the Safety Manager or Fleet Manager review after completion of change.
                            </p>
                            <p>
                                3.	Vessel is to inform office immediately the changes cannot be carried within the proposed time scale.  Office is to review and revalidate the MOC.
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label>Name of the Requester:</label>
                                <input type="text" id="name_requester" name="name_requester" class="form-control">
                            </div>
                            <div class="col-6">
                                <label>Signature:</label>
                                <input type="file" id="sign_requester" name="sign_requester" class="form-control">
                            </div>
                        </div>
                      
                  </div>
                  <div class="d-none">
                          {{-- SECTION_4 --}}
                  <div class=" form-group">
                    <h4 class="mb-2 text-center"> Evaluation</h4>
                    <div class="row">
                        <label for="comp_team_member">Name of the composition Team Member (If any):</label>
                        <textarea type="text" name="comp_team_member" id="comp_team_member" class="form-control"></textarea>
                    </div>
                    <div class="row">
                        <label for="remarks_moc">Remarks:</label>
                        <textarea type="text" name="remarks_moc" id="remarks_moc" class="form-control"></textarea>
                            
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <label for="review_fleet_dgm">Reviewed and Signed By
                              Fleet Manager or D/GM (MSD): 
                              </label>
                              <input type="text" name="review_fleet_dgm" id="review_fleet_dgm" class="form-control">
                          </div>
                          <div class="col-4">
                              <label for="date_fleet_dgm">Date:</label>
                              <input type="text" name="date_fleet_dgm" id="date_fleet_dgm" class="form-control">
                        </div>
                    </div>

                 </div>
                 {{-- SECTION 5 --}}
                 <div class=" form-group">
                    <h4 class=" mb-2 text-center"> General Manager Action</h4>
                    <div class="row">
                        <div class="col-6"><h6>Request Denied:</h6></div>
                        <div class="col-6">
                            <label for="gma_req_den_reason">reason:</label>
                            <textarea name="gma_req_den_reason" id="gma_req_den_reason" cols="10" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6"><h6>Request Deffered or under Review:</h6></div>
                        <div class="col-6">
                            <label for="gma_req_deff_reason">reason:</label>
                            <textarea name="gma_req_deff_reason" id="gma_req_deff_reason" cols="10" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5"><h6>Request accepted:</h6></div>
                        <div class="col-7">
                            <div class="d-flex">
                                <input type="radio" name="" id="gma_req_apr_gm_check"  class="mr-1">
                                <label for="gma_req_apr_gm">review by GM:</label>
                                <input type="text" name="gma_req_apr_gm" id="gma_req_apr_gm" class="form-control">
                            </div>
                            <div class="d-flex">
                                <input type="radio" name="" id="gma_req_apr_ts_check"  class="mr-1">
                                <label for="gma_req_apr_ts">Timescale set:</label>
                                <input type="text" name="gma_req_apr_ts" id="gma_req_apr_ts" class="form-control">
                            </div>
                            <div class="d-flex">
                                <input type="radio" name="" id="gma_req_tqi_check" class="mr-1" >
                                <label for="gma_req_tqi">Training Requirements identified:</label>
                                <input type="text" name="gma_req_apr_tqi" id="gma_req_tqi" class="form-control">
                            </div>
                            <div class="d-flex">
                                <input type="radio" name="" id="gma_req_dp_check" class="mr-1" >
                                <label for="gma_req_dp">Drawings, procedures and other technical documents updated/approved (if applicable).:</label>
                                <input type="text" name="gma_req_apr_gm" id="gma_req_dp_check" class="form-control">
                            </div>
                            
                        </div>
                    </div>

                 </div>
                 {{-- SECTION 6 --}}
                 <div class=" form-group">
                    <h4 class="mb-2 text-center"> Approval</h4>
                      <div class="row">
                          <div class="col-6">
                              <label for="appr_and_sign_gm">Approved and Signed by GM: </label>
                              <input type="file" class="form-control" name="appr_and_sign_gm" id="appr_and_sign_gm">
                          </div>
                          <div class="col-6">
                              <label for="appr_and_sign_date">Date: </label>
                              <input type="text" class="form-control" name="appr_and_sign_date" id="appr_and_sign_date">
                          </div>
                      </div>
                 </div>
                  </div>
                

                {{-- Buttons(next/prev) --}}
                <div class="mr-auto ml-auto" style="overflow:auto;">
                    <div class="d-flex">
                        {{-- <button class="btn btn-primary mt-5 w-25 mr-auto" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button> --}}
                        
                        <button class="btn btn-primary mt-5 w-25 ml-auto" type="submit" id="" >Submit Report</button>
                    </div>
                </div> 

                <!-- Circles which indicates the steps of the form: -->
                {{-- these portion are not require to visible but if input fields are increased then have to increse the span  --}}

                

            </form>
          </div>
    
    </div>
    <!--==============
    Html End -->


@endsection



@section('footer_scripts')
    <script src="/js/custom/moc/create.js"></script>
    <!-- Load Babel -->
    <script src="{{asset('js/babel/babel.js')}}"></script>


    {{-- jquery
    =====================--}}
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    {{-- multi-select
    ============================= --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap_multi_select/bootstrap-multiselect.css') }}">
    <script src="{{ asset('js/bootstrap_multi_select/bootstrap-multiselect.js') }}"></script>


    {{-- date-picker script for date field
    ===============================--}}
    <script>
        $( function() {
            $( "#date" ).datepicker();
            $( "#appr_and_sign_date" ).datepicker();
            $( "#date_fleet_dgm" ).datepicker();
            $( "#date_management" ).datepicker();
        } );

       $(document).ready(function () {
        $('body').on('change','#appr_and_sign_date', function(){
                                 let dateinput = $(this).val();
                                 let date = moment(dateinput).format('DD-MMM-YYYY');
                                 $(this).val(date);
                        })
        $('body').on('change' , '#date_fleet_dgm' , function(){
                                 let dateinput = $(this).val();
                                 let date = moment(dateinput).format('DD-MMM-YYYY');
                                 $(this).val(date);
                        })
        $('body').on('change' , '#date_management' , function(){
                                 let dateinput = $(this).val();
                                 let date = moment(dateinput).format('DD-MMM-YYYY');
                                 $(this).val(date);
                        })
       });

    </script>


<script type="text/javascript" src="/js/summernote/summernote.js"></script>



     <!-- Multi-step form Script
    ================================ -->
    <script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        // showTab1(currentTab); // Display the current tab


        // fire next on presing enter
        // $(document).on("keypress", function (e) {
        //     //all the action
        //     var key = e.which;
        //     if(key == 13)
        //     {
        //         nextPrev(1)
        //     }
        // });

        function showTab1(n) {
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

        function nextPrev1(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is invalid:
            // if(n == 1){
            //     if (n == 1 && !validateForm() || !validateFormTextarea() || !validateFormSelect()) return false;
            // }
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form... :



                if (currentTab >= x.length) {
                    //...the form gets submitted:
                    document.getElementById("managementform").submit();
                     return false;
                }

            // Otherwise, display the correct tab:
            showTab1(currentTab);
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
        // checklist display on and off
        $('.checklist').on('change',function(){
            let value = $(this).val();
            console.log(value);
            let target = $(this).attr('data-parent');
            if(value == 'Yes'){
                 console.log(target);
                //  console.log($(`.checklist_child[data-child="${target}"]`));
                 $(`.checklist_child[data-child="${target}"]`).removeClass('d-none');
            }
            else{
                $(`.checklist_child[data-child="${target}"]`).addClass('d-none');
            }
        })
    </script>
    <!--=============================
     Multi-step Script End -->

    
    
    
 



@endsection
