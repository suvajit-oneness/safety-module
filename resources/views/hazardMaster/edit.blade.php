@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <div class="breadcrumb breadcrumb-custom-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h1>Edit Hazard Master Form</h1>
{{--    <div class="row" style="min-width: 300px;">
          <div class="col-md-12 col-sm-12 form-group">
            <label for="reference" style="font-size: 20px !important; border-right: 2px solid black; line-height: 17px; padding-right: 8px; font-weight: 600;">Reference</label>
            <label id="reference" style="font-size: 20px !important; font-weight: 600; padding-left: 8px;">H-0{{$hazard_master_details->hazard_id}}.0{{$hazard_master_details->ref}}</label>
          </div>
        </div>  --}}
      </div>
      <div class="row">
        <div class="col-md-12 col-sm-12">
          <form method="post" action="{{url('/hazard-master-update').'/'.$hazard_master_details->id}}" class="form" id="hazard_master_form">

            <input class="form-control" id="reference_hidden" name="reference_hidden" value="{{$hazard_master_details->ref}}" hidden></input>

            <!-- Drop down selection from hazard-list table and set reference no-->
            <div class="row mb-3">
              <div class="col-md-6 col-sm-6 form-group">
                <label for="hazard-name">Hazard Type</label>
                <input type="text" class="form-control mr-sm-2" id="hazards-name" readonly="readonly" name="hazards-name" value="{{$hazard_name}}"> 
              </div>

              <div class="col-md-6 col-sm-6 form-group">
                <label for="hazard_title">Vessel Name</label>
              <input class="form-control" id="vessel_name" name="vessel_name" value="{{$hazard_master_details->vessel_name}}"></input> 
              </div>
            </div>

            <!-- Drop down selection from hazard-list table -->
             <div class="row mb-3">
                <div class="col-md-4 col-sm-8 form-group">
                  <label for="hazard">Hazard No</label>
                  <textarea class="form-control" id="hazard_no" rows="3" name="hazard_no" value="{{$hazard_master_details->hazard_no}}">{{$hazard_master_details->hazard_no}}</textarea>
                </div>

                <div class="col-md-4 col-sm-8 form-group">
                  <label for="threats">Area / Source</label>
                  <textarea class="form-control" id="source" rows="3" name="source" value="{{$hazard_master_details->source}}">{{$hazard_master_details->source}}</textarea>
                </div>

                <div class="col-md-4 col-sm-8 form-group">
                  <label for="threats">Life Cycle</label>
                  <textarea class="form-control" id="life_cycle" rows="3" name="life_cycle" value="{{$hazard_master_details->life_cycle}}">{{$hazard_master_details->life_cycle}}</textarea>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 col-sm-8 form-group">
                  <label for="hazard_details">Hazard Details</label>
                  <textarea class="form-control" id="hazard_details" rows="3" name="hazard_details" value="{{$hazard_master_details->hazard_details}}">{{$hazard_master_details->hazard_details}}</textarea>
                </div>
                <div class="col-md-4 col-sm-8 form-group">
                  <label for="causes">Causes</label>
                  <textarea class="form-control" id="causes" rows="3" name="causes" value="{{$hazard_master_details->causes}}">{{$hazard_master_details->causes}}</textarea>
                </div>

                <div class="col-md-4 col-sm-8 form-group">
                  <label for="impact">Impact</label>
                  <textarea class="form-control" id="impact" rows="3" name="impact" value="{{$hazard_master_details->impact}}">{{$hazard_master_details->impact}}</textarea>
                </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-4 col-sm-8 form-group">
                  <label for="applicable_permits">Applicable Permit/s</label>
                  <textarea class="form-control" id="applicable_permits" rows="3" name="applicable_permits" value="{{$hazard_master_details->applicable_permits}}">{{$hazard_master_details->applicable_permits}}</textarea>
              </div>

              <div class="col-md-4 col-sm-8 form-group">
                  <label for="review">Review Comments</label>
                  <textarea class="form-control" id="review" rows="3" name="review" value="{{$hazard_master_details->review}}">{{$hazard_master_details->review}}</textarea>
              </div>

              <div class="col-md-4 col-sm-8 form-group">
                  <label for="situation">Situation Routine/Non-Routine</label>                 
                  <select class="form-control risk_select" id="situation" name="situation">
                    <option value="">--Select--</option>
                    <option value="Routine" <?php echo ($hazard_master_details->situation == 'Routine')?"selected":"" ?>>Routine</option>
                    <option value="Non-Routine" <?php echo ($hazard_master_details->situation == 'Non-Routine')?"selected":"" ?>>Non-Routine</option>
                  </select>
              </div>
            </div> 

            <!-- risk rating dropdowns -->
            <div class="row mb-3">
              <div class="col-md-12 col-sm-12 form-group" style="margin-bottom: 3px !important;">
                <label >Initial Risk</label>                
              </div>
              <div class="col-md-3">
                <label >Severity</label>
                <select class="form-control risk_select" id="ir_severity" name="ir_severity" onchange="ir_prod()">
                 <option value="">--Select--</option>
                 <option value="1" <?php echo ($hazard_master_details->ir_severity == '1')?"selected":"" ?>>1</option>
                 <option value="2" <?php echo ($hazard_master_details->ir_severity == '2')?"selected":"" ?>>2</option>
                 <option value="3" <?php echo ($hazard_master_details->ir_severity == '3')?"selected":"" ?>>3</option>
                 <option value="4" <?php echo ($hazard_master_details->ir_severity == '4')?"selected":"" ?>>4</option>
                 <option value="5" <?php echo ($hazard_master_details->ir_severity == '5')?"selected":"" ?>>5</option>             
          {{--   @foreach($risk_matrices_details as $risk)              
                 @if($risk->code == $hazard_master_details->ir_severity)
                    <option value="{{$risk->code}}" selected>{{$risk->code}}</option>
                    <?php
                      $ir_severity = $risk->hex_code;
                    ?>
                  @else
                    <option value="{{$risk->code}}" >{{$risk->code}}</option>
                  @endif
                 @endforeach   --}}
                </select> 
              </div>              
              <div class="col-md-3">
                <label >Likelihood</label>
                <select class="form-control risk_select" id="ir_likelihood" name="ir_likelihood" onchange="ir_prod()">
                 <option value="">--Select--</option>
                 <option value="1" <?php echo ($hazard_master_details->ir_likelihood == '1')?"selected":"" ?>>1</option>
                 <option value="2" <?php echo ($hazard_master_details->ir_likelihood == '2')?"selected":"" ?>>2</option>
                 <option value="3" <?php echo ($hazard_master_details->ir_likelihood == '3')?"selected":"" ?>>3</option>
                 <option value="4" <?php echo ($hazard_master_details->ir_likelihood == '4')?"selected":"" ?>>4</option>
                 <option value="5" <?php echo ($hazard_master_details->ir_likelihood == '5')?"selected":"" ?>>5</option>
      {{--           @foreach($risk_matrices_details as $risk)
                   @if($risk->code == $hazard_master_details->ir_likelihood)
                    <option value="{{$risk->code}}" selected>{{$risk->code}}</option>
                    <?php
                      $ir_likelihood = $risk->hex_code;
                    ?>
                  @else
                    <option value="{{$risk->code}}" >{{$risk->code}}</option>
                  @endif
                 @endforeach  --}}
                </select> 
              </div>
              <div class="col-md-3">
                <label>Risk Rating</label> 
                <input class="form-control" id="ir_risk_rating" name="ir_risk_rating" readonly="readonly" value="{{$hazard_master_details->ir_risk_rating}}"></input>
              </div>               
            </div>
            <div class="row mb-3">
              <div  class="col-md-6 col-sm-12 form-group">
                <label for="control_barrier">Control Measures</label>
                <textarea class="form-control" id="control" rows="3" name="control" value="{{$hazard_master_details->control}}">{{$hazard_master_details->control}}</textarea>
              </div>
            </div>
            
            <!--nett/residual risk rating dropdowns -->
            <div class="row mb-3">
              <div class="col-md-12 col-sm-12 form-group" style="margin-bottom: 3px !important;">
                <label>Residual Risk</label>                
              </div>
              <div class="col-md-3">
              <label >Severity</label>
                <select class="form-control risk_select" id="rr_severity" name="rr_severity" onchange="rr_prod()">
                 <option value="">--Select--</option>
                 <option value="1" <?php echo ($hazard_master_details->rr_severity == '1')?"selected":"" ?>>1</option>
                 <option value="2" <?php echo ($hazard_master_details->rr_severity == '2')?"selected":"" ?>>2</option>
                 <option value="3" <?php echo ($hazard_master_details->rr_severity == '3')?"selected":"" ?>>3</option>
                 <option value="4" <?php echo ($hazard_master_details->rr_severity == '4')?"selected":"" ?>>4</option>
                 <option value="5" <?php echo ($hazard_master_details->rr_severity == '5')?"selected":"" ?>>5</option>
    {{--            @foreach($risk_matrices_details as $risk)
                    @if($risk->code == $hazard_master_details->rr_severity)
                      <option value="{{$risk->code}}" selected>{{$risk->code}}</option>
                      <?php
                        $rr_severity = $risk->hex_code;
                      ?>
                    @else
                      <option value="{{$risk->code}}" >{{$risk->code}}</option>
                    @endif
                  @endforeach  --}}
                </select>
              </div>
              <div class="col-md-3">
              <label>Likelihood</label>
                <select class="form-control risk_select" id="rr_likelihood" name="rr_likelihood" onchange="rr_prod()">
                <option value="">--Select--</option>
                <option value="1" <?php echo ($hazard_master_details->rr_likelihood == '1')?"selected":"" ?>>1</option>
                <option value="2" <?php echo ($hazard_master_details->rr_likelihood == '2')?"selected":"" ?>>2</option>
                <option value="3" <?php echo ($hazard_master_details->rr_likelihood == '3')?"selected":"" ?>>3</option>
                <option value="4" <?php echo ($hazard_master_details->rr_likelihood == '4')?"selected":"" ?>>4</option>
                <option value="5" <?php echo ($hazard_master_details->rr_likelihood == '5')?"selected":"" ?>>5</option>
   {{--             @foreach($risk_matrices_details as $risk)
                    @if($risk->code == $hazard_master_details->rr_likelihood)
                      <option value="{{$risk->code}}" selected>{{$risk->code}}</option>
                      <?php
                        $rr_likelihood = $risk->hex_code;
                      ?>
                    @else
                      <option value="{{$risk->code}}" >{{$risk->code}}</option>
                    @endif
                  @endforeach --}}
                </select>
              </div>
              <div class="col-md-3">
               <label>Risk Rating</label> 
               <input class="form-control" id="rr_risk_rating" name="rr_risk_rating" readonly="readonly" value="{{$hazard_master_details->rr_risk_rating}}"></input>
              </div>               
             </div>          

            <!-- other fields -->
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
</div>
@endsection

@section('footer_scripts')   
  <script type="text/javascript" src="\js\custom\HazardMaster\hazard_master_edit.js"></script>
  <script>
   {{-- let risk_p = "<?php echo($risk_p)?>";$("#risk_p").css("background-color", risk_p);
    let risk_e = "<?php echo($risk_e)?>";$("#risk_e").css("background-color", risk_e);
    let risk_a = "<?php echo($risk_a)?>";$("#risk_a").css("background-color", risk_a);
    let risk_r = "<?php echo($risk_r)?>";$("#risk_r").css("background-color", risk_r);

    let nett_risk_p = "<?php echo($nett_risk_p)?>";$("#nett_risk_p").css("background-color", nett_risk_p);
    let nett_risk_e = "<?php echo($nett_risk_e)?>";$("#nett_risk_e").css("background-color", nett_risk_e);
    let nett_risk_a = "<?php echo($nett_risk_a)?>";$("#nett_risk_a").css("background-color", nett_risk_a);
    let nett_risk_r = "<?php echo($nett_risk_r)?>";$("#nett_risk_r").css("background-color", nett_risk_r); --}}
  </script>
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
@endsection