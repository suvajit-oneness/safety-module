@extends('layouts.app')

@section('template_title')
    Crew List
@endsection

@section('template_linked_css')
  <link rel="stylesheet" href="/css/dataTables/dataTables.bootstrap.min.css">
@endsection

@section('content')
<div class="container">
    <div class="card p-3 shadow mx-5 ">
        <h2 class="font-weight-light text-center my-3">Crew List</h2>

        {{-- add btton --}}
        <a href="{{ url('crew_list/create') }}" class="btn btn-primary py-1 shadow ml-auto my-3"> Add New Crew <i class="fas ml-2 fa-user-plus"></i></a>
        {{-- view table --}}
        @if (count($data) > 0)
            <table class="table">
                <thead class="thead-light">
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Rank</th>
                    <th scope="col">Nationality</th>
                    <th scope="col">Sex</th>
                    <th scope="col">Date of Birth</th>
                    <th scope="col">Place Of Birth</th>
                    <th scope="col">Seaman Passport</th>
                    <th scope="col">Seaman Book</th>
                    <th scope="col">Date And Port Of Embarkation</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>

                    @foreach ($data as $d )
                        <tr>
                        <th scope="row">1</th>
                        <td>{{$d->name}}</td>
                        <td>{{$d->rank}}</td>
                        <td>{{(!empty($d->nationality))?$d->nationality:'N/A'}}</td>
                        <td>{{(!empty($d->sex))?$d->sex:'N/A'}}</td>
                        <td>{{(!empty($d->dob))?$d->dob:'N/A'}}</td>
                        <td>{{(!empty($d->pob))?$d->pob:'N/A'}}</td>
                        <td> <h6 class="font-weight-bold">PP No</h6> <p>{{(!empty($d->seaman_passpoert_pp_no))?$d->seaman_passpoert_pp_no:'N/A'}}</p> <h6 class="font-weight-bold">EXPIRY</h6> <p>{{(!empty($d->seaman_passpoert_exp))?$d->seaman_passpoert_exp:'N/A'}}</p> </td>
                        <td>  <h6 class="font-weight-bold">CDC No</h6> <p>{{(!empty($d->seaman_book_cdc_no))?$d->seaman_book_cdc_no:'N/A'}}</p> <h6 class="font-weight-bold">EXPIRY</h6> <p>{{(!empty($d->seaman_book_exp))?$d->seaman_book_exp:'N/A'}}</p> </td>
                        <td>  <h6 class="font-weight-bold">Date</h6> <p>{{(!empty($d->date_and_port_of_embarkation_date))?$d->date_and_port_of_embarkation_date:'N/A'}}</p> <h6 class="font-weight-bold">Port</h6> <p>{{(!empty($d->date_and_port_of_embarkation_port))?$d->date_and_port_of_embarkation_port:'N/A'}}</p> </td>
                        <td>
                            <a href="{{ url('crew_list/edit/'.$d->id) }}" class="btn btn-info shadow p-2 w-100">Edit <i class="fas fa-user-edit"></i> </a>
                            <!-- Button trigger Delete modal -->
                            <button type="button" class="btn w-100 shadow btn-danger p-2 my-2" data-toggle="modal" data-target="#deletemodal">
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
                                            <a href="{{ url('crew_list/delete/'.$d->id) }}"  class="btn shadow btn-danger py-1 mx-3">Delete </a>
                                            <button style="border: 1px solid black" type="button" class="btn btn-light py-1 mx-3 shadow" data-dismiss="modal" aria-label="Close"> Cancel </button>
                                        </div>

                                    </div>

                                </div>
                                </div>
                            </div>

                        </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        @else
            <div class="my-5">
                <h1 class="text-center text-danger mt-5"><i class="fas fa-exclamation-triangle"></i></h1>
                <h3 class="text-center text-danger mb-5">No Data Found !</h3>
            </div>
        @endif


    </div>
</div>
@endsection


@section('footer_scripts')

@endsection
