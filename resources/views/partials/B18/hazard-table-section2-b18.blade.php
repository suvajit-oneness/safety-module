<div class="row" id="section2Row">
	<div class="col-12">
        <span>
            <b>Code :</b> No. - Number, LKH - Likelihood, SVR - Severity, RF - Risk Factor, A.C - Additional controls<br>
            <b>Code for Risk Factor :</b>  VH - Very High Risk, HR - High risk, MR - Moderate risk, LR - Low risk, VL - Very Low Risk
        </span>
		<table class="table table-bordered datatable mt-2" id="b_18_table">
            <thead>
                <tr>
                <th colspan="7">For unusual jobs, work on critical equipment or if residual risks remain MR or HR, send JHA to Office</th>
                <th colspan="6" rowspan="2">If any hazard manifests itself even with effective control measures in place or if hazards develop unexpectedly, work should be stopped and office informed.</th>
                </tr>
                <tr>
                    <td colspan="4">Date of JHA:
                        <!-- <input type="text" class="datepicker form-control mr-sm-2" id="jha_date" min="" placeholder="Select JHA Date" name="jha_date"> -->
        
                    @if(isset($risk_assessment_data->jha_date) && $risk_assessment_data->jha_date)
                        <input type="text" class="datepicker form-control mr-sm-2" id="jha_date" min="" placeholder="Select Review Date" name="jha_date" value="{{date('d-M-Y',strtotime($risk_assessment_data->jha_date))}}">
                    @elseif(isset($template[0]) && $template[0]->jha_date)
                        <input type="text" class="datepicker form-control mr-sm-2" id="jha_date" min="" placeholder="Select Review Date" name="jha_date" value="{{date('d-M-Y',strtotime($template[0]->jha_date))}}">
                    @else
                        <input type="text" class="datepicker form-control mr-sm-2" id="jha_date" min="" placeholder="Select JHA Date" name="jha_date">
                    @endif 
                    </td>
                    <td colspan="3">Last Assessment: 
                    @if(isset($risk_assessment_data->last_assessment) && $risk_assessment_data->last_assessment)
                        <input type="text" class="form-control datepicker mr-sm-2" id="last_assessment" placeholder="Enter Last Assessment" name="last_assessment" value="{{$risk_assessment_data->last_assessment}}">
                    @elseif(isset($template[0]) && $template[0]->last_assessment)
                        <input type="text" class="datepicker form-control mr-sm-2" id="last_assessment" min="" placeholder="Select Review Date" name="last_assessment" value="{{date('d-M-Y',strtotime($template[0]->last_assessment))}}">
                    @else
                        <input type="text" class="form-control datepicker mr-sm-2" id="last_assessment" placeholder="Enter Last Assessment" name="last_assessment">
                    @endif 
                    </td>
                </tr>
                <tr>
                    <td colspan="13">
                        <h3>Section 1</h3>
                        <button type="button" class="btn btn-success mt-3" onclick="addHazard()" title="Click to add another row here">
                            Add Hazard
                        </button>
                    </td>
                </tr>                
            </thead>
            <thead>
                <th colspan="6"></th>
                <th colspan="3" title="Risk Rating" style="text-align: center;">Risk Rating</th>
                <th title="Situation">Control Measure</th>
                <th colspan="4" title="Residual Risk" style="text-align: center;">Residual Risk</th>                
                <th title="Actions">#</th>
            </thead>
            <thead>                
                <th title="No">No</th>
                <th title="Event">Job / Event</th>
                <th title="Hazard">Hazard </th>
                {{-- Added by Onenesstechs - hazard details and hazard cause --}}
                <th title="hazard_details">Hazard Details</th> 
                <th title="hazard_cause">Hazard Cause</th>
                {{-------------------------------------------------------------}}
                <th title="Consequence">Consequence</th> 
                <th title="Severity">Severity</th>                        
                <th title="Likelihood">Likelihood</th>
                <th title="IR_Risk_Rating">Risk Factor</th>
                <th colspan="1">(If no contol measures are required, enter NONE and keep LKH & SVR unchanged)</th>
                <th title="RR_Severity">Severity</th>
                <th title="RR_Likelihood">Likelihood</th>
                <th title="RR_Risk_Rating">Risk Factor</th>
                <th title="Additional Controls">A.C</th>                
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
                            <td>{{$rowCount}}</td>
                            <td>{{$data->hazardEvent}}</td>
                            <td>{{$data->hazard_lists_name}}</td>
                            
                            {{-- -----------------Added by onenesstechs------------ --}}
                            
                            @php
                                $hazard_cause = $data->hazard_cause != null ? App\Models\hazard_master_list::find($data->hazard_cause)->causes : 'N.A';
                                $hazard_details = $data->hazard_details != null ? App\Models\hazard_master_list::find($data->hazard_details)->hazard_details : 'N.A';
                            @endphp

                            <td>{{ $hazard_details }}</td>
                            <td>{{ $hazard_cause }}</td>

                            {{-- -----------------------Ends------------------------ --}}

                            <td>{{$data->consequences}}</td>
                            <td>{{$data->svr1}}</td>
                            <td>{{$data->lkh1}}</td>
                            @if(isset($riskMatriceColor[$data->rf1]))
                            <td style="background-color: {{$riskMatriceColor[$data->rf1]}}">{{$riskFactor[$data->rf2]}}</td>
                            @else
                            <td style="background-color: white">NULL</td> 
                            @endif
                            <td>{!!$data->control_measure!!}</td>
                            <td>{{$data->svr2}}</td>
                            <td>{{$data->lkh2}}</td>
                            @if(isset($riskMatriceColor[$data->rf2]))
                            <td style="background-color: {{$riskMatriceColor[$data->rf2]}}">{{$riskFactor[$data->rf2]}}</td>
                            @else
                            <td style="background-color: white">NULL</td>
                            @endif
                            <td>{{$data->add_control}}</td>
                            <td>
                                <button class="btn btn-primary mr-2" type="button" onclick="editSection2Row({{$rowCount}})">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-danger" type="button"onclick="deleteRow({{$rowCount}})">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td> 
                            </tr>                        
                    @endforeach 
                @endif                
            </tbody>
            
        </table>
        <h3 class="pull-right" id="riskTableFooter">
        
        </h3>
	</div>        
</div>