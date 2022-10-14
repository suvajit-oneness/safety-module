@extends('layouts.app')
@section('template_title')
    Location
@endsection
@section('template_linked_css')
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

    <link rel="stylesheet" href="/css/dataTables/dataTables.bootstrap.min.css">
@endsection
@section('content')
@if(session('is_ship'))
<div class="container-fluid">
    <div class="card">
        <div class="card-body">

            <div class="row mb-3 ml-2">
                <a href="/vessel_details/create">
                    <button class="btn btn-danger"><i class="fa fa-plus-circle"></i> Add New Vessel</button>
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
                                <th class="text-center">company id</th>
                                <th class="text-center">unique id</th>
                                <th class="text-center">prefix</th>
                                <th class="text-center">type</th>
                                <th class="text-center">fleet id</th>
                                {{-- <th class="text-center">vessel image</th> --}}
                                <th class="text-center">vessel code</th>
                                <th class="text-center">class society</th>
                                <th class="text-center">imo no</th>
                                <th class="text-center">year built</th>
                                <th class="text-center">owner</th>
                                <th class="text-center">hull no</th>
                                <th class="text-center">grt</th>
                                <th class="text-center">call sign</th>
                                <th class="text-center">flag</th>
                                <th class="text-center">nrt</th>
                                <th class="text-center">length</th>
                                <th class="text-center">port of registry</th>
                                <th class="text-center">breadth</th>
                                <th class="text-center">moulded depth</th>
                                <th class="text-center">action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vessel_data as $vessel)
                                <tr>
                                    <td class="text-center">{{$i++}}</td>
                                    <td class="text-center">{{$vessel->name}}</td>
                                    <td class="text-center">{{$vessel->company_id}}</td>
                                    <td class="text-center">{{$vessel->unique_id}}</td>
                                    <td class="text-center">{{$vessel->prefix}}</td>
                                    <td class="text-center">{{$vessel->type}}</td>
                                    <td class="text-center">{{$vessel->fleet_id}}</td>
                                    {{-- <td class="text-center">{{$vessel->vessel_image}}</td> --}}
                                    <td class="text-center">{{$vessel->vessel_code}}</td>
                                    <td class="text-center">{{$vessel->class_society}}</td>
                                    <td class="text-center">{{$vessel->imo_no}}</td>
                                    <td class="text-center">{{$vessel->year_built}}</td>
                                    <td class="text-center">{{$vessel->owner}}</td>
                                    <td class="text-center">{{$vessel->hull_no}}</td>
                                    <td class="text-center">{{$vessel->grt}}</td>
                                    <td class="text-center">{{$vessel->call_sign}}</td>
                                    <td class="text-center">{{$vessel->flag}}</td>
                                    <td class="text-center">{{$vessel->nrt}}</td>
                                    <td class="text-center">{{$vessel->length}}</td>
                                    <td class="text-center">{{$vessel->port_of_registry}}</td>
                                    <td class="text-center">{{$vessel->breadth}}</td>
                                    <td class="text-center">{{$vessel->moulded_depth}}</td>
                                    <td class="text-center">
                                        <form action="/vessel_details/{{$vessel->id}}" method="POST">
                                            {{ method_field('DELETE') }}
                                            <button class="btn  btn-danger" type="submit" onclick="return confirm('Are you sure you want to delete this item?');" href="vessel_details/destroy/{{$vessel->id}}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        </form>
                                        <br>
                                        <a class="btn btn-info" href="/vessel_details/{{$vessel->id}}/edit">
                                            <i class="fa fa-edit"></i>
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
@else
<div class="container-fluid">
    <div class="card">
        <div class="card-body">

            <div class="row mb-3 ml-2">
                <a href="/vessel_details/create">
                    <button class="btn btn-danger"><i class="fa fa-plus-circle"></i> Add New Vessel</button>
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
                                <th class="text-center">company id</th>
                                <th class="text-center">unique id</th>
                                <th class="text-center">prefix</th>
                                <th class="text-center">type</th>
                                <th class="text-center">fleet id</th>
                                {{-- <th class="text-center">vessel image</th> --}}
                                <th class="text-center">vessel code</th>
                                <th class="text-center">class society</th>
                                <th class="text-center">imo no</th>
                                <th class="text-center">year built</th>
                                <th class="text-center">owner</th>
                                <th class="text-center">hull no</th>
                                <th class="text-center">grt</th>
                                <th class="text-center">call sign</th>
                                <th class="text-center">flag</th>
                                <th class="text-center">nrt</th>
                                <th class="text-center">length</th>
                                <th class="text-center">port of registry</th>
                                <th class="text-center">breadth</th>
                                <th class="text-center">moulded depth</th>
                                <th class="text-center">action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vessel_data as $vessel)
                                <tr>
                                    <td class="text-center">{{$i++}}</td>
                                    <td class="text-center">{{$vessel->name}}</td>
                                    <td class="text-center">{{$vessel->company_id}}</td>
                                    <td class="text-center">{{$vessel->unique_id}}</td>
                                    <td class="text-center">{{$vessel->prefix}}</td>
                                    <td class="text-center">{{$vessel->type}}</td>
                                    <td class="text-center">{{$vessel->fleet_id}}</td>
                                    {{-- <td class="text-center">{{$vessel->vessel_image}}</td> --}}
                                    <td class="text-center">{{$vessel->vessel_code}}</td>
                                    <td class="text-center">{{$vessel->class_society}}</td>
                                    <td class="text-center">{{$vessel->imo_no}}</td>
                                    <td class="text-center">{{$vessel->year_built}}</td>
                                    <td class="text-center">{{$vessel->owner}}</td>
                                    <td class="text-center">{{$vessel->hull_no}}</td>
                                    <td class="text-center">{{$vessel->grt}}</td>
                                    <td class="text-center">{{$vessel->call_sign}}</td>
                                    <td class="text-center">{{$vessel->flag}}</td>
                                    <td class="text-center">{{$vessel->nrt}}</td>
                                    <td class="text-center">{{$vessel->length}}</td>
                                    <td class="text-center">{{$vessel->port_of_registry}}</td>
                                    <td class="text-center">{{$vessel->breadth}}</td>
                                    <td class="text-center">{{$vessel->moulded_depth}}</td>
                                    <td class="text-center">
                                        <form action="/vessel_details/{{$vessel->id}}" method="POST">
                                            {{ method_field('DELETE') }}
                                            <button class="btn  btn-danger" type="submit" onclick="return confirm('Are you sure you want to delete this item?');" href="vessel_details/destroy/{{$vessel->id}}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        </form>
                                        <br>
                                        <a class="btn btn-info" href="/vessel_details/{{$vessel->id}}/edit">
                                            <i class="fa fa-edit"></i>
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
@endif

@endsection
@section('footer_scripts')
    <script type="text/javascript" src="/js/dataTables/dataTables.min.js"></script>
    <script type="text/javascript" src="/js/custom/location/location.js"></script>
@endsection
