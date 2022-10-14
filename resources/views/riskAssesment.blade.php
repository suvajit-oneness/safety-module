@extends('layouts.app')
@section('template_title')
    Risk Assesment
@endsection
@section('template_linked_css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="/css/dataTables/dataTables.bootstrap.min.css">
<link href="/css/custom/b18/index.css" rel="stylesheet"> 
@endsection
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h1 align="center">USE TEMPLATE</h1>
            <div class="row mb-3 ml-2">
                <a href="/riskAssesmentView">
                    <button class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="View/Edit User Forms">
                         User Forms
                    </button>
                </a>
                @if(Auth::user()->isAdmin())
                    <a href="/template">
                        <button class="btn btn-primary ml-2" data-toggle="tooltip" data-placement="top" title="Add New Template">
                             Go to Templates
                        </button>
                    </a>
                @endif
            </div> 
            <div id="Templates" class="tabcontent tabShown"> 
                <div class="row">
                    <div class="col-lg-12 table-responsive">
                        <table class="table table-bordered" id="templates_table">
                            <thead>
                                <tr>
                                    <th class="text-center">Template name</th>
                                    <th class="text-center">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($templates as $template)
                                    <tr>
                                        
                                        <td class="text-center">{{$template->name}}</td>
                                        
                                        <td class="text-center">
                                            <a class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="use"
                                               href="/useMyRiskAssesment/{{$template->template_id}}">
                                                   Use
                                            </a>
                                            
                                          
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 

        </div>
    </div>
</div>
@endsection
   
