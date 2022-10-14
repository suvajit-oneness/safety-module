@extends('layouts.app')

@section('template_title')
    Company
@endsection

@section('content')
            <div class="container">
                <div class="card shadow p-3 py-5" style="width:60vw;position: absolute; top:50%; left:50%; transform:translate(-50%,-50%)">
                    <h2 class="my-3 font-weight-light text-center">Add Company Details</h2>
                    <div class="mx-md-5 " style="">
                        <form class="p-md-3 mx-md-5" method="POST" action="{{ url('company/update/'.$company[0]->id) }}" id="company_form"  enctype="multipart/form-data">
                            @csrf
                            <div class=" form-group">
                                <label for="Name">Name</label>
                                <input type="text"   class="form-control" id="Name" name="Name" value="{{$company[0]->name}}" placeholder="Name..." autocomplete="off">
                                <label for="Name">Logo</label>
                                <input type="file"   class="form-control" id="Logo" name="Logo" placeholder="Logo..." autocomplete="off">
                                <label for="Name">Location</label>
                                <input type="text"   class="form-control" id="Location" name="Location" value="{{$company[0]->location}}" placeholder="Location..." autocomplete="off">
                                <label for="Name">Address</label>
                                <input type="text"   class="form-control" id="Adress" name="Adress" value="{{$company[0]->address}}" placeholder="Adress..." autocomplete="off">
                                <label for="Name">Phone number</label>
                                <input type="text"   class="form-control" id="Phonenumber" name="Phonenumber" value="{{$company[0]->phone_number}}" placeholder="Phone number..." autocomplete="off">
                            </div>
                            <div class="mr-auto ml-auto" style="overflow:auto;">
                                <div class="d-flex">
                                    <button class="btn btn-primary mt-3 ml-auto" type="submit" id="nextBtn" >Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                   
                </div>
            </div>
@endsection