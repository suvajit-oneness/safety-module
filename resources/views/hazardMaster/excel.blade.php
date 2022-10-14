@extends('layouts.app')
@section('template_linked_css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    
  <link href="/css/summernote/summernote.css" rel="stylesheet"> 
  
@endsection
@section('content')
 <div class="container-fluid">
  <div class="card ">
    <div class="card-body">
      <div class="row">
        <div class="col">
          <form method="post" action="/excel" class="form" enctype="multipart/form-data">
            @csrf
            <div class="row" >
                <div class="col-md-6 ml-5" >
                        <label for="upload">Upload</label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mt-2 ml-5">
                    <input required type="file" name = "file" />
                </div>
            </div>
            <div class="float-right mr-5">
                    
                <button type = "submit" class = "btn btn-primary" >Submit</button>
                        
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div> 
@endsection

