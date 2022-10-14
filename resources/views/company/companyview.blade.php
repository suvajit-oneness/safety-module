@extends('layouts.app')

@section('template_title')
    Company
@endsection

@section('template_linked_css')
<link rel="stylesheet" href="/css/dataTables/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection
@section('content')
@php
  $stringLimit = config('constants.TABLE_STRING_SIZE');
@endphp
<div class="container-fluid">
    <div class="card">
        <div class="card-body">

            <div class="row mb-3 ml-2">
                <a href="/company/create">
                    <button class="btn btn-danger d-none"><i class="fa fa-plus-circle"></i> Add New Company</button>
                </a>
            </div>

            @php
                $i=1;
            @endphp
            <div class="row">
                <div class="col-lg-12 table-responsive">
                    <table class="table table-bordered" id="locations_table">
                        <thead>
                            <tr>
                                
                                <th class="text-center">#</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">unique id</th>
                                <th class="text-center">prefix</th>
                                {{--<th class="text-center">logo</th>--}}
                                <th class="text-center">location</th>

                                
                                <th class="text-center">Adresss</th>
                                <th class="text-center">Phone Number</th>
                                {{--<th class="text-center">action</th>--}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($company_data as $company)
                            <tr>
                                <td class="text-center">{{$i++}}</td>
                                <td class="text-center">{{$company->name}}</td>
                                <td class="text-center">{{$company->unique_id}}</td>
                                <td class="text-center">{{$company->prefix}}</td>
                       
                                {{--<td class="text-center"><img src={{asset($company->logo)}} width="100" height="100" alt="" srcset=""></td>  --}}
                                <td class="text-center">{{$company->location}}</td>
                                <td class="text-center">{{$company->address}}</td>
                                <td class="text-center">{{$company->phone_number}}</td>
                                {{--<td class="text-center">
                                    
                                  
                                  <a class="btn  btn-danger mb-2" type="button"  href="company/delete/{{$company->id}}">
                                       <i class="fa fa-trash"></i>
                                 </a>
                              
                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                   
                                    <br>
                                    <a class="btn btn-info" href="/company/edit/{{$company->id}}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('footer_scripts')
    <script type="text/javascript" src="/js/dataTables/dataTables.min.js"></script>
    <script type="text/javascript" src="/js/custom/location/location.js"></script>
@endsection