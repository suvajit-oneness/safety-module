@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="breadcrumb breadcrumb-custom-header" style="display: flex; justify-content: space-between; align-items: center;">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <a href="/risk_assessment" class="btn btn-dark">
                            <i class="fa fa-long-arrow-left"></i>
                        </a>                        
                    </div>
                </div>
                <h1>Edit B18 Form</h1>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <form method="post" action="/risk_assessment_update/{{$risk_assessment_data->id}}" class="form" id="risk_assessment_form">
                    	<div class="row">
                    		<div class="col-md-12">
                                <div class="pull-left">
                                    <p style="color: red;" class="m-0">Section 1</p>
                                </div>
                    			<div class="pull-right" style="display:flex;">
                    				<div class="col form-group">
                                        <label for="id">Risk Assessment ID</label>
                    					<input type="text" class="form-control mr-sm-2" id="email" placeholder="Enter ID" name="id" value="{{$risk_assessment_data->id}}">
                    				</div>
                    				<div class="col form-group">
                                        <label for="vessel_select">Vessel Code</label>
                    					<select class="form-control " id="vessel_select">
                                            @foreach($vessel_info as $vessel)
                                                @if($vessel->id == $risk_assessment_data->vessel_id)
                                                    <option value="{{$vessel->id}}" selected>{{$vessel->code}}</option>
                                                @else
                                                    <option value="{{$vessel->id}}">{{$vessel->code}}</option>
                                                @endif
                                            @endforeach
                    					</select>
                    				</div>
                    			</div>
                    		</div>
                        </div>	
                    	
                    	<div class="row mt-3">
                       
                    		<div class="col form-group">
                    			<label for="vessel-id">Vessel</label>
                                <div class="form-control" readonly>{{$risk_assessment_data->vessel_name}}</div>
                    			<input type="text" class="form-control" id="vessel-id" name="vessel-id" readonly value="{{$risk_assessment_data->vessel_id}}" hidden>
                    		</div>
                       
                    		<div class="col form-group">
                    			<label for="fleet-id">Fleet</label>
                                <div class="form-control" readonly>{{$risk_assessment_data->fleet_name}}</div>
                    			<input type="text" class="form-control" id="fleet-id" name="fleet-id" readonly value="{{$risk_assessment_data->vessel_fleet_id}}" hidden>  
                    		</div>
                       
                    		<div class="col form-group">
                    			<label for="dept-id">Dept</label>
                    			<select class="form-control" id="dept-id" name="dept-id">
                    				@foreach($department_info as $dept)
                                        @if($dept->id == $risk_assessment_data->dept_id)
                                            <option value="{{$dept->id}}" selected>{{$dept->name}}</option>
                                        @else
                                            <option value="{{$dept->id}}">{{$dept->name}}</option>
                                        @endif
                                    @endforeach
                    			</select>
                    		</div>
                       
                    		<div class="col form-group">
                    			<label for="location">Location</label>
                    			<select class="form-control" id="location" name="location">
                    				@foreach($location_info as $location)
                                        @if($location->id == $risk_assessment_data->loc_id)
                                            <option value="{{$location->id}}" selected>{{$location->name}}</option>
                                        @else
                                            <option value="{{$location->id}}">{{$location->name}}</option>
                                        @endif
                                    @endforeach
                    			</select>
                    		</div>
                       
                    		<div class="col form-group">
                    			<label for="assess-date">Assess Date</label>
                    			<input type="date" class="form-control" id="assess-date" placeholder="dd-mm-yyyy"  name="assess-date" value="{{$risk_assessment_data->assess_date}}">
                    		</div>
                    		</div>
                       
                    	<div class="row mt-3">
                            <div class="col-6 form-group">
                    			<label for="activity-name">Activity Name</label>
                                <input type="text" class="form-control" id="activity-name" placeholder="Enter activity-name" name="activity-name" value="{{$risk_assessment_data->activity_name}}">
                            </div>
                            
                            <div class="col-6 form-group">
                            	<label for="activity-type">Activity Type</label>
                            	<select class="form-control" id="activity-type" name="activity-type">
                                    @if($risk_assessment_data->activity_type == "Routine")
                                        <option value="Routine" selected>Routine</option>
                                        <option value="Non Routine">Non Routine</option>
                                        <option value="Non-routine with office">Non-routine with office</option>
                                    @elseif($risk_assessment_data->activity_type == "Non Routine")
                                        <option value="Routine">Routine</option>
                                        <option value="Non Routine" selected>Non Routine</option>
                                        <option value="Non-routine with office">Non-routine with office</option>
                                    @elseif($risk_assessment_data->activity_type == "Non-routine with office")
                                        <option value="Routine">Routine</option>
                                        <option value="Non Routine">Non Routine</option>
                                        <option value="Non-routine with office" selected>Non-routine with office</option>
                                    @endif
                                </select>
                            </div>
                       </div>
                       
                       <div class="row mt-3">
                            <div class="col form-group">
                                <label for="assessed-by">Assessed By</label>
                                <input type="text" class="form-control" id="assessed-by" placeholder="Assessed-by"  name="assessed-by" value="{{$risk_assessment_data->assessed_by}}">
                            </div>
                            <div class="col form-group">
                                <label for="assess-rank">Rank</label>
                                <select class="form-control" id="assess-rank" name="assess-rank">
                                    <option value="{{$risk_assessment_data->assess_rank}}">{{$risk_assessment_data->assess_rank}}</option>
                                    <option value="1">Select A</option>
                                    <option value="2">Select B</option>
                                    <option value="3">Select C</option>
                                    <option value="4">Select D</option>
                                </select>
                            </div>
                            <div class="col form-group">
                                <label for="review-date">Review Date</label>
                                <input type="date" class="form-control" id="review-date" placeholder="review-date"  name="review-date" value="{{$risk_assessment_data->review_date}}">
                            </div>
                            <div class="col form-group">
                                <label for="activity-group">Activity Group</label>
                                <input type="text" class="form-control mr-sm-2" id="activity-group" placeholder="activity-group"  name="activity-group" value="{{$risk_assessment_data->activity_group}}">
                            </div>
                       </div>
                       
                       <div class="row mt-3">
                            <div class="col form-group">
                                <label for="verified-by">Verified By</label>
                                <input type="text" class="form-control mr-sm-2" id="verified-by" placeholder="verified-by"  name="verified-by" value="{{$risk_assessment_data->verified_by}}">
                            </div>
                            <div class="col form-group">
                                <label for="verify-rank">Rank</label>
                                <select class="form-control" id="verify-rank" name="verify-rank">
                                    <option value="{{$risk_assessment_data->verify_rank}}">{{$risk_assessment_data->verify_rank}}</option>
                                    <option value="1">Select A</option>
                                    <option value="2">Select B</option>
                                    <option value="3">Select C</option>
                                    <option value="4">Select D</option>
                                </select>
                            </div>
                            <div class="col form-group">
                                <label for="reviewed-by">Reviewed By</label>
                                <input type="text" class="form-control" id="reviewed-by" placeholder="reviewed-by" name="reviewed-by" value="{{$risk_assessment_data->reviewed_by}}">
                            </div>
                            <div class="col form-group">
                                <label for="review-rank">Rank</label>
                                <select class="form-control" id="rank" name="rank">
                                    <option value="{{$risk_assessment_data->review_rank}}">{{$risk_assessment_data->review_rank}}</option>
                                    <option value="1">Select A</option>
                                    <option value="2">Select B</option>
                                    <option value="3">Select C</option>
                                    <option value="4">Select D</option>
                                </select>
                            </div>
                       </div>

                       <div class="row mt-3">
                            <div class="col-md-6 col-sm-12 form-group">
                                <label for="linkages">Linkages</label>
                                <textarea  class="form-control" id="linkages" placeholder="linkages"  name="linkages" value="{{$risk_assessment_data->linkages}}" rows="3">{{$risk_assessment_data->linkages}}</textarea>
                            </div>
                    		<div class="col-md-6 col-sm-12 form-group">
                                <label for="comments">Comments</label>
                                <textarea class="form-control" id="comments" rows="3" name="comments" value="{{$risk_assessment_data->comments}}">
                                    {{$risk_assessment_data->comments}}
                                </textarea>
                            </div>
                       </div>

                       <!-- <div class="row pl-3 pr-3 mt-4"><div class="col-sm-12 col-md-12" style="border-bottom: 1px solid #d8d8d8;"></div></div> -->

                       <div class="row mt-3">
                            <div class="col-sm-12 col-md-12 mb-3">
                                <div class="pull-left">
                                    <p style="color: red;" class="m-0">Section 2</p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 table-responsive">
                                <table class="table table-bordered" id="edit_hazard_master_table">
                                    <thead>
                                        <tr>
                                          <th>Action</th>
                                          <th>Reference</th>
                                          <th>Hazard Name</th>                      
                                          <th>Threats</th>
                                          <th>Top Event</th>
                                          <th>Consequence</th>
                                          <th colspan="4" scope="colgroup">Gross Risk Rating</th>
                                          <th>Control</th>
                                          <th>Recovery Measure</th>
                                          <th colspan="4" scope="colgroup">Nett/ Residual Risk Rating</th>
                                          <th>Reduction Measure</th>
                                          <th>Remarks</th>
                                        </tr>
                                        <tr>
                                            <th colspan="6"></th>
                                            <th>P</th>
                                            <th>E</th>
                                            <th>A</th>
                                            <th>R</th>
                                            <th colspan="2"></th>
                                            <th>P</th>
                                            <th>E</th>
                                            <th>A</th>
                                            <th>R</th>
                                            <th colspan="3"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($hazardMasters as $data)
                                            <tr>
                                                <td>
                                                    <button type="button" onclick="edit_b_18_row({{$data->id}} )" class="btn btn-primary">
                                                      <i class="fa fa-edit"></i>
                                                    </button>
                                                </td>
                                                <td>H-{{$data->code}}.0{{$data->ref}}</td>
                                                <td>{{$data->name}}</td>                      
                                                <td>{{$data->threats}}</td>
                                                <td>{{$data->top_event}}</td>
                                                <td>{{$data->consequences}}</td>
                                                <td>{{$data->grr_p}}</td>
                                                <td>{{$data->grr_e}}</td>
                                                <td>{{$data->grr_a}}</td>
                                                <td>{{$data->grr_r}}</td>
                                                <td>{{$data->control}}</td>
                                                <td>{{$data->recovery_measure}}</td>
                                                <td>{{$data->nrr_p}}</td>
                                                <td>{{$data->nrr_e}}</td>
                                                <td>{{$data->nrr_a}}</td>
                                                <td>{{$data->nrr_r}}</td>
                                                <td>{{$data->reduction_measure}}</td>
                                                <td>{{$data->remarks}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                       </div>

                       <div class="row mt-5">
                            <div class="col-md-4"></div>
                    		<div class="col-md-4" style="text-align:center;">
                    			<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">	
                       			<button class="btn btn-primary w-100" type="submit" name="submit">Submit</button>
                    		</div>
                            <div class="col-md-4"></div>
                       </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('modals.custom.riskAssessment.modal-edit-second-risk-section-row')

@endsection


@section('footer_scripts') 
    <script>
        let b_18_form_rows = {!! json_encode($hazardMasters) !!};
        let risk_matrix = {!! json_encode($risk_matrix) !!};

        function edit_b_18_row(rowId){
            let selectedRowData = b_18_form_rows.filter(data=> data.id == rowId);
            let grr_p_options;
            let grr_e_options;
            let grr_a_options;
            let grr_r_options;

            let nrr_p_options;
            let nrr_e_options;
            let nrr_a_options;
            let nrr_r_options;

            selectedRowData = selectedRowData[0];
            console.log(selectedRowData);
            $("#id").val(selectedRowData.id);
            $("#edit-reference").html(`H-${selectedRowData.code}`);
            $("#edit-hazard-name").html(selectedRowData.name);
            $("#edit-threats").html(selectedRowData.threats).val(selectedRowData.threats);
            $("#edit-top-events").html(selectedRowData.top_event).val(selectedRowData.top_event);
            $("#edit-consequence").html(selectedRowData.consequences).val(selectedRowData.consequences);
            for(let i=0; i<risk_matrix.length; i++){
                //For GRR
                if(risk_matrix[i].code == selectedRowData.grr_p){
                    grr_p_options +=    `<option value="${risk_matrix[i].code}" style="background: ${risk_matrix[i].hex_code};" selected>
                                            ${risk_matrix[i].code}
                                        </option>`;
                    $("#edit-grr-p").css('background', `${risk_matrix[i].hex_code}`);
                }
                else{
                    grr_p_options +=    `<option value="${risk_matrix[i].code}" style="background: ${risk_matrix[i].hex_code};">
                                            ${risk_matrix[i].code}
                                        </option>`
                }

                if(risk_matrix[i].code == selectedRowData.grr_e){
                    grr_e_options +=    `<option value="${risk_matrix[i].code}" style="background: ${risk_matrix[i].hex_code};" selected>
                                            ${risk_matrix[i].code}
                                        </option>`;
                    $("#edit-grr-e").css('background', `${risk_matrix[i].hex_code}`);
                }
                else{
                    grr_e_options +=    `<option value="${risk_matrix[i].code}" style="background: ${risk_matrix[i].hex_code};">
                                            ${risk_matrix[i].code}
                                        </option>`
                }

                if(risk_matrix[i].code == selectedRowData.grr_a){
                    grr_a_options +=    `<option value="${risk_matrix[i].code}" style="background: ${risk_matrix[i].hex_code};" selected>
                                            ${risk_matrix[i].code}
                                        </option>`;
                    $("#edit-grr-a").css('background', `${risk_matrix[i].hex_code}`);
                }
                else{
                    grr_a_options +=    `<option value="${risk_matrix[i].code}" style="background: ${risk_matrix[i].hex_code};">
                                            ${risk_matrix[i].code}
                                        </option>`
                }

                if(risk_matrix[i].code == selectedRowData.grr_r){
                    grr_r_options +=    `<option value="${risk_matrix[i].code}" style="background: ${risk_matrix[i].hex_code};" selected>
                                            ${risk_matrix[i].code}
                                        </option>`;
                    $("#edit-grr-r").css('background', `${risk_matrix[i].hex_code}`);
                }
                else{
                    grr_r_options +=    `<option value="${risk_matrix[i].code}" style="background: ${risk_matrix[i].hex_code};">
                                            ${risk_matrix[i].code}
                                        </option>`
                }

                //For NRR
                if(risk_matrix[i].code == selectedRowData.nrr_p){
                    nrr_p_options +=    `<option value="${risk_matrix[i].code}" style="background: ${risk_matrix[i].hex_code};" selected>
                                            ${risk_matrix[i].code}
                                        </option>`;
                    $("#edit-nrr-p").css('background', `${risk_matrix[i].hex_code}`);
                }
                else{
                    nrr_p_options +=    `<option value="${risk_matrix[i].code}" style="background: ${risk_matrix[i].hex_code};">
                                            ${risk_matrix[i].code}
                                        </option>`
                }

                if(risk_matrix[i].code == selectedRowData.nrr_e){
                    nrr_e_options +=    `<option value="${risk_matrix[i].code}" style="background: ${risk_matrix[i].hex_code};" selected>
                                            ${risk_matrix[i].code}
                                        </option>`;
                    $("#edit-nrr-e").css('background', `${risk_matrix[i].hex_code}`);
                }
                else{
                    nrr_e_options +=    `<option value="${risk_matrix[i].code}" style="background: ${risk_matrix[i].hex_code};">
                                            ${risk_matrix[i].code}
                                        </option>`
                }

                if(risk_matrix[i].code == selectedRowData.nrr_a){
                    nrr_a_options +=    `<option value="${risk_matrix[i].code}" style="background: ${risk_matrix[i].hex_code};" selected>
                                            ${risk_matrix[i].code}
                                        </option>`;
                    $("#edit-nrr-a").css('background', `${risk_matrix[i].hex_code}`);
                }
                else{
                    nrr_a_options +=    `<option value="${risk_matrix[i].code}" style="background: ${risk_matrix[i].hex_code};">
                                            ${risk_matrix[i].code}
                                        </option>`
                }

                if(risk_matrix[i].code == selectedRowData.nrr_r){
                    nrr_r_options +=    `<option value="${risk_matrix[i].code}" style="background: ${risk_matrix[i].hex_code};" selected>
                                            ${risk_matrix[i].code}
                                        </option>`;
                    $("#edit-nrr-r").css('background', `${risk_matrix[i].hex_code}`);
                }
                else{
                    nrr_r_options +=    `<option value="${risk_matrix[i].code}" style="background: ${risk_matrix[i].hex_code};">
                                            ${risk_matrix[i].code}
                                        </option>`
                }
            }
            $("#edit-grr-p").html(grr_p_options);
            $("#edit-grr-e").html(grr_e_options);
            $("#edit-grr-a").html(grr_a_options);
            $("#edit-grr-r").html(grr_r_options);

            $("#edit-nrr-p").html(nrr_p_options);
            $("#edit-nrr-e").html(nrr_e_options);
            $("#edit-nrr-a").html(nrr_a_options);
            $("#edit-nrr-r").html(nrr_r_options);

            $("#edit-control").html(selectedRowData.control);
            $("#edit-recovery-measure").html(selectedRowData.recovery_measure);
            $("#edit-reduction-measure").html(selectedRowData.reduction_measure);
            $("#edit-remarks").html(selectedRowData.remarks);
            $("#editSetion2Row").modal('show');
        }

        function saveSection2Row(){
            console.log($('#id').val());
            console.log($("#section2EditRowForm").serializeArray());
        }

        $(".risk_select").change(function(){
            var color = $("option:selected", this).css( "background-color" );
            $(this).css("background-color", color);
        });
    </script>  
	<!-- <script type="text/javascript" src="\js\custom\risk_assessment.js"></script> -->
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" 
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" 
        crossorigin="anonymous"></script> -->
    <!-- <script type="text/javascript" src="\js\custom\RiskAssessment\index.js"></script> -->
    <!-- <script type="text/javascript" src="\js\custom\toastr\notificationMessage.js"></script>   -->
    <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.js"></script> -->

    <!-- <script type="text/javascript" src="\js\custom\toastr\toastr.min.js"></script> -->
    <!-- <script type="text/javascript" src="\js\custom\toastr\notificationMessage.js"></script> -->
@endsection