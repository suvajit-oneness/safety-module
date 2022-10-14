@extends('layouts.app')

@section('template_title')
    Incident reporting|Queary
@endsection
<div class="card shadow-lg" style="width:51rem;height:40vh; position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);">
    <div class="card-header"> 
        <h4 style = "text-align:center;">Continue With Previous Draft?</h4>
    </div>
    <div class="card-body">
        <div class="row mt-5">
            <div class="col-6">
                <a href="/incidentContinueWithPreviousDraft"><center><button class = "btn btn-success">Yes</button></center></a>
            </div>
            <div class="col-6">
                <a href="/incidentNewDraft"><center><button class = "btn btn-primary">No</button></center></a>
            </div>
        </div>
    </div>
</div>