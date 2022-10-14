@extends('layouts.app')

@section('template_title') 
    Risk Assessment
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
            @include('partials.B18.title')
            <!-- <div class="row">
                <a href="/risk_assessment" class="btn btn-dark"><i class="fa fa-long-arrow-left"></i></a>
            </div> -->
            <form method="post" action="/risk_assessment_submit" class="form" id="risk_assessment_form">
                <!-- @csrf -->
            	<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                <input type = "hidden" name = "section_1_id" id="section_1_id" value = "{{$VesselInfoId}}">
                <input type = "hidden" name = "section_2_id" id="section_2_id" value = "{{$templateId}}">                
                <input type = "hidden" name = "section_2_array" id="section_2_array" value = "">
                <input type = "hidden" name = "additional_control" id="additional_control" value = "">
                <input type = "hidden" name = "form_builder_json" id="form_builder_json" value = "">

                @if(!Auth::user()->isAdmin())
                    @include('partials.B18.user-details-panel')
                @else
                    @include('partials.B18.template-name')
                    @include('partials.B18.admin-details-panel')
                @endif
                <hr>
                @include('partials.B18.hazard-table-section2-b18')                
                <hr>
                @if(Auth::user()->isAdmin())
                   @include('partials.B18.footer-details')  
                @endif             
        	   <div class="row mt-3">
        			<div class="col-md-12" style="text-align:center;">
        				<button id="RAfrmSubmit" class="btn btn-primary" type="button" name="submit" title="Click to submit" >
                            Submit
                        </button>	   			
        			</div>
        	   </div>
            </form>
        </div>
    </div>
    <br>
    <p class="text-center"><b>
        RESPECT SAFETY OF LIFE, ENVIRONMENT & PROPERTY<br>
        CAREFULLY READ AND COMPLY WITH THE  COMPREHENSIVE DIRECTIVES AND GUIDELINES CONTAINED IN “SMS VOLUME IV: JOB HAZARD ANALYSIS PROCEDURES”</b><br>
        <b style="color:red;">"THE LIFE YOU SAVE IS MAY BE YOUR OWN!"</b>
    </p>
</div>
@include('modals.custom.risk-matrix-modal')
@include('modals.custom.riskAssessment.modal-add-second-risk-section')
@endsection


@section('footer_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" src="\js\custom\toastr\toastr.min.js"></script>
    <script>
        var riskMatriceColor = {!! json_encode($riskMatriceColor) !!};
        var riskFactor = {!! json_encode($riskFactor) !!};
        var templateData = {!! json_encode($templateData) !!};
        var isAdmin = {!! json_encode(Auth::user()->isAdmin()) !!};
    </script>
    <script src="/js/jquery/jquery.form.js"></script>
    <script type="text/javascript" src="/js/dataTables/dataTables.min.js"></script>
    <script type="text/javascript" src="/js/summernote/summernote.js"></script>


    <!-- dynamic form building -->    
    <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
    
    {{-- <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
    </script> --}}
    <script type="text/javascript" src="\js\custom\RiskAssessment\second_section.js"></script>
	<script type="text/javascript" src="\js\custom\RiskAssessment\risk_assessment_create.js"></script>
@endsection