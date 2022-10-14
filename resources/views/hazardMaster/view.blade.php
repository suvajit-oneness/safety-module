@extends('layouts.app')

@section('template_title')
    Hazard Master
@endsection

@section('template_linked_css')
  <!-- <link rel="stylesheet" href="/css/dataTables/dataTables.bootstrap.min.css"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  
  @endsection

@section('content')
@php
  $stringLimit = config('constants.TABLE_STRING_SIZE');
@endphp
<style>
    .wrapper2{width: 100%; border: none 0px RED;
        overflow-x: scroll; overflow-y:scroll;}
    .wrapper1{width: 100%; border: none 0px RED;
        overflow-x: scroll;}

     .wrapper1{height: 20px; }
     .wrapper2{height: 80vh; }
     .div1 {width:100%; height: 20px; }
     .div2 {width:100%; height: 400px;
      overflow: auto;}
      tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
        display: table-header-group;
    }
</style> 
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
        <h1 align="center">Ship Hazard Database</h1>
          <div class="row">
            <div class="col-lg-4 m-3" style = "display:none">
              <a href="excel"><button class = "btn btn-primary">ImportExcel</button></a>
            </div>
          </div>
            @if(Auth::user()->isAdmin())
                <div class="row mb-3 ml-2">
                    <div class="col-md-12">
                        <a href="hazard-master-create">
                        <button class="btn btn-danger"><span><i class="fa fa-plus-circle"></i></span> Add New Hazard</button>
                        </a>
                    </div>
                    <div class="col-md-12 mt-3">                     
                      <button class="btn btn-primary" id="btnExport"><span><i class="fa fa-file-text-o"></i></span> Export To Excel</button>                    
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-lg-12 table-responsive" style="height: 71vh;">
                    <table class="table table-bordered" id="hazard_master_table">
                      
                        <thead>
                            <tr>
                              <th>Hazard No</th>
                              <th>Hazard Name</th>
                              <th>Vessel Name</th>
                              <th>Area/Source</th>
                              <th>Life Cycle</th>
                              <th>Hazard Details</th>
                              <th>Causes</th>
                              <th>Impact</th>
                              <th>Applicable Permits</th>
                              <th>Review Comments</th>
                              <th>Situation</th>
                              <th colspan="3" scope="colgroup" style="text-align:">Initial Risk</th>
                              <th>Control Measure</th>
                              <th colspan="3" scope="colgroup">Residual</th> 
                              @if(Auth::user()->isAdmin())
                                  <th>Action</th>
                              @endif
                            </tr>
                            <tr>
                                <th colspan="11"></th>
                                <th>Severity</th>
                                <th>Likelihood</th>                               
                                <th>Risk Rating</th>
                                <th colspan="1"></th>
                                <th>Severity</th>
                                <th>Likelihood</th>                               
                                <th>Risk Rating</th>
                                @if(Auth::user()->isAdmin())
                                    <th colspan="3"></th>
                                @else
                                    <th colspan="2"></th>
                                @endif
                            </tr>                           
                        </thead>                        
                        <tbody>
                          @foreach($hazardMasters as $data)
                            <tr>
                              <td>
                                {{$data->hazard_no}}                                
                              </td>
                              <td>
                                {{$data->name}}
                              </td>   
                              <td class="showMore" data-field="vessel_name" data-id="{{$data->id}}">
                                @if($data->vessel_name)
                                {!!substr($data->vessel_name,0,$stringLimit)!!}
                                <br><a  style="color:blue;cursor: pointer;" onclick="toggleExpansion(this)">Show More</a>
                                @else
                                  N.A.
                                @endif
                              </td>         
                              <td class="showMore" data-field="source" data-id="{{$data->id}}">
                                {!!substr($data->source,0,$stringLimit)!!}
                                <br><a  style="color:blue;cursor: pointer;" onclick="toggleExpansion(this)">Show More</a>
                              </td>
                              <td class="showMore" data-field="life_cycle" data-id="{{$data->id}}">
                                {!! substr($data->life_cycle,0, $stringLimit) !!}
                                <br><a  style="color:blue;cursor: pointer;" onclick="toggleExpansion(this)">Show More</a>
                              </td>
                              <td class="showMore" data-field="hazard_details" data-id="{{$data->id}}">
                                {!! substr($data->hazard_details,0, $stringLimit) !!}
                                <br><a  style="color:blue;cursor: pointer;" onclick="toggleExpansion(this)">Show More</a>
                              </td>
                              <td class="showMore" data-field="causes" data-id="{{$data->id}}">
                                {!! Str::limit($data->causes, $stringLimit) !!}
                                <br><a  style="color:blue;cursor: pointer;" onclick="toggleExpansion(this)">Show More</a>
                              </td>
                              <td class="showMore" data-field="impact" data-id="{{$data->id}}">
                                {!! substr($data->impact,0, $stringLimit) !!}
                                <br><a  style="color:blue;cursor: pointer;" onclick="toggleExpansion(this)">Show More</a>
                              </td>
                              <td class="showMore" data-field="applicable_permits" data-id="{{$data->id}}">
                                {!! substr($data->applicable_permits,0, $stringLimit) !!}
                                <br><a  style="color:blue;cursor: pointer;" onclick="toggleExpansion(this)">Show More</a>
                              </td>
                              <td class="showMore" data-field="review" data-id="{{$data->id}}">
                                @if($data->review)
                                {!! substr($data->review,0, $stringLimit) !!}
                                <br><a  style="color:blue;cursor: pointer;" onclick="toggleExpansion(this)">Show More</a>
                                @else
                                  N.A.
                                @endif
                              </td>
                              <td class="showMore" data-field="situation" data-id="{{$data->id}}">
                                {!!substr($data->situation,0,$stringLimit)!!}
                                <br><a  style="color:blue;cursor: pointer;" onclick="toggleExpansion(this)">Show More</a>
                              </td>
                              <td >{{$data->ir_severity}}</td>                      
                              <td >{{$data->ir_likelihood}}</td>
                              <td style="background-color: {{$riskMatrices[$data->ir_risk_rating]}}">{{$data->ir_risk_rating}}</td> 

                              <td class="showMore" data-field="control" data-id="{{$data->id}}">
                                {!! substr($data->control,0, $stringLimit) !!}
                                <br><a  style="color:blue;cursor: pointer;" onclick="toggleExpansion(this)">Show More</a>
                              </td>
                              <td >{{$data->rr_severity}}</td>                      
                              <td >{{$data->rr_likelihood}}</td>
                              <td style="background-color: {{$riskMatrices[$data->ir_risk_rating]}}">{{$data->rr_risk_rating}}</td> 
                             {{-- <td>
                                @if($data->reduction_measure)
                                  {{$data->reduction_measure}}
                                @else
                                  {{config('constants.DATA_NOT_AVAILABLE')}}
                                @endif
                              </td>
                              <td>
                                @if($data->remarks)
                                  {{$data->remarks}}
                                @else
                                  {{config('constants.DATA_NOT_AVAILABLE')}}
                                @endif
                              </td> --}}
                              @if(Auth::user()->isAdmin())
                              <td>
                                <a href="hazard-master-delete/{{$data->id}}" onclick="return confirm('Are you sure?')"class="btn btn-danger">
                                  <i class="fa fa-trash"></i>
                                </a>
                                {{-- <a href="hazard-master-edit/{{$data->id}}" class="btn btn-primary">
                                  <i class="fa fa-edit"></i>
                                </a> --}}
                              </td>
                              @endif
                            </tr>
                        @endforeach
                        </tbody> 
                        <tfoot>
                        <tr>
                              <th>Hazard No</th>
                              <th>Hazard Name</th>
                              <th>Vessel Name</th>
                              <th>Area/Source</th>
                              <th>Life Cycle</th>
                              <th>Hazard Details</th>
                              <th>Causes</th>
                              <th>Impact</th>
                              <th>Applicable Permits</th>
                              <th>Review Comments</th>
                              <th>Situation</th>
                              <th colspan="3" scope="colgroup" style="text-align:">Initial Risk</th>
                              <th>Control Measure</th>
                              <th colspan="3" scope="colgroup">Residual</th> 
                              @if(Auth::user()->isAdmin())
                                  <th>Action</th>
                              @endif
                            </tr>
                            
                      </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer_scripts') 
    <script>
      var hazardMasters={!! json_encode($hazardMasters) !!};
      var stringLimit={!! json_encode($stringLimit) !!};
    </script>
    <script type="text/javascript" src="/js/custom/HazardMaster/index.js"></script>   
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>   
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/js/custom/RiskAssessment/table2excel.js"></script>
    <script type="text/javascript">
    $(function () {
      $("#btnExport").click(function () {
        // $("#hazard_master_table").table2excel({
        //   exclude: ".noExport",
        //   filename: "Table.xls"
        // });
        $('#hazard_master_table .showMore a').remove();
        $("#hazard_master_table").table2excel({
          exclude: ".noExport",
          filename: "HazardTable.xls"
        });
        // var len = $('#hazard_master_table .showMore').length;
        // for(var i=0; i < len; i++){
        //   // console.log($('#hazard_master_table .showMore')[i]);
        //   var a_tag = document.createElement("a");
        //   a_tag.innerHTML = "Show More";
        //   a_tag.style.color = "blue";
        //   a_tag.addEventListener("click", toggleExpansion(this));
        //   $('#hazard_master_table .showMore')[i].append(a_tag);
        // }
      });
    });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
              
                $(".wrapper1").scroll(function(){
                     console.log("test1");
                    $(".wrapper2")
                        .scrollLeft($(".wrapper1").scrollLeft());
                });
                
                $(".wrapper2").scroll(function(){
                    console.log("test2");
                    $(".wrapper1")
                        .scrollLeft($(".wrapper2").scrollLeft());
                });
                // var table = $('#hazard_master_table').DataTable();
 
    
        
        });
    </script>
    <script>
      $(() => {
        $('#hazard_master_table_filter').hide();
      })
    </script>
@endsection
