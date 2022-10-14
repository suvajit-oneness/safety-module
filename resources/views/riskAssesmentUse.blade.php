@extends('layouts.app')

@section('template_title')
    Risk Assessment Use
@endsection
@section('template_linked_css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="/js/custom/toastr/toastr.min.css" rel="stylesheet">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/css/dataTables/dataTables.bootstrap.min.css">
  <link href="/css/summernote/summernote.css" rel="stylesheet">
  <link href="/css/custom/riskAssessment/riskAssessmentCreate.css" rel="stylesheet">

@endsection
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">

            <form action="" method = 'POST' id = 'RiskForm' enctype="multipart/form-data">
                @csrf
               {{-- <input type = "hidden" name = "section_1_id" id="section_1_id" value = "{{$VesselInfoId}}">
                <input type = "hidden" name = "section_2_id" id="section_2_id" value = "{{$templateId}}">  --}}
                <input type = "hidden" name = "section_2_array" id="section_2_array" value = "">
                <input type = "hidden" name = "additional_control" id="additional_control" value = "">
                <div class="row">
                    <div class="col-md-12">
                        <label>Enter template name<font style="color: red;font-size: 25px">*</font></label>
                        <input readonly type="text" class="form-control" id="template_name" placeholder="Enter Template Name" name="template_name" value="{{$template[0]->name}}">
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col" >
                        <label for="dept-id" class="mr-sm-2 mt-1">Dept:</label>
                        <select class="form-control mr-sm-2" id="dept-id" name="dept-id">
                            <option hidden value="{{$dept_name->id}}" selected>{{$dept_name->name}}</option>
                            @foreach($department as $dept)
                            <option value="{{$dept->id}}">{{$dept->name}}</option>
                            @endforeach

                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    {{--<div class="col" >
                        <label for="vessel-id" class="">Vessel Name<font style="color: red;font-size: 25px">*</font>:</label>
                        <select class="form-control mr-sm-2" id="vessel_id" name="vessel_id" required>
                            <option hidden value="{{$vessel_name->id}}" selected>{{$vessel_name->name}}</option>
                            @foreach($vessels as $vessel)
                                <option value="{{$vessel->id}}">{{$vessel->name}}</option>
                            @endforeach
                            </select>

                    </div>
                   <div class="col" >
                        <label for="vessel-id" class="">Vessel Name<font style="color: red;font-size: 25px">*</font>:</label>
                            <select class="form-control mr-sm-2" id="vessel_id" name="vessel_id" required>
                            <option hidden value="">Select a vessel name</option>
                            @foreach($vessels as $vessel)
                                <option value="{{$vessel->id}}">{{$vessel->name}}</option>
                            @endforeach
                            </select>

                    </div>
                    <div class="col">
                        <label for="review-date" class="mr-sm-2 mt-1">Date:</label>

                            <input type="text" class="datepicker form-control mr-sm-2" id="review-date" min=""
                        placeholder="Select Review Date" name="review-date">

                    </div>
                    <div class="col">
                        <label for="weather" class="mr-sm-2 mt-1">Wind/Weather:</label>
                        <input type="text" class="form-control mr-sm-2" id="weather" placeholder="Enter Weather" name="weather">

                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <label for="voyage" class="mr-sm-2 mt-1">Voyage#:</label>

                            <input type="text" class="form-control mr-sm-2" id="voyage" placeholder="Enter Voyage" name="voyage" >

                    </div>
                    <div class="col">
                        <label for="location" class="mr-sm-2 mt-1">Port/Location:</label>

                            <input type="text" class="form-control mr-sm-2" id="location" placeholder="Enter Location" name="location" >

                    </div>
                    <div class="col">
                        <label for="tide" class="mr-sm-2 mt-1">Tide:</label>
                        <input type="text" class="form-control mr-sm-2" id="tide" placeholder="Enter Tide" name="tide" >

                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <label for="work_activity" class="mr-sm-2 mt-1">Work activity being assessed:</label>
                        <input type="text" class="form-control mr-sm-2" id="work_activity" placeholder="Enter Work Activity" name="work_activity">

                    </div>
                    <div class="col">
                        <label for="work_area" class="mr-sm-2 mt-1">Work Area:</label>

                            <input type="text" class="form-control mr-sm-2" id="work_area" placeholder="Enter Work Area" name="work_area">

                    </div>
                    <div class="col">
                        <label for="visibility" class="mr-sm-2 mt-1">Visibilty:</label>

                            <input type="text" class="form-control mr-sm-2" id="visibility" placeholder="Enter Visibility" name="visibility">

                    </div>--}}
                </div>
                <div class="row mt-3">

                    <div id="createe" class = "mt-2"> </div>
                    <input hidden type="text" id='form_temp' value= 'null' name = 'form_temp'>
                    <input hidden type="text" id='key' value= '{{$template[0]->key}}' name = 'key'>

                </div>
                <hr>
                @include('partials.B18.hazard-table-section2-b18')
                <hr>



                <div class="row mt-3">
        			<div class="col-md-12" style="text-align:center;">
        				<button id="RAfrmSubmit" class="btn btn-primary" type="submit"  >
                            Submit
                        </button>
        			</div>
        	   </div>
            </form>
        </div>
    </div>
</div>
@include('modals.custom.risk-matrix-modal')
@include('modals.custom.riskAssessment.modal-add-second-risk-section')
@endsection
@section('footer_scripts')
    <!-- dynamic form building -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
    <!-- summernote -->
    <script type="text/javascript" src="/js/summernote/summernote.js"></script>
    <!-- ajax form -->
    <script src="/js/jquery/jquery.form.js"></script>
    <script>
        var riskMatriceColor = {!! json_encode($riskMatriceColor) !!};
        var riskFactor = {!! json_encode($riskFactor) !!};
        var templateData = {!! json_encode($templateData) !!};
        var isAdmin = {!! json_encode(Auth::user()->isAdmin()) !!};
        var redirectAddress = '/userRiskAssesment';
    </script>

    <script>


        $(document).ready(function(){
            var jsonForm = {!! json_encode($formJson) !!};
            const formRenderOptions = {
		        formData: jsonForm
		    }

            var formRenderInstance = $('#createe').formRender(formRenderOptions);

            $('#RiskForm').submit(function() {
                console.log('click');
                $('#form_temp').val(JSON.stringify(formRenderInstance.userData));
                if($('#form_temp').val()=='null'){
                    console.log('false');
                    // console.log(JSON.stringify(formRenderInstance.userData));
                    // // console.log(test);
                    console.log(hey);
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
            // $('#RAfrmSubmit').click(function(){
            //     console.log('click');

            // });
        });
    </script>
<script type="text/javascript" src="\js\custom\RiskAssessment\second_section.js"></script>
<script type="text/javascript" src="\js\custom\RiskAssessment\risk_assessment_create.js"></script>

@endsection

