@extends('layouts.app')

@section('template_title')
    Risk Assesment View
@endsection
@section('template_linked_css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="/js/custom/toastr/toastr.min.css" rel="stylesheet">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/css/dataTables/dataTables.bootstrap.min.css">
  <link href="/css/summernote/summernote.css" rel="stylesheet">
  <link href="/css/custom/riskAssessment/riskAssessmentCreate.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('/css/common.css') }}">

@endsection
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
        <h1 align="center">Risk Assesment</h1>
                <div class="row  mr-3">
                    <div class="col-lg-2">
                        <a href=""><button class='btn btn-success' id = 'all' style="display:none;">All</button></a>
                    </div>
                    <div class="col-lg-7"></div>
                    <div class="col-lg-3">
                        <select class="form-control mr-sm-2" id="search-drop" name="search-drop">
                            <option hidden value="" selected>Select Field</option>
                            {{--<option  value="Tide">Tide</option>
                            <option  value="Visibility">Visibility</option>
                            <option  value="Port" >Port</option>
                            <option value="Weather">Weather</option>--}}
                            @foreach($drops as $drop)
                            <option value="{{$drop}}">{{$drop}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class = 'float-right m-3'>
                        <input class="btn " style="border: 1px solid green" type="search" id="search"> <button id="searchbtn" class="btn btn-success ml-2" type = 'button'> <i class="fas fa-search mr-2"></i> Search</button>
                </div>
                <div id="Templates" class="tabcontent tabShown">

                    <div class="row w-100">
                        <div class="col-lg-12 table-responsive">
                            <table class="table table-bordered" id="templates_table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Id</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Name</th>
                                        {{-- <th class="text-center">Dept_name</th> --}}
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datas as $data)
                                        <tr>

                                            <td class="text-center"><button class = 'btn btn-success'>{{$data->riskAssesment_id}}</button></td>
                                            <td class="text-center">{{$data->status}}</td>
                                            <td class="text-center">{{$data->NnameE}}</td>
                                            {{--<td class="text-center">{{$data->dname}}</td>--}}
                                            <td class="text-center">
                                            <a class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this item?');" href="/riskAssesmentDelete/{{$data->riskAssesment_id}}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                                <a class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"
                                                href="/riskAssesmentEdit/{{$data->riskAssesment_id}}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a class="btn edit" data-toggle="tooltip" data-placement="top" title="PDF"
                                                href="/riskAssesmentPdf/{{$data->riskAssesment_id}}">
                                                    <i class="fa fa-file-pdf"></i>
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
@section('footer_scripts')
    <script>
        $(document).ready(function(){
            $('#searchbtn').click(function(){
                console.log($('#search-drop').val());
                console.log($('#search').val());
                var dropdown = $('#search-drop').val();
                var search =  $('#search').val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"/api/riskAssesmentSearch",
                    method: "POST",
                    dataType: "json",
                    data: { 'data1' : dropdown, 'data2' : search},
                    success: function(response){ // What to do if we succeed
                        //console.log('hello');
                        if(response){
                            console.log(response);

                            var tableData ='<thead>';
                            tableData+='<tr>';
                            tableData+='<th class="text-center">Id</th>';
                            tableData+='<th class="text-center">Status</th>';
                            tableData+='<th class="text-center">Name</th>';
                            // tableData+='<th class="text-center">Dept_name</th>';
                            tableData+='<th class="text-center">Action</th>';
                            tableData+='</tr>';
                            tableData+='</thead>';
                            // tableData+='<tbody>';
                            for(var i=0;i<response.length;i++)
                            {
                                tableData+="<tr class='text-center'>";
                                tableData+="<td class='text-center'><button class = 'btn btn-success'>"+response[i].riskAssesment_id+"</button></td>";
                                tableData+="<td class='text-center'>Not Approved</td>";
                                tableData+="<td class='text-center'>"+response[i].name+"</td>";
                                // tableData+="<td class='text-center'>2</td>";
                                tableData+='<td class="text-center">';
                                tableData+='<a class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"';
                                tableData+='href="/riskAssesmentDelete/'+response[i].riskAssesment_id+'">';
                                tableData+='<i class="fa fa-trash"></i></a>';
                                tableData+='<a class="btn btn-primary ml-1" data-toggle="tooltip" data-placement="top" title="Edit"';
                                tableData+='href="/riskAssesmentEdit/'+response[i].riskAssesment_id+'">';
                                tableData+='<i class="fa fa-edit"></i></a></td>';
                                tableData+="</tr>";
                            }
                            tableData+='</tbody>';
                            // tableData+='</table>';
                            console.log(tableData);
                            $('#templates_table').html(tableData);
                        }
                        else{
                            console.log('error');
                        }
                    },
                    error: function(response){
                        console.log('error : ',response);
                    }
                });
                $('#all').css("display","block");
            });
        });
    </script>
@endsection
