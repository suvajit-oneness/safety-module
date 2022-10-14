@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="card" style="width:40vw; height:40vh;position: absolute; top:50%; left:50%; transform:translate(-50%,-50%)">
            <div class="card-title">
                <div class="card-header">
                    <b>Upload The Excel File</b>
                </div>
            </div>
            <div class="crad-body">
                @if(session('status'))
                    <div class="alert alert-success" role='alert'>
                        {{session('status')}}
                    </div>
                @endif
                @if(session()->has('failures'))
                            <table class = "table table-danger">
                                <tr>
                                    <th>Row</th>
                                    <th>Attributes</th>
                                    <th>Errors</th>
                                    <th>Value</th>
                                </tr>
                                @foreach(session()->get('failures') as $validator)
                                    <tr>
                                        <td>{{$validator->row()}}</td>
                                        <td>{{$validator->attribute()}}</td>
                                        <td>
                                            <ul>
                                                @foreach($validator->errors() as $e)
                                                    <li>{{$e}}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>{{$validator->values()[$validator->attribute()]}}</td>
                                    </tr>
                                @endforeach
                            </table>
                @endif
                <!-- @if(session('msg'))
                    <div class="alert alert-danger">
                        {{session('msg')}}
                    </div>
                @endif -->
                <form action="importUser" method= "post" enctype="multipart/form-data" >
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
@endsection
