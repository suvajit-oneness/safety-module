<!-- Section 2 -->
<div class="row mt-3">
    <div class="col-6">
        <h2>Section 2-Additional Control</h2>
        <table class="table table-bordered datatable mt-2">
            <thead>
                <th title="No">No</th>
                <th colspan="4">To be completed by Office</th>
            </thead>
            <tbody id="section2Body">
                @php
                    $row_count = 0;
                @endphp                
                @if(isset($templateData))
                    @foreach($templateData as $data)
                        @php
                            $row_count++;
                        @endphp
                        <tr id="row_{{$row_count}}">
                           <td>{{$row_count}}</td>
                           <td colspan="3">                               
                                @if(isset($data->additional_control) && $data->additional_control)
                                  <input type="text" class="form-control mr-sm-2" id="additional_control_{{$row_count}}" placeholder="Enter additional control" name="additional_control_{{$row_count}}" value="{{$data->additional_control}}" onchange="add_value({{$row_count}})">
                                @else
                                    <input type="text" class="form-control mr-sm-2" id="additional_control_{{$row_count}}" name="additional_control_{{$row_count}}" onchange="add_value({{$row_count}})">
                                @endif 
                            </td>
                           <td>
                                <select class="form-control" id="additional_control_type_{{$row_count}}" name="additional_control_type_{{$row_count}}" onchange="add_value({{$row_count}})">
                                    <option value="">Select Control Type</option>
                                    @if(isset($data->additional_control_type) && $data->additional_control_type && $data->additional_control_type == "Acceptable")
                                        <option value="Acceptable" selected>Acceptable</option>
                                        <option value="Intolerable">Intolerable</option>                
                                    @elseif(isset($data->additional_control_type) && $data->additional_control_type && $data->additional_control_type == "Intolerable")
                                        <option value="Acceptable">Acceptable</option>                
                                        <option value="Intolerable" selected>Intolerable</option>            
                                    @else
                                        <option value="Acceptable">Acceptable</option>
                                        <option value="Intolerable">Intolerable</option>
                                    @endif
                                </select>  
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table> 
        <h3 class="pull-right" id="ACTableFooter">        
        </h3> 
    </div>
    <div class="col-6">
        <div class="row mt-3">
            <div class="col-md-12">
                <label for="alternate_method" style="padding-right:20px;">Alternate method of work considered and found not applicable</label>
                @if(isset($risk_assessment_data->alternate_method) && $risk_assessment_data->alternate_method=='Yes')
                    <input type="radio" name="alternate_method" value="Yes" checked> Yes
                    <input type="radio" name="alternate_method" value="No"> No
                @elseif(isset($risk_assessment_data->alternate_method) && $risk_assessment_data->alternate_method=='No')
                    <input type="radio" name="alternate_method" value="Yes"> Yes
                    <input type="radio" name="alternate_method" value="No" checked> No
                @else
                    <input type="radio" name="alternate_method" value="Yes"> Yes
                    <input type="radio" name="alternate_method" value="No"> No
                @endif            
            </div>
            <div class="col-md-12">
                <label for="hazard_discussed" style="padding-right:20px;">Discussed hazards and controls with team</label>
                @if(isset($risk_assessment_data->hazard_discussed) && $risk_assessment_data->hazard_discussed=='Yes')
                    <input type="radio" name="hazard_discussed" value="Yes" checked> Yes
                    <input type="radio" name="hazard_discussed" value="No"> No
                @elseif(isset($risk_assessment_data->hazard_discussed) && $risk_assessment_data->hazard_discussed=='No')
                    <input type="radio" name="hazard_discussed" value="Yes"> Yes
                    <input type="radio" name="hazard_discussed" value="No" checked> No
                @else
                    <input type="radio" name="hazard_discussed" value="Yes"> Yes
                    <input type="radio" name="hazard_discussed" value="No"> No
                @endif        
            </div>
            <div class="col-md-5">
                <label for="jha-start">Shut down period for this JHA (For work on critical equipment only)</label>
            </div>
            <div class="col-md-3">
                <label>From</label>
                @if(isset($risk_assessment_data->jha_start) && $risk_assessment_data->jha_start)
                    <input type="text" class="datepicker form-control mr-sm-2" id="jha_start" placeholder="Select JHA Start Date" name="jha_start" value="{{date('d-M-Y',strtotime($risk_assessment_data->jha_start))}}"> 
                @else
                   <input type="text" class="datepicker form-control mr-sm-2" id="jha_start" min="" placeholder="Select JHA Start Date" name="jha_start">
                @endif     
            </div>
            <div class="col-md-3">
                <label>To</label>
                @if(isset($risk_assessment_data->jha_end) && $risk_assessment_data->jha_end)
                    <input type="text" class="datepicker form-control mr-sm-2" id="jha_end" placeholder="Select JHA End Date" name="jha_end" value="{{date('d-M-Y',strtotime($risk_assessment_data->jha_end))}}"> 
                @else
                   <input type="text" class="datepicker form-control mr-sm-2" id="jha_end" min="" placeholder="Select JHA End Date" name="jha_end">
                @endif
                
            </div> 
            <div class="col-md-12">
                <label for="unassessed_hazards" style="padding-right:20px;">Any new or unassessed hazards recognised<br>(If so, it must be mentioned under comments and noted for assessments in the next JHA for this job)</label>
                @if(isset($risk_assessment_data->unassessed_hazards) && $risk_assessment_data->unassessed_hazards=='Yes')
                    <input type="radio" name="unassessed_hazards" value="Yes" checked> Yes
                    <input type="radio" name="unassessed_hazards" value="No"> No
                @elseif(isset($risk_assessment_data->unassessed_hazards) && $risk_assessment_data->unassessed_hazards=='No')
                    <input type="radio" name="unassessed_hazards" value="Yes"> Yes
                    <input type="radio" name="unassessed_hazards" value="No" checked> No
                @else
                    <input type="radio" name="unassessed_hazards" value="Yes"> Yes
                    <input type="radio" name="unassessed_hazards" value="No"> No
                @endif  
            </div>
            <div class="col-md-12">
                <label for="comments" style="padding-right:20px;">Comments:</label>
                @if(isset($risk_assessment_data->comments) && $risk_assessment_data->comments)
                  <textarea type="text" class="form-control mr-sm-2" id="comments" placeholder="Enter comments" name="comments" value="{{$risk_assessment_data->comments}}">{{$risk_assessment_data->comments}}</textarea>
                @else
                    <input type="text" class="form-control mr-sm-2" id="comments" placeholder="Enter comments" name="comments">
                @endif                 
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-8">
                <label for="port_authorities" class="mr-sm-2 mt-1">Where required, have relevant port authorities been notified (Liaise with Office/Agents, if necessary):</label>
                <select class="form-control mr-sm-2" id="port_authorities" name="port_authorities">
                    <option value="">Select Activity Type</option>
                    @if(isset($risk_assessment_data->port_authorities) && $risk_assessment_data->port_authorities == "Yes")
                        <option value="Yes" selected>Yes</option>
                        <option value="Not Required">Not Required</option>
                        <option value="N/A (Outside port limits)">N/A (Outside port limits)</option>
                    @elseif(isset($risk_assessment_data->port_authorities) && $risk_assessment_data->port_authorities == "Not Required")
                        <option value="Yes">Yes</option>
                        <option value="Not Required" selected>Not Required</option>
                        <option value="N/A (Outside port limits)">N/A (Outside port limits)</option>
                    @elseif(isset($risk_assessment_data->port_authorities) && $risk_assessment_data->port_authorities == "N/A (Outside port limits)")
                        <option value="Yes">Yes</option>
                        <option value="Not Required">Not Required</option>
                        <option value="N/A (Outside port limits)" selected>N/A (Outside port limits)</option>
                    @else
                        <option value="Yes">Yes</option>
                        <option value="Not Required">Not Required</option>
                        <option value="N/A (Outside port limits)">N/A (Outside port limits)</option>
                    @endif
                </select>
            </div>
            <div class="col-md-4">
                <label for="tools_available" class="mr-sm-2 mt-1">Required Spares & Tools are Available:</label>
                @if(isset($risk_assessment_data->tools_available) && $risk_assessment_data->tools_available=='Yes')
                    <input type="radio" name="tools_available" value="Yes" checked> Yes
                    <input type="radio" name="tools_available" value="No"> No
                @elseif(isset($risk_assessment_data->tools_available) && $risk_assessment_data->tools_available=='No')
                    <input type="radio" name="tools_available" value="Yes"> Yes
                    <input type="radio" name="tools_available" value="No" checked> No
                @else
                    <input type="radio" name="tools_available" value="Yes"> Yes
                    <input type="radio" name="tools_available" value="No"> No
                @endif         
            </div>
            <div class="col-md-4">
                <label for="lcd_notified" class="mr-sm-2 mt-1">LCD Notified:</label>
                <select class="form-control mr-sm-2" id="lcd_notified" name="lcd_notified">
                    <option value="">Select Activity Type</option>
                    @if(isset($risk_assessment_data->lcd_notified) && $risk_assessment_data->lcd_notified && $risk_assessment_data->lcd_notified == "Yes")
                        <option value="Yes" selected>Yes</option>
                        <option value="N/A">N/A</option>                
                    @elseif(isset($risk_assessment_data->lcd_notified) && $risk_assessment_data->lcd_notified && $risk_assessment_data->lcd_notified == "N/A")
                        <option value="Yes">Yes</option>                
                        <option value="N/A" selected>N/A</option>            
                    @else
                        <option value="Yes">Yes</option>
                        <option value="N/A">N/A</option>
                    @endif
                </select>
            </div>
            <div class="col-md-4">
                <label for="remarks" class="mr-sm-2 mt-1">Remarks:</label>
               @if(isset($risk_assessment_data->remarks) && $risk_assessment_data->remarks)
                  <input type="text" class="form-control mr-sm-2" id="remarks" placeholder="Enter Remarks" name="remarks"value="{{$risk_assessment_data->remarks}}">
                @else
                    <input type="text" class="form-control mr-sm-2" id="remarks" placeholder="Enter Remarks" name="remarks">                   
                @endif
            </div>
</div>

<div class="row mt-1">
    <div class="col-md-6">
        <label><b>Master</b></label>
        <div class="row mt-1">
            <div class="col-md-4">
                <label for="master_name">Name:</label>
                @if(isset($risk_assessment_data->master_name) && $risk_assessment_data->master_name)
                  <input type="text" class="form-control mr-sm-2" id="master_name" placeholder="Enter Name" name="master_name" value="{{$risk_assessment_data->master_name}}">
                @else
                    <input type="text" class="form-control mr-sm-2" id="master_name" placeholder="Enter Name" name="master_name">
                @endif                
            </div>
            <div class="col-md-4">
                <label for="master_date">Date:</label>
                @if(isset($risk_assessment_data->master_date) && $risk_assessment_data->master_date)
                    <input type="text" class="datepicker form-control mr-sm-2" id="master_date" min=""
                placeholder="Select Review Date" name="master_date" value="{{date('d-M-Y',strtotime($risk_assessment_data->master_date))}}">
                @else
                    <input type="text" class="datepicker form-control mr-sm-2" id="master_date" min="" placeholder="Date" name="master_date">
                @endif                
            </div>
            <div class="col-md-4">
                <label for="Signature">Signature:</label>
                <input type="file" class="form-control mr-sm-2" id="master_sign" name="master_sign" onchange="previewImage(this, event, 'masterSignature' )" accept="image/*">
                @if(isset($risk_assessment_data))
                    @if(isset($signature['Master']) && $signature['Master'])
                        <img src="/getSignatureImage/{{$risk_assessment_data->id}}/{{config('constants.signatureFolders.MASTER')}}" id="masterSignature" height="100" width="150">
                    @else
                        <img src="/getSignatureImage/{{$risk_assessment_data->id}}/{{config('constants.signatureFolders.MASTER')}}" id="masterSignature" height="100" width="150" style="display:none;">
                    @endif  
                @endif              
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <label><b>Chief Officer</b></label>
        <div class="row mt-1">
            <div class="col-md-4">
                <label for="Name">Name:</label>
                @if(isset($risk_assessment_data->ch_off_name) && $risk_assessment_data->ch_off_name)
                  <input type="text" class="form-control mr-sm-2" id="ch_off_name" placeholder="Enter Name" name="ch_off_name" value="{{$risk_assessment_data->ch_off_name}}">
                @else
                    <input type="text" class="form-control mr-sm-2" id="ch_off_name" placeholder="Enter Name" name="ch_off_name">
                @endif
                
            </div>
            <div class="col-md-4">
                <label for="Date">Date:</label>
                @if(isset($risk_assessment_data->ch_off_date) && $risk_assessment_data->ch_off_date)
                    <input type="text" class="datepicker form-control mr-sm-2" id="ch_off_date" min=""
                placeholder="Select Review Date" name="ch_off_date" value="{{date('d-M-Y',strtotime($risk_assessment_data->ch_off_date))}}">
                @else
                    <input type="text" class="datepicker form-control mr-sm-2" id="ch_off_date" min="" placeholder="Date" name="ch_off_date">
                @endif
                
            </div>
            <div class="col-md-4">
                <label for="Signature">Signature:</label>
                <input type="file" class="form-control mr-sm-2" id="ch_off_sign" name="ch_off_sign" onchange="previewImage(this, event,'ch_off_signature')" accept="image/*">
                <!-- <img src="/getUserProfileImage/226/SM" id="profileImage" height="200"> -->
                @if(isset($risk_assessment_data))
                    @if(isset($signature['ChiefOff']) && $signature['ChiefOff'])
                        <img src="/getSignatureImage/{{$risk_assessment_data->id}}/{{config('constants.signatureFolders.CHIEF_OFF')}}" id="ch_off_signature" height="100" width="150">
                    @else
                        <img src="/getSignatureImage/{{$risk_assessment_data->id}}/{{config('constants.signatureFolders.CHIEF_OFF')}}" id="ch_off_signature" height="100" width="150" style="display:none;">
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-1">
    <div class="col-md-6">
        <label><b>Chief Engineer</b></label>
        <div class="row mt-1">
            <div class="col-md-4">
                <label for="Name">Name:</label>
                @if(isset($risk_assessment_data))
                @if(isset($risk_assessment_data->ch_eng_name) && $risk_assessment_data->ch_eng_name)
                  <input type="text" class="form-control mr-sm-2" id="ch_eng" placeholder="Enter Name" name="ch_eng_name" value="{{$risk_assessment_data->ch_eng_name}}">
                @else
                    <input type="text" class="form-control mr-sm-2" id="ch_eng_name" placeholder="Enter Name" name="ch_eng_name">
                @endif
                @endif
                
            </div>
            <div class="col-md-4">
                <label for="Date">Date:</label>
                @if(isset($risk_assessment_data))
                @if(isset($risk_assessment_data->ch_eng_date) && $risk_assessment_data->ch_eng_date)
                    <input type="text" class="datepicker form-control mr-sm-2" id="ch_eng_date" min=""
                placeholder="Select Review Date" name="ch_eng_date" value="{{date('d-M-Y',strtotime($risk_assessment_data->ch_eng_date))}}">
                @else
                    <input type="text" class="datepicker form-control mr-sm-2" id="ch_eng_date" min="" placeholder="Date" name="ch_eng_date">
                @endif
                @endif
                
            </div>
            <div class="col-md-4">
                <label for="Signature">Signature:</label>
                <input type="file" class="form-control mr-sm-2" id="ch_eng_sign" name="ch_eng_sign" onchange="previewImage(this, event,'ch_eng_signature')" accept="image/*">
                @if(isset($risk_assessment_data))
                @if(isset($signature['ChiefEngg']) && $signature['ChiefEngg'])
                    <img src="/getSignatureImage/{{$risk_assessment_data->id}}/{{config('constants.signatureFolders.CHIEF_ENG')}}" id="ch_eng_signature" height="100" width="150">
                @else
                    <img src="/getSignatureImage/{{$risk_assessment_data->id}}/{{config('constants.signatureFolders.CHIEF_ENG')}}" id="ch_eng_signature" height="100" width="150" style="display:none;">
                @endif
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <label><b>2nd Engineer</b></label>
        <div class="row mt-1">
            <div class="col-md-4">
                <label for="Name">Name:</label>
                @if(isset($risk_assessment_data))
                @if(isset($risk_assessment_data->eng2_name) && $risk_assessment_data->eng2_name)
                  <input type="text" class="form-control mr-sm-2" id="eng2_name" placeholder="Enter Name" name="master_name" value="{{$risk_assessment_data->eng2_name}}">
                @else
                    <input type="text" class="form-control mr-sm-2" id="eng2_name" placeholder="Enter Name" name="eng2_name">
                @endif 
                @endif               
            </div>
            <div class="col-md-4">
                <label for="Date">Date:</label>
                @if(isset($risk_assessment_data))
                @if(isset($risk_assessment_data->eng2_date) && $risk_assessment_data->eng2_date)
                    <input type="text" class="datepicker form-control mr-sm-2" id="eng2_date" min=""
                placeholder="Select Review Date" name="eng2_date" value="{{date('d-M-Y',strtotime($risk_assessment_data->eng2_date))}}">
                @else
                    <input type="text" class="datepicker form-control mr-sm-2" id="eng2_date" min="" placeholder="Date" name="eng2_date">
                @endif
                @endif
            </div>
            <div class="col-md-4">
                <label for="Signature">Signature:</label>
                <input type="file" class="form-control mr-sm-2" id="eng2_sign" name="eng2_sign" onchange="previewImage(this, event,'second_eng_signature')" accept="image/*">
                @if(isset($signature['SecondEngg']) && $signature['SecondEngg'])
                    <img src="/getSignatureImage/{{$risk_assessment_data->id}}/{{config('constants.signatureFolders.SECOND_ENGG')}}" id="second_eng_signature" height="100" width="150">
                @else
                    <img src="/getSignatureImage/{{$risk_assessment_data->id}}/{{config('constants.signatureFolders.SECOND_ENGG')}}" id="second_eng_signature" height="100" width="150" style="display:none;">
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row mt-1">
    <label style="color:red;font-weight:bold;">Joint JHA is essential by C/O and 2/E when overlapping responsibilities and hazards are involved, approved by Chief Engineer and Authorized by Master</label>
    <div class="col-md-6">
        <label><b>Reviewed By: SM/FM</b></label>
        <div class="row mt-1">
            <div class="col-md-4">
                <label for="Name">Name:</label>
                @if(isset($risk_assessment_data->sm_name) && $risk_assessment_data->sm_name)
                  <input type="text" class="form-control mr-sm-2" id="sm_name" placeholder="Enter Name" name="sm_name" value="{{$risk_assessment_data->sm_name}}">
                @else
                    <input type="text" class="form-control mr-sm-2" id="sm_name" placeholder="Enter Name" name="sm_name">
                @endif                
            </div>
            <div class="col-md-4">
                <label for="Date">Date:</label>
                @if(isset($risk_assessment_data->sm_date) && $risk_assessment_data->sm_date)
                    <input type="text" class="datepicker form-control mr-sm-2" id="sm_date" min=""
                placeholder="Select Review Date" name="sm_date" value="{{date('d-M-Y',strtotime($risk_assessment_data->sm_date))}}">
                @else
                    <input type="text" class="datepicker form-control mr-sm-2" id="sm_date" min="" placeholder="Date" name="sm_date">
                @endif                
            </div>
            <div class="col-md-4">
                <label for="Signature">Signature:</label>
                <input type="file" class="form-control mr-sm-2" id="sm_sign" name="sm_sign" onchange="previewImage(this, event,'sm_signature')" accept="image/*">
                @if(isset($signature['SM']) && $signature['SM'])
                    <img src="/getSignatureImage/{{$risk_assessment_data->id}}/{{config('constants.signatureFolders.SM')}}" id="sm_signature" height="100" width="150">
                @else
                    <img src="/getSignatureImage/{{$risk_assessment_data->id}}/{{config('constants.signatureFolders.SM')}}" id="sm_signature" height="100" width="150" style="display:none;">
                @endif 
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <select id="dgm_activity_type" name="dgm_activity_type">
            <option value="">Select Activity Type</option>
            @if(isset($risk_assessment_data->dgm_activity_type) && $risk_assessment_data->dgm_activity_type && $risk_assessment_data->dgm_activity_type == "Reviewed By")
                <option value="Reviewed By" selected>Reviewed By</option>
                <option value="Approved By">Approved By</option>
                <option value="Reviewed & Approved By">Reviewed & Approved By</option>               
            @elseif(isset($risk_assessment_data->dgm_activity_type) && $risk_assessment_data->dgm_activity_type && $risk_assessment_data->dgm_activity_type == "Approved By")
                <option value="Reviewed By">Reviewed By</option>
                <option value="Approved By" selected>Approved By</option>
                <option value="Reviewed & Approved By">Reviewed & Approved By</option>
            @elseif(isset($risk_assessment_data->dgm_activity_type) && $risk_assessment_data->dgm_activity_type && $risk_assessment_data->dgm_activity_type == "Reviewed & Approved By")
                <option value="Reviewed By">Reviewed By</option>
                <option value="Approved By">Approved By</option>
                <option value="Reviewed & Approved By" selected>Reviewed & Approved By</option>             
            @else
                <option value="Reviewed By">Reviewed By</option>
                <option value="Approved By">Approved By</option>
                <option value="Reviewed & Approved By">Reviewed & Approved By</option>
            @endif
        </select>
        <label style="padding-left: 10px;"><b>D/GM: </b></label>        
        <div class="row mt-1">
            <div class="col-md-4">
                <label for="Name">Name:</label>
                @if(isset($risk_assessment_data->dgm_name) && $risk_assessment_data->dgm_name)
                  <input type="text" class="form-control mr-sm-2" id="dgm_name" placeholder="Enter Name" name="dgm_name" value="{{$risk_assessment_data->dgm_name}}">
                @else
                    <input type="text" class="form-control mr-sm-2" id="dgm_name" placeholder="Enter Name" name="dgm_name">
                @endif                
            </div>
            <div class="col-md-4">
                <label for="Date">Date:</label>
                @if(isset($risk_assessment_data->dgm_date) && $risk_assessment_data->dgm_date)
                    <input type="text" class="datepicker form-control mr-sm-2" id="dgm_date" min=""
                placeholder="Select Review Date" name="dgm_date" value="{{date('d-M-Y',strtotime($risk_assessment_data->dgm_date))}}">
                @else
                    <input type="text" class="datepicker form-control mr-sm-2" id="dgm_date" min="" placeholder="Date" name="dgm_date">
                @endif
                
            </div>
            <div class="col-md-4">
                <label for="Signature">Signature:</label>                
                <input type="file" class="form-control mr-sm-2" id="dgm_sign" name="dgm_sign" onchange="previewImage(this, event,'dgm_signature')" accept="image/*">
                @if(isset($signature['DGM']) && $signature['DGM'])
                    <img src="/getSignatureImage/{{$risk_assessment_data->id}}/{{config('constants.signatureFolders.DGM')}}" id="dgm_signature" height="100" width="150">
                @else
                    <img src="/getSignatureImage/{{$risk_assessment_data->id}}/{{config('constants.signatureFolders.DGM')}}" id="dgm_signature" height="100" width="150" style="display:none;">
                @endif 
            </div>
        </div>
    </div>
</div>
<div class="row mt-1">
    <label class="col-md-12" style="color:red;font-weight:bold;">Identify Team Leader (Name & Rank):</label>
    <div class="col-md-6">
        <label>Personnel Assigned (Name & Rank):</label>
        @if(isset($risk_assessment_data->name_rank) && $risk_assessment_data->name_rank)
          <textarea class="form-control mr-sm-2" id="name_rank" placeholder="Enter name & Rank" name="name_rank">{{$risk_assessment_data->name_rank}}</textarea>
        @else
            <textarea class="form-control mr-sm-2" id="name_rank" placeholder="Enter name & Rank" name="name_rank"></textarea>   
        @endif             
    </div>
    <div class="col-md-6">
        <select id="dgm_activity_type" name="gm_activity_type">
            <option value="">Select Activity Type</option>
            @if(isset($risk_assessment_data->gm_activity_type) && $risk_assessment_data->gm_activity_type && $risk_assessment_data->gm_activity_type == "Reviewed By")
                <option value="Reviewed By" selected>Reviewed By</option>
                <option value="Approved By">Approved By</option>
                <option value="Reviewed & Approved By">Reviewed & Approved By</option>               
            @elseif(isset($risk_assessment_data->gm_activity_type) && $risk_assessment_data->gm_activity_type && $risk_assessment_data->gm_activity_type == "Approved By")
                <option value="Reviewed By">Reviewed By</option>
                <option value="Approved By" selected>Approved By</option>
                <option value="Reviewed & Approved By">Reviewed & Approved By</option>
            @elseif(isset($risk_assessment_data->gm_activity_type) && $risk_assessment_data->gm_activity_type && $risk_assessment_data->gm_activity_type == "Reviewed & Approved By")
                <option value="Reviewed By">Reviewed By</option>
                <option value="Approved By">Approved By</option>
                <option value="Reviewed & Approved By" selected>Reviewed & Approved By</option>             
            @else
                <option value="Reviewed By">Reviewed By</option>
                <option value="Approved By">Approved By</option>
                <option value="Reviewed & Approved By">Reviewed & Approved By</option>
            @endif
        </select>
        <label style="padding-left: 10px;"><b>GM: </b></label>       
        <div class="row mt-1">
            <div class="col-md-4">
                <label for="Name">Name:</label>
                @if(isset($risk_assessment_data->gm_name) && $risk_assessment_data->gm_name)
                  <input type="text" class="form-control mr-sm-2" id="gm_name" placeholder="Enter Name" name="gm_name" value="{{$risk_assessment_data->gm_name}}">
                @else
                    <input type="text" class="form-control mr-sm-2" id="gm_name" placeholder="Enter Name" name="gm_name">
                @endif                
            </div>
            <div class="col-md-4">
                <label for="Date">Date:</label>
                @if(isset($risk_assessment_data->gm_date) && $risk_assessment_data->gm_date)
                    <input type="text" class="datepicker form-control mr-sm-2" id="gm_date" min=""
                placeholder="Select Review Date" name="gm_date" value="{{date('d-M-Y',strtotime($risk_assessment_data->gm_date))}}">
                @else
                    <input type="text" class="datepicker form-control mr-sm-2" id="gm_date" min="" placeholder="Date" name="gm_date">
                @endif                
            </div>
            <div class="col-md-4">
                <label for="Signature">Signature:</label>
                <input type="file" class="form-control mr-sm-2" id="gm_sign" name="gm_sign" onchange="previewImage(this, event,'gm_signature')" accept="image/*">
                @if(isset($signature['GM']) && $signature['GM'])
                    <img src="/getSignatureImage/{{$risk_assessment_data->id}}/{{config('constants.signatureFolders.GM')}}" id="gm_signature" height="100" width="150">
                @else
                    <img src="/getSignatureImage/{{$risk_assessment_data->id}}/{{config('constants.signatureFolders.GM')}}" id="gm_signature" height="100" width="150" style="display:none;">
                @endif  
            </div>
        </div>
    </div>
</div>