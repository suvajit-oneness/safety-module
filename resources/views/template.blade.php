@extends('layouts.app')
@section('template_title')
    Template
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
        <h1 align="center">TEMPLATE</h1>
            <div class="row mb-3 ml-2">

                {{-- Condition added by Onenesstechs- For add a new template only for shore admin --}}

                @if(Auth::guard('web')->user()->is_ship != 1)
                <div class="col-lg-3">
                    <a href="/adminTemplateCreate">
                        <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Add New Template">
                            <i class="fa fa-plus-circle"></i> Add New Template
                        </button>
                    </a>
                </div>
                @endif

                {{-- Condition added by Onenesstechs- For add a new template only for shore admin --}}
                
                <!-- <div class="col-lg-3">
                    <a href="/adminTemplateCreate">
                        <button class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="Add New Template">
                            <i class="fa fa-plus-circle"></i> Add New Risk Assessment
                        </button>
                    </a>
                </div> -->
            </div>
            <div id="Templates" class="tabcontent tabShown"> 
                <div class="row">
                    <div class="col-lg-12 table-responsive">
                        <table class="table table-bordered" id="templates_table">
                            <thead>
                                <tr>
                                    <th class="text-center">Template name</th>
                                    <th class="text-center">Created_on</th>
                                    <th class="text-center">Created_by</th>
                                    <th class="text-center">Ship/Shore</th>
                                    <th class="text-center">Ship_id/Shore_id</th>
                                    <th class="text-center">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($templates as $template)
                                    <tr>
                                        
                                        <td class="text-center">{{$template->name}}</td>
                                        @php
                                            $d=strtotime($template->created_at);
                                            $date = date("d-F,Y ", $d);    
                                        @endphp
                                        <td class="text-center">
                                            {{$date}}
                                        </td>
                                        <td class="text-center">{{$template->creator_email}}</td>
                                        @if($template->is_ship == 0 )
                                            <td class="text-center">Shore</td>
                                        @else
                                            <td class="text-center">Ship</td>
                                        @endif
                                        <td class="text-center">{{$template->creator_id}}</td>
                                        <td class="text-center">
                                            {{-- Condition added by Onenesstechs- For add a new template only for shore admin --}}
                                            @if(Auth::guard('web')->user()->is_ship != 1)
                                                <a class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" 
                                                onclick="return confirm('Are you sure you want to delete this item?');" href="/adminDeleteTemplate/{{$template->template_id}}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                                <a class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"
                                                href="/adminEditTemplate/{{$template->template_id}}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            
                                                <a class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Duplicate"
                                               href="/templateDuplicate/{{$template->template_id}}">
                                                    <i class="fa fa-clone"></i>
                                                </a>
                                            @endif 
                                            {{-- --------------------------------------------------------------------------- --}}
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
@section('footer_scripts')
    <script type="text/javascript" src="/js/dataTables/dataTables.min.js"></script>
    <script type="text/javascript" src="\js\custom\Template\index.js"></script>
@endsection
   
