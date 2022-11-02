@extends('layouts.app')

@section('template_title')
    Vessel Report
@endsection

@section('template_linked_css')
  <link rel="stylesheet" href="/css/dataTables/dataTables.bootstrap.min.css">


@endsection

@section('content')
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<div class="container">
    <div class="card p-3 shadow">
        <h2 class="font-weight-light text-center mt-5">Vessel Details</h2>

        @if ($vessel_data)

            {{-- Vessel Details Showing
            ======================================= --}}
            <div class="container">
                {{-- name and vessel code --}}
                @if($vessel_data->name || $vessel_data->vessel_code)
                    <div class="my-4">
                        <div class='row'>
                            @if($vessel_data->name)
                            <div class='col'>
                                <h4 class='font-weight-bold'>Name </h4>
                                <h6> {{$vessel_data->name}} </h6>
                            </div>
                            @endif

                            @if($vessel_data->vessel_code)
                                <div class='col'>
                                    <h4 class='font-weight-bold'>Vessel Code</h4>
                                    <h6> {{$vessel_data->vessel_code}} </h6>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
                
                @if($vessel_data->class_society || $vessel_data->type)
                    {{-- class society --}}
                    @if($vessel_data->class_society)
                        <div class="my-4">
                            <h4 class="font-weight-bold">Class Society </h4>
                            <h6>{{ $vessel_data->class_society }}</h6>
                        </div>
                    @endif
                    {{-- type --}}
                    @if($vessel_data->type)
                    <div class="my-4">
                        <h4 class="font-weight-bold">Type </h4>
                        <h6>{{ $vessel_data->type }}</h6>
                    </div>
                    @endif
                @endif

                {{-- imo no and year built --}}
                @if($vessel_data->imo_no || $vessel_data->year_built)
                    <div class="my-4">
                        <div class="row">
                            {{-- imo No --}}
                            @if($vessel_data->imo_no)
                                <div class="col">
                                    <h4 class="font-weight-bold">IMO NO </h4>
                                    <h6>{{ $vessel_data->imo_no }}</h6>
                                </div>
                            @endif
                            {{-- year built --}}
                            @if($vessel_data->year_built)
                                <div class="col">
                                    <h4 class="font-weight-bold">Year Built</h4>
                                    <h6>{{ $vessel_data->year_built }}</h6>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
                
                @if($vessel_data->owner || $vessel_data->port_of_registry)
                    <div class="my-4">
                        <div class="row">
                            {{-- Owner --}}
                            @if($vessel_data->owner)
                                <div class="col">
                                    <h4 class="font-weight-bold">Owner </h4>
                                    <h6>{{$vessel_data->owner}}</h6>
                                </div>
                            @endif
                            {{-- port of registry --}}
                            @if($vessel_data->port_of_registry)
                                <div class="col">
                                    <h4 class="font-weight-bold"> Port Of Registry</h4>
                                    <h6> {{ $vessel_data->port_of_registry }} </h6>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- hull no and grt --}}
                @if($vessel_data->hull_no || $vessel_data->grt)
                    <div class="my-4">
                        <div class="row">
                            {{-- hull no --}}
                            @if($vessel_data->hull_no)
                                <div class="col">
                                    <h4 class="font-weight-bold">Hull No </h4>
                                    <h6>{{$vessel_data->hull_no}}</h6>
                                </div>
                            @endif
                            {{-- grt --}}
                            @if($vessel_data->grt)
                                <div class="col">
                                    <h4 class="font-weight-bold">GRT</h4>
                                    <h6>{{$vessel_data->grt}}</h6>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- call sign and flag --}}
                @if($vessel_data->call_sign || $vessel_data->flag)
                    <div class="my-4">
                        <div class="row">
                            {{-- call sign --}}
                            @if($vessel_data->call_sign)
                                <div class="col">
                                    <h4 class="font-weight-bold">Call Sign</h4>
                                    <h6>{{$vessel_data->call_sign}}</h6>
                                </div>
                            @endif
                            {{-- flag --}}
                            @if($vessel_data->flag)
                                <div class="col">
                                    <h4 class="font-weight-bold"> Flag</h4>
                                    <h6>{{ $vessel_data->flag }}</h6>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- nrt and length --}}
                @if($vessel_data->nrt || $vessel_data->length)
                <div class="my-4">
                    <div class="row">
                        {{-- nrt --}}
                        @if($vessel_data->nrt)
                            <div class="col">
                                <h4 class="font-weight-bold">NRT</h4>
                                <h6>{{ $vessel_data->nrt }}</h6>
                            </div>
                        @endif
                        {{-- length --}}
                        @if($vessel_data->length)
                            <div class="col">
                                <h4 class="font-weight-bold">Length</h4>
                                <h6>{{ $vessel_data->length }}</h6>
                            </div>
                        @endif
                    </div>
                </div>
                @endif

                

                {{-- breadth and moduled-depth --}}
                @if($vessel_data->nrt || $vessel_data->length)
                    <div class="my-4">
                        <div class="row">
                            {{-- breadth --}}
                            @if($vessel_data->breadth)
                                <div class="col">
                                    <h4 class="font-weight-bold"> Breadth</h4>
                                    <h6>{{ $vessel_data->breadth }}</h6>
                                </div>
                            @endif
                            {{-- moduled depth --}}
                            @if($vessel_data->moulded_depth)
                                <div class="col">
                                    <h4 class="font-weight-bold">Moduled Depth</h4>
                                    <h6> {{ $vessel_data->moulded_depth }} </h6>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

            </div>

            {{-- Edit/Update Button
                ================================ --}}
            <div class="my-3 mx-5">
                <!-- Button trigger Delete modal -->
                <button type="button" class="btn btn-danger w-25 py-1 shadow" data-toggle="modal" data-target="#deletemodal">
                    Delete <i class="far fa-trash-alt"></i>
                </button>
                <!--  delete Modal -->
                <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">

                        <div class="modal-body">
                            {{-- close top --}}
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h1 class="text-center my-3 text-danger"><i class="far fa-trash-alt"></i></h1>
                            <h3 class="text-center">Are You Sure ?</h3>
                            <div class="my-2 text-center    ">
                                <a href="{{ url('/vessel_details/destroy/'.$vessel_data->id) }}"  class="btn shadow btn-danger py-1 mx-3">Delete </a>
                                <button style="border: 1px solid black" type="button" class="btn btn-light py-1 mx-3 shadow" data-dismiss="modal" aria-label="Close"> Cancel </button>
                            </div>

                        </div>

                    </div>
                    </div>
                </div>




                <a href="{{ url('/vessel_details/edit/'.$data->id) }}" class="btn btn-info w-25 py-1  shadow float-right">Update <i class="fas fa-user-edit pl-3"></i></a>
            </div>

        @else
            <a href="{{ url('/vessel_details/create') }}" class="btn shadow btn-primary px-5 py-1 ml-auto mr-auto my-5">Add Vessel Details <i class="fas ml-2 fa-user-plus pl-3"></i></a>
        @endif


    </div>
</div>
@endsection


@section('footer_scripts')



@endsection
