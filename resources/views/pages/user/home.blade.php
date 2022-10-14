{{-- @extends('layouts.app')

@section('template_title')
    {{ Auth::user()->name }}'s' Homepage
@endsection

@section('template_fastload_css')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-10 offset-lg-1">

                @include('panels.welcome-panel')

            </div>
        </div>
    </div>

@endsection

@section('footer_scripts')
@endsection --}}
@extends('layouts.app')

@section('template_title')
    Welcome {{ Auth::user()->name }}
@endsection

@section('head')
@endsection
@section('template_linked_css')
@endsection
<link rel="stylesheet" href="{{ asset('css/homepage/additional-css.css') }}">

<style>
    body{
        background-color: #fbfbfb !important;
    }
    .new{
        border-radius: 18px 18px 0px 0px !important;
    }
   /* numorphisom button */
   .navbar{
        /* background-color: #ffffff !important; */
        margin-bottom:20px !important;
        background: #ffffff !important;
        box-shadow:  5px 5px 10px #a7a7a7,
                    -5px -5px 10px #ffffff !important;
    }

    .numo-btn{
        border-radius: 18px !important;
        background: #ffffff !important;
        /* border: 1px solid blue; */
    }
    .numo-btn-close{
        color: black !important;
        border-radius: 18px !important;
        background: #ffffff !important;
        /* border: 1px solid blue; */
    }


    /* hover */
    .numo-btn:hover{
        border-radius: 18px !important;
        background: #e1e1e1 !important;
        
            }
    .numo-btn-close:hover{
        color: black !important;
        border-radius: 18px !important;
        background: #ffffff !important;
        
    }
    /* numorphisom button */
</style>

@section('content')
    <div class="container">
   
        {{--  Analytics  --}}
        @if ( session()->get('is_ship') == 0)
            
            <div class="dash">
                <div class="row mt-2 shadow-lg" style = "background-color:white;">
                    <div class="col-md-2">

                    </div>
                    <div class="col-md-1 text-center">
                        Total
                        <div class="shadow-lg mx-auto mt-2" style=" border-radius:5px; height: 10px; width:30px; background-color:blue"></div>
                    </div>
                    <div class="col-md-2 text-center">
                        Submitted
                        <div class="shadow-lg mx-auto mt-2" style=" border-radius:5px; height: 10px; width:30px; background-color:lightgreen"></div>
                    </div>
                    <div class="col-md-1 text-center">
                        Draft
                        <div class="shadow-lg mx-auto mt-2" style=" border-radius:5px; height: 10px; width:30px; background-color:purple"></div>
                    </div>
                    <div class="col-md-2 text-center">
                        Not Approved
                        <div class="shadow-lg mx-auto mt-2" style=" border-radius:5px; height: 10px; width:30px; background-color:red"></div>
                    </div>
                    <div class="col-md-2 text-center">
                        Approved
                        <div class="shadow-lg mx-auto mt-2" style=" border-radius:5px; height: 10px; width:30px; background-color:rgb(88, 250, 88)"></div>
                    </div>
                    <div class="col-md-2 text-center">
                        Correction Required
                        <div class="shadow-lg mx-auto mt-2" style=" border-radius:5px; height: 10px; width:30px; background-color:yellow"></div> 
                    </div>
                </div>
                {{-- Risk Assesment --}}
                <div class="row mt-2 shadow-lg" style = "background-color:white;height:35px;">
                    <div class="col-md-2 ">
                        <b>Risk Assesment</b>
                    </div>
                    <div class="col-md-1 text-center">
                        {{$chart['ra_total']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['ra_submitted']}}
                    </div>
                    <div class="col-md-1 text-center">
                        {{$chart['ra_draft']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['ra_not_approved']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['ra_approved']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['ra_correction_required']}} 
                    </div>
                </div>
                {{-- Risk Assesment End--}}
                {{-- Near Miss Accident --}}
                <div class="row mt-2 shadow-lg" style = "background-color:white;height:35px;">
                    <div class="col-md-2">
                        <b>Near Miss Accident</b>
                    </div>
                    <div class="col-md-1 text-center">
                        {{$chart['nearmiss_total']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['nearmiss_submitted']}}
                    </div>
                    <div class="col-md-1 text-center">
                        {{$chart['nearmiss_draft']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['nearmiss_not_approved']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['nearmiss_approved']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['nearmiss_correction_required']}} 
                    </div>
                </div>
                {{-- Near Miss Accident End--}}
                {{-- Incident --}}
                <div class="row mt-2 shadow-lg" style = "background-color:white;height:35px;">
                    <div class="col-md-2">
                        <b>Incident</b>
                    </div>
                    <div class="col-md-1 text-center">
                        {{$chart['incident_total']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['incident_submitted']}}
                    </div>
                    <div class="col-md-1 text-center">
                        {{$chart['incident_draft']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['incident_not_approved']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['incident_approved']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['incident_correction_required']}} 
                    </div>
                </div>
                {{-- Incident End--}}
                {{-- Inspection & Audits --}}
                <div class="row mt-2 shadow-lg" style = "background-color:white;height:35px;">
                    <div class="col-md-2 ">
                        <b>Inspection & Audits</b>
                    </div>
                    <div class="col-md-1 text-center">
                        {{$chart['inspection_and_audit_total']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['inspection_and_audit_submitted']}}
                    </div>
                    <div class="col-md-1 text-center">
                        {{$chart['inspection_and_audit_draft']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['inspection_and_audit_not_approved']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['inspection_and_audit_approved']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['inspection_and_audit_correction_required']}}
                    </div>
                </div>
                {{-- Inspection & Audits End--}}
                {{-- Management Of Change --}}
                <div class="row mt-2 shadow-lg" style = "background-color:white;height:40px;">
                    <div class="col-md-2 ">
                        <b>Management Of Change</b>
                    </div>
                    <div class="col-md-1 text-center">
                        {{$chart['moc_total']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['moc_submitted']}}
                    </div>
                    <div class="col-md-1 text-center">
                        {{$chart['moc_draft']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['moc_not_approved']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['moc_approved']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['moc_correction_required']}}
                    </div>
                </div>
                {{-- Management Of Change End--}}
                {{-- ISO Files  --}}
                <div class="row mt-2 shadow-lg" style = "background-color:white;height:35px;">
                    <div class="col-md-2 ">
                        <b>ISO Files</b>
                    </div>
                    <div class="col-md-1 text-center">
                        {{$chart['iso_total']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['iso_submitted']}}
                    </div>
                    <div class="col-md-1 text-center">
                        {{$chart['iso_draft']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['iso_not_approved']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['iso_approved']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['iso_correction_required']}}
                    </div>
                </div>
                {{-- ISO Files End --}}
                {{-- Right Ship   --}}
                <div class="row mt-2 shadow-lg" style = "background-color:white;height:35px;">
                    <div class="col-md-2 ">
                        <b>Right Ship</b>
                    </div>
                    <div class="col-md-1 text-center">
                        {{$chart['rs_total']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['rs_submitted']}}
                    </div>
                    <div class="col-md-1 text-center">
                        {{$chart['rs_draft']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['rs_not_approved']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['rs_approved']}}
                    </div>
                    <div class="col-md-2 text-center">
                        {{$chart['rs_correction_required']}}
                    </div>
                </div>
                {{-- Right Ship  End --}}
                <center><h5 class = "my-2">Inspection & Audit</h5></center>
                <div class="row mt-2 shadow-lg" style = "height:40px;">
                    <div class="col-md-4 mt-2">
                        <h6 class="text-center font-weight-bold">Due Dates</h6>
                    </div>
                    <div class="col-md-4 mt-2">
                        Within Last 30 Days : {{$chart['audit_last_thirty_day']}}
                    </div>
                    <div class="col-md-4 mt-2">
                        More Than 30 Days :  {{$chart['audit_after_thirty_day']}}
                    </div>
                    
                </div>
            </div>
        @endif
  
        {{--Risk Assessment Start --}}
        <div class="row my-3 shadow-lg" style = "background-color:white;">
            <div class="col-md-3">
                <div class="card-header  bg-danger" style = "border-radius: 10px 0px 0px 10px;color:white;">Risk Assessment</div>
            </div>
            
            <div class="col-md-3">
                <a href="/userRiskAssesment">
                    <button type="button" class="btn btn-danger custom-btn mt-2 numo-btn-close">Risk Assessment Form</button>
                </a>
            </div>
            <div class="col-md-3">
                <a href="/hazard-master">
                    <button type="button" class="btn btn-danger custom-btn mt-2 numo-btn-close" >Ship Hazard Database</button>
                </a>
            </div>
        </div>
        {{--Risk Assessment End --}}
        
        {{--Near Miss Accident Start--}}
        <div class="row my-3 shadow-lg" style = "background-color:white;">
            <div class="col-md-3">
                <div class="card-header bg-warning" style = "border-radius: 10px 0px 0px 10px;color:white;">Near Miss Accident</div>
            </div>
            <div class="col-md-3">
                <a  href="/Near_Miss">
                    <button type="button" class="btn btn-warning custom-btn numo-btn-close">Near Miss Accident Reporting</button>
                </a>
            </div>
            
        </div>
        {{--Near Miss Accident End--}}
        
        {{--Incient Start--}}
        <div class="row my-3 shadow-lg" style = "background-color:white;">
            <div class="col-md-3">
                <div class="card-header bg-primary" style = " border-radius: 10px 0px 0px 10px;color:white;">Incident</div>
            </div>
            <div class="col-md-3">
                <a href="/incident-reporting">
                    <button type="button" class="btn btn-primary custom-btn numo-btn-close">Incident Reporting</button>
                </a>
            </div>  
        </div>
        {{--Incient End--}}

        
        {{--Inspection & Audit Start--}}
        <div class="row my-3 shadow-lg" style = "background-color:white;">
            <div class="col-md-3">
                <div class="card-header" style="border:1px solid #8b0771; background-color:#8b0771;border-radius: 10px 0px 0px 10px;color:white;">Inspection & Audit</div>
            </div>
            <div class="col-md-3">
                <a href="/inspection-audit">
                    <button type="button" class="btn btn-primary custom-btn numo-btn-close" style="border:1px solid #8b0771!important;">Inspection & Audit</button>
                </a>
            </div>  
        </div>
        {{--Inspection & Audit End--}}

        {{--Management Of Change Start--}}
        <div class="row my-3 shadow-lg" style = "background-color:white;">
            <div class="col-md-3">
            <div class="card-header  bg-success" style="border:1px solid #8b0771; background-color:#8b0771;border-radius: 10px 0px 0px 10px;color:white;">Management Of Change</div>
            </div>
            <div class="col-md-3">
                <a href="/moc">
                    <button type="button" class="btn btn-primary custom-btn numo-btn-close" >Management Of Change</button>
                </a>
            </div>  
        </div>
        {{--Management Of Change End--}}

        {{--ISO Files Start --}}
        <div class="row my-3 shadow-lg" style = "background-color:white;">
            <div class="col-md-3">
                <div class="card-header " style = "background-color: rgb(21, 149, 149);border-radius: 10px 0px 0px 10px;color:white;">ISO Files </div>
            </div>
            <div class="col-md-3">
                <a href="/constuct">
                    <button type="button" class="btn btn-primary custom-btn numo-btn-close mt-3">Legal</button>
                </a>
            </div>
            <div class="col-md-3">
                <a href="/constuct">
                    <button type="button" class="btn btn-primary custom-btn numo-btn-close mt-3">Environment</button>
                </a>
            </div>
            <div class="col-md-3">
                <a href="/constuct">
                    <button type="button" class="btn btn-primary custom-btn numo-btn-close mt-3">Safety Kpi</button>
                </a>
            </div>  
        </div>
        {{--ISO Files End --}}

        @if(session('vessels') && 
            session('vessels')[0]->type && 
            session('vessels')[0]->type == config('constants.SHIP_TYPE.TANKER')
            )  
            
            {{--TSMA Start--}}
            <div class="row my-3 shadow-lg" style = "background-color:white;">
                <div class="col-md-3">
                    <div class="card-header " style = "background-color:rgb(35, 152, 113);border-radius: 10px 0px 0px 10px;color:white;">TSMA</div>
                </div>
                <div class="col-md-3">
                    <a href="/constuct">
                        <button type="button" class="btn btn-primary custom-btn numo-btn-close">TSMA One</button>
                    </a>
                </div>  
            </div>
            {{--TSMA End--}}
            
        @else 
            {{--Right Ship Start--}}
            <div class="row my-3 shadow-lg" style = "background-color:white;">
                <div class="col-md-3">
                    <div class="card-header " style = "background-color:rgb(35, 152, 113);border-radius: 10px 0px 0px 10px;color:white;">Right Ship</div>
                </div>
                <div class="col-md-3">
                    <a href="/constuct">
                        <button type="button" class="btn btn-primary custom-btn numo-btn-close">Right Ship</button>
                    </a>
                </div>  
            </div>
            {{--Right Ship End--}}
        @endif
    </div>


@endsection
