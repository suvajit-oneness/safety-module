@extends('layouts.app')
@section('template_linked_css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    
  <link href="/css/summernote/summernote.css" rel="stylesheet"> 
  
@endsection
@section('content')
 <div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <div class="breadcrumb breadcrumb-custom-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h1>Add new Hazard Master Form</h1>     
   {{-- <div class="row" style="min-width: 300px;">
          <div class="col-md-12 col-sm-12 form-group">
            <label for="reference" style="font-size: 20px !important; border-right: 2px solid black; line-height: 17px; padding-right: 8px; font-weight: 600;">Reference</label>
            <label id="reference" style="font-size: 20px !important; font-weight: 600; padding-left: 8px;"></label>
          </div>
        </div>  --}}
      </div>
      <div class="row">
        <div class="col-md-12 col-sm-12">
          <form method="post" action="hazard-master-submit" class="form" id="hazard_master_form">

            <input class="form-control" id="reference_hidden" name="reference_hidden" value="" hidden></input>

            <!-- Drop down selection from hazard-list table and set reference no-->
            <div class="row mb-3">
                <div class="col-md-12 col-sm-12 form-group">
                    <label for="hazard-name">Hazard Type<font style="color: red;font-size: 25px">*</font></label>
                    <select class="form-control mr-sm-2" id="hazards-name" name="hazards-name" required>
                        <option value="">Select a hazard type</option>
                        @foreach($hazards_list as $hazard)
                            <option value="{{$hazard->id}}">{{$hazard->name}}</option>
                        @endforeach
                    </select>            
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 col-sm-12 form-group">
                  <label for="vessel_name">Vessel Name</label>
                  <input class="form-control" id="vessel_name" name="vessel_name" value="" placeholder="Enter Vessel Name"></input>
                </div>
            </div> 

            <!-- Drop down selection from hazard-list table -->
             <div class="row mb-3">
                <div class="col-md-4 col-sm-8 form-group">
                  <label for="hazard">Hazard No</label>
                  <textarea class="form-control summernote" id="hazard_no" rows="3" placeholder="Enter hazard no" name="hazard_no"></textarea>
                </div>

                <div class="col-md-4 col-sm-8 form-group">
                  <label for="threats">Area / Source</label>
                  <textarea class="form-control summernote" id="source" rows="3" placeholder="Enter area or sources" name="source"></textarea>
                </div>

                <div class="col-md-4 col-sm-8 form-group">
                  <label for="threats">Life Cycle</label>
                  <textarea class="form-control summernote" id="life_cycle" rows="3" placeholder="Enter life cycle" name="life_cycle"></textarea>
                </div>
            </div>

            <!-- Drop down selection from hazard-list table -->
             <div class="row mb-3">
                <div class="col-md-4 col-sm-8 form-group">
                  <label for="hazard">Hazard Details</label>
                  <textarea class="form-control summernote" id="hazard_details" rows="3" placeholder="Enter hazard details" name="hazard_details"></textarea>
                </div>
                <div class="col-md-4 col-sm-8 form-group">
                  <label for="causes">Causes</label>
                  <textarea class="form-control summernote" id="causes" rows="3" placeholder="Enter hazard causes" name="causes"></textarea>
                </div>
                <div class="col-md-4 col-sm-8 form-group">
                  <label for="threats">Impact</label>
                  <textarea class="form-control summernote" id="impact" rows="3" placeholder="Enter impact" name="impact"></textarea>
                </div>
            </div>


           <div class="row mb-3">
              <div class="col-md-4 col-sm-8 form-group">
                  <label for="top_event">Applicable Permit/s</label>
                  <textarea class="form-control summernote" id="applicable_permits" rows="3" placeholder="Enter applicable permits" name="applicable_permits"></textarea>
              </div>

              <div class="col-md-4 col-sm-8 form-group">
                  <label for="consequences">Review Comments</label>
                  <textarea class="form-control summernote" id="review" rows="3" placeholder="Enter review" name="review"></textarea>
              </div>

              <div class="col-md-4 col-sm-8 form-group">
                  <label for="consequences">Situation</label>                  
                  <select class="form-control risk_select" id="situation" name="situation">
                    <option value="">--Select--</option>
                    <option value="Routine">Routine</option>
                    <option value="Non-Routine">Non-Routine</option>
                  </select>
              </div>
            </div> 

            <!-- risk rating dropdowns -->
            <div class="row mb-3">
                <div class="col-md-12 col-sm-12 form-group" style="margin-bottom: 3px !important;">
                  <label >Initial Risk</label>
                
                  <button class="btn btn-primary ml-1" type="button" onclick="openRiskMatrix()">View Matrix</button>
                </div>
                <div class="col-md-3">
                 <label >Severity</label>
                  <select class="form-control risk_select" id="ir_severity" name="ir_severity" onchange ="ir_prod()" required>
                    <option value="">--Select--</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    {{--   @foreach($risk_matrices as $risk)
                    <option value="{{$risk->code}}">{{$risk->code}}</option>
                    @endforeach --}}
                  </select>
                </div>
                <div class="col-md-3">
                  <label >Likelihood</label>
                  <select class="form-control risk_select" id="ir_likelihood" name="ir_likelihood" onchange ="ir_prod()" required>
                    <option value="">--Select--</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    {{--   @foreach($risk_matrices as $risk)
                    <option value="{{$risk->code}}">{{$risk->code}}</option>
                    @endforeach  --}}
                  </select>
                </div>
                <div class="col-md-3">
                  <label>Risk Rating</label> 
                  <input class="form-control" id="ir_risk_rating" name="ir_risk_rating" value=""  readonly="readonly" required>
                </div>              
            </div>
            <div class="row mb-3">
              <div  class="col-md-6 col-sm-12 form-group">
                <label for="control_barrier">Control Measures</label>
                <textarea class="form-control summernote" id="control" rows="3" placeholder="Enter control measures" name="control"></textarea>
              </div>
            </div>
        <!--   <div class="col-md-3">
                <label >Asset</label>
                <select class="form-control risk_select" id="risk_a" name="risk_a">
                <option value="">--Select--</option>
                 @foreach($risk_matrices as $risk)
                 <option value="{{$risk->code}}" style="background-color:{{$risk->hex_code}}">{{$risk->code}}</option>
                 @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <label >Reputation</label>
                <select class="form-control risk_select" id="risk_r" name="risk_r">
                  <option value="">--Select--</option>
                  @foreach($risk_matrices as $risk)
                    <option value="{{$risk->code}}" style="background-color:{{$risk->hex_code}}">{{$risk->code}}</option>
                  @endforeach
                </select> 
              </div> -->
           
            
            <!-- other fields -->
           <!--  <div class="row mb-3">
              <div  class="col-md-6 col-sm-12 form-group">
                <label for="control_barrier">Control Barrier</label>
                <textarea class="form-control" id="control_barrier" rows="3" placeholder="Enter control barrier" name="control_barrier"></textarea>
              </div>

               <div class="col-md-6 col-sm-12 form-group">
                <label for="recovery_measure" class="mr-sm-2 mt-1">Recovery Measure</label>
                <textarea class="form-control" id="recovery_measure" rows="3" placeholder="Enter recovery measure" name="recovery_measure"></textarea>
              </div> 
            </div> -->

            <!--nett/residual risk rating dropdowns -->
            <div class="row mb-3">
                  <div class="col-md-12 col-sm-12 form-group" style="margin-bottom: 3px !important;">
                    <label>Residual Risk</label>
                
                    <button class="btn btn-primary ml-1" type="button" onclick="openRiskMatrix()">View Matrix</button>
                  </div>
                  <div class="col-md-3">
                    <label >Severity</label>
                    <select class="form-control risk_select" id="rr_severity" name="rr_severity" onchange ="rr_prod()" required>
                      <option value="">--Select--</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      {{--  @foreach($risk_matrices as $risk)
                      <option value="{{$risk->code}}">{{$risk->code}}</option>
                      @endforeach   --}}
                    </select>
                  </div>
                  <div class="col-md-3">
                    <label>Likelihood</label>
                    <select class="form-control risk_select" id="rr_likelihood" name="rr_likelihood" onchange="rr_prod()" required>
                      <option value="">--Select--</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    {{--  @foreach($risk_matrices as $risk)
                    <option value="{{$risk->code}}" >{{$risk->code}}</option>
                    @endforeach   --}}
                    </select>
                  </div> 
                  <div class="col-md-3">
                    <label>Risk Rating</label> 
                    <input class="form-control" id="rr_risk_rating" name="rr_risk_rating" value=''  readonly="readonly" required>
                  </div>            
            </div>
            
          <!--     <div class="col-md-3">
              <label >Asset</label>
                <select class="form-control risk_select" id="nett_risk_a" name="nett_risk_a">
                <option value="">--Select--</option>
                 @foreach($risk_matrices as $risk)
                 <option value="{{$risk->code}}" style="background-color:{{$risk->hex_code}}">{{$risk->code}}</option>
                 @endforeach
                </select>
              </div>
              <div class="col-md-3">
              <label >Reputation</label>
                <select class="form-control risk_select" id="nett_risk_r" name="nett_risk_r">
                  <option value="">--Select--</option>
                  @foreach($risk_matrices as $risk)
                    <option value="{{$risk->code}}" style="background-color:{{$risk->hex_code}}">{{$risk->code}}</option>
                  @endforeach
                </select>
              </div> -->
           
            <!-- other fields -->
        <!--     <div class="row mb-3">
              <div class="col-md-6 col-sm-12 form-group">
                <label for="reduction_measure" class="mr-sm-2 mt-1">Further Risk Reduction Measure:</label>
                <textarea class="form-control" id="reduction_measure" rows="3" placeholder="Enter reduction measure" name="reduction_measure"></textarea>
              </div>

              <div class="col-md-6 col-sm-12 form-group">
                <label for="Remarks" class="mr-sm-2 mt-1">Remarks</label>
                <textarea class="form-control" id="remarks" rows="3" placeholder="Enter remarks" name="remarks"></textarea>
              </div>
            </div> -->

            <div class="row mt-5">
              <div class="col-md-4"></div>
              <div class="col-md-4">
                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>"> 
                <button class="btn btn-primary" type="submit" name="submit" style="width: 100%;">Submit</button>
              </div>
              <div class="col-md-4"></div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div> -->
@include('modals.custom.risk-matrix-modal')
@endsection

@section('footer_scripts')   
	<script type="text/javascript" src="\js\custom\HazardMaster\hazard_master_create.js"></script>
  <script type="text/javascript">
        function ir_prod() {
            let ir_severity = document.getElementById("ir_severity").value;            
            let ir_likelihood = document.getElementById('ir_likelihood').value;

            var result = parseInt(ir_severity) * parseInt(ir_likelihood);
            if (!isNaN(result)) {
                document.getElementById('ir_risk_rating').value = result;
            }
        }

        function rr_prod() {
            let rr_severity = document.getElementById("rr_severity").value;            
            let rr_likelihood = document.getElementById('rr_likelihood').value;

            var result = parseInt(rr_severity) * parseInt(rr_likelihood);
            if (!isNaN(result)) {
                document.getElementById('rr_risk_rating').value = result;
            }
        }
    </script>
    <script type="text/javascript" src="/js/summernote/summernote.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
      $('.summernote').summernote({
        toolbar: true
      });
    });
    </script>
@endsection
