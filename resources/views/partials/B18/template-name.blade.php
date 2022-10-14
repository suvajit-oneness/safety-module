{{--<!-- <div class="row">
    <div class="col-md-8" ></div>

    <div class="col-md-4">
    	<label style="font-size:20px">ID : 
    		@if($templateData && $templateData->count()>0)
    			<span id="formId">{{$templateData[0]->template_code}}-{{$templateData[0]->template_ref}}<span>
    		@else
    			<span id="formId"><span>
    			<br>
		    	<label id="formIdMessage">
		        	<font style="color: red">Select Template Department to generate Form ID</font>
		        </label>
    		@endif
    	</label>    	
    </div>
</div> -->--}}
<div class="row">
    {{--<!-- <div class="col-md-4" >
                @if($tempDepartments)
                    <label for="dept-id" class="mr-sm-2 mt-1">Template Department</label>
                    <select class="form-control mr-sm-2" id="template_dept" name="template_dept" required>
                        <option value="">Select Dept Names</option>
                        @foreach($tempHeaders as $tempHeader)
                            @if($tempHeader)
                                <optgroup label="===={{$tempHeader}}====">
                            @endif
                            @foreach($tempDepartments as $tempDepartment)
                                @if($tempDepartment->header == $tempHeader)
                                    @if($tempDepartment->code == $risk_assessment_data->template_code)
                                        <option value="{{$tempDepartment->code}}" selected>{{$tempDepartment->name}}</option>
                                    @else
                                        <option value="{{$tempDepartment->code}}">{{$tempDepartment->name}}</option>
                                    @endif   
                                @endif
                            @endforeach
        
                            @if($tempHeader)
                                </optgroup> 
                            @endif
                        @endforeach
                    </select>
                @else
                    @if($templateData && $templateData->count()>0)
                        <label>Template Department <br><b>{{$templateData[0]->template_department_name}}</b></label>
                    @endif
                @endif
                <input type = "hidden" name = "template_dept_id" id="template_dept_id">
            </div> -->--}}
    <div class="col-md-12">
    	<label>Enter template name<font style="color: red;font-size: 25px">*</font></label>
        <input type="text" class="form-control" id="template_name" placeholder="Enter Template Name" name="template_name" value="{{$templateName}}">
    </div>
</div>
<input type = "hidden" name = "is_template" id="is_template" value = "{{config('constants.template_creation.ADMIN')}}">