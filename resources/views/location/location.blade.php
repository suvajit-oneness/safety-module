@extends('layouts.app')
@section('template_title')
    Location
@endsection
@section('template_linked_css')
    <link rel="stylesheet" href="/css/dataTables/dataTables.bootstrap.min.css">
@endsection
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
        
            <div class="row mb-3 ml-2">
                <a href="/location/create">
                    <button class="btn btn-danger"><i class="fa fa-plus-circle"></i> Add New Location</button>
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
                                <th class="text-center">Location ID</th>
                                <th class="text-center">Location Name</th>
                                <th class="text-center">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($locations as $location)
                                <tr>
                                    <td class="text-center">{{$i++}}</td>
                                    <td class="text-center">{{$location->name}}</td>
                                    <td class="text-center">
                                        <form action="/location/{{$location->id}}" method="POST">
                                            {{ method_field('DELETE') }}
                                            <button class="btn  btn-danger" type="submit" onclick="return confirm('Are you sure you want to delete this item?');" href="location/{{$location->id}}">
                                                <i class="fa fa-trash"></i>    
                                            </button>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        </form>
                                        <a class="btn btn-primary" href="/location/{{$location->id}}/edit">
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
@endsection
@section('footer_scripts') 
    <script type="text/javascript" src="/js/dataTables/dataTables.min.js"></script>
    <script type="text/javascript" src="/js/custom/location/location.js"></script>
@endsection