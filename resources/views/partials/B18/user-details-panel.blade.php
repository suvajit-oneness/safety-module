<input type = "hidden" name = "is_template" id="is_template" value = "{{config('constants.template_creation.USER')}}">

<div class="row mt-3">
    <!-- <div class="col">
        <label for="review-date" class="mr-sm-2 mt-1">Vessel Name:</label>
        @if(isset($risk_assessment_data->vessel_name) && $risk_assessment_data->vessel_name)
          <input type="text" class="form-control mr-sm-2" id="vessel_name" placeholder="Enter Vessel Name" name="vessel_name" value="{{$risk_assessment_data->vessel_name}}">
        @else
            <input type="text" class="form-control mr-sm-2" id="vessel_name" placeholder="Enter Vessel Name" name="vessel_name">
        @endif     
    </div> -->
    <div class="col" >
        <label for="vessel-id" class="">Vessel Name:</label>
        @if(isset($risk_assessment_data->vessel_id) && $risk_assessment_data->vessel_id)
            <select class="form-control mr-sm-2" id="vessel_id" name="vessel_id" required>
              <option value="">Select a vessel name</option>
              @foreach($vessels as $vessel)
                @if($risk_assessment_data->vessel_id == $vessel->id)
                    <option value="{{$vessel->id}}" selected>{{$vessel->name}}</option>
                @else
                    <option value="{{$vessel->id}}">{{$vessel->name}}</option>
                @endif
              @endforeach
            </select>
        @else
            <select class="form-control mr-sm-2" id="vessel_id" name="vessel_id" required>
              <option value="">Select a vessel name</option>
              @foreach($vessels as $vessel)
                <option value="{{$vessel->id}}">{{$vessel->name}}</option>
              @endforeach
            </select>
        @endif
    </div>
    <div class="col">
        <label for="review-date" class="mr-sm-2 mt-1">Date:</label>
        @if(isset($risk_assessment_data->review_date) && $risk_assessment_data->review_date)
            <input type="text" class="datepicker form-control mr-sm-2" id="review-date" min=""
        placeholder="Select Review Date" name="review-date" value="{{date('d-M-Y',strtotime($risk_assessment_data->review_date))}}">
        @else
            <input type="text" class="datepicker form-control mr-sm-2" id="review-date" min=""
        placeholder="Select Review Date" name="review-date">
        @endif
    </div>
    <div class="col">
        <label for="weather" class="mr-sm-2 mt-1">Wind/Weather:</label>
        @if(isset($risk_assessment_data->weather) && $risk_assessment_data->weather)
          <input type="text" class="form-control mr-sm-2" id="weather" placeholder="Enter Weather" name="weather"value="{{$risk_assessment_data->weather}}">
        @else
            <input type="text" class="form-control mr-sm-2" id="weather" placeholder="Enter Weather" name="weather">
        @endif
    </div>
</div>
<div class="row mt-3">
    <div class="col">
        <label for="voyage" class="mr-sm-2 mt-1">Voyage#:</label>
        @if(isset($risk_assessment_data->voyage) && $risk_assessment_data->voyage)
          <input type="text" class="form-control mr-sm-2" id="voyage" placeholder="Enter Voyage" name="voyage"  value="{{$risk_assessment_data->voyage}}">
        @else
            <input type="text" class="form-control mr-sm-2" id="voyage" placeholder="Enter Voyage" name="voyage" >
        @endif
    </div>
    <div class="col">
        <label for="location" class="mr-sm-2 mt-1">Port/Location:</label>
        @if(isset($risk_assessment_data->location) && $risk_assessment_data->location)
          <input type="text" class="form-control mr-sm-2" id="location" placeholder="Enter Location" name="location"  value="{{$risk_assessment_data->location}}">
        @else
            <input type="text" class="form-control mr-sm-2" id="location" placeholder="Enter Location" name="location" >
        @endif
    </div>
    <div class="col">
        <label for="tide" class="mr-sm-2 mt-1">Tide:</label>
        @if(isset($risk_assessment_data->tide) && $risk_assessment_data->tide)
          <input type="text" class="form-control mr-sm-2" id="tide" placeholder="Enter Tide" name="tide"  value="{{$risk_assessment_data->tide}}">
        @else
            <input type="text" class="form-control mr-sm-2" id="tide" placeholder="Enter Tide" name="tide" >
        @endif
    </div>
</div>
<div class="row mt-3">
    <div class="col">
        <label for="work_activity" class="mr-sm-2 mt-1">Work activity being assessed:</label>
        @if(isset($risk_assessment_data->work_activity) && $risk_assessment_data->work_activity)
          <input type="text" class="form-control mr-sm-2" id="work_activity" placeholder="Enter Work Activity" name="work_activity" value="{{$risk_assessment_data->work_activity}}">
        @else
            <input type="text" class="form-control mr-sm-2" id="work_activity" placeholder="Enter Work Activity" name="work_activity">
        @endif
    </div>
    <div class="col">
        <label for="work_area" class="mr-sm-2 mt-1">Work Area:</label>
        @if(isset($risk_assessment_data->work_area) && $risk_assessment_data->work_area)
          <input type="text" class="form-control mr-sm-2" id="work_area" placeholder="Enter Work Area" name="work_area" value="{{$risk_assessment_data->work_area}}">
        @else
            <input type="text" class="form-control mr-sm-2" id="work_area" placeholder="Enter Work Area" name="work_area">
        @endif
    </div>
    <div class="col">
        <label for="visibility" class="mr-sm-2 mt-1">Visibilty:</label>
       @if(isset($risk_assessment_data->visibility) && $risk_assessment_data->visibility)
          <input type="text" class="form-control mr-sm-2" id="visibility" placeholder="Enter Visibilty" name="visibility"value="{{$risk_assessment_data->visibility}}">
        @else
            <input type="text" class="form-control mr-sm-2" id="visibility" placeholder="Enter Visibility" name="visibility">
        @endif
    </div>
</div>


{{--<!-- <div class="row">
    <div class="col-md-8">
    </div>
		
	<div class="col-md-4" style="text-align: right;">
		
            @if(isset($risk_assessment_data) && isset($risk_assessment_data->ref) && isset($risk_assessment_data->vessel_code) && $risk_assessment_data && $risk_assessment_data->ref && $risk_assessment_data->vessel_code)
            
                <label for="id" class="mr-sm-2" style=" margin-left: 100px;"><b>Risk Assessment ID:</b></label>
                <label for="vessel_select" class="pull-right">
                    RA-{{$risk_assessment_data->vessel_code}}-{{$risk_assessment_data->ref}}
                </label>
                <input type="hidden" id="refId" value="{{$risk_assessment_data->ref}}" name="refId">
            @else
            <label for="id" class="mr-sm-2"><b>Risk Assessment ID:</b></label>
                <label for="vessel_select" >RA-</label>
                <select class="mr-sm-2 form-control-custom " id="vessel_select">
                    <option value="">Select Code</option>
                    @if(isset($vessel_fleet) && $vessel_fleet)
                        @foreach($vessel_fleet as $vessel)
                            @if(isset($risk_assessment_data->vessel_id) && $risk_assessment_data->vessel_id && $vessel->id == $risk_assessment_data->vessel_id)
                                <option value="{{$vessel->id}}" selected>{{$vessel->code}}</option>
                            @else
                                <option value="{{$vessel->id}}">{{$vessel->code}}</option>
                            @endif                                                
                        @endforeach
                    @endif
                </select>-
                <label type="text" class="mr-sm-2 important " id="ra-id" placeholder="Enter ID" name="id">Select Vessel Code to generate Form no.</label>
                <!-- <input type="hidden" id="refId" name="refId">
                @if(isset($risk_assessment_data->ref) && $risk_assessment_data->ref)
                    <input type="hidden" id="refId" value="{{$risk_assessment_data->ref}}" name="refId">
                @else
                    <input type="hidden" id="refId" name="refId">
                @endif
            @endif
	</div>
</div>	
<!-- 2nd row
<div class="row mt-3">

	<div class="col" >
		<label for="vessel-id" class="">Vessel:</label>
        @if(isset($risk_assessment_data->vessel_id) && $risk_assessment_data->vessel_id)
		  <input type="text" class="form-control mr-sm-2" id="vessel-id" name="vessel-id" value="{{$risk_assessment_data->vessel_id}}" hidden>
        @else
            <input type="text" class="form-control mr-sm-2" id="vessel-id" name="vessel-id" hidden>
        @endif

        @if(isset($risk_assessment_data->vessel_name))
		  <input type="text" class="form-control mr-sm-2" id="vessel-id-2" name="vessel-id-2" value="{{$risk_assessment_data->vessel_name}}" disabled>
        @else
            <input type="text" class="form-control mr-sm-2" id="vessel-id-2" name="vessel-id-2" disabled>
        @endif
	</div>

	<div class="col" >
		<label for="fleet-id" class="mr-sm-2 mt-1">Fleet:</label>
        @if(isset($risk_assessment_data->fleet_id) && $risk_assessment_data->fleet_id)
		  <input type="text" class="form-control mr-sm-2" id="fleet-id" name="fleet-id" hidden value="{{$risk_assessment_data->fleet_id}}">
        @else
            <input type="text" class="form-control mr-sm-2" id="fleet-id" name="fleet-id" hidden>
        @endif

        @if(isset($risk_assessment_data->vessel_name) && $risk_assessment_data->vessel_name)
		  <input type="text" class="form-control mr-sm-2" id="fleet-id-2" name="fleet-id-2" value="{{$risk_assessment_data->vessel_name}}" disabled>   
        @else
            <input type="text" class="form-control mr-sm-2" id="fleet-id-2" name="fleet-id-2" disabled>   
        @endif
	</div>
-->--}}
	<div class="col" >
		<label for="dept-id" class="mr-sm-2 mt-1">Dept:</label>
		<!-- <input type="text" class="form-control mr-sm-2" id="dept-id" placeholder="dept-id" name="dept-id">  -->
		<select class="form-control mr-sm-2" id="dept-id" name="dept-id">
			<option value="">Select Dept Names</option>
            @if(isset($department) && $department)
                @foreach($department as $dept)
                    @if(isset($risk_assessment_data->dept_id) && $risk_assessment_data->dept_id && $dept->id == $risk_assessment_data->dept_id)
                        <option value="{{$dept->id}}" selected>{{$dept->name}}</option>
                    @else
                        <option value="{{$dept->id}}">{{$dept->name}}</option>
                    @endif                              
                @endforeach
            @endif
		</select>
	</div>
{{--<!--
	<div class="col" >
		<label for="location" class="mr-sm-2 mt-1">Location:</label>
		<!-- <input type="text" class="form-control mr-sm-2" id="location" placeholder="location" name="location"> 
		<select class="form-control mr-sm-2" id="location" name="location">
			<option value="">Select Locations</option>
            @if(isset($location) && $location)
                @foreach($location as $loc)
                    @if(isset($risk_assessment_data->loc_id) && $risk_assessment_data->loc_id && $loc->id == $risk_assessment_data->loc_id)
                        <option value="{{$loc->id}}" selected>{{$loc->name}}</option>
                    @else
                        <option value="{{$loc->id}}">{{$loc->name}}</option>
                    @endif                              
                @endforeach
            @endif
		</select>
	</div>

	<div class="col" >
		<label for="assess-date" class="mr-sm-2 mt-1 pl-2">Assess Date:</label>
        @if(isset($risk_assessment_data->assess_date) && $risk_assessment_data->assess_date)
            <input type="text" class="datepicker form-control mr-sm-2" id="assess-date" 
            placeholder="Select Assess Date" 
            name="assess-date" value="{{date('d-M-Y',strtotime($risk_assessment_data->assess_date))}}">
        @else
            <input type="text" class="datepicker form-control mr-sm-2" id="assess-date" 
            placeholder="Select Assess Date" 
            name="assess-date">
        @endif
	</div>
	</div>
  <!-- 3rd row 
<div class="row mt-1">
    <div class="col-md-6" >
		<label for="activity-name" class="mr-sm-2 mt-1" style="width:200px;">Activity Name:</label>
        @if(isset($risk_assessment_data->activity_name) && $risk_assessment_data->activity_name)
          <input type="text" class="form-control mr-sm-2" id="activity-name" placeholder="Enter Activity Name" name="activity-name" style="width:600px;" value="{{$risk_assessment_data->activity_name}}">
        @else
            <input type="text" class="form-control mr-sm-2" id="activity-name" placeholder="Enter Activity Name" name="activity-name" style="width:600px;">
        @endif
    </div>
    
    <div class="col-md-6" >
    	<label for="activity-type" class="mr-sm-2 mt-1">Activity Type:</label>
    	<!-- <input type="text" class="form-control mr-sm-2" id="activity-type" placeholder="Enter activity-type" name="activity-type" style="width:200px;"> 
    	<select class="form-control mr-sm-2" id="activity-type" name="activity-type">
            <option value="">Select Activity Type</option>
            @if(isset($risk_assessment_data->activity_type) && $risk_assessment_data->activity_type && $risk_assessment_data->activity_type == "Routine")
                <option value="Routine" selected>Routine</option>
                <option value="Non Routine">Non Routine</option>
                <option value="Non-routine with office">Non-routine with office</option>
            @elseif(isset($risk_assessment_data->activity_type) && $risk_assessment_data->activity_type && $risk_assessment_data->activity_type == "Non Routine")
                <option value="Routine">Routine</option>
                <option value="Non Routine" selected>Non Routine</option>
                <option value="Non-routine with office">Non-routine with office</option>
            @elseif(isset($risk_assessment_data->activity_type) && $risk_assessment_data->activity_type && $risk_assessment_data->activity_type == "Non-routine with office")
                <option value="Routine">Routine</option>
                <option value="Non Routine">Non Routine</option>
                <option value="Non-routine with office" selected>Non-routine with office</option>
            @else
                <option value="Routine">Routine</option>
                <option value="Non Routine">Non Routine</option>
                <option value="Non-routine with office">Non-routine with office</option>
            @endif
        </select>
    </div>
</div>
<!-- 4th row 
<div class="row mt-1">
    <div class="col-md-3" >
        <label for="assessed-by" class="mt-1">Assessed By:</label>
        @if(isset($risk_assessment_data->assessed_by) && $risk_assessment_data->assessed_by)
            <input type="text" class="form-control" id="assessed-by" placeholder="Enter Assessed By" name="assessed-by" value="{{$risk_assessment_data->assessed_by}}">
        @else
            <input type="text" class="form-control" id="assessed-by" placeholder="Enter Assessed By" name="assessed-by">
        @endif
    </div>
    <div class="col-md-3" >
        <label for="assess-rank" class="mt-1">Rank:</label>
        <!-- <input type="text" class="form-control mr-sm-2" id="rank" name="rank">
        <select class="form-control mr-sm-2" id="assess-rank" name="assess-rank">
            <option value="">Select Rank</option>        
            @if(isset($ranks) && $ranks)                             
                @foreach($ranks as $rank)
                    @if(isset($risk_assessment_data->assess_rank) && $risk_assessment_data->assess_rank && $risk_assessment_data->assess_rank == $rank->name)
                        <option value="{{$rank->name}}" selected>{{$rank->name}}</option>
                    @else
                        <option value="{{$rank->name}}">{{$rank->name}}</option>
                    @endif                                  
                @endforeach
            @endif          
        </select>
    </div>
    <div class="col-md-3" >
        <label for="review-date" class="mr-sm-2 mt-1">Review Date:</label>
        @if(isset($risk_assessment_data->review_date) && $risk_assessment_data->review_date)
            <input type="text" class="datepicker form-control mr-sm-2" id="review-date" min=""
        placeholder="Select Review Date" name="review-date" value="{{date('d-M-Y',strtotime($risk_assessment_data->review_date))}}">
        @else
            <input type="text" class="datepicker form-control mr-sm-2" id="review-date" min=""
        placeholder="Select Review Date" name="review-date">
        @endif
    </div>
    <div class="col-md-3" >
        <label for="activity-group" class="mr-sm-2 mt-1">Activity Group:</label>
        
        <select class="form-control mr-sm-2" id="activity-group" name="activity-group">
            <option value="">Select Activity Group</option>
            @if(isset($risk_assessment_data->activity_group) && $risk_assessment_data->activity_group && $risk_assessment_data->activity_group == 'General')
                <option value="General" selected>General</option>
                <option value="Maintainance">Maintainance</option>
                <option value="Navigation">Navigation</option>
                <option value="Operation">Operation</option>
            @elseif(isset($risk_assessment_data->activity_group) && $risk_assessment_data->activity_group && $risk_assessment_data->activity_group == 'Maintainance')
                <option value="General">General</option>
                <option value="Maintainance" selected>Maintainance</option>
                <option value="Navigation">Navigation</option>
                <option value="Operation">Operation</option>
            @elseif(isset($risk_assessment_data->activity_group) && $risk_assessment_data->activity_group && $risk_assessment_data->activity_group == 'Navigation')
                <option value="General">General</option>
                <option value="Maintainance">Maintainance</option>
                <option value="Navigation" selected>Navigation</option>
                <option value="Operation">Operation</option>
            @elseif(isset($risk_assessment_data->activity_group) && $risk_assessment_data->activity_group && $risk_assessment_data->activity_group == 'Operation')
                <option value="General">General</options>
                <option value="Maintainance">Maintainance</option>
                <option value="Navigation">Navigation</option>
                <option value="Operation" selected>Operation</option>
            @else
                <option value="General">General</options>
                <option value="Maintainance">Maintainance</option>
                <option value="Navigation">Navigation</option>
                <option value="Operation">Operation</option>
            @endif
        </select>
    </div>
</div> -->--}}
@if(isset($type) && $type == 'temp_use')
<input hidden type="text" id='form_temp' value= 'null' name = 'user_data'>
<div id="use"></div>
@endif