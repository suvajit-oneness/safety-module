<div class="modal fade modal-md modal-top" id="AddRowModal" name="AddRowModal"  data-backdrop="static" data-keyboard="false"  role="dialog" aria-labelledby="AddRowModalLabel" style="padding:5px,margin:5px,width=80vh">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="text-center" id="AddRowModalLabel">Section 1</h4>
      </div>
      <div class="modal-body" >
        <div class="container-fluid">
            <input type = "hidden" name = "section_2_row_index" id="section_2_row_index" value = "">
            <!-- Drop down selection from hazard-list table and set reference no-->
            <div class="row mb-3">
                  <div class="col-md-3">
                      <label for="hazard-name" class="mr-sm-2 mt-1">Hazard Type<font color="red" size="5px">*</font></label>
                  </div>
                  <div class="col-md-9">
                      <select class="form-control mr-sm-2" id="hazards-name" name="hazards-name" required>
                          <option value="">Select a Hazard Type</option>
                          @foreach($filledHazards as $filledHazard)
                            <option value="{{$filledHazard->id}}">{{$filledHazard->name}}</option>
                          @endforeach
                      </select>            
                  </div>      
            </div>
            <!-- Drop down selection from hazard-list table -->
            <div class="row mb-3" >
                  <div class="col-md-3">
                      <label for="hazards_no" id="hazards_no" class="mr-sm-2 mt-1" style = "display:none;" >Hazard No<font color="red" size="5px" >*</font></label>
                  </div>
                  <div class="col-md-9">
                        <select class="form-control mr-sm-2" id="hazards_subtype" name="hazards_subtype" required  style="word-wrap: break-word;white-space: normal;height: 100px; display : none;" >
                            <option value="">Select a Hazard Type First</option>
                            @foreach($filledHazards as $filledHazard)
                               <option title="{{$filledHazard->name}}" value="{{$filledHazard->id}}">
                                {{$filledHazard->code}} {{$filledHazard->name}} 
                              </option>
                            @endforeach
                        </select>   
                       
                  </div> 
            </div>
            <div class="row mb-3">
                  <div class="col-md-3">
                      <label for="source" class="mr-sm-2 mt-1">Area/Source</label>
                  </div>
                  <div class="col-md-9">
                      <input class="form-control" id="source" name="source" value="" readonly="readonly"/>
                  </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="consequences" class="mr-sm-2 mt-1">Impact:</label>
                </div>
                <div class="col-md-9">
                    <textarea class="form-control" id="consequences" placeholder="Enter Consequences" rows="3" name="consequences" readonly="readonly" disabled></textarea> 
                </div>
            </div>
            <div class="row mb-3">
                  <div class="col-md-3">
                      <label for="event" class="mr-sm-2 mt-1">Job/Event</label>
                  </div>
                  <div class="col-md-9">
                      <textarea class="form-control" id="event" placeholder="Enter Job/event" rows="3" name="event"></textarea> 
                      <!-- <textrea class="form-control" id="event" name="event" rows="3"></textarea> -->
                  </div>
            </div>

            <!-- risk rating dropdowns -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="mr-sm-2 mt-1">Risk Rating:</label>
                    <br>
                    <button class="btn btn-primary" onclick="openRiskMatrix()">View Matrix</button>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <label for="lkh1">Likelihood</label>
                            <select class="form-control risk_select" id="lkh1" name="lkh1">
                               <option value="">--Select--</option>
                               <option value="1">1</option>
                               <option value="2">2</option>
                               <option value="3">3</option>
                               <option value="4">4</option>
                               <option value="5">5</option>
                            </select>
                        </div>
                        <div class="col-md-3 text-center">
                            <label for="svr1">Severity</label>
                            <select class="form-control risk_select" id="svr1" name="svr1">
                               <option value="">--Select--</option>
                               <option value="1">1</option>
                               <option value="2">2</option>
                               <option value="3">3</option>
                               <option value="4">4</option>
                               <option value="5">5</option>
                            </select>
                        </div>
                        <div class="col-md-3 text-center">
                            <label for="rf1">Risk Factor</label>
                            <input class="form-control" id="rf1" name="rf1" value="" readonly="readonly"/>
                        </div> 
                        <div class="col-md-3">
                            <label for="rf1_label" id="rf1_label" style="margin-top: 20%;"></label>                            
                        </div>                                   
                    </div>           
                </div>
            </div>
              
            <!-- other fields -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="control_measure" class="mr-sm-2 mt-1">Control Measure:</label>
                </div>
                <div class="col-md-9">
                    <textarea class="form-control summernote" id="control_measure" placeholder="Enter Control Measures" rows="3" name="control_measure"></textarea>
                </div>
            </div>

      <!-- <div class="row mb-3">
                <div class="col-md-3">
                    <label for="recovery_measure" class="mr-sm-2 mt-1">Recovery Measure:</label>
                </div>
                <div class="col-md-9">
                    <textarea class="form-control summernote" id="recovery_measure" placeholder="Enter Recovery Measures" rows="3" name="recovery_measure"></textarea>
                </div>
            </div> -->

            <!--nett/residual risk rating dropdowns -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="mr-sm-2 mt-1">Residual Risk:</label>
                    <br>
                    <button class="btn btn-primary" onclick="openRiskMatrix()">View Matrix</button>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <label for="lkh2">Likelihood</label>
                            <select class="form-control risk_select" id="lkh2" name="lkh2">
                               <option value="">--Select--</option>
                               <option value="1">1</option>
                               <option value="2">2</option>
                               <option value="3">3</option>
                               <option value="4">4</option>
                               <option value="5">5</option>
                            </select>
                        </div>
                        <div class="col-md-3 text-center">
                            <label for="svr2">Severity</label>
                            <select class="form-control risk_select" id="svr2" name="svr2">
                               <option value="">--Select--</option>
                               <option value="1">1</option>
                               <option value="2">2</option>
                               <option value="3">3</option>
                               <option value="4">4</option>
                               <option value="5">5</option>
                            </select>
                        </div>
                        <div class="col-md-3 text-center">
                            <label for="rf2">Risk Factor</label>
                            <input class="form-control" id="rf2" name="rf2" value="" readonly="readonly"/>
                        </div> 
                        <div class="col-md-3">
                            <label for="rf2_label" id="rf2_label" style="margin-top: 20%;"></label>                            
                        </div>  
                       <!--  <div class="col-md-3 text-center">
                            <label for="add_control">Additional Control</label>
                            <input class="form-control" id="add_control" name="add_control" value="" readonly="readonly"/> 
                            <textarea class="form-control summernote" id="add_control" name="add_control"></textarea>
                        </div>  -->                                    
                    </div>           
                </div>
            </div>
             <div class="row mb-3">
                <div class="col-md-3">
                    <label for="add_control" class="mr-sm-2 mt-1">Additional Control</label>
                </div>
                <div class="col-md-9">
                    <input class="form-control" id="acFlag" name="acFlag" value="" style="display:none;"/> 
                    <textarea class="form-control" id="add_control" placeholder="Enter Additional Control" rows="3" name="a_c"></textarea>

                </div>
            </div>

            <div class="text-center">
                 
                <button type="button" class="btn btn-primary" onclick="saveSection2()" class="cursor-pointer">
                    Ok
                </button>
                <button class="btn btn-danger" onclick="closeModal()" class="close cursor-pointer" >
                    Close
                </button>
            </div>

        </div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
