<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h3 style = "text-align:center; ">JOB HAZARD & RISK ANALYSIS FORM</h3>
    <h4 style = "text-align:center;color:red ">Complete this process to Identify the HAZARD and assess Consequence with each hazard. State Control measures to eliminate/mitigate Risks</h4>
    <h4 style = "text-align:center; ">(example: Identified Hazard: “Electricity” ; Consequence: “Electrocution, Disability, Death,”….etc)</h4>

                        {{--<table class="table table-bordered" id="templates_table" style="border: 1px solid black; width: 85vw">
                            <thead>
                                <tr>
                                    <th class="text-center" style="border: 1px solid black ;">Field Name</th>
                                    <th class="text-center" style="border: 1px solid black ;">Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center" style="border: 1px solid black ;">Creator_id</td>                                      
                                    <td class="text-center" style="border: 1px solid black ;">{{$template[0]->creator_id}}</td>                                      
                                </tr>
                                <tr>
                                    <td class="text-center" style="border: 1px solid black ;">Creator_email</td>                                      
                                    <td class="text-center" style="border: 1px solid black ;">{{$template[0]->creator_email}}</td>                                      
                                </tr>
                                <tr>
                                    <td class="text-center" style="border: 1px solid black ;">Template name</td>                                      
                                    <td class="text-center" style="border: 1px solid black ;">{{$template[0]->name}}</td>                                      
                                </tr>
                                <tr>
                                    <td class="text-center" style="border: 1px solid black ;">Dept</td>                                      
                                    <td class="text-center" style="border: 1px solid black ;">{{$dept_name->name}}</td>                                      
                                </tr>
                            </tbody>
                        </table>--}}

                
                @php 
                    $count = 1;
                @endphp               
                <table style="width: 85vw">
                    <tbody>
                        @foreach ($Dynamic as $key => $value)
                            @if(fmod($count,3) == 1)
                                <tr>
                            @endif
                                    <th style = "color:blue;border:1px solid black;text-align:left;">{{ $key }} </th> 
                                    <td style = "border:1px solid black;text-align:left;">{{ $value }}</td>
                            @if(fmod($count,3) == 0)
                                </tr>
                            @endif
                            @php 
                                $count = $count + 1;
                            @endphp
                        @endforeach 
                    </tbody>
                </table>
                
                <div id="editt" class = "mt-2"> </div>
                {{--<input hidden type="text" id='form_temp' value= 'null' name = 'form_temp'>--}}
                <hr>
                {{--Start--}}
             
        <span>
            Code : No. - Number, LKH - Likelihood, SVR - Severity, RF - Risk Factor, A.C - Additional controls      Code for Risk Factor :  VH - Very High Risk, HR - High risk, MR - Moderate risk, LR - Low risk, VL - Very Low Risk
        </span>
        
		
            <table style="border: 1px solid black; width: 85vw; margin-top:10px;">
                <thead style="border: 1px solid black; width: 85vw">
                    <tr>
                     
                        <th colspan="7" style = "color:red;border:1px solid black;">
                            For unusual jobs, work on critical equipment or if residual risks remain MR or HR, send JHA to Office
                                    
                        </th>
                        <th colspan="6" style = "color:red;border: 1px solid black;">
                            If any hazard manifests itself even with effective control measures in place or if hazards develop unexpectedly, work should be stopped and office informed.
                        </th>
                    </tr>      
                </thead>
                <thead>
                    <tr>
                        <th colspan="2" style = "color:blue;border:1px solid black;">Date of JHA</th>
                        <th colspan="1" style = "border:1px solid black;">
                            @if(isset($risk_assessment_data->jha_date) && $risk_assessment_data->jha_date)
                                {{date('d-M-Y',strtotime($risk_assessment_data->jha_date))}}
                            @elseif(isset($template[0]) && $template[0]->jha_date)
                                {{date('d-M-Y',strtotime($template[0]->jha_date))}}
                            @else
                                Null
                            @endif
                        </th>
                        <th colspan="1" style = "color:blue;border:1px solid black;">Last Assessment</th>
                        <th colspan="3" style = "border:1px solid black;"> 
                            @if(isset($risk_assessment_data->last_assessment) && $risk_assessment_data->last_assessment)
                                {{$risk_assessment_data->last_assessment}}
                            @elseif(isset($template[0]) && $template[0]->last_assessment)
                                {{date('d-M-Y',strtotime($template[0]->last_assessment))}}
                            @else
                                Null
                            @endif 
                        </th>
                    </tr>
                </thead>
            <thead style="border: 1px solid black; width: 85vw">
                <th colspan="2" >Section 1</th>
                <th colspan="3" title="Risk Rating" style="text-align: center;">Risk Rating</th>
                <th title="Situation" style="border: 1px solid black ;">Control Measure</th>
                <th colspan="4" title="Residual Risk" style="text-align: center;">Residual Risk</th>                
                
            </thead>
            <thead style="border: 1px solid black; width: 85vw">                
                <th title="No" style="border: 1px solid black ;">No</th>
                <th title="Event" style="border: 1px solid black ;">Job / Event</th>
                <th title="Hazard" style="border: 1px solid black ;">Hazard </th>
                <th title="Consequence" style="border: 1px solid black ;">Consequence</th> 
                <th title="Severity" style="border: 1px solid black ;">Severity</th>                        
                <th title="Likelihood" style="border: 1px solid black ;">Likelihood</th>
                <th title="IR_Risk_Rating" style="border: 1px solid black ;">Risk Factor</th>
                <th colspan="1" style="border: 1px solid black ;">(If no contol measures are required, enter NONE and keep LKH & SVR unchanged)</th>
                <th title="RR_Severity" style="border: 1px solid black ;">Severity</th>
                <th title="RR_Likelihood" style="border: 1px solid black ;">Likelihood</th>
                <th title="RR_Risk_Rating" style="border: 1px solid black ;">Risk Factor</th>
                <th title="Additional Controls" style="border: 1px solid black ;">A.C</th>                
            </thead>
            <tbody id="b_18_tbody">
                @php
                    $rowCount = 0;
                @endphp
                @php
                    $stringLimit = config('constants.TABLE_STRING_SIZE');
                @endphp
                @if(isset($templateData))
                    @foreach($templateData as $data)
                        @php
                            $rowCount++;
                        @endphp
                      <tr id="row_{{$rowCount}}">
                            <td style="border: 1px solid black ;">{{$rowCount}}</td>
                            <td style="border: 1px solid black ;">{{$data->hazardEvent}}</td>
                            <td style="border: 1px solid black ;">{{$data->hazard_lists_name}}</td>
                            <td style="border: 1px solid black ;">{{$data->consequences}}</td>
                            <td style="border: 1px solid black ;">{{$data->svr1}}</td>
                            <td style="border: 1px solid black ;">{{$data->lkh1}}</td>
                            @if(isset($riskMatriceColor[$data->rf1]))
                            <td style="background-color: {{$riskMatriceColor[$data->rf1]}}">{{$riskFactor[$data->rf2]}}</td>
                            @else
                            <td style="background-color: white">NULL</td> 
                            @endif
                            <td style="border: 1px solid black ;">{!!$data->control_measure!!}</td>
                            <td style="border: 1px solid black ;">{{$data->svr2}}</td>
                            <td style="border: 1px solid black ;">{{$data->lkh2}}</td>
                            @if(isset($riskMatriceColor[$data->rf2]))
                            <td style="background-color: {{$riskMatriceColor[$data->rf2]}}">{{$riskFactor[$data->rf2]}}</td>
                            @else
                            <td style="background-color: white">NULL</td>
                            @endif
                            <td style="border: 1px solid black ;">{{$data->add_control}}</td>
                            
                            </tr>                        
                    @endforeach 
                @endif                
            </tbody>
            
        </table>
        <h3 class="pull-right" id="riskTableFooter">
        
        </h3>
	
                              
               

                <!-- Section 2 -->
                
                     
                <table style="border: 1px solid black; width: 85vw">
                            <thead>
                                <th colspan = "2" style = "text-align:left">Section 2 - Additional Control</th>
                                <th>Acceptable/Intolerable</th>
                            </thead>
                            <thead>
                                <th style="border: 1px solid black;">No</th>
                                <th colspan = "2" style="border: 1px solid black;background-color:rgb(99, 226, 60);">To be completed by Office</th>
                                
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
                                        <td style="border: 1px solid black ;">{{$row_count}}</td>
                                        <td style="border: 1px solid black ;">                               
                                                @if(isset($data->additional_control) && $data->additional_control)
                                                    {{$data->additional_control}}
                                                @else
                                                    NULL
                                                @endif 
                                            </td>
                                        <td style="border: 1px solid black ;">
                                               
                                                    @if(isset($data->additional_control_type) && $data->additional_control_type && $data->additional_control_type == "Acceptable")
                                                       
                                                        Acceptable
                                                                        
                                                    @elseif(isset($data->additional_control_type) && $data->additional_control_type && $data->additional_control_type == "Intolerable")
                                                        Intolerable            
                                                    @else
                                                        NULL
                                                    @endif
                                                  
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                </table>

                <table style="border: 1px solid black; width: 85vw;margin:30px 0px;">
                    <thead>
                        <tr>
                            <th colspan = "3" style = "border:1px solid black;background-color:rgb(99, 226, 60);">In case of any MR, HR or VH residual risk, Contact Office</th>
                            <th colspan = "2" style = "border:1px solid black;color:red;">CONTACT OFFICE</th>
                        </tr>
                        <tr>
                            <th colspan = "3" style = "color:red">To Be completed prior commencement of work</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan = "3" style = "border:1px solid black;color:blue;
                            ">Alternate method of work considered and found not applicable</td>
                            <td style = "border:1px solid black;">
                                @if(isset($template[0]->alternate_method)     && $template[0]->alternate_method=='Yes')
                                    <input  type=checkbox checked>Yes
                                @else
                                    <input  type=checkbox > Yes
                                @endif
                            </td>
                            <td style = "border:1px solid black;">
                                @if(isset($template[0]->alternate_method) && $template[0]->alternate_method=='No')
                                    <input  type=checkbox checked>No
                                @else
                                    <input  type=checkbox >No
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td colspan = "3" style = "border:1px solid black;color:blue;
                            ">Discussed hazards and controls with team</td>
                            <td style = "border:1px solid black;">
                                @if(isset($template[0]->hazard_discussed) && $template[0]->hazard_discussed=='Yes')
                                    <input  type=checkbox checked> Yes
                                @else
                                    <input  type=checkbox> Yes
                                @endif
                            </td>
                            <td style = "border:1px solid black;">
                                @if(isset($template[0]->hazard_discussed) && $template[0]->hazard_discussed=='No')
                                <input  type=checkbox checked>No
                                @else
                                    <input  type=checkbox >No
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td colspan = "3" style = "border:1px solid black;color:blue;
                            ">Date and time when all controls are in place (to be checked & entered prior commencement of the job)</td>
                            <td colspan = "2" style = "border:1px solid black;"></td>
                            
                        </tr>
                        <tr>
                            <td style = "border:1px solid black;color:blue;
                            ">Shut down period for this JHA (For work on critical equipment only)</td>
                            <td style = "border:1px solid black;">Form</td>
                            <td style = "border:1px solid black;">
                                @if(isset($template[0]->jha_start) && $template[0]->jha_start)
                                    {{date('d-M-Y',strtotime($template[0]->jha_start))}}
                                @endif
                            </td>
                            <td style = "border:1px solid black;">To</td>
                            <td style = "border:1px solid black;">
                                @if(isset($template[0]->jha_end) && $template[0]->jha_end)
                                            {{date('d-M-Y',strtotime($template[0]->jha_end))}} 
                                @endif 
                            </td>
                        </tr>
                        <tr>
                            <td colspan = "5" style = "border:1px solid black;color:red;">Evaluation of JHA after completion of work</td>
                        </tr>
                        <tr>
                            <td colspan = "3" style = "1px solid black;color:blue;">Any new or unassessed hazards recognised (If so, it must be mentioned under comments and noted for assessments in the next JHA for this job) </td>
                            <td style = "border:1px solid black;"> <input  type=checkbox >Yes</td>
                            <td style = "border:1px solid black;"> <input  type=checkbox >No</td>
                        </tr>
                        <tr>
                            <td colspan = "5" style = "border:1px solid black;color:blue;text-align:left;">Comments:</td>
                        </tr>
                        <tr>
                            <td colspan = "5" style = "border:1px solid black;">
                                @if(isset($template[0]->comments) && $template[0]->comments)
                                    {{$template[0]->comments}}
                                @else
                                    NULL
                                @endif 
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button style = "align-item:center;color:green;">GO AHEAD</button>

                <table style = "border:1px solid black; width: 85vw;margin-top:30px;">
                    <thead>
                        <tr>
                            <th style = "border:1px solid black;background-color: aqua;">
                                Where required, have relevant port authorities been notified (Liaise with Office/Agents, if necessary)
                            </th>
                            <th style = "border:1px solid black;">
                                @if(isset($template[0]->port_authorities) && $template[0]->port_authorities == "Yes")
                                    Yes
                                            
                                @elseif(isset($template[0]->port_authorities) && $template[0]->port_authorities == "Not Required")
                                            
                                    Not Required
                                            
                                @elseif(isset($template[0]->port_authorities) && $template[0]->port_authorities == "N/A (Outside port limits)")
                                    N/A (Outside port limits)
                                @else
                                    NULL
                                @endif 
                            </th>
                            <th style = "border:1px solid black;background-color: aqua;">
                                Required Spares & Tools are Available
                            </th>
                            <th style = "border:1px solid black;">
                                @if(isset($template[0]->tools_available) && $template[0]->tools_available=='Yes')
                                    Yes <input  type=checkbox checked>
                                    
                                @elseif(isset($template[0]->tools_available) && $template[0]->tools_available=='No')
                                    No <input name=name id=id type=checkbox >
                                @else
                                    NULL
                                @endif
                            </th>
                            <th style = "border:1px solid black;background-color: aqua;">
                                LCD Notified
                            </th>
                            <th style = "border:1px solid black;">
                                @if(isset($template[0]->lcd_notified) && $template[0]->lcd_notified && $template[0]->lcd_notified == "Yes")
                                    Yes                
                                @elseif(isset($template[0]->lcd_notified) && $template[0]->lcd_notified && $template[0]->lcd_notified == "N/A")
                                    N/A            
                                @else
                                    NULL
                                @endif 
                            </th>
                            <th style = "border:1px solid black;background-color: aqua;">
                                Remarks
                            </th>
                            <th style = "border:1px solid black;">
                                @if(isset($template[0]->lcd_notified) && $template[0]->lcd_notified && $template[0]->lcd_notified == "Yes")
                                    Yes                
                                @elseif(isset($template[0]->lcd_notified) && $template[0]->lcd_notified && $template[0]->lcd_notified == "N/A")
                                    N/A            
                                @else
                                    NULL
                                @endif
                            </th>
                        </tr>
                    </thead>
                </table>
                
                <table style = "border:1px solid black; width: 85vw;margin-top:30px;">
                    <thead style = "border:1px solid black;">
                        <tr>
                            <th colspan="2">GENERATED ON BOARD OR ASHORE:</th>
                            <th colspan="1">Ship</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th rowspan = "2" style = "border:1px solid black; text-align:center;">Master</td>
                            <td style = "border:1px solid black;text-align:center;">
                                @if(isset($template[0]->master_name) && $template[0]->master_name)
                                            {{$template[0]->master_name}}
                                @else
                                    NULL
                                @endif 
                                /
                                @if(isset($template[0]->master_date) && $template[0]->master_date)
                                            {{date('d-M-Y',strtotime($template[0]->master_date))}}
                                @else
                                    NULL
                                @endif

                            </td>
                            <td style = "border:1px solid black;text-align:center;">
                                @if(isset($signature['Master']) && isset($Image['Master']))
                                    <img height = "30" width = "100" src="{{$Image['Master']}}" alt="">
                                @else
                                    Not uploaded
                                @endif 
                            </td>
                        </tr>
                        <tr>
                            
                            <td style = "border:1px solid black;text-align:center;">Name/ Date</td>
                            <td style = "border:1px solid black;text-align:center;">Signature</td>
                        </tr>
                        <tr>
                            <th rowspan = "2" style = "border:1px solid black;text-align:center;">Chief Engineer</td>
                            <td style = "border:1px solid black;text-align:center;">
                                @if(isset($template[0]))
                                    @if(isset($template[0]->ch_eng_name) && $template[0]->ch_eng_name)
                                        {{$template[0]->ch_eng_name}}
                                    @else
                                        NULL
                                    @endif
                                @endif
                                /
                                @if(isset($template[0]))
                                    @if(isset($template[0]->ch_eng_date) && $template[0]->ch_eng_date)
                                        {{date('d-M-Y',strtotime($template[0]->ch_eng_date))}}
                                    @else
                                        NULL
                                    @endif
                                @endif
                            </td>
                            <td style = "border:1px solid black;text-align:center;">
                                @if(isset($signature['ChiefEngg']) && isset($Image['ChiefEngg']))
                                    <img height = "30" width = "100" src="{{$Image['ChiefEngg']}}" alt="">
                                @else
                                    Not uploaded
                                @endif 
                            </td>
                        </tr>
                        <tr>
                            
                            <td style = "border:1px solid black;text-align:center;">Name/ Date</td>
                            <td style = "border:1px solid black;text-align:center;">Signature</td>
                        </tr>
                    </tbody>
                </table>

                <table style = "border:1px solid black; width: 85vw; margin-top:30px;">
                    <thead style = "border:1px solid black;">
                        
                    </thead>
                    <tbody>
                        <tr>
                            <th rowspan = "2" style = "border:1px solid black;text-align:center;">Chief Officer</td>
                            <td style = "border:1px solid black;text-align:center;">
                                @if(isset($template[0]->ch_off_name) && $template[0]->ch_off_name)
                                    {{$template[0]->ch_off_name}}
                                @else
                                    NULL
                                @endif 
                                /
                                @if(isset($template[0]->ch_off_date) && $template[0]->ch_off_date)
                                            {{date('d-M-Y',strtotime($template[0]->ch_off_date))}}
                                @else
                                    NULL
                                @endif

                            </td>
                            <td style = "border:1px solid black;text-align:center;">
                                @if(isset($signature['ChiefOff']) && isset($Image['ChiefOff']))
                                    <img height = "30" width = "100" src="{{$Image['ChiefOff']}}" alt="">
                                @else
                                    Not uploaded
                                @endif 
                            </td>
                        </tr>
                        <tr>
                            
                            <td style = "border:1px solid black;text-align:center;">Name/ Date</td>
                            <td style = "border:1px solid black;text-align:center;">Signature</td>
                        </tr>
                        <tr>
                            <th rowspan = "2" style = "border:1px solid black;">2nd Engineer</td>
                            <td style = "border:1px solid black;text-align:center;">
                                @if(isset($template[0]))
                                    @if(isset($template[0]->eng2_name) && $template[0]->eng2_name)
                                        {{$template[0]->eng2_name}}
                                    @else
                                        NULL
                                    @endif
                                @endif
                                /
                                @if(isset($template[0]))
                                    @if(isset($template[0]->eng2_date) && $template[0]->eng2_date)
                                        {{date('d-M-Y',strtotime($template[0]->eng2_date))}}
                                    @else
                                        NULL
                                    @endif
                                @endif
                            </td>
                            <td style = "border:1px solid black;text-align:center;">
                                
                                @if(isset($signature['SecondEngg']) && isset($Image['SecondEngg']))
                                    <img height = "30" width = "100" src="{{$Image['SecondEngg']}}" alt="">
                                @else
                                    Not uploaded
                                @endif 
                            </td>
                        </tr>
                        <tr>
                            
                            <td style = "border:1px solid black; text-align:center;">Name/ Date</td>
                            <td style = "border:1px solid black;text-align:center;">Signature</td>
                        </tr>
                    </tbody>
                </table>
                <label style="color:red;font-weight:bold;margin-top:10px;">Joint JHA is essential by C/O and 2/E when overlapping responsibilities and hazards are involved, approved by Chief Engineer and Authorized by Master</label>
                    <table style = "border:1px solid black; width: 85vw; margin-top:10px;">
                        <thead></thead>
                        <tbody>
                            <tr>
                                <th rowspan = "2" style = "border:1px solid black;text-align:center;">Reviewed By: SM/FM</th>
                                <td style = "border:1px solid black;text-align:center;">
                                    @if(isset($template[0]->sm_name) && $template[0]->sm_name)
                                        {{$template[0]->sm_name}}
                                    @else
                                        NULL
                                    @endif
                                    /
                                    @if(isset($template[0]->sm_date) && $template[0]->sm_date)
                                        {{date('d-M-Y',strtotime($template[0]->sm_date))}}
                                    @else
                                        NULL
                                    @endif
                                </td>
                                <td style = "border:1px solid black;text-align:center;">
                                    
                                    @if(isset($signature['SM']) && isset($Image['SM']))
                                        <img height = "30" width = "100" src="{{$Image['SM']}}" alt="">
                                    @else
                                        Not uploaded
                                    @endif 
                                </td>
                            </tr>
                            <tr>
                                <td style = "border:1px solid black;text-align:center;">Name/Date</td>
                                <td style = "border:1px solid black;text-align:center;">Signature</td>
                            </tr>
                            <tr>
                                <th colspan="3" style = "border:1px solid black;color:blue;text-align:left;">
                                    <b>@if(isset($template[0]->dgm_activity_type) && $template[0]->dgm_activity_type && $template[0]->dgm_activity_type == "Reviewed By")
                                            Reviewed By
                                    @elseif(isset($template[0]->dgm_activity_type) && $template[0]->dgm_activity_type && $template[0]->dgm_activity_type == "Approved By")
                                            Approved By
                                    @elseif(isset($template[0]->dgm_activity_type) && $template[0]->dgm_activity_type && $template[0]->dgm_activity_type == "Reviewed & Approved By")
                                            Reviewed & Approved By            
                                    @else
                                        NULL
                                    @endif</b>
                                </th>
                            </tr>
                            <tr>
                                <th rowspan="2" style = "border:1px solid black;text-align:center;">D/GM</th>
                                <td style = "border:1px solid black;text-align:center;">
                                    @if(isset($template[0]->dgm_name) && $template[0]->dgm_name)
                                        {{$template[0]->dgm_name}}
                                    @else
                                        NULL
                                    @endif
                                    /
                                    @if(isset($template[0]->dgm_date) && $template[0]->dgm_date)
                                        {{date('d-M-Y',strtotime($template[0]->dgm_date))}}
                                    @else
                                        NULL
                                    @endif

                                </td>
                                <td style = "border:1px solid black;text-align:center;">
                                    @if(isset($signature['DGM']) && isset($Image['DGM']))
                                        <img height = "30" width = "100" src="{{$Image['DGM']}}" alt="">
                                    @else
                                        Not uploaded
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td style = "border:1px solid black;text-align:center;">
                                    Name/Date
                                </td>
                                <td style = "border:1px solid black;text-align:center;">
                                    Signature
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style = "border: 1px solid black; width: 85vw;margin-top:30px;:">
                        <thead>

                        </thead>
                        <tbody>
                            <tr>
                                <th colspan = "3" style = "border:1px solid black;text-align:left;">
                                    Identify Team Leader (Name & Rank)
                                </th>
                            </tr>
                            <tr>
                                <th colspan = "3" style = "border:1px solid black;text-align:left;">
                                    Personnel Assigned (Name & Rank) :
                                    @if(isset($template[0]->name_rank) && $template[0]->name_rank)
                                        {{$template[0]->name_rank}}
                                    @else
                                        {{$template[0]->name_rank}}   
                                    @endif 
                                </th>
                            </tr>
                            <tr>
                                <th colspan = "3" style = "border:1px solid black; text-align:left;color:blue;">
                                    @if(isset($template[0]->gm_activity_type) && $template[0]->gm_activity_type && $template[0]->gm_activity_type == "Reviewed By")
                                        Reviewed By          
                                    @elseif(isset($template[0]->gm_activity_type) && $template[0]->gm_activity_type && $template[0]->gm_activity_type == "Approved By")
                                        Approved By
                                    @elseif(isset($template[0]->gm_activity_type) && $template[0]->gm_activity_type && $template[0]->gm_activity_type == "Reviewed & Approved By")
                                        Reviewed & Approved By             
                                    @else
                                        NULL
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <th rowspan = "2" style = "border:1px solid black;text-align:center;">
                                    GM
                                </th>
                                <td style = "border:1px solid black;text-align:center;">
                                    @if(isset($template[0]->gm_name) && $template[0]->gm_name)
                                        {{$template[0]->gm_name}}
                                    @else
                                        NULL
                                    @endif
                                    /
                                    @if(isset($template[0]->gm_date) && $template[0]->gm_date)
                                        {{date('d-M-Y',strtotime($template[0]->gm_date))}}
                                    @else
                                        NULL
                                    @endif
                                </td>
                                <td style = "border:1px solid black;text-align:center;">
                                    @if(isset($signature['GM']) && isset($Image['GM']))
                                        <img height = "30" width = "100" src="{{$Image['GM']}}" alt="">
                                    @else
                                        Not uploaded
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td style = "border:1px solid black;text-align:center;">
                                    Name/Date
                                </td>
                                <td style = "border:1px solid black;text-align:center;">
                                    Signature
                                </td>
                            </tr>
                       </tbody>
                    </table>
                        
                        
                    <h4 style = "text-align:center;">RESPECT SAFETY OF LIFE ENVIRONMENT & PROPERTY CAREFULLY READ AND COMPLY WITH THE  COMPREHENSIVE DIRECTIVES AND GUIDELINES CONTAINED IN “SMS VOLUME IV: JOB HAZARD ANALYSIS PROCEDURES”</h4>
                    <h5 style = "text-align:center; color:red;">"THE LIFE YOU SAVE IS MAY BE YOUR OWN!"</h5>
                    
                
                

                

                
                
                
                

<script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
<script>

        $(document).ready(function(){
            
            var form_json = {!! json_encode($template[0]->form_json) !!};
            var formRenderOptions = {
                formData: form_json
		    }
            var formRenderInstance = $('#editt').formRender(formRenderOptions);
            
            $('#RiskForm').submit(function() {
                
                $('#form_temp').val(JSON.stringify(formRenderInstance.userData));
                if($('#form_temp').val()=='null'){
                    return false;
                }
                else if(isAdmin && !$('#template_name').val()){
                    toastr.error('Please Enter a Template Name');
                    return false;
                }
                else if(section2Rows.length==0){
                    toastr.error('Add Atleast 1 Risk Assessment');
                    return false;
                }
                else if($('#dept-id').val() == ''){
                    toastr.error('Enter Department');
                    return false;
                }
                else{
                    // console.log($('#form_temp').val());
                    return true;
                }
            });
        });
</script>
